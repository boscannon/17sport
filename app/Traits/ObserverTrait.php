<?php

namespace App\Traits;
use Schema;

use Illuminate\Database\Eloquent\Model;
use \Altek\Eventually\Eventually;

use App\Models\Audit;

trait ObserverTrait
{
    use \Altek\Eventually\Eventually;

    protected static function booted()
    {
        static::created(function ($model) {
            $event = __('create');
            $auditing = [];

            $old_values = [];
            $new_values = [];
            foreach(static::$audit['only'] as $value){
                if($model->{$value} != ''){
                    $new_values[$value] = $model->{$value};
                    $auditing[] = __('backend.audits.created', [
                        'name' => __('backend.'.$model->getTable().'.'.$value),
                        'new' => static::translation($model, $value),
                    ]);
                } 
            }

            static::createAudit($model, $event, $auditing, $old_values, $new_values);
        });

        static::updated(function ($model) {
            $event = __('edit');
            $auditing = [];

            $old_values = [];
            $new_values = [];
            foreach(static::$audit['only'] as $value){
                if($model->getRawOriginal($value) !== $model->{$value}){
                    $old_values[$value] = $model->getRawOriginal($value);
                    $new_values[$value] = $model->{$value};
                    $auditing[] = __('backend.audits.updated', [
                        'name' => __('backend.'.$model->getTable().'.'.$value),
                        'new' => static::translation($model, $value),
                    ]);
                }
            }

            static::createAudit($model, $event, $auditing, $old_values, $new_values);
        });
        
        static::deleted(function ($model) {
            $event = __('delete');
            $auditing = [];

            $old_values = [];
            $new_values = [];
            foreach(static::$audit['only'] as $value){
                if($model->{$value} != ''){
                    $old_values[$value] = $model->{$value};
                    $auditing[] = __('backend.audits.deleted', [
                        'name' => __('backend.'.$model->getTable().'.'.$value),
                        'old' => static::translation($model, $value),
                    ]);
                }
            }

            static::createAudit($model, $event, $auditing, $old_values, $new_values);
        });       
        
        static::synced(function ($model, $relation, $properties) {
            $event = __('edit');
            $auditing = [];

            $old_values = [];
            $new_values = [];
            foreach(static::$audit['many'] as $key => $value){
                $new = [];
                foreach($model->{$key} as $many_value){
                    $new_values[$value][] = $many_value->{$value};
                    if($relation === 'permissions'){ //權限
                        list($action, $menu) = explode(" ", $many_value->{$value});
                        $new[] = __("backend.menu.$menu").' '.__($action);
                    }else{
                        $new[] = $many_value->{$value};
                    }
                }   
                $auditing[] = __('backend.audits.updated', [
                    'name' => __('backend.'.$model->getTable().'.'.$key),
                    'new' => implode(",", $new),
                ]);  
            }

            static::createAudit($model, $event, $auditing, $old_values, $new_values);
        });
    }

    public static function translation ($model, $value){
        if(isset(static::$audit['translation'][$value]) && $translation = static::$audit['translation'][$value]){
            return $model->{$translation['relation']}->{$translation['name']};
        }else{
            return $model->{$value};
        }
    }

    public static function createAudit ($model, $event, $auditing, $old_values = [], $new_values = []) {
        $data = [
            'user_id' => auth()->user()->id ?? null,
            'event' => $event,
            'table' => $model->getTable(),
            'table_id' => $model->id,
            'old_values' => $old_values,
            'new_values' => $new_values,
            'auditing' => $auditing,
            'url' => request()->url(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ];

        if(count($auditing) > 0) {
            Audit::create($data);
        }
    }
}
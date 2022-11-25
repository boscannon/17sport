@extends('errors.layouts.main', ['message' => 'We are sorry but your request contains bad syntax and cannot be fulfilled..'])
@section('content')
    <div class="display-3 text-flat">
        <i class="fa fa-times-circle-o"></i> 500
    </div>
@stop
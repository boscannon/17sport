<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audit as crudModel;
use DataTables;
use Exception;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CrudModel::with(['user'])->where([
                'table' => $request->table,
                'table_id' => $request->table_id,
            ]);
            return Datatables::eloquent($data)
                ->make(true);
        }
    }
}

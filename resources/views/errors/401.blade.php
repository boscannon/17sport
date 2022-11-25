@extends('errors.layouts.main', ['message' => 'We are sorry but you are not authorized to access this page..'])
@section('content')
    <div class="display-3 text-info">
        <i class="fa fa-lock"></i> 401
    </div>
@stop
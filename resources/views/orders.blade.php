@extends('layouts.app')
@section('content')
<link href="{{asset('DataTables/datatables.min.css')}}" rel="stylesheet">
<script src="{{asset('DataTables/datatables.min.js')}}"></script>
<script src="{{asset('js/orders.js')}}"></script>
<h2>Listado de Órdenes</h2>
<table class="table table-bordered" id="table-orders" style="max-width:100%!important">
    <thead>
        <tr>
            <th>#</th>
            <th>Estatus</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Peso</th>
            <th>Tamaño</th>
            <th>Productos</th>
            <th style="word-break:break-word;max-width:200px">Dirección</th>
            <th></th>
        </tr>
    </thead>
</table>
@endsection

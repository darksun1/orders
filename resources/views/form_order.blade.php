@extends('layouts.app')
@section('content')
<script src="{{asset('js/new-order.js')}}"></script>
<script src="{{asset('js/jquery_validator/jquery.validate.js')}}"></script>
<script src="{{asset('js/jquery_validator/messages_es.js')}}"></script>
<form id="form_order" class="forms-sample" method="POST" novalidate="novalidate">
    @csrf
    <div id="products_section" class="row">
        <fieldset id="field_prod">
            <legend>Productos</legend>
            <table id="prod-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Peso</th>
                        <th>Cantidad</th>
                        <th>$</th>
                        <th>Kg</th>
                    </tr>
                </thead>
                @php $i=0; @endphp
                @foreach($products as $prod)
                    <tr>
                        <td><input class="cbprods" type="checkbox" name="cbprod_{{$i}}" id="cbprod_{{$i}}" onchange="slctProd({{$i}},{{$prod->id}},{{$prod->price}},{{$prod->weight}})" value="{{$prod->id}}"></td>
                        <td>{{$prod->code}}</td>
                        <td>{{$prod->name}}</td>
                        <td>$ {{$prod->price}}</td>
                        <td>{{$prod->weight}} kg</td>
                        <td><input type="text" class="quantity" name="qty_{{$i}}" id="qty_{{$i}}" onblur="qtyProd({{$i}},{{$prod->price}},{{$prod->weight}},this.value)" readonly></td>
                        <td><input type="text" name="total_{{$i}}" id="total_{{$i}}" readonly></td>
                        <td><input type="text" name="total_w_{{$i}}" id="total_w_{{$i}}" readonly></td>
                    </tr>
                    @php $i++; @endphp
                @endforeach
            </table>
        </fieldset>
    </div>
    <div class="row">
        <input type="hidden" id="cont_i" name="cont_i" value="{{$i}}">
        <div class="form-group col-md-3">
            <label for="total">{{ __('Total $') }}</label>
            <input type="text" class="form-control" name="total" id="total" required readonly>
        </div>
        <div class="form-group col-md-3">
            <label for="total_w">{{ __('Peso Total (Kg)') }}</label>
            <input type="text" class="form-control" name="total_w" id="total_w" required readonly>
        </div>
        <div class="form-group col-md-3">
            <label for="size">{{ __('Tamaño de Paquete') }}</label>
            <input type="text" class="form-control" name="size" id="size" required readonly>
        </div>
    </div>
    <h4>Dirección</h4>
    <div class="row">
        <div class="form-group col-md-5">
            <label for="street">{{ __('Calle') }}</label>
            <input type="text" class="form-control" name="street" id="street" required>
        </div>
        <div class="form-group col-md-3">
            <label for="ext">{{ __('Núm. Ext') }}</label>
            <input type="text" class="form-control" name="ext" id="ext" required>
        </div>
        <div class="form-group col-md-3">
            <label for="int">{{ __('Núm. Int') }}</label>
            <input type="text" class="form-control" name="int" id="int">
        </div>
        <div class="form-group col-md-3">
            <label for="zip_code">{{ __('Código Postal') }}</label>
            <input type="text" class="form-control" name="zip_code" id="zip_code" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-5">
            <label for="city">{{ __('Ciudad') }}</label>
            <input type="text" class="form-control" name="city" id="city" readonly>
        </div>
        <div class="form-group col-md-5">
            <label for="state">{{ __('Estado') }}</label>
            <input type="text" class="form-control" name="state" id="state" readonly>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label for="origin">{{ __('Coordenadas de Origen') }}</label>
            <input type="text" class="form-control validateCoor" name="origin" id="origin" required>
        </div>
        <div class="form-group col-md-4">
            <label for="destiny">{{ __('Coordenadas de Destino') }}</label>
            <input type="text" class="form-control validateCoor" name="destiny" id="destiny" required>
        </div>
    </div>
    <div class="row">
        <div class="text-center" style="margin-top:20px">
            <button type="sumbit" class="btn btn-lg btn-success">{{ __('Guardar') }}</button>
        </div>
    </div>
</form>
@endsection
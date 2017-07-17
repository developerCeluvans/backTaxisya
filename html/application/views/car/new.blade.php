@layout('layouts.default')

@section('content')
<h1> Agregar nuevo carro</h1>
{{render('common.car_errors')}}

{{Form::open('car/create','POST')}}
<p>
    {{Form::label('placa','Placa:')}}<br/>
    {{Form::text('placa',Input::old('placa'))}}
</p>
<p>
    {{Form::label('car_brand','Marca:')}}<br/>
    {{Form::text('car_brand',Input::old('car_brand'))}}
</p>
<p>
    {{Form::submit('Add Car')}}
</p>
{{Form::close()}}
@endsection

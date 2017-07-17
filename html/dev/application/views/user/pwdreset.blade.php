@layout('layouts.default')

@section('content')
@if(!isset($result))
<h1>Restablecer contraseña</h1>
{{Form::open('user/pwd/confirm','POST')}}
{{Form::token()}}
<p>
    {{Form::label('email','e-mail:')}}<br/>
    {{Form::text('email',$item->email,array('readonly'))}}
</p>
<p>
    {{Form::label('pwd','contraseña:')}}<br/>
    {{Form::password('pwd')}}
</p>
<p>
    {{Form::hidden('id',$item->id)}}
</p>
<!--
'name' => input::get('name'),
'lastname' => input::get('lastname'),
'login' => input::get('login'),
'pwd' => input::get('pwd')
-->
<p>
    {{Form::submit('Guardar')}}
</p>
{{Form::close()}}
@else
<h1>{{$result}}</h1>
@endif
@endsection
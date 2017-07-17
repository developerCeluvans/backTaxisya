@layout('layouts.default')

@section('content')
<h1> Agregar nuevo usuario</h1>
{{render('common.user_errors')}}

{{Form::open('user/create','POST')}}
{{Form::token()}}
<p>
    {{Form::label('name','Name:')}}<br/>
    {{Form::text('name',Input::old('name'))}}
</p>
<p>
    {{Form::label('lastname','LastName:')}}<br/>
    {{Form::text('lastname',Input::old('lastname'))}}
</p>
<p>
    {{Form::label('email','e-mail:')}}<br/>
    {{Form::text('email',Input::old('email'))}}
</p>
<p>
    {{Form::label('login','Usuario:')}}<br/>
    {{Form::text('login',Input::old('login'))}}
</p>
<p>
    {{Form::label('pwd','Contraseña:')}}<br/>
    {{Form::password('pwd')}}
</p>
<p>
    {{Form::label('uuid','uuid:')}}<br/>
    {{Form::text('uuid',Input::old('uuid'))}}
</p>
<!--
'name' => input::get('name'),
            'lastname' => input::get('lastname'),
            'login' => input::get('login'),
            'pwd' => input::get('pwd')
-->
<p>
    {{Form::submit('Add User')}}
</p>
{{Form::close()}}
@endsection

@layout('layouts.default')

@section('content')
<h1>Login</h1>
{{Form::open('user/login','POST')}}
<p>
    {{Form::label('login','Username:')}}<br />
    {{Form::text('login',Input::old('login'))}}
</p>
<p>
    {{Form::label('pwd','Password:')}}<br/>
    {{Form::text('pwd')}}
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
    {{Form::submit('Enter')}}
</p>
{{Form::close()}}
@endsection
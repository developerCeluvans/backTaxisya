@layout('layouts.default')

@section('content')
<h1>Editing {{$user->name}}{{$user->lastname}}</h1>
{{render('common.user_errors')}}
{{Form::open('user/update','PUT')}}
<p>
    {{Form::label('name','Name:')}}<br />
    {{Form::text('name',$user->name)}}
</p>
<p>
    {{Form::label('lastname','LastName:')}}<br/>
    {{Form::text('lastname',$user->lastname)}}
</p>
<p>
    {{Form::label('email','e-mail:')}}<br/>
    {{Form::text('email',$user->email)}}
</p>
<p>
    {{Form::label('login','Usuario:')}}<br/>
    {{Form::text('login',$user->login)}}
</p>
<p>
    {{Form::label('cellphone','Celular:')}}<br/>
    {{Form::text('cellphone',$user->cellphone)}}
</p>
<p>
    {{Form::hidden('id',$user->id)}}
</p>
<!--
'name' => input::get('name'),
            'lastname' => input::get('lastname'),
            'login' => input::get('login'),
            'pwd' => input::get('pwd')
-->
<p>
    {{Form::submit('Update User')}}
</p>
{{Form::close()}}
@endsection
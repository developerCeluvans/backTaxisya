@layout('layouts.default')

@section('content')
<h1>Editing {{$driver->name}}{{$driver->lastname}}</h1>
{{render('common.driver_errors')}}
{{Form::open('driver/update','PUT')}}
<p>
    {{Form::label('name','Name:')}}<br />
    {{Form::text('name',$driver->name)}}
</p>
<p>
    {{Form::label('lastname','LastName:')}}<br/>
    {{Form::text('lastname',$driver->lastname)}}
</p>
<p>
    {{Form::label('email','e-mail:')}}<br/>
    {{Form::text('email',$driver->email)}}
</p>
<p>
    {{Form::label('login','Usuario:')}}<br/>
    {{Form::text('login',$driver->login)}}
</p>
<p>
    {{Form::label('cellphone','Celular:')}}<br/>
    {{Form::text('cellphone',$driver->cellphone)}}
</p>
<p>
    {{Form::hidden('id',$driver->id)}}
</p>
<p>
    {{Form::select('car_id',$cars,$driver->car_id)}}
</p>
<!--
'name' => input::get('name'),
'lastname' => input::get('lastname'),
'login' => input::get('login'),
'pwd' => input::get('pwd')
-->
<p>
    {{Form::submit('Update driver')}}
</p>
{{Form::close()}}
@endsection
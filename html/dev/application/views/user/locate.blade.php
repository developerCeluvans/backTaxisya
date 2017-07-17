@layout('layouts.default')

@section('content')
<h1>Editing {{$user->name}}{{$user->lastname}}</h1>
{{render('common.user_errors')}}
{{Form::open('user/position','POST')}}
<p>
    {{$user->name}}<br />
</p>
<p>
    {{$user->lastname}}<br/>
</p>
<p>
    {{Form::label('lat','Latitud:')}}<br/>
    {{Form::text('lat',$user->crt_lat)}}
</p>
<p>
    {{Form::label('lng','Longitud:')}}<br/>
    {{Form::text('lng',$user->crt_lng)}}
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
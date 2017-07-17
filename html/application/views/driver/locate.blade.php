@layout('layouts.default')

@section('content')
<h1>Editing {{$driver->name}}{{$driver->lastname}}</h1>
{{render('common.driver_errors')}}
{{Form::open('driver/position','POST')}}
<p>
    {{$driver->name}}<br />
</p>
<p>
    {{$driver->lastname}}<br/>
</p>
<p>
    {{Form::label('lat','Latitud:')}}<br/>
    {{Form::text('lat',$driver->crt_lat)}}
</p>
<p>
    {{Form::label('lng','Longitud:')}}<br/>
    {{Form::text('lng',$driver->crt_lng)}}
</p>
<p>
    {{Form::hidden('id',$driver->id)}}
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
@layout('layouts.default')

@section('content')

<h1>{{$driver->name}}</h1><br />
<p>{{$driver->cellphone}}</p><br />
<p>{{$driver->lastname}}</p><br />
<p>{{$driver->updated_at}}</p><br />
<p>{{$driver->created_at}}</p><br />
<p>{{$driver->email}}</p><br />
<p>{{$driver->car->placa}}</p><br />
<p>{{Response::json($driver->to_array())}}</p><br />
@endsection
@layout('layouts.default')

@section('content')
{{render('common.car_errors')}}
<h1>{{$car->placa}}</h1><br />
<p>{{$car->id}}</p><br />
<p>{{$car->car_brand}}</p><br />
<p>{{$car->updated_at}}</p><br />
<p>{{$car->created_at}}</p><br />
<p>{{Response::json($car->to_array())}}</p><br />
@endsection
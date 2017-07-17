@layout('layouts.default')

@section('content')
<h1>{{$address->id}}</h1><br />
<p>{{$address->id}}</p><br />
<p>{{$address->index_id}}</p><br />
<p>{{$address->comp1}}</p><br />
<p>{{$address->comp2}}</p><br />
<p>{{$address->no}}</p><br />
<p>{{$address->barrio}}</p><br />
<p>{{$address->obs}}</p><br />
<p>{{$address->user_id}}</p><br />
<p>{{$address->user_pref_order}}</p><br />
<p>{{Response::eloquent($address)}}</p><br />
@endsection



@layout('layouts.default')

@section('content')
{{render('common.user_errors')}}
<h1>{{$user->name}}</h1><br />
<p>{{$user->cellphone}}</p><br />
<p>{{$user->lastname}}</p><br />
<p>{{$user->updated_at}}</p><br />
<p>{{$user->created_at}}</p><br />
<p>{{$user->email}}</p><br />
<p>{{Response::json($user->to_array())}}</p><br />
@endsection
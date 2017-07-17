@layout('layouts.default')

@section('content')
<h1> Agregar nuevo usuario</h1>

{{Form::open('address/register','POST')}}
<p>{{$user->name}}</p><br/>
<p>{{$user->lastname}}</p><br/>
<p>{{$user->login}}</p><br/>
<p>{{Form::label('index_id','indicación:')}}<br/>
   {{Form::text('index_id',Input::old('index_id'))}}
</p>
<p>
    {{Form::label('comp1','000X:')}}<br/>
    {{Form::text('comp1',Input::old('comp1'))}}
</p>
<p>
    {{Form::label('comp2','#000X:')}}<br/>
    {{Form::text('comp2',Input::old('comp2'))}}
</p>
<p>
    {{Form::label('no','-No:')}}<br/>
    {{Form::text('no',Input::old('no'))}}
</p>
<p>
    {{Form::label('barrio','barrio:')}}<br/>
    {{Form::text('barrio',Input::old('barrio'))}}
</p>
<p>
    {{Form::label('obs','Obs:')}}<br/>
    {{Form::text('obs',Input::old('obs'))}}
</p>
<!--
'index_id' => Input::get('index_id'),
'comp1' => Input::get('comp1'),
'comp2' => Input::get('comp2'),
'no' => Input::get('no'),
'barrio' => Input::get('barrio'),
'obs' => Input::get('obs'),
'user_id' => Input::get('user_id'),
'user_pref_order' => Input::get('user_pref_order')
-->
<p>
    {{Form::hidden('user_id',$user->id)}}
</p>
<p>
    {{Form::submit('Add Address')}}
</p>
{{Form::close()}}
@endsection

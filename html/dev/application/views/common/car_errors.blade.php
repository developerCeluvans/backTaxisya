@if($errors->has())
<ul>
    {{$errors->first('placa','<li>:message</li>')}}
    {{$errors->first('car_brand','<li>:message</li>')}}
</ul>
@endif
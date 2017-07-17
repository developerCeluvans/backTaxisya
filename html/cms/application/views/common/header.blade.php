<!-- Header -->
<div id="header">
    <ul id="account_info" class="pull-right"> 
        <li><img src="images/icon/user_.png" alt="Online" /></li>
        <li class="setting">
            @if(isset($test)&&$test==TRUE)
            Bienvenid@, <b class="red">John Doe</b>
            <ul class="subnav">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#" id="administrator-1-edit" onclick='dataPoster(this.id);
                        return false'>Perfil</a></li>
                <!-- 
                <li><a href="#">Setting</a></li>
                <li><a href="#">Reset password</a></li>
                -->
                <br class="clearfix"/>
            </ul>
            @else
            Bienvenid@, <b class="red">{{Auth::user()->name}}</b>
            <ul class="subnav">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#" id="administrator-{{Auth::user()->id}}-edit" onclick='dataPoster(this.id);
                        return false'>Perfil</a></li>
                <!-- 
                <li><a href="#">Setting</a></li>
                <li><a href="#">Reset password</a></li>
                -->
                <br class="clearfix"/>
            </ul>
            @endif
        </li>
        <li class="logout" title="Desconectar">Cerrar Sesión</li> 
    </ul>
</div><!-- End Header -->
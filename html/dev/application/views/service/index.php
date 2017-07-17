<h1>Servicios</h1>
<table border="1">
    <thead>
        <tr>
            <th>id</th>
            <th>id de usuario</th>
            <th>id de conductor</th>
            <th>id de vehiculo</th>
            <th>actualizado</th>
            <th>creado</th>
        </tr>
    <thead>
    <tbody>
        <?php
        foreach ($servicios as $key => $value) {
            $placa = (isset($value->driver_id)) ? $value->driver->car->placa : '';
            echo "<tr>
                    <td>{$value->id}</td>
                    <td>{$value->user_id}</td>
                    <td>{$value->driver_id}{$placa}</td>
                    <td>{$value->car_id}</td>
                    <td>{$value->updated_at}</td>
                    <td>{$value->created_at}</td>
                </tr>";
        }
        ?>
    </tbody>



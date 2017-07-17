<h1>Conductores</h1>
<table border="1">
    <thead>
        <tr>
            <th>id</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Cel</th>
            <th>@</th>
            <th>pwd</th>
            <th>UUID</th>
            <th>modificado</th>
            <th>creado</th>
        </tr>
    <thead>
    <tbody>
        <?php
        foreach ($conductores as $key => $value) {
            echo "<tr>
                    <td>{$value->id}</td>
                    <td>{$value->name}</td>
                    <td>{$value->lastname}</td>
                    <td>{$value->cellphone}</td>
                    <td>{$value->email}</td>
                    <td>{$value->pwd}</td>
                    <td>{$value->uuid}</td>
                    <td>{$value->updated_at}</td>
                    <td>{$value->created_at}</td>
                </tr>";
        }
        ?>
    </tbody>
</table>


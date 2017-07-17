<h1>Usuarios</h1>
<?php
foreach ($usuarios as $key => $value) {
    echo "{$value->name} - {$value->lastname} - {$value->cellphone} - {$value->email} - {$value->updated_at} <br/>";
}
?>


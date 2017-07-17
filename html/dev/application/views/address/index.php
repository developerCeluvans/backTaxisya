<h1>Direcciones</h1>
<?php
foreach ($direcciones as $key => $value) {
    echo "{$value->id} - {$value->index_id} - {$value->comp1} - {$value->comp2} - {$value->no} - {$value->barrio} - {$value->obs} - {$value->user_id}<br/>";
}
?>


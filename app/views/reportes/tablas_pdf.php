<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .db-header { background-color: #007bff; color: white; padding: 10px; margin-top: 20px; }
        .table-card { border: 1px solid #ddd; margin-bottom: 15px; }
        .table-header { background-color: #343a40; color: white; padding: 8px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f8f9fa; }
        .badge { background-color: #ffc107; padding: 2px 5px; border-radius: 3px; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Diccionario de Datos</h1>
        <p>Fecha de generación: <?php echo date('Y-m-d H:i:s'); ?></p>
    </div>

    <?php
    $current_db = '';
    foreach($data['tablas'] as $tabla) :
        if($current_db != $tabla->bdNombre) :
            $current_db = $tabla->bdNombre;
    ?>
        <div class="db-header">
            Base de Datos: <?php echo $current_db; ?> (<?php echo $tabla->servidorNombre; ?>)
        </div>
    <?php endif; ?>

    <div class="table-card">
        <div class="table-header">Tabla: <?php echo $tabla->nombre; ?></div>
        <table>
            <thead>
                <tr>
                    <th>Columna</th>
                    <th>Tipo</th>
                    <th>Long.</th>
                    <th>Nulo</th>
                    <th>Llave</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tabla->columnas as $columna) : ?>
                    <tr>
                        <td><strong><?php echo $columna->nombre; ?></strong></td>
                        <td><?php echo $columna->tipo_dato; ?></td>
                        <td><?php echo $columna->longitud; ?></td>
                        <td><?php echo $columna->permite_nulo ? 'Sí' : 'No'; ?></td>
                        <td><?php echo $columna->es_llave ? '<span class="badge">PK/FK</span>' : 'No'; ?></td>
                        <td><?php echo $columna->descripcion; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>
</body>
</html>

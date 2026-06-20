<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .section-header { background-color: #28a745; color: white; padding: 8px; margin-top: 20px; }
        .section-header.func { background-color: #17a2b8; }
        .section-header.disp { background-color: #ffc107; color: black; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #343a40; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Objetos Programables</h1>
        <p>Fecha de generación: <?php echo date('Y-m-d H:i:s'); ?></p>
    </div>

    <div class="section-header">Procedimientos Almacenados</div>
    <table>
        <thead>
            <tr>
                <th>Base de Datos</th>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['procedimientos'] as $proc) : ?>
                <tr>
                    <td><?php echo $proc->bdNombre; ?></td>
                    <td><?php echo $proc->nombre; ?></td>
                    <td><?php echo $proc->descripcion; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="section-header func">Funciones</div>
    <table>
        <thead>
            <tr>
                <th>Base de Datos</th>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['funciones'] as $func) : ?>
                <tr>
                    <td><?php echo $func->bdNombre; ?></td>
                    <td><?php echo $func->nombre; ?></td>
                    <td><?php echo $func->descripcion; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="section-header disp">Disparadores (Triggers)</div>
    <table>
        <thead>
            <tr>
                <th>Base de Datos</th>
                <th>Tabla</th>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['disparadores'] as $disp) : ?>
                <tr>
                    <td><?php echo $disp->bdNombre; ?></td>
                    <td><?php echo $disp->tablaNombre; ?></td>
                    <td><?php echo $disp->nombre; ?></td>
                    <td><?php echo $disp->descripcion; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

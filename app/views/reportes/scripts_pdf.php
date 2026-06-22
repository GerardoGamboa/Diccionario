<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .script-card { border: 1px solid #333; margin-bottom: 20px; page-break-inside: avoid; }
        .script-header { background-color: #343a40; color: white; padding: 8px; font-weight: bold; }
        .script-meta { padding: 8px; background-color: #f8f9fa; border-bottom: 1px solid #ddd; }
        .script-code { background-color: #eee; padding: 10px; font-family: monospace; white-space: pre-wrap; border-bottom: 1px solid #ddd; }
        .script-result { padding: 10px; font-style: italic; color: #555; }
        .label { font-weight: bold; color: #000; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Scripts Aplicados</h1>
        <p>Fecha de generación: <?php echo date('Y-m-d H:i:s'); ?></p>
        <?php if(!empty($data['filtro'])) : ?>
            <p>Filtro aplicado: "<?php echo $data['filtro']; ?>"</p>
        <?php endif; ?>
    </div>

    <?php foreach($data['scripts'] as $script) : ?>
        <div class="script-card">
            <div class="script-header">
                Servidor: <?php echo $script->servidorNombre; ?> | Fecha: <?php echo $script->fecha_aplicacion; ?>
            </div>
            <div class="script-meta">
                <span class="label">Solicitante:</span> <?php echo $script->solicitante; ?> |
                <span class="label">Ejecutor:</span> <?php echo $script->ejecutor; ?>
            </div>
            <div class="script-code"><?php echo $script->codigo; ?></div>
            <?php if(!empty($script->resultado)) : ?>
                <div class="script-result">
                    <span class="label">Resultado:</span><br>
                    <?php echo $script->resultado; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>

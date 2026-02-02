<?php
/**
 * Vista de listado de facturas
 *
 * Muestra una tabla con todas las facturas disponibles y acciones
 * para crear, editar, borrar, exportar y acceder a recibos o líneas asociadas
 *
 * @package ProyectoTienda - Vista
 */

require("layout/header.php");
?>

<h1>FACTURAS</h1>

<table class="table table-striped table-hover" id="tabla">
    <thead>
        <tr class="text-center">
            <th>Id de Factura</th>
            <th>ID de Cliente</th>
            <th>Número de factura</th>
            <th>Fecha Facturación</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($facturas->filas) :
            foreach ($facturas->filas as $fila) :
        ?>
                <tr>
                    <td style="text-align: right; width: 5%;"><?php echo $fila->id; ?></td>
                    <td style="text-align: right; width: 5%;"><?php echo $fila->cliente_id; ?></td>
                    <td style="text-align: right; width: 5%;"><?php echo $fila->numero; ?></td>
                    <td style="text-align: right; width: 5%;"><?php echo $fila->fecha; ?></td>

                    <td style="text-align: right; width: 50%;">
                        <a href="index.php?c=facturas&m=editar&id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-success">Editar</button></a>

                            <a href="index.php?c=recibos&m=recibos&id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-danger">Recibos</button></a>

                        <a href="index.php?c=lineas&m=index&factura_id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-primary">Lineas de Facturación</button></a>
                        <a href="index.php?c=facturas&m=borrar&id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-danger borrar"
                                onclick="return confirm('¿Estás seguro de borrar el registro <?php
                                                                                                echo $fila->id; ?>?');">Borrar</button></a>
                    </td>
                </tr>
        <?php
            endforeach;
        endif;
        ?>
    <tbody>
    <tfoot>
        <tr>
            <td colspan="4">
                <a href="index.php?c=facturas&m=nuevo">
                    <button type="button" class="btn btn-primary">Nuevo</button>
                </a>
                <a href="index.php?c=facturas&m=exportar">
                    <button type="button" class="btn btn-success">Exportar</button>
                </a>
            </td>
        </tr>
    </tfoot>
</table>
<?php require("layout/footer.php"); ?>
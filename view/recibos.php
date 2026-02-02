<?php
/**
 * Vista de listado de recibos
 *
 * Muestra una tabla con todos los recibos disponibles y acciones
 * para crear, editar, borrar, exportar o imprimir en PDF
 *
 * @package ProyectoTienda - Vista
 */

require("layout/header.php");
?>

<h1>RECIBOS</h1>
<br />
<table class="table table-striped table-hover" id="tabla">
    <thead>
        <tr class="text-center">
            <th>Id</th>
            <th>Factura</th>
            <th>Fecha</th>
            <th>Importe</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($recibos->filas) :
            foreach ($recibos->filas as $fila) :
        ?>
                <tr>
                    <td style="text-align: right; width: 5%;"><?php echo $fila->id; ?></td>
                    <td><?php echo $fila->factura_id; ?></td>
                    <td><?php echo $fila->fecha; ?></td>
                    <td><?php echo $fila->importe; ?></td>

                    <td style="text-align: right; width: 50%;">
                        <a href="index.php?c=recibos&m=editar&id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-success">Editar</button></a>
                        <a href="index.php?c=recibos&m=borrar&id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-danger borrar"
                                onclick="return confirm('¿Estás seguro de borrar el registro <?php
                                                                                                echo $fila->id; ?>?');">Borrar</button></a>
                    </td>
                </tr>
        <?php
            endforeach;
        endif;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">
                <a href="index.php?c=recibos&m=nuevo">
                    <button type="button" class="btn btn-primary">Nuevo</button>
                </a>
                <a href="index.php?c=recibos&m=exportar">
                    <button type="button" class="btn btn-success">Exportar</button>
                </a>
                <a href="index.php?c=recibos&m=imprimir" target="_blank">
                    <button type="button" class="btn btn-success">Sacar PDF</button>
                </a>
            </td>
        </tr>
    </tfoot>
</table>
<?php require("layout/footer.php"); ?>
<?php
/**
 * Vista de listado de líneas de facturación
 *
 * Muestra una tabla con las líneas disponibles y permite acceder a acciones
 * como crear nuevas líneas o navegar entre pantallas relacionadas
 *
 * @package ProyectoTienda - Vista
 */

require("layout/header.php"); ?>

<h1>LINEAS DE FACTURACIÓN</h1>
<br />


<table class="table table-striped table-hover" id="tabla">
    <thead>
        <tr class="text-center">
            <th>Id de Lineas</th>
            <th>ID de Factura</th>
            <th>Número de Referencia</th>   
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>IVA</th>
            <th>Importe</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($lineas->filas) :
            foreach ($lineas->filas as $fila) :
        ?>
                <tr>
                    <td style="text-align: right; width: 5%;"><?php echo $fila->id; ?></td>
                    <td style="text-align: right; width: 5%;"><?php echo $fila->cliente_id; ?></td>
                    <td style="text-align: right; width: 5%;"><?php echo $fila->numero; ?></td>
                    <td style="text-align: right; width: 5%;"><?php echo $fila->fecha; ?></td>

                    <td style="text-align: right; width: 50%;">
                        <a href="index.php?c=facturas&m=editar&id=<?php echo $fila->id; ?>">
                            <button type="button" class="btn btn-success">Editar</button></a>
                        <a href="index.php?c=lineas&m=index&id=<?php echo $fila->id; ?>">
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
                <a href="index.php?c=lineas&m=nuevo">
                    <button type="button" class="btn btn-primary">Nuevo</button>
                </a>
                <a href="index.php?c=lineas&m=exportar">
                    <button type="button" class="btn btn-success">Exportar</button>
                </a>
            </td>
        </tr>
    </tfoot>
</table>

<?php require("layout/footer.php"); ?>
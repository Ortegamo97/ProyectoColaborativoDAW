<?php
/**
 * Vista de mantenimiento de recibos
 *
 * Muestra el formulario para crear un nuevo recibo o modificar uno existente
 * según el valor de la variable $opcion
 * Incluye un selector de facturas usando $facturas->filas
 *
 * @package ProyectoTienda - Vista
 */

require("layout/header.php");
?>

<h1>RECIBO</h1>
<br />
<h2><?php echo ($opcion == 'EDITAR' ? 'MODIFICAR' : 'NUEVO'); ?></h2>
<form action="<?php echo 'index.php?c=recibos&m=' .
                    ($opcion == 'EDITAR' ? 'modificar&id=' . $recibos->id : 'insertar'); ?>"
    method="POST">
    <form action="">


        </select>
        <label for="factura_id" class="form-label">Factura</label>
        <select class="form-control" name="factura_id" id="factura_id" require>

            <?php
            if ($opcion == 'NUEVA'):
            ?>

                <option value="" disabled selected>Seleccionar Factura</option>
            <?php
            endif;

            foreach ($facturas->filas as $facturas):
            ?>
                <option value="<?php echo $facturas->id; ?>"

                    <?php
                    if ($opcion == 'EDITAR') echo ($facturas->id ? 'selected' : ''); ?>>
                    <?php echo $facturas->id; ?>

                </option>
            <?php endforeach ?>
        </select>

        <br />

         <label for="fecha" class="form-label">Fecha </label>
    <input type="date"
        class="form-control"
        name="fecha"
        id="fecha"
        value="<?php echo ($opcion == 'EDITAR' ? $recibos->fecha : ''); ?>"
        required />

        <br />
        <br />
        <label for="importe" class="form-label">Importe</label>
        <input type="number" step="0.01"
            class="form-control"
            name="importe"
            id="importe"
            value="<?php echo ($opcion == 'EDITAR' ? $recibos->importe : ''); ?>"
            required />

        <br />

        <br />
        <button type="submit" class="btn btn-primary">Aceptar</button>
        <a href="<?php echo URLSITE . '?c=recibos'; ?>">
            <button type="button"
                class="btn btn-outline-secondary float-end">Cancelar</button>
        </a>

    </form>

    <?php require("layout/footer.php"); ?>
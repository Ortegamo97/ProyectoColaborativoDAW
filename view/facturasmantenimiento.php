<?php
/**
 * Vista de mantenimiento de facturas
 *
 * Muestra el formulario para crear una nueva factura o modificar una existente
 * según el valor de la variable $opcion
 * Carga un selector de clientes usando $clientes->filas
 *
 * @package ProyectoTienda - Vista
 */

require("layout/header.php");
?>

<h1>FACTURAS</h1>
<br />
<h2><?php echo ($opcion == 'EDITAR' ? 'MODIFICAR' : 'NUEVO'); ?></h2>
<form action="<?php echo 'index.php?c=facturas&m=' .
                    ($opcion == 'EDITAR' ? 'modificar&id=' . $facturas->id : 'insertar'); ?>"
    method="POST">
    <form action="">

        <label for="nombre" class="form-label">Cliente</label>    
        <select class="form-control" name="cliente_id" id="cliente_id" require>

        <?php 
            if($opcion == 'NUEVA'):
        ?>

        <option value="" disabled selected> Seleccionar Cliente</option>
        <?php 
        endif;

        foreach ($clientes->filas as $clientes):
            ?>
                <option value="<?php echo $clientes->id; ?>"

                <?php 
                if($opcion == 'EDITAR') echo($clientes-> id == $facturas-> cliente_id ? 'selected' : ''); ?>
                >
                <?php echo $clientes->nombre; ?>
                
            </option>
            <?php endforeach ?>
        </select>

        <br />

    <label for="fecha" class="form-label">Fecha de Facturación</label>
    <input type="date"
        class="form-control"
        name="fecha"
        id="fecha"
        value="<?php echo ($opcion == 'EDITAR' ? $facturas->fecha : ''); ?>"
        required />

        <br />

        <label for="numero" class="form-label">Número de factura</label>
    <input type="number"
        class="form-control"
        name="numero"
        id="numero"
        value="<?php echo ($opcion == 'EDITAR' ? $facturas->numero : ''); ?>"
        required />

    <br />

    <br />
    <button type="submit" class="btn btn-primary">Aceptar</button>
    <a href="<?php echo URLSITE . '?c=facturas'; ?>">
        <button type="button"
            class="btn btn-outline-secondary float-end">Cancelar</button>
    </a>
        
    </form>
    
    <?php require("layout/footer.php"); ?>
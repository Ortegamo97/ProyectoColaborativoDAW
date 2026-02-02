<?php
/**
 * Vista de mantenimiento de líneas de facturación
 *
 * Muestra el formulario para crear una nueva línea o modificar una existente
 * según el valor de la variable $opcion
 * Incluye un selector de artículos usando $articulos->filas
 *
 * @package ProyectoTienda - Vista
 */

require("layout/header.php"); ?>
<h1>LINEAS DE FACTURACIÓN</h1>
<br />
<h2><?php echo ($opcion == 'EDITAR' ? 'MODIFICAR' : 'NUEVO'); ?></h2>
<form action="<?php echo 'index.php?c=lineas&m=' .
                    ($opcion == 'EDITAR' ? 'modificar&id=' . $lineas->id : 'insertar'); ?>"
    method="POST">
    <form action="">
       
        </select>
        <label for="nombre" class="form-label">Articulo</label>
        <select class="form-control" name="referencia" id="referencia" require>

            <?php
            if ($opcion == 'NUEVA'):
            ?>

                <option value="" disabled selected> Seleccionar Articulo</option>
            <?php
            endif;

            foreach ($articulos->filas as $articulos):
            ?>
                <option value="<?php echo $articulos->referencia; ?>"

                    <?php
                    if ($opcion == 'EDITAR') echo ($articulos->referencia ? 'selected' : ''); ?>>
                    <?php echo $articulos->referencia; ?>

                </option>
            <?php endforeach ?>
        </select>

        <br />

        

        <label for="descripcion" class="form-label">Descripción</label>
        <input type="text"
            class="form-control"
            name="descripcion"
            id="descripcion"
            value="<?php echo ($opcion == 'EDITAR' ? $lineas->descripcion : ''); ?>"
            required />

        <br />
        <label for="cantidad" class="form-label">Cantidad</label>
        <input type="number" step="0.01"
            class="form-control"
            name="cantidad"
            id="cantidad"
            value="<?php echo ($opcion == 'EDITAR' ? $lineas->cantidad : ''); ?>"
            required />

        <br />
        <label for="precio" class="form-label">Precio</label>
        <input type="number" step="0.01"
            class="form-control"
            name="precio"
            id="precio"
            value="<?php echo ($opcion == 'EDITAR' ? $lineas->iva : ''); ?>"
            required />
        <br />
        <label for="precio" class="form-label">IVA</label>
        <input type="number" step="0.01"
            class="form-control"
            name="precio"
            id="precio"
            value="<?php echo ($opcion == 'EDITAR' ? $lineas->iva : ''); ?>"
            required />

        <br />
        <label for="importe" class="form-label">Importe</label>
        <input type="number" step="0.01"
            class="form-control"
            name="importe"
            id="importe"
            value="<?php echo ($opcion == 'EDITAR' ? $lineas->importe : ''); ?>"
            required />

        <br />

        <br />
        <button type="submit" class="btn btn-primary">Aceptar</button>
        <a href="<?php echo URLSITE . '?c=lineas'; ?>">
            <button type="button"
                class="btn btn-outline-secondary float-end">Cancelar</button>
        </a>

    </form>

    <?php require("layout/footer.php"); ?>
<?php
/**
 * Vista de mantenimiento de artículos
 *
 * Muestra el formulario para crear un nuevo artículo o modificar uno existente
 * según el valor de la variable $opcion
 *
 * @package ProyectoTienda - Vista
 */

require("layout/header.php");
require_once("controller/crypt.php");
?>

<h1>ARTÍCULOS</h1>
<br />
<h2><?php echo ($opcion == 'EDITAR' ? 'MODIFICAR' : 'NUEVO'); ?></h2>
<form action="<?php echo 'index.php?c=articulos&m=' .
                    ($opcion == 'EDITAR' ? 'modificar&id=' . $articulos->id : 'insertar'); ?>"
    method="POST">

    <label for="referencia" class="form-label">Referencia</label>
    <input type="text"
        class="form-control"
        name="referencia"
        id="referencia"
        value="<?php echo ($opcion == 'EDITAR' ? $articulos->referencia : ''); ?>"
        required />
    <br />
    <label for="descripcion" class="form-label">Descripción</label>
    <input type="text"
        class="form-control"
        name="descripcion"
        id="descripcion"
        value="<?php echo ($opcion == 'EDITAR' ? $articulos->descripcion : ''); ?>"
        required />
    <br />


    <label for="precio" class="form-label">Precio</label>
    <input type="number" step="0.01"
    class="form-control"
    name="precio"
    id="precio"
    value="<?php echo ($opcion == 'EDITAR' ? $articulos->precio : ''); ?>"
    required />
    
    <br />
    <label for="iva" class="form-label">IVA</label>
    <input type="number"  step="0.01"
        class="form-control"
        name="iva"
        id="iva"
        value="<?php echo ($opcion == 'EDITAR' ? $articulos->iva : ''); ?>"
        required />

    <br />
    <button type="submit" class="btn btn-primary">Aceptar</button>
    <a href="<?php echo URLSITE . '?c=articulos'; ?>">
        <button type="button"
            class="btn btn-outline-secondary float-end">Cancelar</button>
    </a>
</form>
<?php require("layout/footer.php"); ?>
<?php 
$eti_proceso="";
switch ($proceso) {
    case "ingresar": $eti_proceso="Ingresar"; break;
    case "editar": $eti_proceso="Editar"; break;
    default: $eti_proceso=""; break;
}

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

   

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Articulos - <?=$eti_proceso ?></div>
                <div class="panel-body">
                    <form role="search" method="POST" action="<?php echo base_url(); ?>articulos/grabar">
                        <div class="form-group">
                            <label for="nombre">Nombre 
                            </label> 
                            <input type="text" name="articulo" id="articulo" class="form-control" 
                                   value="<?=$articulo->articulo?>" />
                            <div id="errArticulo">
                                <small><font color="red">
                                    <?php if (isset($error->articulo)){echo $error->articulo;}?> 
                                </font></small>
                            </div>  
                            <br>
                            
                            <label for="codigo">Código 
                            </label> 
                            <input type="text" name="codigo" id="codigo" class="form-control" 
                                   value="<?=$articulo->codigo?>" />
                            <div id="errCodigo">
                                <small><font color="red">
                                    <?php if (isset($error->codigo)){echo $error->codigo;}?> 
                                </font></small>
                            </div>
                            <br>
                                                        
                            <label for="rubro">Rubro 
                            </label>
                            <select name="rubro" id="rubro" class="form-control">
                                <option value="">Seleccione un rubro</option>
                            <?php foreach ($lista_rubro as $rubro) {?>
                                <option value="<?=$rubro->id_rubro?>" 
                                    <?php if ($rubro->id_rubro==$articulo->id_rubro){echo "selected";}?> >
                                    <?=$rubro->rubro?>
                                </option>
                            <?php }?>        
                            </select>
                            <div id="errRubro">
                                <small><font color="red">
                                    <?php if (isset($error->rubro)){echo $error->rubro;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="categoria">Categoría 
                            </label>
                            <select name="categoria" id="categoria" class="form-control">
                                <option value="">Seleccione una categoría</option>
                            <?php foreach ($lista_categoria as $categoria) {?>
                                <option value="<?=$categoria->id_categoria?>" 
                                    <?php if ($categoria->id_categoria==$articulo->id_rubro){echo "selected";}?> >
                                    <?=$categoria->categoria?>
                                </option>
                            <?php }?>        
                            </select>
                            <div id="errCategoria">
                                <small><font color="red">
                                    <?php if (isset($error->categoria)){echo $error->categoria;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="costo">Costo
                            </label>
                            <input type="text" name="costo" id="costo" class="form-control" 
                                   value="<?=$articulo->costo?>" />
                            <div id="errCosto">
                                <small><font color="red">
                                    <?php if (isset($error->costo)){echo $error->costo;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="precio1">Precio 1
                            </label>
                            <input type="text" name="precio1" id="precio1" class="form-control" 
                                   value="<?=$articulo->precio1?>" />
                            <div id="errPrecio1">
                                <small><font color="red">
                                    <?php if (isset($error->precio1)){echo $error->precio1;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="precio2">Precio 2
                            </label>
                            <input type="text" name="precio2" id="precio2" class="form-control" 
                                   value="<?=$articulo->precio2?>" />
                            <div id="errPrecio2">
                                <small><font color="red">
                                    <?php if (isset($error->precio2)){echo $error->precio2;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="iva">Iva 
                            </label>
                            <select name="iva" id="iva" class="form-control">
                                <option value="">Seleccione un valor de iva</option>
                                <option value="0.21" <?php if ($articulo->iva=="0.21"){echo "selected";}?>>0,21</option>
                                <option value="10.5" <?php if ($articulo->iva=="10.5"){echo "selected";}?>>10,5</option>
                                <option value="27" <?php if ($articulo->iva=="27"){echo "selected";}?>>27</option>
                            </select>
                            <div id="errIva">
                                <small><font color="red">
                                    <?php if (isset($error->iva)){echo $error->iva;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="empresa">Empresa
                            </label>
                            <select name="id_empresa" id="id_empresa" class="form-control">
                                <option value="0">Ninguna</option>
                            <?php foreach ($lista_empresa as $empresa) {?>
                                <option value="<?=$empresa->id_empresa?>" 
                                    <?php if ($empresa->id_empresa==$articulo->id_empresa){echo "selected";}?> >
                                    <?=$empresa->razon_soc?> 
                                </option>
                            <?php }?>        
                            </select>
                            <div id="errIdEmpresa">
                                <small><font color="red">
                                    <?php if (isset($error->id_empresa)){echo $error->id_empresa;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="cc_compras">CC Compras
                            </label>
                            <input type="text" name="cc_compras" id="cc_compras" class="form-control" 
                                   value="<?=$articulo->cc_compras?>" />
                            <div id="errCompras">
                                <small><font color="red">
                                    <?php if (isset($error->cc_compras)){echo $error->cc_compras;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="cc_ventas">CC Ventas
                            </label>
                            <input type="text" name="cc_ventas" id="cc_ventas" class="form-control" 
                                   value="<?=$articulo->cc_ventas?>" />
                            <div id="errVentas">
                                <small><font color="red">
                                    <?php if (isset($error->cc_ventas)){echo $error->cc_ventas;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                        </div>
                        <input type="hidden" name="id_art" value="<?=$articulo->id_art?>" />
                        <button type="submit" class="btn btn-primary">Grabar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
$(document).ready(function(){
    $('#costo').mask('9999999999999.99');
    $('#precio1').mask('9999999999999.99');
    $('#precio2').mask('9999999999999.99');
    $('#cc_compras').mask('9999999999999.99');
    $('#cc_ventas').mask('9999999999999.99');
    
    $("#articulo").keydown(function() {$("#errArticulo").html("");});
    $("#codigo").keydown(function() {$("#errCodigo").html("");});
    $("#rubro").change(function() {$("#errRubro").html("");});
    $("#categoria").change(function() {$("#errCategoria").html("");});
    $("#costo").keydown(function() {$("#errCosto").html("");});
    $("#precio1").keydown(function() {$("#errPrecio1").html("");});
    $("#precio2").keydown(function() {$("#errPrecio2").html("");});
    $("#iva").change(function() {$("#errIva").html("");});
    $("#id_empresa").change(function() {$("#errIdEmpresa").html("");});
    $("#cc_compras").keydown(function() {$("#errCompras").html("");});
    $("#cc_ventas").keydown(function() {$("#errVentas").html("");});
    
});
    
</script>
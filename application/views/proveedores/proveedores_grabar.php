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
                <div class="panel-heading">Proveedores - <?=$eti_proceso ?></div>
                <div class="panel-body">
                    <form role="search" method="POST" action="<?php echo base_url(); ?>proveedores/grabar">
                        <div class="form-group">
                            <label for="nombre">Nombre 
                            </label> 
                            <input type="text" name="proveedor" id="proveedor" class="form-control" 
                                   value="<?=$proveedor->proveedor?>" />
                            <div id="errProveedor">
                                <small><font color="red">
                                    <?php if (isset($error->proveedor)){echo $error->proveedor;}?> 
                                </font></small>
                            </div>  
                            <br>
                            
                            <label for="domicilio">Dirección 
                            </label> 
                            <input type="text" name="domicilio" id="domicilio" class="form-control" 
                                   value="<?=$proveedor->domicilio?>" />
                            <div id="errDomicilio">
                                <small><font color="red">
                                    <?php if (isset($error->domicilio)){echo $error->domicilio;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="telefonos">Telefonos 
                            </label> 
                            <input type="text" name="telefonos" id="telefonos" class="form-control" 
                                   value="<?=$proveedor->telefonos?>" />
                            <div id="errTelefonos">
                                <small><font color="red">
                                    <?php if (isset($error->telefonos)){echo $error->telefonos;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="email">Email 
                            </label> 
                            <input type="text" name="email" id="email" class="form-control" 
                                   value="<?=$proveedor->email?>" />
                            <div id="errEmail">
                                <small><font color="red">
                                    <?php if (isset($error->email)){echo $error->email;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="email">Cuit 
                            </label> 
                            <input type="text" name="cuit" id="cuit" class="form-control" 
                                value="<?=$proveedor->cuit?>" 
                                placeholder="Formato 99-99999999-9"
                                />
                                   
                            <div id="errCuit">
                                <small><font color="red">
                                    <?php if (isset($error->cuit)){echo $error->cuit;}?> 
                                </font></small>
                            </div>
                            
                            <br>
                            <label for="email">Iva 
                            </label>
                            <select name="iva" id="iva" class="form-control">
                                <option value="">Seleccione una condición de iva</option>
                            <?php foreach ($lista_iva as $iva) {?>
                                <option value="<?=$iva->codigo?>" 
                                    <?php if ($iva->codigo==$proveedor->iva){echo "selected";}?> >
                                    <?=$iva->cond_iva?>
                                </option>
                            <?php }?>        
                            </select>
                            <div id="errIva">
                                <small><font color="red">
                                    <?php if (isset($error->iva)){echo $error->iva;}?> 
                                </font></small>
                            </div>
                            
                            <br>
                            <label for="email">Localidad 
                            </label>
                            <input type="text" name="localidad" id="localidad" class="form-control" 
                                   value="<?=$proveedor->localidad?>" />
                            <div id="errLocalidad">
                                <small><font color="red">
                                    <?php if (isset($error->localidad)){echo $error->localidad;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="email">Código postal 
                            </label>
                            <input type="text" name="cp" id="cp" class="form-control" 
                                   value="<?=$proveedor->cp?>" />
                            <div id="errCp">
                                <small><font color="red">
                                    <?php if (isset($error->cp)){echo $error->cp;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="email">Empresa
                            </label>
                            <select name="id_empresa" id="id_empresa" class="form-control">
                                <option value="0">Ninguna</option>
                            <?php foreach ($lista_empresa as $empresa) {?>
                                <option value="<?=$empresa->id_empresa?>" 
                                    <?php if ($empresa->id_empresa==$proveedor->id_empresa){echo "selected";}?> >
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
                            
                            <label for="email">DNI
                            </label>
                            <input type="text" name="dni" id="dni" class="form-control" 
                                   value="<?=$proveedor->dni?>" />
                            <div id="errDNI">
                                <small><font color="red">
                                    <?php if (isset($error->dni)){echo $error->dni;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="email">Etiqueta 
                            </label>
                            <select name="id_etiqueta" id="id_etiqueta" class="form-control">
                                <option value="0">Ninguna</option>
                            <?php foreach ($lista_etiqueta as $etiqueta) {?>
                                <option value="<?=$etiqueta->id?>" 
                                    <?php if ($etiqueta->id==$proveedor->id_etiqueta){echo "selected";}?> >
                                    <?=$etiqueta->etiqueta?>
                                </option>
                            <?php }?>        
                            </select>
                            <div id="errIdEtiqueta">
                                <small><font color="red">
                                    <?php if (isset($error->id_etiqueta)){echo $error->id_etiqueta;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="email">Razón social
                            </label>
                            <div class="input-group">
                                <input type="text" name="rz" id="rz" class="form-control" 
                                    value="<?=$proveedor->rz?>" 
                                    placeholder="Puede replicar el nombre del proveedor haciendo click en 'Copiar nombre proveedor'"
                                />
                                
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="btnCopiaNombre">
                                      Copiar nombre proveedor
                                    </button>
                                </span>
                            </div><!-- /input-group -->    
                                
                            <div id="errRz">
                                <small><font color="red">
                                    <?php if (isset($error->rz)){echo $error->rz;}?> 
                                </font></small>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?=$proveedor->id?>" />
                        <button type="submit" class="btn btn-primary">Grabar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
$(document).ready(function(){
    $('#cuit').mask('99-99999999-9');
    $('#dni').mask('99999999');
    
    $("#proveedor").keydown(function() {$("#errProveedor").html("");});
    $("#domicilio").keydown(function() {$("#errDomicilio").html("");});
    $("#telefonos").keydown(function() {$("#errTelefonos").html("");});
    $("#email").keydown(function() {$("#errEmail").html("");});
    $("#cuit").keydown(function() {$("#errCuit").html("");});
    $("#iva").change(function() {$("#errIva").html("");});
    $("#localidad").keydown(function() {$("#errLocalidad").html("");});
    $("#cp").keydown(function() {$("#errCp").html("");});
    $("#id_empresa").change(function() {$("#errIdEmpresa").html("");});
    $("#dni").keydown(function() {$("#errDNI").html("");});
    $("#id_etiqueta").change(function() {$("#errIdEtiqueta").html("");});
    $("#rz").keydown(function() {$("#errRz").html("");});
    
    
    $("#btnCopiaNombre").click(function() {
        $("#rz").val($("#proveedor").val());
    });
});
    
</script>
<?php
$btn_g="Editar";
if(!(isset($etiqueta->id))){
    $etiqueta = new stdClass();
    $etiqueta->id="";
    $etiqueta->etiqueta="";
    $btn_g="Ingresar";
}else{
    if (!(is_numeric($etiqueta->id))){$btn_g="Ingresar";}
}
?>

<script>
    
$(document).ready(function(){
    $("#etiqueta").keydown(function() {
        $("#errEtiqueta").html("");
    });
});
    
</script>   

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Etiquetas - <?=$btn_g?></div>
                <div class="panel-body">
                    <form role="search" method="POST" action="<?php echo base_url(); ?>clientes/etiqueta_grabar">
                        <div class="form-group">
                            <label for="etiqueta_nombre">Etiqueta 
                            </label> 
                            <input type="text" name="etiqueta" id="etiqueta" class="form-control" id="etiqueta_nombre" value="<?=$etiqueta->etiqueta?>">
                            <div id="errEtiqueta">
                                <small><font color="red">
                                    <?php if (isset($error->etiqueta)){echo $error->etiqueta;}?> 
                                </font></small>
                            </div>    
                        </div>
                        <input type="hidden" name="id" value="<?=$etiqueta->id?>">
                        <button type="submit" class="btn btn-primary">Grabar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
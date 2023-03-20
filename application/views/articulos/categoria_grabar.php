<?php
$btn_g="Editar";
if(!(isset($categoria->id_categoria))){
    $categoria = new stdClass();
    $categoria->id_categoria="";
    $categoria->categoria="";
    $btn_g="Ingresar";
}else{
    if (!(is_numeric($categoria->id_categoria))){$btn_g="Ingresar";}
}
?>

<script>
    
$(document).ready(function(){
    $("#categoria").keydown(function() {
        $("#errCategoria").html("");
    });
});
    
</script>   

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Categorías - <?=$btn_g?></div>
                <div class="panel-body">
                    <form role="search" method="POST" action="<?php echo base_url(); ?>articulos/categoria_grabar">
                        <div class="form-group">
                            <label for="categoria_nombre">Categoria 
                            </label> 
                            <input type="text" name="categoria" id="categoria" class="form-control" value="<?=$categoria->categoria?>">
                            <div id="errCategoria">
                                <small><font color="red">
                                    <?php if (isset($error->categoria)){echo $error->categoria;}?> 
                                </font></small>
                            </div>    
                        </div>
                        <input type="hidden" name="id" value="<?=$categoria->id_categoria?>">
                        <button type="submit" class="btn btn-primary">Grabar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
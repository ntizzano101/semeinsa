<?php
$btn_g="Editar";
if(!(isset($rubro->id_rubro))){
    $rubro = new stdClass();
    $rubro->id_rubro="";
    $rubro->rubro="";
    $btn_g="Ingresar";
}else{
    if (!(is_numeric($rubro->id_rubro))){$btn_g="Ingresar";}
}
?>

<script>
    
$(document).ready(function(){
    $("#rubro").keydown(function() {
        $("#errRubro").html("");
    });
});
    
</script>   

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Rubros - <?=$btn_g?></div>
                <div class="panel-body">
                    <form role="search" method="POST" action="<?php echo base_url(); ?>articulos/rubro_grabar">
                        <div class="form-group">
                            <label for="rubro_nombre">Rubro 
                            </label> 
                            <input type="text" name="rubro" id="rubro" class="form-control" value="<?=$rubro->rubro?>">
                            <div id="errRubro">
                                <small><font color="red">
                                    <?php if (isset($error->rubro)){echo $error->rubro;}?> 
                                </font></small>
                            </div>    
                        </div>
                        <input type="hidden" name="id" value="<?=$rubro->id_rubro?>">
                        <button type="submit" class="btn btn-primary">Grabar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
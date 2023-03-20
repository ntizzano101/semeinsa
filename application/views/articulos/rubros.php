<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" /> 
<style>
.container a:hover, a:visited, a:link, a:active{
    text-decoration: none;
}   
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Rubros</div>
                <?php if(isset($mensaje)){?>
                    <div class="row">
                        <div class="col-md-12">
                            <?=$mensaje?>
                        </div>
                    </div>
                    <?php }?>
                <div class="panel-body">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>articulos/rubro_ingresar">Nuevo rubro</a>
                    <br>
                    <form class="navbar-form navbar-left" role="search" method="POST" action="<?php echo base_url(); ?>articulos/rubro_buscar">
                        <input type="text" class="form-control" name="buscar" placeholder="Buscar..">
                        <button type="submit" class="btn btn-default">Buscar</button>								
                    </form>	
                </div>
                
                <table class="table">
                  <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php 
                        foreach($rubros as $rub){ ?>	
                                <tr>
                                    <th scope="row"><?=$rub->id_rubro ?></th>
                                    <td><?=$rub->rubro ?></td>
                                    <td>
                                        <a class="btn-default fa fa-pencil" title="Editar"  
                                           href="<?php echo base_url(); ?>articulos/rubro_editar/<?=$rub->id_rubro?>"></a> 
                                        &nbsp;
                                        <a class="btn-default fa fa-eraser" title="Borrar" 
                                           onclick="verBorrar(<?=$rub->id_rubro?>, '<?=$rub->rubro?>')" >  
                                        </a>
                                    </td>
                                </tr>
                        <?php	
                        }
                        ?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="mdlVerBorrar">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title">Borrar</h1>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        ¿Esta seguro de borrar al rubro <label id="lblBorrarRub"/> &#191;
                        
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-default btn-danger" id="hrefBorrar" href="">Borrar
                    
                </a>
            </div>

          </div>
        </div>
    </div> 
    
</div>

<script>
    
$(document).ready(function(){
    
    
});

function verBorrar(id,etiqueta){
    $("#lblBorrarRub").html(etiqueta);
    $("#hrefBorrar").attr("href","<?php echo base_url()?>articulos/rubro_borrar/" + id);
    $("#mdlVerBorrar").modal("show");
}

    
</script>
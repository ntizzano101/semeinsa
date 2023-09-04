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
                <div class="panel-heading">Clientes</div>
                <?php if(isset($mensaje)){?>
                <div class="row">
                    <div class="col-md-12">
                        <?=$mensaje?>
                    </div>
                </div>
                <?php }?>
                <div class="panel-body">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>clientes/ingresar">Nuevo cliente</a>
                    <br>
                    <form class="navbar-form navbar-left" role="search" method="POST" action="<?php echo base_url(); ?>clientes/buscar">
                    <input type="text" class="form-control" name="buscar" placeholder="Buscar..">
                    <button type="submit" class="btn btn-default">Buscar</button>								
                    </form>	
                </div>
                
                <table class="table">
                  <thead>
                        <tr>
                          <th>DNI</th>
                          <th>Nombre</th>
                          <th>Direccion</th>
                          <th>Empresa</th>
                          <th>Acciones</th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php 
                        foreach($clientes as $clie){ ?>	
                                <tr>
                                    <td><?=$clie->dni ?></td>
                                    <td><?=$clie->cliente ?></td>
                                    <td><?=$clie->domicilio ?></td>
                                    <td><?=$clie->empresa_nombre ?></td>
                                    <td>
                                        <a class="btn-default fa fa-eye" title="Ver" 
                                            href="<?php echo base_url(); ?>clientes/ver/<?=$clie->id?>">
                                        </a>
                                        &nbsp; &nbsp;
                                        <a class="btn-default fa fa-pencil" title="Editar" 
                                            href="<?php echo base_url(); ?>clientes/editar/<?=$clie->id?>">                                        
                                        </a>
                                        &nbsp; &nbsp;
                                        <a class="btn-default fa fa-book" title="CtaCte" 
                                            href="<?php echo base_url(); ?>recibos/ctacte/<?=$clie->id?>">  
                                        </a>
                                    <?php if (!($clie->baja)){ ?>
                                        &nbsp; &nbsp;
                                        <a class="btn-default fa fa-eraser" title="Borrar" 
                                           onclick="verBorrar(<?=$clie->id?>, '<?=$clie->cliente?>')" >  
                                        </a>
                                    <?php }?>
                                        
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
    
    <!MODALS !>
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
                        ¿Esta seguro de borrar al cliente <label id="lblBorrarClien" /> ?   
                        
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

function verBorrar(id,cliente){
    $("#lblBorrarClien").html(cliente);
    $("#hrefBorrar").attr("href","<?php echo base_url()?>clientes/borrar/" + id);
    $("#mdlVerBorrar").modal("show");
}

    
</script>
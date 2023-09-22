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
           
                <div class="panel-heading">PLAN DE CUENTAS</div>     
            <form id="formu" class="navbar-form navbar-left" role="search" method="POST" action="<?php echo base_url(); ?>iva/plan_de_cuentas_buscar">                           
                <input type="text" class="form-control" name="cuenta" value="" id="cuenta" placeholder="cuenta..">
                <button type="submit" class="btn btn-primary">Filtrar</button>	               
                <a href="#" class="btn btn-success" id="btnAgregar">Agregar</a>	    
            </form>
               
                <table class="table">
                  <thead>
                        <tr>
                          <th>Cuenta</th>
                          <th>Nombre</th>
                          <th>Ajustable</th>                         
                          <th>Acciones</th>                          
                        </tr>
                  </thead>
                  <tbody>
                        <?php 
                        $total=0;$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;
                        foreach($iva as $cta){                 
                            $mover=0;
                            for($i=10;$i>0;$i--){                               
                                if(substr($cta->cuenta,$i-1,1)<>'0' and $mover==0)
                                       $mover=$i; 
                            }   
                                   
                            ?>	
                                <tr id="fila<?=$cta->id?>">
                                    <td><?=$cta->cuenta ?></td>                                    
                                    <td><?php echo "\\" . str_repeat("_",$mover) . $cta->nombre  ?></td>
                                    <td><?=$cta->imputable ?></td>
                                    <td>
                                    <a class="btn-default fa fa-pencil" title="Editar" 
                                            href="<?php echo base_url(); ?>iva/plan_editar/<?=$cta->id?>">                                        
                                        </a>                               
                                        &nbsp; &nbsp;
                                        <a href="#"  onClick="borrar(<?=$cta->id?>)" class="btn-default fa fa-eraser" title="Borrar">
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
</div> 

<!MODALS !>
            <div class="modal fade" id="mdlBorrar">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title">BORRAR CUENTA</h1>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="row">
                                <h4 id="borro_texto" class="text-danger"></h4>       
                                <div class="col-12 col-md-12 col-lg-12">                                
                                    ¿Esta seguro de borrar la cuenta?<label id="lblBorrarOp" /> ?                               
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="id_borro" value="">
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="btnBorrar" data-dismiss="modal">Eliminar</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="mdlAlta">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title">NUEVA CUENTA CONTABLE</h1>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Cuenta
                            </label>                       
                            <input type="text" name="cuenta1" id="cuenta1" class="form-control" 
                                   value="" />
                            <div id="errCuenta">
                                <small><font color="red" id="errCuenta1">                            
                                </font></small>
                            </div>  
                            <br>                            
                            <label for="domicilio">Nombre
                            </label> 
                            <input type="text" name="nombre1" id="nombre1" class="form-control" 
                                   value="" />
                            <div id="errNombre">
                                <small><font color="red" id="errNombre1">                                   
                                </font></small>
                            </div>
                            <br>                            
                            <label for="telefonos">Ajustable
                            </label> 
                            <input type="text" name="imputable1" id="imputable1" class="form-control" 
                                   value="" />
                            <div id="errImputable">
                                <small><font color="red" id="errImputable1">                                   
                                </font></small>
                            </div>
                            <br>
                        <div>                    
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                            <a href="#" class="btn btn-success" id="btnGuardar">Guardar</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
<!MODALS !>  
<script>
var CFG = {
        url: '<?php echo $this->config->item('base_url');?>',
        token: '<?php echo $this->security->get_csrf_hash();?>'
    };   
    $(document).ready(function(){
                $.ajaxSetup({data: {token: CFG.token}});
                $(document).ajaxSuccess(function(e,x) {
                    var result = $.parseJSON(x.responseText);
                    $('input:hidden[name="token"]').val(result.token);
                    $.ajaxSetup({data: {token: result.token}});
                });

    $("#btnAgregar").click(function(){  
        $("#mdlAlta").modal("show");    
    });  

    $("#btnGuardar").click(function(){         
            $("#errNombre1").html('');
            $("#errCuenta1").html('');
            $("#errImputable1").html('');      
            $.post(CFG.url + 'iva/verificar_plan/',
                {id:0,             
                nombre:$("#nombre1").val(),             
                cuenta:$("#cuenta1").val(),             
                imputable:$("#imputable1").val(),                          
                },
                function(data){     
                                            
                if(data.mensaje==""){                                               
                    $("#mdlAlta").modal("hide");
                    $("#formu").submit();

                }
                else{
                    $("#"+ data.error +"1").html(data.mensaje);                
                }                             
            });   
    });        

    $("#btnBorrar").click(function(){              
            $.post(CFG.url + 'iva/plan_delete/',
            {id:$("#id_borro").val()          
            },
            function(data){               
                $("#fila" + $("#id_borro").val()).remove();
                $("#mdlBorrar").modal("hide");   
            });           
            
        });

    });         
    function borrar(id) { 
        $.post(CFG.url + 'iva/plan_id/',
            {id:id},
            function(data){                  
                $("#id_borro").val(data.id)    ;
                $("#borro_texto").html(data.cuenta + ' ' + data.nombre)    ;
                $("#mdlBorrar").modal("show");           
            });      
  }     
  </script>
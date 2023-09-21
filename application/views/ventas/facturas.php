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
                <div class="panel-heading">Ventas , Comprobantes </div>
                <?php if(isset($mensaje)){?>
                <div class="row">
                    <div class="col-md-12">
                        <?=$mensaje?>
                    </div>
                </div>
                <?php }?>
                <div class="panel-body">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>ventas/ingresar">Nueva Venta</a>
                    <br>
                    <form class="navbar-form navbar-left" role="search" method="POST" action="<?php echo base_url(); ?>ventas/buscar">
                    <input type="text" class="form-control" name="buscar" placeholder="Buscar..">
                    <button type="submit" class="btn btn-default">Buscar</button>								
                    </form>	
                </div>
                
                <table class="table">
                  <thead>
                        <tr>
                          <th>Id</th>
                          <th>Empresa</th>
                          <th>Cliente</th>
                          <th>Fecha</th>
                          <th>Comprobante</th>
                          <th>Total</th>
                          <th>Acciones</th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php 
                        foreach($facturas as $fact){ 
                            $color=' class= "text-info" '   ;
                            $mult=1;
                            if(strpos($fact->nombre,"NC")>0){
                                $color=' class = "text-danger" ';
                                $mult=-1;
                                }
                                ?>	
                                <tr <?php echo $color ?> >
                                    <td><?=$fact->id ?></td>
                                    <td><?=$fact->datos ?></td>
                                    <td><?=$fact->cliente ?></td>
                                    <td><?=$fact->fecha ?></td>                                    
                                    <td><a href="#" id="renglon<?=$fact->id?>" onClick="modificar_nro(<?=$fact->id?>)"><?php echo $fact->nombre . " " .  str_pad($fact->puerto,5,"0",STR_PAD_LEFT)."-".  str_pad($fact->numero,8,"0",STR_PAD_LEFT) ;  ?></a></td>                                    
                                    <td align="right"><?php printf("$ %0.2f", $fact->total * $mult) ?></td>
                                    <td>
                                        <a class="btn-default fa fa-eye" title="Ver Comprobante" 
                                            href="<?php echo base_url(); ?>ventas/comprobante/<?=$fact->id?>" target="blank_">
                                        </a>
                                        &nbsp; &nbsp;
                                        <a class="btn-default fa fa-exchange" title="Generar De Credito"
                                            onclick="verNC(<?=$fact->id?>, '<?=$fact->cliente?>')" >                              
                                            </a>                                        
                                        &nbsp; &nbsp;
                                        <a class="btn-default fa fa-money" title="Ver Comprobante Asociado" 
                                            href="<?php echo base_url(); ?>ventas/comprobante/<?=$fact->id_comp_asoc?>" target="blank_">
                                        </a> 
                                        &nbsp; &nbsp;
                                        <a class="btn-default fa fa-eraser" title="Borrar" 
                                           onclick="verBorrar(<?=$fact->id?>, '<?=$fact->cliente?>')" >  
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
                        <label id="msjBorrar"></label>   
                        
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
    <!MODALS !>
    <div class="modal fade" id="mdlCambioNro">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title">Cambiar Numeracion</h1>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <label id="msjNumeracion"></label>                           
                    </div>
                </div>
                <div class="row">
                        <label for="itemCod">Ingrese Nuevo Numero</label>                                                
                        <input type="hidden" name="" value="" id="id_factura" class="form-control"/> 
                        <input type="text" name="" id="nuevonro" class="form-control"/> 
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="bntCambioNro">Aceptar</button>
            </div>

          </div>
        </div>
    </div>    
    <!MODALS !>
    <!MODALS !>
    <div class="modal fade" id="mdlError">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title">Error Al Procesar La Solicitud</h1>
              <button type="button" class="close" data-dismiss="modal">&times;</button>            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <label id="msjError"></label>   
                        
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>   
                    
                </a>
            </div>

          </div>
        </div>
    </div>  
    
</div>

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
   
    $("#bntCambioNro").click(function(){                    
        $.post(CFG.url + 'Ajax/validarnro/',
        {id:$("#id_factura").val(),
        numero:$("#nuevonro").val()},
        function(data){                               
            if(data.mensaje!=""){
                $("#msjNumeracion").html(data.mensaje);                  
           }
           else{                  
              $("#renglon"+data.id_factura).html(data.renglon);               
              $("#mdlCambioNro").modal("hide");
            }
        });           
    });               

});

function verBorrar(id,cliente){
    $.post(CFG.url + 'Ajax/borrar_comprobante/',
        {id:id},
        function(data){         
           if(data.mensaje!=""){
                $("#msjError").html(data.mensaje);                
                $("#mdlError").modal("show");
           }
           else{
            $("#msjBorrar").html("¿Está seguro de borrar el comprobante ID:"+ id + " del Cliente : " + cliente + " ?");
            $("#hrefBorrar").attr("href","<?php echo base_url()?>ventas/borrar/" + id );
            $("#mdlVerBorrar").modal("show");

           }
        });
    }
    function modificar_nro(id){
    $.post(CFG.url + 'Ajax/comprobantecambiar/',
        {id:id},
        function(data){        
              $("#id_factura").val(data.id_factura)  ;
              $("#nuevonro").val(data.numero);      
              $("#mdlCambioNro").modal("show");
            }
        );
    } 
 /*   function validar_nro(){
    $.post(CFG.url + 'Ajax/validarnro/',
        {id:$("#id_factura").val(),
        numero:$("#nuevonro").val()},
        function(data){  
            if(data.mensaje!=""){
                $("#msjError").html(data.mensaje);                
                $("#mdlError").modal("show");
           }
           else{       
              $("#nuevonro").val(data.numero);      
              $("#mdlCambioNro").modal("show");
            }
        });
    } 
    */
</script>
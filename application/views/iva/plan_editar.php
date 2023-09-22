<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Editar Plan de Cuentas</div>
                <div class="panel-body">
                   
                        <div class="form-group">
                            <label for="nombre">Cuenta
                            </label> 
                            <input type="hidden" id="id" name="id" value="<?=$cuenta->id?>">
                            <input type="hidden" id="ok" name="ok" value="NO">
                            <input type="text" name="cuenta" id="cuenta" class="form-control" 
                                   value="<?=$cuenta->cuenta?>" />
                            <div id="errCuenta">
                                <small><font color="red" id="errCuenta1">                            
                                </font></small>
                            </div>  
                            <br>
                            
                            <label for="domicilio">Nombre
                            </label> 
                            <input type="text" name="nombre" id="nombre" class="form-control" 
                                   value="<?=$cuenta->nombre?>" />
                            <div id="errNombre">
                                <small><font color="red" id="errNombre1">                                   
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="telefonos">Ajustable
                            </label> 
                            <input type="text" name="imputable" id="imputable" class="form-control" 
                                   value="<?=$cuenta->imputable?>" />
                            <div id="errImputable">
                                <small><font color="red" id="errImputable1">                                   
                                </font></small>
                            </div>
                            <br>
                        <div>                            
                        <a href="<?php echo base_url(); ?>iva/plan_de_cuentas" class="btn btn-primary">Volver</a>    
                        <buttom id="guardar" class="btn btn-success" onClick="verificar()">Guardar</buttom>
                        <div class="btn btn-default" id="listo"></div>
                 
                 
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

     $("#listo").hide();           

    });     
    function verificar(){          
        $("#errNombre1").html('');
        $("#errCuenta1").html('');
        $("#errImputable1").html('');      
        $.post(CFG.url + 'iva/verificar_plan/',
            {id:$("#id").val(),             
             nombre:$("#nombre").val(),             
             cuenta:$("#cuenta").val(),             
             imputable:$("#imputable").val(),                          
            },
            function(data){                                                     
               if(data.mensaje==""){
                    $("#listo").html("se guardo la actualizacion de la cuenta");                                         
                    $("#listo").show();
                    $("#guardar").hide();
               }
               else{
                $("#"+ data.error +"1").html(data.mensaje);                
               }                             
            });      
    }
    function eliminarFila(index) {
         $("#fila" + index).remove();
}
  
</script>    

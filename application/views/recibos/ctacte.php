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
                <div class="panel-heading">Cuenta Corriente - <?=$proveedor->cliente?></div>
                <?php if(isset($mensaje)){?>
                <div class="row">
                    <div class="col-md-12">
                        <?=$mensaje?>
                    </div>
                </div>
                <?php }?>
                <div class="panel-body">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>recibos/opago/<?=$proveedor->id?>">Nuevo Recibo</a>
                    <br>
                </div>
                
                <table class="table">
                  <thead>
                        <tr>
                          <th>Fecha</th>
                          <th>Comprobante</th>
                          <th>Debe</th>
                          <th>Haber</th>
                          <th>Saldo</th>
                          <th>Acciones</th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php 
                        $total=0;
                        foreach($ctactes as $cta){ 
                            $total=$total + $cta->debe - $cta->haber ;
                            ?>	
                                <tr>
                                    <td><?=$cta->fecha ?></td>
                                    <td><?=$cta->descrip ?></td>
                                    <td><?=number_format($cta->debe,2,".",",")?></td>
                                    <td><?=number_format($cta->haber,2,".",",")?></td>
                                    <td><?=number_format($total,2,".",",")?></td>
                                    <td><?php if($cta->tt=='O'){
                                        echo '  <a class="btn-default fa fa-eraser" onClick="borro('.$cta->id.','.$proveedor->id.')"></span></a>
                                        <a class="btn-default fa fa-eye" onClick="verOP('.$cta->id.')"></span></a>';}
                                        else{echo '  <a class="btn-default fa fa-eye" onClick="verFacturaCompra('.$cta->id.')"></span></a>';}
                                     ?></td>
                                    <td>                                        
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
    <!MODALS !>
    <div class="modal fade" id="mdlVerBorrar">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title">ELIMINAR RECIBO DE CLIENTE</h1>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        ¿Esta seguro de borrar eL Recibo?<label id="lblBorrarOp" /> ?   
                        
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
    <?php
    $this->load->view('recibos/veropago');
    $this->load->view('recibos/verFacturaCompra');
    ?>
    <!MODALS !>
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



            });
    function verOP(id){        
        $.post(CFG.url + 'recibos/ver_opago/',
            {id:id},
            function(data){                    
                $("#tablaop").html(data.tabla);                                         
                $("#mdlOP").modal("show");
            });                  
    }   
    function verFacturaCompra(id){    
        $.post(CFG.url + 'recibos/ver_factura_compra/',
            {id:id},
            function(data){             
        $("#factura").html(data.tabla);  
        $("#tablarec").html(data.tabla2);               
        $("#mdlFacturaCompra").modal("show"); }); 
    }   
    function borro(id,proveedor){
        $("#hrefBorrar").attr("href","<?php echo base_url()?>recibos/ctacteb/" + id+"/"+proveedor);
        $("#mdlVerBorrar").modal("show");
    }     
</script>            

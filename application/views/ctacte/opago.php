<?php $this->load->helper('form'); ?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" /> 
<style>
.container a:hover, a:visited, a:link, a:active{
    text-decoration: none;
}   
</style>

<div class="container">
    <div class="row"  id="terminado">
        <div class="col-md-12">   
            <a class="btn btn-primary" href="<?php echo base_url(); ?>ctacte/ctacte/<?=$proveedor->id?>">Se Grabo la Orden de pago Corectamente</a>
        </div>
    </div>

    <div class="row" id="principal">
        <div class="col-md-12">
                    <div class="alert alert-danger" id="alerta">
                    <strong>Error</strong> <span id="finError">  </span>
                    </div>
            <div class="panel panel-default">            
                <div class="panel-heading">FACTURAS IMPAGAS - <?=$proveedor->proveedor?></div>
                <input type="hidden" id="id_proveedor" value="<?=$proveedor->id?>>">                        
                <input type="hidden" id="resto" value="0.00">                        
                <input type="hidden" id="id_pago_aux" value="<?=$id_opago?>">                         
                <table class="table">
                  <thead>
                        <tr>
                          <th>Fecha</th>
                          <th>Comprobante</th>                          
                          <th>Total</th>                          
                          <th>Saldo</th>                          
                        </tr>
                  </thead>
                  <tbody>
                        <?php 
                        $total=0;
                        $i=0;
                        foreach($deuda as $cta){ 
                            if($cta->tipo_comp==3)
                                 $cta->saldo=$cta->saldo *-1;               
                            $total=$total + $cta->saldo ;                           
                            ?>	
                                <tr>
                                    <td><?=$cta->fecha ?></td>
                                    <td><?=$cta->letra." (".  $cta->codigo_comp . ") " . $cta->puerto . " -  " . $cta->numero ?></td>
                                    <td><?=number_format($cta->total,2,".",",")?></td>
                                    <input type="hidden" name="compr[<?=$i?>][id_comp]" value="<?=$cta->id_factura?>">
                                    <input type="hidden" name="compr[<?=$i?>][saldo]" value="<?=$cta->saldo?>">
                                    <td align="right"><input style="text-align:right" type="text"  name="compr[<?=$i?>][paga]" value="<?=$cta->saldo;?>"></td>
                                </tr>
                        <?php	
                         $i++;
                        }
                        ?>
                         <tr>
                                    <td colspan="3">Total Adeudado</td>                                    
                                    <td align="right"><?=number_format($total,2,".",",")?></td>
                                    <input type="hidden" id="deudor" value="<?=$total?>">                                                                                                
                                    <input type="hidden" id="cantcomp" name="cantcomp" value="<?=$i?>">
                                </tr>
                  </tbody>
                </table>
            </div>
        </div>
        <?php
        $combo='<select id="combo" class="form-control" name="tipo_pago">';
        foreach($medios_de_pago as $cta) 
            $combo=$combo.'<option value="'.$cta->id.'">'.$cta->mpago.'</option>';        
                    
        $combo=$combo."</select>";
        ?>
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">MEDIO DE PAGOS</div>
                <?php if(isset($mensaje)){?>
                <div class="row">
                    
                </div>
                <?php }?>             
                
                <table class="table">
                  <thead>
                        <tr>
                          <th>Seleccione los medio de pago</th>                                                                     
                          <th> </th> 
                        </tr>
                  </thead>
                  <tbody>
                  <tr>
                        <td><?=$combo ?></td>
                        <td><button type="button" class="btn btn-success" id="ingreso">Seleccionar</button>
                        </td>
                </tr>
                 <tr>                    
                 <td>      
                 <label for="itemPrcU">Fecha de La Orden De Pago</label>
                </td>
                <td>
                          <input type="date" name="itemPrcU" id="opagofecha" class="form-control"/> 
                </td>
                 </tr>
                 
                                                        
                  </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">SALIDAS</div>                               
                <table class="table">
                  <thead>
                        <tr>
                          <th>Medio de Pago</th>
                          <th>Monto</th>                                                    
                          <th>Comprobante</th>                                                    
                          <th>Obs</th>
                          <th>Comp.Transf</th>
                          <th>Cheque Numero</th>
                          <th>Cheque Vence</th>                                                    
                        </tr>
                  </thead>
                  <tbody id="tabla_pagos">      

                  </tbody>
                </table>
            </div>
        </div>

    </div>
    
    <!MODALS !>
    <?php
    $this->load->view('ctacte/frmEfectivo');
    $this->load->view('ctacte/frmTransferencia');
    $this->load->view('ctacte/frmcheques');    
    $this->load->view('ctacte/frmchequespro');    
    $this->load->view('ctacte/frmOtroPago');  
    ?>  
    
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
        $("#alerta").hide();  
        $("#terminado").hide();        
        $("#ingreso").click(function(){                        
            $.post(CFG.url + 'Ajax/medio_pago/',
            {id:$("#combo").val()},
            function(data){    
                $("#otropagotitulo").html(data.nombre.mpago);
                $("#otropagoetiqueta").html(data.nombre.mpago);                                
            });           
            switch($("#combo").val()) {
            case '1':
                $("#efeError").html('');
                $("#efe_comentario").val('');
                $("#efe_importe").val('');
                $("#efectivo").modal("show");
                   break;
            case '2':
                $("#cheque").modal("show");
                    break;
            case '9':
                $("#transferencia").modal("show");                
                    break;   
            case '6':
                $("#chequepro").modal("show");                
                    break;                
            default:                
                $("#otro").modal("show");         
            }
          
    
                                
        });

        $("#bntIngEfe").click(function(){              
            $.post(CFG.url + 'ctacte/ingreso_pago_efectivo/',
            {id_aux:$("#id_pago_aux").val(),
             comentario:$("#efe_comentario").val(),
             importe:$("#efe_importe").val()
            },
            function(data){                           
               if(data.rta==""){
                $("#efectivo").modal("hide");
                recalcular();
                        
               }
               else{
                $("#efeError").html(data.rta);
               }                             
            });           
            
        });
        /*Cheque de terceros*/
        $("#bntIngChe3").click(function(){              
            $.post(CFG.url + 'ctacte/ingreso_pago_cheque3/',
            {id_aux:$("#id_pago_aux").val(),
             che3_nro:$("#che3_nro").val(),
             che3_banco:$("#che3_banco").val(),
             che3_fecha:$("#che3_fecha").val(),
             che3_importe:$("#che3_importe").val(),
             che3_cliente:$("#che3_cliente").val(),
            },
            function(data){                 
               if(data.rta==""){
                $("#cheque").modal("hide");
                recalcular();
                        
               }
               else{
                $("#che3Error").html(data.rta);
               }                             
            });           
            
        });
        /*cheque propio*/   
        $("#bntIngChe").click(function(){                   
            $.post(CFG.url + 'ctacte/ingreso_pago_cheque/',
            {id_aux:$("#id_pago_aux").val(),
             che_nro:$("#che_nro").val(),
             che_banco:$("#che_banco").val(),
             che_fecha:$("#che_fecha").val(),
             che_importe:$("#che_importe").val()             
            },
            function(data){                   
               if(data.rta==""){
                $("#chequepro").modal("hide");
                recalcular();
                        
               }
               else{
                $("#cheError").html(data.rta);
               }                             
            });           
            
        });
        /*trasnfe*/
        $("#bntIngTra").click(function(){                   
            $.post(CFG.url + 'ctacte/ingreso_pago_traf/',
            {id_aux:$("#id_pago_aux").val(),             
             tra_banco:$("#tra_banco").val(),
             tra_comp:$("#tra_comentario").val(),
             tra_importe:$("#tra_importe").val()             
            },
            function(data){                                
               if(data.rta==""){
                $("#transferencia").modal("hide");
                recalcular();
                        
               }
               else{
                $("#traError").html(data.rta);
               }                             
            });           
            
        });

        /*otros*/
        $("#bntIngOtr").click(function(){                   
            $.post(CFG.url + 'ctacte/ingreso_pago_otro/',
            {id_aux:$("#id_pago_aux").val(),             
             otr_comen:$("#otr_comentario").val(),             
             otr_importe:$("#otr_importe").val(),             
             otr_tipo:$("#combo").val(),             
            },
            function(data){ 
                
               if(data.rta==""){
                $("#otro").modal("hide");
                recalcular();
                        
               }
               else{
                $("#otrError").html(data.rta);
               }                             
            });           
            
        });
        recalcular();    
    });
    function recalcular(){
        $.post(CFG.url + 'ctacte/recalcular/',
            {id_aux:$("#id_pago_aux").val()},
            function(data){  
                $("#tabla_pagos").html(data.tabla);
            });           
    }
    function borro(id){
        $.post(CFG.url + 'ctacte/borro_opago_aux/',
            {id_aux:id},
            function(data){  
                recalcular();
            });           
    }
    function guardar(){
        var cancela='';
        for(i=0;i<$("#cantcomp").val();i++){
            if(cancela=='')
                cancela=$("input[name='compr["+i+"][id_comp]']").val() + "_" + $("input[name='compr["+i+"][saldo]']").val() +"_"+$("input[name='compr["+i+"][paga]']").val();
            else
                cancela=cancela+";"+$("input[name='compr["+i+"][id_comp]']").val() + "_" + $("input[name='compr["+i+"][saldo]']").val() +"_"+$("input[name='compr["+i+"][paga]']").val();
        }   
        $("#alerta").hide();   
        $.post(CFG.url + 'ctacte/finalizar_opago/',
            {id_aux:$("#id_pago_aux").val(),             
             compro:cancela,
             id_proveedor:$("#id_proveedor").val(),             
             opagofecha:$("#opagofecha").val(),
             total_fin:$("#total_fin").val()
            },
            function(data){                 
               if(data.rta==""){
                $("#otro").modal("hide");
                $("#principal").hide();    
                $("#terminado").show();    
                        
               }
               else{
                $("#alerta").show();
                $("#finError").html(data.rta);
               }                             
            });  
    }

    
</script>    

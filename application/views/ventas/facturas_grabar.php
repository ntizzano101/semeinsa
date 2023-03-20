
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" /> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
   

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Venta - Ingresar</div>
                <div class="panel-body">
                    <!--method="" action="<?php echo base_url(); ?>ventas/grabar" onSubmit="habiliar()"-->
                    <div role="search">
                          <div class="row" id="mensaje">

                          </div>   
                        <div class="row">
                            <div class="col-md-6">
                                
                                <label for="empresa">Empresa</label>
                                <select name="empresa" id="empresa" class="form-control">
                                    <option value="">Seleccione una empresa</option>
                                <?php foreach ($lista_empresas as $emp) {?>
                                    <option value="<?=$emp->id_empresa?>"
                                        <?php if ($emp->id_empresa==$factura->empresa){ echo " selected ";}?> >
                                        <?=$emp->razon_soc?>
                                    </option>
                                <?php }?>        
                                </select>
                                <div>
                                    <small><font color="red" id="errEmp">                                       
                                    </font></small>
                                </div>                            
                            </div>                                                            
                            <div class="col-md-6">                                   
                                <label for="cod_afip">Tipo de comprobante</label>
                                    <select name="cod_afip" id="cod_afip" class="form-control">
                                        <option value="">Seleccione un tipo de comprobante</option>
                                    </select>
                                    <div>
                                        <small><font color="red" id="errCod_afip">                                        
                                        </font></small>
                                    </div>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Cliente">Cliente</label>
                                <select name="cliente" id="cliente" class="form-control">
                                    <option value="">Seleccione un Cliente</option>
                                <?php foreach ($lista_clientes as $prov) {?>
                                    <option value="<?=$prov->id?>"
                                        <?php if ($prov->id==$factura->cliente){ echo " selected ";}?>     
                                        >
                                        <?=$prov->cliente?>
                                    </option>
                                <?php }?>        
                                </select>
                                <div>
                                    <small><font color="red" id="errCli">                                    
                                    </font></small>
                                </div>                                  
                            </div>                            
                            <div class="col-md-3">                                                                   
                                        
                                            <label>Puerto</label>               
                                            <select name="factnro1" id="factnro1" class="form-control">
                                            </select> 
                                            <div>
                                                <small><font color="red" id="errPuerto">                                    
                                                </font></small>
                                </div>                                             
                            </div>                                                                    
                            <div class="col-md-3">            
                                        <label>Nro Comprobante</label>     
                                            <input type="text" name="factnro2" id="factnro2" 
                                             value="" class="form-control" readonly />
                                        
                                        
                            </div>  
                        </div>      
                        <div class="row">
                            <div class="col-md-6">            
                                    <label for="fecha">Fecha</label>
                                    <input type="date" name="fecha" id="fecha" 
                                        value="" class="form-control"/> 
                                    <div>
                                        <small><font color="red" id="errFecha">                                        
                                        </font></small>
                                    </div>
                                </div>
                                <div class="col-md-6">  
                                    <label for="Cuit">Cuit</label>
                                    <input type="text" name="cuit" id="cuit" class="form-control"
                                        value="" readonly="readonly">   
                                    <div>
                                        <small><font color="red" id="errCuit">                                        
                                        </font></small>
                                    </div>                                 
                                </div>                               
                        </div>    
                        <div class="row">
                            <div class="col-md-6">            
                                    <label for="cond">Condicion Frente al Iva</label>
                                    <input type="text" name="proviva" id="proviva" 
                                        value="" readonly="readonly"  class="form-control"/>                                     
                                    <div>
                                        <small><font color="red" id="proviva">                                        
                                        </font></small>
                                    </div>                                 
                                        
                            </div>
                                <div class="col-md-6">  
                                    <label for="Direccion">Direccion</label>
                                    <input type="text" name="provdir" id="provdir" class="form-control"
                                        value="" readonly="readonly">                                       
                                </div>                               
                        </div>    
                                        
                        
                        
                        <br>
                        <hr>  
                        
                        <div id="tbFactura">
                            <input type=button id="btnVerMdItem" value="Nuevo item" onclick="verMdItem()" />
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>código</th>
                                        <th>descripción</th>
                                        <th>cantidad</th>
                                        <th>precio u</th>
                                        <th>iva</th>
                                        <th>total</th>
                                        <th>acción</th>
                                    </tr>
                                </thead>
                                
                                <tbody id="cpFl">
                                    <?php 
                                    $lista_items= json_decode($factura->items,true);
                                    if(count($lista_items)>0){
                                        $i=0;
                                        foreach ($lista_items as $un_item) {
                                        ++$i;
                                        ?>
                                    <tr>
                                        <td><?=$un_item["cod"]?>
                                        <td><?=$un_item["desc"]?>
                                        <td><?=$un_item["cant"]?>
                                        <td><?=$un_item["prcu"]?>
                                        <td><?=$un_item["iva"]?>
                                        <td><?=$un_item["total"]?>
                                        <td><a class="btn-default fa fa-eraser" title="Borrar"
                                            onclick="quitaItem(<?=$i?>)">
                                            
                                    <?php
                                        
                                        }
                                    }else{
                                    ?>
                                    <tr>
                                        <td colspan="7" align="center" >Sin Items</td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    
                                        
                                    
                                </tbody>
                                
                            </table>
                            
                        </div>
                        
                        <br>
                        <hr>  
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="formaPago">Forma de pago</label>
                                    <select name="formaPago" id="formaPago" class="form-control">
                                        <option value=""
                                             <?php if ($factura->formaPago==""){ echo " selected ";}?>  
                                            >Seleccione una forma de pago</option>
                                        <option value="0" 
                                            <?php if ($factura->formaPago=="0"){ echo " selected ";}?>    
                                            >Contado</option>
                                        <option value="1"
                                           <?php if ($factura->formaPago=="1"){ echo " selected ";}?>     
                                            >Cuenta corriente</option>
                                    </select>
                                    <div >
                                        <small><font color="red" id="errFormaPago">                                        
                                        </font></small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                            <label for="intImpNeto">Importe Neto</label>
                            <input type="text" name="intImpNeto" id="intImpNeto" 
                                value="" class="form-control" readonly/>
                            
                            <br> 
                            
                            <label for="intIva">IVA</label>
                            <input type="text" name="intIva" id="intIva" 
                                value="<?=$factura->intIva?>" class="form-control" readonly/>
                            
                            <br>
                            <!--
                            <label for="intPerIngB">Percepción Ing. Brutos</label>
                            <input type="text" name="intPerIngB" id="intPerIngB" class="form-control"/>
                            <div id="errIntPerIngB">
                                <small><font color="red">
                                    <?php if (isset($error->intPerIngB)){echo $error->intPerIngB;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="intPerIva">Percepción IVA</label>
                            <input type="text" name="intPerIva" id="intPerIva" class="form-control"/>
                            <div id="errIntPerIva">
                                <small><font color="red">
                                    <?php if (isset($error->intPerIva)){echo $error->intPerIva;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="intPerGnc">Percepción Ganancias</label>
                            <input type="text" name="intPerGnc" id="intPerGnc" class="form-control"/>
                            <div id="errIntPerGnc">
                                <small><font color="red">
                                    <?php if (isset($error->intPerGnc)){echo $error->intPerGnc;}?> 
                                </font></small>
                            </div>
                            <br>
                            
                            <label for="intPerStaFe">Percepción Santa Fé</label>
                            <input type="text" name="intPerStaFe" id="intPerStaFe" class="form-control"/>
                            <div id="errIntPerStaFe">
                                <small><font color="red">
                                    <?php if (isset($error->errIntPerStaFe)){echo $error->errIntPerStaFe;}?> 
                                </font></small>
                            </div>
                            <br>
                            -->
                            <label for="intImpExto">Importe Exento</label>
                            <input type="text" name="intImpExto" id="intImpExto" value="<?=$factura->intImpExto?>" readonly="readonly" class="form-control"/>
                            
                            <br>
                            <!--
                            <label for="intConNoGrv">Conc. no Gravados</label>
                            <input type="text" name="intConNoGrv" id="intConNoGrv" class="form-control"/>
                            <div id="errIntConNoGrv">
                                <small><font color="red">
                                    <?php if (isset($error->intConNoGrv)){echo $error->intConNoGrv;}?> 
                                </font></small>
                            </div>
                            <br>
                                -->
                            <label for="intTotal">Total</label>
                            <input type="text" name="intTotal" id="intTotal" value="0" readonly class="form-control"/>
                            <div>
                                <small><font color="red" id="errTotal">
                                    
                                </font></small>
                            </div>
                            <br>
                            
                            </div>
                            
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <label for="obs">Observación</label>
                                <textarea name="obs" id="obs" style="min-width: 100%" class="form-control"></textarea>

                            </div>
                            
                        </div>
                        
                        <br><br>
                        
                        <input type="hidden" id="items" name="items" value='<?=$factura->items?>'>    
                        <button type="botton" id="aceptar" class="btn btn-primary" onclick="grabar()">Grabar</button>
                        <a href="<?php echo base_url(); ?>/ventas/listar"  class="btn btn-primary">Volver</a>
                    
                                </div>  
                </div>
                        
                        
                
              
                    
                    
            </div>
        </div>
    </div>
    
    
    <!MODALS !>
    <div class="modal fade" id="mdlItem">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title">Item</h1>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2">   
                    </div>
                    
                    <div class="col-md-8">  
                        
                        <div class="form-inline">
                            <input type="text" name="itemTxtBsq" id="itemTxtBsq" placeholder="Filtrar item" class="form-control"/>
                            <input type="button" onclick="buscaItem()" id class="btn btn-default" value="Filtrar" class="form-control"/>
                            <select name="itemBsq" id="itemBsq" class="form-control">
                                    <option value="">Sin items</option>
                            </select>
                            
                        </div>
                        
                        
                    <hr>    
                        
                        <div class="row">
                            <label for="itemCod">Código</label>
                            <input type="hidden" name="itemidArt" id="itemidArt" class="form-control"/>
                            <input type="text" name="itemCod" id="itemCod" class="form-control"/> 
                        </div>

                        <div class="row">
                            <label for="itemDesc">Descripción</label>
                            <input type="text" name="itemDesc" id="itemDesc" class="form-control"/> 
                        </div>

                        <div class="row">
                            <label for="itemCant">Cantidad</label>
                            <input type="text" name="itemCant" id="itemCant" class="form-control"/> 
                        </div>

                        <div class="row">
                            <label for="itemPrcU">Precio Unidad</label>
                            <input type="text" name="itemPrcU" id="itemPrcU" class="form-control"/> 
                        </div>

                        <div class="row">
                            <label for="itemIva">IVA</label>
                            <select name="itemIva" id="itemIva" class="form-control">
                             <!--
                                <option value="0" selected="true" >0003 (0%)</option>
                               
                                
                                <option value="0.27">0006 (26%)</option>
                                <option value="0.05">0008 (5%)</option>
                                <option value="0.025">0009 (2.5%)</option>
                                -->
                                <option value="0.21">0005 (21%)</option>
                                <option value="0">Exento</option>
                            </select>
                        </div>

                        <div class="row">
                            <label for="itemTotal">Total</label>
                            <input type="text" readonly name="itemTotal" id="itemTotal" class="form-control"  /> 
                        </div>
                        
                    </div>
                    
                    <div class="col-md-2">   
                    </div>
                    
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="bntIngItem">Ingresar</button>
                    
                </a>
            </div>

          </div>
        </div>
    </div>    
    
    <!MODALS !>
    <div class="modal fade" id="mdlOk">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title"></h1>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <label id="msjGuardado"></label>   
                        Se Guardo El Comprobante
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                
                <button type="button" class="btn btn-primary" data-dismiss="modal" 
                onClick="window.location.href = CFG.url + 'Ventas/'">Ok</button>
                
                    
                </a>
            </div>

          </div>
        </div>
    </div>    
    
</div>
    
    
    
</div>
<p id="errores"></p>


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
    
    
    
   // $('#factnro1').mask('99999');
    $('#factnro2').mask('99999999');

    $.post(CFG.url + 'Ajax/busca_cliente/',
        {id:$("#cliente").val()},
        function(data){
            $("#provdir").val(data.domicilio);
            $("#proviva").val(data.cond_iva);
            $("#cuit").val(data.cuit);
        });
        
    if($("#cliente").val()==="" || $("#empresa").val()===""){
        $("#cod_afip").html('<option value="">Sin tipos de comprobante</option>');
        $("#factnro1").html('<option value="">Sin Puerto</option>');
    }else{
        $.post(CFG.url + 'Ajax/busca_tp_comprob_cl/',
        {proveedor:$("#cliente").val(),empresa:$("#empresa").val()},
        function(data){
            $("#cod_afip").html(data.combo);
            $("#errCod_afip").html("");
        });
    }  
    
    
    
    $("#cliente").change(function(){
        $("#errProv").html("");
        $.post(CFG.url + 'Ajax/busca_cliente/',
            {id:$(this).val()},
            function(data){
                $("#provdir").val(data.domicilio);
                $("#proviva").val(data.cond_iva);
                $("#cuit").val(data.cuit);
                $("#itemIva").html("")
                if($.trim(data.cond_iva)=="Consumidor Final" || $.trim(data.cond_iva)=="Exento"){
                    $("#itemIva").html("<option value='0' Selected='Selected'>Exento</option>");
                }
                else{
                    $("#itemIva").html('<option value=".105">10,5%</option><option value=".21" Selected="Selected">21%</option>');
                }                
            });
        if($(this).val()==="" || $("#empresa").val()===""){
            $("#cod_afip").html('<option value="">Sin tipos de comprobante</option>');
            $("#factnro1").html('<option value="">Sin Puerto</option>');
        }else{        
            $.post(CFG.url + 'Ajax/busca_tp_comprob_cl/',
            {cliente:$(this).val(),empresa:$("#empresa").val()},
            function(data){                
                $("#cod_afip").html(data.combo);
                $("#errCod_afip").html("");
                $("#factnro1").html("");
                $.post(CFG.url + 'Ajax/busca_puertos/',
                     {id:$("#cod_afip").val(),empresa:$("#empresa").val()},
                     function(data){
                      $("#factnro1").html(data.combo); 
                      $("#errPuerto").html("");             
                });     
            });
           
        }    
            
    });

    
    $("#empresa").change(function(){
        $("#errEmp").html("");
        if($(this).val()==="" || $("#cliente").val()===""){
            $("#cod_afip").html('<option value="">Sin tipos de comprobante</option>');
            
        }else{
            $.post(CFG.url + 'Ajax/busca_tp_comprob_cl/',
            {cliente:$("#cliente").val(),empresa:$(this).val()},           
            function(data){
                $("#cod_afip").html(data.combo);
                $("#errCod_afip").html("");
            });
        }    
            
    });

    $("#cod_afip").change(function(){
        $("#factnro1").html("");   
        $.post(CFG.url + 'Ajax/busca_puertos/',
            {id:$(this).val(),empresa:$("#empresa").val()},
            function(data){                                  
                $("#factnro1").html(data.combo);              
            });       
    });


    
    //$('#factnro1').keyup(function(){ $("#errFactnro").html("");});
    $('#factnro2').keyup(function(){ $("#errFactnro").html("");});
    $('#fecha').keyup(function(){ $("#errFecha").html("");});
    $('#fecha').change(function(){ $("#errFecha").html("");});
    $('#cuit').keyup(function(){ $("#errCuit").html("");});
    $('#formaPago').change(function(){ $("#errFormaPago").html("");})
    
    $("#itemCant").keyup(function(){ calcPrItem(); });
    $("#itemPrcU").keyup(function(){ calcPrItem(); });
    $("#itemIva").change(function(){ calcPrItem(); });
    
    $("#intImpNeto").keyup(function(){$("#errIntImpNeto").html(""); calcTotal(); });
    $("#intImpNeto").change(function(){$("#errIntImpNeto").html(""); calcTotal(); })
    $("#intIva").keyup(function(){$("#errIntIva").html(""); calcTotal(); });
    $("#intIva").change(function(){$("#errIntIva").html(""); calcTotal(); });
    $("#intPerIngB").keyup(function(){ $("#errIntPerIngB").html("");calcTotal(); });
    $("#intPerIngB").change(function(){ $("#errIntPerIngB").html("");calcTotal(); });
    $("#intPerIva").keyup(function(){$("#errIntPerIva").html("");calcTotal(); });
    $("#intPerIva").change(function(){$("#errIntPerIva").html("");calcTotal(); });
    $("#intPerGnc").keyup(function(){$("#errIntPerGnc").html(""); calcTotal(); });
    $("#intPerGnc").change(function(){$("#errIntPerGnc").html(""); calcTotal(); });
    $("#intPerStaFe").keyup(function(){$("#errIntPerStaFe").html(""); calcTotal(); });
    $("#intImpExto").keyup(function(){$("#errIntConNoGrv").html(""); calcTotal(); });
    $("#intConNoGrv").change(function(){$("#errIntImpExto").html(""); calcTotal(); });
    $("#intTotal").change(function(){$("#errIntTotal").html(""); calcTotal(); });
    $("#aceptar").click(function(){
        document.getElementById('empresa').disabled=false;
        document.getElementById('cliente').disabled=false;
        if(isNaN($("#intImpNeto").val())){$("#intImpNeto").val("0")}
        if(isNaN($("#intIva").val())){$("#intIva").val("0")}
        if(isNaN($("#intImpExto").val())){$("#intImpExto").val("0")}
    });
    $("#bntIngItem").click(function(){
        if(!(isNaN($("#itemTotal").val()))){
            $.post(CFG.url + 'Ajax/carga_item/',
                {itemCod:$("#itemCod").val(),
                itemDesc:$("#itemDesc").val(),
                itemCant:$("#itemCant").val(),
                itemPrcU:$("#itemPrcU").val(),
                itemIva:$("#itemIva").val(),
                itemidArt:$("#itemidArt").val(),
                textIva:$("#itemIva option:selected").text(),
                itemTotal:$("#itemTotal").val(),
                items:$("#items").val()
                },
                function(data){
                    $("#items").val(data.items);
                    $("#cpFl").html(data.cpFl);
                    $("#intImpNeto").val(data.intImpNeto);
                    $("#intImpExto").val(data.intImpExto);
                    $("#intIva").val(data.intIva);
                    calcTotal();
                    $("#mdlItem").modal("hide");
                });
        }
        
        //$("#mdlItem").modal("hide"); 
    });  
    
    
    $("#itemBsq").change(function(){
        $.post(CFG.url + 'Ajax/busca_item/',
            {id:$(this).val()},
            function(data){
                $("#itemCod").val(data.codigo);
                $("#itemDesc").val(data.articulo);
                $("#itemPrcU").val(data.precio1);
                $("#itemidArt").val(data.id_art);
                calcPrItem();
            });
         
    });
    
});


function verMdItem(){
    $("#itemidArt").val("");
    $("#itemCod").val("");
    $("#itemDesc").val("");
    $("#itemCant").val("");
    $("#itemPrcU").val("");
    //$("#itemIva").val(0);
    $("#itemTotal").val("");
    $("#itemTxtBsq").val("");
    $("#mdlItem").modal("show");
}

function buscaItem(){
    $.post(CFG.url + 'Ajax/busca_combo_item/',
            {item:$("#itemTxtBsq").val()},
            function(data){
                $("#itemBsq").html(data.combo);
                $("#itemCod").val(data.codigo);
                $("#itemDesc").val(data.articulo);
                $("#itemPrcU").val(data.precio1);
                $("#itemidArt").val(data.id_art);
                calcPrItem();
            });
}

function quitaItem(id){
    $.post(CFG.url + 'Ajax/quita_item/',
        {id:id,
        items:$("#items").val()
        },
        function(data){
            $("#items").val(data.items);
            $("#cpFl").html(data.cpFl);
            $("#intImpNeto").val(data.intImpNeto);
            $("#intIva").val(data.intIva);
            calcTotal();
        });
}

function calcPrItem(){
    cantidad=parseFloat($("#itemCant").val());
    precio=parseFloat($("#itemPrcU").val());
    iva=parseFloat($("#itemIva").val()) ;    
    total=cantidad * precio * (1 + iva);
    if(isNaN(total))
    {$("#itemTotal").val("");}
    else{$("#itemTotal").val(total);}        
}


function calcTotal(){
    
    intImpNeto=parseFloat($("#intImpNeto").val());
    intIva=parseFloat($("#intIva").val()) ;  
    intPerIngB=parseFloat($("#intPerIngB").val());
    intPerIva=parseFloat($("#intPerIva").val());
    intPerGnc=parseFloat($("#intPerGnc").val());
    intPerStaFe=parseFloat($("#intPerStaFe").val());
    intImpExto=parseFloat($("#intImpExto").val());
    intConNoGrv=parseFloat($("#intConNoGrv").val());  
    total=0.00;
    if(!(isNaN(intImpNeto))){total+=intImpNeto;}
    if(!(isNaN(intIva))){total+=intIva;}
    if(!(isNaN(intPerIngB))){total+=intPerIngB;}
    if(!(isNaN(intPerIva))){total+=intPerIva;}
    if(!(isNaN(intPerGnc))){total+=intPerGnc;}
    if(!(isNaN(intPerStaFe))){total+=intPerStaFe;}
    if(!(isNaN(intImpExto))){total+=intImpExto;}
    if(!(isNaN(intConNoGrv))){total+=intConNoGrv;}
    
    $("#intTotal").val(total.toFixed(2));    
    //Si el total no es cero entonces tengo que bloquar Empresa y Cliente
    if(total != 0.00){
        document.getElementById('empresa').disabled=true;
        document.getElementById('cliente').disabled=true;
        
    } 
    else    
    {
        document.getElementById('empresa').disabled=false;
        document.getElementById('cliente').disabled=false;
        
    }
}
function habilitar(){
        document.getElementById('empresa').disabled=false;
        document.getElementById('cliente').disabled=false;
}
function grabar(){
    proceso=true;    
    $("#errEmp").html("");
    $("#errCli").html("");
    $("#errCod_afip").html("");
    $("#errPuerto").html("");
    $("#errFecha").html("");
    $("#errTotal").html("");
    $("#errFormaPago").html("");
    if($("#empresa").val()==""){$("#errEmp").html("Seleccione Una Empresa");proceso=false;}
    if($("#cliente").val()==""){$("#errCli").html("Seleccione Un Clente");proceso=false;}
    if($("#cod_afip").val()==""){$("#errCod_afip").html("Seleccione Un Tipo De Comprobante");proceso=false;}
    if(document.getElementById('factnro1').value==''){$("#errPuerto").html("Seleccione Un Puerto/Punto de Venta");proceso=false;}
    if($("#fecha").val()==""  ||  $("#fecha").val().length!=10){$("#errFecha").html("Fecha Incorrecta");proceso=false;}
    if($("#intTotal").val()=="0"  || $("#intTotal").val()==""){$("#errTotal").html("El Total No Puede Ser Cero");proceso=false;}
    if($("#formaPago").val()==""){$("#errFormaPago").html("Seleccione Forma de Pago");proceso=false;}
    if(proceso===true){             ;
        $.post(CFG.url + 'Ventas/grabar/',
            {empresa:$('#empresa').val(),
            cliente:$('#cliente').val(),
            factnro1:$('#factnro1').val(),
            factnro2:0,
            fecha:$('#fecha').val(),            
            cod_afip:$('#cod_afip').val(),
            formaPago:$('#formaPago').val(),
            intImpNeto:$('#intImpNeto').val(),
            intIva:$('#intIva').val(),
            intPerIngB:$('#intPerIngB').val(),
            intPerIva:$('#intPerIva').val(),
            intPerGnc:$('#intPerGnc').val(),
            intPerStaFe:$('#intPerStaFe').val(),
            intImpExto:$('#intImpExto').val(),
            intConNoGrv:$('#intConNoGrv').val(),
            intTotal:$('#intTotal').val(),
            obs:$('#obs').val(),
            cuit:$('#cuit').val(),
            items:$('#items').val() } ,
            function(data){
                $('#errores').html('');
                $('#errores').html(data);
                    if(data.error==""){
                        
                        $("#factnro2").val(data.numero2);
                        $('#empresa').val('');
                        $('#cliente').val('');
                    }
                    else{
                        $("#factnro2").val('');
                    }
                    $("#mdlOk").modal("show");

                    
            });
    }
    else
        return false;
}
    
</script>
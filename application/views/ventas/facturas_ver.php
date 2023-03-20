
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" /> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
   

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Factura - Ver</div>
                <div class="panel-body">
                    <form role="search" method="POST" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="empresa">Empresa</label> 
                                <input type="text" name="empresa" id="empresa" class="form-control" 
                                   value="<?=$factura->empresa?>" disabled /> 
                                
                            <br>
                                <label for="prov_nombre">Proveedor</label> 
                                <input type="text" name="prov_nombre" id="prov_nombre" class="form-control" 
                                   value="<?=$factura->prov_nombre?>" disabled /> 
                            <br>
                            
                            <label for="prov_dir">Dirección</label>
                            <input type="text" name="prov_dir" id="prov_dir" class="form-control" 
                                   value="<?=$factura->prov_dir?>" disabled /> 
                            <br>
                            <label for="prov_iva">Código IVA</label>
                            <input type="text" name="prov_iva" id="prov_iva" class="form-control" 
                                   value="<?=$factura->prov_iva?>" disabled /> 
                            <br>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Nro Factura</label>
                                    </div>
                                    <br>
                                    <div class="col-md-3 ">
                                        <input type="text" name="factnro1" id="factnro1" class="form-control"
                                            value="<?=$factura->puerto?>" disabled />
                                    </div>
                                    <div class="col-md-1">
                                        <label>-</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="factnro2" id="factnro2" class="form-control"
                                            value="<?=$factura->numero?>" disabled  />
                                    </div>
                                </div>
                                
                                <br>
                                
                                <label for="fecha">Fecha</label>
                                <input type="text" name="fecha" id="fecha" class="form-control" 
                                       value="<?=$factura->fc_format?>" disabled/> 
                                
                                <br>    
                                    
                                <label for="per_iva">Período de IVA</label>
                                <input type="text" name="per_iva" id="periva" class="form-control"
                                       value="<?=$factura->pi_mes?>/<?=$factura->pi_anio?>" disabled/>   
                                <br>      
                                
                                <label for="cod_afip">Tipo de comprobante</label>
                                <input type="text" name="cod_afip" id="cod_afip" class="form-control"
                                       value="<?=$factura->tp_comprob?>" disabled/>  
                            </div>    
                                
                        </div>
                        
                        <br>
                        <hr>  
                        
                        <div id="tbFactura">
                           
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>código</th>
                                        <th>descripción</th>
                                        <th>cantidad</th>
                                        <th>precio u</th>
                                        <th>iva</th>
                                        <th>total</th>
                                    </tr>
                                </thead>
                                
                                <tbody id="cpFl">
                                    <tr>
                                        <td colspan="7" align="center" >Sin Items</td>
                                    </tr>
                                        
                                    
                                </tbody>
                                
                            </table>
                            
                        </div>
                        
                        <br>
                        <hr>  
                        
                        <?php $frmPg="";
                        if ($factura->ctacte=="0"){ $frmPg="Contado";}
                        if ($factura->ctacte=="1"){ $frmPg="Cuenta corriente";}
                        ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="formaPago">Forma de pago</label>
                                     <input type="text" name="cod_afip" id="cod_afip" class="form-control"
                                       value="<?=$frmPg?>" disabled/> 
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                            <label for="intImpNeto">Importe Neto</label>
                           <input type="text" name="intImpNeto" id="intImpNeto" class="form-control"
                                value="<?=$factura->neto?>" disabled/>  
                            <br> 
                            
                            <label for="intIva">IVA</label>
                            <input type="text" name="intIva" id="intIva" class="form-control"
                                value="<?=$factura->iva?>" disabled/>  
                            <br>
                            
                            <label for="intPerIngB">Percepción Ing. Brutos</label>
                            <input type="text" name="intPerIngB" id="intPerIngB" class="form-control"
                                value="<?=$factura->per_ing_bto?>" disabled/>  
                            <br>
                            
                            <label for="intPerIva">Percepción IVA</label>
                            <input type="text" name="intPerIva" id="intPerIva" class="form-control"
                                value="<?=$factura->per_iva?>" disabled/>  
                            <br>
                            
                            <label for="intPerGnc">Percepción Ganancias</label>
                            <input type="text" name="intPerGnc" id="intPerGnc" class="form-control"
                                value="<?=$factura->per_ganancia?>" disabled/>  
                            <br>
                            
                            <label for="intPerStaFe">Percepción Santa Fé</label>
                            <input type="text" name="intPerStaFe" id="intPerStaFe" class="form-control"
                                value="<?=$factura->per_stafe?>" disabled/>
                            <br>
                            
                            <label for="intImpExto">Importe excento</label>
                            <input type="text" name="intImpExto" id="intImpExto" class="form-control"
                                value="<?=$factura->excento?>" disabled/>
                            <br>
                            
                            <label for="intConNoGrv">Conc. no Gravados</label>
                            <input type="text" name="intConNoGrv" id="intConNoGrv" class="form-control"
                                value="<?=$factura->con_nograv?>" disabled/>  
                            <br>
                            
                            <label for="intTotal">Total</label>
                            <input type="text" name="intTotal" id="intTotal" class="form-control" 
                                value="<?=$factura->total?>" disabled/>  
                            <br>
                            
                            </div>
                            
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <label for="obs">Observación</label><br>
                                <?=nl2br($factura->observacion)?>
                                </div>
                            
                        </div>
                        
                        <br><br>
                        
                        
                        <button type="submit" class="btn btn-primary">Volver</button>
                    
                    </form>  
                </div>
                    
            </div>
        </div>
    </div>
    
</div>
 <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Clientes - Ver</div>
                <div class="panel-body">
                    <form role="search" method="POST" action="<?php echo base_url(); ?>clientes">
                        <div class="form-group">
                            <label for="nombre">Cliente 
                            </label> 
                            <input type="text" name="nombre" id="nombre" class="form-control" 
                                   value="<?=$cliente->cliente?>" disabled />
                            
                        <?php if ($cliente->domicilio !="" ){ ?> 
                            <label for="direccion">Dirección 
                            </label> 
                            <input type="text" name="direccion" id="direccion" class="form-control" 
                                   value="<?=$cliente->domicilio?>" disabled />
                        <?php }?>    
                        
                        <?php if ($cliente->telefonos !="" ){ ?> 
                            <label for="telefonos">Telefonos 
                            </label> 
                            <input type="text" name="telefonos" id="telefonos" class="form-control" 
                                   value="<?=$cliente->telefonos?>" disabled />
                        <?php }?>  
                            
                        <?php if ($cliente->email !="" ){ ?> 
                            <label for="email">Email 
                            </label> 
                            <input type="text" name="email" id="email" class="form-control" 
                                   value="<?=$cliente->email?>" disabled />
                        <?php }?>    
                            
                        <?php if ($cliente->cuit !="" ){ ?> 
                            <label for="cuit">Cuit 
                            </label> 
                            <input type="text" name="cuit" id="cuit" class="form-control" 
                                   value="<?=$cliente->cuit?>" disabled />
                        <?php }?>    
                        
                        <?php if ($cliente->cdiva_nombre !="" ){ ?> 
                            <label for="cdiva_nombre">Iva 
                            </label> 
                            <input type="text" name="cdiva_nombre" id="cdiva_nombre" class="form-control" 
                                   value="<?=$cliente->cdiva_nombre?>" disabled />
                        <?php }?>    
                            
                        <?php if ($cliente->localidad !="" ){ ?> 
                            <label for="localidad">Localidad 
                            </label> 
                            <input type="text" name="localidad" id="localidad" class="form-control" 
                                   value="<?=$cliente->localidad?>" disabled />
                        <?php }?>  
                            
                        <?php if ($cliente->cp !="" ){ ?> 
                            <label for="cp">Código postal  
                            </label> 
                            <input type="text" name="cp" id="cp" class="form-control" 
                                   value="<?=$cliente->cp?>" disabled />
                        <?php }?> 
                            
                        <?php if ($cliente->empresa_nombre !="" ){ ?> 
                            <label for="empresa_nombre">Empresa  
                            </label> 
                            <input type="text" name="empresa_nombre" id="empresa_nombre" class="form-control" 
                                   value="<?=$cliente->empresa_nombre?>" disabled />
                        <?php }?>    
                          
                        <?php if ($cliente->dni !="" ){ ?> 
                            <label for="dni">DNI
                            </label> 
                            <input type="text" name="dni" id="dni" class="form-control" 
                                   value="<?=$cliente->dni?>" disabled />
                        <?php }?>
                            
                        <?php if ($cliente->etiqueta_nombre !="" ){ ?> 
                            <label for="etiqueta_nombre">Etiqueta
                            </label> 
                            <input type="text" name="etiqueta_nombre" id="etiqueta_nombre" class="form-control" 
                                   value="<?=$cliente->etiqueta_nombre?>" disabled />
                        <?php }?>    
                            
                        <?php if ($cliente->rz !="" ){ ?> 
                            <label for="rz">Razón social 
                            </label> 
                            <input type="text" name="rz" id="rz" class="form-control" 
                                   value="<?=$cliente->rz?>" disabled />
                        <?php }?>    
                            
                        <?php if ($cliente->baja !="" ){ ?> 
                            <label for="baja">Dado de baja 
                            </label> 
                            <input type="text" name="baja" id="baja" class="form-control" 
                                   value="<?=$cliente->fecha_baja?>" disabled />
                        <?php }?>    
                        </div>
                        <button type="submit" class="btn btn-primary">Volver</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
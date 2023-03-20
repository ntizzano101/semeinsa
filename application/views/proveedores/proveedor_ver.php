 <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Proveedores - Ver</div>
                <div class="panel-body">
                    <form role="search" method="POST" action="<?php echo base_url(); ?>proveedores">
                        <div class="form-group">
                            <label for="nombre">Proveedor 
                            </label> 
                            <input type="text" name="nombre" id="nombre" class="form-control" 
                                   value="<?=$proveedor->proveedor?>" disabled />
                            
                        <?php if ($proveedor->domicilio !="" ){ ?> 
                            <label for="direccion">Dirección 
                            </label> 
                            <input type="text" name="direccion" id="direccion" class="form-control" 
                                   value="<?=$proveedor->domicilio?>" disabled />
                        <?php }?>    
                        
                        <?php if ($proveedor->telefonos !="" ){ ?> 
                            <label for="telefonos">Telefonos 
                            </label> 
                            <input type="text" name="telefonos" id="telefonos" class="form-control" 
                                   value="<?=$proveedor->telefonos?>" disabled />
                        <?php }?>  
                            
                        <?php if ($proveedor->email !="" ){ ?> 
                            <label for="email">Email 
                            </label> 
                            <input type="text" name="email" id="email" class="form-control" 
                                   value="<?=$proveedor->email?>" disabled />
                        <?php }?>    
                            
                        <?php if ($proveedor->cuit !="" ){ ?> 
                            <label for="cuit">Cuit 
                            </label> 
                            <input type="text" name="cuit" id="cuit" class="form-control" 
                                   value="<?=$proveedor->cuit?>" disabled />
                        <?php }?>    
                        
                        <?php if ($proveedor->cdiva_nombre !="" ){ ?> 
                            <label for="cdiva_nombre">Iva 
                            </label> 
                            <input type="text" name="cdiva_nombre" id="cdiva_nombre" class="form-control" 
                                   value="<?=$proveedor->cdiva_nombre?>" disabled />
                        <?php }?>    
                            
                        <?php if ($proveedor->localidad !="" ){ ?> 
                            <label for="localidad">Localidad 
                            </label> 
                            <input type="text" name="localidad" id="localidad" class="form-control" 
                                   value="<?=$proveedor->localidad?>" disabled />
                        <?php }?>  
                            
                        <?php if ($proveedor->cp !="" ){ ?> 
                            <label for="cp">Código postal  
                            </label> 
                            <input type="text" name="cp" id="cp" class="form-control" 
                                   value="<?=$proveedor->cp?>" disabled />
                        <?php }?> 
                            
                        <?php if ($proveedor->empresa_nombre !="" ){ ?> 
                            <label for="empresa_nombre">Empresa  
                            </label> 
                            <input type="text" name="empresa_nombre" id="empresa_nombre" class="form-control" 
                                   value="<?=$proveedor->empresa_nombre?>" disabled />
                        <?php }?>    
                          
                        <?php if ($proveedor->dni !="" ){ ?> 
                            <label for="dni">DNI
                            </label> 
                            <input type="text" name="dni" id="dni" class="form-control" 
                                   value="<?=$proveedor->dni?>" disabled />
                        <?php }?>
                            
                        <?php if ($proveedor->etiqueta_nombre !="" ){ ?> 
                            <label for="etiqueta_nombre">Etiqueta
                            </label> 
                            <input type="text" name="etiqueta_nombre" id="etiqueta_nombre" class="form-control" 
                                   value="<?=$proveedor->etiqueta_nombre?>" disabled />
                        <?php }?>    
                            
                        <?php if ($proveedor->rz !="" ){ ?> 
                            <label for="rz">Razón social 
                            </label> 
                            <input type="text" name="rz" id="rz" class="form-control" 
                                   value="<?=$proveedor->rz?>" disabled />
                        <?php }?>    
                            
                        <?php if ($proveedor->baja !="" ){ ?> 
                            <label for="baja">Dado de baja 
                            </label> 
                            <input type="text" name="baja" id="baja" class="form-control" 
                                   value="<?=$proveedor->fecha_baja?>" disabled />
                        <?php }?>    
                        </div>
                        <button type="submit" class="btn btn-primary">Volver</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
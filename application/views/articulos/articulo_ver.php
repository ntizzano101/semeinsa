 <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Articulos - Ver</div>
                <div class="panel-body">
                    <form role="search" method="POST" action="<?php echo base_url(); ?>articulos">
                        <div class="form-group">
                            <label for="nombre">Nombre 
                            </label> 
                            <input type="text" name="articulo" id="articulo" class="form-control" 
                                   value="<?=$articulo->articulo?>" disabled />
                            <br>
                            
                            <label for="codigo">Código 
                            </label> 
                            <input type="text" name="codigo" id="codigo" class="form-control" 
                                   value="<?=$articulo->codigo?>" disabled />
                            <br>
                                                        
                            <label for="rubro">Rubro 
                            </label>
                            <input type="text" name="rubro" id="rubro" class="form-control" 
                                   value="<?=$articulo->rubro_nombre?>" disabled />
                            <br>
                            
                            <label for="categoria">Categoría 
                            </label>
                            <input type="text" name="categoria" id="categoria" class="form-control" 
                                   value="<?=$articulo->categoria_nombre?>" disabled />
                            <br>
                            
                            <label for="costo">Costo
                            </label>
                            <input type="text" name="costo" id="costo" class="form-control" 
                                   value="<?=$articulo->costo?>" disabled />
                            <br>
                            
                            <label for="precio1">Precio 1
                            </label>
                            <input type="text" name="precio1" id="precio1" class="form-control" 
                                   value="<?=$articulo->precio1?>" disabled />
                            <br>
                            
                            <label for="precio2">Precio 2
                            </label>
                            <input type="text" name="precio2" id="precio2" class="form-control" 
                                   value="<?=$articulo->precio2?>" disabled />
                            <br>
                            
                            <label for="iva">Iva 
                            </label>
                            <input type="iva" name="iva" id="iva" class="form-control" 
                                   value="<?=$articulo->iva?>" disabled />
                            <br>
                            
                            <label for="empresa">Empresa
                            </label>
                            <input type="text" name="empresa" id="empresa" class="form-control" 
                                   value="<?=$articulo->empresa_nombre?>" disabled />
                            <br>
                            
                            <label for="cc_compras">CC Compras
                            </label>
                            <input type="text" name="cc_compras" id="cc_compras" class="form-control" 
                                   value="<?=$articulo->cc_compras?>" disabled />
                            <br>
                            
                            <label for="cc_ventas">CC Ventas
                            </label>
                            <input type="text" name="cc_ventas" id="cc_ventas" class="form-control" 
                                   value="<?=$articulo->cc_ventas?>" disabled />
                            <br>
                        </div>
                        <button type="submit" class="btn btn-primary">Volver</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
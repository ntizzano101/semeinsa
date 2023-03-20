
<div class="container">
    
    <div class="row">
        <div class="col-md-12">
        <div class="alert alert-warning alert-dismissible" role="alert">
            ¿Está seguro de borrar esta etiqueta?
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Etiquetas - Borrar</div>
                <div class="panel-body">
                    <form role="search" method="POST" action="<?php echo base_url(); ?>clientes/etiqueta_borrar">
                        <div class="form-group">
                            <label for="etiqueta_nombre">Etiqueta</label>
                            <input type="text" name="etiqueta" class="form-control" disabled id="etiqueta_nombre" value="<?=$etiqueta->etiqueta?>">
                        </div>
                        <input type="hidden" name="id" value="<?=$etiqueta->id?>">
                        <button type="submit" class="btn btn-primary">Borrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
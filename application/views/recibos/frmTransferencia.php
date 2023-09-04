<div class="modal fade" id="transferencia">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title">Transferencia</h1>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2">   
                    </div>
                    
                    <div class="col-md-8">  
                        
                       
                        
                        <div class="row">
                            <label for="itemCod">Comprobante</label>
                            <input type="text" name="efe_comentario" id="tra_comentario" class="form-control"/> 
                        </div>
                        <div class="row">
                            <label for="itemPrcU">Banco</label>                           
                            <?php echo form_dropdown('banco', $bancos,'', ' class="form-control" id="tra_banco"'); ?>
                        </div>
                        <div class="row">
                            <label for="itemPrcU">Importe</label>
                            <input type="text" name="itemPrcU" id="tra_importe" class="form-control"/> 
                        </div>


                        
                    </div>
                    
                    <div class="col-md-2">   
                    </div>
                    
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="bntIngTra">Ingresar</button>
                    
                </a>
            </div>

          </div>
        </div>
    </div>   
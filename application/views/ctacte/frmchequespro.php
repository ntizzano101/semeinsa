<div class="modal fade" id="chequepro">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title">Cheque Propio</h1>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2">   
                    </div>
                    
                    <div class="col-md-8">  
                        
                    <div class="row">    
                            <p class="text-danger" id="cheError"></p>
                        </div> 
                        
                        <div class="row">
                            <label for="itemCod">Numero</label>
                            <input type="text" name="che_rio" id="che_nro" class="form-control"/> 
                        </div>
                       
                        <div class="row">
                            <label for="itemPrcU">Banco</label>                           
                            <?php echo form_dropdown('banco', $bancos,'', ' class="form-control" id="che_banco"'); ?>
                        </div>

                        <div class="row">
                            <label for="itemPrcU">Fecha Vto</label>
                            <input type="date" name="itemPrcU" id="che_fecha" class="form-control"/> 
                        </div>                       

                        <div class="row">
                            <label for="itemPrcU">Importe</label>
                            <input type="text" name="itemPrcU" id="che_importe" class="form-control"/> 
                        </div>

                        
                    </div>
                    
                    <div class="col-md-2">   
                    </div>
                    
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="bntIngChe">Ingresar</button>
                    
                </a>
            </div>

          </div>
        </div>
    </div>   
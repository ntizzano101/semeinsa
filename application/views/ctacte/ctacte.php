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
                <div class="panel-heading">Cuenta Corriente - <?=$proveedor->proveedor?></div>
                <?php if(isset($mensaje)){?>
                <div class="row">
                    <div class="col-md-12">
                        <?=$mensaje?>
                    </div>
                </div>
                <?php }?>
                <div class="panel-body">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>ctacte/opago/<?=$proveedor->id?>">Nueva orden de pago</a>
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
                        foreach($ctactes as $cta){ ?>	
                                <tr>
                                    <td><?=$cta->fecha ?></td>
                                    <td><?=$cta->id ?></td>
                                    <td><?=number_format($cta->debe,2,",","")?></td>
                                    <td><?=number_format($cta->haber,2,",","")?></td>
                                    <td><?=number_format($cta->total,2,",","")?></td>
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
        
    
</div>

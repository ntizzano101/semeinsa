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
                <div class="panel-heading">IVA VENTAS</div>     
                <form class="navbar-form navbar-left" role="search" method="POST" action="<?php echo base_url(); ?>iva/ventas">                           
                <input type="text" class="form-control" name="periodo" value="<?=$periodo?>" id="buscar" placeholder="aaaamm">
                <button type="submit" class="btn btn-primary">Filtrar</button>	
                </form>
                <table class="table">
                  <thead>
                        <tr>
                          <th>Fecha</th>
                          <th>Cliente</th>
                          <th>Cuit</th>
                          <th>Comprobante</th>
                          <th>Neto</th>
                          <th>Iva</th>
                          <th>Exento</th>
                          <th>No Gravados</th>
                          <th>Total</th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php 
                        $total=0;$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;
                        foreach($iva as $cta){ 
                            $mul=1;
                            if($cta->tipo_comp==3){$mul=-1;}
                            $total=$total + $cta->total * $mul;        
                            $t1=$t1+$cta->neto * $mul;
                            $t2=$t2+$cta->iva* $mul;
                            $t3=$t3+$cta->excento* $mul;
                            $t4=$t4+$cta->con_nograv* $mul;
                            $t5=$t5+$cta->per_ing_bto* $mul;
                            ?>	
                                <tr>
                                    <td><?=$cta->fechaf ?></td>
                                    <td><?=$cta->cliente ?></td>
                                    <td><?=$cta->cuit ?></td>
                                    <td><?php echo $cta->nombre  . " " .  str_pad($cta->puerto,5,"0",STR_PAD_LEFT)."-".  str_pad($cta->numero,8,"0",STR_PAD_LEFT) ;?></td>
                                    <td align="right"><?=number_format($cta->neto*$mul,2,".",",")?></td>
                                    <td align="right"><?=number_format($cta->iva*$mul,2,".",",")?></td>
                                    <td align="right"><?=number_format($cta->excento*$mul,2,".",",")?></td>
                                    <td align="right"><?=number_format($cta->con_nograv*$mul,2,".",",")?></td>
                                    <td align="right"><?=number_format($cta->total*$mul,2,".",",")?></td>                                                                        
                                </tr>
                        <?php	
                        }                        
                        ?>                        
                        <tr>
                            <td colspan="4"></td>
                            <td  align="right"><?=number_format($t1,2,".",",")?></td>
                            <td  align="right"><?=number_format($t2,2,".",",")?></td>
                            <td  align="right"><?=number_format($t3,2,".",",")?></td>
                            <td  align="right"><?=number_format($t4,2,".",",")?></td>
                            <td  align="right"><?=number_format($total,2,".",",")?></td>

                        </tr>

                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>  
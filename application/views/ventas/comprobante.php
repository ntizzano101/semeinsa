<?php
function fechaDBtoHtml($t){
	list($ano,$mes,$dia)=explode("-",$t);
	if($ano+$mes+$dia==0)
			return "";
	else		
		return sprintf("%d/%d/%d",$dia,$mes,$ano);
}
?>
<html>
<head>
<style  type="text/css">
body{
	font-family:verdana;
	font-size:small;
}
.tr1{

border-bottom:1px solid #000;
}
.texto{
font-size:small;
}
</style>
</head>
<body>
<center>
<table border=1>
<tr>
	<td width="45%" style="text-align:left;margin-left:100px">
		<?=$empresa->razon_soc?><br>
		<?=$empresa->direccion?><br>
		<?=$empresa->localidad?><br>
		<?=$empresa->provincia?> CP <?=$empresa->cp?><br>
		<?=$empresa->telefono?><br>
		<?=$empresa->cond_iva?><br>
	</td>
	<td width="10%" style="text-align:center" valign="top"><span style="font-size:60px"><?=$venta->letra?></span><br>
	<?php if(in_array($venta->letra,array("A","B",))) { ?>	
	<span style="font-size:20px">COD.<?=$venta->codigo_comp?>		
	</span>
	<?php } ?>
	</td>		
	<td width="45%" align="right" valign="top">
	    FECHA :<?=fechaDBtoHtml($venta->fecha) ?><br> 
		<?=$venta->nombre_c?>:<?php printf("%05d-%08d",$venta->puerto,$venta->numero) ?><br>
		CUIT :<?=$empresa->cuit?><br>
		IIBB :<?=$empresa->nro_iibb?><br>
	</td>	
</tr>
<tr>
	<td colspan="3">
		 Cliente : <?php echo $cliente->cliente  ?> <br> 
		 Direcci&oacute;n: <?php echo $cliente->domicilio ?> <br>
		 Telefono: <?php echo $cliente->telefonos ?> <br>
		 Condicion IVA: <?php echo $cliente->cond_iva ?> <br>
		 Cuit: <?php echo $cliente->cuit ?><br>		 
	</td>
</tr>
<tr>
	<td colspan="3">
	<table width="100%" class="texto">
		<?php if($venta->letra!='R') {?>
		<tr>
			<td  style="border:1px solid #000" >Cant.</td>						
			<?php if(($cliente->iva==1 or $cliente->iva==6) and ($venta->letra=='A' or $venta->letra=='P')) {?>
			<td  style="border:1px solid #000">Descripcion</td>		
			<td  style="border:1px solid #000">Iva</td>			
			<?php } 
			else {
			?>
			<td  style="border:1px solid #000" colspan="2">Descripcion</td>	
			<?php } ?>
			<td  style="border:1px solid #000">Precio U.</td>
			<td  style="border:1px solid #000">Sub.Tot.</td>					
		</tr>
		<?php } else { ?>
			<td  style="border:1px solid #000" >Cant.</td>	
			<td  style="border:1px solid #000" colspan="4">Descripcion</td>	
		<?php }  ?>
		<?php foreach ($items as $it) { 
			if($venta->letra!='R') {?>
			<tr>		
				<td ><?php echo $it->cantidad ?></td>
				<?php if(($cliente->iva==1 or $cliente->iva==6) and ($venta->letra=='A' or $venta->letra=='P')) {?>
				<td ><?php echo $it->articulo ?></td>
				<td align="right"><?php echo $it->iva * 100 ?></td>
				<?php } 
				else {
				?>
				<td colspan="2" ><?php echo $it->articulo ?></td>
				<?php } ?>
				<td align="right"><?php echo $it->precio ?></td>
				<td align="right"><?php echo $it->precio *  $it->cantidad?></td>			
			</tr>
		<?php } else { ?>
			<tr>		
				<td ><?php echo $it->cantidad ?></td>
				<td colspan="4" ><?php echo $it->articulo ?></td>			
			</tr>	
		<?php }
		} 
	for($j=0;$j<30 - count($items);$j++){ ?>	
			<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>		
			</tr>
		<?php
		}		
		?>		
	</table>
	</td>
	</tr>
	<?php if(($cliente->iva==1 or $cliente->iva==6) and ($venta->letra=='A' or $venta->letra=='P')){ ?>
		<tr>
			<td width="80%" colspan="2" align="right">SUBTOTAL</td>			
			<td width="20%" align="right"><b><?php echo $venta->neto ?></b></td>
		</tr>		
		<tr>
			<td width="80%" colspan="2" align="right">IVA 10,5%</td>			
			<td width="20%" align="right"><b><?php echo $venta->iva105 ?></b></td>
		</tr>		
		<tr>
			<td width="80%" colspan="2" align="right">IVA 21%</td>			
			<td width="20%" align="right"><b><?php echo $venta->iva21 ?></b></td>
		</tr>		
	<?php }  
	if($venta->letra!='R') { ?>
	<tr>
			<td width="80%" colspan="2" align="right">TOTAL</td>
			
			<td width="20%" align="right"><b><?php echo $venta->total ?></b></td>
	</tr>
	<?php } else { ?>
		<tr>			
			
		<td colspan="5" style="padding: 30px;"> FIRMA___________________________  ACLARACION ________________________
		
		</td>
		</tr>	
	<?php } ?>	
	<?php if(in_array($venta->letra,array("A","B",))) { ?>
	<tr>
			<td width="100%" colspan="10" align="center">
				<table width="100%" align="center">
					<tr>
						<td>
							
							<?php
							
							//QR V1
							//ver 	Numérico 1 digito 	OBLIGATORIO – versión del formato de los datos del comprobante 	1
							$qr1["ver"]=1;
							//fecha 	full-date (RFC3339) 	OBLIGATORIO – Fecha de emisión del comprobante 	"2020-10-13"
							$qr1["fecha"]=$venta->fecha;
							//cuit 	Numérico 11 dígitos 	OBLIGATORIO – Cuit del Emisor del comprobante 	30000000007
							$qr1["cuit"]=$empresa->cuit;
							//ptoVta 	Numérico hasta 5 digitos 	OBLIGATORIO – Punto de venta utilizado para emitir el comprobante 	10
							$qr1["ptoVta"]=$venta->puerto; //Sori Pero lo tengo HArdoce DAMASO;
							//tipoCmp 	Numérico hasta 3 dígitos 	OBLIGATORIO – tipo de comprobante (según Tablas del sistema ) 	1
							$qr1["tipoCmp"]=$venta->cod_afip;
							//nroCmp 	Numérico hasta 8 dígitos 	OBLIGATORIO – Número del comprobante 	94
							$qr1["nroCmp"]=$venta->numero;
							//importe 	Decimal hasta 13 enteros y 2 decimales 	OBLIGATORIO – Importe Total del comprobante (en la moneda en la que fue emitido) 	12100
							$qr1["importe"]=$venta->total;
							//moneda 	3 caracteres 	OBLIGATORIO – Moneda del comprobante (según Tablas del sistema ) 	"DOL"
							$qr1["moneda"]="PES";
							//ctz 	Decimal hasta 13 enteros y 6 decimales 	OBLIGATORIO – Cotización en pesos argentinos de la moneda utilizada (1 cuando la moneda sea pesos) 	65
							$qr1["ctz"]=1;
							//tipoDocRec 	Numérico hasta 2 dígitos 	DE CORRESPONDER – Código del Tipo de documento del receptor (según Tablas del sistema ) 	80
							//$qr1["tipoDocRec"]=$otros->codigo_iva; // le erre mal es el tipo de documento CUIT DNI
							//nroDocRec 	Numérico hasta 20 dígitos 	DE CORRESPONDER – Número de documento del receptor correspondiente al tipo de documento indicado 	20000000001
							if($cliente->iva != 5)
								{ 
								$qr1["nroDocRec"]=$cliente->cuit;
								$qr1["tipoDocRec"]=80;
								}
							else{
								$qr1["nroDocRec"]=$cliente->dni;	
								$qr1["tipoDocRec"]=96;
								}
							//tipoCodAut 	string 	OBLIGATORIO – “A” para comprobante autorizado por CAEA, “E” para comprobante autorizado por CAE 	"E"
							$qr1["tipoCodAut"]="E";	
							//codAut 	Numérico 14 dígitos 	OBLIGATORIO – Código de autorización otorgado por AFIP para el comprobante 	70417054367476
							$qr1["codAut"]=$venta->cae;
							$valor=json_encode($qr1);
							$valor="https://www.afip.gob.ar/fe/qr/?p=" . base64_encode($valor);
							?>
							<img src="https://chart.googleapis.com/chart?cht=qr&chs=250x250&chl=<?=$valor?>">
						</td>
						<td>
							<img src="/ln/img/afip.png"><br>
							CAE Nro: <?php echo $venta->cae ?>
							Fecha.Vto.Cae: <?php echo fechaDBtoHtml($venta->cae_vence) ?>
						</td>						
					</tr>
				</table>
			</td>
		</tr>		
	</table>	
	</td>
</tr>
<?php } ?>
</table>
</center>	
</body>
</html>

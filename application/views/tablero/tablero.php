 <div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
			  <div class="panel-heading">Tablero</div>
			  <div class="panel-body">
				<form class="navbar-form navbar-left" role="search" method="POST" action="<?php echo base_url(); ?>alumnos/buscar">
				<input type="text" class="form-control" name="buscar" placeholder="Buscar..">
				<button type="submit" class="btn btn-default">Buscar</button>								
				</form>	
			  </div>
				<table class="table">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>Nombre</th>
					  <th> - </th>
					  <th>Direccion</th>
					  <th>Telefono</th>
					  <th>Acciones</th>
					</tr>
				  </thead>
				  <tbody>
					<?php 
					$alumnos=array();
					foreach($alumnos as $alu){ ?>	
						<tr>
							<th scope="row"><?=$alu->id ?></th>
							<td><?=$alu->apellido .", ". $alu->nombre ?></td>
							<td><?=$alu->curso ?></td>
							<td><?=$alu->direccion ?></td>
							<td><?=$alu->telefono ?></td>
							<td><a href="<?php echo base_url(); ?>alumnos/editar/<?=$alu->id?>"> Editar </a> | 
							 <a href="<?php echo base_url(); ?>alumnos_cc/cuentacorriente/<?=$alu->id?>">Cta.Cte.</a> | 
							 <a href="<?php echo base_url(); ?>alumnos_cc/a_cancelar/<?=$alu->id?>">Cobrar</a> | 
							 <a href="<?php echo base_url(); ?>alumnos_cc/deuda/<?=$alu->id?>">Deuda</a> | 
							 <a href="<?php echo base_url(); ?>alumnos/eliminar/<?=$alu->id?>">Eliminar</a>
							 
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
</div>


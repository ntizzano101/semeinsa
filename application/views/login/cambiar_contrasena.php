<div class="container">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
		<div class="panel panel-default m-top-10">
			  <div class="panel-heading">Cambiar contraseña</div>
			  <div class="panel-body">
			<form method="POST" action="">
			<div class="form-group">
				<input type="password" placeholder="Contraseña actual" name="contrasena_actual" class="form-control">
			</div>
				<?php echo form_error('contrasena_actual'); ?>
			<div class="form-group">
				<input type="password" placeholder="Contraseña nueva" name="contrasena_nueva" class="form-control">
			</div>
				<?php echo form_error('contrasena_nueva'); ?>
			<div class="form-group">
				<input type="password" placeholder="Confirmación de contraseña nueva" name="contrasena_nueva_conf" class="form-control">
			</div>
				<?php echo form_error('contrasena_nueva_conf'); ?>
			<input type="submit" value="Cambiar contraseña" class="btn btn-lg btn-primary btn-block">
			</form>
			</div>
			</div>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>
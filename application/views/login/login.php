   <div class="container">
    <div class="row vertical-offset-100">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">La Nicole&ntilde;a S.A.</h3>
			 	</div>
			  	<div class="panel-body">
                                   
			    	<form accept-charset="UTF-8" role="form" method="post" action="<?php echo base_url(); ?>ingreso">
                    <fieldset>
			    	  	<div class="form-group">
			    		    <input class="form-control" placeholder="Usuario" name="usuario" type="text">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Password" name="password" type="password" value="">
			    		</div>
			    		<div class="checkbox">
			    	    	<label>
			    	    		<input name="remember" type="checkbox" value="Recordarme"> Recordarme
			    	    	</label>
			    	    </div>
			    		<input class="btn btn-lg btn-primary btn-block" type="submit" value="Ingresar">
			    		<?php if($mensaje!=''){ ?>
			    		<div class="alert alert-warning">
							 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong> Error </strong>Usuario o Contraseña Incorrecta
						</div>
						<?php } ?>
			    	</fieldset>
			      	</form>
			    </div>
			</div>
		</div>
	</div>
</div>
  </body>
</html>

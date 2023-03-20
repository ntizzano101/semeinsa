  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?=base_url()?>">La Nicole&ntilde;a</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
		         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Clientes<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>clientes">Clientes</a></li>
            <li><a href="<?=base_url()?>etiquetas">Etiquetas </a></li>
            <li><hr></li>
            <li><a href="<?=base_url()?>cuentacorriente/clientes">Cuenta Corriente</a></li>
            <li><a href="<?=base_url()?>ventas/listar">Comprobantes</a></li>          
          </ul>
        </li> 
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Proveedores<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>proveedores">Proveedores</a></li>
            <li><hr></li>
            <li><a href="<?=base_url()?>proveedores">Cuenta Corriente</a></li>
            <li><a href="<?=base_url()?>facturas">Facturas</a></li>          
          </ul>
        </li> 
		  
       
	    <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Contabilidad<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>conceptos_caja/editar/">Plan De Cuentas</a></li>
            <li><a href="<?=base_url()?>conceptos_caja/listado">Iva Ventas</a></li>		     
            <li><a href="<?=base_url()?>movimientos_caja/listar">Iva Compras</a></li>
						 <li><hr></li>
			     <li><a href="<?=base_url()?>cierre_caja/verificar/">Posicion IVA</a></li>
           
          </ul>
        </li> 
	   
	   
		   <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Articulos<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>articulos">Articulos</a></li>
            <li><a href="<?=base_url()?>rubros">Rubros</a></li>
            <li><a href="<?=base_url()?>categorias">Categorias</a></li>
          </ul>
        </li>
		
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Caja<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>alumnos_cc/listar_ingresos">Ver Cajas</a></li>
            <li><a href="<?=base_url()?>alumnos_cc/listar_facturas">Codigos Ingreso/Egreso</a></li>
            
          </ul>
        </li>        
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata("titulo") ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>cambiar_contrasena">Cambiar contraseña</a></li>
            <li><a href="<?=base_url()?>salir">Salir</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
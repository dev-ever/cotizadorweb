<?php 

	
	$usuarios = ControladorUsuarios::ctrContarUsuarios();
	$clientes = ControladorClientes::ctrContarClientes();
	$cotizacion = ControladorCotizacion::ctrContarCotizacion();
	
 ?>
<div class="col-lg-3 col-xs-6">
	
	<div class="small-box bg-danger">

		<div class="inner">

			<h3><?php echo $usuarios["totalUsuarios"] ?></h3>
			<p>Usuarios</p>
		
		</div>

		<div class="icon">
			
			 <i class="fa fa-user"></i>
			
		</div>

		
	</div>

</div>



<div class="col-lg-3 col-xs-6">
	
	<div class="small-box bg-warning">

		<div class="inner">

			<h3><?php echo $clientes["totalClientes"] ?></h3>
			<p>Clientes</p>
		
		</div>

		<div class="icon">
			
			<i class="fa fa-users"> </i>
			
		</div>

	
		
	</div>

</div>


<div class="col-lg-3 col-xs-6">
	
	<div class="small-box bg-info">

		<div class="inner">

			<h3><?php echo $cotizacion["totalCotizacion"]; ?></h3>
			<p>Cotizaciones</p>
		
		</div>

		<div class="icon">
			
			<i class="fa fa-th-list"> </i>
			
		</div>

		
		
	</div>

</div>


<div class="col-lg-3 col-xs-6">
	
	<div class="small-box bg-success">

		<div class="inner">

			<h3><?php echo $usuarios["totalUsuarios"]; ?></h3>
			<p>Usuarios</p>
		
		</div>

		<div class="icon">
			
			<i class="fa fa-user"> </i>
			
		</div>

	
		
	</div>

</div>



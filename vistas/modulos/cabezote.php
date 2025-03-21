 <header class="main-header">
 	
	<!--=====================================
	LOGOTIPO
	======================================-->
	<a href="inicio" class="logo">
		
		<!-- logo mini -->
		<span class="logo-mini">
			
			<img src="vistas/img/plantilla/icono-blanco.png" class="img-responsive" style="padding:10px">

		</span>

		<!-- logo normal -->

		<span class="logo-lg">
			
			<img src="vistas/img/plantilla/logo-blanco-lineal.png" class="img-responsive" style="padding:10px 0px">

		</span>

	</a>

	<!--=====================================
	BARRA DE NAVEGACIÓN
	======================================-->
	<nav class="navbar navbar-static-top" role="navigation">
		
		<!-- Botón de navegación -->

	 	<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        	
        	<span class="sr-only">Toggle navigation</span>
      	
      	</a>

		<!-- perfil de usuario -->

		<div class="navbar-custom-menu text-center">
				
			<ul class="nav navbar-nav">
				
				<li class="dropdown user user-menu">
					
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">

					<?php

					if($_SESSION["foto"] != ""){

						echo '<img src="'.$_SESSION["foto"].'" class="user-image">';

					}else{


						echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';

					}


					?>
						
						<span class="hidden-xs"><?php  echo $_SESSION["nombre"]; ?></span>

					</a>

					<!-- Dropdown-toggle -->

					<ul class="dropdown-menu text-center">
						
						<li class="user-header bg-light-dark">

							<?php 

								if($_SESSION["foto"] != ""){

									echo '<img src="'.$_SESSION["foto"].'" class="img-circle">';
								}else{

									echo '<img src="vistas/img/usuarios/default/anonymous.png" class="img-circle">';
								}

							 ?>

							 <p style="color:#fff;" class="text-center">

								
								<!-- <span class="hidden-xs"><?php//  echo $_SESSION["nombre"]; ?></span> -->
								<?php echo $_SESSION["nombre"]; ?>

								<hr style="border:0.5px solid #fff;">
								
							</p>

							<p>
								<?php echo $_SESSION["usuario"]; ?>
							</p>
							

							<li class="user-body">

								<div class="pull-left">

									<a href="salir" class="btn btn-default btn-flat"><i class="fa fa-refresh"></i> Cambiar de usuario</a>

								</div>

								<div class="pull-right">
									
									<a href="salir" class="btn btn-default btn-flat"> <i class="fa fa-times"></i> Salir</a>
								</div>

							</li>

							
							
							<!-- <div class="pull-right">
								
								<a href="salir" class="btn btn-default btn-flat">Salir</a>

							</div> -->

						</li>

					</ul>




				</li>

			</ul>

		</div>

	</nav>

 </header>
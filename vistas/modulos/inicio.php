<div class="content-wrapper">

    <section class="content-header">
      
      <h1>
        
        Tablero
        
        <small>Panel de Control</small>
      
      </h1>

      <ol class="breadcrumb">
        
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        
        <li class="active">Tablero</li>
      
      </ol>

    </section>





  <!-- Main content -->
  <section class="content">

        <div class="row">

      <?php 

          if($_SESSION["perfil"] == "Administrador") {

             include "inicio/cajas-superiores.php";

             // echo  '
             //          <div class="box-header with-border">

             //              <button type="button" class="btn btn-default" id="daterange-btn2">
                      
             //                <span>
             //                    <i class="fa fa-calendar"></i> Rango de fechas
             //                </span>

             //                <i class="fa fa-caret-down"></i>

             //              </button>

             //              <div class="box-tools pull-right"></div>

             //          </div> 


             //          <div class="box-body">
             //             <div class="row">
             //                <div class="col-xs-12">';

                    // include "reportes/grafico-tickets.php";

                   //  echo        '</div>
                   //       </div>
                   //    </div>
                   // ';




          }else{

              echo '
                      <div class="box-header">

                           <h4 class="text-primary text-right">Bienvenido(a): '.$_SESSION["nombre"].', '.$_SESSION["perfil"].'  </h4>
                      
                        </div>

                      ';
                 include "inicio/cajas-superiores-sell.php";
          }


         ?>


        </div>

  </section>



</div>

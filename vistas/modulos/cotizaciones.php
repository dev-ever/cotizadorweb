<div class="content-wrapper">







  <section class="content-header">



    



    <h1>



      



      Administrar Cotizaciones



    



    </h1>







    <ol class="breadcrumb">



      



      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>



      



      <li class="active">Administrar cotizacion</li>



    



    </ol>







  </section>







  <!-- Main content -->



  <section class="content">







    <!-- Default box -->



    <div class="box">



      <div class="box-header with-border">







        <a href="crear-cotizacion">



          



          <button class="btn btn-primary">  



            



            Agregar cotización







          </button>



      </a>



      </div>







      <div class="box-body">



        



        <table class="table table-bordered table-striped dt-responsive tablas tablasCotizaciones" width="100%">



          



          <thead>



            



                <th style="width: 10px;">#</th>



                <th>Código</th>



                <th>Venta</th>



                <th>Cliente</th>



                <th class="text-center">Vendedor</th>



                <th class="text-center">Email</th>



                <th class="text-center">Impuesto</th>



                <th class="text-center">Neto</th>



                <th class="text-center">Total</th>



                <th class="text-center">Fecha</th>



                <th class="text-center">Acciones</th>







                       



          </thead>







          <tbody>







            <?php 







            $item = null;



            $valor = null;







            $respuesta = ControladorCotizacion::ctrMostrarCotizaciones($item,$valor);







              foreach ($respuesta as $key => $value) {



                echo '

                    <tr>



                      <td>'.($key+1).'</td>



                      <td>'.$value["codigo"].'</td>
                      <td>'.$value["id_cliente"].'</td>';







                      // $itemCliente = "id";
                      // $valorCliente = $value["id_cliente"];

                      // $clientes = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);



                // echo '<td>'.utf8_decode($clientes["nombre"]).'</td>



                     echo  '<td>'.$value["nombreCliente"].'</td>';







                      $itemVendedor = "id";



                      $valorVenderdor = $value["id_vendedor"];







                      $vendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor,$valorVenderdor);











                echo '<td class="text-center">'.$vendedor["nombre"].'</td>



                      <td class="text-center">'.$value["emailCliente"].'</td>



                      <td class="text-center">$'.$value["impuesto"].'</td>



                      <td class="text-center">$'.$value["neto"].'</td>



                      <td class="text-center"><label class="btn btn-success btn-xs">$'.$value["total"].'</label></td>



                      <td class="text-center">'.$value["fecha"].'</td>







                      <td class="text-center">



                      



                        <div class="btn-group">







                          <button class="btn btn-success btnImprimirFactura" codigoCotizacion="'.$value["codigo"].'">



                              <i class="fa fa-print"></i>



                          </button>







                           <button class="btn btn-warning btnEditarCotizacion" idCotizacion="'.$value["id"].'"><i class="fa fa-pencil"></i></button></a>







                          <button class="btn btn-danger btnEliminarCotizacion" idCotizacion="'.$value["id"].'"><i class="fa fa-times"></i></button>







                        </div>



                      </td>



                    </tr>



                    ';



              }



            ?>



           



          </tbody>







        </table>















      </div>











      <!-- /.box-body -->



      <div class="box-footer">



        Footer



      </div>



      <!-- /.box-footer-->



    </div>



    <!-- /.box -->







  </section>



  <!-- /.content -->



</div>



<!-- /.content-wrapper -->
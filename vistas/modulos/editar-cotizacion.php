<div class="content-wrapper">







  <section class="content-header">



    



    <h1>



      



      Editar cotización



    



    </h1> 







    <ol class="breadcrumb">



      



      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

 

      



      <li class="active">Editar cotización</li>



    



    </ol>







  </section>



 



  <!-- Main content -->



  <section class="content">







  



    <div class="row">







      <!--/* FORMULARIO */-->



      



        <div class="col-lg-12 col-xs-12">



            



            <div class="box box-success">







                <div class="box-header with-border"></div>







            <form role="form" method="post" class="formularioCotizacion">







                <div class="box-body">



                  



                







                      <div class="box">



                        



                        <?php 







                              $item = "id";



                              $valor = $_GET["idCotizacion"];







                              $cotizacion = ControladorCotizacion::ctrMostrarCotizaciones($item, $valor);







                              // var_dump($cotizacion);







                              $itemVendedor = "id";



                              $valorVendedor = $cotizacion["id_vendedor"];







                              $vendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor,$valorVendedor);







                              $itemCliente = "id";



                              $valorCliente = $cotizacion["id_cliente"];







                              $cliente = ControladorClientes::ctrMostrarClientes($itemCliente,$valorCliente);







                              $porcentajeImpuesto = round($cotizacion["impuesto"] * 100 / $cotizacion["neto"]);



















                         ?>



                             <!--===========================================



                              ENTRADA VENDEDOR (ID)  DESDE BASE DE DATOS



                              =============================================-->







                          <div class="form-group">



                            



                            <div class="input-group col-lg-6">



                              



                              <span class="input-group-addon"><i class="fa fa-user"></i></span>







                              <input type="text" class="form-control" name="nuevoVendedor" id="nuevoVendedor" value="<?php echo $vendedor["nombre"]; ?>" readonly>



                              <input type="hidden" name="idVendedor" name="idVendedor" value="<?php echo $vendedor['id']; ?>">



                            </div>



                          



                          </div>







                           <!--===========================================



                              ENTRADA CODIGO  DESDE BASE DE DATOS



                              =============================================-->







                          <div class="form-group">



                            



                            <div class="input-group col-lg-6">



                              



                              <span class="input-group-addon"><i class="fa fa-key"></i></span>







                                    <input type="text" class="form-control" name="editarCotizacion" id="nuevaCotizacion" value="<?php echo $cotizacion["codigo"]; ?>" readonly>



         



                            </div>



                          



                          </div>




















                           <!--===========================================



                              ENTRADA CLIENTE PUBLICO DESDE INTERFAZ



                              =============================================-->







                          <div class="form-group">



                            



                            <div class="input-group col-lg-6">



                              



                              <span class="input-group-addon"><i class="fa fa-user"></i></span>







                              <input type="text" class="form-control" name="nombreCliente1" id="nombreCliente1"  value="<?php echo $cotizacion["nombreCliente"]; ?>" placeholder="Nombre del Cliente" required >



                            



                            </div>



                          



                          </div>




                            <!--===========================================



                              ENTRADA CLIENTE PUBLICO DESDE BASE DE DATOS



                              =============================================-->



                          <div class="form-group">

                            <div class="input-group col-lg-6">

                              <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                              <?php
                                // $item = null;
                                // $valor = null;

                                // $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

                                // foreach ($clientes as $key => $value) {

                                //   echo ' <input type="text" class="form-control" name="nombreCliente" id="nombreCliente"  placeholder="Nombre del Cliente" required value="'.$value["nombre"].'" readonly>';

                                //   echo '<input type="hidden" id="idCliente" class="form-control" name="idCliente" value="'.$value["id"].'">';

                                // }

                               ?>

                                <input type="text" class="form-control" name="editarTelefono" id="editarTelefono"  placeholder="Ingresa número telefónico (solo números)" required value="<?php echo $cotizacion["id_cliente"]; ?>">

                            </div>

                          </div>











                          <!--===========================================



                              ENTRADA EMAIL CLIENTE



                              =============================================-->







                          <div class="form-group">



                            



                            <div class="input-group col-lg-6">



                              



                              <span class="input-group-addon"><i class="fa fa-envelope"></i></span>







                              <input type="text" class="form-control" name="emailCliente" id="emailCliente"  value="<?php echo $cotizacion["emailCliente"]; ?>" placeholder="Email del Cliente" required>



                            



                            </div>



                          



                          </div>







             <!--===========================================



                        <div class="form-group">



                            



                            <div class="input-group">



                              



                              <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>







                              <textarea type="text" class="form-control" name="direccionCliente" id="direccionCliente"  placeholder="Dirección del Cliente" required></textarea>



                            



                         











          



                    



                          </div>



                        </div>



               =============================================-->     















                   <!-- /*=============================================



                    =            ENTRADAS DE PRODUCTOS         =



                    =============================================*/-->



                    



                          <div class="form-group row nuevoProducto">



                            



                            <div class="row" style="padding:5px 25px">



                              <div class="col-xs-2 text-primary btn-default text-center">

                                Cantidad

                                

                              </div>



                              <div class="col-xs-1 text-primary btn-default text-center">

                                Unidad

                              </div>



                              <div class="col-xs-3 text-primary btn-default" style="padding-right: 0px;">



                                  Descripción



                              </div>











                              <div class="col-xs-2 text-primary btn-default text-center">



                                  Tiempo Entrega



                              </div>







                              <div class="col-xs-2 text-primary btn-default">



                                  Precio



                              </div>







                              <div class="col-xs-2 text-primary btn-default">



                                  Total



                              </div>



                            </div>











                            <?php 







                              



                              $listarProducto = json_decode($cotizacion["productos"], true);



                               // var_dump($listarProducto);







                              foreach($listarProducto as $key => $value) {



                                



                                echo '







                                      <div class="row" style="padding:5px 15px">







                                        <div class="col-xs-2" style="padding-right: 0px;">



                                                                    



                                            <div class="input-group"> 



                                                                    



                                              <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto"><i class="fa fa-times"></i></button></span>  



                                              



                                              <input type="number" name="nuevaCantidadProducto" class="form-control nuevaCantidadProducto" id="nuevaCantidadProducto" value="'.$value["cantidad"].'" min="1" placeholder="0" required>

                                                           



                                            </div>







                                           </div>

                                              





                                           <div class="col-xs-1">



                                                <input type="text" name="unidad" class="form-control unidad" id="unidad" value="'.$value["unidad"].'">



                                           </div>



                                           <div class="col-xs-3">

                                              

                                              <input type="text" name="agregarProducto" class="form-control agregarProducto" id="agregarProducto" value="'.$value["descripcion"].'" placeholder="Descripción de producto" required>



                                           </div>





                                           <div class="col-xs-2"> 



                                                <input type="text" name="entrega" class="form-control entrega"id="entrega" value="'.$value["entrega"].'">

                                           

                                           </div>





                                          <div class="col-xs-2">



                                                                    



                                            <input type="text" name="nuevaPrecioU" class="form-control nuevaPrecioU" id="nuevaPrecioU" placeholder="0" value="'.$value["precio"].'" required>







                                           </div>











                                         <div class="col-xs-2" style="padding-left: 0px;">







                                              <div class="input-group">







                                                <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>







                                                <input type="text" name="nuevoPrecioProducto" class="form-control nuevoPrecioProducto" id="nuevoPrecioProducto" value="'.$value["total"].'" placeholder="000000"  required readonly>







                                              </div>



                                                                    



                                           </div>







                                        </div>















                                     ';



                                



                              }



















                             ?>



                            



                           



                          </div>



                    



                          







                          <!---============================================



                          =            AGREGAR LISTA PRODUCTOS                 =



                          =============================================-->







                          <input type="hidden" name="listaProductos" id="listaProductos">







                          <!---============================================



                          =            AGREGAR PRODUCTO                   =



                          =============================================-->



                          



                          



                          <button type="button" class="btn btn-default btnAgregarProducto">



                            Agregar Producto



                          </button>



                          <button type="button" class="btn btn-default btnTotalProducto">



                            Total

                            

                          </button>









                          <hr>



                        <div class="col-xs-6">

                          

                            

                        <label>Observaciones - caracteres restantes:<span id="contadorTaComentario">0/250</span></label>

                            

                            <textarea style="text-align: justify;" name="observaciones" id="taComentario" class="form-control observaciones" rows="5"><?php echo $cotizacion["observaciones"]; ?></textarea>

                       </div>





                        





                       







                          <div class="row">



                            <div class="col-xs-8 pull-right">



                                



                                <table class="table">







                                  <thead>







                                    <tr>







                                      <th>IVA</th>



                                      <th>Total</th>







                                    </tr>







                                  </thead>



                                  <tbody>



                                    



                                      <tr>



                                        <td style="width: 50%;">







                                          <div class="input-group col-lg-5">



                                            <input type="text" class="form-control"  id="nuevoImpuestoCotizacion" name="nuevoImpuestoCotizacion" placeholder="0" value="<?php echo $porcentajeImpuesto; ?>" required readonly>







                                            <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" value="<?php echo $cotizacion["impuesto"] ?>" required>







                                            <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" value="<?php echo $cotizacion["neto"] ?>" required>







                                            <span class="input-group-addon"><i class="fa fa-percent"></i></span>



                                          </div>







                                         <td style="width: 50%;">



                                          <div class="input-group col-lg-5">



                                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>



                                            <input type="text" class="form-control" id="nuevoTotalCotizacion" name="nuevoTotalCotizacion" total="" placeholder="000000" required readonly value="<?php echo $cotizacion["total"] ?>">



                                            <input type="hidden" name="totalCotizacion" id="totalCotizacion" value="<?php echo $cotizacion["total"] ?>">







                                          </div>



                                        </td>



                                          



                                        </td>



                                      </tr>







                                  </tbody>



                                </table>



                            </div>



                          </div>



                   







                      </div>



                



                </div>



                







                <div class="box-footer">



                 



                  <button type="submit" class="btn btn-primary pull-right" class="agregarProducto"><i class="fa fa-save"></i> Guardar Cambios </button>







                </div>







               </form>







               



                    <?php 







                        $editarCotizacion = new ControladorCotizacion();



                        $editarCotizacion -> ctrEditarCotizacion();















                     ?>



                







            </div>



        </div>







        <!-- TABLA DE PRODUCTOS     -->



<!-- 



        <div class="col-lg-7 hidden-sm hidden-xs">



          <div class="box box-warning">



            Catalogo



          </div>



        </div> -->



    </div>











  </section>



  



</div>




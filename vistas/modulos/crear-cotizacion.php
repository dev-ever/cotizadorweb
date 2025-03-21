<div class="content-wrapper">


  <section class="content-header">


    <h1>


      Crear cotización



    </h1> 







    <ol class="breadcrumb">



      



      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>



      



      <li class="active">Crear cotización</li>



    



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



                        



                             <!--===========================================



                              ENTRADA VENDEDOR (ID)  DESDE BASE DE DATOS



                              =============================================-->







                          <div class="form-group">



                            



                            <div class="input-group col-lg-6">



                              



                              <span class="input-group-addon"><i class="fa fa-user"></i></span>







                              <input type="text" class="form-control" name="nuevoVendedor" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"];?>" readonly>



                              <input type="hidden" name="idVendedor" name="idVendedor" value="<?php echo $_SESSION["id"];?>">



                            </div>



                          



                          </div>







                           <!--===========================================



                              ENTRADA CODIGO  DESDE BASE DE DATOS



                              =============================================-->







                          <div class="form-group">



                            



                            <div class="input-group col-lg-6">



                              



                              <span class="input-group-addon"><i class="fa fa-key"></i></span>







                              <?php 
                                $item = null;
                                $valor = null;
                                $cotizacion = ControladorCotizacion::ctrMostrarCotizaciones($item, $valor);


                                if(!$cotizacion){

                                    echo '<input type="text" class="form-control" name="nuevaCotizacion" id="nuevaCotizacion" value="1" readonly>';

                                }else{

                                    foreach ($cotizacion as $key => $value) {

                                   }











                                    $codigo = $value["codigo"] + 1;







                                  







                                    echo '<input type="text" class="form-control" name="nuevaCotizacion" id="nuevaCotizacion" value="'.$codigo.'" readonly>';







                                  

                                }







                              ?> 







                              



                            



                            </div>



                          



                          </div>





                                                     <!--===========================================



                              ENTRADA CLIENTE PUBLICO DESDE INTERFAZ



                              =============================================-->







                          <div class="form-group">



                            



                            <div class="input-group col-lg-6">



                              



                              <span class="input-group-addon"><i class="fa fa-user"></i></span>







                              <input type="text" class="form-control" name="nombreCliente1" id="nombreCliente1"  placeholder="Nombre del Cliente" required >



                            



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
                                //   echo ' <input type="text" class="form-control" name="nombreCliente" id="nombreCliente"  placeholder="Ingresa número telefónico" required value="'.$value["nombre"].'">';

                                //   echo '<input type="hidden" id="idCliente" class="form-control" name="idCliente" value="'.$value["id"].'">';
                                // }

                               ?>
                               <input type="text" class="form-control" name="telefono" id="telefono"  placeholder="Ingresa número telefónico (solo números)" required>
                            </div>

                          </div>












                          <!--===========================================



                              ENTRADA EMAIL CLIENTE



                              =============================================-->







                          <div class="form-group">



                            



                            <div class="input-group col-lg-6">



                              



                              <span class="input-group-addon"><i class="fa fa-envelope"></i></span>







                              <input type="text" class="form-control" name="emailCliente" id="emailCliente"  placeholder="Email del Cliente" required>



                            



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

                              

                                <div class="col-xs-1 text-primary btn-default">



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

                            <label>Observaciones - caracteres restantes: <span id="contadorTaComentario">0/250</span></label>

                            <textarea name="observaciones" id="taComentario" class="form-control observaciones" placeholder="Observaciones Generales" rows="5"></textarea>



                          </div>

                           







                          <div class="row">



                            <div class="col-xs-8 pull-right">



                                



                                <table class="table">







                                  <thead>







                                









                                      <th>IVA</th>



                                      <th>Total</th>







                                 







                                  </thead>



                                  <tbody>



                                    

                                                               



                                      <tr>



                                        <td style="width: 50%;">







                                          <div class="input-group col-lg-5">



                                            <input type="number" class="form-control" value="16" id="nuevoImpuestoCotizacion" name="nuevoImpuestoCotizacion" placeholder="0" required readonly>







                                            <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" required>







                                            <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" required>







                                            <span class="input-group-addon"><i class="fa fa-percent"></i></span>



                                          </div>







                                         <td style="width: 50%;">



                                          <div class="input-group col-lg-5">



                                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>



                                            <input type="text" class="form-control" id="nuevoTotalCotizacion" name="nuevoTotalCotizacion" total="" placeholder="000000" required readonly>



                                            <input type="hidden" name="totalCotizacion" id="totalCotizacion">



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



                 



                  <button type="submit" class="btn btn-primary pull-right" class="agregarProducto">Guardar Cotización </button>







                </div>







               </form>







               



                    <?php 







                        $crearCotizacion = new ControladorCotizacion();



                        $crearCotizacion -> ctrCrearCotizacion();















                     ?>



                







            </div>



        </div>







        <!-- TABLA DE PRODUCTOS     -->





<!-- 

        <div class="col-lg-4 hidden-sm hidden-xs">



          <div class="box box-warning">



            Catalogo



          </div>



        </div> -->



    </div>











  </section>



  



</div>




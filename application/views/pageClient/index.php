<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url();
         ?>theme/dist/img/logo.jpg"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
  

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>theme/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url();?>theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="<?php echo base_url();?>theme/plugins/datatables-autofill/css/autoFill.bootstrap4.min.css">
    
    <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url();
        ?>theme/plugins/select2/css/select2.min.css">      

  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url();?>theme/plugins/icheck-bootstrap/icheck-bootstrap.min.css">    
  
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url();
        ?>theme/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">    

  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url();
        ?>theme/plugins/toastr/toastr.min.css">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url();
         ?>theme/dist/css/adminlte.min.css">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- Bootstrap4 Duallistbox --> 
  <link rel="stylesheet" href="<?php echo base_url();?>theme/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>theme/plugins/ekko-lightbox/ekko-lightbox.css">


  
  <!-- Scripts -->
  
  <!-- jQuery -->
  <script src="<?php echo base_url();
          ?>theme/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url();
          ?>theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url();
          ?>theme/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url();
          ?>theme/dist/js/demo.js"></script>
  <!-- DataTables -->
  <script src="<?php echo base_url();
          ?>theme/plugins/datatables/jquery.dataTables.min.js"></script>

  <script src="<?php echo base_url();
          ?>theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

  <!-- jQuery Validate -->
  <script src="<?php echo base_url();?>theme/plugins/jquery-validate/jquery.validate.js"></script>

  <!-- Select2 -->
  <script src="<?php echo base_url();
          ?>theme/plugins/select2/js/select2.full.min.js"></script>

  <!-- InputMask -->
  <script src="<?php echo base_url();
          ?>theme/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

  <!-- Moment -->
  <script src="<?php echo base_url();
          ?>theme/plugins/moment/moment-with-locales.min.js"></script>

  <!-- Toastr -->
  <script src="<?php echo base_url();
          ?>theme/plugins/toastr/toastr.min.js"></script>

  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?php echo base_url();
          ?>theme/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

  <!-- Password Generator -->
  <script src="<?php echo base_url();
          ?>theme/plugins/random-secure-password-generator/jquery.jquery-password-generator-plugin.min.js"></script>
   
  <!-- Bootstrap Switch -->
  <script src="<?php echo base_url();
          ?>theme/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

  <!-- SweetAlert -->
  <script src="<?php echo base_url();?>theme/plugins/sweetalert2/sweetalert2.all.min.js"></script>

  <!-- jquery-inactivityTimeout-->
  <script src="<?php echo base_url();?>theme/plugins/jquery-inactivityTimeout/jquery.inactivityTimeout.min.js"></script>

  <!-- InputMask -->
  <script src="<?php echo base_url();?>theme/plugins/inputmask/min/inputmask/inputmask.min.js"></script>

  <!-- Bootstrap4 Duallistbox -->
  <script src="<?php echo base_url();?>theme/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>

  <script src="<?php echo base_url();?>theme/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  
  <script src="<?php echo base_url();?>theme/plugins/jquery.maskedinput-master/src/jquery.maskedinput.js"></script>
  <script src="<?php echo base_url();?>theme/plugins/icheck-bootstrap/icheck.min.js"></script>

  <link rel="stylesheet" href="<?php echo base_url();?>theme/plugins/fine-uploader/fine-uploader-new.min.css">
  <script src="<?php echo base_url();?>theme/plugins/fine-uploader/jquery.fine-uploader.js"></script>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="../../index3.html" class="navbar-brand">
        <img src="<?php echo base_url();?>theme/dist/img/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"> <b>MA</b> IMPORTS</span>
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <!-- <ul class="navbar-nav">
          <li class="nav-item">
            <a href="index3.html" class="nav-link">Home</a>
          </li>
        </ul> -->

        <!-- SEARCH FORM -->
        <!-- <form class="form-inline ml-0 ml-md-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form> -->
      </div>

      <!-- Right navbar links -->
      
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> Autos Usados <small></small></h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title m-0">Nuestro Inventario</h5>
              </div>
              <div class="card-body">
                <div class="row" id="cars">
                        
                </div>
                <div class="row">
                    
                </div>
              </div>
            </div>

            
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    
  </footer>


  <div class="modal fade" id="ajax-modal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="formModal"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <form id="usuarioForm" autocomplete="off" name="usuarioForm" class="form-horizontal">
                      <div class="row">
                      <div class="col-md-6 col-sm-6 col-12">
                        <div class="info-box">
                          <span class="info-box-icon bg-info"><i class="fas fa-car-side"></i></span>

                          <div class="info-box-content">
                            <span id="marcaC" class="info-box-text"></span>
                            <span id="modeloC" class="info-box-number"></span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control text-uppercase" placeholder="nombre"  
                             id="nombre" name="nombre" required>
                          </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Apellidos</label>
                                <input type="text" class="form-control text-uppercase" placeholder="Apellidos"
                                id="apellido" name="apellido" maxlength="90" required>
                            </div>
                            <input type="hidden" id="id_vehiculo" name="id_vehiculo">
                         </div>
                        <div class="col-sm-4">
                            <!-- text input -->
                            <div class="form-group">
                              <label>Telefono</label>
                                <div class="input-group mb-3">
                                    <!-- /btn-group -->
                                    <input type="text" class="form-control text-uppercase" id="telefono" 
                                    name="telefono" placeholder="Telefono del cliente" required>
                                    
                                </div>
                            </div>
                        </div>
                      </div>
                      
                      <div class="row" >
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo" required>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Comentario</label>
                                    <textarea class="form-control" name="comentario" id="" cols="30" rows="6"></textarea>
                                </div>
                            </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn-save" value="create">Guardar</button>
                  </div>
                </form>
              </div>
          </div>
      
        </div>


        <div class="modal fade" id="modalDetalles" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll;">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     
      <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 id="marca"></h1>
          </div>
          <div class="col-sm-6">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
              <h3  class="d-inline-block d-sm-none"></h3>
              <div class="col-12">
                <img id="img2" src="" class="product-image" alt="Product Image">
              </div>
              <div class="col-12 product-image-thumbs">
                <!-- <div class="product-image-thumb active"><img id="img1" src="" alt="Product Image"></div>
                <div class="product-image-thumb" ><img src="" id="img3" alt="Product Image"></div>
                <div class="product-image-thumb" ><img src="" id="img4" alt="Product Image"></div> -->
                <div class="card-body">
                <div class="row">
                  <div class="col-sm-2">
                    <a id="imge1" href="" data-toggle="lightbox" data-title="" data-gallery="gallery">
                      <img id="img1" src="" class="img-fluid mb-2" alt=""/>
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a id="imge3" href="" data-toggle="lightbox" data-title="" data-gallery="gallery">
                      <img id="img3" src="" class="img-fluid mb-2" alt=""/>
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a id="imge4" href="" data-toggle="lightbox" data-title="" data-gallery="gallery">
                      <img id="img4" src="" class="img-fluid mb-2" alt=""/>
                    </a>
                  </div>
                  
                </div>
              </div>
                
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <h3 id="modelo" class="my-3"></h3>
              <p id="observaciones"></p>

              <hr>

              <div class="bg-gray py-2 px-3 mt-4">
                <h2 id="precio" class="mb-0">
                
                </h2>
                <h4 class="mt-0">
                  
                </h4>
              </div>

              <div class="mt-4">
                <!-- <div class="btn btn-primary btn-lg btn-flat">
                  <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                  Contactar
                </div> -->

                
              </div>

              <div class="mt-4 product-share">
                <a href="#" class="text-gray">
                  <i class="fab fa-facebook-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fab fa-twitter-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fas fa-envelope-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fas fa-rss-square fa-2x"></i>
                </a>
              </div>

              

            </div>
          </div>
          
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      
      </div>
    </div>
  </div>
</div>


</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->

</body>
</html>
<script src="<?php echo base_url();?>theme/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script>
    $(document).ready(function() {
          
        $.ajax({ 
                url: "vehiculo/getAllVehiculos/",
                type: "POST",
                dataType: 'json',
                success: function (res) {
                    //console.log(res)
                    let contenido = document.getElementById("cars");
                    console.log(res.data)

                        res.data.forEach(element => {
                        var data_str = encodeURIComponent(JSON.stringify(element));    
                        var datastr = encodeURIComponent(JSON.stringify(element));
                        contenido.innerHTML += `
                    
                                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                              <div class="card bg-light">
                                <div class="card-header text-muted border-bottom-0">
                                  <b>${element.marcaV}</b> 
                                </div>
                                <div class="card-body pt-0">
                                  <div class="row">
                                    <div class="col-7">
                                      <h2 class="lead"><b>${element.modeloV}</b></h2>
                                      <p class="text-muted text-sm"><b>Precio: $</b>${element.precio} </p>
                                      <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"></span> Año: ${element.año}</li>
                                        
                                      </ul>
                                    </div>
                                    <div class="col-5 text-center">
                                      <img src="${element.foto3}" alt="" class="img img-fluid">
                                    </div>
                                  </div>
                                </div>
                                <div class="card-footer">
                                  <div class="text-right" id="botones">
                                    <a data-toggle="modal" class="btn btn-sm bg-teal contactar ${element.id_vehiculo}" data-target="${datastr}" id="contactar">
                                      <i class="fas fa-comments"> Contactar</i>
                                    </a>
                                    <a  class="btn btn-sm btn-primary detalles" data-toggle="modal" data-target="${data_str}" id="${element.id_vehiculo}" >
                                      <i class="fas fa-plus"></i> Detalles
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                                    `;

                    
                    
                })
                   res.data.forEach(dt => {
                    let ids = "#" + dt.id_vehiculo
                    let my_object
                        $(ids).click(function(){
                           // console.log(this)
                           // console.log($(this).data("target"))
                             my_object = JSON.parse(decodeURIComponent($(this).data("target")));
                            console.log(my_object)
                            $("#modalDetalles").modal('show')
                            $("#marca").html(my_object.marcaV)
                            $("#modelo").html(my_object.modeloV)
                            $("#img1").attr("src", my_object.foto1)
                            $("#img2").attr("src", my_object.foto2)
                            $("#img3").attr("src", my_object.foto3)
                            $("#img4").attr("src", my_object.foto4)
                            $("#imge1").attr("href", my_object.foto1)
                            $("#imge2").attr("href", my_object.foto2)
                            $("#imge3").attr("href", my_object.foto3)
                            $("#imge4").attr("href", my_object.foto4)
                            $("#precio").html("$"+my_object.precio)
                            $("#observaciones").html(my_object.observaciones)
                            
                        })

                      let idsC = "." + dt.id_vehiculo
                      $(idsC).click(function(){
                        let object = JSON.parse(decodeURIComponent($(this).data("target")));
                        console.log(object)
                        $("#ajax-modal").modal('show')
                        $("#marcaC").html(object.marcaV)
                        $("#modeloC").html(object.modeloV)
                        $("#id_vehiculo").val(object.id_vehiculo)
                      })
                   })
                  
                },
                error: function (data) {
                  
                }
          });

          


          $("#usuarioForm").validate({
          rules: {
            nombre: {required: true, maxlength: 60,},
            apellido: {required: true, maxlength: 60 },
            codigoUsuario: {required: true, maxlength: 20 },
            id_rol: { required: true },
            id_ccostos: {required: true },
            ip: { maxlength: 24  }
          },
          messages: {
            nombre: { required: "Ingrese el nombre del Usuario",  maxlength: jQuery.validator.format("Por favor, no ingrese mas de {0} caracteres")},
            pass: { required: "Ingrese el password del Usuario", maxlength: jQuery.validator.format("Por favor, no ingrese mas de {0} caracteres")},
            codigoUsuario: { required: "Ingrese el codigo del Usuario", maxlength: jQuery.validator.format("Por favor, no ingrese mas de {0} caracteres")},
            id_rol: {required: "Seleccione el rol del usuario"},
            id_ccostos: {required: "Seleccione el centro de costos asignado al usuario"},
            ip: { maxlength: jQuery.validator.format("Por favor, no ingrese mas de {0} caracteres") },
         },
         errorElement: 'span',
          errorPlacement: function (error, element) {
              error.addClass('invalid-feedback');
              element.closest('.form-group').append(error);

              if (element.parent('.input-group').length) { 
                  error.insertAfter(element.parent());      // radio/checkbox?
              } else if (element.hasClass('select2')) {     
                  error.insertAfter(element.next('span'));  // select2
              } else {                                      
                  error.insertAfter(element);               // default
              }
          },
          highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
          },
         submitHandler: function (form) {
            var actionType = $('#btn-save').val();
            var urlRequest = '';
            var dataRequest = '';

            if(actionType == 'create'){
              urlRequest = 'solicitudes/store';
              dataRequest = $('#usuarioForm').serialize();
            } 

            $('#btn-save').prop('disabled',true);
            $('#btn-save').html('Guardando..');
 
            $.ajax({
               data: dataRequest,
               url: urlRequest,
               type: "POST",
               dataType: 'json',
               success: function (res) {
                if(res.status == true){
                    Swal.fire({
                      type: 'success',
                      title: 'Exito',
                      text: 'Su registro ha sido guardado',
                      footer: ''
                    })
                    
                    $('#usuarioForm').trigger("reset");
                    $('#ajax-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    $('#btn-save').prop('disabled', false);

                 }  else {
                    Swal.fire({
                      type: 'warning',
                      title: 'Hubo un problema',
                      text: 'Su registro no ha podido ser guardado, por favor verifique que los datos ingresados son correctos',
                      footer: ''
                    })
                    $('#btn-save').html('Guardar');
                    $('#btn-save').prop('disabled', false);
                 }
               },
               error: function (data) {
                Swal.fire({
                  type: 'error',
                  title: 'Error...',
                  text: 'No se pudo completar su peticion!',
                  footer: ''
                })
                $('#btn-save').html('Guardar');
                $('#btn-save').prop('disabled', false);
                console.log('Error:', data);
               }
            });
         }
      })

          
    
    });

    $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>

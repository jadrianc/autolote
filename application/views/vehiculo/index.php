  <!-- Content Wrapper. Contains page content -->
  <style>
      .preview-images-zone {
    width: 100%;
    border: 1px solid #ddd;
    min-height: 180px;
    /* display: flex; */
    padding: 5px 5px 0px 5px;
    position: relative;
    overflow:auto;
}
.preview-images-zone > .preview-image:first-child {
    height: 185px;
    width: 185px;
    position: relative;
    margin-right: 5px;
}
.preview-images-zone > .preview-image {
    height: 90px;
    width: 90px;
    position: relative;
    margin-right: 5px;
    float: left;
    margin-bottom: 5px;
}
.preview-images-zone > .preview-image > .image-zone {
    width: 100%;
    height: 100%;
}
.preview-images-zone > .preview-image > .image-zone > img {
    width: 100%;
    height: 100%;
}
.preview-images-zone > .preview-image > .tools-edit-image {
    position: absolute;
    z-index: 100;
    color: #fff;
    bottom: 0;
    width: 100%;
    text-align: center;
    margin-bottom: 10px;
    display: none;
}
.preview-images-zone > .preview-image > .image-cancel {
    font-size: 18px;
    position: absolute;
    top: 0;
    right: 0;
    font-weight: bold;
    margin-right: 10px;
    cursor: pointer;
    display: none;
    z-index: 100;
}
.preview-image:hover > .image-zone {
    cursor: move;
    opacity: .5;
}
.preview-image:hover > .tools-edit-image,
.preview-image:hover > .image-cancel {
    display: block;
}
.ui-sortable-helper {
    width: 90px !important;
    height: 90px !important;
}

.container {
    padding-top: 50px;
}
  </style>
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $title; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>inicio">Inicio</a></li>
              <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-gray-dark">
        <div class="card-header">
          <h3 class="card-title">Listado de <?php echo $title; ?></h3>

          <div class="card-tools">
              <a href="javascript:void(0)" class="btn btn-primary ml-3" id="create-new"><i class="fas fa-plus"></i> Agregar nuevo/a</a>
          </div>
        </div>
        <div class="card-body">
          <table id="usuario_list" class="table table-bordered table-hover table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Año</th>
                        <th>Precio</th>
                        <th>Observaciones</th>
                        <th>Estado</th>
                        
                        <th style="width: 20%">Opciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        
          <div class="modal fade" id="ajax-modal" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="formModal"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <form id="usuarioForm" method="POST" role="form" autocomplete="on" name="usuarioForm" class="form-horizontal" enctype="multipart/form-data">
                      
                      <div class="row">
                        <div class="col-sm-4">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Marca</label>
                            <select class="form-control select2 select2-info" name="marca" id="marca" 
                                data-dropdown-css-class="select2-info" style="width: 100%;" required> </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Modelo</label>
                                <select class="form-control select2 select2-info" name="modelo" id="modelo" 
                                data-dropdown-css-class="select2-info" style="width: 100%;" required> </select>
                            </div>
                         </div>
                        <div class="col-sm-2">
                            <!-- text input -->
                            <div class="form-group">
                              <label>Año</label>
                                <div class="input-group mb-3">
                                    <!-- /btn-group -->
                                    <input type="text" class="form-control text-uppercase" id="año" 
                                    name="año" placeholder="Año" required>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Precio</label>
                                <input type="text" class="form-control text-uppercase" id="precio" 
                                    name="precio" placeholder="Precio" required>
                            </div>
                        </div>
                      </div>
                      <div class="row" >
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Nombre Contanto</label>
                                <input type="text" class="form-control" id="nombreContacto" 
                                    name="nombreContacto" placeholder="Nombre contacto" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Telefono</label>
                                <input type="text" class="form-control" id="telefono" 
                                    name="telefono" placeholder="Telfono contacto" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Direccion</label>
                                <input type="text" class="form-control" id="direccion" 
                                    name="direccion" placeholder="Direccion contacto" required>
                            </div>
                        </div>
                      </div>
                      <div class="row" >
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <input type="text" class="form-control" id="observaciones" 
                                    name="observaciones" placeholder="Observaciones" required>
                            </div>
                        </div>
                      </div>

                      <div class="row" >
                            <div class="col-md-12" id="images">
                            
                                <fieldset class="form-group">
                                      <a class="btn btn-info" href="javascript:void(0)" onclick="$('#pro-image').click()">Subir Imagenes</a>
                                      <input type="file" id="pro-image" name="pro-image[]" style="display: none;" class="form-control" multiple>
                                  </fieldset>
                                  <div class="preview-images-zone">
                                      
                                  </div>
                              </div>
                              <div class="col-md-5" id="estados">
                                <div class="form-group">
                                  <label for="">Estado</label>
                                  <select class="form-control select2 select2-info" name="estadoV" id="estadoV" 
                                  data-dropdown-css-class="select2-info" style="width: 100%;" required> 
                                  <option value="Disponible">Disponible</option>
                                  <option value="Vendido">Vendido</option>
                                  <option value="Proceso de Venta">Proceso de Venta</option>
                                </select>
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
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script>




$(document).ready(function() {
    document.getElementById('pro-image').addEventListener('change', readImage, false);
    
    $( ".preview-images-zone" ).sortable();
    
    $(document).on('click', '.image-cancel', function() {
        let no = $(this).data('no');
        $(".preview-image.preview-show-"+no).remove();
    });
});



var num = 4;
function readImage() {
    if (window.File && window.FileList && window.FileReader) {
        var files = event.target.files; //FileList object
        var output = $(".preview-images-zone");

        for (let i = 0; i < files.length; i++) {
            var file = files[i];
            if (!file.type.match('image')) continue;
            
            var picReader = new FileReader();
            
            picReader.addEventListener('load', function (event) {
                var picFile = event.target;
                var html =  '<div class="preview-image preview-show-' + num + '">' +
                            '<div class="image-cancel" data-no="' + num + '">x</div>' +
                            '<div class="image-zone"><img id="pro-img-' + num + '" src="' + picFile.result + '"></div>' +
                            '<div class="tools-edit-image"><a href="javascript:void(0)" data-no="' + num + '" class="btn btn-light btn-edit-image">edit</a></div>' +
                            '</div>';

                output.append(html);
                num = num + 1;
            });

            picReader.readAsDataURL(file);
        }
       // $("#pro-image").val('');
    } else {
        console.log('Browser not support');
    }
}

$(document).ready(function() {

   //Check File API support
   if(window.File && window.FileList && window.FileReader)
    {
        var filesInput = document.getElementById("files");
        filesInput.addEventListener("change", function(event){
            var files = event.target.files; //FileList object
            var output = document.getElementById("result");
            for(var i = 0; i< files.length; i++)
            {
                var file = files[i];
                //Only pics
                if(!file.type.match('image'))
                    continue;
                var picReader = new FileReader();
                picReader.addEventListener("load",function(event){
                    var picFile = event.target;
                    var div = document.createElement("div");
                    div.innerHTML = "<img class='thumbnail' src='" + picFile.result + "'" +
                    "title='" + picFile.name + "'/>";
                    output.insertBefore(div,null);
                });
                //Read the image
                picReader.readAsDataURL(file);
            }
        });
    }
    else
    {
        console.log("Your browser does not support File API");
    }
    


    $('#telefono').on('keydown', function (event) {
        if (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 37 || event
            .keyCode == 39) {} else {
            if ((event.keyCode > 47 && event.keyCode < 60) || (event.keyCode > 95 && event.keyCode < 106)) {
                inputval = $(this).val();
                var string = inputval.replace(/[^0-9]/g, "");
                var bloc1 = string.substring(0, 4);
                var bloc2 = string.substring(4, 7);
                var string = bloc1 + "-" + bloc2;
                $(this).val(string);
            } else {
                event.preventDefault();
            }

        }
    });
     
});

  $(document).ready(function() {
    $('#li-vehiculo').removeClass('nav-link').addClass('nav-link active');


    var estados = [
      {
        id: 0,
        text: 'Vendido'
    },
    {
        id: 1,
        text: 'Disponible'
    },
    {
        id: 2,
        text: 'Proceso de Venta'
    }
    ]
    
    $("#estadoV").select2({
          placeholder: "Seleccione estado vehiculo"
          
      });

      $("#estados").hide()

    $("#marca").change(function(){
        $(this).valid(); 
      });

      $("#modelo").change(function(){
        $(this).valid(); 
      });

    let VEHICULO = '';
    var table = $('#usuario_list').DataTable({
          language: {
              "decimal": "",
              "emptyTable": "No hay información",
              "info": "Mostrando _START_ a _END_ de _TOTAL_ Datos",
              "infoEmpty": "Mostrando 0 to 0 of 0 Datos",
              "infoFiltered": "(Filtrado de _MAX_ total Datos)",
              "infoPostFix": "",
              "thousands": ",",
              "lengthMenu": "Mostrar _MENU_ Datos",
              "loadingRecords": "Cargando...",
              "processing": "Procesando...",
              "search": "Buscar:",
              "zeroRecords": "Sin resultados encontrados",
              "paginate": {
                  "first": "Primero",
                  "last": "Ultimo",
                  "next": "Siguiente",
                  "previous": "Anterior"
              }
          },
        "ajax": {
            "url": "vehiculo/getAllVehiculos",
            "type": "GET",
            
        },
        "columns": [
            { "data": "marcaV" },
            { "data": "modeloV" },
            { "data": "año" },
            { "data": "precio" },
            { "data": "observaciones" },
            { "data": "estado" }
            
        ],
        "columnDefs": [ {
            "targets": 6,
            "data": null,
            "class": "project-actions text-center",
            "defaultContent": "<button class='btn btn-success btn-sm btn-edit'><i class='fas fa-pen'></i> </button>  &nbsp; <button class='btn btn-danger btn-sm btn-delete'><i class='fas fa-trash'></i> </button> &nbsp; "
        } ]
    });


      $("#marca").select2({
          placeholder: "Seleccione Marca Vehiculo",
          ajax: { 
            url: 'vehiculo/getSelect2Marca',
            type: "post",
            dataType: 'json',
            delay: 150,
            data: function (params) {
                return {
                  searchTerm: params.term
                };
            },
            processResults: function (response) {
                return {
                  results: response
                };
            }
          }
      });

      $("#modelo").select2({
          placeholder: "Seleccione Modelo Vehiculo",
          ajax: { 
            url: 'vehiculo/getSelect2Modelo',
            type: "post",
            dataType: 'json',
            delay: 150,
            data: function (params) {
                return {
                  searchTerm: params.term
                };
            },
            processResults: function (response) {
                return {
                  results: response
                };
            }
          }
      });

      
        

    $('#usuario_list tbody').on('click', '.btn-edit', function () {
        var data = table.row( $(this).parents('tr') ).data();
        console.log(data)
        $("#images").hide()
        $("#estados").show()
          $.ajax({ 
                url: "vehiculo/getVehById/"+data['id_vehiculo'],
                type: "GET",
                dataType: 'json',
                success: function (res) {
                  if(res.success){
                    $('#usuarioForm').trigger("reset");
                    $('#formModal').html("Editar Vehiculo");
                    $('#btn-save').val("update");
                    setForm(res.data);
                    $('#ajax-modal').modal('show');
                  } else {
                    Swal.fire({
                    type: 'warning',
                    title: 'Error...',
                    text: 'No se encontrol el recurso seleccionado',
                    footer: ''
                  })
                  }
                },
                error: function (data) {
                  Swal.fire({
                    type: 'error',
                    title: 'Error...',
                    text: 'No se pudo completar su peticion!',
                    footer: ''
                  })
                  console.log('Error:', data);
                }
          });
    });


    $('#usuario_list tbody').on('click', '.btn-delete', function () {
        var data = table.row( $(this).parents('tr') ).data();
          Swal.fire({
          title: 'Esta seguro de borrar este Vehiculo: ?',
          text: "Este proceso es irreversible!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, deseo borrarlo',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {
            $.ajax({ 
                url: "vehiculo/delete/"+data['id_vehiculo'],
                type: "GET",
                dataType: 'json',
                success: function (res) {
                  Swal.fire(
                    'Eliminado!',
                    'Su dato ha sido eliminado con exito.',
                    'success'
                  )
                  table.ajax.reload();
                },
                error: function (data) {
                  Swal.fire({
                    type: 'error',
                    title: 'Error...',
                    text: 'No se pudo completar su peticion!',
                    footer: ''
                  })
                  console.log('Error:', data);
                }
             });
          }
        })
    });

    function setNullSelect2(){
       
        $('#marca').val(null).trigger('change');
        $('#modelo').val(null).trigger('change');
      }

    function setForm(data){
     
      VEHICULO = data['id_vehiculo'];
   
      
      $('#precio').val(data['precio']);
      $('#año').val(data['año']);
      $('#nombreContacto').val(data['nombre_contacto']);
      $('#telefono').val(data['telefono_contacto']);
      $('#direccion').val(data['direccion_contacto']);
      $('#observaciones').val(data['observaciones']);

      var cRolSelect = $('#marca');
      var option = new Option(data['id_marca']+ ' - ' + data['marcaV'], data['id_marca'], true, true);
      cRolSelect.append(option).trigger('change');

      cRolSelect.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });

        var cRolSelect = $('#modelo');
        var option = new Option(data['id_modelo']+ ' - ' + data['modeloV'], data['id_modelo'], true, true);
        cRolSelect.append(option).trigger('change');

        cRolSelect.trigger({
                type: 'select2:select',
                params: {
                    data: data
                }
            }); 

      var cEstSelect = $('#estadoV');
      var option = new Option(data['estado'], data['estado'], true, true);
      cEstSelect.append(option).trigger('change');

      cEstSelect.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });
            
    }

    $('#create-new').click(function () {
        
         $("#estados").hide()
         $("#images").show()
         $('#btn-save').val("create");
         $('#usuarioForm').trigger("reset");
         $('#formModal').html("Agregar Nuevo Vehiculo");
         $('#ajax-modal').modal('show');
         setNullSelect2();
         
      });

    if ($("#usuarioForm").length > 0) {

        $("#usuarioForm").validate({
          rules: {
            nombre: {required: true, maxlength: 60,},
            apellido: {required: true, maxlength: 60 },
            codigoUsuario: {required: true, maxlength: 20 },
            marca: { required: true },
            modelo: { required: true },
            id_ccostos: {required: true },
            ip: { maxlength: 24  }
          },
          messages: {
            nombre: { required: "Ingrese el nombre del Usuario",  maxlength: jQuery.validator.format("Por favor, no ingrese mas de {0} caracteres")},
            pass: { required: "Ingrese el password del Usuario", maxlength: jQuery.validator.format("Por favor, no ingrese mas de {0} caracteres")},
            codigoUsuario: { required: "Ingrese el codigo del Usuario", maxlength: jQuery.validator.format("Por favor, no ingrese mas de {0} caracteres")},
            marca: {required: "Seleccione marca automovil"},
            modelo: {required: "Seleccione modelo automovil"},
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
              urlRequest = 'vehiculo/store';
              var data = new FormData($("#usuarioForm")[0]);
            } else if(actionType == 'update') {
              urlRequest = 'vehiculo/update';
              var data = new FormData($("#usuarioForm")[0]);
              
              data.append('id_vehiculo', VEHICULO)

              //dataRequest = $('#usuarioForm').serialize() + '&id_Vehiculo=' + VEHICULO
            }

            $('#btn-save').prop('disabled',true);
            $('#btn-save').html('Guardando..');
 
            $.ajax({
                data: data,
               url: urlRequest,
               type: "POST",
               dataType: 'json',
               contentType: false,
               processData: false,
               success: function (res) {
                if(res.status == true){
                    Swal.fire({
                      type: 'success',
                      title: 'Exito',
                      text: 'Su registro ha sido guardado',
                      footer: ''
                    })
                    table.ajax.reload();
                    $('#usuarioForm').trigger("reset");
                    $('#ajax-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    $('#btn-save').prop('disabled', false);
                    location.reload();
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
   } 
  });
 </script>
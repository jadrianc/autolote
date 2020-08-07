  <!-- Content Wrapper. Contains page content -->
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
          <h3 class="card-title">Listado de Solicitudes</h3>

          <div class="card-tools">
              
          </div>
        </div>
        <div class="card-body">
          <table id="usuario_list" class="table table-bordered table-hover table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Correlativo</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Fecha y hora</th>
                        <th>Estado</th>
                        <th style="width: 20%">Opciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        
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
                      
                      <div class="card">
                          <div class="card-header" class="bg-primary color-palette">
                                <h5>Asignar Solicitud de Compra</h5>
                          </div>
                          <div class="card-body">
                            <div class="alert alert-info alert-dismissible">
                                    
                                    <h5 ><i class="icon fas fa-car"></i> <span id="marca"></span></h5>
                                    <h6>Cliente: <span id="nombre"></span></h6>
                                    <h6></h6>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Vendedor</label>
                                        <select class="form-control select2 select2-info" name="vendedor" id="vendedor" 
                                        data-dropdown-css-class="select2-info" style="width: 100%;" required> </select>
                                    </div>
                                </div>
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
 <script>

  $(document).ready(function() {
    $('#li-asignaciones').removeClass('nav-link').addClass('nav-link active');

    $("#vendedor").select2({
          placeholder: "Seleccione Vendedor a Asignar",
          ajax: { 
            url: 'usuarios/getSelectVendedores',
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

    let USER = '';
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
            "url": "asignaciones/getAllSolicitudes",
            "type": "GET",
            
        },
        "columns": [
            { "data": "id_solicitud" },
            { "data": "nombre" },
            { "data": "apellido" },
            { "data": "telefono" },
            { "data": "correo" },
            { "data": "marca" },
            { "data": "modelo" },
            { "data": "fecha" },
            { "data": "estadoSolicitud" }
            
        ],
        "columnDefs": [ {
            "targets": 9,
            "data": null,
            "class": "project-actions text-center",
            "defaultContent": " <button id='editarAsignacion' class='btn btn-success btn-sm btn-editar'><i class='far fa-edit'></i> </button> &nbsp; <button id='asignacionB' class='btn btn-warning btn-sm btn-edit'><i class='fas fa-user-check'></i> </button> &nbsp;  <button class='btn btn-info btn-sm btn-delete'><i class='fas fa-eye'></i> </button> &nbsp; "
        } ]
    });


    table.on( 'draw', function () {
            $('#usuario_list tr').each(function() { 


               var estado = $(this).find("td:nth-child(9)").html();
               console.log(estado)
              
              var asignar = $(this).find('#asignacionB');
              var editar = $(this).find('#editarAsignacion');
             

              
              if(estado === 'Asignado'){
                asignar.attr('disabled','disabled');
              }

               if(estado === 'Pendiente'){
                editar.attr('disabled','disabled');
               }

              // if(estado == "DESCARGADO"){
              //   buttonRevertir.attr('disabled','disabled');
              //   buttonReasinar.attr('disabled','disabled');
              // }
              
             
              });
          } );


      $("#id_rol").select2({
          placeholder: "Seleccione un Rol de Usuario",
          ajax: { 
            url: 'roles/getSelect2',
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

      
        

      $('#usuario_list tbody').on('click', '.btn-editar', function () {
        var data = table.row( $(this).parents('tr') ).data();
        //console.log(data)
          $.ajax({ 
                url: "asignaciones/getById/"+data['id_solicitud'],
                type: "GET",
                dataType: 'json',
                success: function (res) {
                  console.log(res)
                  if(res.success){
                    $('#usuarioForm').trigger("reset");
                    $('#formModal').html("Editar Asignacion");
                    $('#btn-save').val("update");
                    setFormAs(res.data);
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

    // $('#usuario_list tbody').on('click', '.btn-editar', function () {
    //     var data = table.row( $(this).parents('tr') ).data();
    //     console.log(data)
          
    //     // $('#usuarioForm').trigger("reset");
    //     // $('#formModal').html("Editar Usuario");
    //     // $('#btn-save').val("update");
    //     setForm(data);
    //     $('#ajax-modal').modal('show');
                  
         
    // });


    $('#usuario_list tbody').on('click', '.btn-delete', function () {
        var data = table.row( $(this).parents('tr') ).data();
          Swal.fire({
          title: 'Esta seguro de borrar al usuario: '+ data['nombres'] + '?',
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
                url: "clientes/delete/"+data['id_cliente'],
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
       
        $('#id_rol').val(null).trigger('change');
      }

    function setForm(data){

        console.log(data)
     $("#marca").html(data.marca)
     $("#nombre").html(data.nombre + " " + data.apellido)
     VEHICULO = data['id_vehiculo'];
     SOLICITUD = data['id_solicitud'];
    //   $('#nombre').val(data['nombres']);
    //   $('#apellido').val(data['apellidos']);
    //   $('#dui').val(data['dui']);
    //   $('#telefono').val(data['telefono']);
    //   $('#direccion').val(data['direccion']);
    //   $('#correo').val(data['correo']);
              
    }

   
    function setFormAs(data){
      ASIGNACION = data["id_asignacion"]
      var cRolSelect = $('#vendedor');
            var option = new Option(data['id_usuario']+ ' - ' + data['nombre'], data['id_usuario'], true, true);
            cRolSelect.append(option).trigger('change');

            cRolSelect.trigger({
                  type: 'select2:select',
                  params: {
                      data: data
                  }
              });
    }

    $('#create-new').click(function () {
        
         
         $('#btn-save').val("create");
         $('#usuarioForm').trigger("reset");
         $('#formModal').html("Agregar Nuevo Cliente");
         $('#ajax-modal').modal('show');
         setNullSelect2();
         
      });

    if ($("#usuarioForm").length > 0) {

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
              urlRequest = 'asignaciones/store';
              dataRequest = $('#usuarioForm').serialize() + '&id_vehiculo=' + VEHICULO + '&id_solicitud=' + SOLICITUD
            } else if(actionType == 'update') {
          
              urlRequest = 'asignaciones/update';
              dataRequest = $('#usuarioForm').serialize() + '&id_asignacion=' + ASIGNACION
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
                    table.ajax.reload();
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
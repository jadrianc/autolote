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
              <li class="breadcrumb-item"><a href="#">Transito</a></li>
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
          <table id="marca_list" class="table table-bordered table-hover table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Tipo Licencia</th>
                        <th>Descripcion</th>
                        <th style="width: 20%">Opciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        
          <div class="modal fade" id="ajax-modal" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="formModal"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <form id="marcaForm" autocomplete="off" name="marcaForm" class="form-horizontal">
                      
                              <input type="hidden" class="form-control" id="id_clase" name="id_clase" value="0" 
                              placeholder="Ingrese un Codigo a la Marca" value="" maxlength="5" required>
                          
                        <div class="form-group">
                          <label for="name" class="col-sm-3 control-label">Codigo Licencia</label>
                          <div class="col-sm-12">
                              <input type="text" class="form-control text-uppercase" id="licencia" name="licencia" 
                              placeholder="Ingrese Codigo Licencia" value="" maxlength="60" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="name" class="col-sm-3 control-label">Descripción</label>
                          <div class="col-sm-12">
                              <input type="text" class="form-control text-uppercase" id="descripcion" name="descripcion" 
                              placeholder="Ingrese Descripcion" value="" maxlength="60" required>
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
    $('#li-op-armas').removeClass('nav-item has-treeview').addClass('nav-item has-treeview menu-open');
    $('#li-armas').removeClass('nav-link').addClass('nav-link active');
    $('#li-Amarca').removeClass('nav-link').addClass('nav-link active');

    var table = $('#marca_list').DataTable({
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
            "url": "TipoLicencia/getAll",
            "type": "GET",
            'beforeSend': function (request) {
                request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }
        },
        "columns": [
            { "data": "ID_FILA" },
            { "data": "CODIGO" },
            { "data": "DESCRIPCION" }
        ],
        "columnDefs": [ {
            "targets": 3,
            "class": "project-actions text-center",
            "data": null,
            "defaultContent": "<button class='btn btn-info btn-sm btn-edit'><i class='fas fa-pen'></i> </button> &nbsp; <button class='btn btn-danger btn-sm btn-delete'><i class='fas fa-trash'></i> </button>"
        } ]
    });

    $('#marca_list tbody').on('click', '.btn-edit', function () {
        var data = table.row( $(this).parents('tr') ).data();
          $.ajax({ 
                url: "TipoLicencia/getById/"+data['ID_FILA'],
                type: "GET",
                beforeSend: function (request) {
     request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                dataType: 'json',
                success: function (res) {
                  if(res.success == true){
                    $('#marcaForm').trigger("reset");
                    $('#formModal').html("Editar Tipo Licencia");
                    $('#btn-save').val("update");
                    setForm(res.data);
                    $('#ajax-modal').modal('show');
                  } else {
                    Swal.fire({
                    type: 'warning',
                    title: 'Error...',
                    text: 'No se encontrol el recurso seleccionado',
                    footer: 'TRANSITO'
                  })
                  }
                },
                error: function (data) {
                  Swal.fire({
                    type: 'error',
                    title: 'Error...',
                    text: 'No se pudo completar su peticion!',
                    footer: 'TRANSITO'
                  })
                  console.log('Error:', data);
                }
          });
    });

    $('#marca_list tbody').on('click', '.btn-delete', function () {
        var data = table.row( $(this).parents('tr') ).data();
          Swal.fire({
          title: 'Esta seguro de borrar el dato: '+ data['DESCRIPCION'] + '?',
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
                url: "TipoLicencia/delete/"+data['ID_FILA'],
                type: "GET",
                beforeSend: function (request) {
     request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                dataType: 'json',
                success: function (res) {
                  if(res.status == true){
                  Swal.fire(
                    'Eliminado!',
                    'Su dato ha sido eliminado con exito.',
                    'success' )
                    table.ajax.reload();
                  }
                  else {
                    Swal.fire({
                      type: 'error',
                      title: 'Imposible eliminar',
                      text: 'Este dato esta siendo usado en otro lado',
                      footer: 'TRANSITO'
                    })
                  }
                },
                error: function (data) {
                  Swal.fire({
                    type: 'error',
                    title: 'Error...',
                    text: 'No se pudo completar su peticion!',
                    footer: 'TRANSITO'
                  })
                  console.log('Error:', data);
                }
             });
          }
        })
    });

    function setForm(data){
      console.log(data);
      $("#id_clase").prop('readonly', true);
      $('#id_clase').val(data['ID_FILA']);
      $('#licencia').val(data['CODIGO']);
      $('#descripcion').val(data['DESCRIPCION']);
    }

    $('#create-new').click(function () {
         $("#id_marca").prop('readonly', false);
         $('#btn-save').val("create");
         $('#marcaForm').trigger("reset");
         $('#formModal').html("Agregar Tipo Licencia");
         $('#ajax-modal').modal('show');
      });

    if ($("#marcaForm").length > 0) {

        $("#marcaForm").validate({
          rules: {
            id_marca: { maxlength: 10, number: true },
            marca: { maxlength: 60 },
          },
          messages: {
            id_marca: {number: "Por favor ingrese un numero valido", required: "Ingrese el codigo de la Marca",  maxlength: jQuery.validator.format("Por favor, no ingrese mas de {0} caracteres")},
            marca: {required: "Ingrese el nombre de la Marca",  maxlength: jQuery.validator.format("Por favor, no ingrese mas de {0} caracteres")}
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
            
            if(actionType == 'create'){
              urlRequest = 'TipoLicencia/store';
            } else if(actionType == 'update') {
              urlRequest = 'TipoLicencia/update';
            }

            $('#btn-save').prop('disabled',true);
            $('#btn-save').html('Guardando..');
 
            $.ajax({
               data: $('#marcaForm').serialize(),
               url: urlRequest,
               type: "POST",
               beforeSend: function (request) {
     request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
               },
               dataType: 'json',
               success: function (res) {
                 if(res.status == true){
                    Swal.fire({
                      type: 'success',
                      title: 'Exito',
                      text: 'Su registro ha sido guardado',
                      footer: 'TRANSITO'
                    })
                    table.ajax.reload();
                    $('#marcaForm').trigger("reset");
                    $('#ajax-modal').modal('hide');
                    $('#btn-save').html('Guardar');
                    $('#btn-save').prop('disabled', false);
                 } else {
                    Swal.fire({
                      type: 'warning',
                      title: 'Hubo un problema',
                      text: 'Su registro no ha podido ser guardado, por favor verifique que los datos ingresados son correctos',
                      footer: 'TRANSITO'
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
                  footer: 'TRANSITO'
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
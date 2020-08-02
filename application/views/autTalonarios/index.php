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
                        <th>Oni Autorizado</th>
                        <th>Unidad</th>
                        <th>Cantidad</th>
                        <th>Fecha Autorizacion</th>
                        <th>Estado</th>
                        <th>Numero Autorizacion</th>
                        <th>Referencia</th>
                        <th>Observaciones</th>
                        <th style="width: 20%">Opciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

            <div class="card card-danger" id="div03">
          <div class="card-header">
              <h3 class="card-title" id="title-pdf">Documento PDF</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
          </div>

          

          <div class="card-body">
            <div class="row" id="drawPDF">
                  <div class="col-lg-12 col-12">
                    <!-- small card -->
                    <div class="small-box">
                      <div class="inner">
                        <h3>PDF</h3>

                        <p>Su PDF aparecera aqui</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-file-pdf"></i>
                      </div>
                      <a href="#" class="small-box-footer bg-danger">
                        TRANSITO</i>
                      </a>
                    </div>
                  </div>
              </div>
            <iframe width="100%" height="700" src="" id="viewReport"></iframe>
            </div>
        </div>
        
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
                    <form id="marcaForm" autocomplete="off" name="marcaForm" class="form-horizontal" enctype="multipart/form-data">
                      
                              <input type="hidden" class="form-control" id="id_clase" name="id_clase" value="0" 
                              placeholder="Ingrese un Codigo a la Marca" value="" maxlength="5" required>
                              <div class="form-group">
                            <label>ONI</label>
                            <div class="input-group mb-3">
                            <!-- /btn-group -->
                            <input placeholder="oni" type="text" class="form-control text-uppercase" id="oni_asignado" name="oni_asignado" required>
                            
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-info" id="searchONI-Asignado"><i class="fas fa-search"></i></button>
                            </div>
                            
                            
                            </div>
                            <p id="msj" style="color: red;">Oni no existe</p>
                        </div>
                        <div class="col-sm-12" id="divAsignado">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control text-uppercase" id="nombre" name="nombre" required readonly>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Unidad de Transito Asignado</label>
                                <select class="form-control select2 select2-info" name="id_unidad" id="id_unidad" 
                                data-dropdown-css-class="select2-info" style="width: 100%;" required> </select>
                            </div>
                         </div>
                        <div class="form-group">
                          <label for="name" class="col-sm-3 control-label">Cantidad</label>
                          <div class="col-sm-5">
                              <input type="number" class="form-control text-uppercase" id="cantidad" name="cantidad" 
                              placeholder="Ingrese Cantidad de talonarios" max="999" value="" maxlength="60" required>
                          </div>
                        </div>
                        <div class="form-group">
                            <label>Fecha Autorizacion *</label>
                                    <div class="input-group date" id="fechatraslado" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#fechatraslado" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                        </div>
                                        <input type="text" class="form-control datetimepicker-input" id="date_fechatraslado" name="fechatraslado"
                                        data-target="#fechatraslado" required/>
                                    </div>
                            
                            </div>
                            <div class="col-sm-12">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control select2 select2-info" name="estado" id="estado" 
                                data-dropdown-css-class="select2-info" style="width: 100%;" required> 
                                <option value="INACTIVO">Inactivo</option>
                                <option value="ACTIVO">Activo</option>
                                </select>
                            </div>

                         </div>
                         <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="">No. Documento</label>
                                <input type="text" placeholder="Numero de Documento" class="form-control" id="NumDocumento" name="NumDocumento" required>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="">Referencia</label>
                                <input type="text" placeholder="Referencia" class="form-control" id="referencia" name="referencia" required>
                              </div>
                            </div>
                         </div>
                         <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                            <label for="">Observaciones</label>
                              <textarea placeholder="Observaciones" class="form-control textarea" name="observaciones" id="observaciones" cols="20" rows="4"></textarea>
                            </div>
                          </div>
                         </div>
                         <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Seleccione Archivo PDF</label>
                                <input type="file" accept="application/pdf" class="form-control-file" id="file" name="file">
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

    $("#viewReport").hide();

    $('#fechatraslado').datetimepicker({
        format: 'L',
        locale: 'es',
        maxDate: $.now()
    });

    $("#id_unidad").change(function(){
        $(this).valid();
      });

    $('#msj').hide();

    $("#id_unidad").select2({
          placeholder: "Seleccione una Unidad de Transito",
          ajax: { 
            url: 'unidadesTransito/getSelect2',
            type: "post",
            dataType: 'json',
            beforeSend: function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            },
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

      function setNullSelect2(){
        $('#id_unidad').val(null).trigger('change');
        
      }

    $('#li-op-armas').removeClass('nav-item has-treeview').addClass('nav-item has-treeview menu-open');
    $('#li-armas').removeClass('nav-link').addClass('nav-link active');
    $('#li-Amarca').removeClass('nav-link').addClass('nav-link active');


    $("#oni_asignado").keyup(function(e){
        var id = $(this).val()
        console.log(id)
        if(id){
        $.ajax({
             type: "POST",
             url: "unidadesTransito/comprobar/"+id,
             dataType: "json",
              beforeSend: function (request) {
                    request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
              success: function(data){                                                      
                 console.log(data)
                 if(data){
                    $("#btn-save").prop('disabled', false);
                    
                    $('#msj').hide();
                 }else{
                    $("#btn-save").prop('disabled', true);
                    $('#msj').show();
                 }
              }
         });
        }else{
            $("#msj").hide()
        }
    })

    $("#searchONI-Asignado").click(function(){
      if($("#oni_asignado").val()!=""){ 
        $.ajax({ 
                url: "<?php echo base_url();?>personal/getNombreById",
                data : "oni="+$("#oni_asignado").val(),
                type: "POST",
                dataType: 'json',
                beforeSend: function (request) {
                      request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                success: function (res) {
                  console.log(res)
                  if(res.success){
                    
                  
                      $("#categoria").val(res.data[0].cargo);
                      $("#nombre").val(res.data[0].nombre);
                      
                  } else {
                    Swal.fire({
                    type: 'warning',
                    title: 'Oni no valido',
                    text: 'Intente con otro',
                    footer: 'TRANSITO'
                  })
                  $("#categoria").val("");
                  $("#oni_asignado").val("");

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
      } else { 
        $("#oni_asignado").val('');
        Swal.fire({
          type: 'info',
          title: 'ONI Vacio',
          text: 'Por favor ingrese un numero de ONI para realizar su busqueda',
          footer: 'TRANSITO'
        })
      }
    });


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
            "url": "AutTalonarios/getAll",
            "type": "GET",
            'beforeSend': function (request) {
                request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }
        },
        "columns": [
            { "data": "ID_FILA" },
            { "data": "ONI" },
            { "data": "NOMBRE" },
            { "data": "CANTIDAD" },
            { "data": "FECHA_AUT" },
            { "data": "ESTADO" },
            { "data": "NO_DOCUMENTO" },
            { "data": "NO_REFERENCIA" },
            { "data": "OBSERVACION" },
        ],
        "columnDefs": [ {
            "targets": 9,
            "class": "project-actions text-center",
            "data": null,
            "defaultContent": "<button class='btn btn-info btn-sm btn-edit'><i class='fas fa-pen'></i> </button> &nbsp; <button class='btn btn-danger btn-sm btn-delete'><i class='fas fa-trash'></i> </button> &nbsp; <button class='btn btn-info btn-sm btn-pdf' ><i class='fas fa-file-pdf'></i> </button>"
        } ]
    });

    $('#marca_list tbody').on('click', '.btn-edit', function () {
        var data = table.row( $(this).parents('tr') ).data();
          $.ajax({ 
                url: "AutTalonarios/getById/"+data['ID_FILA'],
                type: "GET",
                beforeSend: function (request) {
     request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                dataType: 'json',
                success: function (res) {
                  if(res.success == true){
                    $('#marcaForm').trigger("reset");
                    $('#formModal').html("Editar Autorizacion");
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
          title: 'Esta seguro de borrar esta autorizacion: '+ data['ONI'] + '?',
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
                url: "AutTalonarios/delete/"+data['ID_FILA'],
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
                      text: 'Este usuario tiene talonarios asignados',
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

    $('#marca_list tbody').on('click', '.btn-pdf', function (e) {
      var data = table.row( $(this).parents('tr') ).data();
    var numero = data['ID_FILA'];
    var url = "documentos/" + numero + ".pdf";
    e.preventDefault(); // if you have a URL in the link
       jQuery.ajax({
           type: "POST",
           url: url,
           success: function(data)
           {
               
            $("#drawPDF").hide();
            //console.log(data) 
            $("#viewReport").show();
                
            var con = $("#viewReport").attr('src', url);
           },
           error: function(){
            $("#drawPDF").show();
            
            $("#viewReport").hide();
            Swal.fire({
                      type: 'warning',
                      title: 'Hubo un problema',
                      text: 'Este registro no cuenta con un archivo asociado',
                      footer: 'TRANSITO'
                    })

           }
       });
    
    
    //console.log(numero);
    })
    function setForm(data){
      console.log(data);
      $("#id_clase").prop('readonly', true);
      $('#id_clase').val(data['ID_FILA']);
      $('#nombre').val(data['NOMPER']);
      $('#oni_asignado').val(data['ONI']);
      $('#cantidad').val(data['CANTIDAD']);
      $('#date_fechatraslado').val(data['FECHA_AUT']);
      $('#NumDocumento').val(data['NO_DOCUMENTO']);
      $('#referencia').val(data['NO_REFERENCIA']);
      $('#observaciones').val(data['OBSERVACION']);
      $('#searchONI-Asignado').click();

      var unidad = $('#id_unidad');
            var option = new Option(data['ID_UNIDAD']+ ' - ' + data['NOMBRE'], data['ID_UNIDAD'], true, true);
            unidad.append(option).trigger('change');

            unidad.trigger({
                  type: 'select2:select',
                  params: {
                      data: data
                  }
              });

              var unidad = $('#estado');
            var option = new Option(data['ESTADO'], data['ESTADO'], true, true);
            unidad.append(option).trigger('change');

            unidad.trigger({
                  type: 'select2:select',
                  params: {
                      data: data
                  }
              });
     
    }

    $('#create-new').click(function () {
         $("#id_marca").prop('readonly', false);
         $('#btn-save').val("create");
         $('#marcaForm').trigger("reset");
         $('#formModal').html("Otorgar Permiso de Talonarios");
         $('#ajax-modal').modal('show');
         setNullSelect2();
      });

    if ($("#marcaForm").length > 0) {

        $("#marcaForm").validate({
          rules: {
            id_marca: { maxlength: 10, number: true },
            marca: { maxlength: 60 }

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
              urlRequest = 'AutTalonarios/store';
              var data = new FormData($("#marcaForm")[0]);
            } else if(actionType == 'update') {
              urlRequest = 'AutTalonarios/update';
              var data = new FormData($("#marcaForm")[0]);
            }

            $('#btn-save').prop('disabled',true);
            $('#btn-save').html('Guardando..');
 
            $.ajax({
               data: data,
               url: urlRequest,
               type: "POST",
               contentType: false,
               processData: false,
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
                   console.log(data)
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
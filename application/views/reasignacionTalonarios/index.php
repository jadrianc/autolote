<style>
       .datepicker {
         z-index: 1600 !important; /* has to be larger than 1050 */
       }
</style>
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
      <input type="hidden" id="nombreUsuario" value='<?php echo $nombreUsuario; ?>'>
      <input type="hidden" id="oniUsuario" value='<?php echo $oniUsuario; ?>'>
      <input type="hidden" id="cargoUsuario" value='<?php echo $cargoUsuario; ?>'>
      <input type="hidden" id="depuesto">
      <div id="errores_form" class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-ban"></i> Errores del Formulario : </h5>
         <div id="mensajes_errores"></div>
      </div>
      <!-- Default box -->
      
      
      <div class="card card-info" id="table">
        <div class="card-header">
            <h3 class="card-title">Talonarios <i class="fas fa-align-justify"></i></h3>
            <div class="card-tools">
                <button type="button" id="btn-close-historico" class="btn btn-tool"  data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body" id="tablaTalonariosReasignados">
          <div class="table-responsive">
          <table id="reasignacion" class="table table-bordered table-hover table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Fecha Entrega</th>
                        <th>Estado</th>
                        <th>Serie Inicial</th>
                        <th>Serie Final</th>
                        <th>ONI</th>
                        <th>Fecha Reasignación</th>
                        <th>Oni Responsable</th>
                        <th style="width: 10%">Esquelas Digitadas</th>
                        <th style="width: 20%">REASIGNAR/REVERTIR/DESCARGO</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

          </div>
        </div>
        <div class="card-footer">
       
        </div>
      </div>



      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reasignar Talonario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="formReasignacion">

            <div class="row">
            <div class="col-md-12">
            <input type="text" hidden class="form-control" name="idTalonario" id="idTalonario" readonly>
            <div class="form-group">
                    <label for="">Serie</label>
                    <input type="hiden" class="form-control" name="talonarios" id="talonarios" readonly>
                </div>
            </div>
            </div>
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
        <div class="col-sm-12" id="divAsignado">
            <div class="form-group">
                <label>Nombre Unidad</label>
                <input type="text" class="form-control text-uppercase" id="nomUni" name="nomUni" required readonly>
            </div>

        </div>
        <div class="col-sm-12">
            <div class="form-group">
            <label for="">Observaciones</label>
                <textarea placeholder="Observaciones" class="form-control textarea" name="observaciones" id="observaciones" cols="20" rows="4"></textarea>
            </div>
        </div>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="reasignar" class="btn btn-primary">Asignar</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modalDescargo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Descargo de Talonario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="formDescargo">
        <div class="row">
            <div class="col-md-12">
            <input type="text" hidden class="form-control" name="idTalonarioDesc" id="idTalonarioDesc" readonly>
            <div class="form-group">
                    <label for="">Serie a Descargar</label>
                    <input type="hiden" class="form-control" name="talonariosDesc" id="talonariosDesc" readonly>
                </div>
            </div>
            </div>
          <div class="row">
          <div class="form-group">
                              <label>Fecha Descargo</label>
                                  <div class="input-group date" id="fechaadqui" data-target-input="nearest">
                                      <div class="input-group-append" data-target="#fechaadqui" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                      </div>
                                      <input type="text" class="form-control datetimepicker-input" placeholder="Fecha de Descargo" 
                                      name="fechaadqui" data-target="#fechaadqui" id="fechaadqui" readonly required/>
                                  </div>
                              </div>
        <div class="col-sm-12">
            <div class="form-group">
            <label for="">Observaciones de Descargo</label>
                <textarea placeholder="Observaciones" class="form-control textarea" name="observacionesDesc" id="observacionesDesc" cols="20" rows="4"></textarea>
            </div>
        </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button"  id="descargarTalonario" class="btn btn-primary dissable">Descargar</button>
      </div>
      </form>
    </div>
  </div>
</div>
  <!-- /.content-wrapper -->
 <script>
    $(document).ready(function() {
     
      
      

      var oni = $("#oniUsuario").val();


      var table = $('#reasignacion').DataTable({
        "order": [[ 0, "desc" ]],
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
            "url": "reasignacionTalonarios/getTalonariosByOni/"+oni,
            "type": "post",
            'beforeSend': function (request) {
                request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }
        },
        "columns": [
            { "data": "FECHA_ENTREGA" },
            { "data": "ESTADO" },
            { "data": "SERIE_INICIAL" },
            { "data": "SERIE_FINAL" },
            { "data": "ONI_RECIBE" },
            { "data": "FECHA_REASIGNACION" },
            { "data": "ONI_RESPONSABLE" },
            { "data": "TOT_IMPUESTAS" }
        ],
        "columnDefs": [ {
            "targets": 8,
            "class": "project-actions text-center",
            "data": null,
            "defaultContent": "<button data-toggle='modal' data-target='#exampleModal' id='btnReAsignar' class='btn btn-success btn-sm btn-edit'><i class='fas fa-check'></i></button> <button class='btn btn-danger btn-sm btn-revertir' id='btnRevertir'><i class='fas fa-times'></i> </button> <button data-toggle='modal' data-target='#modalDescargo' id='btnDescargo' class='btn btn-warning btn-sm btn-descargo'><i class='fas fa-arrow-down'></i> </button>"
        } ]
    });


    table.on( 'draw', function () {
            $('#reasignacion tr').each(function() { 
              var estado = $(this).find("td:nth-child(2)").html();
              console.log(estado)
              var buttonReasinar = $(this).find('#btnReAsignar');
              var buttonRevertir = $(this).find('#btnRevertir');
              var buttonDescargo = $(this).find('#btnDescargo');

              
              if(estado === 'ASIGNADO' || estado === 'Asignado'){
                buttonRevertir.attr('disabled','disabled');
              }

              if(estado === 'Reasignado' || estado === 'REASIGNADO'){
                buttonReasinar.attr('disabled','disabled');
              }

              if(estado == "DESCARGADO"){
                buttonRevertir.attr('disabled','disabled');
                buttonReasinar.attr('disabled','disabled');
              }
              
             
              });
          } );

      $("#reasignacion tbody").on('click', '.btn-revertir', function(){
        var data = table.row( $(this).parents('tr') ).data();
        console.log(data);
        Swal.fire({
              title: "Desea revertir esta asignacion?",
              text: "Serie: " + data["SERIE_INICIAL"] + " - " + data["SERIE_FINAL"] + "\n Reasignada a: " + data["ONI_RESPONSABLE"],
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Revertir',
              cancelButtonText: 'Cancelar',
            }).then((result) => {
              if (result.value) {
                swal.showLoading();
                $.ajax({
                  
                  url: 'reasignacionTalonarios/revertirReasignacion/' + data["ID_FILA"],
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
                      
                        
                    } else {
                        Swal.fire({
                          type: 'warning',
                          title: 'Hubo un problema',
                          text: 'Este ONI ya cuenta con 3 talonarios asignados',
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
                    
                    console.log('Error:', data);
               }
            });
                     
          }
        })
      })

      

      $('#reasignacion tbody').on('click', '.btn-descargo', function () {
       
        
      var data = table.row( $(this).parents('tr') ).data();
     
      $("#observacionesDesc").val("")
      $("#talonariosDesc").val(data["SERIE_INICIAL"] + " - " + data["SERIE_FINAL"]);
      $("#idTalonarioDesc").val(data["ID_FILA"]);
        if(data["FECHA_DESCARGO"] == null){
          $('#fechaadqui').datetimepicker({
            format: 'L',
            locale: 'es',
            maxDate: $.now(),
            defaultDate: moment($.now()).toDate()
          });
        }else{
          $('#fechaadqui').datetimepicker('date', moment(moment(data['FECHA_DESCARGO'], 'D-MMM-YYYY')).format('DD/MM/YYYY'));
          $("#observacionesDesc").val(data["OBSERVACION_D"]);
          $("#observacionesDesc").prop("readonly", true);
          $("#descargarTalonario").prop("disabled", true);
        }
      console.log(data)
  });

    function clearFormModal(){
      $('#formReasignacion').trigger("reset");
    }



    $('#reasignacion tbody').on('click', '.btn-edit', function () {
      
        var data = table.row( $(this).parents('tr') ).data();
        clearFormModal();
        $("#talonarios").val(data["SERIE_INICIAL"] + " - " + data["SERIE_FINAL"]);
        $("#idTalonario").val(data["ID_FILA"]);

          console.log(data["SERIE_INICIAL"])
    });


    $("#descargarTalonario").click(function(){


      var serie = $("#talonariosDesc").val();


        Swal.fire({
    title: 'Descargar serie: ',
    text: serie,
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Descargar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.value) {
      swal.showLoading();
      $.ajax({
        data: $('#formDescargo').serialize(),
        url: 'reasignacionTalonarios/descargoTalonario',
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
              $('#formDescargo').trigger("reset");
              $('#modalDescargo').modal('hide');
              
          } else {
              Swal.fire({
                type: 'warning',
                title: 'Hubo un problema',
                text: 'Datos Invalidos',
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
          
          console.log('Error:', data);
     }
  });
           
}
})


      
  

  
});
    
      
 
      $("#reasignar").click(function(){

          var oni = $("#oni_asignado").val();
          var nombre = $("#nombre").val();
            if(oni == ""){
                Swal.fire({
                    type: 'warning',
                    title: 'Error...',
                    text: 'Estimado usuario, algunos campos necesitan ser llenados',
                    footer: 'TRANSITO'
                  })
            }else{


                  Swal.fire({
              title: 'Asignar serie: \n' + $("#talonarios").val(),
              text: nombre + " - " + oni,
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Asignar',
              cancelButtonText: 'Cancelar',
            }).then((result) => {
              if (result.value) {
                swal.showLoading();
                $.ajax({
                  data: $('#formReasignacion').serialize(),
                  url: 'reasignacionTalonarios/reasignar',
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
                        $('#formReasignacion').trigger("reset");
                        $('#exampleModal').modal('hide');
                        
                    } else {
                        Swal.fire({
                          type: 'warning',
                          title: 'Hubo un problema',
                          text: 'Este ONI ya cuenta con 3 talonarios asignados',
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
                    
                    console.log('Error:', data);
               }
            });
                    
          }
        })


                
            }

            
      });



        

    
function enviarData(datos){
  var url = "<?php echo base_url();?>AsignacionTalonarios/store";
  Swal.fire({
          title: 'Desea Asignar talonarios a',
          text: datos.nombreAutorizado + " - " + datos.oniAutorizado,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Asignar',
          cancelButtonText: 'Cancelar',
        }).then((result) => {
          if (result.value) {
            swal.showLoading();
            $.ajax({ 
                url: url,
                data: {'array': JSON.stringify(datos)},
                type: "POST",
                dataType: 'json',
                beforeSend: function (request) {
                        request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                success: function (res) {
                  
                  generarPdf(datos);
                  Swal.fire(
                    'Enviado!',
                    'Los talonarios han sido asignados',
                    'success'
                  )
                  $("#btn-asignar").prop('disabled', true);
                  //$('#btnLimpiar').click();
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
             habilitarFrom();         
          }
        })
}


    
    function generarPdf(data){

                      $("#viewReport").show();
                     $("#drawPDF").hide(); 
                      //console.log(datosAr)
                      urlReport = "<?php echo base_url();?>AsignacionTalonarios/CrearReporteTalonarioPdf/PDF";
                      
                      $.ajax({ 
                            
                            url: urlReport,
                            type: "POST",
                            data: {'array': JSON.stringify(data)},
                            beforeSend: function (xhr, settings) {
                                    xhr.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                            },
                            success: function (res) {
                              console.log(res)  
                              Toast.fire({
                                type: 'success',
                                title: 'Talonarios generados'
                              }) 
                              $("#headerCard").removeClass("card card-navy");
                              $("#headerCard").addClass("card card-navy collapsed-card");
                              $('#modal-certificado').modal('hide');                           
                              clearFormSearch()
                                $("#viewReport").attr('src',"data:application/pdf;base64" + res);  
                                                           
                            }                      
                      });

    }

    

      $('#msj').hide();
      $('#msj1').hide();

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
                    $("#reasignar").prop('disabled', false);
                    
                    $('#msj').hide();
                 }else{
                    $("#reasignar").prop('disabled', true);
                    $('#msj').show();
                 }
              }
         });
        }else{
            $("#msj").hide()
        }
    })

    $("#total_asignar").keyup(function(){
    
        var total_asignar = $("#total_asignar").val();
        var disponibilidad = parseInt($("#disponibilidad").val());

        if(disponibilidad < total_asignar){
          
          $("#total_asignar").val("")
          $("#generar").prop('disabled', true);
          $('#msj1').show();
        }else{
          $("#generar").prop('disabled', false);
                    
          $('#msj1').hide();
        }
     });

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
                      $("#nomUni").val(res.data[0].unidad);
                      
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



      $('#li-armasIng').removeClass('nav-link').addClass('nav-link active');
      $('#valor').inputmask('currency', {clearIncomplete: true, rightAlign: false,  keepStatic: true, autoUnmask: true });
      $("#errores_form").hide();
      $(".reEnterDiv").hide();
      $("#mensajes_errores").html('');
      var estadoSelect = $('#id_estado');
      var option = new Option('BODEGA', '2', true, true);
      estadoSelect.append(option).trigger('change');

      $("#modal-search").on('shown.bs.modal', function(){
        $(this).find('#buscarSerie').focus();
      });
      $("#viewReport").hide();

            $("#btnCertificado").click(function(){
              if($("#nombreJefe").val() == ""){
                Swal.fire({
                    type: 'error',
                    title: 'Error...',
                    text: 'Campo nombre es requerido',
                    footer: 'TRANSITO'
                  })
              }else{
                $("#viewReport").show();
                     $("#drawPDF").hide(); 
                      console.log(datosAr)
                      urlReport = "<?php echo base_url();?>Armas/certificacionArmasPdf/PDF";
                      datosAr.oni_jefe = $("#oniJefeSuministro").val();
                      datosAr.nombre_jefe = $("#nombreJefe").val();
                      datosAr.cargo_jefe = $("#cargoJefe").val();
                      datosAr.id = $("#btnBorrar").val();
                      $.ajax({ 
                            data: datosAr,
                            url: urlReport,
                            type: "POST",
                            beforeSend: function (xhr, settings) {
                                    xhr.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                            },
                            success: function (res) {  
                              Toast.fire({
                                type: 'success',
                                title: 'Se Genero Certificado Correctamente'
                              }) 
                              $("#headerCard").removeClass("card card-navy");
                              $("#headerCard").addClass("card card-navy collapsed-card");
                              $('#modal-certificado').modal('hide');                           
                              clearFormSearch()
                                $("#viewReport").attr('src',"data:application/pdf;base64" + res);                              
                            }                      
                      });
              }
                      
                })

      $("#searchONI").click(function(){
      if($("#oniJefeSuministro").val()!=""){ 
        $.ajax({ 
                url: "<?php echo base_url();?>personal/getNombreById",
                data : "oni="+$("#oniJefeSuministro").val(),
                type: "POST",
                dataType: 'json',
                beforeSend: function (request) {
                      request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                success: function (res) {
                  if(res.success){
                    //console.log(res)
                      $("#nombreJefe").val(res.data[0].nombre);
                      $("#cargoJefe").val(res.data[0].cargo);
                      
                  } else {
                      $("#nombreJefe").val('');
                      $("#cargoJefe").val('');
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
        $("#nombreJefe").val('');
        Swal.fire({
          type: 'info',
          title: 'ONI Vacio',
          text: 'Por favor ingrese un numero de ONI para realizar su busqueda',
          footer: 'TRANSITO'
        })
      }
    });

     



      $("#id_marca").select2({
          placeholder: "Seleccione una Marca",
          ajax: { url: 'ArmasMarca/getSelectAll', type: "post", dataType: 'json',
            beforeSend: function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }, delay: 100,
            data: function (params) {
                return {searchTerm: params.term };
            },
            processResults: function (response) {
                return {results: response};
            }
          }
      });

      $("#id_modelo").select2({
          placeholder: "Seleccione un Modelo",
          ajax: { url: 'ArmasModelos/getSelectAll', type: "post", dataType: 'json',
            beforeSend: function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }, delay: 100,
            data: function (params) {
                return {searchTerm: params.term };
            },
            processResults: function (response) {
                return {results: response};
            }
          }
      });

      $("#id_calibre").select2({
          placeholder: "Seleccione un Calibre",
          ajax: { url: 'ArmasCalibre/getSelectAll', type: "post", dataType: 'json',
            beforeSend: function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }, delay: 100,
            data: function (params) {
                return {searchTerm: params.term };
            },
            processResults: function (response) {
                return {results: response};
            }
          }
      });

      $("#id_clase").select2({
          placeholder: "Seleccione una Clase",
          ajax: { url: 'ArmasClases/getSelectAll', type: "post", dataType: 'json',
            beforeSend: function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }, delay: 100,
            data: function (params) {
                return {searchTerm: params.term };
            },
            processResults: function (response) {
                return {results: response};
            }
          }
      });

      $("#id_tipo").select2({
          placeholder: "Seleccione un Tipo",
          ajax: { url: 'TipoArmas/getSelectAll', type: "post", dataType: 'json',
            beforeSend: function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }, delay: 100,
            data: function (params) {
                return {searchTerm: params.term };
            },
            processResults: function (response) {
                return {results: response};
            }
          }
      });

      $("#id_tadqui").select2({
          placeholder: "Seleccione un Tipo de Adquisición",
          ajax: { url: 'TipoArmas/getSelectAll2', type: "post", dataType: 'json',
            beforeSend: function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }, delay: 100,
            data: function (params) {
                return {searchTerm: params.term };
            },
            processResults: function (response) {
                return {results: response};
            }
          }
      });

      $("#id_proveedor").select2({
          placeholder: "Seleccione un Proveedor",
          ajax: { url: 'ArmasProveedores/getSelectAll', type: "post", dataType: 'json',
            beforeSend: function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }, delay: 100,
            data: function (params) {
                return {searchTerm: params.term };
            },
            processResults: function (response) {
                return {results: response};
            }
          }
      });

      $("#id_procedencia").select2({
          placeholder: "Seleccione una Procedencia",
          ajax: { url: 'ArmProcedencia/getSelectAll', type: "post", dataType: 'json',
            beforeSend: function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }, delay: 100,
            data: function (params) {
                return {searchTerm: params.term };
            },
            processResults: function (response) {
                return {results: response};
            }
          }
      });

      $("#id_fabricante").select2({
          placeholder: "Seleccione un Fabricante",
          ajax: { url: 'ArmasFabricante/getSelectAll', type: "post", dataType: 'json',
            beforeSend: function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }, delay: 100,
            data: function (params) {
                return {searchTerm: params.term };
            },
            processResults: function (response) {
                return {results: response};
            }
          }
      });

      $("#id_pais").select2({
          placeholder: "Seleccione un País",
          ajax: { url: 'ArmasPaisFabricante/getSelectAll', type: "post", dataType: 'json',
            beforeSend: function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }, delay: 100,
            data: function (params) {
                return {searchTerm: params.term };
            },
            processResults: function (response) {
                return {results: response};
            }
          }
      });

      $("#id_estado").select2({
          placeholder: "Seleccione un Estado",
          ajax: { url: 'Armas/getSelectAll', type: "post", dataType: 'json',
            beforeSend: function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }, delay: 100,
            data: function (params) {
                return {searchTerm: params.term };
            },
            processResults: function (response) {
                return {results: response};
            }
          }
      });    

      

      $('#btnLimpiar').click(function() {
        
       
       
        $("#btn-asignar").prop('disabled', false);
        $("#viewReport").hide();
        limpiarFormulario();
        setSaveButtonNewRegistry();
        movimientos.clear().draw();
        habilitarFrom();
        $('#btnSave').show();
         $('#serie').prop('readOnly',false);
      });
          

     
      function cambioSelect2Null(){
        if($('#id_marca').val()!=null){
          $('#id_marca').val(null).trigger('change');
        }
        if($('#id_modelo').val()!=null){
          $('#id_modelo').val(null).trigger('change');
        }
        if($('#id_calibre').val()!=null){
          $('#id_calibre').val(null).trigger('change');
        }
        if($('#id_clase').val()!=null){
          $('#id_clase').val(null).trigger('change');
        }
        if($('#id_tipo').val()!=null){
          $('#id_tipo').val(null).trigger('change');
        }
        if($('#id_tadqui').val()!=null){
          $('#id_tadqui').val(null).trigger('change');
        }
        if($('#id_proveedor').val()!=null){
          $('#id_proveedor').val(null).trigger('change');
        }   
        if($('#id_procedencia').val()!=null){
          $('#id_procedencia').val(null).trigger('change');
        }   
        if($('#id_fabricante').val()!=null){
          $('#id_fabricante').val(null).trigger('change');
        }   
        if($('#id_pais').val()!=null){
          $('#id_pais').val(null).trigger('change');
        }  
        
        var estadoSelect = $('#id_estado');
        var option = new Option('BODEGA', '2', true, true);
        estadoSelect.append(option).trigger('change');
      };

      $("#id_marca").change(function(){
        if($(this).val() != ''){
          $(this).valid();
        }
      });
      $("#id_modelo").change(function(){
        if($(this).val() != ''){
          $(this).valid();
        }
      });
      $("#id_calibre").change(function(){
        if($(this).val() != ''){
          $(this).valid();
        }
      });
      $("#id_clase").change(function(){
        if($(this).val() != ''){
          $(this).valid();
        }
      });
      $("#id_tipo").change(function(){
        if($(this).val() != ''){
          $(this).valid();
        }
      });
      $("#id_tadqui").change(function(){
        if($(this).val() != ''){
          $(this).valid();
        }
      });
      $("#id_proveedor").change(function(){
        if($(this).val() != ''){
          $(this).valid();
        }
      });
      $("#id_precedencia").change(function(){
        if($(this).val() != ''){
          $(this).valid();
        }
      });
      $("#id_fabricante").change(function(){
        if($(this).val() != ''){
          $(this).valid();
        }
      });
      $("#id_pais").change(function(){
        if($(this).val() != ''){
          $(this).valid();
        }
      });      
      
      $("#btnSave").click(function() {
        if($("#formArmas").valid()) {
          var actionType = $('#btnSave').val();
          console.log(actionType);
          var iconSave = '';
          if(actionType == 'create'){
            urlRequest = 'Armas/store';
          } else if(actionType == 'update') {
            urlRequest = 'Armas/update';
          }          

          $('#btnSave').prop('disabled',true);
          $('#btnSave').html(iconSave + ' Guardando..');

          $.ajax({
               data: $("#formArmas").serialize(),
               url: urlRequest,
               type: "POST",
               dataType: 'json',
               beforeSend: function (request) {
                      request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
               },
               success: function (res) {
                if(actionType == 'create'){
                    if(res.status == true){
                      Swal.fire({
                          type: 'success',
                          title: 'Exito',
                          text: 'Su registro ha sido guardado',
                          footer: 'TRANSITO'
                        })
                        $(".reEnterDiv").show();
                        $("#reEnterData").prop("disabled", false);
                        $("#reEnterData").prop("checked", false);
                        $("#processSwitch").prop("disabled", false);
                        $("#processSwitch").prop("checked", false);
                        $("#lblProcessSwitch").html('Viendo informacion del Arma');
                        $("#id_estado").prop("disabled", false);
                        setSaveButtonUpdateRegistry();
                        $('#btnSave').hide();
                        $('#btnCancel').hide();
                        $('#btnSave').prop('disabled', false);
                    }
                    else if(res.status == 'duplicate') {
                      Swal.fire({
                          type: 'info',
                          title: 'Registro duplicado',
                          text: 'Estimado usuario, ya existe un registro con los datos que usted ha ingresado',
                          footer: 'TRANSITO'
                        })
                        if(actionType == 'create'){
                          setSaveButtonNewRegistry();
                        } else if(actionType == 'update') {
                          setSaveButtonUpdateRegistry();
                        }
                        $('#btnSave').prop('disabled', false);
                    }
                    else if(res.status == 'form-not-valid') { 
                      Swal.fire({
                          type: 'info',
                          title: 'Revise el Formulario',
                          text: 'Estimado usuario, el formulario tiene algunos errores',
                          footer: 'TRANSITO'
                        })
                        $("#formActivoFijo").valid();
                        $("#errores_form").show();
                        $("#mensajes_errores").html(res.messages);

                        if(actionType == 'create'){
                          setSaveButtonNewRegistry();
                        } else if(actionType == 'update') {
                          setSaveButtonUpdateRegistry();
                        }
                        $('#btnSave').prop('disabled', false);
                    } 
                    else if(res.status == false) {
                      Swal.fire({
                          type: 'warning',
                          title: 'Fallo al ingresar registro',
                          text: 'Estimado usuario, intente nuevamente',
                          footer: 'TRANSITO'
                        })

                        if(actionType == 'create'){
                          setSaveButtonNewRegistry();
                        } else if(actionType == 'update') {
                          setSaveButtonUpdateRegistry();
                        }
                        $('#btnSave').prop('disabled', false);
                    }
                  } else if(actionType == 'update') {
                    if(res.status == true){
                        Swal.fire({
                            type: 'success',
                            title: 'Exito',
                            text: 'Su registro ha sido actualizado',
                            footer: 'TRANSITO'
                          })
                          $("#processSwitch").prop("disabled", false);
                          $("#processSwitch").prop("checked", false);
                          $("#lblProcessSwitch").html('Viendo informacion del Arma Actualizado');
                          setSaveButtonUpdateRegistry();
                          $('#btnSave').hide();
                          $('#btnCancel').hide();
                          $('#btnSave').prop('disabled', false);
                      } else if(res.status == 'form-not-valid') {
                          Swal.fire({
                            type: 'info',
                            title: 'Revise el Formulario',
                            text: 'Estimado usuario, el formulario tiene algunos errores',
                            footer: 'TRANSITO'
                          })
                          $("#formActivoFijo").valid();
                          $("#errores_form").show();
                          $("#mensajes_errores").html(res.messages);

                          if(actionType == 'create'){
                            setSaveButtonNewRegistry();
                          } else if(actionType == 'update') {
                            setSaveButtonUpdateRegistry();
                          }
                          $('#btnSave').prop('disabled', false);
                        }else if(res.status == false) {                      
                          Swal.fire({
                              type: 'info',
                              title: 'No se pudo actualizar el registro',
                              text: 'Estimado usuario, intente nuevamente',
                              footer: 'TRANSITO'
                            })

                          if(actionType == 'create'){
                              setSaveButtonNewRegistry();
                            } else if(actionType == 'update') {
                              setSaveButtonUpdateRegistry();
                            }
                            $('#btnSave').prop('disabled', false);
                        } 
                  }
              },

          });
        }
        else{
          Swal.fire({
            type: 'warning',
            title: 'Campos requeridos',
            text: 'Estimado usuario, algunos campos necesitan ser llenados',
            footer: 'TRANSITO'
          })
        }
      });

      $("#formArmas").validate({  
        rules: {
          serie:{required: true},
          caf:{required: true},
          id_marca:{required: true},
          id_modelo:{required: true},
          id_calibre:{required: true},
          id_clase:{required: true},
          id_tipo:{required: true},
          descripcion:{maxlength:50},
          balistica:{required: true},
          id_tadqui:{required: true},
          fechaadqui:{required: true},
          valor:{ required: true, number: true },
          id_fabricante:{required: true},
          id_proveedor:{required: true},
          id_pais:{required: true},
          id_procedencia:{required: true},
          observaciones:{maxlength:250},
          observaciones2:{maxlength:100}
        },
        messages: {
          serie: "Digite una Serie",
          serie: "Ingrese el CAF",
          id_marca: "Seleccione una Marca",
          id_modelo: "Seleccione un Modelo",
          id_calibre: "Seleccione un Calibre",
          id_clase: "Seleccione una Clase",
          id_tipo: "Seleccione un Tipo",
          descripcion:{maxlength: jQuery.validator.format("Por favor, no ingrese mas de {0} caracteres")},
          balistica: "Digite un dato balistico",
          id_tadqui: "Seleccione un Tipo de Aquisición",
          fechaadqui: "Ingrese una fecha válida",
          valor: {number: "Debe ingresar un valor numerico"},
          id_fabricante: "Seleccione un fabricante",
          id_proveedor: "Seleccione un proveedor",
          id_pais: "Seleccione un país de fabricación",
          id_procedencia: "Seleccione una procedencia",
          observaciones:{maxlength: jQuery.validator.format("Por favor, no ingrese mas de {0} caracteres")},
          observaciones2:{maxlength: jQuery.validator.format("Por favor, no ingrese mas de {0} caracteres")}
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
    
              }
      });  
      
  });

  function setSaveButtonNewRegistry()
      {
          $('#btnSave').removeClass('btn-info').addClass('btn-success');
          $('#btnSave').html('<i class="fas fa-save"></i>   Guardar');
          $('#btnSave').val('create');
      }

      function setSaveButtonUpdateRegistry()
      {
          $('#btnSave').removeClass('btn-success').addClass('btn-info');
          $('#btnSave').html('<i class="fas fa-pen"></i>  Guardar Cambios');
          $('#btnSave').val('update');
          var estado = $('#id_estado option:selected').text();
          $("#labelEstado").html('Estado: '+estado);
      }

  $('#processSwitch').click(function() {
    if ($(this).is(':checked')) {
        $("#lblProcessSwitch").html('Modificar Información del Bien');
        setSaveButtonUpdateRegistry();
        $('#btnSave').show();
        $('#btnCancel').show();
        habilitarFrom();
    } else {
        $('#btnSave').hide();
        $('#btnCancel').hide();
        $("#lblProcessSwitch").html('Click aqui para modificar');
        dehabilitarForm();
    }
  });
  
  $('#reEnterData').click(function() {
    if ($(this).is(':checked')) {
        $('#correlativo').val('');
        $('#serie').val('');
        $('#caf').val('');
        $('#id_estado').prop('disabled', true);
        var estadoSelect = $('#id_estado');
        var option = new Option('BODEGA', '2', true, true);
        estadoSelect.append(option).trigger('change');
        setSaveButtonNewRegistry();
        $('#btnSave').show();
        $('#btnCancel').show();
        habilitarFrom();
    }
  });

  $("#numeroaf1").keyup(function() {
    if($("#processSwitch").is(':checked') &&  $('#btnSave').val() == 'create' || $("#reEnterData").is(':checked') &&  $('#btnSave').val() == 'create'){
        $("#docasig").val($(this).val());
    }
  });

  function clearFormSearch()
  {
    $('#searchForm').trigger("reset");
    $('#buscarSerie').val(null).trigger('change');
    $('#searchForm').trigger("reset");
    $('#nombreJefe').val(null).trigger('change');
    $('#cargoJefe').val(null).trigger('change');
    $('#oniJefeSuministro').val(null).trigger('change');
  }  
  
  const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
 </script>


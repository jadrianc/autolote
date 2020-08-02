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
      <div id="headerCard" class="card card-navy">
      
         <div class="card-header">
            <h3 class="card-title">Datos<i class="fas fa-pencil-alt"></i></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
            </div>
         </div>
          <div class="card-body bg-light">
                <div class="row no-print">
                  <div class="col-md-4">
                      
                  </div>
                  <div class="col-md-3">
                      <div class="custom-control custom-switch">
                        <h5><label id="labelEstado"></label></h5>
                      </div>
                  </div>
                  <div class="col-md-5">
                        <button type="button" class="btn btn-primary float-right" id="btnCert" data-toggle="modal" data-target="#modal-certificado"  style="margin-right: 5px;">
                          <i class="fas fa-check"></i> Emitir Certificado
                        </button>
                        <button type="button" class="btn btn-primary float-right" id="btnBuscar" data-toggle="modal" data-target="#modal-search"  style="margin-right: 5px;">
                          <i class="fas fa-search"></i> Buscar
                        </button>
                        <button type="button" class="btn btn-warning float-right" id="btnLimpiar" style="margin-right: 10px;">
                          <i class="fas fa-eraser"></i> Limpiar
                        </button>
                        <?php if($allOptions and $ID_ROL != 4  and $ID_ROL != 2){ ?>
                        <button type="button" class="btn btn-danger float-right" id="btnBorrar" value="" style="margin-right: 10px;">
                          <i class="fas fa-trash"></i> Borrar
                        </button>
                        <?php } ?>
                  </div>
                </div>
                <div class="row no-print reEnterDiv">
                  
                </div>
                <hr>
                <form role="form" id="formArmas" autocomplete="off">
                      
                    <div class="row">
                    <div class="form-group col-sm-2">
                            <label>ONI Autorizado</label>
                            <div class="input-group mb-3">
                            <!-- /btn-group -->
                            <input placeholder="oni" type="text" class="form-control text-uppercase" id="oni_asignado" name="oni_asignado" required>
                            <input type="hidden" id="cargoAutorizado">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-info" id="searchONI-Asignado"><i class="fas fa-search"></i></button>
                            </div>
                            
                            
                            </div>
                            <p id="msj" style="color: red;">Oni no autorizado</p>
                        </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label>Nombre</label>
                          <input type="text" class="form-control text-uppercase" id="nombre" name="nombre" readonly>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label>Unidad</label>
                          <input type="text" class="form-control text-uppercase" id="unidad" name="unidad" readonly>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label>Cantidad Talonarios</label>
                          <input type="text" class="form-control text-uppercase" id="cantidad" name="cantidad" readonly>
                        </div>
                      </div>

                    </div>

                    <div class="row">
                      <div class="col-sm-2">
                          <div class="form-group">
                            <label>Disponibilidad</label>
                            <input type="text" class="form-control text-uppercase" id="disponibilidad" name="disponibilidad" readonly>
                          </div>
                      </div>
                      
                    
                      <div class="col-sm-2">
                            <div class="form-group">
                              <label>Serie Inicial</label>
                              <input type="number" class="form-control text-uppercase" id="serie_inicial" name="serie_inicial" required>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                              <label>Total a Asignar</label>
                              <input type="number" class="form-control text-uppercase" id="total_asignar" name="total_asignar" required>
                            </div>
                            <p id="msj1" style="color: red;">Numero de talonarios no permitido</p>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                              <button class="btn btn-success float-right" id="generar"><i class="fas fa-check"></i> Generar Talonarios</button>
                            </div>
                        </div>
                      </div>
                    
                    
                    

                    <!--/.card-footer -->
                    
                </form>
              <!-- /.card-body -->
          </div>
      </div>


      <div class="card card-success" id="div-reporte">
        <div class="card-header">
            <h3 class="card-title">Reporte <i class="fas fa-search"></i></h3>
            <div class="card-tools">
                <button type="button" id="btn-close-historico" class="btn btn-tool" data-card-widget="colapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body" id="tablaTalonarios">
          <div class="table-responsive">
              <table id="tablaReporte" class="table table-bordered table-hover table-sm" style="width:100%">
                 <thead>
                    <tr>
                      <th>Estado</th>
                      <th>Serie Inicial</th>
                      <th>Serie Final</th>
                      <th>Fecha Entrega</th>
                      <th>Oni Asignación</th>                
                      <th>Unidad</th>
                      <th>Observaciones</th>
                      <th>Fecha Reasignación</th>
                      <th>Oni Reasignación</th>
                      
                    </tr>
                 </thead>
                 <tbody>
                 
                 </tbody>
              </table>





          </div>
        </div>
        <div class="card-footer">
        <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                              <!-- <button class="btn btn-success float-right" id="btn-asignar"><i class="fas fa-save"></i> Asignar</button> -->
                            </div>
                        </div>
                      </div>
        </div>
      </div>
      

      <div class="card card-info" id="div-tabla">
        <div class="card-header">
            <h3 class="card-title">Talonarios <i class="fas fa-align-justify"></i></h3>
            <div class="card-tools">
                <button type="button" id="btn-close-historico" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body" id="tablaTalonarios">
          <div class="table-responsive">
              <table id="example" class="table table-bordered table-hover table-sm" style="width:100%">
                 
              </table>

          </div>
        </div>
        <div class="card-footer">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                  <button class="btn btn-success float-right" id="btn-asignar"><i class="fas fa-save"></i> Asignar</button>
                </div>
            </div>
          </div>
        </div>
      </div>

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



      <div class="modal fade" id="modal-search" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Busqueda Talonarios</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form id="" autocomplete="off" class="form-horizontal">                    
                    <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group">
                            <label>Buscar por:</label>
                            <select name="busqueda" id="busqueda" class="form-control">
                              <option value="fecha">Fecha Asignación</option>
                              <option value="oni">Oni Asignado</option>
                              <option value="num_talonario">Numero Talonario</option>
                            </select>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                          <div class="col-sm-12" id="divFecha">
                            <div class="form-group">
                              <label for="">Fecha</label>
                              <div class="input-group date" id="fecha_busqueda" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#fecha_busqueda" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                        </div>
                                        <input type="text" class="form-control datetimepicker-input" id="fecha_bus"
                                        data-target="#fecha_busqueda" required/>
                                    </div>
                            </div>
                          </div>
                   
                   
                        <div class="col-sm-12" id="divOni">
                          <div class="form-group">
                          <label for="">ONI</label>
                            <input type="text" placeholder="ONI" id="oni_busqueda" class="form-control text-uppercase">
                          </div>
                        
                        </div>
                          
                          
                          <div class="col-sm-12" id="divNum">
                          <label for="">Numero Talonario</label>
                            
                            <input type="number" placeholder="Serie Inicial" id="final" class="form-control">
                          </div>
                          
                          
                            
                        
                    
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-info" id="btn-search-modal">Buscar <i class="fas fa-search"></i></button>
                </div>
              </form>
            </div>
        </div>
      <!-- /.modal -->
    
    
    
    </section>

    <!-- /.content -->
  </div>

  <div class="modal fade" id="modal-certificado" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 id="msjCert" class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form id="searchFormg" autocomplete="off" name="searchForm" class="form-horizontal">                    
                    <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group">
                            <label>ONI Jefe/a Departamento de Suministros</label>
                            <div class="col-sm-4" id="divOni">
                                  <div class="form-group">
                                      
                                      <div class="input-group mb-3">
                                        <!-- /btn-group -->
                                        <input placeholder="oni" type="text" class="form-control text-uppercase" id="oniJefeSuministro" name="oniJefeSuministro" required>
                                        <div class="input-group-prepend">
                                          <button type="button" class="btn btn-info" id="searchONI"><i class="fas fa-search"></i></button>
                                        </div>
                                      </div>
                                  </div>
                                </div>                 

                                    <div class="col-sm-12" id="divAsignado">
                                      <div class="form-group">
                                          <label>Nombre</label>
                                          <input type="text" class="form-control text-uppercase" id="nombreJefe" name="nombreJefe" required readonly>
                                      </div>
                                  </div>
                                  <div class="col-sm-12" id="divAsignado">
                                      <div class="form-group">
                                          <label>Cargo</label>
                                          <input type="text" class="form-control text-uppercase" id="cargoJefe" name="cargoJefe" required readonly>
                                      </div>
                                  </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-info" id="btnCertificado">Aceptar <i class="fas fa-check"></i></button>
                </div>
              </form>
            </div>
        </div>
      <!-- /.modal -->
    
    
    
    </section>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <script>
    $(document).ready(function() {

      $("#div-reporte").hide()

      $("#btnBuscar").click(function(){
        $("#oni_busqueda").val("");
        $("#inicial").val("");
        $("#final").val("");
        $("#fecha_busqueda").val("")
      })

      $('#fecha_busqueda').datetimepicker({
        format: 'L',
        locale: 'es',
        maxDate: $.now()
      });

      $("#divOni").hide();
      $("#divNum").hide();
      $("#busqueda").change(function(){
        
        if($(this).val() == 'num_talonario'){
          $("#divOni").hide();
          $("#divNum").show();
          $("#divFecha").hide();
         
        }
        if($(this).val() == 'oni'){
          $("#divOni").show();
          $("#divNum").hide();
          $("#divFecha").hide();
        }
        if($(this).val() == 'fecha'){
          
          $("#divOni").hide();
          $("#divNum").hide();
          $("#divFecha").show();
          
        }
      })

      $("#btn-search-modal").click(function(){
          var busqueda = $("#busqueda").val();

          if(busqueda == 'fecha'){
            
            var fecha = $("#fecha_bus").val()
            if(fecha == ""){
              $("#btn-search-modal").prop('disable', true)
              mensajeError()
            }else{
              var datos = new Object();
              datos.fecha = $("#fecha_bus").val() 
              datos.oniUsuario = $("#oniUsuario").val();
              datos.busqueda = busqueda;
              enviarBusqueda(datos)
            }
            
            
          }else if(busqueda == 'oni'){
            if($("#oni_busqueda").val() == ""){
              mensajeError()
            }else{
              var datos = new Object();
             datos.oni = $("#oni_busqueda").val()
             datos.oniUsuario = $("#oniUsuario").val();
             datos.busqueda = busqueda;
              enviarBusqueda(datos)
            }
            
            
          }else{
            if($("#inicial").val() == "" ||  $("#final").val() == ""){
              mensajeError()
            }else{
              var datos = new Object();
              datos.final = $("#final").val()
              datos.oniUsuario = $("#oniUsuario").val();
              datos.busqueda = busqueda;
              enviarBusqueda(datos)
            }
            
            
          }
      })

      function mensajeError(){
        Swal.fire({
                    type: 'warning',
                    title: 'Error...',
                    text: 'Estimado usuario, algunos campos necesitan ser llenados',
                    footer: 'TRANSITO'
                  })
      }

      function enviarBusqueda(data){
        //swal.showLoading();
        $("#div-reporte").show()
        
        $('#modal-search').modal('hide');
        var table = $('#tablaReporte').on('xhr.dt', function ( e, settings, json, xhr ) {
       // if(json.data.length == 0 && json.rol == false){
          
        //}
        
    } )
    .DataTable({
          destroy: true,
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
            "url": "AsignacionTalonarios/reporte",
            "data": {'array': JSON.stringify(data)},
            "type": "POST",
            'beforeSend': function (request) {
              
                request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }
        },
        
        "columns": [
            { "data": "ESTADO" },
            { "data": "SERIE_INICIAL" },
            { "data": "SERIE_FINAL" },
            { "data": "FECHA_ENTREGA" },
            { "data": "ONI_RECIBE" },
            { "data": "NOMBRE" },
            { "data": "OBSERVACION_E" },
            { "data": "FECHA_REASIGNACION" },
            { "data": "ONI_RESPONSABLE" }
        ]
    });

    
        
           
      }
      
      $('#total_asignar').prop('readonly', true);
      
 
      $("#generar").click(function(){



        var serie = $("#serie_inicial").val();
      var cantidad = $("#total_asignar").val();
      var oni =  $("#oni_asignado").val();
      var nombreUser = $("#nombre").val();
      var dataSet = new Array();
      var serie_final = 0;
        var cantidadAsig = $("#total_asignar").val();
        var lugar = $("#unidad").val();
        var responsable = $("#nombre").val();
        var oniResponsable = $("#oni_asignado").val();
        if(!serie || !cantidad || !oni || !nombreUser){
        Swal.fire({
                    type: 'warning',
                    title: 'Error...',
                    text: 'Estimado usuario, algunos campos necesitan ser llenados',
                    footer: 'TRANSITO'
                  })
      }else{

        $.ajax({ 
                url: "AsignacionTalonarios/validarAsignacion/"+cantidadAsig+"/"+serie,
                type: "POST",
                dataType: 'json',
                beforeSend: function (request) {
                        request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                success: function (res) {
                  console.log(res);
                  if(res.length != 0){
                    Swal.fire({
                    type: 'warning',
                    title: 'Error...',
                    text: 'Este rango de talonarios ya han sido asignados',
                    footer: 'TRANSITO'
                  })
                  }else{
                    Swal.fire({
          title: 'Desea Asignar estos ' + cantidadAsig + ' talonarios a:',
          text: 'Seccion ' + lugar + ', bajo responsabilidad de ' + responsable + ' - ' + oniResponsable,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Asignar',
          cancelButtonText: 'Cancelar',
        }).then((result) => {
          if (result.value) {
            swal.showLoading();

        var datos = new Object();
      for(x=0; x < cantidad; x++){
        serie_final = parseInt(serie) + parseInt(24)
        dataSet.push(new Array(x+1, serie, serie_final, oni, 'ASIGNADO'));
        serie = parseInt(serie) + parseInt(25)
      }
     


     // console.log(dataSet)
      
    
      $('#example').DataTable( {
        data: dataSet,
        destroy: true,
        columns: [
            { title: "N°" },
            { title: "Serie Inicial" },
            { title: "Serie Final" },
            { title: "Asignado A" },
            { title: "Estado" },
            
        ]
    } );

    $("#btn-close-historico").trigger('click');
    $("#btn-close-historico").removeAttr("data-card-widget")

    datos.data = dataSet;
    datos.nombreUsuario = $("#nombreUsuario").val(); 
    datos.oniUsuario = $("#oniUsuario").val();
    datos.cargoUsuario = $("#cargoUsuario").val();

    datos.oniAutorizado = $("#oni_asignado").val();
    datos.nombreAutorizado = $("#nombre").val();
    datos.nombreUnidadAutorizado = $("#unidad").val();
    datos.cargoAutorizado = $("#cargoAutorizado").val();
    datos.depuesto = $("#depuesto").val();
    
      

     
      $("#btn-asignar").click(function(){
        enviarData(datos);
        
    })  
                  
          }
        })
                  }
                }
             });

          

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
             url: "AsignacionTalonarios/comprobar/"+id,
             dataType: "json",
              beforeSend: function (request) {
                    request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
              success: function(data){                                                      
                 console.log(data)
                 if(data){
                    $("#generar").prop('disabled', false);
                    
                    $('#msj').hide();
                 }else{
                    $("#generar").prop('disabled', true);
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
                url: "<?php echo base_url();?>personal/getNombreByIdTalonarios",
                data : "oni="+$("#oni_asignado").val(),
                type: "POST",
                dataType: 'json',
                beforeSend: function (request) {
                      request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                success: function (res) {

                  var asignado = res.data['NUMTALONARIOSASIGNADOS'];
                  var numAsignado = res.data['CANTIDAD'];
                  $('#total_asignar').prop('readonly', false);
                  if(res.success){
                    
                  console.log(res.data['NOMBRE'])
                  $("#nombre").val(res.data['NOMPER'] + res.data['APEPER']);
                  $("#unidad").val(res.data['NOMBRE']);
                  $("#depuesto").val(res.data['DEPUESTO']);
                  $("#cantidad").val(numAsignado);
                  $("#cargoAutorizado").val(res.data['CARNOM']);
                  $("#disponibilidad").val(numAsignado-asignado);
                  } else {
                    Swal.fire({
                    type: 'warning',
                    title: 'Oni no valido',
                    text: 'Intente con otro',
                    footer: 'TRANSITO'
                  })
                  $("#nombre").val("");
                  $("#cantidad").val("");
                  $("#unidad").val("");

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

      <?php if($allOptions){ ?>
      $("#btnBorrar").hide();
      $("#btnCert").hide();
      $("#btnBorrar").val('');
      <?php } ?>
      $("#btnCancel").hide();
      $("#processSwitch").prop("disabled", true);
      $("#processSwitch").prop("checked", true);
      $('#unidad').prop('readOnly',true);
      $('#oni').prop('readOnly',true);
      $('#persona').prop('readOnly',true);
      $('#ccosto').prop('readOnly',true);
      $('#fechaAsigna').prop('readOnly',true);
      $("#btn-close-historico").trigger('click');

      $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {         
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };
      var movimientos = $("#movimientos_list").DataTable({
      processing: true,
      autoWidth: false,
      autoFill: true,
      oLanguage: {
          sProcessing: "Cargando...",
          sDecimal: "",
          sEmptyTable: "No hay información",
            sInfo: "Mostrando _START_ a _END_ de _TOTAL_ Datos",
            sInfoEmpty: "Mostrando 0 to 0 of 0 Datos",
            sInfoFiltered: "(Filtrado de _MAX_ total Datos)",
            sInfoPostFix: "",
            sThousands: ",",
            sLengthMenu: "Mostrar _MENU_ Datos",
            sLoadingRecords: "Cargando...",
            sProcessing: "Procesando...",
            sSearch: "Buscar:",
            sZeroRecords: "Sin resultados encontrados",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Ultimo",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            }
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
        
        $("#tablaTalonarios").hide()
       
        $("#btn-asignar").prop('disabled', false);
        $("#viewReport").hide();
        limpiarFormulario();
        setSaveButtonNewRegistry();
        movimientos.clear().draw();
        habilitarFrom();
        $('#btnSave').show();
         $('#serie').prop('readOnly',false);
      });
          

      function limpiarFormulario()
      {   
        var validator = $("#formArmas").validate();
        validator.resetForm();
        $("#formArmas")[0].reset();
        cambioSelect2Null(); 
        setSaveButtonNewRegistry();       
        
        $(".reEnterDiv").hide();
        $("#reEnterData").prop("disabled", true);
        $("#reEnterData").prop("checked", false);
        $("#processSwitch").prop("disabled", true);
        $("#processSwitch").prop("checked", true);
        $("#lblProcessSwitch").html('Registrando un Nuevo Bien');
        <?php if($allOptions){ ?>
        $("#btnBorrar").hide();
        $("#btnCert").hide();
        $("#btnBorrar").val('');
        $('#btnCancel').hide();
        <?php } ?>  
        $("#errores_form").hide();
        $("#mensajes_errores").html('');
        $("#labelEstado").html('');
        //$('#fechaadqui').datetimepicker('date', moment());
        //$("#fechaadqui").change();

        var validator = $("#formArmas").validate();
        validator.resetForm();     
      };

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


    <script>
      function setForm(data)
      {
        console.log(data);
        <?php if($allOptions){ ?>
          $("#btnBorrar").show();
          $("#btnCert").show();
        <?php } ?>
        <?php if($allOptions){ ?>
          $("#btnBorrar").val(data['ID_FILA']);
        <?php } ?>
        $('#btnSave').hide();
        $("#processSwitch").prop("disabled", false);
        $("#processSwitch").prop("checked", false);        
        $("#msjCert").html("Certificado Propiedad Serie: " + data['SERIE'])  
        $("#serie").val(data['SERIE']);
        $("#descripcion").val(data['DESCRIPCION']);
        $("#balistica").val(data['BALISTICA']);
        $("#numerofactura").val(data['NUM_FACTURA']);
        $("#numeropoliza").val(data['NUM_POLIZA']);
        $("#packi").val(data['PACKIN_LIST']);
        $("#correlativo").val(data['CORRELATIVO']);
        $("#valor").val(data['VALOR']);
        $("#observaciones").val(data['OBSERVACION']);
        $("#observaciones2").val(data['OBSERVACION2']);
        $("#caf").val(data['CAF']);
        $("#labelEstado").html('Estado: '+data['ESTADO']);
        $("#oni").val(data['ONI_ASIGNACION']);
        $("#unidad").val(data['UNIDAD']);
        $("#persona").val(data['PERSONA']);
        $("#ccosto").val(data['CCOSTO']);
        $("#fechaAsigna").val(data['FECHA_ASIGNACION']);

       
        if(data['FECHA_ADQ']!=null)
        {
          $('#fechaadqui').datetimepicker('date', moment(moment(data['FECHA_ADQ'], 'D-MMM-YYYY')).format('DD/MM/YYYY'));
        }

        if(data['MARCA']!=null  && data['ID_MARCA']!=null) {
          var cMarcaSelect = $('#id_marca');
          var option = new Option(data['MARCA'], data['ID_MARCA'], true, true);
          cMarcaSelect.append(option).trigger('change');
          cMarcaSelect.trigger({
                type: 'select2:select',
                params: {data: data}
          });
        }
        if(data['MODELO']!=null  && data['ID_MODELO']!=null) {
          var cModeloSelect = $('#id_modelo');
          var option = new Option(data['MODELO'], data['ID_MODELO'], true, true);
          cModeloSelect.append(option).trigger('change');
          cModeloSelect.trigger({
                type: 'select2:select',
                params: {data: data}
          });
        }
        if(data['CALIBRE']!=null  && data['ID_CALIBRE']!=null) {
          var cClibreSelect = $('#id_calibre');
          var option = new Option(data['CALIBRE'], data['ID_CALIBRE'], true, true);
          cClibreSelect.append(option).trigger('change');
          cClibreSelect.trigger({
                type: 'select2:select',
                params: {data: data}
          });
        }
        if(data['CLASE']!=null  && data['ID_CLASE']!=null) {
          var cClaseSelect = $('#id_clase');
          var option = new Option(data['CLASE'], data['ID_CLASE'], true, true);
          cClaseSelect.append(option).trigger('change');
          cClaseSelect.trigger({
                type: 'select2:select',
                params: {data: data}
          });
        }
        if(data['TIPO']!=null  && data['ID_TIPO']!=null) {
          var cTipoSelect = $('#id_tipo');
          var option = new Option(data['TIPO'], data['ID_TIPO'], true, true);
          cTipoSelect.append(option).trigger('change');
          cTipoSelect.trigger({
                type: 'select2:select',
                params: {data: data}
          });
        }
        if(data['ADQUI']!=null  && data['ID_TADQ']!=null) {
          var cAdquiSelect = $('#id_tadqui');
          var option = new Option(data['ADQUI'], data['ID_TADQ'], true, true);
          cAdquiSelect.append(option).trigger('change');
          cAdquiSelect.trigger({
                type: 'select2:select',
                params: {data: data}
          });
        }
        if(data['PROVEEDOR']!=null  && data['ID_PROVEEDOR']!=null) {
          var cProveedorSelect = $('#id_proveedor');
          var option = new Option(data['PROVEEDOR'], data['ID_PROVEEDOR'], true, true);
          cProveedorSelect.append(option).trigger('change');
          cProveedorSelect.trigger({
                type: 'select2:select',
                params: {data: data}
          });
        }
        if(data['PROCEDENCIA']!=null  && data['ID_PROCEDENCIA']!=null) {
          var cProcedenciaSelect = $('#id_procedencia');
          var option = new Option(data['PROCEDENCIA'], data['ID_PROCEDENCIA'], true, true);
          cProcedenciaSelect.append(option).trigger('change');
          cProcedenciaSelect.trigger({
                type: 'select2:select',
                params: {data: data}
          });
        }
        if(data['FABRICANTE']!=null  && data['ID_FABRICANTE']!=null) {
          var cFabricaSelect = $('#id_fabricante');
          var option = new Option(data['FABRICANTE'], data['ID_FABRICANTE'], true, true);
          cFabricaSelect.append(option).trigger('change');
          cFabricaSelect.trigger({
                type: 'select2:select',
                params: {data: data}
          });
        }
        if(data['PAIS']!=null  && data['ID_PAIS']!=null) {
          var cPaisSelect = $('#id_pais');
          var option = new Option(data['PAIS'], data['ID_PAIS'], true, true);
          cPaisSelect.append(option).trigger('change');
          cPaisSelect.trigger({
                type: 'select2:select',
                params: {data: data}
          });
        }   
        if(data['ESTADO']!=null  && data['ID_ESTADO']!=null) {
          var cEstadoSelect = $('#id_estado');
          var option = new Option(data['ESTADO'], data['ID_ESTADO'], true, true);
          cEstadoSelect.append(option).trigger('change');
          cEstadoSelect.trigger({
                type: 'select2:select',
                params: {data: data}
          }); 
        }

        dehabilitarForm();

      }
</script>
<script>
  <?php if($allOptions){ ?>
      $('#btnBorrar').click(function() {
        console.log($(this).val());
        Swal.fire({
          title: 'Esta seguro de borrar el Activo Fijo?',
          text: "Este proceso es irreversible!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, deseo borrarlo',
          cancelButtonText: 'Cancelar',
        }).then((result) => {
          if (result.value) {
            swal.showLoading();
            $.ajax({ 
                url: "Armas/delete/"+$(this).val(),
                type: "GET",
                dataType: 'json',
                beforeSend: function (request) {
                        request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                success: function (res) {
                  Swal.fire(
                    'Eliminado!',
                    'Su dato ha sido eliminado con exito.',
                    'success'
                  )
                  $('#btnLimpiar').click();
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

         console.log($(this).val());
      });
      <?php } ?>
</script>

<script>
  function dehabilitarForm(){
    $('#formArmas select').attr('disabled', 'disabled');
    $('#formArmas input').attr('disabled', 'disabled');
    $('#formArmas textArea').attr('disabled', 'disabled');
  };

  function habilitarFrom(){
    $('#formArmas select').removeAttr("disabled");
    $('#formArmas input').removeAttr("disabled");
    $('#formArmas textArea').removeAttr("disabled");
  }
</script>
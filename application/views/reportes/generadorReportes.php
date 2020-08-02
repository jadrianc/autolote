<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Generador de Reportes</h1>
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
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Seleccione una de las siguientes opciones</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
        <div class="row">
          <div class="col-12 col-sm-12 col-lg-12">
            <div class="card card-info card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#crear" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">CREAR</a>
                  </li> 
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#buscar" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">BUSCAR</a>
                  </li> 
                <!--  <li class="nav-item">
                    <a class="nav-link" active id="custom-tabs-one-messages-tab" data-toggle="pill" href="#simular" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="true">SIMULAR</a>
                  </li> -->
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="crear" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                  <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-secondary p-1">
                                    <label for="">Simular Reporte de Remision</label>
                                </div>
                                <div class="card-body">
                                <form action="" id="formSimular" autocomplete="off">
                                        <div class="content">
                                           
                                                
                                                    <div class="row">
                                                        <h3 class="card-title">
                                                                <i class="fas fa-edit"></i>
                                                                Seleccione fechas en las cuales desea saber las esquelas que seran remitidas
                                                                <hr>
                                                        </h3>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="">Inlcuir desde</label>
                                                                    <div class="input-group date" id="fechaDesdesim" data-target-input="nearest">
                                                                        <div class="input-group-append" data-target="#fechaDesdesim" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                                        </div>
                                                                        <input type="text" class="form-control datetimepicker-input" placeholder="Desde" 
                                                                        name="fechaDesdesim" data-target="#fechaDesdesim" required/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="">Hasta</label>
                                                                    <div class="input-group date" id="fechaHastasim" data-target-input="nearest">
                                                                        <div class="input-group-append" data-target="#fechaHastasim" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                                        </div>
                                                                        <input type="text" class="form-control datetimepicker-input" placeholder="Hasta" 
                                                                        name="fechaHastasim" data-target="#fechaHastasim" required/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <table class="table table-bordered text-center clearfix">
                                                                <tr>
                                                                    <th>
                                                                        <div class="icheck-primary d-inline">
                                                                            <input type="radio" id="fechaingSim" value="FECHA_INGRESO" name="tipoFechasim" checked>
                                                                            <label for="fechaingSim">
                                                                            Fecha Ingreso de Esquela
                                                                            </label>
                                                                        </div>
                                                                    </th>
                                                                    <th>
                                                                        <div class="icheck-primary d-inline">
                                                                            <input type="radio" id="fechaimpSim" value="FECHA_ESQUELA" name="tipoFechasim">
                                                                            <label for="fechaimpSim">
                                                                            Fecha Imposicion de Esquela
                                                                            </label>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                            </table
                                                         </div>
                                                
                                            
                                        </div>
                                        <div class="row">
                                        <div class="col-md-10"></div>
                                            <div class="col-md-2">
                                                <button class="btn btn-success float-rigth" id="btnSimulacion">Simulacion</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="" id="totalEsquelas"></label>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" id="sinDecomiso"></label>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" id="conDecomiso"></label>
                                            </div>
                                        </div>  
                                        <div class="card card-primary" id="div02">
                                          <div class="card-header">
                                              <h3 class="card-title" id="title-list">Lista de documentos</h3>
                                              <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                                              </div>
                                          </div>
                                          <div class="card-body">
                                            <div class="table-responsive">
                                              <div class="table" id="tablaSimulacion">
                                                  <table class="table table-bordered" id="tableSimular">
                                                      <thead>
                                                          <tr>
                                                              <th>N°</th>
                                                              <th>SERIE</th>
                                                              <th>NOMBRE</th>
                                                              <th>FECHA</th>
                                                              <th>IMPONE</th>
                                                              <th>DECOMISOS</th>
                                                              <th>PLACA</th>
                                                             
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                      </tbody>
                                                  </table>
                                              </div>
                                            </div>
                                          </div>
                                      </div>
                                </form>
                                </div>
                            </div>
                        </div>
                      </div>
                  </div>
                      <div class="row" id="crearReporte">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-secondary p-1">
                                    <label for="">Crear Nuevo Reporte</label>
                                </div>
                                <div class="card-body">
                                <form action="" id="formCrear" autocomplete="off">
                                        <div class="content">
                                            <div class="row">
                                                    <h3 class="card-title">
                                                    <i class="fas fa-edit"></i>
                                                    ENCABEZADO
                                                    <hr>
                                                </h3>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Fecha</label>
                                                        <div class="input-group date" id="fechaadqui" data-target-input="nearest">
                                                            <div class="input-group-append" data-target="#fechaadqui" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control datetimepicker-input" placeholder="Fecha de Adquisición" 
                                                            name="fechaadqui" data-target="#fechaadqui" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Departamento</label>
                                                        <select class="form-control select2 select2-info" name="departamento" id="departamento" data-dropdown-css-class="select2-info" style="width: 100%;" required> </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Numero de Oficio</label>
                                                        <input type="text" id="numOficio" name="numOficio" class="form-control text-uppercase" placeholder="numero oficio">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                            <label for="">Dirigido a</label>
                                                            <input type="text" id="dirigido" name="dirigido" class="form-control text-uppercase" placeholder="Nombre">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                        <div class="form-group">
                                                                <label for="">Cargo</label>
                                                                <input type="text" id="cargo" name="cargo" class="form-control text-uppercase" placeholder="Cargo">
                                                        </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                
                                            <h3 class="card-title">
                                                    <i class="fas fa-edit"></i>
                                                    CIERRE
                                                    <hr>
                                                </h3>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                        <div class="form-group">
                                                                <label for="">Remite</label>
                                                                <input type="text" id="remite" name="remite" class="form-control text-uppercase" placeholder="Nombre Remite">
                                                        </div>
                                                </div>
                                                <div class="col-md-6">
                                                        <div class="form-group">
                                                                <label for="">Cargo</label>
                                                                <input type="text" id="cargoRemite" name="cargoRemite" class="form-control text-uppercase" placeholder="Cargo Remite">
                                                        </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row" id="divFechas">
                                            <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Incluir desde</label>
                                                        <div class="input-group date" id="fechaDesde" data-target-input="nearest">
                                                            <div class="input-group-append" data-target="#fechaDesde" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control datetimepicker-input" placeholder="Desde" 
                                                             data-target="#fechaDesde" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Hasta</label>
                                                        <div class="input-group date" id="fechaHasta" data-target-input="nearest">
                                                            <div class="input-group-append" data-target="#fechaHasta" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control datetimepicker-input" placeholder="Hasta" 
                                                             data-target="#fechaHasta" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="divTipoFecha">
                                                <table class="table table-bordered text-center clearfix">
                                                    <tr>
                                                        <th>
                                                            <div class="icheck-primary d-inline">
                                                                <input type="radio" id="fechaIngEsquela" value="FECHA_INGRESO" name="tipoFecha" checked>
                                                                <label for="fechaIngEsquela">
                                                                Fecha Ingreso de Esquela
                                                                </label>
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="icheck-primary d-inline">
                                                                <input type="radio" id="fechaImpEsquela" value="FECHA_ESQUELA" name="tipoFecha">
                                                                <label for="fechaImpEsquela">
                                                                Fecha Imposicion de Esquela
                                                                </label>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </table
                                            </div>
                                        </div>  
                                
                                </div>
                                <div class="card-footer">
                                   
                                        <div class="row">
                                            <div class="col-md-8"></div>
                                            <div class="col-md-4">
                                            <input type="button" id="btnCrearReporte" class="btn btn-success ml-5" value="Crear Reporte Sertrasen">
                                            </div>
                                        </div>
                                    
                                </div>
                                </form>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="container" id="btnReportes">
                        <div class="row">
                          <div class="col-md-4">
                            <button id="reporteOficio" class="btn btn-info"><i class="fas fa-file-pdf"></i> OFICIO</button>
                          </div>
                          <div class="col-md-4">
                            <button id="SinDecomisos" class="btn btn-info"><i class="fas fa-file-pdf"></i> DETALLE ESQUELA SIN DECOMISO</button>
                          </div>
                          <div class="col-md-4">
                            <button id="ConDecomisos" class="btn btn-info"><i class="fas fa-file-pdf"></i> DETALLE ESQUELA CON DECOMISO</button>
                          </div>
                        </div>
                        <br>
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
                  </div>
                  <div class="tab-pane fade" id="buscar" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                  <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-secondary p-1">
                                    <label for="">Buscar Reporte por Numero de Oficio</label>
                                </div>
                                <div class="card-body">
                                <form action="" id="formBuscar" autocomplete="off">
                                        <div class="content">
                                            <div class="row">
                                                <div class="row">
                                                    <h3 class="card-title">
                                                            <i class="fas fa-edit"></i>
                                                            Digite el numero de Oficio para Realizar la Busqueda
                                                            <hr>
                                                        </h3>
                                                </div>
                                            </div>
                                               
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                        <label for="">Fecha</label>
                                                        <div class="input-group date" id="fechaBusqueda" data-target-input="nearest">
                                                            <div class="input-group-append" data-target="#fechaBusqueda" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control datetimepicker-input" placeholder="Fecha Busqueda" 
                                                            name="fechaBusqueda" data-target="#fechaBusqueda" required/>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                      <table class="table table-bordered text-center clearfix">
                                                      <tr>
                                                          <th>
                                                              <div class="icheck-primary d-inline">
                                                                  <input type="radio" id="solounidad" value="unidad" name="geografico" checked>
                                                                  <label for="solounidad">
                                                                  Solo mi Unidad
                                                                  </label>
                                                              </div>
                                                          </th>
                                                          <th>
                                                              <div class="icheck-primary d-inline">
                                                                  <input type="radio" id="nacional" value="nacional" name="geografico">
                                                                  <label for="nacional">
                                                                  A Nivel Nacional
                                                                  </label>
                                                              </div>
                                                          </th>
                                                      </tr>
                                                      </table>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-10"></div>
                                                        <div class="col-md-2">
                                                            <button class="btn btn-primary" id="btnBuscar"><i class="fas fa-search"></i> Buscar</button>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="card card-primary" id="div02">
                                          <div class="card-header">
                                              <h3 class="card-title" id="title-list">Lista de Oficios</h3>
                                              <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                                              </div>
                                          </div>
                                          <div class="card-body">
                                            <div class="table-responsive">
                                              <div class="table" id="tablaOficio">
                                                  <table class="table table-bordered" id="tableOficios">
                                                      <thead>
                                                          <tr>
                                                              <th>N°</th>
                                                              <th>NUMERO DE OFICIO</th>
                                                              <th>TOTAL</th>
                                                              <th>UNIDAD</th>
                                                              <th>DOCUMENTO</th>
                                                             
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                      </tbody>
                                                  </table>
                                              </div>
                                            </div>
                                          </div>
                                          
                                      </div>
                                            
                                      <div class="card card-danger" id="div04">
                      <div class="card-header">
                          <h3 class="card-title" id="title-pdf">Documento PDF</h3>
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                        </div>
                      </div>

                      

                      <div class="card-body">
                        <div class="row" id="drawPDF1">
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
                        <iframe width="100%" height="700" src="" id="viewReport1"></iframe>
                        </div>
                    </div>


                                        </div>  
                                </form>
                                </div>
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="tab-pane fade" id="simular" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                  
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
         
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>

  <script>
$(document).ready(function() {
  $("#viewReport1").hide()
  $("#divTipoFecha").hide()
  $("#divFechas").hide()
  $("#crearReporte").hide();

  $("#btnReportes").hide();

  $("#formCrear").validate({  
        rules: {
          fechaadqui:{required: true},
          departamento:{required: true},
          numOficio:{required: true},
          dirigido:{required: true},
          cargo:{required: true},
          remite:{required: true},
          cargoRemite:{required: true},
          fechaDesde:{required: true},
          fechaHasta:{required: true}
        },
        messages: {
          fechaadqui: "Este campo es requerido",
          departamento: "Este campo es requerido",
          numOficio: "Este campo es requerido",
          dirigido: "Este campo es requerido",
          cargo: "Este campo es requerido",
          remite: "Este campo es requerido",
          cargoRemite: "Este campo es requerido",
          fechaDesde:"Este campo es requerido",
          fechaHasta: "Este campo es requerido"
          
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
      
      $("#btnCrearReporte").click(function() {
        
        if($("#formCrear").valid()) {

         

          if($("#fechaingSim").is(":checked")) {
          var tipo = $("#fechaingSim").val();
         
        }
        if($("#fechaimpSim").is(":checked")) {
          var tipo = $("#fechaimpSim").val();
        }

          Swal.fire({
              title: 'Crear Reporte de remision: \n' + $("#numOficio").val(),
              text: 'Dirigido a: ' + $("#dirigido").val() + ' \nEntre: ' + $("#fechaDesde").data('date') + ' Hasta: ' + $("#fechaHasta").data('date'),
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Crear',
              cancelButtonText: 'Cancelar',
            }).then((result) => {
              if (result.value) {
                swal.showLoading();

             
                
                $.ajax({ 
                url: "<?php echo base_url();?>GeneradorReporte/crear",
                data: $('#formCrear').serialize()+"&fechaDesde="+$("#fechaDesdesim").data('date')+"&fechaHasta="+$("#fechaHastasim").data('date')+"&tipoFecha="+tipo,
                type: "POST",
                beforeSend: function (xhr, settings) {
                  let timerInterval
                      Swal.fire({
                        title: 'Procesando',
                        html: 'Espere...',
                        timer: 2000,
                        timerProgressBar: true,
                        onBeforeOpen: () => {
                          Swal.showLoading()
                          timerInterval = setInterval(() => {
                            const content = Swal.getContent()
                            if (content) {
                              const b = content.querySelector('b')
                              if (b) {
                                b.textContent = Swal.getTimerLeft()
                              }
                            }
                          }, 100)
                        }
                      })

                  xhr.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                success: function (res) {
               console.log("crear listo")
                  if(res[10] == "f"){
                    Swal.fire({
                          type: 'warning',
                          title: 'Advertencia...',
                          text: 'No se encontraron registros ',
                          footer: 'TRANSITO'
                        })
                  }else{
                      $("#btnReportes").show();
                      //console.log(res)  
                      Swal.fire({
                              type: 'success',
                              title: 'Exito',
                              text: 'Su registro ha sido guardado, Elija Tipo de Reporte',
                              footer: 'TRANSITO'
                            })
                      
                      $('#modal-certificado').modal('hide');                           
                      //clearFormSearch()
                      $('#reporteOficio').val(res);
                        //$("#reporteOficio").attr('src', "data:application/pdf;base64" + res);



                        $.ajax({ 
                    url: "<?php echo base_url();?>GeneradorReporte/getReporteSinDecomiso",
                    data: $('#formCrear').serialize()+"&fechaDesde="+$("#fechaDesdesim").data('date')+"&fechaHasta="+$("#fechaHastasim").data('date')+"&tipoFecha="+tipo,
                    type: "POST",
                    beforeSend: function (xhr, settings) {
                      xhr.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                    },
                    success: function (res) {
                      console.log("sin decomiso listo")
                      //console.log(res) 
                      if(res.status == false){
                          
                      } else{
                        $('#SinDecomisos').val(res);
                      }                     
                      
                      $.ajax({ 
                    url: "<?php echo base_url();?>GeneradorReporte/getReporteConDecomiso",
                    data: $('#formCrear').serialize()+"&fechaDesde="+$("#fechaDesdesim").data('date')+"&fechaHasta="+$("#fechaHastasim").data('date')+"&tipoFecha="+tipo,
                    type: "POST",
                    beforeSend: function (xhr, settings) {
                      xhr.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                    },
                    success: function (res) {
                      console.log("con decomiso listo")
                      //console.log(res) 
                      //deshabilitarFormCrear();                      
                      $('#ConDecomisos').val(res);
                        //$("#reporteOficio").attr('src', "data:application/pdf;base64" + res);  
                    }
                })  
                    }
                    
                });

                

                  }
                }
             });

             

             
                    
          }
        })

                
        }
      })
        
      $("#reporteOficio").click(function(){

        $("#viewReport").show();
        $("#drawPDF").hide(); 
        $("#viewReport").attr('src', "data:application/pdf;base64" +  $("#reporteOficio").val());
      })

      $("#SinDecomisos").click(function(){

          $("#viewReport").show();
          $("#drawPDF").hide(); 
          $("#viewReport").attr('src', "data:application/pdf;base64" +  $("#SinDecomisos").val());
        })

        $("#ConDecomisos").click(function(){

          $("#viewReport").show();
          $("#drawPDF").hide(); 
          $("#viewReport").attr('src', "data:application/pdf;base64" +  $("#ConDecomisos").val());
        })

      $("#viewReport").hide();
      $("#departamento").select2({
          placeholder: "Seleccione Departamento",
          ajax: { 
            url: 'Esquelas/getSelect2Departamentos',
            type: "post",
            dataType: 'json',
            beforeSend: function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            },
            delay: 150,
            data: function (params) {
                return {
                  searchTerm: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                  results: response
                };
            }
          }
      });

      $('#fechaadqui').datetimepicker({
        format: 'L',
        locale: 'es',
        maxDate: $.now(),
        defaultDate: moment($.now()).toDate()
      });

      $('#fechaDesde').datetimepicker({
        format: 'L',
        locale: 'es',
        maxDate: $.now(),
        defaultDate: moment($.now()).toDate()
      });

      $('#fechaHasta').datetimepicker({
        format: 'L',
        locale: 'es',
        maxDate: $.now(),
        defaultDate: moment($.now()).toDate()
      });
      
      $('#fechaBusqueda').datetimepicker({
        format: 'L',
        locale: 'es',
        maxDate: $.now(),
        defaultDate: moment($.now()).toDate()
      });

      $('#fechaHastasim').datetimepicker({
        format: 'L',
        locale: 'es',
        maxDate: $.now(),
        defaultDate: moment($.now()).toDate()
      });
      
      $('#fechaDesdesim').datetimepicker({
        format: 'L',
        locale: 'es',
        maxDate: $.now(),
        defaultDate: moment($.now()).toDate()
      });
      


const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    function deshabilitarFormCrear(){
      $("#numOficio").attr('readonly', true);
      $("#fechaadqui").attr('readonly', true);
      $("#dirigido").attr('readonly', true);
      $("#cargo").attr('readonly', true);
      $("#remite").attr('readonly', true);
      $("#cargoRemite").attr('readonly', true);
      $('#formCrear select').attr('disabled', 'disabled');
      $("#fechaDesde").attr('disabled', true);
      $("#fechaHasta").attr('disabled', true);
      $("#fechaIngEsquela").attr('disabled', true);
      $("#fechaImpEsquela").attr('disabled', true);
      $("#btnCrearReporte").attr('disabled', true);


    }

    $("#formSimular").validate({  
        rules: {
          
          fechaDesdesim:{required: true},
          fechaHastasim:{required: true},
          fechaHasta:{required: true}
        },
        messages: {
          
          fechaDesdesim: "Este campo es requerido",
          fechaHastasim:"Este campo es requerido",
          fechaHasta: "Este campo es requerido"
          
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


      $("#btnBuscar").click(function(e) {
   e.preventDefault()
        $("#div02").show();
        var fecha1 = $("#fechaBusqueda").data('date');
        
        
        if($("#solounidad").is(":checked")) {
          var tipo = $("#solounidad").val();
         
        }
        if($("#nacional").is(":checked")) {
          var tipo = $("#nacional").val();
        }

        var data = {
          fecha : fecha1,
          tipoFecha : tipo
        };
       $("#tablaOficio").show();
       
        

        window.table = $('#tableOficios').DataTable({
       
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
          "url": "GeneradorReporte/getOficios",
            "type": "post",
            "data": data,
            "dataSrc": "",
            'beforeSend': function (request) {
                request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }
        },
        "columns": [
            { "data": "ID_FILA" },
            { "data": "NUM_OFICIO" },
            { "data": "TOT_ESQUELAS" },
            { "data": "NOMBRE" }
        ],
        "columnDefs": [ {
            "targets": 4,
            "class": "project-actions text-center",
            "data": null,
            "defaultContent": "<button id='btnDocumento' class='btn btn-danger btn-sm btn-oficio'><i class='fas fa-file-pdf'></i></button> "
        } ]
    });
           table.on( 'draw', function () {
            Toast.fire({
                          type: 'success',
                          title: 'Registros Encontrado'
                        })
          } );
          
          
      });


      $("#tableOficios tbody").on('click', '.btn-oficio', function(e){
        e.preventDefault()
        var data = table.row( $(this).parents('tr') ).data();
        console.log(data);
        $.ajax({ 
            url: "<?php echo base_url();?>GeneradorReporte/crearOficio/" + data["ID_FILA"],
        
            type: "POST",
            beforeSend: function (xhr, settings) {
              xhr.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            },
            success: function (res) {
              Toast.fire({
                          type: 'success',
                          title: 'Registro Encontrado'
                        })
          
              //console.log(res) 
              //deshabilitarFormCrear();                      
              $("#viewReport1").show()
              $("#drawPDF1").hide()
              $("#viewReport1").attr('src', "data:application/pdf;base64" + res);  
            }
        })  
      })


  })

 


  $("#btnSimulacion").click(function() {
    if($("#formSimular").valid()) {
        $("#div02").show();
        var fecha1 = $("#fechaDesdesim").data('date');
        var fecha2 = $("#fechaHastasim").data('date');
        
        if($("#fechaingSim").is(":checked")) {
          var tipo = $("#fechaingSim").val();
         
        }
        if($("#fechaimpSim").is(":checked")) {
          var tipo = $("#fechaimpSim").val();
        }

        var data = {
          fechaDesdesim : fecha1,
          fechaHastasim : fecha2,
          tipoFecha : tipo
        };
       $("#tablaSimulacion").show();
      
         table = $('#tableSimular').DataTable({
          paging:   true,
          filter: true,
          destroy: true,
          searching: true,
          language: {
              "decimal": "",
              "emptyTable": "No hay información",
              "info": "Mostrando _START_ a _END_ de _TOTAL_ Datos",
              "infoEmpty": "Mostrando 0 to 0 of 0 Datos",
              "infoFiltered": "(Filtrado de _MAX_ total Datos)",
              "infoPostFix": "",
              "thousands": ",",
              "lengthMenu": "Mostrar _MENU_ Datos",
              "loadingRecords": "No existe asignacion para estos datos...",
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
            "url": "<?php echo base_url();?>GeneradorReporte/getSimulacion",
            "type": "POST",
            "data" : data,
            'beforeSend': function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            },
            "error": function (res){
              Swal.fire({
                    type: 'warning',
                    title: 'Advertencia...',
                    text: 'No se encontraron registros ',
                    footer: 'TRANSITO'
            })
            }
        },
        "columns": [
            { "data": "ID_FILA" },
            { "data": "NUM_SERIE" },
            { "data": "NOMBRES" },
            { "data": "FECHA_ESQUELA" },
            { "data": "ONI_IMPONE" },
            { "data": "DECOMISOS" },
            { "data": "NUM_PLACA" }
        ]
        
    }); 

    $.ajax({ 
                url: "<?php echo base_url();?>GeneradorReporte/getNumEsquelas",
                data: data,
                type: "POST",
                beforeSend: function (xhr, settings) {
                  xhr.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                success: function (res) {
                 var esquelas = JSON.parse(res)
                  console.log(esquelas.total) 
                                        
                 $("#totalEsquelas").text('Total Esquelas: ' + esquelas.total);
                 $("#conDecomiso").text('Esquelas con Decomiso: ' + esquelas.con_decomiso);
                 $("#sinDecomiso").text('Esquelas Sin Decomiso: ' + esquelas.sin_decomiso);
                 $("#crearReporte").show();    
                }
             })

    
           }else {
            Swal.fire({
                    type: 'warning',
                    title: 'Advertencia...',
                    text: 'Llene todos los campos',
                    footer: 'TRANSITO'
            })
           }
           


           table.on( 'draw', function () {
            
            $('#tablaSimulacion tr').each(function() { 
              //Id = $(this).find("td:last").html();
                
              
            })

            //console.log(total)
          } );
          
          
      });
  </script>
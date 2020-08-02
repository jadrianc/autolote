<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CONTROL VEHICULAR</h1>
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
        <div class="card-header bg-secondary">
          <h3 class="card-title">Planes Operativos</h3>
        </div>
        <div class="card-body">
        <form action="" id="buscarPlanes" autocomplete="off">
            <div class="row">
                <h3 class="card-title"><i class="fas fa-edit"></i>Selecciones el periodo de tiempo para crear el consolidado de controles realizados en las diferentes dependencias policiales.  </h3>
            </div>
            <br>
            <div class="row">
                
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
            <div class="row">
              
            </div>

           
        </div>
        
        <!-- /.card-body -->
        <div class="card-footer">
         <div class="row">
         <div class="col-md-9"></div>
            <div class="col-md-3">
                <button id="buscar" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
            </div>
         </div>
        </div>
        </form>
        <!-- /.card-footer-->
      </div>
      <div class="card card-primary" id="div02">
        <div class="card-header">
            <h3 class="card-title" id="title-list">Talonarios Asignados</h3>
            <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
        </div>
        <div class="card-body">
        <div class="table-responsive">
            <div class="table" id="tablaDiv">
                <table class="table table-bordered" id="tablaBitacora">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>ID</th>
                            <th>ESTADO</th>
                            <th>TALONARIO</th>
                            <th>ASIGNADO A</th>
                            <th>ULTIMA ESQUELA</th>
                            <th>PENDIENTES</th>
                            <th>OPCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>

  <script>
  
  $(document).ready(function() {

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

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

      $("#viewReport").hide();

     $("#buscar").click(function(event){
         event.preventDefault();
         var oni = $("#oni").val();
         var nombre = $("#nombre").val();

         if(oni == "" && nombre == ""){
            Swal.fire({
                type: 'warning',
                title: 'Advertencia...',
                text: 'Debe Ingresar ONI o Nombre para continuar ',
                footer: 'TRANSITO'
            })
         }else{

            var data = {
                oni : oni,
                nombre : nombre
        };
       $("#tablaDiv").show();
       
        

        window.table = $('#tablaBitacora').DataTable({
       
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
          "url": "Bitacora/getBitacoraTalonarios",
            "type": "post",
            "data": data,
            'beforeSend': function (request) {
                request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            }
        },
        "columns": [
          { "data": "NUM" },
            { "data": "ID_FILA" },
            { "data": "ESTADO" },
            { "data": "TALONARIO" },
            { "data": "NOMBRECOMPLETO" },
            { "data": "ULTIMAESQUELA" },
            { "data": "PENDIENTES" }
        ],
        "columnDefs": [ {
            "targets": 7,
            "class": "project-actions text-center",
            "data": null,
            "defaultContent": "<button id='btnPdf' class='btn btn-danger btn-sm btn-esquelas'><i class='fas fa-file-pdf'></i></button> <button id='btnexcel' class='btn btn-success btn-sm btn-excel'><i class='fas fa-file-excel'></i></button>"
        } ]
    });
           table.on( 'draw', function () {
            Toast.fire({
                type: 'success',
                title: 'Registros Encontrado'
            })
          } );
         }
     })

     $("#tablaBitacora tbody").on('click', '.btn-esquelas', function(e){
        e.preventDefault()
        var data = table.row( $(this).parents('tr') ).data();
       // console.log(data);
        //console.log(data['TALONARIO'])
        var serie = data['TALONARIO'].split(" ")
        var serieInicial = serie[0];
        var serieFinal = serie[2];
        console.log(serieInicial)
        console.log(serieFinal)
        $.ajax({ 
            url: "<?php echo base_url();?>Bitacora/crearBoleta/" + serieInicial +"/"+serieFinal,
        
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
              $("#viewReport").show()
              $("#drawPDF").hide()
              $("#viewReport").attr('src', "data:application/pdf;base64" + res);  
            }
        })  
      })

      $("#tablaBitacora tbody").on('click', '.btn-excel', function(e){
        e.preventDefault()
        var data = table.row( $(this).parents('tr') ).data();
       // console.log(data);
        //console.log(data['TALONARIO'])
        var serie = data['TALONARIO'].split(" ")
        var serieInicial = serie[0];
        var serieFinal = serie[2];
        console.log(serieInicial)
        console.log(serieFinal)
  
      var token = <?php echo '"'.$token.'";'; ?>
      var peticion = 'excelArmasConsultas';
      window.open("<?php echo base_url();?>Bitacora/boletaExcel"+'/'+serieInicial+'/'+serieFinal, 'Excel'); 
      
    
  });

  })
  
  </script>
  
  
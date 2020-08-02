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
              <li class="breadcrumb-item active"><a href="#">Inicio</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content-header">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h4 >Acceso rápido</h3>
          <div class="card-tools">
          </div>
        </div>
        <div class="card-body">
          <div class="row">
              <?php if($allOptions === "validacion1" || $allOptions === "validacion5"){  ?>
              <div class="col-md-3">        
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h4>Inventario </h4>
                    <p>Inventario Técnico</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-desktop"></i>
                  </div>
                  <a href="<?php echo base_url();?>inventariotecnico" class="small-box-footer">
                    Ir <i class="fas fa-arrow-circle-right"></i>
                  </a>
              </div>
            </div>
            <?php } ?>

            <?php if($allOptions === "validacion1" || $allOptions === "validacion2" || $allOptions === "validacion4" || $allOptions === "validacion6"){  ?>
              <div class="col-md-3">        
                <div class="small-box bg-success">
                  <div class="inner">
                    <h4>Catalogo de Bienes</h4>

                    <p>Ingreso de Bienes</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-edit"></i>
                  </div>
                  <a href="<?php echo base_url();?>activosfijos" class="small-box-footer">
                    Ir <i class="fas fa-arrow-circle-right"></i>
                  </a>
              </div>
            </div>
            <?php } ?>
            <?php if($allOptions === "validacion1" || $allOptions === "validacion2" || $allOptions === "validacion3" || $allOptions === "validacion4" || $allOptions === "validacion6"){  ?>
            <div class="col-md-3">        
                <div class="small-box bg-primary">
                  <div class="inner">
                    <h4>Consultas Generales</h4>

                    <p>Consulta de Bienes</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-search"></i>
                  </div>
                  <a href="<?php echo base_url();?>consultasgenerales" class="small-box-footer">
                    Ir <i class="fas fa-arrow-circle-right"></i>
                  </a>
              </div>
            </div>
            <?php } ?>
            <?php if($allOptions === "validacion1" || $allOptions === "validacion2" || $allOptions === "validacion4" || $allOptions === "validacion6"){  ?>
            <div class="col-md-3">        
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h4>Reportes</h4>

                    <p>Reporte General</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-file-pdf"></i>
                  </div>
                  <a href="<?php echo base_url();?>reportes/ReporteGeneral" class="small-box-footer">
                    Ir <i class="fas fa-arrow-circle-right"></i>
                  </a>
              </div>
            </div>
            <?php } ?>
            
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?=$ccosto?></h3>
          <div class="card-tools">
          </div>
        </div>
        <div class="card-body">
          <div class="row">
              <div class="col-md-6">              
                      <table class="table m-0" id="tablaClases">
                        <thead>
                        <tr>
                          <th>Código</th>
                          <th>Bienes</th>
                          <th>Cantidad</th>
                          <th>Valor Total</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        <tr>        
                            <td><?= $computadoraId?></td>
                            <td><?= $computadora?></td>
                            <td><?= $computadoraCant?></td>
                            <td><?= '$ '.number_format($computadoraSuma, 2, '.', ',');?></td>
                            <td>
                              <a href="#" class="my-a text-muted" id="openModal">
                                <i class="fas fa-search"></i>
                              </a>
                            </td>
                        </tr>
                        <tr>        
                            <td><?= $impresoraId?></td>
                            <td><?= $impresora?></td>
                            <td><?= $impresoraCant?></td>
                            <td><?= '$ '.number_format($impresoraSuma, 2, '.', ',');?></td>
                            <td>
                              <a href="#" class="my-a text-muted" id="openModal">
                                <i class="fas fa-search"></i>
                              </a>
                            </td>
                        </tr>
                        <tr>        
                            <td><?= $laptopId?></td>
                            <td><?= $laptop?></td>
                            <td><?= $laptopCant?></td>
                            <td><?= '$ '.number_format($laptopSuma, 2, '.', ',');?></td>
                            <td>
                              <a href="#" class="my-a text-muted" id="openModal">
                                <i class="fas fa-search"></i>
                              </a>
                            </td>
                        </tr>
                        <tr>        
                            <td><?= $clase4_id?></td>
                            <td><?= $clase4_a?></td>
                            <td><?= $clase4_b?></td>
                            <td><?= '$ '.number_format($clase4_c, 2, '.', ',');?></td>
                            <td>
                              <a href="#" class="my-a text-muted" id="openModal">
                                <i class="fas fa-search"></i>
                              </a>
                            </td>
                        </tr>
                        <tr>        
                            <td><?= $autoId?></td>
                            <td><?= $auto?></td>
                            <td><?= $autoCant?></td>
                            <td><?= '$ '.number_format($autoSuma, 2, '.', ',');?></td>
                            <td>
                              <a href="#" class="my-a text-muted" id="openModal">
                                <i class="fas fa-search"></i>
                              </a>
                            </td>
                        </tr>
                        
                        </tbody>
                      </table>
              </div>

              <div class="col-md-6">
              <canvas id="pieChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
              </div>
          </div>
        </div>
      </div>


<div class="row">
      <div class="col-md-6"> 
          <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Sistema TRANSITO</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">        
              <!-- /.card-header -->              
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                  </ol>
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <img class="d-block w-100" src="<?php echo base_url();?>theme/dist/img/activo01.png" alt="First slide">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="<?php echo base_url();?>theme/dist/img/activo02.png" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100"  src="<?php echo base_url();?>theme/dist/img/activo03.png" alt="Third slide">
                    </div>
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
              </div>
              <!-- /.card-body -->
            <!-- /.card -->
          </div>
      </div>
</div>
</section>
</div>

<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h4 class="modal-title" id="tituloModal">Large Modal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table id="subclases_list" class="table table-striped table-bordered table-hover table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Bienes</th>
                        <th>Cantidad</th>
                        <th>Valor en $</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer  bg-secondary">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


 <!-- ChartJS -->
 <script src="<?php echo base_url();?>theme/plugins/chart.js/Chart.min.js"></script>
<script>
 //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#pieChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
        <?php echo '"'.$computadora.'"'; ?>, 
        <?php echo '"'.$impresora.'"'; ?>,
        <?php echo '"'.$laptop.'"'; ?>, 
        <?php echo '"'.$clase4_a.'"'; ?>, 
        <?php echo '"'.$auto.'"'; ?>
      ],
      datasets: [
        {
          data: [<?=$computadoraCant?>,<?=$impresoraCant?>,<?=$laptopCant?>,<?=$clase4_b?>,<?=$autoCant?>],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    /*
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    })*/

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })

</script>
<script>
$(".my-a").click(function(){
  
  //var datos = table.row( $(this).parents('tr') ).data();
  var clase =$(this).parents("tr").find("td").eq(1).html();
  var claseId =$(this).parents("tr").find("td").eq(0).html();
  $("#tituloModal").html(claseId+' - '+clase);
  var datos= {
    id_clase : claseId
  };

  $("#modal-lg").modal("show");
  $('#subclases_list').DataTable().destroy();              
              
  movimientos = $("#subclases_list").DataTable({
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
      },
      processing: true,
      autoWidth: true,
      autoFill: true,
      ajax: {
      "url": "<?php echo base_url();?>inicio/getSubclases",
      "type": "POST", 
      "beforeSend": function (request) {
              request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
      },
      "data": datos
      },
      "columns": [
        {"data": "PRODUCTO"},
        {"data": "CANTIDAD"},
        {"data": "SUMA"}
      ],
  });
});
</script>
 
  <!-- /.content-wrapper -->
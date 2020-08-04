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
  

  

    <!-- datepicker -->
    
  

</head>
<body id="bodyTemplate" class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" id="logout-link" href="<?php echo base_url();
         ?>inicio/Logout"><i class="fas fa-power-off"></i> Cerrar Sesion</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url();
         ?>inicio" class="brand-link">
      <img src="<?php echo base_url();
         ?>theme/dist/img/logo.jpg"
           alt="PNC Logo"
           class="brand-image img-circle elevation">
      <span class="brand-text font-weight-light">IMPORT <b>CARS</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">Usuario : <?php echo $username; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">MODULO</li>
          <?php if(true){  ?>
          <li class="nav-item">
              <a id="li-vehiculo" href="<?php echo base_url();
              ?>Vehiculo" class="nav-link">
              <i class="nav-icon fas fa-car"></i>
              <p>
                Vehiculos
              </p>
            </a>
          </li>
          <li class="nav-item">
              <a id="li-clientes" href="<?php echo base_url();
              ?>Clientes" class="nav-link">
              <i class="nav-icon fas fa-street-view"></i>
              <p>
                Clientes
              </p>
            </a>
          </li>
          <li class="nav-item">
              <a id="li-permiso" href="<?php echo base_url();
              ?>Inspecciones" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Consultas
              </p>
            </a>
          </li>
          <li class="nav-item">
              <a id="li-permiso" href="<?php echo base_url();
              ?>Inspecciones" class="nav-link">
              <i class="nav-icon fas fa-calendar-check"></i>
              <p>
                Asignaciones
              </p>
            </a>
          </li>
          <li class="nav-item">
              <a id="li-cli" href="<?php echo base_url();
              ?>pageClient" class="nav-link">
              <i class="nav-icon fas fa-globe"></i>
              <p>
                Pagina Cliente
              </p>
            </a>
          </li>
          
          <?php } ?> 

          
          <?php if(true){  ?>
          
          
          <li class="nav-header">ADMINISTRACIÓN</li>
          <li class="nav-item">
              <a id="li-rol" href="<?php echo base_url();
              ?>roles" class="nav-link">
              <i class="nav-icon fas fa-user-shield"></i>
              <p>
                Roles de Usuario
              </p>
            </a>
          </li>
          <li class="nav-item">
              <a id="li-usuario" href="<?php echo base_url();
              ?>usuarios" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Usuarios
              </p>
            </a>
          </li>
          <?php } ?>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MA IMPORTS | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();
          ?>theme/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url();
          ?>theme/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();
          ?>theme/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

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

  <!-- jQuery Validate -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  	<div class="image">
          <img src="<?php echo base_url();
          ?>theme/dist/img/logo.jpg" width="200" height="200" class="img-fluid img-circle elevation" alt="User Image">
    </div>
    <a href="/MA Export">LOGIN</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <?php
      if (isset($error_message)) {
      ?>
      <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-ban"></i> Notificacion</h5>
           Estimado usuario :  <?php echo $error_message;?> 
      </div>
      <?php
      }

      ?>


      <p class="login-box-msg">Ingrese sus credenciales</p>
      <form action="<?php echo base_url();
         ?>login/loginUser" autocomplete="off" id="loginForm" method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="username" 
          name="username" placeholder="Usuario" value="<?php if(isset($error_message)) { echo $user;  } ?>" maxlength="10" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user	"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" maxlength="90" 
          required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
		</div>
		<div class="row">
          <!-- /.col -->
          <div class="col-12">
            <input type="submit" id="btn-login" class="btn btn-primary btn-block btn-flat" value="Inicar Sesion">
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
	  <br>
      
    </div>
    <!-- /.login-card-body -->

  
  </div>
</div>
<!-- /.login-box -->
</body>
</html>

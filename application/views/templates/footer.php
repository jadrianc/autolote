
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <strong>Desarrollado por &copy; 2019-2020 <a href="javascript:;">DATUM REDSOFT</a>.</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
</body>
</html>

<script>
  $(document).ready(function() {
    $(document).inactivityTimeout({
        inactivityWait: 600,
        dialogWait: 60,
        dialogMessage : 'Por razones de seguridad, se cerrará sesión automáticamente en %s segundos ' +
        'debido a la inactividad.&nbsp;&nbsp;<a href="javascript:;" style="color: #FFF;"><strong>De click aqui para mantener su sesion activa.</strong></a>',
        logoutUrl: '<?php echo base_url();?>inicio/Logout',
    });
  });
</script>
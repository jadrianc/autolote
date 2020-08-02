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
      
      <div id="errores_form" class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-ban"></i> Errores del Formulario : </h5>
         <div id="mensajes_errores"></div>
      </div>
      
      <div class="row">
      <div class="col-md-4">
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input d-block" id="processSwitch" checked disabled>
          <label class="custom-control-label" id="lblProcessSwitch" for="processSwitch">Registrando Nueva Esquela</label>
        </div>
    </div>
    <div class="col-md-3">
          <div class="custom-control custom-switch" id="nuevoRegistro">
            <input type="checkbox" class="custom-control-input d-inline" id="reEnterData" disabled>
            <label class="custom-control-label" id="lblreEnterData" for="reEnterData">Crear Nuevo Registro en Base a Informacion Actual</label>
          </div>
      </div>
      
      
      
      
        
    
      
      
      </div>
      <form role="form" id="formArmas" autocomplete="off" name="formArmas" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md 6">
        
        </div>
        <div class="col-md-3" >
            <label for="" class="">Numero Esquela</label><input type="number" class="form-control float-sm-right" id="serie" name="serie" placeholder="Serie" required>
        </div>
        </div>
     <br>
     
      <div class="row no-print">
                  
                  <div class="col-md-6">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Estado</th>
                          <th>Usuario</th>
                          <th>Unidad</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><h5><label id="labelEstado"></label></h5></td>
                          <td><h5><label id="labelUsuario"></label></h5></td>
                          <td><h5><label id="labelUnidad"></label></h5></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-sm-5"  style="position: relative; left 20px;">
                        
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-search"  style="margin-right: 5px;">
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
      
      <!-- Default box -->
      <div class="row">
      <div class="col-md-9">
      
      </div>
      <div class="col-md-3 float-left">
      <div class="input-group mb-3 ">
        <!-- /btn-group -->

      
        
        
        </div>
      </div>
      </div>
      <div id="headerCard" class="card card-navy">
      
         <div class="card-header">
            <h3 class="card-title">Información del Conductor <i class="fas fa-pencil-alt"></i></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
            </div>
         </div>
          <div class="card-body bg-light">
                
                <div class="row no-print reEnterDiv">
                
                   
                </div>
                <hr>
                <input type="hidden" id="id_fila" name="id_fila">
                    <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Documento *</label>
                          <select class="form-control select2 select2-info" name="documento" id="documento" 
                            data-dropdown-css-class="select2-info" style="width: 100%;" required> </select>
                        </div>
                      </div>
                        <div class="form-group col-sm-4">
                            <label>Licencia</label>
                            <div class="input-group mb-3">
                              <!-- /btn-group -->
                           
                              <input tabindex="3" placeholder="0000-000000-000-0" type="text" class="form-control text-uppercase" id="licencia" name="licencia" required>
                              
                              <div class="input-group-prepend">
                                  <button type="button" class="btn btn-info" id="searchLicencia"><i class="fas fa-search"></i></button>
                              </div>
                            </div>
                            <p id="msj" style="color: red;"></p>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Apellidos *</label>
                          <input type="text" id="apellidos" name="apellidos" class="form-control text-uppercase" required readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Nombre *</label>
                          <input type="text" id="nombre" name="nombre" class="form-control text-uppercase" required readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Departamento *</label>
                          <select class="form-control select2 select2-info" name="departamento" id="departamento" 
                            data-dropdown-css-class="select2-info" style="width: 100%;" required> </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                    
                      

                    </div>

                    <div class="widget-user-header bg-primary">
                      <hr>                    
                      <h5>&nbsp;&nbsp; Datos del Vehiculo</h5>
                      <hr>
                    </div>                   
                    
                    <div id="infoCompra">
                      <div class="row">
                        
                        <div class="form-group col-sm-2">
                            <label>Numero de Placa</label>
                            <div class="input-group mb-3">
                              <!-- /btn-group -->
                            <input type="text" hidden id="idPlaca" name="idPlaca">
                              <input tabindex="3" type="text" class="form-control text-uppercase" placeholder="PXXXXXX / ABXXXXX" id="num_placa" name="num_placa" required>
                              <input type="hidden" id="cargoAutorizado">
                              <div class="input-group-prepend">
                                  <button type="button" class="btn btn-info" id="searchPlaca"><i class="fas fa-search"></i></button>
                              </div>
                            </div>
                            <p id="msj" style="color: red;"></p>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label>Tipo de Placa *</label>
                            
                            <select class="form-control select2 select2-info" name="placa" id="placa" 
                            data-dropdown-css-class="select2-info" style="width: 100%;" required> </select>
                            <input type="hidden" name="manual" id="manual">
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                          <label>Clase</label>
                          
                          <select class="form-control select2 select2-info" name="clase" id="clase" 
                            data-dropdown-css-class="select2-info" style="width: 100%;" required> </select>
                            <input type="hidden" name="licmanual" id="licmanual">
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="form-group">
                          <label>Marca</label>
                            <input type="text" class="form-control" id="marca" name="marca" readonly>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="form-group">
                          <label>Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" readonly>
                          </div>
                        </div>
                        
                        
                        </div>
                        
                        <div class="row">

                        <div class="col-sm-2">
                          <div class="form-group">
                          <label>Color</label>
                            <input type="text" class="form-control" id="color" name="color">
                          </div>
                        </div>
                        <div class="col-sm-2">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Ruta</label>
                          <input type="text" class="form-control" placeholder="" id="ruta" name="ruta">
                        </div>
                      </div>
                        
                        
                      
                        

                      </div>
                    </div>
                    
                    <div class="widget-user-header bg-primary">
                      <hr>                    
                      <h5>&nbsp;&nbsp;Información de la Falta</h5>
                      <hr>
                    </div>
                    <div id="infoProveedor">
                        <div class="row">
                        <div class="col-md-2">
                        <div class="form-group">
                            
                              <label>Fecha *</label>
                                  <div class="input-group date" id="fechaadqui" data-target-input="nearest">
                                      <div class="input-group-append" data-target="#fechaadqui" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                      </div>
                                      <input type="text" class="form-control datetimepicker-input" placeholder="Fecha de Adquisición" 
                                      name="fechaadqui" data-target="#fechaadqui" required/>
                                  </div>
                              </div>
                        </div>
                            
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label>Hora *</label>
                              
                              <div class="input-group date" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" name="hora_falta" data-target="#hora_falta" id="hora_falta" placeholder="00:00"/>
                              <div class="input-group-append" data-target="#hora_falta" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Falta *</label>
                              <select class="form-control select2 select2-info" name="falta" id="falta" 
                            data-dropdown-css-class="select2-info" style="width: 100%;" required> </select>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Lugar de Infraccion *</label>
                              <input type="text" class="form-control" placeholder="" id="lugar_falta" name="lugar_falta">
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                            <label>Clasificacion</label>
                            
                              <input type="text" class="form-control" placeholder="" id="clasificacion" name="clasificacion" readonly>
                            </div>
                          </div>
                          <div class="col-sm-2">
                        <!-- text input -->
                          <div class="form-group">
                            <label>Valor</label>
                            <input type="text" class="form-control" placeholder="0.00" id="valor" name="valor" readonly>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Observaciones</label>
                              <textarea class="form-control text-uppercase" rows="2" placeholder="" id="observaciones_falta" name="observaciones_falta"></textarea>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <!-- radio -->
                            <div class="form-group clearfix">
                              <div class="icheck-primary d-block">
                                <input type="radio" id="radioPrimary1" name="r1" disabled>
                                <label for="radioPrimary1">Transito</label>
                              </div>
                              <div class="icheck-primary d-block">
                                <input type="radio" id="radioPrimary2" name="r1" disabled>
                                <label for="radioPrimary2">Transporte</label>
                              </div>
                              <div class="icheck-primary d-block">
                                <input type="radio" id="radioPrimary3" name="r1" disabled>
                                <label for="radioPrimary3">Carga</label>
                              </div>
                            </div>
                          </div>
                          
                      </div>
                    </div>

                    

                    <div class="widget-user-header bg-primary">
                      <hr>                    
                      <h5>&nbsp;&nbsp;Información de la Autoridad</h5>
                      <hr>
                    </div>

                 
                      <div class="row">
                      <div class="col-sm-2" id="divOni">
                          <div class="form-group">
                              <label>ONI *</label>
                              <div class="input-group mb-3">
                                <!-- /btn-group -->
                                <input placeholder="oni" type="text" class="form-control text-uppercase" id="oni_asignado" name="oni_asignado" required>
                                <div class="input-group-prepend">
                                  <button type="button" class="btn btn-info" id="searchONI-Asignado"><i class="fas fa-search"></i></button>
                                </div>
                              </div>
                          </div>
                        </div>

                        <div class="col-sm-4" id="divAsignado">
                        <div class="form-group">
                            <label>Nombre Agente</label>
                            <input type="text" class="form-control text-uppercase" id="nombreAgente" name="nombreAgente" required readonly>
                        </div>
                      </div>

                      <div class="col-sm-4" id="divDependencia">
                      <div class="form-group">
                          <label>Ubicacion</label>
                          <input type="text" class="form-control text-uppercase" id="dependencia" name="dependencia" required readonly>
                      </div>
                    </div>
                      </div>

                      <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Fecha Asignación</label>
                              <input type="text" class="form-control" id="fechaAsignacion" readonly>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <label for="">Esquelas Digitadas</label>
                            <input type="number" class="form-control" id="disponibilidad" name="disponibilidad" readonly>
                          </div>
                          <div class="col-sm-3">
                          <div class="form-group">
                          <label>Plan Operativo</label>
                          <select class="form-control select2 select2-info" name="plan" id="plan" 
                            data-dropdown-css-class="select2-info" style="width: 100%;" required> </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                              <label>Observaciones</label>
                              <textarea class="form-control text-uppercase" rows="3" placeholder="" id="observaciones_aut" name="observaciones_aut"></textarea>
                            </div>
                          </div>
                      </div>
                      
                      <div class="row">
                        

                        
                      </div>
                  
                      <div class="widget-user-header bg-primary">
                      <hr>                    
                      <h5>&nbsp;&nbsp;Decomisos</h5>
                      <hr>
                    </div>
                    <div>
                    <div class="form-group clearfix">
                            <div class="row">
                            <table class="table table-bordered text-center">
                                <tr>
                                    
                                    <th>
                                    <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="vehiculo" name="vehiculo">
                                    <label for="vehiculo">
                                    VEHICULO
                                    </label>
                                  </div>
                                    </th>
                                    <th>
                                    <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="tarjeta" name="tarjeta">
                                    <label for="tarjeta">
                                    TARJETA DE CIRCULACION
                                    </label>
                                  </div>
                                    </th>
                                    <th>
                                    <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="licencia_cond" name="licencia_cond">
                                    <label for="licencia_cond">
                                      LICENCIA
                                    </label>
                                  </div>
                                    </th>
                                    <th>
                                    <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="placas1" name="placas1">
                                    <label for="placas1">
                                      PLACAS (1)
                                    </label>
                                  </div>
                                    </th>
                                    <th>
                                    <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="placas2" name="placas2">
                                    <label for="placas2">
                                      PLACAS (2)
                                    </label>
                                  </div>
                                    </th>
                                    <th>
                                    <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="poliza" name="poliza">
                                    <label for="poliza">
                                      POLIZA
                                    </label>
                                  </div>
                                    </th>
                                    <th>
                                    <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="permiso_linea" name="permiso_linea">
                                    <label for="permiso_linea">
                                      PERMISO DE LINEA
                                    </label>
                                  </div>
                                    </th>
                                </tr>
                            
                            </table>
                    </div>
                           </div>
                            
                    
                    </div>
                    <div class="widget-user-header bg-primary">
                      <hr>                    
                      <h5>&nbsp;&nbsp;Adjuntar Archivo</h5>
                      <hr>
                    </div>

                    <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Seleccione Imagen Esquela (max 5 Mb)</label>
                                <input type="file" class="btn btn-info form-control-file" id="file" name="file">
                            </div>
                          </div>
                      </div>
                      <div class="row" id="divImagen" hidden>
                        <div class="col-md-12">
                            <!-- Box Comment -->
                            <div class="card card-widget">
                                  <div class="card-header">
                                      <div class="user-block">
                                        <!--<img class="img-circle" src="../dist/img/user1-128x128.jpg" alt="User Image">
                                        <span class="username"><a href="#">Jonathan Burke Jr.</a></span>
                                        <span class="description">Shared publicly - 7:30 PM Today</span> -->
                                      </div>
                                      <!-- /.user-block -->
                                      <div class="card-tools">
                                        
                                        <button type="button" class="btn btn-info" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                        </button>
                                        
                                      </div>
                                      <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                      <img class="img-fluid pad" id="imgEsquela" src="" alt="Photo">
                                  </div>
                              </div>
                          </div>
                    </div>
                    <!--/.card-footer -->
                    <div class="card-footer">
                    <?php if($ID_ROL != 4 ){ ?>
                      <button type="button" id="btnSave" class="btn btn-success float-right" value="create"><i class="fas fa-save"></i>  Guardar</button>
                      <button type="button" id="btnCancel" class="btn btn-warning"><i class="fas fa-ban"></i>   Cancelar</button>
                    <?php } ?> 
                    </div>
                </form>
              <!-- /.card-body -->
          </div>
      </div>




      <div class="modal fade" id="modal-search" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Buscar Esquela</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form id="searchForm" autocomplete="off" name="searchForm" class="form-horizontal">                    
                    <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group">
                            <label>Serie</label>
                            <input type="text" class="form-control" id="buscarSerie" name="buscarSerie" maxlength="20">
                          </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-info" id="btn-search-modal">Buscar <i class="fas fa-search"></i></button>
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
                  <form id="searchForm" autocomplete="off" name="searchForm" class="form-horizontal">                    
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
      
     // $("#nuevoRegistro").hide();
      $("#clase").prop("disabled", true);
      $("#placa").prop("disabled", true);
      $("#placas1").click( function(){
        if( $(this).is(':checked') ) {
          $("#placas2").prop("disabled", true)
        }else{
          $("#placas2").prop("disabled", false)
        }
      });

      $("#placas2").click( function(){
        if( $(this).is(':checked') ) {
          $("#placas1").prop("disabled", true)
        }else{
          $("#placas1").prop("disabled", false)
        }
      });
      


      $('#hora_falta').datetimepicker({
      format: 'LT'
    })

      $("#falta").select2({
          placeholder: "Seleccione Falta",
          ajax: { 
            url: 'Esquelas/getSelect2Falta',
            type: "post",
            dataType: 'json',
            beforeSend: function (request) {
                  request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
            },
            delay: 150,
            success: function(res){
              //console.log(res)
            },
            data: function (params) {
              
                return {
                  
                  searchTerm: params.term // search term
                };
            },
            processResults: function (response) {
              
              //console.log(response)
                return {

                  results: response
                };
            }
          }
      });

      $('#falta').on('select2:select', function (e) {
        var data = e.params.data;
        console.log(data);
        $("#valor").val(data["valor"])
        $("#clasificacion").val(data["clasificacion"])
        if(data["rubro"] == "CARGA"){
          $("#radioPrimary3").prop("checked", true);
        }else if(data["rubro"] == "TRANSPORTE"){
          $("#radioPrimary2").prop("checked", true);
        }else{
          $("#radioPrimary1").prop("checked", true);
        }
    });

      $("#plan").select2({
          placeholder: "Seleccione Plan Operativo",
          ajax: { 
            url: 'Esquelas/getSelect2Plan',
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

      $("#searchPlaca").click(function(){
      if($("#num_placa").val()!=""){ 
        //var licenciaGuiones = $("#licencia").val();
        //var licencia = licenciaGuiones.replace(/-/g,"");
        console.log(licencia);
        $.ajax({ 
                url: "<?php echo base_url();?>Esquelas/getByPlaca",
                data : "placa="+$("#num_placa").val(),
                type: "POST",
                dataType: 'json',
                beforeSend: function (request) {
                      request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                success: function (res) {
                  //console.log(res.data[0].apellidos)
                  if(res.success == "no valida"){
                    Swal.fire({
                          title: "Placa: " + $("#num_placa").val() + " NO existe",
                          text: "Recuerde que el formato correcto para placas nacionales no debe llevar guion (P12345). ¿Desea Continuar?",
                          type: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Continuar',
                          cancelButtonText: 'Corregir',
                        }).then((result) => {
                          if (result.value) {
                            swal.showLoading();
                           $("#placa").prop("readonly", false);
                           $("#clase").prop("readonly", false);
                           $("#marca").prop("readonly", false);
                           $("#modelo").prop("readonly", false);
                           $("#clase").prop("disabled", false);
                          $("#placa").prop("disabled", false);
                          $("#manual").val("manual");
                          //$("#claseN").val("");
                              
                            
                      }
                    })
                  }
                  
                  if(res.success){
                    
                  
                      console.log(res)
                      $("#marca").val(res.data[0].marca);
                      $("#modelo").val(res.data[0].modelo);
                      $("#color").val(res.data[0].color);
                    
                     // $("#placaN").val(res.data[0].tipo_placa);
                     // $("#claseN").val(res.data[0].clase);

                      var cClibreSelect = $('#clase');
                        var option = new Option(res.data[0].clase, res.data[0].id_clase, true, true);
                        cClibreSelect.append(option).trigger('change');
                        cClibreSelect.trigger({
                              type: 'select2:select'
                        });

                        var placaSelect = $('#placa');
                        var option = new Option(res.data[0].tipo_placa, res.data[0].id_placa, true, true);
                        placaSelect.append(option).trigger('change');
                        placaSelect.trigger({
                              type: 'select2:select'
                        });

                        
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
        $("#licencia").val('');
        Swal.fire({
          type: 'info',
          title: 'Campo Numero de Placa Vacio',
          text: 'Por favor ingrese un numero de Placa para realizar su busqueda',
          footer: 'TRANSITO'
        })
      }
    });
    
      window.documentoChange = function(){
        $("#documento").on("change", function(){
        if($(this).val() == 6){
          $("#licencia").unmask();
          $("#nombre").prop("readonly", false);
          $("#apellidos").prop("readonly", false);
          $("#licencia").val("").prop("readonly", false)
          $("#nombre").val("")
          $("#apellidos").val("")
        }else if($(this).val() == 11){
          $("#licencia").val("000-000000-00")
          .prop("readonly", true);
          $("#nombre").val("CONDUCTOR AUSENTE")
          .prop("readonly", true);

          $("#apellidos").val("CONDUCTOR AUSENTE")
          .prop("readonly", true);
        }else if($(this).val() == 7){
          $("#licencia").unmask();
          $("#nombre").prop("readonly", false);
          $("#apellidos").prop("readonly", false);
          $("#nombre").val("")
          $("#apellidos").val("")
          $("#licencia").val("").prop("readonly", false)
        }
        
        else{
          mascara();
          $("#nombre").prop("readonly", true);
          $("#apellidos").prop("readonly", true);

          $("#licencia").val("")
          .prop("readonly", false);
          $("#nombre").val("")
         

          $("#apellidos").val("")
          
        }
      });
      }
    
      documentoChange()

      $("#documento").select2({
          placeholder: "Seleccione Tipo Documento",
          ajax: { 
            url: 'Esquelas/getSelect2Documentos',
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

      $("#clase").select2({
          placeholder: "Seleccione Clase",
          ajax: { 
            url: 'Esquelas/getSelect2Clase',
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

      $("#placa").select2({
          placeholder: "Seleccione Tipo Placa",
          ajax: { 
            url: 'Esquelas/getSelect2Placa',
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

      $("#searchLicencia").click(function(){
      if($("#licencia").val()!=""){ 
        var licenciaGuiones = $("#licencia").val();
        var licencia = licenciaGuiones.replace(/-/g,"");
        console.log(licencia);
        $.ajax({ 
                url: "<?php echo base_url();?>Licencias/getByLicencia",
                data : "licencia="+licencia,
                type: "POST",
                dataType: 'json',
                beforeSend: function (request) {
                      request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                success: function (res) {
                  
                  console.log(res.success)
                              if(res.success == 'no valida'){
                                Swal.fire({
                          title: "Licencia no existe",
                          text: "Desea Continuar?",
                          type: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Continuar',
                          cancelButtonText: 'Cancelar',
                        }).then((result) => {
                          if (result.value) {
                            swal.showLoading();
                            $("#nombre").prop("readonly", false);
                            $("#apellidos").prop("readonly", false);
                            $("#licmanual").val("manual");
                                
                      }
                    })
                  }
                  if(res.success == true){
                    
                  
                      $("#apellidos").val(res.data[0].apellidos);
                      $("#nombre").val(res.data[0].nombre);
                      $("#nombre").prop("readonly", true);
                      $("#apellidos").prop("readonly", true);
                      
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
        $("#licencia").val('');
        Swal.fire({
          type: 'info',
          title: 'Campo Licencia Vacio',
          text: 'Por favor ingrese un numero de licencia para realizar su busqueda',
          footer: 'TRANSITO'
        })
      }
    });

    mascara();
      function mascara(){
        $(function() {
              $.mask.definitions['~'] = "[+-]";
              $("#licencia").mask("9999-999999-999-9");
              

              $("input").blur(function() {
                  $("#info").html("Unmasked value: " + $(this).mask());
              }).dblclick(function() {
                  $(this).unmask();
              });
          });

      }
      
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

           

      $("#searchONI-Asignado").click(function(){
      if($("#oni_asignado").val()!="" || $("#serie").val()!= ""){ 
        var parametros = {
          "oni": $("#oni_asignado").val(),
          "serie": $("#serie").val()
        }
        $.ajax({ 
                url: "<?php echo base_url();?>Esquelas/getAsigTalonarios",
                data : parametros,
                type: "POST",
                dataType: 'json',
                beforeSend: function (request) {
                      request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                success: function (res) {

                  if(res.status == 'form-not-valid') { 
                      Swal.fire({
                          type: 'info',
                          title: 'Revise el Formulario',
                          text: 'Estimado usuario, ingrese numero de serie',
                          footer: 'TRANSITO'
                        })
                        
                    } 
                    if(res.status == 'no corresponde') { 
                      Swal.fire({
                          type: 'info',
                          title: 'Numero de serie no asignado para: ' + parametros.oni,
                          text: "Ingrese un numero de serie valido",
                          footer: 'TRANSITO'
                        })
                        
                    }
                    if(res.status == 'repetido') { 

                      Swal.fire({
                          type: 'warning',
                          title: 'Este numero de talonario ya fue procesado',
                          text: 'Estimado usuario, ingrese un numero de serie no procesado',
                          footer: 'TRANSITO'
                        })
                        
                    } 
                  if(res.success){
                    console.log(res)
                      $("#nombreAgente").val(res.data[0].nombre + " " +res.data[0].apellidos);
                      $("#dependencia").val(res.data[0].nomunidad);
                      $("#fechaAsignacion").val(res.data[0].fecha);
                      $("#disponibilidad").val(res.data[0].impuestas);
                  } else {
                    $("#nombreAgente").val("");
                      $("#dependencia").val("");
                      $("#fechaAsignacion").val("");
                      $("#disponibilidad").val("");
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
          title: 'Igrese ONI y Numero de Serie',
          text: 'Por favor rellene los campos para realizar su busqueda',
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

      $('#fechaadqui').datetimepicker({
        format: 'L',
        locale: 'es',
        maxDate: $.now(),
        defaultDate: moment($.now()).toDate()
      });

      $('#btnLimpiar').click(function() {
        
        location.reload();
      });

      function clean(){
        
      }
          

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
        $("#processSwitch").prop("v", true);
        $("#processSwitch").prop("checked", true);
        $("#lblProcessSwitch").html('Registrando nueva esquela');
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
        $("#serie").attr("readonly", false)       
      };

      function cambioSelect2Null(){
        
          $('#placa').val(null).trigger('change');
        
        if($('#clase').val()!=null){
          $('#clase').val(null).trigger('change');
        }
        if($('#falta').val()!=null){
          $('#falta').val(null).trigger('change');
        }
        if($('#plan').val()!=null){
          $('#plan').val(null).trigger('change');
        }
        if($('#documento').val()!=null){
          $('#documento').val(null).trigger('change');
        }
        if($('#departamento').val()!=null){
          $('#departamento').val(null).trigger('change');
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
        
       // var estadoSelect = $('#id_estado');
       // var option = new Option('BODEGA', '2', true, true);
        //estadoSelect.append(option).trigger('change');
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
          $("#placa").prop("disabled", false);
                $("#clase").prop("disabled", false);
          var actionType = $('#btnSave').val();
          console.log(actionType);
          var iconSave = '';
          if(actionType == 'create'){
            urlRequest = 'Esquelas/store';
            var data = new FormData($("#formArmas")[0]);
            
          } else if(actionType == 'update') {
            urlRequest = 'Esquelas/update';
            var data = new FormData($("#formArmas")[0]);
          }          

          //$('#btnSave').prop('disabled',true);
          //$('#btnSave').html(iconSave + ' Guardando..');

          $.ajax({
               data: data,
               url: urlRequest,
               type: "POST",
               dataType: 'json',
               contentType: false,
               processData: false,
               beforeSend: function (request) {
                
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



                      request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
               },
               success: function (res) {
                if(actionType == 'create'){
                  console.log(res)
                  if(res.status == "oni invalido"){
                    Swal.fire({
                          type: 'info',
                          title: 'ONI no valido',
                          text: 'Estimado usuario, ingrese un oni que este registrado',
                          footer: 'TRANSITO'
                        })
                        $('#btnSave').prop('disabled',false);
                        
                  }
                    else if(res.status == true){
                      console.log(res);
                      Swal.fire({
                          type: 'success',
                          title: 'Exito',
                          text: 'Su registro ha sido guardado',
                          footer: 'TRANSITO'
                        })
                        $("#id_fila").val(res.data["ID_FILA"]);
                        $(".reEnterDiv").show();
                        $("#reEnterData").prop("disabled", false);
                        $("#reEnterData").prop("checked", false);
                        $("#processSwitch").prop("disabled", false);
                        $("#processSwitch").prop("checked", false);
                        $("#lblProcessSwitch").html('Viendo informacion de esquela');
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
                    } else if(res.status == 'errorImagen') {
                      Swal.fire({
                          type: 'warning',
                          title: 'ERROR de archivo',
                          text: 'La imagen es muy pesada o no es el formato adecuado',
                          footer: 'TRANSITO'
                        })

                    }else if(res.status == 'finalizada'){
                      Swal.fire({
                          type: 'warning',
                          title: 'ERROR',
                          text: 'Esquela ya procesada',
                          footer: 'TRANSITO'
                        })
                    }else if(res.status == 'serieInvalido'){
                      Swal.fire({
                          type: 'warning',
                          title: 'ERROR',
                          text: 'Numero de serie no valido',
                          footer: 'TRANSITO'
                        })
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
                        } else if(res.status == 'errorImagen') {
                            Swal.fire({
                            type: 'warning',
                            title: 'ERROR de archivo',
                            text: 'La imagen es muy pesada o no es el formato adecuado',
                            footer: 'TRANSITO'
                        })

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
          modelo:{required: true},
          serie:{required: true, number:true},
          color:{required: true},
          licencia:{required: true},
          nombre:{required: true},
          marca:{required: true},
          clase:{required: true},
          fechaadqui:{required: true},
          descripcion:{maxlength:50},
          hora_falta:{required: true},
          codigo_falta:{required: true},
          lugar_falta:{required: true},
          valor:{ required: true, number: true },
          clasificacion:{required: true},
          id_proveedor:{required: true},
          id_pais:{required: true},
          id_procedencia:{required: true},
          observaciones:{maxlength:250},
          observaciones2:{maxlength:100}
        },
        messages: {
          nombre: "Este campo es requerido",
          color: "Este campo es requerido",
          serie: {number: "Campo numerico", required: "Este campo es requerido"},
          marca: "Seleccione una Marca",
          id_modelo: "Seleccione un Modelo",
          id_calibre: "Seleccione un Calibre",
          clase: "Seleccione una Clase",
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
          
      }

  $('#processSwitch').click(function() {
    if ($(this).is(':checked')) {
        documentoChange()
         
        $("#lblProcessSwitch").html('Modificar Información de la esquela');
        setSaveButtonUpdateRegistry();
        $('#btnSave').show();
        $('#btnCancel').show();
        
        
        habilitarFrom();
        if( $("#placas1").is(':checked') ) {
          $("#placas2").prop('disabled', true)
        }
        if( $("#placas2").is(':checked') ) {
          
          $("#placas1").prop('disabled', true)
        }
    } else {
        $('#btnSave').hide();
        $('#btnCancel').hide();
        $("#lblProcessSwitch").html('Click aqui para modificar');
        dehabilitarForm(); 
    }
  });
  
  $('#reEnterData').click(function() {
    if ($(this).is(':checked')) {
      documentoChange()
      $('#falta').on('select2:select', function (e) {
        var data = e.params.data;
        console.log(data);
        $("#valor").val(data["valor"])
        $("#clasificacion").val(data["clasificacion"])
        if(data["rubro"] == "CARGA"){
          $("#radioPrimary3").prop("checked", true);
        }else if(data["rubro"] == "TRANSPORTE"){
          $("#radioPrimary2").prop("checked", true);
        }else{
          $("#radioPrimary1").prop("checked", true);
        }
    });
      $("#serie").prop("readonly", false)
        $('#placa').val('');
        $('#num_placa').val('');
        $('#placa').val(null).trigger('change');
        $('#clase').val(null).trigger('change');
        $('#serie').val('');
        $('#tipoPlaca').val('');
        $('#clase').val('');
        $('#marca').val('');
        $('#modelo').val('');
        $('#color').val('');
        $('#ruta').val('');
        $('#hora').val('');
        $('#observaciones_falta').val('');
        $('#observaciones_aut').val('');
        $('#licencia').val('');
        $('#hora').val('');
        $('#apellidos').val('');
        $('#nombre').val('');
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
        $("#searchForm").on('submit',addForm)
        function addForm(event)
        {
            event.preventDefault();
            if ($("#searchForm").length > 0) {
            $.ajax({
                data: $('#searchForm').serialize(),
                url: 'Esquelas/buscar',
                type: "POST",
                beforeSend: function (request) {

                  let timerInterval
                      Swal.fire({
                        title: 'Buscando Registro',
                        html: 'Espere...',
                        timer: 20000,
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

                      request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                },
                dataType: 'json',
                success: function (res) {
                    if(res.success){
                        $('#btn-search-modal').html('Buscar Esquela <i class="fas fa-search"></i>');
                        $('#btn-search-modal').prop('disabled', false);
                        $('#modal-search').modal('hide');
                        $('#serie').prop('readOnly',true);
                        Toast.fire({
                          type: 'success',
                          title: 'Registro Encontrado'
                        })
                        clearFormSearch();
                        window.datosAr = res.data
                        setForm(res.data);
                        
                        $("#lblProcessSwitch").html('Click aquí para modificar');
                        $("#divImagen").prop('hidden', false);

                        $("#imgEsquela").attr('src', 'documentos/esquelas/' + res.archivos + '?' + new Date().getTime());
                    } else {
                      Toast.fire({
                        type: 'question',
                        title: 'No hemos podido encontrar su registro'
                      })
                      clearFormSearch();
                      $('#btn-search-modal').html('Buscar Esquela <i class="fas fa-search"></i>');
                      $('#btn-search-modal').prop('disabled', false);
                    }
                },
                error: function (data) {
                  Swal.fire({
                    type: 'error',
                    title: 'Error...',
                    text: 'No se pudo completar su peticion!',
                    footer: 'TRANSITO'
                  })
                  $('#btn-search-modal').html('Buscar Esquela <i class="fas fa-search"></i>');
                  $('#btn-search-modal').prop('disabled', false);
                  console.log('Error:', data);
                }
              });


              $('#movimientos_list').DataTable().destroy();              
              var data = {
                serie : $("#buscarSerie").val()
              };
              movimientos = $("#movimientos_list").DataTable({
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
                    autoWidth: false,
                    autoFill: true,
                    ajax: {
                    "url": "<?php echo base_url();?>Armas/getHistorial",
                    "type": "POST", 
                    "beforeSend": function (request) {
                            request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
                    },
                    "data": data
                    },
                    "columns": [
                      {"data": "FECHA"},
                      {"data": "ONI_ENTREGA"},
                      {"data": "ONI"},
                      {"data": "ESTADO"}
                    ],
                });
              
      }
}
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
        $("#id_fila").val(data["ID_FILA"]);
        $("#serie").val(data['NUM_SERIE']);
        $("#licencia").val(data['NUM_LICENCIA']);
        $("#nombre").val(data['NOMBRES']);
        $("#apellidos").val(data['APELLIDOS']);
        $("#num_placa").val(data['NUM_PLACA']);
        $("#reEnterData").prop("disabled", false);
        if(data['HIT_PLACA'] != 1){
          $("#searchPlaca").click();
        }else{
          $("#marca").val(data['MARCA']);

              $("#modelo").val(data['MODELO']);
              $("#color").val(data['COLOR']);
            
             

              var cClibreSelect = $('#clase');
                var option = new Option(data['CLASE_VEHICULO'], data['CLASE_VEHICULO'], true, true);
                cClibreSelect.append(option).trigger('change');
                cClibreSelect.trigger({
                      type: 'select2:select'
                });

                var placaSelect = $('#placa');
                var option = new Option(data['TIPO_PLACA'], data['TIPO_PLACA'], true, true);
                placaSelect.append(option).trigger('change');
                placaSelect.trigger({
                      type: 'select2:select'
                });
                
        }
        
        
        $("#hora_falta").val(data['HORA_ESQUELA']);
        
        $("#observaciones_aut").val(data['OBSERVACION_AUT']);
        $("#lugar_falta").val(data['DIRECCION']);
        $("#labelEstado").html(data['ESTADO']);
        $("#labelUsuario").html(data['USER_ADD']);
        $("#labelUnidad").html(data['UNIDAD_TRANSITO']);
        $("#oni_asignado").val(data['ONI_IMPONE']);
        $('#fechaadqui').datetimepicker('date', moment(moment(data['FECHA_ESQUELA'], 'D-MMM-YYYY')).format('DD/MM/YYYY'));
        $("#nombreAgente").val(data['NOMBRE']);
        $("#dependencia").val(data['UBICACION']);
        $("#disponibilidad").val(data['ESQUELAS_IMPUESTAS']);
        $("#fechaAsignacion").val(data['FECHA_ASIGNACION']);
        
       
        $("#observaciones_falta").val(data['OBSERVACION']);
        
        $('#falta').on('select2:select', function (e) {
          var data = e.params.data;
          console.log(data);
          $("#clasificacion").val(data['CLASIFICACION']);
          $("#valor").val(data['VALOR']);
          if(data["RUBRO"] == "CARGA") $("#radioPrimary3").prop("checked", true);
          if(data["RUBRO"] == "TRANSPORTE") $("#radioPrimary2").prop("checked", true);
          if(data["RUBRO"] == "TRANSITO") $("#radioPrimary1").prop("checked", true);
        
        });

        if(data['DECOM_1_PLACA']) { 
          $("#placas1").prop("checked", true) 
          
          }
        if(data['DECOM_2_PLACA']) { 
          $("#placas2").prop("checked", true) 
           
          }
        if(data['DECOM_LICENCIA']) $("#licencia_cond").prop("checked", true)
        if(data['DECOM_PERMISO_L']) $("#permiso_linea").prop("checked", true)
        if(data['DECOM_POLIZA']) $("#poliza").prop("checked", true)
        if(data['DECOM_TARJETA']) $("#tarjeta").prop("checked", true)
        if(data['DECOM_VEHICULO']) $("#vehiculo").prop("checked", true)
        
          $("#documento").off("change");

        
          var docu = $('#documento');
          var option = new Option(data['DOCUMENTO'], data['ID_CLASELIC'], true, true);
          docu.append(option).trigger('change');
          docu.trigger({
                type: 'select2:select',
                params: {data: data}
          });
        
        
          var depa = $('#departamento');
          var option = new Option(data['DEPARTAMENTO'], data['ID_DEPARTAMENTO'], true, true);
          depa.append(option).trigger('change');
          depa.trigger({
                type: 'select2:select',
                params: {data: data}
          });
        
        
          var falta = $('#falta');
          var option = new Option(data['FALTA'], data['ID_FALTA'], true, true);
          falta.append(option).trigger('change');
          falta.trigger({
                type: 'select2:select',
                params: {data: data}
          });
        
        
          var plan = $('#plan');
          var option = new Option(data['PLAN'], data['ID_PLAN'], true, true);
          plan.append(option).trigger('change');
          plan.trigger({
                type: 'select2:select',
                params: {data: data}
          });
        
        

        dehabilitarForm();

      }
</script>
<script>
  <?php if($allOptions){ ?>
      $('#btnBorrar').click(function() {
        console.log($(this).val());
        Swal.fire({
          title: 'Esta seguro de ELIMINAR la esquela?',
          text: "Este proceso es irreversible!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, deseo borrarla',
          cancelButtonText: 'Cancelar',
        }).then((result) => {
          if (result.value) {
            swal.showLoading();
            $.ajax({ 
                url: "Esquelas/delete/"+$(this).val(),
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
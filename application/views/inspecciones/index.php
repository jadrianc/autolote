  <style>
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
#map {
  height: 100%;
}

/* Optional: Makes the sample page fill the window. */
html,
body {
  height: 100%;
  margin: 0;
  padding: 0;
}


  </style>

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWlw231bgP1i-WAh-3QJlQBgC62LLlvc8&callback=initMap&libraries=&v=weekly" defer></script>
  
  <!-- Content Wrapper. Contains page content -->
  <div id="app">
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


    <div id="opcionesInspeccion" v-if="!mostrarFormulario">
      <div class="card">
        <div class="card-header">
        <div class="row">
            <div class="col-md-3">
             <button class="btn btn-app bg-info" @click="cambiarMenu('avance')" id="avance"><i class="fas fa-plus d-inline"></i> <b> <h6 class="d-inline">Crear Avance</h6> </b> </button>
            </div>
            <div class="col-md-3">
            <button class="btn btn-app bg-info" @click="cambiarMenu('crear')" id="inspeccion"><i class="fas fa-plus d-inline"></i> <b><h6 class="d-inline"> Crear Inspeccion</h6></b> </button>
            </div>
            <div class="col-md-3">
            <button class="btn btn-app bg-info" @click="cambiarMenu('busqueda')" id="inspeccion"><i class="fas fa-search d-inline"></i> <b><h6 class="d-inline"> Buscar Datos</h6></b> </button>
            </div>
          </div>
        </div>
        <div class="card-body">
         
            <div class="row" id="adelanto" v-if="avance">
             
              <div class="row">
              
                  <div class="col-md-12">
                  <p>Esta opcion le permite crear un avance de novedad</p>
                  
                  </div>
                  <div class="col-md-5">
                  <h5>Crear un nuevo avance de novedad</h5>
                  </div>
                  <div class="col-md-8">
                    <div class="input-group">
                      <label for="">Codigo </label>
                      <div class="input-group-prepend">
                      <span class="input-group-text" >
                          <input type="text" class="" v-model="codeUnidad">
                        </span>
                        <span class="input-group-text">
                          <input type="text" class="" v-model="fechaCodigo"> 
                        </span>
                      </div>
                      <input  type="text" class="form-control" value="0000" readonly>
                    </div>
                    <!-- /input-group -->
                  </div>
                  <div class="col-md-4">
                        <button @click="nuevoAvance" class="btn btn-info">Crear Avance</button>
                  </div>
              </div>
               
            </div>


            <div class="row" id="inspeccionF" v-if="crear">
              <div class="row">
                <div class="col-md-12">
                  <h5>Crear nueva Inspeccion</h5>
                </div>
              </div>
              <div class="row">
              <div class="col-md-12">

                <p>Esta opcion le premite crear una inspeccion nueva partiendo de cero. Utilizela si no ha ingresado un avance de novedad</p>
                </div>
                
              </div>
                
                <div class="row">
                  
                <div class="col-md-8">
                    <div class="input-group">
                      <label for="">Codigo </label>
                      <div class="input-group-prepend">
                      <span class="input-group-text" >
                          <input type="text" class="" v-model="codeUnidad">
                        </span>
                        <span class="input-group-text">
                          <input type="text" class="" v-model="fechaCodigo"> 
                        </span>
                      </div>
                      <input type="text" class="form-control">
                    </div>
                    <!-- /input-group -->
                  </div>
                  <div class="col-md-2">
                    <button class="btn btn-info btn-block">Verificar</button>
                  </div>
                  <div class="col-md-2">
                    <button class="btn btn-info btn-block">Iniciar Inspeccion</button>
                  </div>
                </div>
                
                
            </div>
            

            <div class="row" id="busc" v-show="busqueda">
               <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Buscar por</label>
                            <v-select
                                
                                label="text" 
                                :options="['Fecha', 'Codigo', 'Direccion']" 
                                @input="seleccionTipoBusqueda">
                            </v-select>
                        </div>
                    </div>
                  
                      <div class="col-md-4">
                        <div class="form-group" v-show="tipoBusqueda.fecha">
                            <label for="">Fecha de novedad</label>
                            <div class="input-group date" id="fechainspb" data-target-input="nearest">
                            <div class="input-group-append" data-target="#fechainspb" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                            </div>
                            <input v-model="buscarFecha" type="text" class="form-control datetimepicker-input" placeholder="Fecha de Inspeccion" 
                            name="fechainspb" data-target="#fechainspb" required/>
                         </div>
                        </div>
                        

                            <div class="form-group" v-show="tipoBusqueda.codigo">
                                <label for="">Codigo</label>
                                <input v-model="buscarCodigo" type="number" class="form-control" placeholder="Ultimos 4 digitos">
                            </div>
                        

                            <div class="form-group" v-show="tipoBusqueda.direccion">
                                <label for="">Direccion</label>
                                <input v-model="buscarDireccion" type="text" class="form-control" placeholder="direccion">
                            </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            
                            <button @click="realizarBusquedaAvances" style="margin-top: 31px" class="btn btn-info">Buscar</button>
                          </div>
                        </div>
                    
                     </div>
                     
                      <div class="row" >
                          <div class="col-md-12 col-sm-12">
                              <v-card>
                                <v-card-title>
                                  Avances
                                  <v-spacer></v-spacer>
                                  <v-text-field
                                    v-model="search"
                                    append-icon="mdi-magnify"
                                    label="Buscar"
                                    single-line
                                    hide-details
                                  ></v-text-field>
                                </v-card-title>
                                <v-data-table
                                  :headers="headers"
                                  :items="desserts"
                                  :search="search"
                                  @click:row="handleClick"
                                ></v-data-table>
                              </v-card>
                          </div>
                     </div> 
            </div>
            </div>
                
            
          
          
        </div>
      </div>
    </div>
      
     <div v-show="mostrarFormulario">
     <div id="formularioInspeccion">

     <div class="row">
      <div class="col-md-4">
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input d-block" id="processSwitch" checked disabled>
          <label class="custom-control-label" id="lblProcessSwitch" for="processSwitch">Registrando Nueva Inspeccion</label>
        </div>
    </div>
    <div class="col-md-3">
          <div class="custom-control custom-switch" id="nuevoRegistro">
            <input type="checkbox" class="custom-control-input d-inline" id="reEnterData" disabled>
            <label class="custom-control-label" id="lblreEnterData" for="reEnterData">Crear Nuevo Registro en Base a Informacion Actual</label>
          </div>
      </div>
      <div class="col-md-3">
        <button @click="mostrarFormulario = false" class="btn btn-info"><i class="fas fa-arrow-left"></i> Atras</button>
      </div>
     
      </div>

      
      <div class="row">
        <div class="col-md 6">
        
        </div>
        <div class="col-md-3" >
            <label for="" class="">Codigo</label><input type="number" class="form-control float-sm-right" id="Codigo" name="serie" placeholder="Serie" required>
        </div>
        </div>
     <br>
     
      <div class="row no-print">
                  
                  <div class="col-md-6">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Estado</th>
                          <th>Codigo</th>
                          <th>Avance</th>
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
                        <button v-if="false" type="button" class="btn btn-danger float-right" id="btnBorrar" value="" style="margin-right: 10px;">
                          <i class="fas fa-trash"></i> Borrar
                        </button>
                        <?php } ?>
                  </div>
        </div>
      
      <div id="headerCard" class="card card-navy">
      
         <div class="card-header">
            <h3 class="card-title">Genarales del Accidente <i class="fas fa-pencil-alt"></i></h3>
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
                          <label for="">Unidad</label>
                          <v-select name="unidad" label="text" :options="unidades" @input="seleccion"></v-select>
                        </div>
                      </div>
                        <div class="form-group col-sm-4">
                        <div class="form-group">
                          <label for="">Municipio</label>
                          <select class="form-control select2 select2-info" name="municipioIns" id="municipioIns" 
                            data-dropdown-css-class="select2-info" style="width: 100%;" required> </select>
                        </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Numero de Referencia FGR</label>
                          <input type="text" id="referenciaFgrIns" name="referenciaFgrIns" class="form-control text-uppercase" required >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                    
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Direccion</label>
                          <input type="text" id="direccionIns" name="direccionIns" class="form-control text-uppercase" required >
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                            <label>LAT</label>
                            <div class="input-group mb-3">
                              <!-- /btn-group -->
                              <div class="input-group-prepend">
                                  <button type="button" class="btn btn-info" id="modalMapa" data-toggle="modal" data-target="#modalMap"><i class="fas fa-map-marked-alt"></i></button>
                              </div>
                              <input tabindex="3" placeholder="" type="text" class="form-control text-uppercase" id="lat" name="lat">
                              
                              
                            </div>
                            <p id="msj" style="color: red;"></p>
                        </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="">LON</label>
                          <input type="text" id="lon" name="lon" class="form-control text-uppercase" required >
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for=""> Fecha Accidente</label>
                          <div class="input-group date" id="fechaadqui" data-target-input="nearest">
                            <div class="input-group-append" data-target="#fechaadqui" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                            </div>
                            <input type="text" class="form-control datetimepicker-input" placeholder="Fecha de Adquisición" 
                            name="fechaadqui" data-target="#fechaadqui" required/>
                         </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                    
                    <div class="col-md-3">
                        <div class="form-group">
                          <label for=""> Fecha Inspeccion</label>
                          <div class="input-group date" id="fechainsp" data-target-input="nearest">
                            <div class="input-group-append" data-target="#fechainsp" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                            </div>
                            <input type="text" class="form-control datetimepicker-input" placeholder="Fecha de Inspeccion" 
                            name="fechainsp" data-target="#fechainsp" required/>
                         </div>
                        </div>
                      </div>

                      <div class="col-sm-2">
                            <div class="form-group">
                              <label>Hora Accidente</label>
                              
                              <div class="input-group date" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" name="hora_falta" data-target="#hora_falta" id="hora_falta" placeholder="00:00"/>
                              <div class="input-group-append" data-target="#hora_falta" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-2">
                            <div class="form-group">
                              <label>Hora Aviso</label>
                              
                              <div class="input-group date" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" name="hora_falta" data-target="#hora_aviso" id="hora_aviso" placeholder="00:00"/>
                              <div class="input-group-append" data-target="#hora_aviso" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-2">
                            <div class="form-group">
                              <label>Hora Llegada</label>
                              
                              <div class="input-group date" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" name="hora_llegada" data-target="#hora_falta" id="hora_llegada" placeholder="00:00"/>
                              <div class="input-group-append" data-target="#hora_llegada" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                              <div class="form-group">
                                <label for="">Tipo</label>
                                <v-select label="text" :options="tipoAccidente"></v-select>
                                <input type="hidden" name="tipoAccidente" v-model="tipoAccidente">
                              </div>
                          </div>

                    </div>

                    <div class="row">
                    <div class="col-md-4">
                              <div class="form-group">
                                <label for="">Causa</label>
                                <v-select label="text" :options="causaAccidente"></v-select>
                                <input type="hidden" name="causaAccidente" v-model="causaAccidente">
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                <label for="">Resultado</label>
                                
                                 <v-select name="resultado" label="text" :options="resultado" @input="seleccion"></v-select>
                              </div>
                          </div>
                    </div>

                    <div class="row">
                        <table class="table table-hover">
                            <tr>
                                <th>Vehiculos:</th>
                                <th>Testigos:</th>
                                <th>Lesionados:</th>
                                <th>Fallecidos:</th>
                                <th>Detenidos:</th>
                            </tr>
                        </table>
                    </div>

                    <div class="widget-user-header bg-primary">
                      <hr>                    
                      <h5>&nbsp;&nbsp; Vehiculos Involucrados</h5>
                      <hr>
                    </div>                   
                    
                    <div id="infoCompra">
                            
                            <div class="row">
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-certificado">
                              <i class="fas fa-plus"></i> Agregar Vehiculo
                            </button>
                            </div>
                            <br>
                            <div id="map"></div>
                            <div class="row">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>VID</th>
                                            <th>PLACA</th>
                                            <th>MARCA</th>
                                            <th>COLOR</th>
                                            <th>AÑO</th>
                                            <th>CONDUCTOR</th>
                                            <th>PROPIETARIO</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                    </div>
                    
                    <div class="widget-user-header bg-primary">
                      <hr>                    
                      <h5>&nbsp;&nbsp;Personas Participantes</h5>
                      <hr>
                    </div>
                    <div id="infoProveedor">
                    <div class="row">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-persona">
                              <i class="fas fa-plus"></i> Agregar Persona
                            </button> 
                    </div>  
                    <br>
                    </div>
                      <div class="row">
                          <table class="table table-hover table-bordered">
                              <thead>
                                  <tr>
                                      <th>N°</th>
                                      <th>PID</th>
                                      <th>NOMBRE</th>
                                      <th>RESULTADO</th>
                                      <th>CALIDAD</th>
                                      <th>VEHICULO</th>
                                      <th>ACCIONES</th>
                                  </tr>
                              </thead>
                          </table>
                      </div>      
                    <div class="widget-user-header bg-primary">
                      <hr>                    
                      <h5>&nbsp;&nbsp;Información</h5>
                      <hr>
                    </div>
                      <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="">Causas</label>
                                <input type="text" class="form-control">
                                
                            </div>
                        </div>
                        <div class="col-md-1 mt-4">
                       
                            <button type="button" class="btn btn-danger "><i class="fas fa-times"></i></button>
                        </div>
                        <div class="col-md-1 mt-4">
                      
                            <button @click="abrirModal('Causas')" type="button" class="btn btn-info"  data-toggle="modal" data-target=""><i class="fas fa-comment-dots"></i></button>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="">Descripcion del Lugar</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-1 mt-4">
                       
                            <button type="button" class="btn btn-danger "><i class="fas fa-times"></i></button>
                        </div>
                        <div class="col-md-1 mt-4">
                      
                            <button @click="abrirModal('Descripcion del Lugar')" type="button" class="btn btn-info"><i class="fas fa-comment-dots"></i></button>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="">Apreciacion Policial</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-1 mt-4">
                       
                            <button type="button" class="btn btn-danger "><i class="fas fa-times"></i></button>
                        </div>
                        <div class="col-md-1 mt-4">
                      
                            <button @click="abrirModal('Apreciacion Policial')" type="button" class="btn btn-info "><i class="fas fa-comment-dots"></i></button>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="">Incautaciones</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-1 mt-4">
                       
                            <button type="button" class="btn btn-danger "><i class="fas fa-times"></i></button>
                        </div>
                        <div class="col-md-1 mt-4">
                      
                            <button type="button" class="btn btn-info "><i class="fas fa-comment-dots"></i></button>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">ONI Elabora</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">ONI Acompaña</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">ONI Revisa</label>
                                <input type="text" class="form-control">
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
                
              <!-- /.card-body -->
          </div>
      </div>
      </div>

      <div class="modal fade" id="modalCausas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{tipoModal}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             
                  <div class="row">
                    <div class="col-md-12">
                      <textarea name="causasClob" id="causasClob" cols="70" rows="10" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                    <v-card>
                      <v-card-title>
                        Vehiculos
                        <v-spacer></v-spacer>
                        <v-text-field
                          v-model="search"
                          append-icon="mdi-magnify"
                          label="Buscar"
                          single-line
                          hide-details
                        ></v-text-field>
                      </v-card-title>
                      <v-data-table
                        :headers="headerVeh"
                        :items="autos"
                        :search="search"
                        @click:row="handleClick"
                      ></v-data-table>
                    </v-card>
                    </div>
                    <div class="col-md-6">
                    <v-card>
                      <v-card-title>
                        Frases
                        <v-spacer></v-spacer>
                        <v-text-field
                          v-model="search"
                          append-icon="mdi-magnify"
                          label="Buscar"
                          single-line
                          hide-details
                        ></v-text-field>
                      </v-card-title>
                      <v-data-table
                        :headers="headerFrase"
                        :items="frases"
                        :search="search"
                        @click:row="handleClick"
                      ></v-data-table>
                    </v-card>
                    </div>
                  </div>       
             
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary">Guardar</button>
            </div>
          </div>
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
            
            </div>
        </div>
      <!-- /.modal -->
    
    
    
    </section>

    <!-- /.content -->
  </div>
  <form autocomplete="off" name="searchForm" class="form-horizontal" id="formVehiculo"> 
  <div class="modal fade" id="modal-certificado" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                  <div class="row">
                    <div class="col-md-3">
                    <h5>ID:</h5>
                    </div>
                    <div class="col-md-3">
                    <h5>EID:</h5>
                    </div>
                  </div>
                  <h4 id="msjCert" class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                                     
                    <div class="row">
                        <div class="col-md-2">
                      
                            <label>Numero de Placa</label>
                            <div class="input-group mb-3">
                              <!-- /btn-group -->
                            
                              <input tabindex="3" type="text" class="form-control text-uppercase" placeholder="PXXXXXX / ABXXXXX" id="num_placa" name="num_placa" v-model="placa" required>
                              <input type="hidden" id="cargoAutorizado">
                              <div class="input-group-prepend">
                                  <button type="button" class="btn btn-info" id="" @click="buscarPlaca"><i class="fas fa-search"></i></button>
                              </div>
                            </div>
                            <p id="msj" style="color: red;"></p>
                       
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Marca</label>
                            <input type="text" class="form-control" id="marca" name="marca" :value="data.marca" readonly>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" :value="data.modelo" readonly>
                          </div>
                        </div>
                        <div class="col-md-1">
                          <div class="form-group">
                            <label for="">Año</label>
                            <input type="text" class="form-control" id="año" name="año" :value="data.anio" readonly>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Poliza</label>
                            <input type="text" class="form-control" id="poliza" name="poliza">
                          </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="">Color</label>
                          <input type="text" class="form-control" id="color" name="color" :value="data.color" readonly>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="">Clase</label>
                          <v-select label="text" :value="claseVeh" :options="claseVeh" @input="" disabled></v-select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="">Estado</label>
                          <v-select label="text" :options="estado" @input="" v-model="selects.estadoVehiculo" ></v-select>
                          <input type="hidden" v-model="selects.estadoVehiculo" name="estado" />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Rumbo</label>
                          <v-select name="rumbo" label="text" :options="rumbo" @input="" v-model="selects.estadoRumbo" ></v-select>
                          <input type="hidden" v-model="selects.estadoRumbo" name="rumbo" />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                      <div class="form-group">
                          <label for="">Correo Electronico</label>
                          <input type="email"  class="form-control" id="email" name="email">
                        </div>
                      </div>
                      <div class="col-md-2">
                      <div class="form-group">
                          <label for="">Asegurado</label>
                          <select class="form-control select2 select2-info" name="seguroAuto" id="seguroAuto" 
                                data-dropdown-css-class="select2-info" style="width: 100%;" required>
                                <option value="si">SI</option>
                                <option value="no">NO</option>
                              </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                      <div class="form-group">
                          <label for="">Aseguradora</label>
                          <input type="text" class="form-control" id="aseguradoraAuto" name="aseguradoraAuto">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                            <label for="">Propietario</label>
                            <input type="text" class="form-control" id="propietarioAuto" name="propietarioAuto">
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                            <label for="">Telefono</label>
                            <input type="number" class="form-control" id="telefono" name="telefono">
                          </div>
                      </div>
                      <div class="col-md-5">
                          <div class="form-group">
                            <label for="">Direccion</label>
                            <input type="text" class="form-control" id="direccion" name="direccion">
                          </div>
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                          <div class="form-group">
                            <label for="">Daños en el Vehiculo</label>
                            <input type="text" class="form-control" id="daños" name="daños">
                          </div>
                      </div>
                    </div>
                </div>

                <div class="row">
          <div class="col-12 col-sm-12">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#conductor" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">CONDUCTOR</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#salud" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">SALUD</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#laboral" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">LABORAL</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#transporteColectivo" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">T. COLECTIVO</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#identificacion" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">IDENTIFICACION</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#policial" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">P. POLICIAL</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#citaciones" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">CITACIONES</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#detenciones" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">DETENCION</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">

                <!---- FORMULARIO CONDUCTOR ------>


                  <div class="tab-pane fade show active" id="conductor" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                     <div class="row">
                     <div class="col-md-1">
                          <div class="form-group">
                            <label for="">ID</label>
                            <input type="text" class="form-control" id="idConductor" name="idConductor" readonly>
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                            <label for="">LIC.</label>
                            
                            <v-select label="text" :options="lic" v-model="selects.lic"></v-select>
                            <input type="hidden" v-model="selects.lic" name="lic" />
                          </div>
                      </div>
                      <div class="form-group col-sm-4">
                            <label>Licencia</label>
                            <div class="input-group mb-3">
                              <!-- /btn-group -->
                           
                              <input tabindex="3" v-model="numLic" placeholder="0000-000000-000-0" type="text" class="form-control text-uppercase" id="" name="licencia" :readonly="activar">
                              
                              <div class="input-group-prepend">
                                  <button @click="getLicencia" type="button" class="btn btn-info" id=""><i class="fas fa-search"></i></button>
                              </div>
                            </div>
                            <p id="msj" style="color: red;"></p>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="">Nombre</label>
                            <input type="text" class="form-control" id="nombreConductor" name="nombreConductor" :readonly="readOnlyNombre" v-model="nombreConductor">
                          </div>
                      </div>
                     </div>
                     <div class="row">
                     <div class="col-md-2">
                          <div class="form-group">
                            <label for="">Genero</label>
                            
                            <v-select name="genero" label="text" :options="['M', 'F', 'S/I']" v-model="selects.genero"></v-select>
                            <input type="hidden" v-model="selects.genero" name="genero" />
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                            <label for="">Direccion</label>
                            <input type="text" class="form-control" id="direccionConductor" name="direccionConductor" >
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                            <label for="">Telefono</label>
                            <input type="number" class="form-control" id="telefonoConductor" name="telefonoConductor" >
                          </div>
                      </div>
                      <div class="col-md-1">
                          <div class="form-group">
                            <label for="">Edad</label>
                            <input type="number" class="form-control" id="2" name="edadConductor" >
                  
                            
                          </div>
                          
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                              <label for="">Tipo</label>
                              <v-select label="text" :options="['Años', 'Meses', 'Dias', 'S/I']" @input="seleccion"></v-select>
                          </div>
                      </div>
                     </div>
                     <div class="row">
                     <div class="col-md-3">
                          <div class="form-group">
                            <label for="">DUI</label>
                            <input type="number" class="form-control" id="dui" name="dui" >
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="">NIT</label>
                            <input type="number" class="form-control" id="nit" name="nit" >
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Pasaporte</label>
                            <input type="number" class="form-control" id="pasaporte" name="pasaporte" >
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Otro documento de identidad</label>
                            <input type="number" class="form-control" id="otroDoc" name="otroDoc" >
                          </div>
                      </div>
                     </div>
                     <div class="row">
                     <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Correo Electronico</label>
                            <input type="number" class="form-control" id="correoConductor" name="correoConductor" >
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                          <div class="icheck-primary d-inline">
                            <input type="checkbox" id="checkboxPrimary1" name="cinturon">
                            <label for="checkboxPrimary1">Portaba Casco/Cinturon</label>
                          </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Version</label>
                            <textarea class="form-control" name="version" id="" cols="30" rows="4"></textarea>
                          </div>
                      </div>
                     </div>
                  </div>



                <!---- FORMULARIO SALUD ------>


                  <div class="tab-pane fade" id="salud" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                      <div class="row">
                      <div class="col-md-2">
                          <div class="form-group">
                            <label for="">Resultado</label>
                            
                            <v-select name="resultado" label="text" :options="['Ileso', 'Lesionado', 'Fallecido']" v-model="selects.resultado" @input=""></v-select>
                            <input type="hidden" name="resultado" v-model="selects.resultado">
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                            <label for="">Estado del Conductor</label>
                            
                            <v-select
                                label="text" 
                                :options="['En estado de ebriedad', 'Droga conocida', 'Sintomas de haber ingerido licor', 'Comportamiento normal', 'Con histeria', 'Sin informacion']" 
                                v-model="selects.estadoConductor">
                            </v-select>
                            <input type="hidden" name="estadoConductor" v-model="selects.estadoConductor">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Salud</label>
                            
                            <v-select
                                label="text" 
                                :options="[
                                    'Buena Salud', 
                                    'Problemas Auditivos', 
                                    'Uso de lentes medicados', 
                                    'Deficiencias Fisicas', 
                                    'Fatigado', 
                                    'Sin informacion'
                                    ]" 
                                 v-model="selects.saludConductor">
                            </v-select>
                            <input type="hidden" name="saludConductor" v-model="selects.saludConductor">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Tipo de Lesiones</label>
                            
                            <v-select 
                                label="text" 
                                :options="[
                                    'Leve', 
                                    'Grave', 
                                    'Muy Grave', 
                                    'Ileso',
                                    ]" 
                                 v-model="selects.tipoLesiones">
                            </v-select>
                            <input type="hidden" name="tipoLesiones" v-model="selects.tipoLesiones">
                          </div>
                      </div>
                      </div>
                      <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                            <label for="">Detalles</label>
                            
                            <input type="text" class="form-control" name="detalles" id="detalles">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Centro Asistencial</label>
                            
                            <select class="form-control select2 select2-info" name="centroAsistencial" id="centroAsistencial" 
                                data-dropdown-css-class="select2-info" style="width: 100%;" required> </select>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                            <label for="">Observacion</label>
                            
                            <input type="text" class="form-control" name="observacionSalud" id="observacionSalud">
                          </div>
                      </div>
                      </div>
                      <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                            <label for="">Trasladado por</label>
                            
                            <input type="text" class="form-control" name="trasladoPor" id="traslado">
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                            <label for="">Medio Traslado</label>
                            
                            <v-select 
                                label="text" 
                                :options="[
                                    'Ambulancia', 
                                    'Vehiculo Participante', 
                                    'Vehiculo no Participante', 
                                    'Equipo Policial',
                                    'Sin Informacion'
                                    ]" 
                                  v-model="selects.medioTraslado">
                            </v-select>
                            <input type="hidden" name="medioTraslado" v-model="selects.medioTraslado">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="">N° Equipos</label>
                            
                            <input type="number" class="form-control" name="numeroEquipo" id="numeroEquipo">
                          </div>
                      </div>
                      </div>
                      <div class="row">
                      <div class="col-md-7">
                          <div class="form-group">
                            <label for="">Causa de Nuerte</label>
                            
                            <input type="text" class="form-control" name="causaMuerte" id="causaMuerte">
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                            <label for="">Dias de Incapacidad</label>
                            
                            <input type="number" class="form-control" name="incapacidad" id="incapacidad">
                          </div>
                      </div>
                      </div>
                      <div class="row">
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Fiscal</label>
                            
                            <input type="text" class="form-control" name="fiscal" id="fiscal">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Forense</label>
                            
                            <input type="text" class="form-control" name="forense" id="forense">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Comentario</label>
                            
                            <input type="text" class="form-control" name="comentarioSalud" id="comentarioSalud">
                          </div>
                      </div>
                      </div>
                  </div>



                  <!---- FORMULARIO LABORAL ------>


                  <div class="tab-pane fade" id="laboral" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                     <div class="row">
                     <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Trabaja</label>
                            
                            <v-select 
                                name="trabaja" 
                                label="text" 
                                :options="[
                                    'SI', 
                                    'NO'
                                    ]" 
                                 v-model="selects.trabaja">
                            </v-select>
                            <input type="hidden" v-model="selects.trabaja" name="trabaja">
                          </div>
                      </div>
                      <div class="col-md-7">
                          <div class="form-group">
                            <label for="">Empresa</label>
                            
                            <input type="text" class="form-control" name="empresa" id="empresa">
                          </div>
                      </div>
                     </div>
                     <div class="row">
                     <div class="col-md-9">
                          <div class="form-group">
                            <label for="">Direccion</label>
                            
                            <input type="text" class="form-control" name="direccionEmpresa" id="direccionEmpresa">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Telefono</label>
                            
                            <input type="text" class="form-control" name="telefono" id="telefonoEmpresa">
                          </div>
                      </div>
                     </div>
                  </div>



                  <!---- FORMULARIO TRANSPORTE COLECTIVO ------>


                  <div class="tab-pane fade" id="transporteColectivo" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                     <div class="row">
                     <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Ruta</label>
                            
                            <input type="text" class="form-control" name="ruta" id="ruta">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Codigo de Ruta</label>
                            
                            <input type="text" class="form-control" name="codigoRuta" id="codigoRuta">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="">N° Permiso VMT</label>
                            
                            <input type="text" class="form-control" name="permisoVMT" id="permisoVMT">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="">N° Permiso Linea</label>
                            
                            <input type="text" class="form-control" name="permisoLinea" id="permisoLinea">
                          </div>
                      </div>
                     </div>
                  </div>


                  <!---- FORMULARIO IDENTIFICACION ------>


                  <div class="tab-pane fade" id="identificacion" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                     <div class="row">
                       
                     </div>
                  </div>

                  <!---- FORMULARIO P. POLICIAL ------>


                  <div class="tab-pane fade" id="policial" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                     <div class="row">
                        <div class="col-md-2">
                          <div class="form-group">
                              <label for="">N° Equipo</label>
                              <input type="number" class="form-control" name="nEquipo" id="nEquipo">
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                              <label for="">Unidad</label>
                              <input type="text" class="form-control" name="unidadPolicial" id="unidadPolicial">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                              <label for="">Categoria</label>
                              <v-select
                                label="text" 
                                :options="[
                                    'Agente', 
                                    'Cabo',
                                    'Sargento',
                                    'Subinspector',
                                    'Inspector',
                                    'Inspector Jefe',
                                    'Sub Comisionado',
                                    'Comisionado',
                                    'Comisionada',
                                    'Subinspectora',
                                    ]" 
                                  v-model="selects.categoria">
                            </v-select>
                            <input type="hidden" v-model="selects.categoria" name="categoria">
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                              <label for="">ONI</label>
                              <input type="text" class="form-control" name="oniPolicial" id="oniPolicial">
                          </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Numero de Permiso</label>
                                <input type="number" class="form-control" name="numPermiso" id="numPermiso">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tipo de permiso</label>
                                <v-select
                                    label="text" 
                                    :options="[
                                        'S/I',
                                        'S/P',
                                        'VEH',
                                        'MOT'
                                        ]" 
                                      v-model="selects.tipoPermiso">
                                </v-select>
                                <input type="hidden" v-model="selects.tipoPermiso" name="tipoPermiso">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Unidad</label>
                                <input type="text" class="form-control" name="unidadPermiso" id="unidadPermiso">
                            </div>
                        </div>
                      </div>

                  </div>


                  <!---- FORMULARIO CITACIONES ------>

                  <div class="tab-pane fade" id="citaciones" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                    <div class="row">

                    </div>
                  </div>


                  <!---- FORMULARIO DETENCIONES ------>
                  <div class="tab-pane fade" id="detenciones" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                     <div class="row">
                       <div class="col-md-3">
                         <div class="form-group">
                              <div class="icheck-primary d-inline">
                              <input type="checkbox" id="detenido" name="detenido">
                              <label for="detenido">Detenido</label>
                            </div>
                         </div>
                       </div>
                       <div class="col-md-9">
                            <div class="form-group">
                                <label for="">Delito</label>
                                <v-select 
                                  label="text" 
                                  :options="[
                                      'Conduccion temeraria de vehiculo de motor', 
                                      'Lesiones',
                                      'Amenazas',
                                      'Lesiones culposas',
                                      'Homicidio culposo',
                                      'N/A',
                                      'Resistencia',
                                      'Uso de documentos falsos'
                                      ]" 
                                  v-model="selects.delito">
                               </v-select>
                               <input type="hidden" v-model="selects.delito" name="delito">
                            </div>
                        </div>
                     </div>
                     <div class="row">
                       <label for="">Se Encontraba Bajo Los Efectos de:</label>
                       <div class="form-group clearfix">
                      <div class="icheck-primary d-inline m-4">
                        <input type="radio" id="radioPrimary1" name="na" >
                        <label for="radioPrimary1">
                          N/A
                        </label>
                      </div>
                      <div class="icheck-primary d-inline m-4">
                        <input type="radio" id="radioPrimary2" name="alcohol">
                        <label for="radioPrimary2">
                          Alcohol
                        </label>
                      </div>
                      <div class="icheck-primary d-inline m-4">
                        <input type="radio" id="radioPrimary3" name="droga" >
                        <label for="radioPrimary3">
                          Droga
                        </label>
                      </div>
                      <div class="icheck-primary d-inline m-4">
                        <input type="radio" id="medicamentos" name="medicamentos" >
                        <label for="medicamentos">
                          Medicamentos
                        </label>
                      </div>
                      <div class="icheck-primary d-inline m-4">
                        <input type="radio" id="otra" name="otra" >
                        <label for="otra">
                          Otra
                        </label>
                      </div>
                    </div>
                     </div>
                     <div class="row">
                       <div class="col-md-2">
                         <div class="form-group">
                           <label for="">Porcentaje de Alcohol</label>
                           <input type="number" class="form-control" name="procentajeAlcohol" id="procentajeAlcohol">
                         </div>
                       </div>
                       <br>
                       <div class="col-md-2 ">
                         <div class="form-group">
                              <div class="icheck-primary d-block ">
                              <input type="checkbox" id="acta" name="acta">
                              <label for="acta">Acta de Negativa</label>
                            </div>
                         </div>
                       </div>
                       <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Medicamento Prescrito</label>
                                <v-select
                                label="text" 
                                :options="[
                                    'NO',
                                    'SI'
                                    ]" 
                                 v-model="selects.medicamentoPrescrito">
                            </v-select>
                            <input type="hidden" name="medicamentoPrescrito" v-model="selects.medicamentoPrescrito">
                            </div>
                        </div>
                        <div class="col-md-2 ">
                         <div class="form-group">
                              <label for="">Esquela Impuesta</label>
                              <input type="text" class="form-control" name="esquelaImpuesta" id="esquelaImpuesta">
                            </div>
                         </div>
                         <div class="col-md-2 ">
                         <div class="form-group">
                              <div class="icheck-primary d-block ">
                              <input type="checkbox" id="veh" name="vehDecomisado">
                              <label for="veh">Veh. Decomisado</label>
                            </div>
                         </div>
                       </div>
                       <div class="col-md-2 ">
                         <div class="form-group">
                              <div class="icheck-primary d-block ">
                              <input type="checkbox" id="pla" name="placaDecomisada">
                              <label for="pla">Pla. Decomisada</label>
                            </div>
                         </div>
                       </div>
                       </div>
                       <div class="row">
                       <div class="col-md-2 ">
                         <div class="form-group">
                              <div class="icheck-primary d-block ">
                              <input type="checkbox" id="vehIncautado" name="vehIncautado">
                              <label for="vehIncautado">Vehiculo Incautado</label>
                            </div>
                         </div>
                       </div>
                       <div class="col-md-5">
                         <div class="form-group">
                           <label for="">Parqueo</label>
                           <input type="text" class="form-control" name="parqueo" id="parqueo">
                         </div>
                       </div>
                       <div class="col-md-5">
                         <div class="form-group">
                           <label for="">Grua que Remitio</label>
                           <input type="text" class="form-control" name="grua" id="grua">
                         </div>
                       </div>
                       </div>
                     </div>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-info" id="btnCertificado" @click="enviarVehiculo">Aceptar <i class="fas fa-check"></i></button>
        </div>
        </div>
                      
                
              
            </div>
        </div>
      <!-- /.modal -->
      </form>
     

     
    
    </section>

    <!-- /.content -->
  </div>



  <div class="modal fade" id="modal-persona" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                  <div class="row">
                    <div class="col-md-3">
                    <h5>ID:</h5>
                    </div>
                    <div class="col-md-3">
                    <h5>EID:</h5>
                    </div>
                  </div>
                  <h4 id="msjCert" class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                                   
                    <div class="row">
                      
                    <div class="col-md-2">
                          <div class="form-group">
                          <div class="icheck-primary d-inline">
                            <input type="checkbox" id="responsable">
                            <label for="responsable">Es Responsable del Accidente</label>
                          </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="">Participacion</label>
                          <select class="form-control select2 select2-info" name="participacion" id="participacion" 
                                data-dropdown-css-class="select2-info" style="width: 100%;" required> </select>
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <label for="">Nombre</label>
                          <input type="text" class="form-control" id="nombreAcompañante" name="nombreAcompañante">
                        </div>
                        
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="">Edad</label>
                          <input type="number" class="form-control" id="edadAcompañante" name="edadAcompañante">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                          <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Genero</label>
                            <select class="form-control select2 select2-info" name="participacion" id="participacion" 
                                  data-dropdown-css-class="select2-info" style="width: 100%;" required> 
                                  <option value="m">Masculino</option>
                                  <option value="f">Femenino</option>
                                </select>
                              </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Direccion</label>
                              <input type="text" class="form-control" id="direccionAcompañante" name="direccionAcompañante">
                            </div>
                          </div>
                          <div class="col-md-2">
                        <div class="form-group">
                          <label for="">Telefono</label>
                          <input type="text" class="form-control" id="telefonoAcompañante" name="telefonoAcompañante">
                        </div>
                        
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                      <div class="form-group">
                          <label for="">DUI</label>
                          <input type="text" class="form-control" id="duiAcompañante" name="duiAcompañante">
                        </div>
                      </div>
                      <div class="col-md-2">
                      <div class="form-group">
                          <label for="">NIT</label>
                          <input type="text" class="form-control" id="nitAcompañante" name="nitAcompañante">
                        </div>
                      </div>
                      <div class="col-md-2">
                      <div class="form-group">
                          <label for="">Pasaporte</label>
                          <input type="text" class="form-control" id="pasaporteAcompañante" name="pasaporteAcompañante">
                        </div>
                      </div>
                      <div class="col-md-4">
                      <div class="form-group">
                          <label for="">Otro Documento de Identificacion</label>
                          <input type="text" class="form-control" id="otroDocAcompañante" name="otroDocAcompañante">
                        </div>
                      </div>
                      
                    </div>
              
                    <div class="row">
                    <div class="col-md-12">
                          <div class="form-group">
                            <label for="">Manifiesta</label>
                            <input type="text" class="form-control" id="manifiesta" name="manifiesta">
                          </div>
                      </div>
                    </div>
                </div>

                <div class="row">
          <div class="col-12 col-sm-12">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#vehiculo" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">VEHICULO</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#saludA" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">SALUD</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#laboralA" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">LABORAL</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#transporteColectivoA" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">T. COLECTIVO</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#identificacionA" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">IDENTIFICACION</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#policialA" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">P. POLICIAL</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#citacionesA" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">CITACIONES</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#detencionesA" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">DETENCION</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">

                <!---- FORMULARIO CONDUCTOR ------>


                  <div class="tab-pane fade show active" id="vehiculo" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                     <div class="row">
                     <div class="col-md-3">
                          <div class="form-group">
                            <label for="">Clase Licencia</label>
                            <select class="form-control select2 select2-info" name="claseLicencia" id="claseLicencia" 
                                  data-dropdown-css-class="select2-info" style="width: 100%;" required> 
                                  
                                </select>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                <label for="">Numero</label>
                                <input type="text" class="form-control" id="numero" name="numero">
                              </div>
                          </div>
                          <div class="col-md-3">
                                <div class="form-group">
                                  <label for="">Vehiculo</label>
                                  <select class="form-control select2 select2-info" name="vehiculoInv" id="vehiculoInv" 
                                        data-dropdown-css-class="select2-info" style="width: 100%;" required> 
                                  
                                </select>
                              </div>
                              
                          </div>
                          <div class="col-md-2">
                                  <div class="form-group">
                                  <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="cinturon">
                                    <label for="cinturon">Portaba Cinturon</label>
                                  </div>
                                  </div>
                              </div>
                     </div>
                  </div>



                <!---- FORMULARIO SALUD ------>


                  <div class="tab-pane fade" id="saludA" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                      
                  </div>



                  <!---- FORMULARIO LABORAL ------>


                  <div class="tab-pane fade" id="laboralA" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                     
                  </div>



                  <!---- FORMULARIO TRANSPORTE COLECTIVO ------>


                  <div class="tab-pane fade" id="transporteColectivoA" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                     
                  </div>


                  <!---- FORMULARIO IDENTIFICACION ------>


                  <div class="tab-pane fade" id="identificacionA" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                     <div class="row">
                       
                     </div>
                  </div>

                  <!---- FORMULARIO P. POLICIAL ------>


                  <div class="tab-pane fade" id="policialA" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                     

                  </div>


                  <!---- FORMULARIO CITACIONES ------>

                  <div class="tab-pane fade" id="citacionesA" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                    <div class="row">

                    </div>
                  </div>


                  <!---- FORMULARIO DETENCIONES ------>
                  <div class="tab-pane fade" id="detencionesA" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                     
                     </div>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <div class="modal-footer">
                  <button type="button" class="btn btn-info" id="btnCertificado">Aceptar <i class="fas fa-check"></i></button>
                </div>
        </div>
                      
                
              
            </div>
        </div>


     </div>

    
   
    
    </section>

    <!-- /.content -->
 
   <div class="modal fade" id="modalMap">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ubicacion Geografica</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="latitude">
                      Latitude:
                  </label>
                  <input id="txtLat" :value="lat"  type="text" class="form-control"/>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="longitude">
                      Longitude:
                  </label>
                  <input id="txtLng" :value="lon" type="text" class="form-control"/><br />
                  
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                <div id="map_canvas" style="width: auto; height: 500px;">
                </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" id="aceptarCoordenadas" class="btn btn-primary">Aceptar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
  </div>
  </div>
  <!-- /.content-wrapper -->
  
  <script>
 
    Vue.component('v-select', VueSelect.VueSelect);
    
    const vue = new Vue({
      el: "#app",
      vuetify: new Vuetify(),
      data() {

        return {
          buscarFecha: "",
          buscarCodigo: "",
          buscarDireccion: "",
          tipoBusqueda: {fecha: true, direccion: false, codigo: false},
          oniUser: <?php echo '"'.$oni.'"'; ?>,
          causaAccidente: ["VELOCIDAD EXCESIVA", "CONDUCIR EN ESTADO DE EBRIEDAD", "INEXPERIENCIA", "DISTRACCION DEL CONDUCTOR", "FALLA MECANICA", "VELOCIDAD INADECUADA", "ENFERMEDAD", "NO GUARDAD DISTANCIA DE SEGURIDAD"],
          tipoAccidente: ["ATROPELLO", "COLISION", "VUELCO", "CARACTERISTICAS ESPECIALES", "CHOQUE"],
          mostrarFormulario: false,
          estadoRumbo: "",
          selects: {estadoVehiculo: "", estadoRumbo: "", lic: "", genero: "", resultado: "", estadoConductor: "", saludConductor: "", medioTraslado: "", tipoLesiones: "", trabaja: "", categoria: "", tipoPermiso: "", delito: "", medicamentoPrescrito: ""},
          mascaraLicencia: "licencia",
          nombreConductor: "",
          activar: false,
          readOnlyNombre: true,
          numLic: "",
          lic: ["N/A", "PAR", "LIV", "PES", "P-T", "MOT", "EXT", "J-V", "J-M", "C/A"],
          estado: ["Pinchazo o Revento", "Neumatico en mal estado", "Sistema de luces deficiente", "Sobrecarga", "Frenos Defectuosos", "Direccion Defectuosa", "Buen Estado", "Sin Informacion"],
          rumbo: ["Circulaba de Norte a Sur", "Circulaba de Oriente a Poniente", "Circulaba de Poniente a Oriente", "Circulaba de Sur a Norte", "Se encontraba estacionado", "Sin Informacion"],
          claseVeh: [],
          data: {},
          placa: "",
          tipoModal: "",
          codeUnidad: <?php echo '"'.$codeUnidad.'"'; ?>,
          unidades: [],
          resultado: ["MATERIALES", "PERSONALES"],
          token: <?php echo '"'.$token.'"'; ?>,
          unidad: "",
          idUnidad: "",
          crear: false,
          avance: true,
          busqueda: false,
          fechaCodigo: new Date().getDate() + ('0' + (new Date().getMonth() + 1)).slice(-2) + new Date().getFullYear(),
          search: '',
          headerVeh: [
          
          { text: 'N°', value: 'num' },
          { text: 'Valor', value: 'valor' },
         
        ],
        autos: [
          {
            num: 1,
            valor: "M3453"
          },
          {
            num: 1,
            valor: "p124213"
          },
          {
            num: 1,
            valor: "p155413"
          },
        ],

        headerFrase: [
          
          { text: 'Frase', value: 'frase' },
         
         
        ],
        frases: [
          {
            frase: "El conductor del vehiculo"
          },
          {
            frase: "La conductora del vehiculo"
          },
          {
            frase: "en momentos que circulaba en los rumbos de"
          },
        ],
        headers: [
          
          { text: 'Hora', value: 'hora' },
          { text: 'Codigo', value: 'codigo' },
          { text: 'Resultado', value: 'resultado' },
          { text: 'Elabora', value: 'elabora' },
          { text: 'Direccion', value: 'direccion' },
        ],
        desserts: [
          {
           
            hora: "09:12",
            codigo: "0101-07072020-2345",
            resultado: "PERSONALES",
            elabora: "21501",
            direccion: 'BOULEVAR DEL EJERCITO NACIONAL A LA ALTURA DE LA 50 AVENIDA NORTE, SAN SALVADOR',
          },
          {
           
           hora: "09:12",
           codigo: "0101-07072020-0000",
           resultado: "PERSONALES",
           elabora: "21501",
           direccion: 'BOULEVAR DEL EJERCITO NACIONAL A LA ALTURA DE LA 50 AVENIDA NORTE, SAN SALVADOR',
         },
          
          
        ]

        }
      },

      computed:{
        
      },

     

      mounted(){
        const myHeaders = new Headers();
         
          myHeaders.append('Content-Type', 'application/json');
          myHeaders.append('Authorization', this.token);
         
         return fetch('unidadesTransito/getSelect2', {
          method: 'GET',
          headers: myHeaders,
        })
        .then(res => res.json())
        .then(data => {
          this.unidades = data
        })
        .catch(err => {
          Swal.fire({
            type: 'error',
            title: 'Error...',
            text: 'No se pudo completar su peticion!',
            footer: 'TRANSITO'
          })
        });
      
        let fecha = new Date();
        
        this.fechaCodigo = `${fecha.getDate()}${('0' + (fecha.getMonth() + 1)).slice(-2)}${fecha.getFullYear()}`
    
      },

      
      methods:{

        realizarBusquedaAvances(){
            let data = new FormData()
            data.append("direccion", this.buscarDireccion);
            data.append("fecha", this.buscarFecha);
            data.append("codigo", this.buscarCodigo);

            const myHeaders = new Headers();
            myHeaders.append('Authorization', this.token);

            fetch('Inspecciones/buscarAvances',{
              method: "POST",
              headers: Myheaders
            })
        }, 
          
        

        seleccionTipoBusqueda(value){
          console.log(value)
          if(value === "Direccion"){
           
            this.tipoBusqueda.direccion = true
            this.tipoBusqueda.codigo = false
            this.tipoBusqueda.fecha = false
          }
          if(value === "Codigo"){
            
            this.tipoBusqueda.codigo = true
            this.tipoBusqueda.fecha = false
            this.tipoBusqueda.direccion = false
          }
          if(value === "Fecha"){
           
            this.tipoBusqueda.fecha = true
            this.tipoBusqueda.codigo = false
            this.tipoBusqueda.direccion = false
          }
          
        },

        handleClick(value) {
            console.log(value)
        },
        selectLic(value){
          if(value == 'C/A'){
            this.activar = true
            this.nombreConductor = "CONDUCTOR AUSENTE"
          }else{
            this.activar = false
            this.nombreConductor = ""
          }

          if(value == 'EXT'){
            this.readOnlyNombre = false
            
          }else{
            this.readOnlyNombre = true
            
          }
        },
        seleccion(value){
          //this.idUnidad = value.id
          console.log(value)
        },

        cambiarMenu(option){
          if(option == "crear"){
            this.crear = true
            this.avance = false
            this.busqueda = false
            let fecha = new Date();
            
            this.fechaCodigo = `${fecha.getDate()}${('0' + (fecha.getMonth() + 1)).slice(-2)}${fecha.getFullYear()}`
          }

          if(option == "avance"){
            this.crear = false
            this.avance = true
            this.busqueda = false
            this.fechaCodigo = `${fecha.getDate()}${('0' + (fecha.getMonth() + 1)).slice(-2)}${fecha.getFullYear()}`
          }

          if(option == "busqueda"){
            this.crear = false
            this.avance = false
            this.busqueda = true
            
          }
        },

        abrirModal(tipo){
          $("#modalCausas").modal()
          this.tipoModal = tipo
        },

        buscarPlaca(){

          var placa = new FormData();

          placa.append("placa", this.placa);
          const myHeaders = new Headers();
         
          myHeaders.append('Authorization', this.token);
          
          const data = new FormData(document.getElementById('searchForm'));
          console.log(data)
          fetch('Esquelas/getByPlaca', {
          method: 'POST',
          headers: myHeaders,
          body: placa
        })
        .then(res => res.json())
        .then(data => {

          this.data = {
            color: data.data[0].color,
            marca: data.data[0].marca,
            modelo :data.data[0].modelo,
            anio: data.data[0].año,
            estado: data.data[0].estado,
            
          }

          this.claseVeh.push(data.data[0].clase)
         //console.log(data.data[0].color)
         //console.log(this.placa)
        })
        .catch(err => {
          Swal.fire({
            type: 'error',
            title: 'Error...',
            text: 'No se pudo completar su peticion!',
            footer: 'TRANSITO'
          })
        })

        },

        getLicencia(){
          var lic = new FormData();

          lic.append("licencia", this.numLic);

          const myHeaders = new Headers();
          myHeaders.append('Authorization', this.token);

          fetch('Licencias/getByLicencia',{
             method: 'POST',
             headers: myHeaders,
             body: lic
          })
          .then(res => res.json())
          .then(data => {
            this.nombreConductor = data.data[0].nombre + data.data[0].apellidos
          })
          .catch(err => {
          Swal.fire({
            type: 'error',
            title: 'Error...',
            text: 'No se pudo completar su peticion!',
            footer: 'TRANSITO'
          })
        })

        },

        enviarVehiculo(){
      
          const data = new FormData(document.getElementById('formVehiculo'));
          //data.append("lic", this.selects.lic)
          const myHeaders = new Headers();
          myHeaders.append('Authorization', this.token);
         
          fetch('Inspecciones/storeVehiculo',{
             method: 'POST',
             headers: myHeaders,
             body: data
          })
          .then(res => console.log(res))
          

        },

        nuevoAvance(){
          this.mostrarFormulario = !this.mostrarFormulario
          var data = new FormData();
          data.append("unidad", this.codeUnidad);
          data.append("fechaCodigo", this.fechaCodigo);
          data.append("correlativo", "0000");

          data.append("oniUser", this.oniUser);
          $.ajax({
               data: data,
               url: 'Inspecciones/storeAvance',
               type: "POST",
               dataType: 'json',
               contentType: false,
               processData: false,
               beforeSend: function (request) {
                request.setRequestHeader("Authorization",  <?php echo '"'.$token.'"'; ?>);
               },
               success: function (res) {

               }
          })

          /*
          this.mostrarFormulario = !this.mostrarFormulario
          var data = new FormData();
          data.append("unidad", this.codeUnidad);
          data.append("fechaCodigo", this.fechaCodigo);
          data.append("correlativo", "0000");

          data.append("oniUser", this.oniUser);
          const myHeaders = new Headers();
          myHeaders.append('Authorization', this.token);

          fetch('Inspecciones/storeAvance',{
             method: 'POST',
             headers: myHeaders,
             body: data
          })
          .then(res => console.log(res))
          */
        },

        buscarAvance(){
          const myHeaders = new Headers();
          myHeaders.append('Authorization', this.token);

          fetch('Inspecciones/buscarAvances',{
             method: 'POST',
             headers: myHeaders,
             body: data
          })
          .then(res => console.log(res))
        }


      }
      
    })
  </script>
 <script>
    $(document).ready(function() {

    


      document.getElementById("modalMapa").addEventListener("click", function(){
        cargarMapa()
      })

      document.getElementById("aceptarCoordenadas").addEventListener("click", function(){
        $('#modalMap').modal('hide');
        $("#lat").val($("#txtLat").val())
        $("#lon").val($("#txtLng").val())  
      })

      function cargarMapa(){
 
        var map = new google.maps.Map(document.getElementById('map_canvas'), {
            zoom: 10,
            center: new google.maps.LatLng(13.656337, -88.822539),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        // creates a draggable marker to the given coords
        var vMarker = new google.maps.Marker({
            position: new google.maps.LatLng(13.656337, -88.822539),
            draggable: true
        });

        // adds a listener to the marker
        // gets the coords when drag event ends
        // then updates the input with the new coords
        
        google.maps.event.addListener(vMarker, 'dragend', function (evt) {
          
            $("#txtLat").val(evt.latLng.lat().toFixed(6));
            $("#txtLng").val(evt.latLng.lng().toFixed(6));

            map.panTo(evt.latLng);
        });

        // centers the map on markers coords
        map.setCenter(vMarker.position);

        // adds the marker on the map
        vMarker.setMap(map);
}
      
      
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

    $('#hora_aviso').datetimepicker({
      format: 'LT'
    })

    $('#hora_llegada').datetimepicker({
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

      $('#fechainsp').datetimepicker({
        format: 'L',
        locale: 'es',
        maxDate: $.now(),
        defaultDate: moment($.now()).toDate()
      });

      $('#fechainspb').datetimepicker({
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
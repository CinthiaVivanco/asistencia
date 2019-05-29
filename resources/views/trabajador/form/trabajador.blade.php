<div class="containertab">
 <div class="row">
  <div class="process">
   <div class="process-row nav nav-tabs">

    <div class="process-step tabmenu1">
     <button type="button" class="btn btn-info btn-circle" data-toggle="tab" href="#menu1"><i class="fa fa-file-text fa-2x"></i></button>
     <p><small>Datos <br />Personales</small></p>
     <div class='errortab'>
       <i class="fa fa-exclamation" aria-hidden="true"></i> 
     </div>
     <div class='bientab'>
       <i class="fa fa-check" aria-hidden="true"></i> 
     </div>
    </div>

    <div class="process-step tabmenu2">
     <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu2"><i class="fa fa-briefcase fa-2x"></i></button>
     <p><small>Datos<br />Laborales</small></p>
     <div class='errortab'>
       <i class="fa fa-exclamation" aria-hidden="true"></i>
     </div>
     <div class='bientab'>
       <i class="fa fa-check" aria-hidden="true"></i> 
     </div>
    </div>

    <div class="process-step tabmenu3">
     <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu3"><i class="fa fa-check fa-2x"></i></button>
     <p><small>Guardar<br />Ficha</small></p>
     <div class='errortab'>
       <i class="fa fa-exclamation" aria-hidden="true"></i>
     </div>
    </div>


   </div>
  </div>
  <div class="tab-content">

    <div id="menu1" class="tab-pane fade active in">
         <h3></h3>

        <div class="row">
          <div class="col-sm-6">        
                <div class="panel-body">
                  <div class="form-group ">

                    <label class="col-sm-12 control-label labelleft" >Tipo Documento  <span class="required">*</span> </label>
                    <div class="col-sm-7 abajocaja" >
                      {!! Form::select( 'tipodocumento_id', $combotipodocumento, array(),
                                        [
                                          'class'       => 'form-control control input-sm dnipais dnivalidar' ,
                                          'id'          => 'tipodocumentos_id',
                                          'required'    => '',
                                          'data-aw'     => '1',
                                        ]) !!}
                    </div>
                  </div>



                    <div class="form-group">
                      <label class="col-sm-12 control-label labelleft">DNI <span class="required">*</span></label>
                      <div class="col-sm-7 abajocaja">

                        <input  type="text"
                                id="dni" name='dni' value="@if(isset($trabajador)){{old('dni' ,$trabajador->dni)}}@else{{old('dni')}}@endif" placeholder="DNI"
                                required = "" class="form-control input-sm validarnumero dnivalida" data-parsley-type="number"
                                autocomplete="off" data-aw="2"/>

                          @include('error.erroresvalidate', [ 'id' => $errors->has('dni')  , 
                                                              'error' => $errors->first('dni', ':message') , 
                                                              'data' => '2'])

                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-sm-12 control-label labelleft">Apellido Paterno <span class="required">*</span></label>
                      <div class="col-sm-7 abajocaja">

                        <input  type="text" 
                                id="apellidopaterno" name='apellidopaterno' value="@if(isset($trabajador)){{old('apellidopaterno',$trabajador->apellidopaterno)}}@else{{old('apellidopaterno')}}@endif" placeholder="Apellido Paterno"
                                required = ""
                                autocomplete="off" class="form-control input-sm validarletras validarmayusculas" data-aw="3"/>

                      </div>
                    </div>


                    <div class="form-group">
                          <label class="col-sm-12 control-label labelleft">Apellido Materno <span class="required">*</span></label>
                          <div class="col-sm-7 abajocaja">

                            <input  type="text"
                                    id="apellidomaterno" name='apellidomaterno' value="@if(isset($trabajador)){{old('apellidomaterno',$trabajador->apellidomaterno)}}@else{{old('apellidomaterno')}}@endif" placeholder="Apellido Materno"
                                    required = ""
                                    autocomplete="off" class="form-control input-sm validarletras validarmayusculas" data-aw="4"/>

                          </div>
                    </div>

                  
                </div>
      
            </div>

            <div class="col-sm-6">

              <div class="panel-body">

                <div class="form-group">
                        <label class="col-sm-12 control-label labelleft">Nombres <span class="required">*</span></label>
                        <div class="col-sm-7 abajocaja">

                          <input  type="text"
                                  id="nombre" name='nombre' value="@if(isset($trabajador)){{old('nombre',$trabajador->nombres)}}@else{{old('nombre')}}@endif" placeholder="Nombres" required = ""
                                  autocomplete="off" class="form-control input-sm validarletras validarmayusculas" data-aw="5"/>

                        </div>
                </div> 

                <div class="form-group">
                    <label class="col-sm-12 control-label labelleft">Fec Nacimiento <span class="required">*</span>
                    </label> 
                    <div class="col-sm-7 abajocaja"> 
                      <div data-min-view="2" data-date-format="dd-mm-yyyy"  class="input-group date datetimepicker">
                                <input size="16" type="text" value="@if(isset($trabajador)){{old('fechanacimiento',date_format(date_create($trabajador->fechanacimiento),'d-m-Y'))}}@else{{old('fechanacimiento')}}@endif" placeholder="Fecha Nacimiento"
                                id='fechanacimiento' name='fechanacimiento' 
                                required = ""
                                class="form-control input-sm">
                                <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                      </div>
                    </div>
                </div>


                  <div class="form-group">
                    <label class="col-sm-12 control-label labelleft">Telefono<span class="required">*</span></label>
                    <div class="col-sm-5 abajocaja">

                      <input  type="text"
                              id="telefono" name='telefono' value="@if(isset($trabajador)){{old('telefono',$trabajador->telefono)}}@else{{old('telefono')}}@endif"placeholder="Telefono"
                              data-parsley-type="number" required = "" 
                              autocomplete="off" class="form-control input-sm validarnumero" data-aw="6">

                    </div>
                  </div>

              </div>

            </div>
        </div>

        <ul class="list-unstyled list-inline pull-right">
         <li><button type="button" class="btn btn-info next-step">Siguiente <i class="fa fa-chevron-right"></i></button></li>
        </ul>
    </div>

 <div id="menu2" class="tab-pane fade">
        <h3></h3>

        <div class="row panelhorarioempresa">
              <div class="col-sm-6">        
                  <div class="panel-body">
                    
                      <div class="form-group" <?php if ((isset($trabajador))){echo 'style="display:none;"'; } ?>>
                          <label class="col-sm-12 control-label labelleft " >Empresa :</label>
                          <div class="col-sm-12 abajocaja">
                            {!! Form::select( 'empresa_id', $comboempresa, array(),
                                              [
                                                'class'       => 'form-control control input-sm' ,
                                                'id'          => 'empresa_id',
                                                'required'    => '',
                                                'data-aw'     => '1',
                                              ]) !!}
                          </div>
                      </div>

                      <div class="form-group ajaxlocalempresa" <?php if ((isset($trabajador))){echo 'style="display:none;"'; } ?> >

                           @include('general.ajax.combolocalempresa', ['combolocal' => $combolocal])

                      </div>

                      <div class='ajaxareahorariocargo'>
                        <div class="form-group">
                          <label class="col-sm-12 control-label labelleft" >Area :</label>
                          <div class="col-sm-12 abajocaja" >
                            {!! Form::select( 'area_id', $comboarea, array(),
                                              [
                                                'class'       => 'form-control control input-sm' ,
                                                'id'          => 'area_id',
                                                'required'    => '',
                                                'data-aw'     => '2',
                                              ]) !!}
                          </div>
                        </div>                

                        <div class="form-group">
                                <label class="col-sm-12 control-label labelleft">Horario <span class="required">*</span></label>
                                <div class="col-sm-7 abajocaja">
                                  {!! Form::select( 'horario_id', $combohorario, array(),
                                                    [
                                                      'class'       => 'form-control control input-sm' ,
                                                      'id'          => 'horario_id',
                                                      'required'    => '',
                                                      'data-aw'     => '26'
                                                    ]) !!}
                                </div>
                        </div>

                        <div class="form-group">

                              <label class="col-sm-12 control-label labelleft">Cargo <span class="required">*</span></label>
                              <div class="col-sm-7 abajocaja">
                                {!! Form::select( 'cargo_id', $combocargo, array(),
                                                  [
                                                    'class'       => 'form-control control input-sm' ,
                                                    'id'          => 'cargo_id',
                                                    'required'    => '',
                                                    'data-aw'     => '26'
                                                  ]) !!}
                              </div>
                        </div>

                        
                      </div>

                  </div>
              </div>

              <div class="col-sm-6">

                <div class="panel-body">

                      <div class="form-group">
                          <label class="col-sm-12 control-label labelleft">Fecha Ingreso <span class="required">*</span>
                          </label> 
                          <div class="col-sm-7 abajocaja"> 
                            <div data-min-view="2" data-date-format="dd-mm-yyyy"  class="input-group date datetimepicker">
                                      <input size="16" type="text" value="@if(isset($trabajador)){{old('fechaingreso',date_format(date_create($trabajador->fechaingreso),'d-m-Y'))}}@else{{old('fechaingreso')}}@endif" placeholder="Fecha Ingreso"
                                      id='fechaingreso' name='fechaingreso' 
                                      required = ""
                                      class="form-control input-sm">
                                      <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                            </div>
                          </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-12 control-label labelleft">Marcar con DNI <span class="required">*</span></label>
                        <div class="col-sm-7 abajocaja">
                          <div class="be-radio has-success inline">
                            <input type="radio" class="radiodni radio" value='1' @if(isset($trabajador)) @if($trabajador->mar_dni == 1) checked @endif @else @endif name="mar_dni" id="rad1">
                            <label for="rad1">Sí</label>
                          </div>
                          <div class="be-radio has-danger inline radio2">
                            <input type="radio" class="radiodni radio" required = "" value='0' @if(isset($trabajador)) @if($trabajador->mar_dni == 0) checked @endif @endif name="mar_dni" id="rad2">
                            <label for="rad2">No</label>
                          </div>
                        </div>
                      </div> 

                  </div>
              </div>
        </div>
        
        <ul class="list-unstyled list-inline pull-right">
         <li><button type="button" class="btn btn-default prev-step"><i class="fa fa-chevron-left"></i> Atrás</button></li>
         <li><button type="button" class="btn btn-info next-step">Siguiente <i class="fa fa-chevron-right"></i></button></li>
        </ul>
  </div>

    <div id="menu3" class="tab-pane fade">
          <h3></h3>
          <center><p>¿Seguro que desea guardar esta ficha?</p></center>

          <ul class="list-unstyled list-inline pull-right">
            <p class="text-center">
                 <li><button type="button" class="btn btn-default prev-step"><i class="fa fa-chevron-left"></i> Atrás</button></li>
                 <li><button type="submit" id='guardartrabajador' class="btn btn-space btn-primary btn btn-success "><i class="fa fa-check"></i>Guardar</button></li>             
            </p>           
          </ul>
    </div>

  </div>
 </div>
</div>

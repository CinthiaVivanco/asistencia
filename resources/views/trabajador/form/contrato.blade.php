<div class="containertab">
   <div class="row">
      <div class="process">
           <div class="process-row nav nav-tabs">
              <div class="process-step tabmenu1"> 
                 <button type="button" class="btn btn-info btn-circle" data-toggle="tab" href="#menu1"><i class="fa fa-pencil-square-o fa-2x"></i></button>
                 <p><small>Datos del<br />Contrato</small></p>
                 <div class='errortabc'>
                   <i class="fa fa-exclamation" aria-hidden="true"></i> 
                 </div>
                 <div class='bientabc'>
                   <i class="fa fa-check" aria-hidden="true"></i> 
                 </div>
              </div>  
              <div class="process-step tabmenu2">
                 <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu2"><i class="fa fa-usd fa-2x"></i></button>
                 <p><small>Datos del<br />Pago</small></p>
                 <div class='errortabc'>
                   <i class="fa fa-exclamation" aria-hidden="true"></i> 
                 </div>
                 <div class='bientabc'>
                   <i class="fa fa-check" aria-hidden="true"></i> 
                 </div>
              </div>
              <div class="process-step tabmenu3">
                 <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu3"><i class="fa fa-check fa-2x"></i></button>
                 <p><small>Guardar<br />Contrato</small></p>
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

                            <label class="col-sm-12 control-label labelleft">Tipo Contrato <span class="required">*</span> </label>
                            <div class="col-sm-6 abajocaja"  >
                              {!! Form::select( 'tipocontrato_id', $combotipocontrato, array(),
                                                [
                                                  'class'       => 'form-control control input-sm' ,
                                                  'id'          => 'tipocontrato_id',
                                                  'required'    => '',
                                                  'data-aw'     => '1'
                                                ]) !!}
                            </div>
                          </div>

                         <div class="form-group">
                              <label class="col-sm-12 control-label labelleft">
                                Fecha Inicio <span class="required">*</span>
                              </label>
                              <div class="col-sm-7 abajocaja">
                                <div data-min-view="2" 
                                     data-date-format="dd-mm-yyyy"  
                                     class="input-group date datetimepicker">
                                     <input size="16" type="text" 
                                            value="@if(isset($contrato)){{old('fechainicio',date_format(date_create($contrato->fechainicio),'d-m-Y'))}}@else{{old('fechainicio')}}@endif" 
                                            placeholder="Fecha Inicio"
                                            id='fechainicio' 
                                            name='fechainicio' 
                                            required = ""
                                            class="form-control input-sm"/>
                                      <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                                </div>
                              </div>
                          </div>

                          <div class="form-group">
                               <label class="col-sm-12 control-label labelleft">
                                Fecha Fin<span class="required">*</span>
                               </label> 
                               <div class="col-sm-7 abajocaja">
                                 <div data-min-view="2" 
                                      data-date-format="dd-mm-yyyy"  
                                      class="input-group date datetimepicker">
                                      <input size="16" 
                                             type="text" 
                                             id='fechafin' 
                                             name='fechafin'      
                                             data-parsley-fechamayor='fechainicio'                                       
                                             value="
                                             @if(isset($contrato))
                                              @if($contrato->fechafin=='')
                                                {{old('fechafin')}}
                                              @else
                                                {{old('fechafin',date_format(date_create($contrato->fechafin),'d-m-Y'))}}
                                              @endif
                                             @else{{old('fechafin')}} @endif"  
                                             placeholder="Fecha Fin"
                                             required = ""
                                             class="form-control input-sm"/>
                                           <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                                  </div>
                               </div>
                          </div>

                          <div class="form-group ajaxcargo">
                             @include('general.ajax.combocargo', ['combocargo' => $combocargo])
                          </div>

                       </div>
                    </div>

                    <div class="col-sm-6">

                        <div class="panel-body">

                          <div class="form-group">

                            <label class="col-sm-12 control-label labelleft">Jornada Laboral<span class="required">*</span></label>
                            <div class="col-sm-6 abajocaja jornada">
                              @foreach($jornadalaboral as $key=>$item)  

                                <div class="be-checkbox inline">

                                  <input 
                                  id="{{$item->id}}" 
                                  value="{{$item->id}}" 
                                  name="jornadalaboral[]" 
                                  type="checkbox"
                                  data-parsley-multiple="groups-jornada"                   
                                  data-parsley-errors-container="#error-jornada"
                                  data-parsley-mincheck="1" 
                                  @if($key == count($jornadalaboral)-1) 
                                      required=""  
                                  @endif 

                                  @if(isset($contrato))
                                    @if($item->activo == '1') 
                                      checked  
                                    @endif 
                                  @endif
                                  >
                                  <label for="{{$item->id}}">
                                    <font style="vertical-align: inherit;">
                                      <font   style="vertical-align: inherit;">{{$item->descripcion}}</font>
                                    </font>
                                  </label>
                                </div>
                              @endforeach
                                <div id="error-jornada"></div>
                            </div>
                          </div>

                           <div class="form-group">
                                <label class="col-sm-12 control-label labelleft">Periodicidad <span class="required">*</span></label>
                                <div class="col-sm-7 abajocaja">
                                    {!! Form::select( 'periodicidad_id', $comboperiodicidad, array(),
                                                      [
                                                        'class'       => 'form-control control input-sm' ,
                                                        'id'          => 'periodicidad_id',
                                                        'required'    => '',
                                                        'data-aw'     => '24'
                                                      ]) !!}
                                </div>
                           </div>

                          <div class="form-group">
                              <label class="col-sm-12 control-label labelleft">Observación</label>
                              <div class="col-sm-6 abajocaja">

                                <input  type="text"
                                        id="observacion" 
                                        name='observacion' 
                                        value="@if(isset($contrato)){{old('observacion',$contrato->observacion)}}@else{{old('observacion')}}@endif"
                                        placeholder="Observación"
                                        autocomplete="off" 
                                        class="form-control input-sm" 
                                        data-aw="3"/>
                                        @include('error.erroresvalidate', [ 'id' => $errors->has('observacion')  , 
                                                                    'error' => $errors->first('observacion', ':message') , 
                                                                    'data' => '2'])

                              </div>
                          </div>

                          @if(isset($contrato)) 
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft">Estado <span class="required">*</span></label>
                                <div class="col-sm-6 abajocaja">

                                  <div class="be-radio has-success inline">
                                    <input type="radio" value="1"  

                                      @if(isset($contrato)) 
                                        @if($contrato->estado == 1) 
                                          checked  
                                        @endif 
                                      @endif 
                                      name="estado" id="rad1">
                                    <label for="rad1">Activo</label>
                                  </div>

                                  <div class="be-radio has-danger inline">
                                    <input type="radio" value='0'  

                                      @if(isset($contrato)) 
                                        @if($contrato->estado == 0) 
                                          checked  
                                        @endif 
                                      @endif 
                                      name="estado" id="rad2">
                                    <label for="rad2">Concluido</label>
                                  </div>
                                  
                                </div>
                            </div>  
                          @endif 
               
                        </div>
                    </div>
                </div>

                <ul class="list-unstyled list-inline pull-right">
                 <li><button type="button" class="btn btn-info next-step">Siguiente <i class="fa fa-chevron-right"></i></button></li>
                </ul>
             </div>  

             <div id="menu2" class="tab-pane fade" >
                <h3></h3>
                <div class="row" >
                  
                    <div class="col-md-6 col-md-offset-3 centro">
                      <div class="panel-body">

                           <div class="form-group" >

                                <label class="col-sm-12 control-label labelleft">Tipo Pago <span class="required">*</span></label>
                                <div class="col-sm-7 abajocaja">
                                  {!! Form::select( 'tipopago_id', $combotipopago, array(),
                                                    [
                                                      'class'       => 'form-control control input-sm' ,
                                                      'id'          => 'tipopago_id',
                                                      'required'    => '',
                                                      'data-aw'     => '22'
                                                    ]) !!}
                                </div>
                            </div>

                            <div class="form-group" >
                                  <label class="col-sm-12 control-label labelleft">Número Cuenta</label>
                                  <div class="col-sm-7 abajocaja">

                                    <input  type="text"
                                            id="numerocuenta" name='numerocuenta' value="@if(isset($contrato)){{old('numerocuenta',$contrato->numerocuenta)}}@else{{old('numerocuenta')}}@endif" placeholder="Número Cuenta" maxlength="16" minlength="16" 
                                            autocomplete="off" class="form-control input-sm validarnumero" data-aw="23"/>

                                  </div>
                            </div>

                            <div class="form-group">
                                  <label class="col-sm-12 control-label labelleft">Remuneración <span class="required">*</span></label>
                                  <div class="col-sm-7 abajocaja">

                                    <input  type="text"
                                            id="remuneracion" name='remuneracion' value="@if(isset($contrato)){{old('remuneracion',$contrato->remuneracion)}}@else{{old('remuneracion')}}@endif" placeholder="Remuneración"
                                            required = "" data-parsley-type="number"
                                            autocomplete="off" class="form-control input-sm validarnumero" data-aw="25"/>

                                  </div>
                            </div>

                            <div class="form-group" >

                                <label class="col-sm-12 control-label labelleft">Formato Contrato <span class="required">*</span></label>
                                <div class="col-sm-7 abajocaja">
                                  {!! Form::select( 'formato_id', $comboformato, array(),
                                                    [
                                                      'class'       => 'form-control control input-sm' ,
                                                      'id'          => 'formato_id',
                                                      'required'    => '',
                                                      'data-aw'     => '22'
                                                    ]) !!}
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
                    <center><p>¿Seguro que desea guardar el contrato?</p></center>

                    <ul class="list-unstyled list-inline pull-right">
                        <p class="text-center">
                                <li><button type="button" class="btn btn-default prev-step"><i class="fa fa-chevron-left"></i> Atrás</button></li>
                                <li><button type="submit" id='guardarcontrato' class="btn btn-space btn-primary btn btn-success "><i class="fa fa-check"></i>Guardar</button></li>
                                          
                        </p>                
                    </ul>
                    
             </div>         

        </div>
   </div>
</div>

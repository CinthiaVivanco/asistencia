
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">×</button>
  <h4 class="modal-title">Contrato de:  {{$contrato->trabajador->apellidopaterno}} {{$contrato->trabajador->apellidomaterno}} {{$contrato->trabajador->nombres}}</h4>
</div>
<div class="modal-body">

      <div class="container">
          <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="">
                      <div class="row">

                          <div class="col-sm-12 col-md-6 columna">

                            <div class="form-group">

                                  <div class="title">
                                      <h4 class="titleh4">TIPO CONTRATO</h4>
                                  </div>
                                                
                                  <div class="textmodal">
                                      <span class="spanmodal">{{$contrato->tipocontrato->descripcion}} </span>
                                  </div>

                            </div>

                            <div class="form-group">
                                  <div class="title">
                                      <h4  class="titleh4">FECHA INICIO</h4>
                                  </div>
                                                
                                  <div class="textmodal">
                                      <span class="spanmodal">{{$contrato->fechainicio}}</span>
                                  </div>
                            </div>

                            <div class="form-group">
                                  <div class="title">
                                      <h4  class="titleh4">FECHA FIN</h4>
                                  </div>
                                                
                                  <div class="textmodal">
                                      <span class="spanmodal">{{$contrato->fechafin}}</span>
                                  </div>
                            </div>

                            <div class="form-group">
                                  <div class="title">
                                      <h4  class="titleh4">CARGO</h4>
                                  </div>
                                                
                                  <div class="textmodal">
                                      <span class="spanmodal">{{$contrato->cargo->nombre}}</span>
                                  </div>
                            </div>

                            <div class="form-group">
                                  <div class="title">
                                      <h4  class="titleh4">PERIODICIDAD</h4>
                                  </div>
                                                
                                  <div class="textmodal">
                                      <span class="spanmodal">{{$contrato->periodicidad->descripcion}}</span>
                                  </div>
                            </div>

                          </div>


                          <div class="col-sm-6 col-md-6 columna">

                            <div class="form-group">
                                  <div class="title">
                                      <h4  class="titleh4">OBSERVACIÓN</h4>
                                  </div>
                                                
                                  <div class="textmodal">
                                      <span class="spanmodal">{{$contrato->observacion}}</span>
                                  </div>
                            </div>

                            <div class="form-group">
                                  <div class="title">
                                      <h4  class="titleh4">TIPO PAGO</h4>
                                  </div>
                                                
                                  <div class="textmodal">
                                      <span class="spanmodal">{{$contrato->tipopago->descripcion}}</span>
                                  </div>
                            </div>

                            <div class="form-group">
                                  <div class="title">
                                      <h4  class="titleh4">NÚMERO CUENTA</h4>
                                  </div>
                                                
                                  <div class="textmodal">
                                      <span class="spanmodal">{{$contrato->numerocuenta}}</span>
                                  </div>
                            </div>

                            <div class="form-group">
                                  <div class="title">
                                      <h4  class="titleh4">REMUNERACIÓN</h4>
                                  </div>
                                                
                                  <div class="textmodal">
                                      <span class="spanmodal">{{$contrato->remuneracion}}</span>
                                  </div>
                            </div> 

                            <div class="form-group">
                                  <div class="title">
                                      <h4  class="titleh4">FORMATO</h4>
                                  </div>
                                                
                                  <div class="textmodal">
                                      <span class="spanmodal">{{$contrato->formato->descripcion}}</span>
                                  </div>
                            </div>
                          </div>
                    </div>
                  </div>
              </div>
          </div>
</div>


      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
</div>
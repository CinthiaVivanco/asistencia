<h3>{{$asistenciatrabajador->trabajador->nombres}} {{$asistenciatrabajador->trabajador->apellidopaterno}} {{$asistenciatrabajador->trabajador->apellidomaterno}}</h3>
<p class= 'fecha'>({{date_format(date_create($asistenciatrabajador->$diah), 'd-m-Y')}})</p>
<div class="col-sm-12 cell-detail">
	<div class="row">


		<div class="col-sm-5 col-sm-offset-1">

		  	<span id='tentrada' class="cell-detail-description cell-detail-descriptionfr cell-detail-time
		  		{{$funcion->funciones->getcolormarco($asistenciatrabajador->id,$dia,1)}}">
		    	ENTRADA ({{$funcion->funciones->gethorario($asistenciatrabajador->$hdia,'horainicio')}})
		  	</span>
			<div class="input-group input-group-sm xs-mb-15">

	            <span class="input-group-btn">
				    <button 
				        type="button" 
				        class="btn btn-danger"
				        id='eliminarhora'
				        data-id  		= "{{Hashids::encode(substr($asistenciatrabajador->id, -12))}}"
				        data-tid  		= "{{Hashids::encode(substr($asistenciatrabajador->trabajador->id, -12))}}"
				        data-atr 		= "{{$diami}}"
				        data-hor 		= "{{$diad}}"
				        data-dia 		= "{{$dia}}"
				        data-entrada  	= "1"
				        data-cantmar  	= "1"
				        data-ajax  		= "{{$sectorupdate}}"
				        data-titulo  	= "tentrada"
				        data-aviso  	= "Entrada"
				        data-horario  	= "horainicio"				        
				        data-fecha 		= "{{$asistenciatrabajador->$diad}}"
				    ><span class="mdi mdi-close"></span></button> 
	           </span>   

	            <input type="text" id='timepicker' name='timepicker' class="form-control" style = 'height: 37px;'
	            	value='{{$asistenciatrabajador->$diami}}' 
				    data-timepicki-tim = '{{$funcion->funciones->horaasistencia($asistenciatrabajador->$diami)}}' 
				    data-timepicki-mini= '{{$funcion->funciones->minutosasistencia($asistenciatrabajador->$diami)}}'
				    data-val = "{{$asistenciatrabajador->$diami}}"
				    />
	            <span class="input-group-btn">
				    <button 
				        type="button" 
				        class="btn btn-primary"
				        id='limpiarhora'                
				    ><span class="mdi mdi-delete"></span></button>                	
			      	<button 
				        type="button"
				        class="btn btn-primary"
				        id='actualizarhora'
				        data-id  		= "{{Hashids::encode(substr($asistenciatrabajador->id, -12))}}"
				        data-tid  		= "{{Hashids::encode(substr($asistenciatrabajador->trabajador->id, -12))}}"
				        data-atr 		= "{{$diami}}"
				        data-hor 		= "{{$diad}}"
				        data-dia 		= "{{$dia}}"
				        data-entrada  	= "1"
				        data-cantmar  	= "1"
				        data-ajax  		= "{{$sectorupdate}}"
				        data-titulo  	= "tentrada"
				        data-aviso  	= "Entrada"
				        data-horario  	= "horainicio"				        
				        data-fecha 		= "{{$asistenciatrabajador->$diad}}"
			      	><span class="mdi mdi-refresh-sync "></span></button>
	           </span>
	        </div>


			@if ($asistenciatrabajador->$diacantmarc == 4) 

			  	<span id='trefrigeriosalida' class="cell-detail-description cell-detail-descriptionfr cell-detail-time
			  		{{$funcion->funciones->getcolormarco($asistenciatrabajador->id,$dia,2)}}">
			    	REFRIGERIO SALIDA ({{$funcion->funciones->gethorario($asistenciatrabajador->$hdia,'refrigerioinicio')}})
			  	</span>
				<div class="input-group input-group-sm xs-mb-15">

		            <span class="input-group-btn">
					    <button 
					        type="button" 
					        class="btn btn-danger"
					        id='eliminarhora'
					        data-id  		= "{{Hashids::encode(substr($asistenciatrabajador->id, -12))}}"
					        data-tid  		= "{{Hashids::encode(substr($asistenciatrabajador->trabajador->id, -12))}}"
					        data-atr 		= "{{$diamri}}"
					        data-hor 		= "{{$diad}}"
					        data-dia 		= "{{$dia}}"
					        data-entrada  	= "0"
					        data-cantmar  	= "2"
					        data-ajax  		= "{{$sectorupdate}}"
					        data-titulo  	= "trefrigeriosalida"
					        data-aviso  	= "S. refrigerio"
					        data-horario  	= "refrigerioinicio"				        
					        data-fecha 		= "{{$asistenciatrabajador->$diad}}"					                       
					    ><span class="mdi mdi-close"></span></button> 
		           </span>   

		            <input type="text" id='timepicker' name='timepicker' class="form-control" style = 'height: 37px;'
		            	value='{{$asistenciatrabajador->$diamri}}' 
					    data-timepicki-tim = '{{$funcion->funciones->horaasistencia($asistenciatrabajador->$diamri)}}' 
					    data-timepicki-mini= '{{$funcion->funciones->minutosasistencia($asistenciatrabajador->$diamri)}}'
					    data-val = "{{$asistenciatrabajador->$diamri}}"
					    />
		            <span class="input-group-btn">
					    <button 
					        type="button" 
					        class="btn btn-primary"
					        id='limpiarhora'                
					    ><span class="mdi mdi-delete"></span></button>                	
				      	<button 
					        type="button"
					        class="btn btn-primary"
					        id='actualizarhora'
					        data-id  		= "{{Hashids::encode(substr($asistenciatrabajador->id, -12))}}"
					        data-tid  		= "{{Hashids::encode(substr($asistenciatrabajador->trabajador->id, -12))}}"
					        data-atr 		= "{{$diamri}}"
					        data-hor 		= "{{$diad}}"
					        data-dia 		= "{{$dia}}"
					        data-entrada  	= "0"
					        data-cantmar  	= "2"
					        data-ajax  		= "{{$sectorupdate}}"
					        data-titulo  	= "trefrigeriosalida"
					        data-aviso  	= "S. refrigerio"
					        data-horario  	= "refrigerioinicio"				        
					        data-fecha 		= "{{$asistenciatrabajador->$diad}}"
				      	><span class="mdi mdi-refresh-sync "></span></button>
		           </span>
		        </div>

			@endif

		</div>

		<div class="col-sm-5">

			@if ($asistenciatrabajador->$diacantmarc == 4) 
			  	<span id='trefrigerioentrada' class="cell-detail-description cell-detail-descriptionfr cell-detail-time
			  		{{$funcion->funciones->getcolormarco($asistenciatrabajador->id,$dia,3)}}">
			    	REFRIGERIO ENTRADA ({{$funcion->funciones->gethorario($asistenciatrabajador->$hdia,'refrigeriofin')}})
			  	</span>
				<div class="input-group input-group-sm xs-mb-15">

		            <span class="input-group-btn">
					    <button 
					        type="button" 
					        class="btn btn-danger"
					        id='eliminarhora' 
					        data-id  		= "{{Hashids::encode(substr($asistenciatrabajador->id, -12))}}"
					        data-tid  		= "{{Hashids::encode(substr($asistenciatrabajador->trabajador->id, -12))}}"
					        data-atr 		= "{{$diamrf}}"
					        data-hor 		= "{{$diad}}"
					        data-dia 		= "{{$dia}}"
					        data-entrada  	= "0"
					        data-cantmar  	= "3"
					        data-ajax  		= "{{$sectorupdate}}"
					        data-titulo  	= "trefrigerioentrada"
					        data-aviso  	= "E. refrigerio"
					        data-horario  	= "refrigeriofin"				        
					        data-fecha 		= "{{$asistenciatrabajador->$diad}}"					                       
					    ><span class="mdi mdi-close"></span></button> 
		           </span>   

		            <input type="text" id='timepicker' name='timepicker' class="form-control" style = 'height: 37px;'
		            	value='{{$asistenciatrabajador->$diamrf}}' 
					    data-timepicki-tim = '{{$funcion->funciones->horaasistencia($asistenciatrabajador->$diamrf)}}' 
					    data-timepicki-mini= '{{$funcion->funciones->minutosasistencia($asistenciatrabajador->$diamrf)}}'
					    data-val = "{{$asistenciatrabajador->$diamrf}}"
					    />
		            <span class="input-group-btn">
					    <button 
					        type="button" 
					        class="btn btn-primary"
					        id='limpiarhora'                
					    ><span class="mdi mdi-delete"></span></button>                	
				      	<button 
					        type="button"
					        class="btn btn-primary"
					        id='actualizarhora'
					        data-id  		= "{{Hashids::encode(substr($asistenciatrabajador->id, -12))}}"
					        data-tid  		= "{{Hashids::encode(substr($asistenciatrabajador->trabajador->id, -12))}}"
					        data-atr 		= "{{$diamrf}}"
					        data-hor 		= "{{$diad}}"
					        data-dia 		= "{{$dia}}"
					        data-entrada  	= "0"
					        data-cantmar  	= "3"
					        data-ajax  		= "{{$sectorupdate}}"
					        data-titulo  	= "trefrigerioentrada"
					        data-aviso  	= "E. refrigerio"
					        data-horario  	= "refrigeriofin"				        
					        data-fecha 		= "{{$asistenciatrabajador->$diad}}"
				      	><span class="mdi mdi-refresh-sync "></span></button>
		           </span>
		        </div>
			@endif

		  	<span id='tsalida' class="cell-detail-description cell-detail-descriptionfr cell-detail-time
		  		{{$funcion->funciones->getcolormarco($asistenciatrabajador->id,$dia,4)}}">
		    	SALIDA ({{$funcion->funciones->gethorario($asistenciatrabajador->$hdia,'horafin')}})
		  	</span>
			<div class="input-group input-group-sm xs-mb-15">

	            <span class="input-group-btn">
				    <button 
				        type="button" 
				        class="btn btn-danger"
				        id='eliminarhora'
				        data-id  		= "{{Hashids::encode(substr($asistenciatrabajador->id, -12))}}"
				        data-tid  		= "{{Hashids::encode(substr($asistenciatrabajador->trabajador->id, -12))}}"
				        data-atr 		= "{{$diamf}}"
				        data-hor 		= "{{$diad}}"
				        data-dia 		= "{{$dia}}"
				        data-entrada  	= "0"
				        data-cantmar  	= "{{$asistenciatrabajador->$diacantmarc}}"
				        data-ajax  		= "{{$sectorupdate}}"
				        data-titulo  	= "tsalida"
				        data-aviso  	= "Salida"
				        data-horario  	= "horafin"				        
				        data-fecha 		= "{{$asistenciatrabajador->$diad}}"               
				    ><span class="mdi mdi-close"></span></button> 
	           </span>   

	            <input type="text" id='timepicker' name='timepicker' class="form-control" style = 'height: 37px;'
	            	value='{{$asistenciatrabajador->$diamf}}' 
				    data-timepicki-tim = '{{$funcion->funciones->horaasistencia($asistenciatrabajador->$diamf)}}' 
				    data-timepicki-mini= '{{$funcion->funciones->minutosasistencia($asistenciatrabajador->$diamf)}}'
				    data-val = "{{$asistenciatrabajador->$diamf}}"
				    />
	            <span class="input-group-btn">
				    <button 
				        type="button" 
				        class="btn btn-primary"
				        id='limpiarhora'                
				    ><span class="mdi mdi-delete"></span></button>                	
			      	<button 
				        type="button"
				        class="btn btn-primary"
				        id='actualizarhora'
				        data-id  		= "{{Hashids::encode(substr($asistenciatrabajador->id, -12))}}"
				        data-tid  		= "{{Hashids::encode(substr($asistenciatrabajador->trabajador->id, -12))}}"
				        data-atr 		= "{{$diamf}}"
				        data-hor 		= "{{$diad}}"
				        data-dia 		= "{{$dia}}"
				        data-entrada  	= "0"
				        data-cantmar  	= "{{$asistenciatrabajador->$diacantmarc}}"
				        data-ajax  		= "{{$sectorupdate}}"
				        data-titulo  	= "tsalida"
				        data-aviso  	= "Salida"
				        data-horario  	= "horafin"				        
				        data-fecha 		= "{{$asistenciatrabajador->$diad}}"
			      	><span class="mdi mdi-refresh-sync "></span></button>
	           </span>
	        </div>

		</div>

		<div class="col-sm-12 footer">
            <span class="panel-subtitle">Editar marcacion del trabajador</span>
        </div>

	</div>
                   
</div>
<div class="xs-mt-50"> 

</div>

<script type="text/javascript">
  $(document).ready(function(){
      $('.ajaxhoraasistencia #timepicker').timepicki({
      show_meridian:false,
      min_hour_value:0,
      max_hour_value:23,
      overflow_minutes:true,
      increase_direction:'up',
      disable_keyboard_mobile: true});
      $(".timepicki-input").removeAttr("readonly");
  });
</script>
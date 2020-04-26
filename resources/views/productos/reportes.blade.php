@extends('layouts.app')


@section('content')


<br>  
 
<div >
  <hr> 

<h4> Reportes </h4>

<form class="form-inline" id="pdf"  enctype="multipart/formdata">
  {{csrf_field()}}
   <div class="form-group mb-2">
   <select  name="select_almacen" required class="form-control custom-select" id="select_almacen">
   <option selected="" placeholder="almacen" value="0" > Seleccione un almacen</option>
  @foreach($almacenes as $almacen)
  <option value="{{$almacen->rowid}}">{{$almacen->lieu}}</option>
  @endforeach
  </select>
   </div>
    <div class="form-group mx-sm-5 mb-2">
<button id="checar" class="btn btn-outline-primary" type="submit">Ver Reportes   </button>
    </div>


    <div class="form-group mx-5 mb-2"> 
     <button class="btn btn-outline-info" id="boton">Generar Reporte   </button>
    </div>

    <div class="loader form-group mx-5 mb-2" id="imgnone" >
        <img id="loadimg" src="{{asset('imagenes/loading.gif')}}" style=" width: 60px;
    height: 60px; border-image: 50px; border-radius: 50px;">
    </div>
 
</form>
  <br>



<div  class="form-inline" style="margin-left: 21%"  >
  
 <div class="form-group mx-4 mb-5"  > 
    <button class='btn btn-primary' id='editar'  data-toggle='modal' data-target='#exampleModal'> Finalizar Inventario</button>
  </div>


   <div class="form-group mx-3 mb-2" > 
 

    <ul>
    

    <li>
  <a href="{{asset('manual')}}" target="_blank"  class="btn btn-outline-secondary " ><i class="fas fa-question"></i></a>
      <div class="content" >
      

  
     <span  style=" margin: 19px;">Necesitas ayuda. da click  al boton para ir al manual de usuario</span>
   
      </div> 
    </li>
  </ul>


 </div>


</div>
<p id="generar"   class="alert alert-danger" role="alert" style="display:none"></p>
<br>
<hr>
</div>






<div id="ocultar"  >
	<table id="tabla" class="table table-striped">
		<thead  >
			<tr>
        <th>Almacen</th>
				<th>Fecha del Reporte</th>
				<th>Ver Reporte</th>

			
			</tr>
		</thead>

		<tbody>
			@foreach($reportes as $r)
			<tr>
        <td>{{$r->almacen}}</td>
			<td>{{$r->fecha}}</td>
			<td><a  class="btn btn-outline-secondary" 
        target="_blank" href="{{url('mostrar').'/'.$r->report}}">    <i class="fas fa-file-pdf"> </i> </a ></td>
			
			</tr>
			
			@endforeach
		</tbody>
	</table>
</div>




<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Finalizar inventario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="actualizar" enctype="multipart/formdata" >
        {{csrf_field()}}


        <div class="form-group">
        
          <select name="select_finalizar" required="" class="form-control custom-select" id="select_finalizar">
   <option selected="" value="0" >Selecciona un Almacen</option>
  @foreach($almacenes as $almacen)
  <option value="{{$almacen->rowid}}">{{$almacen->lieu}}</option>
  @endforeach
  </select>
  </div>
        <div class="form-group">
           <br>
            <p id="alerta_de_error_reporte"   class="alert alert-danger" role="alert" style="display: none;"></p>
        </div>
      

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="finalizar"  class="btn btn-primary">Finalizar inventario</button>
      </div>
      </form>
    </div>
  </div>
</div>
       </div>
@endsection()

@section('scripts')
<script>



  $("#exampleModal").on("hidden.bs.modal", function () {
    $('#alerta_de_error_reporte').hide();

    if ($("#alerta_de_error_reporte").hasClass("alert-success")) {
      $("#alerta_de_error_reporte").removeClass("alert-success");
         $("#alerta_de_error_reporte").addClass("alert-danger");
    }
});




$('#checar').on('click',function(){
var valor=$("#select_almacen").val();
if (valor==0) {
$('#generar').show();

$('#generar').text(' debes seleccionar un almancen');
  $("#select_almacen").focus();   
return false;
}


});





$('#finalizar').on('click',function(e){
e.preventDefault();
 var valor=$("#select_finalizar").val();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

  var valor=$("#select_finalizar").val();
if (valor==0) {
$('#alerta_de_error_reporte').show();

$('#alerta_de_error_reporte').text(' debes seleccionar un almancen');
  $("#select_finalizar").focus();   
return false;
}
$.ajax({
          type:'post',
          url:'{{url('actualizar')}}',
          data:{almacen:valor, _token:CSRF_TOKEN},
          beforeSend:function(){
       $('#finalizar').text("Finalizando El inventario espere esto puede tardar");
       $("#finalizar").prop("disabled", true);
       },
          
          success:function(response){
            console.log(response);
           if (response==1) {
             $("#alerta_de_error_reporte").show();
            $('#alerta_de_error_reporte').text('no hay articulos ingresados en el conteo del inventario del almacen seleccionado');
            $("#finalizar").prop("disabled", false);
            $('#finalizar').text("Finalizar inventario");
           }else if(response==2){
              $("#alerta_de_error_reporte").show();
            $('#alerta_de_error_reporte').text('No hay un reporte de inventario generado para el  almacen seleccionda.');
            $("#finalizar").prop("disabled", false);
            $('#finalizar').text("Finalizar inventario");

            }else if (response==3) {
              $("#alerta_de_error_reporte").show();
              $("#alerta_de_error_reporte").removeClass("alert-danger");
              $("#alerta_de_error_reporte").addClass("alert-success");                
            $('#alerta_de_error_reporte').text('Inventario Finalizado con exito');
            $("#finalizar").prop("disabled", false);
            $('#finalizar').text("Finalizar inventario");

            }

          },
          error:function(error){
            console.log(error);
        $('#alerta_de_error_reporte').text('Ocurrio un error intenta mas tarde por favor');
       
       }


 });

         });














$('#boton').on('click',function(e){
  e.preventDefault();
  var valor=$("#select_almacen").val();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


 if (valor==0) {
$('#generar').show();

$('#generar').text(' debes seleccionar un almancen');
  $("#select_almacen").focus(); 
return false;
}
$.ajax({
       type:'POST',
       url:'{{url('reporte.pdf')}}',
       data:$('#pdf').serialize(),
       beforeSend:function(){
       $('.loader').show();
       $('#boton').text("Generenado reporte espere");
       $("#boton").prop("disabled", true);
       },
       success:function(response){
        console.log(response);
       if (response==1) {
          $('.loader').hide();
          $("#boton").prop("disabled", false);
          $('#generar').show();
        $('#generar').text("no hay articulos en el conteo del almacen seleccionado");

       } else if(response==2) {
       $('#generar').show();
         $("#generar").removeClass("alert-danger");
         $("#generar").addClass("alert-success");

        $('#generar').text("reporte generado");
          $('.loader').hide();
        $("#pdf").submit();
       }else if(response==3){
         $('#generar').show();
         $("#generar").removeClass("alert-danger");
         $("#generar").addClass("alert-success");

        $('#generar').text("reporte actualizado");
        $('.loader').hide();
        $("#pdf").submit();
       }
       },
       error:function(error){
       console.log(error);
       $('#generar').show();
       alert('Error intente mas tarde ');
       }
       });
});




//url:'http://localhost:8080/invent/public/reporte.pdf',
</script>
@endsection()
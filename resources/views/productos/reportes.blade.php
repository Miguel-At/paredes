@extends('layouts.app')


@section('content')


<br>  
 
<div >
  <hr> 

<h4> Reportes </h4>


<form class="form-inline" id="pdf"  enctype="multipart/formdata">
  {{csrf_field()}}
   <div class="form-group mb-2">
   <select name="select_almacen" required class="form-control custom-select" id="select_almacen">
   <option selected="" >Selecciona un Almacen</option>
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
  <div class="form-group mx-5 mb-2"> 
    <button class='btn btn-primary' id='editar'  data-toggle='modal' data-target='#exampleModal'> Finalizar Inventario</button>
  </div>
</form>

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
          <select name="select_finalizar" required="" class="form-control custom-select" id="select_finalizar">
   <option selected="" >Selecciona un Almacen</option>
  @foreach($almacenes as $almacen)
  <option value="{{$almacen->rowid}}">{{$almacen->lieu}}</option>
  @endforeach
  </select>
        <div class="form-group">
            <p id="mensaje"   class="p-2 mb-2 bg-info text-white" style=""></p>
        </div>
      
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



$('#finalizar').on('click',function(e){
e.preventDefault();
 var valor=$("#select_finalizar").val();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


$.ajax({
          type:'post',
          url:'{{url('actualizar')}}',
          data:{almacen:valor, _token:CSRF_TOKEN},
          success:function(response){
            console.log(response);
            alert("yes")


          },
          error:function(error){
            console.log(error);
       alert('Error al escoger el almacen intente de nuevo');
       
       }


 });

         });










$('#editar').on('click',function(e){
e.preventDefault();

});





$('#boton').on('click',function(e){
  e.preventDefault();
  var valor=$("#select_almacen").val();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
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
        alert("no hay articulos en el conteo del almacen seleccionado");

       } else if(response==2) {
        alert("reporte generado");
          $('.loader').hide();
        $("#pdf").submit();
       }else if(response==3){
        alert("reporte actualizado");
        $('.loader').hide();
        $("#pdf").submit();
       }
       },
       error:function(error){
       console.log(error);
       alert('Error intente mas tarde ');
       }
       });
});




//url:'http://localhost:8080/invent/public/reporte.pdf',
</script>
@endsection()
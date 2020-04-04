@extends('layouts.app')
  

@section('content')
   
   <br>


<input type="hidden" id="prueba" value="0">

<div class="row">

<div class="col-4">
<button id="mostra_ocultar" class=" btn btn-primary"> <i class="fas fa-angle-double-up"></i></button>
</div>




   <div class="col-4" id="almacen">  
    <form  enctype="multipart/formdata">
  {{csrf_field()}}
   <div class="form-group">
    <label for=""><h5>Seleccione un almacen para empezar con el Inventario</h5></label>
  <select name="select_almacen" class="form-control" id="select">
   <option disabled selected="" value="">Selecciona un Almacen</option>
  @foreach($almacenes as $almacen)
  <option value="{{$almacen->rowid}}">{{$almacen->lieu}}</option>
  @endforeach
  </select>
  </div>
  </form>
   </div>

<div class="col-4" > <h4 id="inventario_de_almacen"></h4></div>

   <hr>
</div>
 <br>
 <hr>
<div id="ocultar" >
<form action="" name="myform" id="myform" enctype="multipart/formdata">
   {{csrf_field()}}
          <div class="input-group mb-3">
          <input type="text" id='productos' class="form-control" name="productos"     placeholder="Buscar">
          <div class="input-group-append">
          <button id="button1" type="submit" class="btn btn-outline-secondary"><i id="icon" class="fas fa-search"></i></button>
		  </div>
         </div>
</form>
  <p id="alerta_de_error"   class="alert alert-danger" role="alert"></p>
</div>
<hr>
               <table id="tabla" class="table ">
               <thead>
                 
                   <th>Producto</th>
                   <th>Descripcion</th>
                   <th>Stock</th>
                   <th>Pz/contadas</th>
                   <th>Precio</th>
                   <th>Acciones</th>
               </thead>
 </table>

  <!modal eliminar !>

<!-- Modal -->
<div class="modal fade" id="eli" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Esta seguro de borrar el articulo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formEliminar"enctype="multipart/formdata" >
          {{csrf_field()}}
             {{method_field('DELETE')}}
          
          <input type="hidden" id="eliminer_input">

           <p id="p_product"></p>
           <p id="p_description"></p>

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn-eliminar" class="btn btn-primary">Borrar Articulo</button>
      </div>
        </form>
    </div>
  </div>
</div>
      <!modal Editar!>
     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Piezas Contadas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAct" enctype="multipart/formdata" >
        {{csrf_field()}}
         {{method_field('PUT')}}
        <div class="form-group">
          <input type="hidden" id="id" class="form-control" readonly="" name="id">
        </div>
        <div class="form-group">
           <label for="">Articulo</label>
          <input type="text" id="ref" class="form-control" readonly="" name="ref">
        </div>
        <div class="form-group">
           <label for="">Descripcón</label>
          <input type="text" id="description" class="form-control" readonly="" name="description">
        </div>
        <div class="form-group">
           <label for="">Ingrese la cantidad </label>
          <input type="text" id="stock" class="form-control" name="stock">
        </div>
        <div class="form-group">
            <p id="mensaje"   class="p-2 mb-2 bg-info text-white" style=""></p>
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="actualizar"  class="btn btn-primary">Guardar cambios</button>
      </div>
      </form>
    </div>
  </div>
</div>
       </div>



  


</div>
@endsection()





@section('scripts')
<script src="{{ asset('js/crud.js') }}" ></script>
<script>
 


$('i').click(function() {
  $(this).toggleClass('fas fa-angle-double-down').toggleClass('fas fa-angle-double-up');
});

  var contador=0;
$("#mostra_ocultar").on("click",function (){
  contador++;
if (contador%2==0) {
  $("#almacen").hide();  
  $("#inventario_de_almacen").show();
}

if (contador%2) {
  $("#almacen").show(); 
  $("#inventario_de_almacen").hide();

}
});
</script>


@endsection()
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
	<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
	<title></title>
</head>
<body>

	<div class="row">
       <div class="col-4">
   <img src="{{asset('imagenes/logo.png')}}" height="80" alt="">
   <p >Fecha del Reporte:  {{$fecha}} </p>
  </div>
   <div class="col-14" > <h5 class="text-center"> Reporte de Inventario del Almacen </h5>
   	@foreach($almacen as $al)
    <h5 class="text-center">{{$al->lieu}}</h5> 
    @endforeach()
</div>
</div>
  <div class="table-responsive-sm" style="margin-top:-65px;" >
  <table class=" table table-bordered" style="margin-top:-13px;" >
		 <thead class="table-dark">
			<tr>
				<th>Referencia</th>
				<th>descripcion</th>
				<th>precio</th>
				<th>stock en Almacen</th>
				<th>Pz/contadas</th>
				<th>Diferencias del conteo</th>
				<th>Diferencias Perdida/gancias</th>
			
			</tr>
		</thead>

		<tbody>
			
@foreach($data as $invent)
<tr>
<td>{{$invent->ref}}</td>
<td>{{$invent->description}}</td>
<td>${{$invent->price}}</td>
<td>{{$invent->stock}}</td>
<td>{{$invent->tem_stock}}</td>
<td>{{$invent->diferencia}}</td>
<td>${{$invent->pesos}}</td>


</tr>

@endforeach()


		</tbody>
	
	</table>
	<div id="footer">
    <p class="page">Pagina  </p>
  </div> 
</div>
 <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  

</body>

</html>
<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
          <link rel="stylesheet"  href="{{ asset('css/estilos.css') }}">

              
               <meta name="csrf-token" content="{{ csrf_token() }}">
                <title>Inventario</title>
                </head>
                <body>
   	 
              <nav class="navbar navbar-expand-lg navbar-dark bg-dark   bg-faded">
  <a class="navbar-brand" href="{{url('/') }}">Paredes</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
      <li class="nav-item active"  >
      <a class="nav-link" href="{{url('almacen') }}">Inventario <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active" style=" margin-left:30px;
  margin-right:150px;">
      <a class="nav-link   mr-sm-2" href="{{url('productos')}}">Reportes</a>
      </li>
      </ul>
      </div>
       </nav>

   	       <div class="container">
	       @yield('content')
	
           </div>
           </body>
 <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
       <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
       <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}" ></script>
<script src="https://kit.fontawesome.com/05a16cb1fd.js" crossorigin="anonymous"></script>
     @yield('scripts')
   </html>



@extends('layouts.app')



@section('content')

<br>
<div class="inicio container" id="inicio" style="background-image: url(imagenes/joyas.jpg);  
background-size:100% 100%;
 box-shadow: 0px 0px 20px gray; height: 400px; padding-top: 10px;">


<div class="container" style="  float: right;
       height: 350px; width: 420px; box-shadow: 10px 10px 20px gray; padding-right: 100px; border-radius: 16px;">
        
        <div class="text-center"><br>
          <img src="{{asset('imagenes/logo2.jpg')}}" style="height: 100px; width: 100px; border-radius: 50px; " alt="">
          </div>
     <br>
    <h4 class="text-center text-white" >Hola bienvenido al sistema de inventario </h4>
     <div class="text-center">
    <a id="btn_inicio"  type="button" href="{{url('almacen')}}" class="btn btn-outline-dark  text-white" style="background-color: black; ">Empezar</a>
    </div>
    </div>



</div>


@endsection()






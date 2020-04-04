


<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">

          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
      <meta name="csrf-token" content="{{ csrf_token() }}">

 

        <title>Laravel</title>

        <br>
     
       <body>

        


       <div class="container">

      
        <button class="btn btn-secondary" id="listar">Listar  </button>
          <form action="" name="myform" id="myform">

    <input type="text" id='productos' name="productos" required="" placeholder="Buscar" style="margin-right: 40px;"enctype="multipart/formdata">
  {{csrf_field()}}
    <button id="button1" type="submit" class="btn">Guardar</button>
     </form>
           <table id="tabla" class="table ">
               <thead>
                    <th>#</th>
                   <th>Productos</th>
                   <th>descripcion</th>
                   <th>stock</th>
                   <th>Acciones</th>
               </thead>


           </table>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="formAct" enctype="multipart/formdata" >
        {{csrf_field()}}
  {{method_field('PUT')}}
        <div class="form-group">
           <label for=""></label>
          <input type="text" id="id" class="form-control" readonly="" name="id">
        </div>
        <div class="form-group">
           <label for=""></label>
          <input type="text" id="ref" class="form-control" readonly="" name="ref">
        </div>
        <div class="form-group">
           <label for=""></label>
          <input type="text" id="description" class="form-control" readonly="" name="description">
        </div>
        <div class="form-group">
           <label for=""></label>
          <input type="text" id="stock" class="form-control"  name="stock">
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
       </div>

       <!modal eliminar !>

<!-- Modal -->
<div class="modal fade" id="eli" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="btn-eliminar" class="btn btn-primary">Save changes</button>
      </div>
        </form>
    </div>
  </div>
</div>


       <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
       <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
       <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>

    <script>
$(document).ready(function() {
  
listar();
  });
   
$('#listar').on('click',function(){

listar();
})


  function listar(){ 
   var table=$('#tabla').DataTable({
        destroy:true,
       ajax: '{{route (' products ')}}', 
        columns: [
        { data: 'fk_product', name: 'fk_product' },
            { data: 'ref', name: 'ref' },
            { data: 'description', name: 'description' },
            { data: 'tem_stock', name: 'tem_stock' },
            {defaultContent:
             "<button class='btn btn-primary' id='editar'  data-toggle='modal' data-target='#exampleModal'> editar</button> <button class='btn btn-primary' id='eliminar'  data-toggle='modal' data-target='#eli'> eliminar</button>",orderable: false, searchable: false}
        ]
    });
   obtener_datos("#tabla tbody", table);
    obtener_datos_eliminar("#tabla tbody", table);
   }

   function  obtener_datos(tbody,table){
    $(tbody).on("click","#editar",function(){
    var data=table.row($(this).parents("tr")).data();    
   var fk_product = $("#id").val( data.fk_product );
     var       ref = $("#ref").val( data.ref );
        var    description = $("#description").val( data.description );
  });
}

function  obtener_datos_eliminar(tbody,table){
  $(tbody).on("click","#eliminar",function(){
  var data=table.row($(this).parents("tr")).data();


    var fk_product = $("#eliminer_input").val( data.rowid );   
     
   $("#p_product").text(data.ref ); 
    $("#p_description").text(data.description ); 

  });
}


function limpiar(){
      var ref_f= $("#stock").val('');
}


$('#btn-eliminar').on('click',function(e){
  e.preventDefault();
      var id=$("#eliminer_input").val();
     
       $.ajax({
        type:'DELETE',
        url:'{{url('/borrar/')}}/'+id,
        data:$('#formEliminar').serialize(),
        success:function(response){
          console.log(response);
          $('#eli').modal('hide');
          listar();

      
        },
        error:function(error){
          console.log(error);
          alert('No se pudo eliminar el articulo');
        }
       });

});
 
 $('#formAct').on('submit',function(e){
    

       $.ajax({
        type:'PUT',
        url:'{{url('/actualizar/')}}/'+id,
        data:$('#formAct').serialize(),
        success:function(response){
        console.log(response);
        $('#exampleModal').modal('hide');
        limpiar();
        listar();
        },
        error:function(error){
        console.log(error);
       alert('EL articulo ingresado no existe en el almacen');
       }
       });
       });

 

$('#myform').on('submit',function(e){
       e.preventDefault();

       $.ajax({
        type:'POST',
        url:'{{url('/guardar')}}',
        data:$('#myform').serialize(),
        success:function(response){
          console.log(response);
          listar();
    
        },
        error:function(error){
          console.log(error);
          alert('EL articulo ingresado no existe en el almacen');
        }
       });
     });




    </script>
    <script >
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

      $( "#productos" ).autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url:"{{route('autocomplete.fetch')}}",
            type: 'post',
            dataType: "json",
            data: {
               _token: CSRF_TOKEN,
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
           minLength: 3,
           $('#productos').val(ui.item.label); // display the selected text
           return false;
        }
      });



      

    });
    </script>

</html>

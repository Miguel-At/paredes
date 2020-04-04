 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


// en host




var ruta=""https://paredes925.herokuapp.com/invent/public/autocomplete";
var ruta_de_listar=""https://paredes925.herokuapp.com/invent/public/product";
var ruta_de_borrar=""https://paredes925.herokuapp.com/invent/public/borrar";
var ruta_de_guardar=""https://paredes925.herokuapp.com/invent/public/guardar";
var ruta_de_actualizar=""https://paredes925.herokuapp.com/invent/public/actualizar";
var ruta_de_elegir=""https://paredes925.herokuapp.com/invent/public/elegir";



//local 
/*
var ruta="http://localhost:8080/invent/public/autocomplete";
var ruta_de_listar="http://localhost:8080/invent/public/product";
var ruta_de_borrar="http://localhost:8080/invent/public/borrar";
var ruta_de_guardar="http://localhost:8080/invent/public/guardar";
var ruta_de_actualizar="http://localhost:8080/invent/public/actualizar";
var ruta_de_elegir="http://localhost:8080/invent/public/elegir";

*/

//idioma de la tabla 
 var   idioma_español={
    "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
}


























                                                               

      $(document).ready(function()
       {
       listar();
       });
       //bucar productos
      
         var id=$("#prueba").val();
        $("#productos" ).autocomplete({
        source: function( request, response )
         {
          $.ajax({
          url:ruta,
          type: 'post',
          dataType: "json",
          data: {_token: CSRF_TOKEN,
                 search: request.term
                 },
          success: function( data )
                 {
                 response( data );
                 }

                 });
        },
     minLength:3,
        select: function (event, ui) {
        $('#productos').val(ui.item.label); // display the selected text

        return false;
        }

       });
      
    
     
       function listar(){ 
        var id=$("#prueba").val();
       var table=$('#tabla').DataTable({
        destroy:true,
        ajax:ruta_de_listar+'/'+id,
        columns: [
       
        { data: 'ref', name: 'ref' },
        { data: 'description', name: 'description' },
        { data: 'stock', name: 'stock' },
        { data: 'tem_stock', name: 'tem_stock' },
        { data: 'price', name: 'price' },
        {defaultContent:
        "<button class='btn btn-primary' id='editar'  data-toggle='modal' data-target='#exampleModal'> editar</button> <button class='btn btn-danger' id='eliminar'  data-toggle='modal' data-target='#eli'> eliminar</button>",orderable: false, searchable: false}
        ],
        "language":idioma_español
          
       });
       obtener_datos_eliminar("#tabla tbody", table);
       obtener_datos("#tabla tbody", table);
       }
       
       //funcion para obtener los datos de la fila para editar stock
      function  obtener_datos(tbody,table){
      $(tbody).on("click","#editar",function(){
      var $tr = $(this).closest('tr');
      var data = $('#tabla').DataTable().row($tr).data();
      var fk_product = $("#id").val( data.fk_product );
      var ref = $("#ref").val( data.ref );
      var description = $("#description").val( data.description );
      });
      }
      //funcion para obtener los datos de la fila y eliminar el producto
      function  obtener_datos_eliminar(tbody,table){
      $(tbody).on("click","#eliminar",function(){
       var $tr=$(this).closest('tr');
       var data=$('#tabla').DataTable().row($tr).data();

      var fk_product = $("#eliminer_input").val( data.rowid );   
      $("#p_product").text(data.ref ); 
      $("#p_description").text(data.description ); 
      
      });
      }


      $("#select").change(function(e){
       e.preventDefault();
       var valor=this.value;
       $.ajax({
       type:'POST',
       url:ruta_de_elegir,
       data:{valor:valor, _token:CSRF_TOKEN},
       success:function(response){
       $('#prueba').val($("#select").val());
       $("#almacen").hide();
      //  $('#inventario').val($("#servicio option:selected").text());
            $("#inventario_de_almacen").text( $( "#select option:selected" ).text());
     $("#inventario_de_almacen").show();

      listar();
     
       },
       error:function(error){
       console.log(error);
       alert('Error al escoger el almacen intente de nuevo');
       }
       });
       });
       //funcion para limpiar las cajas de texto
       function limpiar(){
         var ref_f= $("#stock").val('');
        var cheacar= $("#productos").val('');
       }

       //ajax para eliminar el articulo por medio del meto DELETE
       $('#btn-eliminar').on('click',function(e){
       e.preventDefault();
       var id=$("#eliminer_input").val();
       $.ajax({
       type:'DELETE',
       url:ruta_de_borrar+'/'+id,
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

       //ajax para agreagar articulo a la cuenta del inventario
       $('#myform').on('submit',function(e){
       e.preventDefault();
        var id=$("#prueba").val();
        var productos=$("#productos").val();
         var expresiones=productos.match(/^[a-zA-Z0-9]+$/);
       if (id==0) {
        alert("seleccione un almacen primero para poder empezar con el inventario");
        $("#select").focus(); 
        return false;
       }

        if (productos== "") {
         $("#alerta_de_error").show();
        $("#alerta_de_error").text("Ingrese un articulo");
         $("#productos").focus(); 
         return false;
       }
       if (!expresiones) {
        $("#alerta_de_error").show();
        $("#alerta_de_error").text("El nombre del articulo esta mal escrito");
        $("#productos").focus(); 
        return false;
       }
       $.ajax({
       type:'POST',
       url:ruta_de_guardar,
       data:$('#myform').serialize(),
       success:function(response){
       console.log(response);
       limpiar();
       $("#alerta_de_error").hide();
       listar();
       },
       error:function(error){
       console.log(error);
       alert('EL articulo ingresado no existe en el almacen');
       }
       });
     
       });



    


       $('#actualizar').on('click',function(e){
     
        e.preventDefault();
  
        var id=$("#id").val();
        var stock=$("#stock").val();

           var stock=$("#stock").val();
    
     var decimal = stock.match(/^\d{0,5}(?:\.\d{0,2}){0,1}$/);
    if($("#stock").val() == ""){
      $("#mensaje").show();
        $("#mensaje").text("debe ingresar una cantidad para actualizar el stock");
        $("#stock").focus();    
       return false;

    }
    
    if (!decimal) {
      $("#mensaje").show();
   $("#mensaje").text("Error, Recuerda que los formatos de ingreso son."+"\n"+ 
    "Para articulos que se vendende por gramo : "+"\n"+
    "(23.75) , (1,2,3) , (0.5) "  +"\n"+
     "(recuerda que  puede ir una  o dos cifras despues del  punto decimal) "+
     "\n"+ "Para articulos que se vendende por pieza : "+"\n"+
     "Numeros del 1,2,3,,4,5,6,7,8 ect,");
     $("#stock").focus(); 
     return false;
      }


       $.ajax({
        type:'PUT',
        url:ruta_de_actualizar+'/'+id,
        data:$('#formAct').serialize(),
        success:function(response){
        console.log(response);
        $('#exampleModal').modal('hide');
         $("#mensaje").hide();
        limpiar();
        listar();
        },
        error:function(msj){
          console.log(msj.responseJSON.errors.stock);
       alert('Error intentelo mas tarde');
        $("#mensaje").show();
        $("#mensaje").text(msj.responseJSON.errors.stock);
         
       }
       });
       });

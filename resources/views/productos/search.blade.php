<html>
  
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
      <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

    <body>
<div>


  
    <!-- For displaying selected option value from autocomplete suggestion -->
</div>

    <!-- Script -->
 
<script
   src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>



    <script type="text/javascript">

    // CSRF Token
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
  </body>
</html>
</html>
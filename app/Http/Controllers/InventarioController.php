<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\productos;
use App\reportes;
use App\inventario_tem;
use App\Stock;
use App\Resagados;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade as PDF;
use DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class InventarioController extends Controller
{
   public function index(Request $request){

 
  
    
   $select=$request->get("select_almacen");
    $datos['almacenes']= DB::table('llx_entrepot')->paginate(6); 
     $reportes['reportes']=reportes::where('fk_entrepot', '=',$select)->orderBy('id','desc')->get();
    return view('productos.reportes', $datos,$reportes); 
   }

   
   public function show ($id){


if(Storage::exists('public/pdf/'.$id)){
 return Storage::response('public/pdf/'.$id);
}else
{
  return "El archivo no existe ";
}
   
}


public function manual(){

return Storage::response('public/Manual.pdf');

}


   
   


 public function actualizar(Request $request){



  $data=$request->get('almacen');
  $hoy=date("Y-m-d");


  $count = inventario_tem::where('fk_entrepot','=',$data)->count();
  if ($count==0) {
    return 1;
  }

  //comprar que se exixta un reporte de inventario
$reporte=reportes::where('fecha','=',$hoy)->where('fk_entrepot','=',$data)->first(); 

if($reporte==null){
  return 2;
}






// borrar datos de rezagados en casa de que en el ultimo inventario no fueran borrados para introducir los nuevos valores y no alla sobre escritura de los datos 

if (Resagados::where('fk_entrepot','=',$data )->exists()) {

   Resagados::where('fk_entrepot','=' ,$data)->delete(); 

}



 //busqueda de los artilos no contados duarante el inventario (rezagados)
$Resagados=Stock::leftJoin('llx_inventary_temp', 'llx_product_stock.rowid', '=', 'llx_inventary_temp.fk_stock')->select('llx_product_stock.reel','llx_product_stock.rowid','llx_product_stock.fk_product','llx_product_stock.fk_entrepot')->where('llx_product_stock.fk_entrepot','=',$data  )->whereNull('llx_inventary_temp.fk_stock')->get();

//insercion de los  datos a la tabla Rezagados para el respaldo de los productos no contados por perdida o no encotrados en el almacen 
foreach ($Resagados as $key) {
  $Resagados = new Resagados();
                $Resagados->reel=$key->reel;
                $Resagados->fk_product=$key->fk_product;
                $Resagados->fk_entrepot=$key->fk_entrepot;
                $Resagados->fk_product_stock=$key->rowid;
                $Resagados->save();
}

      
 // actualizacion de los articulos  contados  duarante el inventario a su respectivo almacen
$x=Stock::join('llx_inventary_temp','llx_product_stock.rowid','=','llx_inventary_temp.fK_stock')->select('llx_product_stock.rowid','llx_inventary_temp.stock','llx_product_stock.reel','llx_inventary_temp.fk_product','llx_inventary_temp.tem_stock')->where('llx_product_stock.fk_entrepot', '=',$data  )->get();
foreach($x as $value){
    $actualiza=Stock::where('rowid','=',$value->rowid)->update(['reel'=>$value->tem_stock]);
}


    //eliminacion de los articulos contados duarante el inventario del almacen
   inventario_tem::where('fk_entrepot','=',$data)->delete();

return 3;
}



 public function  Exportpdf( Request $request){
  $select = $request->get("select_almacen");

               $name=time().'.'.'pdf';
                $hoy=date("Y-m-d");
         $data= DB::table('llx_inventary_temp')->select(DB::raw('ref,description, price,stock, tem_stock , (tem_stock-stock) as diferencia , ((tem_stock-stock)*price) AS pesos'))->where('fk_entrepot','=',$select)->get();
               $fecha=date("Y-m-d");








    $almacen=  Almacen::select('lieu')->where('rowid','=',$select)->get();
     

   $count = inventario_tem::where('fk_entrepot','=',$select)->count();


if ($count==0) {
     if (reportes::where('fk_entrepot', '=',$select)->where('fecha', '=',$hoy)->exists()) {
        $consulta=reportes::select('id','report')->where('fecha', '=',$hoy )->where('fk_entrepot','=',$select)->get();
      Storage::delete('public/pdf/'.$consulta[0]['report']);
      $productos=reportes::where('id','=',$consulta[0]['id'])->delete();
     }
  return 1;
 
}else if(reportes::where('fk_entrepot', '=',$select)->where('fecha', '=',$hoy)->exists()){           $consulta=reportes::select('id','report')->where('fecha', '=',$hoy )->where('fk_entrepot','=',$select)->get();



Storage::delete('public/pdf/'.$consulta[0]['report']);
 $productos=reportes::where('id','=',$consulta[0]['id'])->delete();
  


 

  $reportes = new reportes();
$reportes->fk_entrepot=$request->get("select_almacen");
$reportes->report=$name;
$reportes->fecha=$hoy;
$reportes->almacen= $almacen[0]['lieu'];
$reportes->save();
 $pdf=PDF::loadView('productos.pdf',compact('data','fecha','almacen'))->setPaper('a4', 'landscape')->save(storage_path('app/public/pdf/') .$name);


return 3;
}else{
          
$reportes = new reportes();

$reportes->fk_entrepot=$request->get("select_almacen");
$reportes->report=$name;
$reportes->fecha=$hoy;
 $reportes->almacen= $almacen[0]['lieu'];
$reportes->save();
 $pdf=PDF::loadView('productos.pdf',compact('data','fecha','almacen'))->setPaper('a4', 'landscape')->save(storage_path('app/public/pdf/') .$name);



return 2;





            }
 




   }
}


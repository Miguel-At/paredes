<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\productos;
use App\reportes;
use App\inventario_tem;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade as PDF;
use DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class InventarioController extends Controller
{
   public function index(Request $request){

     $data=reportes::where('fk_entrepot', '=',2)->orderBy('id','desc')->get();
  
    
   $select=$request->get("select_almacen");
    $datos['almacenes']= DB::table('llx_entrepot')->where('rowid', '!=', 1 ,'AND', 'lieu', '!=', 'ALMACEN PRINCIPAL')->paginate(5); 
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


 public function actualizar(Request $request){



  $data=$request->get('almacen');
  
 
   $selection=Stock::join('llx_inventary_temp','llx_product_stock.rowid','!=','llx_inventary_temp.fK_stock')->select('llx_inventary_temp.stock','llx_product_stock.reel','llx_inventary_temp.fk_product')->where('llx_product_stock.fk_entrepot', '=',$data  )->get();
  //update(['-llx_product_stock.reel' => 'llx_inventary_temp.stock']);


   return $selection;





  //Stock::where('fk_entrepot', 2) ->update(['reel' => 1]);


 }


      










 public function  Exportpdf( Request $request){
  $select = $request->get("select_almacen");

               $name=time().'.'.'pdf';
                $hoy=date("Y-m-d");
         $data= DB::table('llx_inventary_temp')->select(DB::raw('ref,description, price,stock, tem_stock , (tem_stock-stock) as diferencia , ((tem_stock-stock)*price) AS pesos'))->where('fk_entrepot','=',$select)->get();
              /* $data= DB::table('llx_inventary_temp')
            ->join('llx_entrepot', 'llx_inventary_temp.fk_entrepot', '=', 'llx_entrepot.rowid')->select(DB::raw('llx_entrepot.lieu,llx_inventary_temp.ref,llx_inventary_temp.description, llx_inventary_temp.price,llx_inventary_temp.stock, llx_inventary_temp.tem_stock , (llx_inventary_temp.tem_stock-llx_inventary_temp.stock) as diferencia , ((llx_inventary_temp.tem_stock-llx_inventary_temp.stock)*price) AS pesos'))->where('fk_entrepot','=',$select)->get();*/
               $fecha=date("Y-m-d");








    $almacen=  Almacen::select('lieu')->where('rowid','=',$select)->get();
     
  $almacen[0]['lieu'];

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


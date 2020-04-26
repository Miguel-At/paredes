<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidarRequest;
use App\inventario_tem;
use App\productos;

use DB;
use DataTables;
use Session;


class Almacen extends Controller
{

        public function elegir(request $request)
        {
       $select = $request->get("valor");
       $request->session()->put('almacen',$select);
       return  $value =$request->session()->get('almacen');
       }

       public function index(Request $request)
       {
       $datos['almacenes']= DB::table('llx_entrepot')->paginate(6);
         return view('productos.invent',$datos);
        }


    function fetch(Request $request)
       {
     $search = $request->search;
     $productos = productos::select('ref')->where('ref', 'like', '%' .$search . '%')->limit(10)->get();
      $response = array();
      foreach($productos as $product){
       $response[] = array("label"=>$product->ref);
      }
      echo json_encode($response);
      exit;
      }

        public function store(Request $request)
         {



          $datos=request()->except('_token');
          $value =session()->get('almacen');
          $selection=productos::join('llx_product_stock','llx_product_stock.fk_product','=','llx_product.rowid')->select('llx_product.rowid','llx_product_stock.fk_entrepot','llx_product.description','llx_product_stock.reel','llx_product.ref','llx_product.price','llx_product_stock.rowid as fk_stock')->where('llx_product.ref', '=',$datos  )->where('llx_product_stock.fk_entrepot', '=',$value )->get();

               

            if(inventario_tem::where('ref', '=',$datos)->where('fk_entrepot', '=',$value )->exists()){
              $increment=inventario_tem::where('ref','=',$datos)->increment('tem_stock');
             }else{
                 
                $inventario = new inventario_tem();
                $inventario->fk_product=$selection[0]["rowid"];
                $inventario->fk_entrepot=$selection[0]["fk_entrepot"];
                $inventario->description=$selection[0]["description"];
                $inventario->stock=$selection[0]["reel"];
                $inventario->tem_stock=$selection[0]["stock"]=1;
                $inventario->ref=$selection[0]["ref"];
                $inventario->price=$selection[0]['price'];
                $inventario->fk_stock=$selection[0]['fk_stock'];

                $inventario->save();
                }
          }



          public function update(ValidarRequest $request,$id )
           {
             $validated = $request->validated();
           $value =session()->get('almacen');
          $datos=$request->input('stock');
          $actualiza=inventario_tem::where('fk_product',$id)->where('fk_entrepot','=',$value)->update(['tem_stock'=>$datos]);
           }

     
            public function destroy($id){
            $value =session()->get('almacen');
             $productos=inventario_tem::where('rowid',$id)->where('fk_entrepot','=',$value)->delete();
             return 'eliminado';
             }
    
         function mostrar($id){
          
          $datos = inventario_tem::select([ 'rowid','fk_product', 'ref', 'description', 'stock','tem_stock','price'])->where('fk_entrepot','=',$id);
        return Datatables::of($datos) ->make(true);        
            }
 
}

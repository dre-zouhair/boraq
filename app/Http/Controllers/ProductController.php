<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductClient;
use App\ProductSerial;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Sodium\add;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::latest()->get();
            $datas = Array();
            foreach ($data as $key => $value){
                $datas[$key]['id'] = $value->id;
                $datas[$key]['P_name'] = $value->P_name;
                $datas[$key]['P_I_price'] = $value->P_I_price;
                $datas[$key]['P_count'] = $value->P_count;
                $datas[$key]['en_stock'] =$value->P_count - DB::table('products')
                    ->join('product_serials', 'products.id', '=', 'product_serials.product_id')
                    ->join('product_clients', 'product_serials.id', '=', 'product_clients.product_serial_id')
                    ->where('products.id','=',$value->id)
                    ->count();
                $datas[$key]['P_T_cost'] = $value->P_T_cost;
                $datas[$key]['P_S_price'] = $value->P_S_price;
                $datas[$key]['admin'] = User::find($value->admin_id)->name;
            }
            if(sizeof($datas)==0) $datas = [];
            return Datatables($datas)
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row['id'].'" data-original-title="Edit"  class="edit btn btn-warning btn-sm editProduct">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row['id'].'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data = $request->except('_token','field_name','Product_id');
       $data['admin_id'] = Auth::user()->getAuthIdentifier();
       $product = new Product($data);
       $product->save();
        foreach ($request->input('field_name') as $key => $value){
            if($key > 0 && $value){
                ProductSerial::create([
                    'product_id'=>$product->id,
                    'P_serial' => $value
                ]);
            }
        }
        $response = ['success'=>true, 'data'=>'user created successfully'];
        return response()->json($response, 201);
        $response = ['success'=>false, 'data'=>'Couldn\'t create user'];
        return response()->json($response, 400);

    }

    public function edit(Request $request)
    {
        /*
         'en_stock' => $product->P_count - DB::table('products')
                    ->join('product_serials', 'products.id', '=', 'product_serials.product_id')
                    ->join('product_clients', 'product_serials.id', '=', 'product_clients.product_serial_id')
                    ->where('products.id','=',$product->id)
                    ->count()
        */
        $id = $request->input('id');
        $product = Product::find($id);
        $output = array(
            'id'=>$product->id,
            'P_name'=>$product->P_name,
            'P_I_price'=>$product->P_I_price,
            'P_count'=> $product->P_count,
            'P_T_cost'=>$product->P_T_cost,
            'P_S_price'=> $product->P_S_price,
            'serials' => DB::select('Select id,"P_serial" from product_serials s where product_id = '.$product->id.' EXCEPT Select sa.id , sa."P_serial" from product_clients ca join product_serials sa on ca."product_serial_id" = sa.id'),
            'disabled_serials'=>DB::select('select id,"P_serial" from product_serials where product_id = '.$product->id.' and id not in (Select id from product_serials s where product_id = '.$product->id.' EXCEPT Select sa.id from product_clients ca join product_serials sa on ca."product_serial_id" = sa.id)') ,

        );
        echo json_encode($output);
    }

    public function update(Request $request)
    {

        $product_data = $request->except('_token','serials','Product_id');
        $new_serials = Array();
        $old_serials = Array();

            foreach ($request->input('serials') as $id){
                    if($id['id'] == -1 ){
                        array_push($new_serials , $id['serial']);
                    }
                  else
                  {
                      array_push( $old_serials,$id['id']);
                      ProductSerial::find($id['id'])->update([
                            'P_serial' => $id['serial']
                      ]);
                  }
        }

        ProductSerial::select('id')->where('product_id',$request->input('Product_id'))->whereNotIn('id', $old_serials)->delete();
        foreach($new_serials as $value){
            ProductSerial::create([
               'product_id'=>$request->input('Product_id'),
                'P_serial'=>$value
            ]);
        }
        Product::find($request->input('Product_id'))->update($product_data);
        return response()->json(Product::find($request->input('Product_id')), 201);

        if ($product->save())
        {
            $response = ['success'=>true, 'data'=>'product created successfully'];
            return response()->json($response, 201);
        }
        else{
            $response = ['success'=>false, 'data'=>'Couldn\'t create product'];
            return response()->json($response, 400);
        }
    }

    public function destroy(Request $request)
    {
        $serials = ProductSerial::all()->where('product_id',$request->input('id'));
        ProductSerial::deleted($serials);
        Product::destroy($request->input('id'));
        echo json_encode(['success'=>true]);
    }

    public function AllSerials(Request $request){
        if ($request->ajax()) {
           return ProductSerial::select('P_serial')->where('product_id',$request->input('id'))->get();
        }
    }
    public function available(){

            $data = Product::latest()->get();
            $datas = Array();
            foreach ($data as $key => $value){
                if ( $value->P_count - DB::table('products')
                        ->join('product_serials', 'products.id', '=', 'product_serials.product_id')
                        ->join('product_clients', 'product_serials.id', '=', 'product_clients.product_serial_id')
                        ->where('products.id','=',$value->id)
                        ->count() > 0 ){
                    $datas[$key]['id'] = $value->id;
                    $datas[$key]['P_name'] = $value->P_name;
                    $datas[$key]['P_I_price'] = $value->P_I_price;
                    $datas[$key]['en_stock'] =$value->P_count - DB::table('products')
                            ->join('product_serials', 'products.id', '=', 'product_serials.product_id')
                            ->join('product_clients', 'product_serials.id', '=', 'product_clients.product_serial_id')
                            ->where('products.id','=',$value->id)
                            ->count();
                    $datas[$key]['P_T_cost'] = $value->P_T_cost;
                    $datas[$key]['P_S_price'] = $value->P_S_price;
                }

            }
            if(sizeof($datas)==0) $datas = [];
            return Datatables($datas)
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row['id'].'" data-original-title="Edit"  class="edit btn btn-success btn-sm addPanel">Add to panel</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }
}

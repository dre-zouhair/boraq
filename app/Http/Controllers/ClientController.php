<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Client;
use App\Product;
use App\ProductClient;
use App\ProductSerial;
use App\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Client::latest()->get();
            $datas = Array();
            foreach ($data as $key => $value){
                $datas[$key]['id'] = $value->id;
                $datas[$key]['C_name'] = $value->C_name;
                $datas[$key]['C_identifier'] = $value->C_identifier;
                $datas[$key]['C_type'] = $value->C_type;
            }
            if(sizeof($datas)==0) $datas = [];
            return Datatables($datas)
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row['id'].'" data-original-title="Display" class="display btn btn-primary btn-sm displayClient">Display History</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function history(Request $request)
    {
        $data = Bill::all()->where('client_id',$request->input('Client_id'));
        $datas = Array();
        foreach ($data as $key => $value){
            $datas[$key]['id'] = $value->id;
            $datas[$key]['user'] = User::find($value->user_id)->name;
            $datas[$key]['value'] = ProductClient::all()->where('bill_id',$value->id)->sum('P_S_price');
            $datas[$key]['payment_method'] = $value->Payment_type;
            $datas[$key]['date'] =  \Carbon\Carbon::parse($value->created_at)->format('d/m/Y');
        }
        if(sizeof($datas)==0) $datas = [];
        return Datatables($datas)
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row['id'].'" data-original-title="Display" class="display btn btn-primary btn-sm displayBill">Display Bill details</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function bill(Request $request)
    {
        $data = ProductClient::all()->where('bill_id',$request->input('Bill_id'));
        $datas = Array();
        $sum = 0;
        $key = 0 ;
        foreach ($data as  $value){
            $datas[$key]['id'] = $value->id;
            $datas[$key]['product_name'] = Product::find(ProductSerial::find($value->product_serial_id)->product_id)->P_name ;
            $datas[$key]['Product_serial'] = ProductSerial::find($value->product_serial_id)->P_serial;
            $datas[$key]['P_S_price'] = $value->P_S_price;
            $sum += $value->P_S_price;
            $key++;
        }
        if(sizeof($datas)==0) $datas = [];
        $datas[$key]['id'] = 'totale';
        $datas[$key]['product_name'] = '';
        $datas[$key]['Product_serial'] = '';
        $datas[$key]['P_S_price'] = $sum;
        return Datatables($datas)
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show(Request $request)
    {
        $val = $request->input('val');
        return response()->json(
           Product::all()->where('P_name',$val)
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}

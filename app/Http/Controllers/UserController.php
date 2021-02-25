<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = User::latest()->get();
            $datas = Array();
            foreach ($data as $key => $value){
                $datas[$key]['id'] = $value->id;
                $datas[$key]['name'] = $value->name;
                $datas[$key]['email'] = $value->email;
                }
            if(sizeof($datas)==0) $datas = [];
            return Datatables($datas)
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row['id'].'" data-original-title="Edit" class="edit btn btn-primary btn-sm editUser">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row['id'].'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // return response()->json($request, 201);
        $payload =[];
        if($request->input('is_admin')){
            $payload = [
                'name'=>$request->input('name'),
                'password'=>\Hash::make($request->password),
                'email'=>$request->email,
                'is_admin'=>1
            ];
        }
        else{
            $payload = [
                'name'=>$request->input('name'),
                'password'=>\Hash::make($request->password),
                'email'=>$request->email,
                'is_admin'=>0
            ];
        }
        $user = new  User($payload);
        if ($user->save())
        {
            $response = ['success'=>true, 'data'=>'user created successfully'];
            return response()->json($response, 201);
        }
        else
        {
            $response = ['success'=>false, 'data'=>'Couldn\'t create user'];
            return response()->json($response, 400);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);
        $output = array(
            'id'=>$user->id,
            'name'=>$user->name,
            'email'=>$user->email,
            'is_admin'=> $user->is_admin
        );
        echo json_encode($output);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $user = User::find($request->input('User_id'));

        $user->name = $request->input('name2');
        $user->email = $request->input('email2');

        if($request->input('is_admin2')){
           $user->is_admin = true;
        }
        else{
            $user->is_admin = false;
        }

        if ($user->save())
        {
            $response = ['success'=>true, 'data'=>'user created successfully'];
            return response()->json($response, 201);
        }
        else{
            $response = ['success'=>false, 'data'=>'Couldn\'t create user'];
            return response()->json($response, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::destroy($request->input('id'));
        echo json_encode(['success'=>true]);

    }
}

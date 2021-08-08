<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function index(Request $request)
    {

        $users = User::all();

        return view('user.index', compact('users'));
    }




    public function store(Request $request)
    {

       $rules= [
            'first_name' => 'required|max:255',
            'last_name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:7|max:255',
            'role' => 'required'
       ];
        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }


        $form_data = array(
            'first_name'        =>  $request->first_name,
            'last_name'         =>  $request->last_name,
            'email'             =>  $request->email,
            'password'          =>  $request->password,
            'role'              =>  $request->role
        );


        $form_data['status'] = 'active';


        User::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function show(Request $request)
    {

        //
        if ($request->ajax()) {
            $data = User::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($data) {
                    error_log($data->status== 'active');
                    if($data->status == 'active'){

                        return '<label class="badge bg-success">Active</label>';
                    }else{
                        return '<label class="badge bg-danger">Inactive</label>';
                    }
                })
                ->addColumn('action', function ($row) {

                    $button = '<button type="button" name="edit" id="' . $row->id . '" class="edit btn btn-primary btn-sm">'.__("translation.edit").'</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="' . $row->id . '" class="delete btn btn-danger btn-sm">'.__("translation.delete").'</button>';
                    return $button;
                })

                ->rawColumns(['status','action'])
                ->make(true);
        }
    }


    public function edit($id)
    {
        //
        if(request()->ajax())
        {
            $data = User::findOrFail($id);
            return response()->json(['result' => $data]);
        }


    }



    public function update(Request $request, $id)
    {
        //
        if(request()->ajax())
        {

        $rules= [
            'first_name' => 'required|max:255',
            'last_name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:7|max:255',
            'role' => 'required'
       ];
        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

            $data = User::findOrFail($id);
            $data["first_name"]= $request->first_name;
            $data["last_name"]= $request->last_name;
            $data["email"]= $request->email;
            $data["role"]= $request->role;

            if (!empty($request->password)) {
                # code...
                $data["password"]= $request->password ;

            }

            $data->save();


            return response()->json(['success' => 'Data Edited successfully.']);

        }
    }


    public function destroy(Request $request)
    {

        $user = User::where('id',$request->id)->delete();
        return Response()->json($user);
    }
}

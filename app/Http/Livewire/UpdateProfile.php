<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\Validation\ValidationException;


class UpdateProfile extends Component
{



    public $userDetails;
    public $first;
    public $user;
    public $oldPassword;
    public $newPassword;
    public $confirmPassword;


    public function render()
    {
        $this->fetchUserData();

        return view('livewire.update-profile',['arr'=>'']);


    }
    public function fetchUserData(){
            // Get current user
            $userId = Auth::id();
            $this->user= User::findOrFail($userId);

            $this->userDetails = array(
                'first_name'        =>   $this->user["first_name"],
                'last_name'         =>   $this->user["last_name"],
                'email'             =>   $this->user["email"],


            );

    }
    public function update($data){

        $validated = $this->validate([
            'userDetails.first_name'=>'required',
            'userDetails.last_name'=>'required',
            'userDetails.email'=>'required',

        ]);

        $this->user->update($validated['userDetails']);
           // Validate the data submitted by user
        //    $validator = Validator::make($request->all(), [
        //     'name' => 'required|max:255',
        //     'email' => 'required|email|max:225|'. Rule::unique('users')->ignore($user->id),
        // ]);

        // // if fails redirects back with errors
        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        // // Fill user model
        // $user->fill([
        //     'name' => $request->name,
        //     'email' => $request->email
        // ]);

        // // Save user to database
        // $user->save();
    }

    public function updatePassword($data){
        // dd();

        $userid = Auth::id();

        $this->validate([
            'oldPassword'=>'required',
            'newPassword'=>'required|min:6',
            'confirmPassword'=>'required|same:newPassword',

        ]);
        if ((Hash::check( $data["old_password"] , Auth::user()->password)) == false) {
            // $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
                $error =['error' => "Check your old password."];
                throw ValidationException::withMessages(['error' => $error]);

        } else if ((Hash::check($data["new_password"], Auth::user()->password)) == true) {
            // $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
                $error =['error' => "Please enter a password which is not similar then current password."];
                throw ValidationException::withMessages(['error' => $error]);
        } else {
            User::where('id', $userid)->update(['password' => Hash::make($data["new_password"])]);
            // $arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
            $success =['success' => "Password updated successfully."];
            throw ValidationException::withMessages(['success' => $success]);
        }

        // return Response::json($arr);
        // return back(['arr'=>$arr]);
        // dd($arr);

        // $validatedData = Validator::make(
        //     ['oldPassword' => $this->oldPassword],
        //     ['oldPassword' => 'required'],
        //     ['required' => 'The :attribute field is requiresssssd'],
        // )->validate();




    }

}

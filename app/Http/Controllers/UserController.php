<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\Photo;
use Gate;
use Kamaln7\Toastr\Facades\Toastr;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {


        if(!Gate::allows('isRoot')){

            $message = "No Permission";
            // Toastr::error($message, $title = "Permission deny", $options = []);
            Toastr::error($message, $title = "Permission deny", $options = []);
            return back();
            // abort(404,"Sorry, You can do this actions");
        }


        $users = User::all();
        return view('user.index',compact('users'));

    }

    public function changeStatus($id)
    {
        // if(!Gate::allows('isRoot')){

        //     $message = "No Permission";
        //     Toastr::error($message, $title = "Permission deny", $options = []);
        //     return back();
        // }
        // dd($id);
        $user = User::findOrFail($id);

        if($user->active == 1){
            $user->active = 0;
            $user->save();
        }else{
            $user->active = 1;
            $user->save();
        }

        $message = "Successfully Change";
        Toastr::success($message, $title = "Success Action", $options = []);
        $users = User::all();
        return view('user.index',compact('users'));

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'bail|required|unique:users|max:255',
            'user_type' => 'required|max:255',
        ]);

        $this->validate($request, [
            'photo_id' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->user_type != 'user'){
            if($request->password !== $request->password_confirmation ){

                $message = "Error please fill in corectly";
                Toastr::warning($message, $title = "Error Action", $options = []);

                $users = User::all();
                return view('user.index',compact('users'));
            }

            if(strlen($request->password)<4){

                $message = "Error please fill in password more than 4 characters";
                Toastr::warning($message, $title = "Error Action", $options = []);

                $users = User::all();
                return view('user.index',compact('users'));
            }

            if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$request->email))
            {

                $message = "Error please fill in email";
                Toastr::warning($message, $title = "Error Action", $options = []);

                $users = User::all();
                return view('user.index',compact('users'));
            }

            // file
            $save_photo_id = "";
            if($file = $request->file('photo_id')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $photo = Photo::create(['file'=>$name]);
                $save_photo_id = $photo->id;
            }

            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
            $user->user_type = $request['user_type'];
            $user->active = 1;
            $user->photo_id = $save_photo_id;
            $user->save();

        }else{


            // save

            // User::create($request);

            // file
            $save_photo_id = "";
            if($file = $request->file('photo_id')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $photo = Photo::create(['file'=>$name]);
                $save_photo_id = $photo->id;
            }

            $user = new User();
            $user->name = $request['name'];
            $user->email = "";
            $user->password = "";
            $user->user_type = $request['user_type'];
            $user->active = 1;
            $user->photo_id = $save_photo_id;
            $user->save();


        }



        $message = "Successfully add user";
        Toastr::success($message, $title = "Successfully Action", $options = []);

        $users = User::all();
        return view('user.index',compact('users'));
    }


    public function edit($id)
    {
        // dd($id);
        $userSelected = User::findOrFail($id);
        // dd($userSelected);
        $users = User::all();
        return view('user.edit',compact('userSelected','users'));
    }

    public function update(Request $request, $id)
    {
        $userSelected = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'bail|required|max:255',
            'user_type' => 'required|max:255',
        ]);

        $this->validate($request, [
            'photo_id' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->user_type != 'user'){
            if($request->password !== $request->password_confirmation ){

                $message = "Error please fill in corectly";
                Toastr::warning($message, $title = "Error Action", $options = []);

                // $users = User::all();
                return view('user.edit',compact('userSelected'));
            }

            if(strlen($request->password)<4){

                $message = "Error please fill in password more than 4 characters";
                Toastr::warning($message, $title = "Error Action", $options = []);

                // $users = User::all();
                return view('user.edit',compact('userSelected'));
            }

            if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$request->email))
            {

                $message = "Error please fill in email";
                Toastr::warning($message, $title = "Error Action", $options = []);

                // $users = User::all();
                return view('user.edit',compact('userSelected'));
            }

            // file
            $save_photo_id = "";
            if($file = $request->file('photo_id')) {

                //delete first
                // delete photo first
                unlink(public_path() . $userSelected->photo->file);
                $photoDatabaseToDelete = Photo::findOrFail($userSelected->photo_id);
                $photoDatabaseToDelete->delete();


                // save
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $photo = Photo::create(['file'=>$name]);
                $save_photo_id = $photo->id;

                //save new photo
                $userSelected->photo_id = $save_photo_id;
            }

            // $user = new User();
            $userSelected->name = $request['name'];
            $userSelected->email = $request['email'];
            $userSelected->password = bcrypt($request['password']);
            $userSelected->user_type = $request['user_type'];
            // $user->active = 1;
            $userSelected->save();

        }else{


            // file
            $save_photo_id = "";
            if($file = $request->file('photo_id')) {

                // delete photo first
                unlink(public_path() . $userSelected->photo->file);
                $photoDatabaseToDelete = Photo::findOrFail($userSelected->photo_id);
                $photoDatabaseToDelete->delete();

                // save
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $photo = Photo::create(['file'=>$name]);
                $save_photo_id = $photo->id;

                //save new photo
                $userSelected->photo_id = $save_photo_id;
            }

            // User::create($request);

            $userSelected->email = "";
            $userSelected->password = "";
            $userSelected->name = $request['name'];
            $userSelected->user_type = $request['user_type'];
            // $user->active = 1;
            $userSelected->save();


        }



        $message = "Successfully edit user";
        Toastr::success($message, $title = "Successfully Action", $options = []);

        $users = User::all();
        return view('user.index',compact('users'));
    }
}

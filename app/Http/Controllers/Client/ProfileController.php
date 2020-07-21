<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $user = auth()->user();
        return view('private.client.profile',compact('user'));
    }

    public function upload(Request $request)
    {
        $user = auth()->user();

        $photoable_type = 'App\User';

        $photoable_id = $user->id;

        if($image = $request->file('image'))
        {
            $rules = [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];

            $this->validate($request,$rules);
            
            $file_to_store = time() . "_" . $user->first_name . "_" . "." . $image->getClientOriginalExtension();

                if($user->photo)
                {
                    $filename = $user->photo->filename;
                    $user->photo->delete();
                    unlink('images/'.$filename);
                    if($user->photo()->create(['filename' => $file_to_store , 'photoable_type' => $photoable_type , 'photoable_id' => $photoable_id]) );
                    {
                        $image->move('images', $file_to_store);
                    }
                }

                else
                {
                    if($user->photo()->create(['filename' => $file_to_store , 'photoable_type' => $photoable_type , 'photoable_id' => $photoable_id]) );
                    {
                        $image->move('images', $file_to_store);
                    }
                }

                return back()->withStatus(__('image successfully updated.'));
        }
        else
        {
            return redirect('/admin/profile');
        }
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }

}

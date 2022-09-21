<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profile(Request $request, $id)
    {
        $user = User::find($id);
        return view('auth.profile', compact('user'));
    }

    public function editProfile(Request $request, $id)
    {
        $user = User::find($id);
        return view('auth.editprofile', compact('user'));
    }

    public function updateProfile(Request $request, User $users, $id)
    {
        $user = $users->find($id);

        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required | digits:10',
            'address' => 'required|string| max:255',
            'gender' => 'required',
            'hobbies' => 'required',
            'profile_image' => 'required'
        ]);

<<<<<<< HEAD
        $profile_image = $request->profile_image;
        //generate unique id for image
        $name_gen = hexdec(uniqid());
=======

        $profile_image = $request->file('profile_image');
>>>>>>> 75e8c80b041ae0f7c7d5194d684866786b0b219d

        if ($profile_image) {
            //generate unique id for image
            $name_gen = hexdec(uniqid());

<<<<<<< HEAD
=======
            //image extention
            $img_ext = strtolower($profile_image->getClientOriginalExtension());
            $img_name = $name_gen . '.' . $img_ext;
            $up_location = 'image/post/';
            $last_img = $up_location . $img_name;
            $profile_image->move($up_location, $img_name);

            $user->update([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'image' => $last_img,
                'hobbies' => $request->hobbies,
                'gender' => $request->gender,
                'updated_at' => Carbon::now()
            ]);

            return redirect()->route('post.index')
                ->with('success', 'Post updated successfully');
        } else {
            $user->update([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'hobbies' => $request->hobbies,
                'gender' => $request->gender,
                'updated_at' => Carbon::now()
            ]);
        }

        $email_data = array(
            'name' => $user['name'],
            'mobile' => $user['mobile'],
            'address' => $user['address'],
            'gender' => $user['gender'],
        );
>>>>>>> 75e8c80b041ae0f7c7d5194d684866786b0b219d

        Mail::send('welcome_email', $email_data, function ($message) use ($email_data) {
            $message->to($email_data['name'], $email_data['mobile'], $email_data['address'], $email_data['gender'])
                ->subject('Welcome to System')
                ->from('admin@gmail.com');
        });

        return redirect('/profile/' . $request->user_id);
    }
}

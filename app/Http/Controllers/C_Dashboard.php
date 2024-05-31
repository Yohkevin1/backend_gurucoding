<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class C_Dashboard extends Controller
{
    public function index()
    {
        if (session('user.role') == 'mentor') {
            $data = Mentor::where('id_user', session('user.id'))->first();
            return view('dashboard_mentor', compact('data'));
        } else {
            $mentors = Mentor::with('user')->get();
            return view('dashboard_admin', compact('mentors'));
        }
    }

    public function resetPass(Request $request, $email)
    {
        $credentials = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed|regex:/^(?:(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{10,})$/',
        ], [
            'password.regex' => 'Password harus terdiri dari huruf kecil, huruf besara, angka, dan simbol',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        if ($credentials->fails()) {
            return back()->with(['message' => $credentials->errors()->first(), 'alert-type' => 'error']);
        }

        $email = decrypt($email);
        User::where('email', $email)->update([
            'password' => bcrypt($request->password),
        ]);
        return back()->with(['message' => 'Password Berhasil Dirubah', 'alert-type' => 'success']);
    }

    public function updateEmail(Request $request, $email)
    {
        $credentials = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($credentials->fails()) {
            return back()->with(['message' => $credentials->errors()->first(), 'alert-type' => 'error']);
        }

        $email = decrypt($email);
        User::where('email', $email)->update([
            'email' => $request->email,
        ]);

        session()->put('user.email', $request->email);

        return back()->with(['message' => 'Email Berhasilh Dirubah', 'alert-type' => 'success']);
    }

    public function destroyMentor($id)
    {
        $id = decrypt($id);
        $mentor = Mentor::where('id', $id)->first();
        if ($mentor->image != 'img_empty.gif' && $mentor->image != "") {
            File::delete('mentor/img/' . $mentor->image);
        }
        if ($mentor->cv != 'cv_empty.pdf' && $mentor->cv != "") {
            File::delete('mentor/cv/' . $mentor->cv);
        }
        $user = User::where('id', $mentor->id_user)->first();
        $mentor->forceDelete();
        $user->forceDelete();
        return back()->with(['message' => 'Mentor Berhasilh Dihapus', 'alert-type' => 'success']);
    }

    public function detailMentor($id)
    {
        $id = decrypt($id);
        $data = Mentor::where('id', $id)->with('user')->first();
        return view('detailMentor', compact('data'));
    }
}

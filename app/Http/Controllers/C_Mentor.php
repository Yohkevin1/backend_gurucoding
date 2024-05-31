<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class C_Mentor extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'description' => 'required',
            'phone' => 'required|max:15',
            'skills' => 'required|max:250',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:3072',
            'cv' => 'nullable|mimes:pdf|max:3072',
            'status' => 'required|max:15',
            'alamat' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->with(['message' => $validator->errors()->first(), 'alert-type' => 'error']);
        }

        $data = Mentor::where('id_user', session('user.id'))->first();
        if (!$data) {
            return back()->with(['message' => 'Akun Tidak Terdaftar', 'alert-type' => 'error']);
        }

        $namaFileLama = $request->input('fotoLama');
        $image = $request->file('image');
        if ($image && $image->isValid()) {
            $namaFile = $image->hashName();
            $image->move('mentor/img/', $namaFile);
            if ($namaFileLama != 'img_empty.gif' && $namaFileLama != "") {
                File::delete('mentor/img/' . $namaFileLama);
            }
        } else {
            $namaFile = $namaFileLama;
        }

        $cvLama = $request->input('cvLama');
        $cv = $request->file('cv');
        if ($cv && $cv->isValid()) {
            $namaCV = $cv->hashName();
            $cv->move('mentor/cv/', $namaCV);
            File::delete('mentor/cv/' . $cvLama);
        } else {
            $namaCV = $cvLama;
        }

        $data->update([
            'name' => $request->name,
            'description' => $request->description,
            'phone' => $request->phone,
            'image' => $namaFile,
            'cv' => $namaCV,
            'skills' => $request->skills,
            'status' => $request->status,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return redirect()->back()->with(['message' => 'Successfully saved data', 'alert-type' => 'success']);
    }
}

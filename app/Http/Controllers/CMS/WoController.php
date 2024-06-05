<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\WopalModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class WoController extends Controller
{
    protected $WopalModel;

    public function __construct(WopalModel $WopalModel)
    {
        $this->WopalModel = $WopalModel;
    }

    public function getAllData()
    {
        // $user = Auth::user();
        // if ($user->role == 'admin') {
        //     $data = $this->WopalModel::where('id_user', $user->id)->get();
        //                 return response()->json([
        //     'status' => 'success',
        //     'data' => $data,
        // ], 200);
        // } else {
            $data = $this->WopalModel::all();
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ], 200);
        // }
    }

    public function createData(Request $request)
    {
        // Mendefinisikan pesan error kustom
        $messages = [
            'nama_wopal.required' => 'Nama WO harus diisi.',
            'nama_wopal.string' => 'Nama WO harus berupa teks.',
            'nama_wopal.max' => 'Nama WO tidak boleh lebih dari 255 karakter.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'no_hp.required' => 'Nomor telepon harus diisi.',
            'no_hp.string' => 'Nomor telepon harus berupa teks.',
            'no_hp.max' => 'Nomor telepon tidak boleh lebih dari 20 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong.',
            'img_wopal.image' => 'File harus berupa gambar.',
            'img_wopal.mimes' => 'File harus berformat jpeg, png, jpg, gif, atau svg.',
            'img_wopal.max' => 'Ukuran file tidak boleh lebih dari 2048 KB.',
        ];
    
        // Menambahkan validasi
        $validator = Validator::make($request->all(), [
            'nama_wopal' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'deskripsi' => 'required|string',
            'img_wopal' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar
        ], $messages);
    
        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
    
            $data = new $this->WopalModel;
            $data->nama_wopal = htmlspecialchars($request->input('nama_wopal'));
            $data->alamat = htmlspecialchars($request->input('alamat'));
            $data->no_hp = htmlspecialchars($request->input('no_hp'));
            $data->email = htmlspecialchars($request->input('email'));
            $data->img_wopal = htmlspecialchars($request->input('img_wopal'));
            $data->deskripsi = htmlspecialchars($request->input('deskripsi'));
            // $data->id_user = $user;
    
            if ($request->hasFile('img_wopal')) {
                $file = $request->file('img_wopal');
                $extension = $file->getClientOriginalExtension();
                $filename = 'wopal-profile-' . Str::random(15) . '.' . $extension;
                Storage::makeDirectory('uploads/wopal_profile');
                $file->move(public_path('uploads/wopal_profile'), $filename);
                $data->img_wopal = $filename;
            }
    
            $data->save();
    
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => $e
            ], 400);
        }
    }

    
  

    public function updateData(Request $request, $id)
    {
        // Mendefinisikan pesan error kustom
        $messages = [
            'nama_wopal.required' => 'Nama WO harus diisi.',
            'nama_wopal.string' => 'Nama WO harus berupa teks.',
            'nama_wopal.max' => 'Nama WO tidak boleh lebih dari 255 karakter.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'no_hp.required' => 'Nomor telepon harus diisi.',
            'no_hp.string' => 'Nomor telepon harus berupa teks.',
            'no_hp.max' => 'Nomor telepon tidak boleh lebih dari 20 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong.',
            'img_wopal.image' => 'File harus berupa gambar.',
            'img_wopal.mimes' => 'File harus berformat jpeg, png, jpg, gif, atau svg.',
            'img_wopal.max' => 'Ukuran file tidak boleh lebih dari 2048 KB.',
        ];
    
        // Menambahkan validasi
        $validator = Validator::make($request->all(), [
            'nama_wopal' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'deskripsi' => 'required|string',
            'img_wopal' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar
        ], $messages);
    
        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }
    
        try {
            $data = $this->WopalModel::find($id);
    
            if (!$data) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data not found.'
                ], 404);
            }
    
            $data->nama_wopal = htmlspecialchars($request->input('nama_wopal'));
            $data->alamat = htmlspecialchars($request->input('alamat'));
            $data->no_hp = htmlspecialchars($request->input('no_hp'));
            $data->email = htmlspecialchars($request->input('email'));
            $data->deskripsi = htmlspecialchars($request->input('deskripsi'));
    
            // Check if a new image file is uploaded
            if ($request->hasFile('img_wopal')) {
                // Delete old image file
                $old_file = public_path('uploads/wopal_profile') . '/' . $data->img_wopal;
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
    
                // Upload and store new image file
                $file = $request->file('img_wopal');
                $extension = $file->getClientOriginalExtension();
                $filename = 'wopal-profile-' . Str::random(15) . '.' . $extension;
                Storage::makeDirectory('uploads/wopal_profile');
                $file->move(public_path('uploads/wopal_profile'), $filename);
                $data->img_wopal = $filename;
            }
    
            $data->save();
    
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'error' => $e
            ], 400);
        }
    }
    

    

    // public function getDataByUser()
    // {
    //     $user = Auth::user();
    //     if ($user->role == 'user') {
    //         $data = $this->WopalModel::where('id_user' , $user->id)->get();
    //         return $this->success($data);
    //     }else{
    //         $data = $this->WopalModel::all();
    //         return $this->success($data);
    //     }
    // }

    public function getDataById($id)
    {
        $data = $this->WopalModel::where('id', $id)->first();
        if (!$data) {
            return response()->json([
                'code' => 404,
                'message' => 'ID or data not found'
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ], 200);
        };
    }

    public function deleteData($id)
    {
        $data = $this->WopalModel::where('id', $id)->first();
        if (!$data) {
            return response()->json([
                'code' => 404,
                'message' => 'ID or data not found',
            ]);
        } else {
            $location = 'uploads/wopal_profile/' . $data->img_wopal;
            $data->delete();
            if (File::exists($location)) {
                File::delete($location);
            }
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
        ], 200);
    }


    
}


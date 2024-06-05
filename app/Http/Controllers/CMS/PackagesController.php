<?php

namespace App\Http\Controllers\CMS;

use App\Models\PackagesModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class PackagesController extends Controller
{
    protected $packagesModel;

    // Gunakan dependency injection untuk memasukkan model ke dalam controller
    public function __construct(PackagesModel $packagesModel)
    {
        $this->packagesModel = $packagesModel;
    }

    public function getAllData()
    {
        // Fetching data
        $data = $this->packagesModel::with('wopal')->inRandomOrder()->get();
        // Checking if data is empty
        if ($data->isEmpty()) {
            return response()->json([
                'code' => 404,
                'message' => 'Data not found'
            ]);
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $data
            ]);
        }
    }

    public function getAllDataByWO()
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            $data = $this->packagesModel::with('wopal')->where('id_user', $user->id)->get();
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $data
            ]);
        } else {
            $data = $this->packagesModel::with('wopal')->get(); // Adjusted to eager load 'wopal' relationship
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $data
            ]);
        }
    }
    
    
    
    public function getDataPacketByWO($id_wopal)
    {
        $data = $this->packagesModel::where('id_wopal', $id_wopal)->get();
        if (!$data) {
            return response()->json([
                    'code' => 404,
                    'message' => 'ID or data not found',
                ]);
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $data
            ]);
        };
    }


    public function createData(Request $request)
    {
        // Mendefinisikan pesan error kustom
    $messages = [
        'nama_paket.required' => 'Nama paket harus diisi.',
        'nama_paket.string' => 'Nama paket harus berupa teks.',
        'nama_paket.max' => 'Nama paket tidak boleh lebih dari 255 karakter.',
        'harga.required' => 'Harga paket harus diisi.',
        'harga.numeric' => 'Harga paket harus berupa angka.',
        'harga.min' => 'Harga paket tidak boleh kurang dari 0.',
        'deskrisi.required' => 'Deskripsi harus diisi.',
        'deskrisi.string' => 'Deskripsi harus berupa teks.',
        'gmb_paket.required' => 'Gambar paket harus diunggah.',
        'gmb_paket.image' => 'File harus berupa gambar.',
        'gmb_paket.mimes' => 'File harus berformat jpeg, png dan jpg',
        'gmb_paket.max' => 'Ukuran file tidak boleh lebih dari 2048 KB.',
    ];
        // Menambahkan validasi
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskrisi' => 'required|string',
            'gmb_paket' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
        ], $messages);
    
        try {
            // $user = Auth::user();
            $data = new PackagesModel();
            $data->nama_paket = htmlspecialchars($request->input('nama_paket'));
            $data->harga = htmlspecialchars($request->input('harga'));
            $data->deskrisi = htmlspecialchars($request->input('deskrisi'));
            $data->id_wedding = $request->input('id_wedding');
            // $data->id_user = $user->id;
    
            if ($request->hasFile('gmb_paket')) {
                $file = $request->file('gmb_paket');
                $extension = $file->getClientOriginalExtension();
                $filename = 'Paket-' . Str::random(15) . '.' . $extension;
                Storage::makeDirectory('uploads/packages');
                $file->move(public_path('uploads/packages'), $filename);
                $data->gmb_paket = $filename;
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
            'nama_paket.required' => 'Nama paket harus diisi.',
            'nama_paket.string' => 'Nama paket harus berupa teks.',
            'nama_paket.max' => 'Nama paket tidak boleh lebih dari 255 karakter.',
            'harga.required' => 'Harga paket harus diisi.',
            'harga.numeric' => 'Harga paket harus berupa angka.',
            'harga.min' => 'Harga paket tidak boleh kurang dari 0.',
            'deskrisi.required' => 'Deskripsi harus diisi.',
            'deskrisi.string' => 'Deskripsi harus berupa teks.',
            'gmb_paket.image' => 'File harus berupa gambar.',
            'gmb_paket.mimes' => 'File harus berformat jpeg, png dan jpg.',
            'gmb_paket.max' => 'Ukuran file tidak boleh lebih dari 2048 KB.',
        ];
    
        // Menambahkan validasi dengan pesan kustom
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskrisi' => 'required|string',
            'gmb_paket' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $messages);
    
        try {
            $data = $this->packagesModel::find($id);
    
            if (!$data) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Data not found.'],
                    404);
            }
    
            $data->nama_paket = htmlspecialchars($request->input('nama_paket'));
            $data->harga = htmlspecialchars($request->input('harga'));
            $data->deskrisi = htmlspecialchars($request->input('deskrisi'));
    
            // Check if a new image file is uploaded
            if ($request->hasFile('gmb_paket')) {
                // Delete old image file
                $old_file = public_path('uploads/packages') . '/' . $data->gmb_paket;
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
    
                // Upload and store new image file
                $file = $request->file('gmb_paket');
                $extension = $file->getClientOriginalExtension();
                $filename = 'Paket-' . Str::random(15) . '.' . $extension;
                $file->move(public_path('uploads/packages'), $filename);
                $data->gmb_paket = $filename;
            }
    
            $data->save();
    
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'error' => $e], 400);
        }
    }
    

    public function getDataById($id)
    {
        $data = $this->packagesModel::where('id', $id)->first();
        if (!$data) {
            return response()->json([
                    'code' => 404,
                    'message' => 'ID or data not found',
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
        $data = $this->packagesModel::where('id', $id)->first();
        if (!$data) {
            return response()->json([
                'code' => 404,
                'message' => 'ID or data not found',
            ]);
        } else {
            $location = 'uploads/packages/' . $data->gmb_paket;
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

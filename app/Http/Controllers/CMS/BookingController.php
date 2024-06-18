<?php

namespace App\Http\Controllers\CMS;

use App\Models\BookingModel;
use App\Models\PackagesModel;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    protected $bookingModel;

    // Gunakan dependency injection untuk memasukkan model ke dalam controller
    public function __construct(BookingModel $bookingModel)
    {
        $this->bookingModel = $bookingModel;
    }

    public function getAllData()
    {
        try {
            $user = Auth::user();
            $role = $user->role;

            if ($role === 'admin') {
                // Ambil data booking berdasarkan user terautentikasi yang merupakan WO
                $data = $this->bookingModel::with(['package', 'user'])
                    ->whereHas('package', function ($query) use ($user) {
                        $query->whereHas('wopal', function ($q) use ($user) {
                            $q->where('id_user', $user->id);
                        });
                    })->get();
            } elseif ($role === 'super_admin') {
                // Ambil semua data booking
                $data = $this->bookingModel::with(['package', 'user'])->get();
            } else {
                return response()->json([
                    'code' => 403,
                    'message' => 'Forbidden. You do not have permission to access this resource.'
                ]);
            }

            if ($data->isEmpty()) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Data not found'
                ]);
            } else {
                return response()->json([
                    'code' => 200,
                    'message' => 'Success',
                    'data' => $data
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Failed to retrieve booking data: ' . $e->getMessage()
            ]);
        }
    }
    
    public function createData(Request $request)
    {
        $messages = [
            'catatan.required' => 'Catatan harus diisi.',
            'catatan.string' => 'Catatan harus berupa teks.',
            'tgl_nk.required' => 'Tanggal harus diisi.',
            'tgl_nk.date' => 'Tanggal harus berupa tanggal.',
            'id_user.required' => 'User harus dipilih.',
            'id_user.exists' => 'User tidak valid.',
            'id_package.required' => 'Paket harus dipilih.',
            'id_package.exists' => 'Paket tidak valid.',
        ];
    
        // Validasi input
        $validator = Validator::make($request->all(), [
            'catatan' => 'required|string',
            'tgl_nk' => 'required|date',
            'id_user' => 'required|exists:users,id',
            'id_package' => 'required|exists:tb_packages,id',
        ], $messages);
    
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }
    
        try {
            $data = new $this->bookingModel;
            $data->catatan = $request->input('catatan');
            $data->tgl_nk = $request->input('tgl_nk');
            $data->id_user = $request->input('id_user');
            $data->id_package = $request->input('id_package');
            $data->save();
    
            // Load relations
            $data->load('package', 'user');
    
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }
    
    public function getDataById($id)
    {
        $data = $this->bookingModel::where('id', $id)->first();
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
        }
    }

    public function deleteData($id)
    {
        $data = $this->bookingModel::where('id', $id)->first();
        if (!$data) {
            return response()->json([
                'code' => 404,
                'message' => 'ID or data not found',
            ]);
        } else {
            $data->delete();
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => $data
            ]);
        }
    }
}

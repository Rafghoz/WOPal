<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    
    public function getAllData()
    {
        $data = $this->userModel::all();
        if ($data->isEmpty()) {
            return response()->json([
                'code' => 404,
                'message' => 'Data not found'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

    public function getDataById($id)
    {
        $data = $this->userModel::find($id);
        if (!$data) {
            return response()->json([
                'code' => 404,
                'message' => 'Data not found'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

    public function createData(Request $request)
    {
            // Pesan-pesan validasi yang disesuaikan
    $messages = [
        'name.required' => 'Nama harus diisi.',
        'name.string' => 'Nama harus berupa teks.',
        'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
        'email.required' => 'Email harus diisi.',
        'email.email' => 'Email harus valid.',
        'email.unique' => 'Email sudah digunakan.',
        'alamat.string' => 'Alamat harus berupa teks.',
        'no_hp.string' => 'Nomor HP harus berupa teks.',
        'password.required' => 'Password harus diisi.',
        'password.string' => 'Password harus berupa teks.',
        'password.min' => 'Password minimal 8 karakter.',
    ];
    
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'password' => 'required|string|min:8',
        ], $messages);
    
        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }
    
        try {
            $data = new User();
            $data->name = $request->input('name');
            $data->email = $request->input('email');
            $data->alamat = $request->input('alamat');
            $data->no_hp = $request->input('no_hp');
            $data->role = 'user';
            $data->password = Hash::make($request->input('password'));
    
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
// Pesan-pesan validasi yang disesuaikan
$messages = [
    'name.required' => 'Nama harus diisi.',
    'name.string' => 'Nama harus berupa teks.',
    'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
    'email.required' => 'Email harus diisi.',
    'email.email' => 'Email harus valid.',
    'email.unique' => 'Email sudah digunakan.',
    'alamat.string' => 'Alamat harus berupa teks.',
    'no_hp.int' => 'Nomor HP harus berupa nomor.',
    'password.string' => 'Password harus berupa teks.',
    'password.min' => 'Password minimal 8 karakter.',
];

// Validasi input
$validator = Validator::make($request->all(), [
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email,'.$id,
    'alamat' => 'nullable|string',
    'no_hp' => 'nullable|int',
    'password' => 'nullable|string|min:8',
], $messages);
    
        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }
    
        try {
            $data = $this->userModel::find($id);
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }
    
            $data->name = $request->input('name');
            $data->email = $request->input('email');
            $data->alamat = $request->input('alamat');
            $data->no_hp = $request->input('no_hp');
            
            if ($request->has('password')) {
                $data->password = Hash::make($request->input('password'));
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
    
    
    public function deleteData($id)
    {
        try {
            $data = $this->userModel::find($id);
            if (!$data) {
                return response()->json([
                    'code' => 404,
                    'message' => 'ID or data not found',
                ]);
            } else {
                $data->delete();
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => $e
            ], 400);
        }
        return response()->json([
            'code' => 200,
            'message' => 'Success delete ',
        ]);
    }

    public function login(Request $request)
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Login failed'
                ]);
            }

            $user =  $this->userModel::where('email', $request['email'])->first();
            $token = $user->createToken('auth_token')->plainTextToken;
            return $this->success([
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => $e
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user('web')->tokens()->delete();
        Auth::guard('web')->logout();
        return response()->json([
            'message' => 'success logout'
        ]);
    }
}
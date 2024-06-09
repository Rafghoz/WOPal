<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

    public function createUser(Request $request)
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
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->alamat = $request->input('alamat');
            $user->no_hp = $request->input('no_hp');
            $user->role = 'user'; // Role user
            $user->password = Hash::make($request->input('password'));
        
            $user->save();
        
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => $e
            ], 400);
        }
    }
    
    public function createAdmin(Request $request)
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
        $admin = new User();
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->alamat = $request->input('alamat');
        $admin->no_hp = $request->input('no_hp');
        $admin->role = 'admin'; // Role admin
        $admin->password = Hash::make($request->input('password'));
    
        $admin->save();
    
        return response()->json([
            'success' => true,
            'data' => $admin
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

    public function showLoginForm()
    {
        return view('cms.auth.Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user = Auth::user();
            // $token = $user->createToken('auth_token')->plainTextToken;

            // Determine redirect URL based on user role
            $redirect_url = '/';
            if ($user->role == 'admin') {
                $redirect_url = '/Dashboard';
            } elseif ($user->role == 'super_admin') {
                $redirect_url = '/superadmin-dashboard';
            }

            return response()->json([
                'code' => 200,
                // 'access_token' => $token,
                'redirect_url' => $redirect_url,
                'message' => 'Logged in successfully',
            ]);
        }

        return response()->json([
            'code' => 401,
            'message' => 'Invalid credentials',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user('web')->tokens()->delete(); // Menghapus semua personal access tokens yang terkait dengan user
        Auth::guard('web')->logout(); // Melakukan logout dari web guard

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Successfully logged out']);
        }

        return redirect('/cms/login'); // Redirect ke halaman login setelah logout
    }
}

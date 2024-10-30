<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; //ini blm ditambahin, harusnya ada di materi yg ada di discord

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Website Pertamaku',
            'home' => 'Home',
            'menu' => 'Master',
            'submenu' => 'Menu User',
            'titleSubmenu' => 'Data User',
            'users' => User::all(),
        ];

        return view('master.user', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('Error disini masuk gak...');
        $request->validate(
            [
                'nama' => 'required|max:128',
                'pekerjaan' => 'required|max:50',
                'alamat' => 'required|max:255',
                'email' => 'required|unique:users,email,' . $request->email
            ],
            [
                // Berfungsi untuk custom pesan error/validasi
                'nama.required' => 'Nama wajib diisi!',
                'nama.max' => 'Nama maksimal 50 karakter!',
                'pekerjaan.required' => 'Pekerjaan wajib diisi!',
                'pekerjaan.max' => 'Pekerjaan maksimal 50 karakter!',
                'alamat.required' => 'Alamat wajib diisi!',
                'alamat.max' => 'Alamat maksimal 255 karakter!',
                'email.required' => 'Email wajib diisi!',
                'email.unique' => 'Email sudah terdaftar'
            ]
        );

        User::create([
            'nama' => $request->nama,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return response()->json(['success' => 'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, $id)
    {
        // cari user berdasarkan $id
        $checkUser = User::find($id);

        // Jika data user ada / ditemukan
        if ($checkUser) {

            // Hapus user
            User::destroy($id);
            return response()->json(['success' => true]);
        }
    }

    /**
     * show the form for editing the specified resource.
     */
    public function edit(User $user, $id)
    {
        $getUser['data'] = User::find($id);
        return response()->json($getUser);
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'e_nama' => 'required|max:128',
                'e_pekerjaan' => 'required|max:50',
                'e_alamat' => 'required|max:255',
                'e_email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($request->id),

                ],
            ],
            [
                // Berfungsi untuk custom pesan error
                'e_nama.required' => 'Nama wajib diisi!',
                'e_nama.max' => 'Nama maksimal 128 karakter!',
                'e_nama.pekerjaan' => 'Pekerjaan wajib diisi!',
                'e_pekerjaaan.max' => 'Pekerjaan maksimal 50 karakter!',
                'e_alamat.required' => 'Alamat wajib diisi!',
                'e_alamat.max' => 'Alamat maksimal 255 karakter!',
                'e_email.required' => 'Email wajib diisi!',
                'e_email' => 'Email sudah terdaftar!',
            ]
        );

        $getPass = User::where('id', $request->id)->first();

        User::where('id', $request->id)->update([
            'nama' => $request->e_nama,
            'pekerjaan' => $request->e_pekerjaan,
            'alamat' => $request->e_alamat,
            'email' => $request->e_email,
            'password' => $request->e_password != '' ? Hash::make($request->e_password) : $getPass->password,

        ]);

        return response()->json(['success' => 'Post created successfuly.']);
    }
    public function profile(Request $request)
    {
        $data = [
            'title' => 'Website Pertamaku',
            'home' => 'Home',
            'menu' => 'Pengaturan',
            'submenu' => 'Profile',
            'titleSubmenu' => 'Data Profile',
            'users' => User::find(Auth::user()->id),
        ];

        return view('setting.profile', $data);
    }

    public function register()
    {
        $data = [
            'title' => 'Website Pertamaku',
            'home' => 'Home',
            'menu' => 'Register',
            'submenu' => 'Register',
            'titleSubmenu' => 'Register'
        ];

        return view('register', $data);
    }

    public function register_user(request $request)
    {
        $request->validate(
            [
                'nama' => 'required|max:128',
                'email' => 'required|unique:users,email,' .  $request->email,
                'password' => 'required|min:6',
            ],
            [
                // Berfungsi untuk custom pesan error
                'nama.required' => 'Nama wajib diisi!',
                'nama.max' => 'Nama maksimal 128 karakter!',
                'email.required' => 'Email wajib diisi!',
                'email.unique' => 'Email sudah terdaftar!',
                'password.required' => 'Password wajib diisi!',
                'password.min' => 'password minimal 6 karakter!',
            ]
        );

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['success' => 'Post created successfully.']);
    }

    public function login(Request $request)
    {
        $data = [
            'submenu' => 'Login'
        ];

        return view('login', $data);
    }

    public function login_user(Request $request)
    {
        $validate = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ],
            [
                //Berfungsi untuk custom pesan error
                'email.required' => 'Email wajib diisi!',
                'email.unique' => 'Email sudah terdaftar!',
                'email.email' => 'Format Email Salah!',
                'password.required' => 'Password wajib diisi!',
            ]
        );

        if (Auth::Attempt($validate)) {
            return response()->json(['success' => ['message' => 'Berhasil Login']], 200);
        } else {
            return response()->json(['errors' => ['message' => 'Email atau password salah.']], 404);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/');
    }
}

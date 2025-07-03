<?php

namespace App\Http\Controllers;


use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Role;
use App\Models\AuthAssignment;
use Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.register');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return redirect()->route('dashboard')->with('success', 'Login berhasil sebagai admin!');
            }

            if ($user->hasRole('researcher')) {
                return redirect()->route('researcher.dashboard')->with('success', 'Login berhasil sebagai peneliti!');
            }

            if ($user->hasRole('customer')) {
                return redirect()->route('index')->with('success', 'Login berhasil sebagai customer!');
            }

            // Default jika role tidak dikenali
            Auth::logout();
            return back()->withErrors(['email' => 'Role tidak dikenali.']);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }




    /**
     * Write code on Method
     *
     * @return response()
     */

    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Tambahkan role 'customer'
        $role = Role::where('name', 'customer')->first();
        if ($role) {
            $user->roles()->attach($role->id, ['user_type' => User::class]);
        }

        Auth::login($user);

        return redirect()->route('index')->with('success', 'Registrasi berhasil. Anda login sebagai customer!');
    }



    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function indexUser()
    {
        $model = 0;

        return view('auth.index_user')->with([
            '$model' => $model,
        ]);
    }

    public function dataUser()
    {
        $data = DB::table('users')
            ->leftJoin('auth_assignment', 'auth_assignment.user_id', '=', 'users.id')
            ->where('status', '=', 10)
            ->orderBy('users.updated_at', 'DESC')
            ->get();

        return Datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('reset_password', function ($row) {

                $reset_password = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Input User" class="btn btn-outline-danger rounded-pill mb-3 reset_password"><i class="ri-edit-2-fill"></i>Reset</a>
                                               <a href="javascript:void(0)" data-toggle="tooltip"  data-id_user="' . $row->id . '" data-original-title="Edit User" class="btn btn-warning rounded-pill mb-3 edit_data"><i class="ri-user-settings-line"></i>Edit</a>';

                return $reset_password;
            })
            ->rawColumns([
                'reset_password' => 'reset_password',

            ])
            ->make(true);
    }

    public function resetPassword($id, Request $request)
    {

        $password = "123456";
        $model = User::where('id', $id)->get()->first();

        $model->password = Hash::make($password);

        if ($model->save()) {
            Session::flash('success', 'Password Berhasil Direset');
            return response()->json(['success' => 'Password Berhasil Direset']);
        } else {
            Session::flash('danger', 'Password Gagal Direset');
            return response()->json(['success' => 'Password Gagal Direset']);
        }


    }

    public function generateResetPassword($role, Request $request)
    {
        ini_set('max_execution_time', 0);
        $password = "123456";

        $users = DB::table('users')
            ->join('auth_assignment', 'users.id', '=', 'auth_assignment.user_id')
            ->where('auth_assignment.item_name', '=', $role)
            ->get();


        foreach ($users as $data) {
            $model = User::where('id', $data->id)->get()->first();
            $model->password = Hash::make($password);
            $model->save();
        }

        Session::flash('success', 'Password Berhasil Direset');
        return redirect()->back();
        //return response()->json(['success'=>'Password Berhasil Direset']);



    }

    // Create New User
    public function createNewUser(Request $request)
    {

        $password = "123456";

        $model = new User;
        $model->username = $request->username;
        $model->password = Hash::make($password);
        $model->email = $request->email;
        $model->status = 10;
        $model->inisial_user = $request->inisial_user;
        $model->nama_user = $request->nama_user;
        $model->telp = $request->telp;

        if ($model->save()) {

            Session::flash('success', 'Data User Berhasil Ditambahkan');
        } else {
            Session::flash('danger', 'Data User Gagal Ditambahkan');
        }
        return redirect()->back();
    }

    // Update  User
    public function update(Request $request, $id)
    {

        $model = User::where('id', $id)->first();
        $model->email = $request->email_edit;
        $model->status = 10;
        $model->inisial_user = $request->inisial_user_edit;
        $model->nama_user = $request->nama_user_edit;
        $model->telp = $request->telp_edit;
        $model->save();
        /*if ($model->save()) {
            Session::flash('success','Data User Berhasil Diupdate');
        }else{
            Session::flash('danger','Data User Gagal Diupdate');
        }
        return redirect()->back();*/
        return response()->json(['success' => 'Data saved successfully.', 'message' => 'Data User Berhasil Diupdate']);
    }

    //Get Data User By ID
    public function getUserById(Request $request, $id)
    {
        $model = User::where('id', $id)->first();

        return response()->json($model);
    }

    // Create Role User
    public function createRoleUser(Request $request)
    {

        $model = new AuthAssignment();
        $model->item_name = $request->item_name;
        $model->user_id = $request->user_id;

        if ($model->save()) {
            Session::flash('success', 'Data Role User Berhasil Ditambahkan');
        } else {
            Session::flash('danger', 'Data Role User Gagal Ditambahkan');
        }
        return redirect()->back();
    }

    public function create(array $data)
    {

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function viewProfil($id)
    {
        $model = User::where('id', $id)->first();

        return view('auth.view_profil')->with([
            'model' => $model,
        ]);
    }

    // Update  User
    public function updateProfil(Request $request, $id)
    {

        $model = User::where('id', $id)->first();
        $model->nama_user = $request->nama_user;
        $model->email = $request->email;
        $model->telp = $request->telp;

        if ($model->save()) {
            Session::flash('success', 'Data Profil Berhasil Diupdate');
        } else {
            Session::flash('danger', 'Data Profil Gagal Diupdate');
        }
        return redirect()->back();
        //return response()->json(['success'=>'Data saved successfully.','message' => 'Data User Berhasil Diupdate']);
    }

    public function updatePassword($id, Request $request)
    {
        $model = User::where('id', $id)->get()->first();
        $new_password = $request->new_password;
        $repeat_password = $request->repeat_password;

        if (strcmp($new_password, $repeat_password) == 0) {
            $password = $new_password;
            $model->password = Hash::make($password);
        }

        if ($model->save()) {
            Session::flash('success', 'Password Berhasil Diubah');
            //return response()->json(['success'=>'Password Berhasil Diubah']);
        } else {
            Session::flash('danger', 'Password Gagal Diubah');
            //return response()->json(['success'=>'Password Gagal Direset']);
        }
        return redirect()->back();


    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }
}

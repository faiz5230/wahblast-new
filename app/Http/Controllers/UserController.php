<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->status_account == 'demo')
        {
            toast('Akses dibatasi! status akun hanya demo','error');
            return redirect()->route('admin.schedule-message');
        }
        $users = User::get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed'
        ],
        [
            'name.required' => 'Nama harus di isi!',
            'email.required' => 'Email harus di isi!',
            'email.unique' => 'Email sudah terdaftar!', 
            'password.required' => 'password harus di isi!'
        ]);

        try {
            if($request->status == 'on')
            {
                $request['status'] = 1;
            }else{
                $request['status'] = 0;
            }
            $request['password'] = bcrypt($request->password);
            User::create($request->all());
            toast('Berhasil menambahkan user', 'success');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            toast($e, 'error');
            return redirect()->route('users.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$request->password) {
            $request->request->remove('password');
        } else {
            $request['password'] = bcrypt($request->password);
            $request['password_confirmation'] = $request->except('password_confirmation');
        }
        $user->update($request->all());

        toast('User berhasil diperbarui!', 'success');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        toast('User berhasil dihapus', 'success');
        return redirect()->route('users.index');
    }
}

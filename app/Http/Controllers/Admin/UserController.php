<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت کاربران وبسایت';

        $users = User::withoutTrashed()

            ->orderByDesc('level')
            ->orderByDesc('email_verified_at')
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->get();

        return response()->view('admin.user.index', [
            'title' => $title,
            'users' => $users
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() : Response
    {
        $title = 'افزودن کاربر جدید';
        return response()->view('admin.user.create', [
            'title' => $title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'family'=>['required', 'string', 'max:50'],
            'mobile'=>['required', 'iran_mobile', 'unique:users,mobile'],
            'email' => ['required', 'string', 'email', 'max:70', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'level'=>['required', 'numeric','in:0,121'],
            'status'=>['required', 'numeric', 'in:0,1'],
            'verified'=>['required', 'numeric', 'in:0,1'],
        ]);

        User::query()->create(array_merge(
            $request->except('password', 'verified'),
            ['password' => Hash::make($request->input('password'))],
            ['email_verified_at' => ($request->input('verified') == 1) ? Carbon::now()->toDateTimeString() : null ]
        ));

        return response()->redirectToRoute('users.index')->with('success', 'کاربر جدید با موفقیت افزوده شد!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::withoutTrashed()->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'family'=>['required', 'string', 'max:50'],
            'mobile'=>['required', 'iran_mobile', 'unique:users,mobile,'.$user->id],
            'email' => ['required', 'string', 'email', 'max:70', 'unique:users,'.$user->id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'level'=>['required', 'numeric','in:0,121'],
            'status'=>['required', 'numeric', 'in:0,1'],
            'verified'=>['required', 'numeric', 'in:0,1'],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

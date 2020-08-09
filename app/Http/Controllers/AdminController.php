<?php

namespace App\Http\Controllers;


use App\Http\Middleware\Admin;
use App\Rules\MatchOldPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    public function users()
    {
        return view('admin.users');
    }

    public function createUser()
    {
        return view('admin.createUser');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'userName' => ['required', 'string', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
             'role'    =>['required']
        ], [
            'required'=>'هذا الحقل مطلوب',
            'max'=>'اقصى عدد لحروف يجب ادخالها هى 255',
            'unique'=>'اسم المستخدم موجود بالفعل',
            'min'=>'اقل عدد يجب ادخاله هو 8 حروف او ارقام',
            'confirmed'=>'كلمه السر غير متطابقه'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        User::create([
            'name'=>$request->input('name'),
            'username'=>$request->input('userName'),
            'password'=>Hash::make($request->input('userName')),
            'role'=>$request->input('role')
        ]);
        return redirect()->route('admin.users')->with(['success'=>'تم اضافه العضو بنجاح']);
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.editUser', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $id],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'role'    =>['required']
        ], [
            'required'=>'هذا الحقل مطلوب',
            'max'=>'اقصى عدد لحروف يجب ادخالها هى 255',
            'unique'=>'اسم المستخدم موجود بالفعل',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        User::find($id)->update([
            'name'=>$request->input('name'),
            'username'=>$request->input('username'),
            'role'=>$request->input('role')
        ]);
        return redirect()->route('admin.users')->with(['success'=>'تم تعديل بيانات المستخدم بنجاح']);
    }

    public function changeAdminPassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'current-password' => 'required',
            'password' => ['required', 'string', 'min:1', 'confirmed'],
        ],
            [
            'required'=>'هذا الحقل مطلوب',
            'max'=>'اقصى عدد لحروف يجب ادخالها هى 255',
            'unique'=>'اسم المستخدم موجود بالفعل',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if (Hash::check($request->input('current-password') , User::find($id)->password)){
            User::find($id)->update(['password'=> Hash::make($request->password)]);
            return redirect()->back()->with(['success'=>'تم تغير كلمه المرور بنجاح']);
        }else{
            return redirect()->back()->with(['message'=>'كلمه المرور القديمه غير صحيحه']);
        }
    }

    public function userData()
    {
        $user = User::all();
        return Datatables::of($user)
            ->editColumn('created_at', function ($model){
                return $model->created_at->format('Y-m-d');
            })
            ->editColumn('edit', function ($model){
                return '<a href=" '. route('admin.user.edit', $model->id) .' " class="btn btn-primary"><i class="fa fa-edit"></i></a>';
            })
            ->editColumn('role', function ($model){
                if ($model->role == 1){
                    return "<span>" . "مشرف" . "</span>";
                }else{
                    return "<span>" . "عضو" . "</span>";
                }
            })
            ->editColumn('delete', function ($model){
                if ($model->id !== 1){
                    return "<form action=" . route('admin.user.destroy', $model->id) ." method='POST'>" .  csrf_field() ."
                    <button type='submit' class='btn btn-danger'><i class='fa fa-trash'></i></button></form>";
                }else{
                    return "<span>" . "لا يمكن حذف صلحيه المشرف الاساسى" . "</span>";
                }

            })
            ->addColumn('make_role', function ($model){
                if ($model->role == 1){
                    $form = "<form action=" . route('remove.admin', $model->id) ." method='POST'>" .  csrf_field() ."
                    <button type='submit' class='btn btn-danger'>حذف صلحيات المشرف</button></form>";
                }else{
                    $form = "<form action=" . route('make.admin', $model->id) ." method='POST'>" .  csrf_field() ."
                    <button type='submit' class='btn btn-success'>اعطاء صلحيات المشرف</button></form>";
                }
                return $form;
            })
            ->rawColumns(['make_role', 'edit', 'delete', 'role'])
            ->make(true);
    }

    public function makeAdmin($id)
    {
        $user = User::find($id)->update(['role'=>1]);
        return redirect()->route('admin.users')->with(['success'=>'تم اعطاء صلحيات المشرف بنجاح للمستخدم : ' . User::find($id)->name]);

    }

    public function removeAdmin($id)
    {
        $user = User::find($id)->update(['role'=>0]);
        return redirect()->route('admin.users')->with(['success'=>'تم ازاله صلحيات المشرف بنجاح للمستخدم : ' . User::find($id)->name]);

    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('admin.users')->with(['success'=>'تم حذف المستخدم بنجاح ']);
    }
}

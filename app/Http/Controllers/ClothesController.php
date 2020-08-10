<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Purchase;
use App\Sale;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;

class ClothesController extends Controller
{
    public function index()
    {
        return view('pages/index');
    }

    public function purchasesStore(Request $request)
    {
        $input = $request->all();
        $rules = [
            'total_purchases' => 'required|numeric',
            'dis_purchases' => 'required',
            'images' => 'required:size:1024',
        ];
        $message = [
            'required'=>'هذا الحقل مطلوب',
            'mimes'=>'يجب ادخال صوره فقط',
            'numeric'=>'يجب الا يحتوى الحقل على حروف',
        ];
        $validator = Validator::make($input, $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if($request->file('images')){
            $images = $request->file('images');
            $arr = [];
            foreach ($images as $image){
                $arr[] = filesize($image) ;
            }
            if (array_sum($arr) > 10485760){
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()->with(['error_purchases'=>'حجم الصور يجب الا يتعدى ال 10 ميجا']);
            }
            $purchase = Auth::user()->purchases()->create([
                'total_purchases'=>$request->input('total_purchases'),
                'dis_purchases'=>$request->input('dis_purchases')
            ]);
            foreach($images as $image)
            {
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                if (filesize($image) > 512000){
                    Image::make($image)->save(public_path('images/') . $new_name, 20);
                }else{
                    Image::make($image)->save(public_path('images/') . $new_name, 50);
                }

                $purchase->images()->create(['name'=>$new_name]);
            }
        }
        return redirect()->back()->with(['success'=>'تم اضافه المشتريات بنجاح']);

    }




    public function salesStore(Request $request)
    {
        $input = $request->all();
        $rules = [
            'total_sales' => 'required|numeric',
            'dis_sales' => 'required',
        ];
        $message = [
            'required'=>'هذا الحقل مطلوب',
            'max'=>'اقصى عدد يجب ادخاله هو 10 ارقام',
            'mimes'=>'يجب ادخال صوره فقط',
            'numeric'=>'يجب الا يحتوى الحقل على حروف'
        ];
        $validator = Validator::make($input, $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $sales = Auth::user()->sales()->create([
            'total_sales'=>$request->input('total_sales'),
            'dis_sales'=>$request->input('dis_sales')
        ]);
        return redirect()->back()->with(['success'=>'تم اضافه المبيعات بنجاح']);
    }




    public function expensesStore(Request $request)
    {
        $input = $request->all();
        $rules = [
            'total_expenses' => 'required|numeric',
            'dis_expenses' => 'required',
        ];
        $message = [
            'required'=>'هذا الحقل مطلوب',
            'numeric'=>'يجب الا يحتوى الحقل على حروف',
        ];
        $validator = Validator::make($input, $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if($request->file('images')){
            $images = $request->file('images');
            $arr = [];
            foreach ($images as $image){
                $arr[] = filesize($image) ;
            }
            if (array_sum($arr) > 10485760){
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()->with(['error_expenses'=>'حجم الصور يجب الا يتعدى ال 10 ميجا']);
            }
            $expenses = Auth::user()->expenses()->create([
                'total_expenses'=>$request->input('total_expenses'),
                'dis_expenses'=>$request->input('dis_expenses')
            ]);
            foreach($images as $image)
            {
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                if (filesize($image) > 512000){
                    Image::make($image)->save(public_path('images/') . $new_name, 20);
                }else{
                    Image::make($image)->save(public_path('images/') . $new_name, 50);
                }

                $expenses->images()->create(['name'=>$new_name]);
            }
        }else{
            $expenses = Auth::user()->expenses()->create([
                'total_expenses'=>$request->input('total_expenses'),
                'dis_expenses'=>$request->input('dis_expenses')
            ]);
        }
        return redirect()->back()->with(['success'=>'تم اضافه المصروفات بنجاح']);

    }

    public function purchasesIndex()
    {
        $purchases = Purchase::orderBy('id', 'desc')->get();
        return view('pages.purchasePage', compact('purchases'));
    }

    public function salesIndex()
    {
        $sales = Sale::orderBy('id', 'desc')->get();
        return view('pages.salesPage', compact('sales'));
    }
    public function expensesIndex()
    {
        $expenses = Expense::orderBy('id', 'desc')->get();
        return view('pages.expensesPage', compact('expenses'));
    }

    public function purchasesSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_from'=>'required'
        ], [
            'required'=>'هذا الحقل مطلوب'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');
        if ($request->date_to == '' || !$request->has('date_to') || $date_to > now()->format('Y-m-d')){
            $date_to = now()->format('Y-m-d');
        }
        $to = Carbon::createFromFormat('Y-m-d', $date_to)->addDay()->format('Y-m-d');
         $purchases = Purchase::whereBetween('created_at', [$date_from, $to])->orderBy('created_at', 'asc')->get();
        return view('pages.purchasePage', compact('purchases'));
    }
    public function expensesSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_from'=>'required'
        ], [
            'required'=>'هذا الحقل مطلوب'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');
        if ($request->date_to == '' || !$request->has('date_to') || $date_to > now()->format('Y-m-d')){
            $date_to = now()->format('Y-m-d');
        }
         $expenses = Expense::whereBetween('created_at', [$date_from, Carbon::createFromFormat('Y-m-d', $date_to)->addDay()])->orderBy('created_at', 'asc')->get();
        return view('pages.expensesPage', compact('expenses'));
    }

    public function salesSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_from'=>'required'
        ], [
            'required'=>'هذا الحقل مطلوب'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');
        if ($request->date_to == '' || !$request->has('date_to') || $date_to > now()->format('Y-m-d')){
            $date_to = now()->format('Y-m-d');
        }
         $to = Carbon::createFromFormat('Y-m-d', $date_to)->addDay()->format('Y-m-d');
        $sales = Sale::whereBetween('created_at', [$date_from, $to])->orederBy('created_at', 'asc')->get();
        return view('pages.salesPage', compact('sales'));
    }

    public function report(Request $request)
    {
        if ($request->date_to == '' || !$request->has('date_to') || $request->date_to > now()->format('Y-m-d')){
            $date_to = now()->format('Y-m-d');
        }elseif ($request->date_to !== '' || $request->has('date_to')){
            $date_to = $request->input('date_to');

        }
        if ($request->has('date_from') && $request->input('date_from') !== ''){
            $date_from = $request->input('date_from');
            $sum_purchases = Purchase::whereBetween('created_at', [$date_from, Carbon::createFromFormat('Y-m-d', $date_to)->addDay()])->sum('total_purchases');
            $sum_sales = Sale::whereBetween('created_at', [$date_from, Carbon::createFromFormat('Y-m-d', $date_to)->addDay()])->sum('total_sales');
            $sum_expenses = Expense::whereBetween('created_at', [$date_from, Carbon::createFromFormat('Y-m-d', $date_to)->addDay()])->sum('total_expenses');
        }else{
            $sum_purchases = Purchase::sum('total_purchases');
            $sum_sales = Sale::sum('total_sales');
            $sum_expenses = Expense::sum('total_expenses');
        }
        return view('pages.report', compact('sum_purchases', 'sum_expenses', 'sum_sales'));
    }
    public function purchasesData(Request $request)
    {

        if($request->json()){
            if ($request->date_to == '' || !$request->has('date_to') || $request->date_to > now()->format('Y-m-d')){
                $date_to = now()->format('Y-m-d');
            }elseif ($request->date_to !== '' || $request->has('date_to')){
                $date_to = $request->input('date_to');

            }
            if ($request->has('date_from') && $request->input('date_from') !== ''){
                $date_from = $request->input('date_from');
                $to = Carbon::createFromFormat('Y-m-d', $date_to)->addDay()->format('Y-m-d');
                $purchases = Purchase::whereBetween('created_at', [$date_from, $to])->get();
                return Datatables::of($purchases)
                    ->editColumn('id', function ($model){
                        return "<span class='pu_id_td'>" . $model->id ." </span>";
                    })
                    ->editColumn('user_id', function ($model){
                        return "<span class='pu_user_td'>" . $model->user->name . "</span>";
                    })
                    ->editColumn('total_purchases', function ($model){
                        return "<span class='pu_total_td'>" . $model->total_purchases . "</span>";
                    })
                    ->editColumn('dis_purchases', function ($model){
                        return "<span class='pu_dis_td'>" . $model->dis_purchases ." </span>";
                    })
                    ->editColumn('created_at', function ($model){
                        return "<span class='pu_created_at_ts'>" . $model->created_at->format('Y-m-d') . "</span>";
                    })
                    ->rawColumns(['dis_purchases', 'user_id', 'total_purchases', 'created_at', 'id'])

                    ->make(true);

            }else{
                $purchases = Purchase::all();
                return Datatables::of($purchases)
                    ->editColumn('id', function ($model){
                        return "<span class='pu_id_td'>" . $model->id ." </span>";
                    })
                    ->editColumn('user_id', function ($model){
                        return "<span class='pu_user_td'>" . $model->user->name . "</span>";
                    })
                    ->editColumn('total_purchases', function ($model){
                        return "<span class='pu_total_td'>" . $model->total_purchases . "</span>";
                    })
                    ->editColumn('dis_purchases', function ($model){
                        return "<span class='pu_dis_td'>" . $model->dis_purchases ." </span>";
                    })
                    ->editColumn('created_at', function ($model){
                        return "<span class='pu_created_at_ts'>" . $model->created_at->format('Y-m-d') . "</span>";
                    })
                    ->rawColumns(['dis_purchases', 'user_id', 'total_purchases', 'created_at', 'id'])
                    ->make(true);
            }

        }
    }
    public function salesData(Request $request)
    {

        if ($request->date_to == '' || !$request->has('date_to') || $request->date_to > now()->format('Y-m-d')){
            $date_to = now()->format('Y-m-d');
        }elseif ($request->date_to !== '' || $request->has('date_to')){
            $date_to = $request->input('date_to');

        }
        if ($request->has('date_from') && $request->input('date_from') !== ''){
            $date_from = $request->input('date_from');
            $to = Carbon::createFromFormat('Y-m-d', $date_to)->addDay()->format('Y-m-d');
            $sales = Sale::whereBetween('created_at', [$date_from, $to])->get();
            return Datatables::of($sales)
                ->editColumn('id', function ($model){
                    return "<span class='sl_id_td'>" . $model->id . "</span>";
                })
                ->editColumn('user_id', function ($model){
                    return "<span class='sl_user_td'>" . $model->user->name . "</span>";
                })
                ->editColumn('total_sales', function ($model){
                    return "<span class='sl_total_td'>" . $model->total_sales . "</span>";
                })
                ->editColumn('created_at', function ($model){
                    return "<span class='sl_created_at_td'>" . $model->created_at->format('Y-m-d') . "</span>";
                })
                ->editColumn('dis_sales', function ($model){
                    return "<span class='sl_dis_td'>" . $model->dis_sales ." </span>";
                })
                ->rawColumns(['dis_sales', 'id', 'user_id', 'total_sales', 'created_at'])
                ->make(true);

        }else{
            $sales = Sale::all();
            return Datatables::of($sales)
                ->editColumn('id', function ($model){
                    return "<span class='sl_id_td'>" . $model->id . "</span>";
                })
                ->editColumn('user_id', function ($model){
                    return "<span class='sl_user_td'>" . $model->user->name . "</span>";
                })
                ->editColumn('total_sales', function ($model){
                    return "<span class='sl_total_td'>" . $model->total_sales . "</span>";
                })
                ->editColumn('created_at', function ($model){
                    return "<span class='sl_created_at_td'>" . $model->created_at->format('Y-m-d') . "</span>";
                })
                ->editColumn('dis_sales', function ($model){
                    return "<span class='sl_dis_td'>" . $model->dis_sales ." </span>";
                })
                ->rawColumns(['dis_sales', 'id', 'user_id', 'total_sales', 'created_at'])
                ->make(true);
        }

    }
    public function expensesData(Request $request)
    {

        if ($request->date_to == '' || !$request->has('date_to') || $request->date_to > now()->format('Y-m-d')){
            $date_to = now()->format('Y-m-d');
        }elseif ($request->date_to !== '' || $request->has('date_to')){
            $date_to = $request->input('date_to');

        }
        if ($request->has('date_from') && $request->input('date_from') !== ''){
            $date_from = $request->input('date_from');
            $to = Carbon::createFromFormat('Y-m-d', $date_to)->addDay()->format('Y-m-d');
            $expenses = Expense::whereBetween('created_at', [$date_from, $to])->get();
            return Datatables::of($expenses)
                ->editColumn('id', function ($model){
                    return "<span class='ex_id_td'>" . $model->id . "</span>";
                })
                ->editColumn('user_id', function ($model){
                    return "<span class='ex_user_td'>" . $model->user->name . "</span>";
                })
                ->editColumn('total_expenses', function ($model){
                    return "<span class='ex_total_td'>" . $model->total_expenses . "</span>";
                })
                ->editColumn('created_at', function ($model){
                    return "<span class='ex_created_at_td'>" . $model->created_at->format('Y-m-d') . "</span>";
                })
                ->editColumn('dis_expenses', function ($model){
                    return "<span class='ex_dis_td'>" . $model->dis_expenses ." </span>";
                })
                ->rawColumns(['dis_expenses', 'id', 'user_id', 'total_expenses', 'created_at'])
                ->make(true);

        }else{
            $expenses = Expense::all();
            return Datatables::of($expenses)
                ->editColumn('id', function ($model){
                    return "<span class='ex_id_td'>" . $model->id . "</span>";
                })
                ->editColumn('user_id', function ($model){
                    return "<span class='ex_user_td'>" . $model->user->name . "</span>";
                })
                ->editColumn('total_expenses', function ($model){
                    return "<span class='ex_total_td'>" . $model->total_expenses . "</span>";
                })
                ->editColumn('created_at', function ($model){
                    return "<span class='ex_created_at_td'>" . $model->created_at->format('Y-m-d') . "</span>";
                })
                ->editColumn('dis_expenses', function ($model){
                    return "<span class='ex_dis_td'>" . $model->dis_expenses ." </span>";
                })
                ->rawColumns(['dis_expenses', 'id', 'user_id', 'total_expenses', 'created_at'])
                ->make(true);
        }

    }

    public function userProfile()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }
    public function userUpdateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . Auth::id()],
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
        Auth::user()->update([
            'name'=>$request->input('name'),
            'username'=>$request->input('username'),
        ]);
        return redirect()->back()->with(['success'=>'تم تعديل بيانات المستخدم بنجاح']);
    }
    public function changeUserPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current-password' => 'required',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ],
            [
                'required' => 'هذا الحقل مطلوب',
                'confirmed'=>'كلمه المرور غير متطابقه',
                'اقل عدد حروف او ارقام يجب ادخاله هو 6'
            ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if (Hash::check($request->input('current-password'), Auth::user()->password)) {
            Auth::user()->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['success' => 'تم تغير كلمه المرور بنجاح']);
        } else {
            return redirect()->back()->with(['message' => 'كلمه المرور القديمه غير صحيحه']);
        }
    }

}

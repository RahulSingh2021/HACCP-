<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddNewCouponController extends Controller
{
    public function index(){
        $coupons =  DB::table('coupons')->get();
        return view('admin.AddNewCoupon.views.index',['coupons' => $coupons]);
    }

    public function addCouponPage(){
        return view('admin.AddNewCoupon.views.add');
    }

    public function addCoupon(Request $request){
        DB::table('coupons')->insert([
           'coupon_code' => $request->coupon_code ?? '',
           'discount_percentage' => $request->discount_percentage ?? '',
           'validity_till' => $request->expiry_date ?? '',
        ]);

        return redirect()->back()->with('success', 'Coupon added successfully'); 
    }

    public function deleteCoupon($id){
        DB::table('coupons')->where('id',$id)->delete();
        return redirect()->back()->with('success', 'Coupon deleted successfully'); 
    }

    public function editCoupon($id){
       $data = DB::table('coupons')->where('id',$id)->first();
        return view('admin.AddNewCoupon.views.edit',['data'=>$data]);
    }

    public function updateCoupon(Request $request,$id){
        DB::table('coupons')->where('id', $id)->update([
            'coupon_code' => $request->coupon_code ??  DB::raw('coupon_code'),
            'discount_percentage' => $request->discount_percentage ??  DB::raw('discount_percentage'),
            'validity_till' => $request->expiry_date ??  DB::raw('validity_till'),
        ]);
    
        return redirect()->back()->with('success', 'Coupon updated successfully');
    }
}

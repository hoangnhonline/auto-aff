<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\SanPham;
use App\Models\SpThuocTinh;
use App\Models\SpHinh;
use App\Models\ThuocTinh;
use App\Models\LoaiThuocTinh;
use App\Models\Banner;
use App\Models\Orders;
use App\Models\OrderDetail;
use App\Models\Customer;
use Helper, File, Session, Auth;
use Mail;
use Carbon\Carbon;

class OrderController extends Controller
{

  protected $status = [
    0 => 'Chờ xử lý',
    1 => 'Đang xử lý',
    2 => 'Đang tạm ngừng',
    3 => 'Đã hoàn thành',
    4 => 'Đã huỷ',
    5 => 'Đã hoàn lại tiền',
    6 => 'Thất bại'
  ];

  public function detail(Request $request)
  {
    $order_id = $request->order_id;
    $order = Orders::find($order_id);
    $customer_id = Session::get('userId'); 

    if($order->customer_id != $customer_id){
      return redirect()->route('home');
    }else{
      $orderDetail = $order->order_detail;      
    }
    $str_order_id = str_pad($order->id, 6, "0", STR_PAD_LEFT);
     $seo['title'] = $seo['description'] = $seo['keywords'] = "Chi tiết đơn hàng #".$str_order_id;

     $status = $this->status;
     $ngay_dat_hang = Carbon::parse($order->created_at)->format('d-m-Y H:i:s');
     $customer = Customer::find($customer_id);
    return view('frontend.account.order-detail', compact('order', 'orderDetail', 'seo', 'str_order_id', 'status', 'ngay_dat_hang', 'customer'));
  }

  public function show(Request $request)
  {
    $customer_id = Session::get('userId');
    $orders = Orders::where('customer_id', $customer);
    return view('', compact('orders'));
  }

  public function history(Request $request)
  {
    if(!Session::has('userId')) {
      return redirect()->route('home');
    }
    $customer_id = Session::get('userId');
    $customer = Customer::find($customer_id);
    $orders = Orders::where('customer_id', $customer_id)->orderBy('id', 'DESC')->get();
    $status = $this->status;
    
      $seo['title'] = $seo['description'] = $seo['keywords'] = "Đơn hàng của tôi";
    
    return view('frontend.account.order-history', compact('orders', 'status', 'customer', 'seo'));
  }

}

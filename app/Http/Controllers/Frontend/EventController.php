<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\SanPham;
use App\Models\ProductEvent;
use App\Models\MetaData;

use Helper, File, Session, Auth;
use Mail;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {   
        $dt = Carbon::now()->format('Y-m-d H:i:s');

        $dataList = Events::where('from_date', '<=', $dt)->where('to_date', '>=', $dt)->where('status', 1)->get();
        $seo['title'] = $seo['description'] = $seo['keywords'] = "Chương trình khuyến mãi - iCho.vn";                
        
        $socialImage = "";
        return view('frontend.event.index', compact('seo', 'socialImage', 'dataList'));
    }

    public function detail(Request $request){

               

        $slug = $request->slug;        
        $detail = Events::where('slug', $slug)->first();       
        if(!$detail){
            return redirect()->route('home');
        }
        $event_id = $detail->id;
        
        // check con ton tai hay ko ?
        $dt = Carbon::now()->format('Y-m-d H:i:s');
        $rsCheck = Events::where('from_date', '<=', $dt)->where('to_date', '>=', $dt)->where('status', 1)->where('id', $event_id)->first();
        if(!$rsCheck){
            return redirect()->route('home');   
        }       

        Session::set('event_id', $event_id);        
        $detail = Events::find($event_id);
        $dataList = ProductEvent::where('event_id', $event_id)->where('product_event.status', 1)
                    ->join('san_pham', 'san_pham.id', '=', 'product_event.sp_id')                    
                    ->join('sp_hinh', 'san_pham.thumbnail_id', '=', 'sp_hinh.id')
                    ->join('loai_sp', 'san_pham.loai_id', '=', 'loai_sp.id')
                    ->join('cate', 'san_pham.cate_id', '=', 'cate.id')                    
                    ->where('product_event.so_luong', '>', 0)
                    ->select('san_pham.*', 'sp_hinh.*', 'loai_sp.name as ten_loai', 'cate.name as ten_cate', 'product_event.*', 'san_pham.id as sp_id')
                    ->get();
         
        $socialImage = $detail->large_banner;
        if( $detail->meta_id > 0){
           $seo = MetaData::find( $detail->meta_id )->toArray();
           $seo['title'] = $seo['title'] != '' ? $seo['title'] : $detail->name;
           $seo['description'] = $seo['description'] != '' ? $seo['description'] : $detail->name;
           $seo['keywords'] = $seo['keywords'] != '' ? $seo['keywords'] : $detail->name;
        }else{
            $seo['title'] = $seo['description'] = $seo['keywords'] = $detail->name;
        }  
        $is_km = 1;
        return view('frontend.event.detail', compact('seo', 'socialImage', 'dataList', 'detail', 'is_km'));
    }

}


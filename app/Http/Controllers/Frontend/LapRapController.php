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
use App\Models\Location;
use App\Models\TinhThanh;
use App\Models\HoverInfo;
use App\Models\SpMucDich;
use App\Models\SpTuongThich;

use App\Models\Pages;
use Helper, File, Session, Auth;

class LapRapController extends Controller
{
    
    public static $loaiSp = []; 
    public static $loaiSpArrKey = [];    

    public function __construct(){
        
       

    }
    public function lapRap(Request $request){
        
        $slug = $request->slug;
        
        $tmp = $this->getMucDich($slug);
        
        $muc_dich = $tmp['muc_dich'];
        $title = $tmp['title'];
        $spFreeList = [];
           
        $cateList = Cate::where(['status' => 1, 'loai_id' => 7])->orderBy('display_order')->get();        
        foreach($cateList as $cate){
            
            $spFreeList[$cate->id] = SanPham::where('cate_id', $cate->id)->orderBy('id', 'DESC')->limit(20)->get();
            
        }
        $title = $tmp['title'];
        $seo = Helper::seo();
        $lap_rap = 1;

        return view('frontend.may-bo.lap-rap', compact('muc_dich', 'title', 'seo', 'lap_rap', 'cateList', 'spFreeList', 'slug', 'title'));
    }
    public function getTuongThich(Request $request){
        $id = $request->sp_id;
        $type = $request->type;
        $detail = (object) [];
        if($type == "ram"){
            $cate_id = 35;
            $detail = SanPham::find($id);
        }elseif( $type == "mainboard"){
            $cate_id = 31;
        }elseif( $type == "vga"){
            $cate_id = 85;
        }elseif( $type == "cpu"){
            $cate_id = 32;
        }
        $cate = Cate::find($cate_id);
        $tmpArr = SanPham::where('status', 1)
                    ->join('sp_tuongthich', 'sp_2' , '=', 'id')
                    ->where('sp_1', $id)
                    ->where('sp_tuongthich.cate_id', $cate_id)
                    ->select('name', 'price', 'price_sale', 'is_sale', 'alias', 'slug', 'id')
                    ->get();
                  
        return view('frontend.may-bo.ajax-load', compact('tmpArr', 'cate', 'detail'));
    }
    public function mua(Request $request){
        $data = $request->all();
        if(!empty($data['select'])){
            $listProduct = Session::get('products');
            foreach($data['select'] as $cate_id => $sp_id){
                $quantity = $cate_id == 35 ? $request->so_ram : 1;
                $listProduct[$sp_id] = $quantity;               
                
            }
            Session::put('products', $listProduct);
        }
        return redirect()->route('gio-hang');
    }
    public function index(Request $request)
    {

        $productArr = [];
        
        $loai_id = 3;
        $slug = $request->path();
        $tmp = $this->getMucDich($slug);
        $muc_dich = $tmp['muc_dich'];
        $title = $tmp['title'];
        if( $muc_dich > 0){
            $loaiSp = LoaiSp::find($loai_id);

            $cateArr = Cate::where('status', 1)->where('loai_id', $loai_id)->get();
            
            $productArr = SanPham::where('loai_id', $loai_id)
                    ->leftJoin('sp_hinh', 'sp_hinh.id', '=','san_pham.thumbnail_id')
                    ->join('sp_mucdich', 'sp_mucdich.sp_id', '=','san_pham.id')
                    ->where('muc_dich', $muc_dich)
                    ->select('sp_hinh.image_url', 'san_pham.*')
                    ->orderBy('san_pham.id', 'desc')
                    ->limit(6)->get();         
        }       
        $seo = Helper::seo();
        $lap_rap = 1;
        return view('frontend.may-bo.index', compact('productArr', 'cateArr', 'loaiSp', 'muc_dich', 'title', 'seo', 'lap_rap', 'slug'));
    }
    

    public function getMucDich($slug){
        switch ($slug) {
            case 'may-bo-van-phong':
                $muc_dich = 1;
                $title = "Máy bộ văn phòng";
                break;
            case 'may-bo-choi-game':
                $muc_dich = 2;
                $title = "Máy bộ chơi game";
                break;
            case 'may-bo-do-hoa':
                $muc_dich = 3;
                $title = "Máy bộ đồ họa";
                break;
            case 'may-bo-am-thanh':
                $muc_dich = 4;
                $title = "Máy bộ âm thanh";
                break;
            default:
                $muc_dich = 0;
                $title = '';
                break;
        }
        return ['muc_dich' => $muc_dich, 'title' => $title];
    }
}
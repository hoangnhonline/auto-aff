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
use App\Models\HoverInfo;
use App\Models\Location;
use App\Models\TinhThanh;
use App\Models\Articles;
use App\Models\ArticlesCate;
use App\Models\Customer;
use App\Models\Newsletter;
use App\Models\PriceRange;
use App\Models\Settings;
use App\Models\LinkSite;
use App\Models\LinkImage;
use Helper, File, Session, Auth, Hash;

class HomeController extends Controller
{
    
    public static $loaiSp = []; 
    public static $loaiSpArrKey = [];    

    public function __construct(){
        
       

    }
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function showLink(Request $request){
        $site_id = $request->site_id;
        $all = LinkSite::where('site_id', $site_id)->get();
        $i = 0;
        foreach($all as $data){
            $i++;
            echo $i."-"."<strong>".$data->link."</strong><br>";
            if($data->images->count()){
                foreach ($data->images as $value) {
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$value->image_url;
                    echo "<br>";
                }
            }
            echo "<hr>";
        }
        die;


    }
    public function loadSlider(){
        return view('frontend.home.ajax-slider');
    }
    public function index(Request $request)
    {  
        $productArr = [];
        $hoverInfo = [];
        $loaiSp = LoaiSp::where('status', 1)->get();
        $bannerArr = [];
        foreach( $loaiSp as $loai){
            $query = SanPham::where(['loai_id' => $loai->id])->where('so_luong_ton', '>', 0)->where('price', '>', 0)
            ->leftJoin('sp_hinh', 'sp_hinh.id', '=','san_pham.thumbnail_id')
            ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.sp_id', '=','san_pham.id')
            ->select('sp_hinh.image_url', 'san_pham.*', 'thuoc_tinh')
            ->where('sp_hinh.image_url', '<>', '');
            if($loai->price_sort == 0){
                $query->where('price', '>', 0)->orderBy('san_pham.price', 'asc');
            }else{
                $query->where('price', '>', 0)->orderBy('san_pham.price', 'desc');
            }
            $query->orderBy('san_pham.is_hot', 'desc')
            ->orderBy('san_pham.is_sale', 'desc')
            ->orderBy('san_pham.display_order', 'desc')
            ->orderBy('san_pham.id', 'desc');

            if($loai->home_style == 0){
                $query->limit(12);
            }elseif( $loai->home_style == 1){
                $query->limit(6);
            }elseif( $loai->home_style == 2){
                $query->limit(8);
            }else{
                $query->limit(8);
            }
            if( $loai->home_style > 0 ){
                $bannerArr[$loai->id] = Banner::where(['object_id' => $loai->id, 'object_type' => 1])->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
            }

            $hoverInfo[$loai->id] = HoverInfo::where('loai_id', $loai->id)->orderBy('display_order', 'asc')->orderBy('id', 'asc')->limit(8)->get();
            $productArr[$loai->id] = $query->get()->toArray();
            
            $settingArr = Settings::whereRaw('1')->lists('value', 'name');
            $seo = $settingArr;
            $seo['title'] = $settingArr['site_title'];
            $seo['description'] = $settingArr['site_description'];
            $seo['keywords'] = $settingArr['site_keywords'];
            $socialImage = $settingArr['logo'];
        }    
        $articlesArr = Articles::where(['cate_id' => 1, 'is_hot' => 1])->orderBy('id', 'desc')->get();

        return view('frontend.home.index', compact('productArr', 'hoverInfo', 'bannerArr', 'articlesArr', 'socialImage', 'seo'));
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function search(Request $request)
    {
        $tu_khoa = $request->keyword;       

        $productArr = SanPham::where('alias', 'LIKE', '%'.$tu_khoa.'%')->where('so_luong_ton', '>', 0)->where('price', '>', 0)
                        ->leftJoin('sp_hinh', 'sp_hinh.id', '=','san_pham.thumbnail_id')
                        ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.sp_id', '=','san_pham.id')
                        ->select('sp_hinh.image_url', 'san_pham.*', 'thuoc_tinh')
                        ->orderBy('id', 'desc')->paginate(20);
        $seo['title'] = $seo['description'] =$seo['keywords'] = "Tìm kiếm sản phẩm theo từ khóa '".$tu_khoa."'";
        $hoverInfo = [];
        if($productArr->count() > 0){
            $hoverInfoTmp = HoverInfo::orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
            foreach($hoverInfoTmp as $value){
                $hoverInfo[$value->loai_id][] = $value;
            }
        }
        //var_dump("<pre>", $hoverInfo);die;
        return view('frontend.search.index', compact('productArr', 'tu_khoa', 'seo', 'hoverInfo'));
    }
    public function ajaxTab(Request $request){
        $table = $request->type ? $request->type : 'category';
        $id = $request->id;

        $arr = Film::getFilmHomeTab( $table, $id);

        return view('frontend.index.ajax-tab', compact('arr'));
    }
    public function contact(Request $request){        

        $seo['title'] = 'Liên hệ';
        $seo['description'] = 'Liên hệ';
        $seo['keywords'] = 'Liên hệ';
        $socialImage = '';
        return view('frontend.contact.index', compact('seo', 'socialImage'));
    }

    public function newsList(Request $request)
    {
        $slug = $request->slug;
        $cateArr = $cateActiveArr = $moviesActiveArr = [];
       
        $cateDetail = ArticlesCate::where('slug' , $slug)->first();

        $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;

        $articlesArr = Articles::where('cate_id', $cateDetail->id)->orderBy('id', 'desc')->paginate(10);

        $hotArr = Articles::where( ['cate_id' => $cateDetail->id, 'is_hot' => 1] )->orderBy('id', 'desc')->limit(5)->get();
        $seo['title'] = $cateDetail->meta_title ? $cateDetail->meta_title : $cateDetail->title;
        $seo['description'] = $cateDetail->meta_description ? $cateDetail->meta_description : $cateDetail->title;
        $seo['keywords'] = $cateDetail->meta_keywords ? $cateDetail->meta_keywords : $cateDetail->title;
        $socialImage = $cateDetail->image_url;       
        return view('frontend.news.index', compact('title', 'hotArr', 'articlesArr', 'cateDetail', 'seo', 'socialImage'));
    }      

     public function newsDetail(Request $request)
    {     
        $id = $request->id;

        $detail = Articles::where( 'id', $id )
                ->select('id', 'title', 'slug', 'description', 'image_url', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'custom_text', 'created_at', 'cate_id')
                ->first();
        $is_km = $is_news = $is_kn = 0;
        if( $detail ){           

            $title = trim($detail->meta_title) ? $detail->meta_title : $detail->title;

            $hotArr = Articles::where( ['cate_id' => 1, 'is_hot' => 1] )->where('id', '<>', $id)->orderBy('id', 'desc')->limit(5)->get();
            $otherArr = Articles::where( ['cate_id' => 1] )->where('id', '<>', $id)->orderBy('id', 'desc')->limit(5)->get();
            $seo['title'] = $detail->meta_title ? $detail->meta_title : $detail->title;
            $seo['description'] = $detail->meta_description ? $detail->meta_description : $detail->title;
            $seo['keywords'] = $detail->meta_keywords ? $detail->meta_keywords : $detail->title;
            $socialImage = $detail->image_url; 
            $is_km = $detail->cate_id == 2 ? 1 : 0;
            $is_news = $detail->cate_id == 1 ? 1 : 0;
            $is_kn = $detail->cate_id == 4 ? 1 : 0;
            return view('frontend.news.news-detail', compact('title',  'hotArr', 'detail', 'otherArr', 'seo', 'socialImage', 'is_km', 'is_news', 'is_kn'));
        }else{
            return view('erros.404');
        }
    }

    public function registerNews(Request $request)
    {

        $register = 0; 
        $email = $request->email;
        $newsletter = Newsletter::where('email', $email)->first();
        if(is_null($newsletter)) {
           $newsletter = new Newsletter;
           $newsletter->email = $email;
           $newsletter->is_member = Customer::where('email', $email)->first() ? 1 : 0;
           $newsletter->save();
           $register = 1;
        }

        return $register;
    }

}

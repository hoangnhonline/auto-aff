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
use App\Models\MetaData;
use App\Models\Compare;

use Helper, File, Session, Auth;

class DetailController extends Controller
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
    public function index(Request $request)
    {   
       

        $spThuocTinhArr = $productArr = [];
        $slug = $request->slug;
        $detail = SanPham::where('slug', $slug)->where('cate_id', '>', 0)->where('loai_id', '>', 0)->first();
        if(!$detail){
            return redirect()->route('home');
        }
        $rsLoai = LoaiSp::find( $detail->loai_id );
        $rsCate = Cate::find( $detail->cate_id );

        $hinhArr = SpHinh::where('sp_id', $detail->id)->get()->toArray();
        // hien thuoc tinh
        $tmp = SpThuocTinh::where('sp_id', $detail->id)->select('thuoc_tinh')->first();
        
        if( $tmp ){
            $spThuocTinhArr = json_decode( $tmp->thuoc_tinh, true);
        }
        if ( $spThuocTinhArr ){
            $loaiThuocTinhArr = LoaiThuocTinh::where('loai_id', $detail->loai_id)->orderBy('display_order')->get();            
           
            if( $loaiThuocTinhArr->count() > 0){
                foreach ($loaiThuocTinhArr as $value) {

                    $thuocTinhArr[$value->id]['id'] = $value->id;
                    $thuocTinhArr[$value->id]['name'] = $value->name;

                    $thuocTinhArr[$value->id]['child'] = ThuocTinh::where('loai_thuoc_tinh_id', $value->id)->select('id', 'name')->orderBy('display_order')->get()->toArray();
                }
                
            }        
        }
        
        // sp phu kien
        $phuKienArr = $tuongtuArr = [];
        if( $detail->sp_phukien ){
            $phuKienArr = explode(',', $detail->sp_phukien);
        }        
        if( $detail->sp_tuongtu ){
            $tuongtuArr = explode(',', $detail->sp_tuongtu);
        }       
         //get compare
        $compare1 = Compare::where('sp_1', $detail->id)->lists('sp_2')->toArray();              
        $compare2 = Compare::where('sp_2', $detail->id)->lists('sp_1')->toArray();        
        $sosanhArr = array_merge($compare1, $compare2);
        //var_dump($sosanhArr);die;
        $tmpArr = array_merge($phuKienArr, $tuongtuArr, $sosanhArr);
        
        if( !empty($tmpArr)){
            $productTmpArr = SanPham::whereIn('san_pham.id', $tmpArr)
                ->leftJoin('sp_hinh', 'sp_hinh.id', '=','san_pham.thumbnail_id')
                ->select('san_pham.id as sp_id', 'name', 'name_extend', 'slug', 'price', 'price_sale', 'sp_hinh.image_url', 'is_sale')->get();
            foreach($productTmpArr as $product){
                $productArr[$product->sp_id] = $product;
            }
        }
        $lienquanArr = SanPham::where('san_pham.cate_id', $detail->cate_id)
                ->leftJoin('sp_hinh', 'sp_hinh.id', '=','san_pham.thumbnail_id')
                ->where('san_pham.id', '<>', $detail->id)
                ->select('san_pham.id as sp_id', 'name', 'name_extend', 'slug', 'price', 'price_sale', 'sp_hinh.image_url', 'is_sale')->orderBy('san_pham.id', 'desc')->limit(10)->get();        

        if( $detail->meta_id > 0){
           $meta = MetaData::find( $detail->meta_id )->toArray();
           $seo['title'] = $meta['title'] != '' ? $meta['title'] : $detail->name;
           $seo['description'] = $meta['description'] != '' ? $meta['description'] : $detail->name;
           $seo['keywords'] = $meta['keywords'] != '' ? $meta['keywords'] : $detail->name;
        }else{
            $seo['title'] = $seo['description'] = $seo['keywords'] = $detail->name;
        }               
        
        $socialImage = SpHinh::find($detail->thumbnail_id)->image_url;

        return view('frontend.detail.index', compact('detail', 'rsLoai', 'rsCate', 'hinhArr', 'ttArr','thuocTinhArr', 'loaiThuocTinhArr', 'spThuocTinhArr', 'productArr', 'phuKienArr', 'tuongtuArr', 'sosanhArr', 'lienquanArr', 'seo', 'socialImage'));
    }

    public function ajaxTab(Request $request){
        $table = $request->type ? $request->type : 'category';
        $id = $request->id;

        $arr = Film::getFilmHomeTab( $table, $id);

        return view('frontend.index.ajax-tab', compact('arr'));
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function search(Request $request)
    {

        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        
        $layout_name = "main-category";
        
        $page_name = "page-category";

        $cateArr = $cateActiveArr = $moviesActiveArr = [];

        $tu_khoa = $request->k;
        
        $is_search = 1;

        $moviesArr = Film::where('alias', 'LIKE', '%'.$tu_khoa.'%')->orderBy('id', 'desc')->paginate(20);

        return view('frontend.cate', compact('settingArr', 'moviesArr', 'tu_khoa',  'is_search', 'layout_name', 'page_name' ));
    }

    public function cate(Request $request)
    {

        $productArr = [];
        $slugLoaiSp = $request->slugLoaiSp;
        $slug = $request->slug;
        $rs = LoaiSp::where('slug', $slugLoaiSp)->first();
        $loai_id = $rs->id;
        $rsCate = Cate::where(['loai_id' => $loai_id, 'slug' => $slug])->first();
        $cate_id = $rsCate->id;

        $cateArr = Cate::where('status', 1)->where('loai_id', $loai_id)->get();

        
        $productArr = SanPham::where('cate_id', $rsCate->id)->where('loai_id', $loai_id)
                ->leftJoin('sp_hinh', 'sp_hinh.id', '=','san_pham.thumbnail_id')
                ->select('sp_hinh.image_url', 'san_pham.*')
                //->where('sp_hinh.image_url', '<>', '')
                ->orderBy('san_pham.id', 'desc')
                ->paginate(24);

        return view('frontend.cate.child', compact('productArr', 'cateArr', 'rs', 'rsCate'));
    }

    public function tags(Request $request)
    {
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');

        $layout_name = "main-category";
        
        $page_name = "page-category";

        $cateArr = $cateActiveArr = $moviesActiveArr = [];
       
        $is_search = 0;
        $tagName = $request->tagName;

        $title = '';
        $cateDetail = (object) [];       
        
        $cateDetail = Tag::where('slug', $tagName)->first();
       
         $moviesArr = Film::where('status', 1)
        ->join('tag_objects', 'id', '=', 'tag_objects.object_id')
        ->where('tag_objects.tag_id', $cateDetail->id)
        ->where('tag_objects.type', 1)
        ->groupBy('object_id')
        ->orderBy('id', 'desc')->paginate(30);        
       
        $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;
        $cateDetail->name = "Phim theo tags : ".'"'.$cateDetail->name.'"';
        

        return view('frontend.cate', compact('title', 'settingArr', 'is_search', 'moviesArr', 'cateDetail', 'layout_name', 'page_name', 'cateActiveArr', 'moviesActiveArr'));
    }
    
    public function daoDien(Request $request)
    {
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');

        $layout_name = "main-category";
        
        $page_name = "page-category";

        $cateArr = $cateActiveArr = $moviesActiveArr = [];
       
        $is_search = 0;
        $name = $request->name;

        $title = '';
        $cateDetail = (object) [];       
        
        $cateDetail = Crew::where('slug', $name)->first();
       
         $moviesArr = Film::where('status', 1)
        ->join('film_crew', 'id', '=', 'film_crew.film_id')
        ->where('film_crew.crew_id', $cateDetail->id)
        ->where('film_crew.type', 2)
        ->groupBy('film_id')
        ->orderBy('id', 'desc')->paginate(30);        
       
        $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;
        $cateDetail->name = "Phim của : ".'"'.$cateDetail->name.'"';
        

        return view('frontend.cate', compact('title', 'settingArr', 'is_search', 'moviesArr', 'cateDetail', 'layout_name', 'page_name', 'cateActiveArr', 'moviesActiveArr'));
    }

    public function dienVien(Request $request)
    {
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');

        $layout_name = "main-category";
        
        $page_name = "page-category";

        $cateArr = $cateActiveArr = $moviesActiveArr = [];
       
        $is_search = 0;
        $name = $request->name;

        $title = '';
        $cateDetail = (object) [];       
        
        $cateDetail = Crew::where('slug', $name)->first();
       
         $moviesArr = Film::where('status', 1)
        ->join('film_crew', 'id', '=', 'film_crew.film_id')
        ->where('film_crew.crew_id', $cateDetail->id)
        ->where('film_crew.type', 1)
        ->groupBy('film_id')
        ->orderBy('id', 'desc')->paginate(30);         
       
        $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;
        $cateDetail->name = "Phim của : ".'"'.$cateDetail->name.'"';
        

        return view('frontend.cate', compact('title', 'settingArr', 'is_search', 'moviesArr', 'cateDetail', 'layout_name', 'page_name', 'cateActiveArr', 'moviesActiveArr'));
    }

    public function newsList(Request $request)
    {
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $layout_name = "main-news";
        
        $page_name = "page-news";

        $cateArr = $cateActiveArr = $moviesActiveArr = [];
       
        $cateDetail = ArticlesCate::where('slug' , 'tin-tuc')->first();
        $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;

        $articlesArr = Articles::where('cate_id', 1)->orderBy('id', 'desc')->paginate(10);
        $hotArr = Articles::where( ['cate_id' => 1, 'is_hot' => 1] )->orderBy('id', 'desc')->limit(5)->get();
        return view('frontend.news-list', compact('title','settingArr', 'hotArr', 'layout_name', 'page_name', 'articlesArr'));
    }

    public function newsDetail(Request $request)
    {
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $layout_name = "main-news";
        
        $page_name = "page-news";

        $id = $request->id;

        $detail = Articles::where( 'id', $id )
                ->select('id', 'title', 'slug', 'description', 'image_url', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'custom_text')
                ->first();

        if( $detail ){
            $cateArr = $cateActiveArr = $moviesActiveArr = [];
        
            
            $title = trim($detail->meta_title) ? $detail->meta_title : $detail->title;

            $hotArr = Articles::where( ['cate_id' => 1, 'is_hot' => 1] )->where('id', '<>', $id)->orderBy('id', 'desc')->limit(5)->get();

            return view('frontend.news-detail', compact('title', 'settingArr', 'hotArr', 'layout_name', 'page_name', 'detail'));
        }else{
            return view('erros.404');
        }     

        
    }

}

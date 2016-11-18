<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\Color;
use App\Models\LoaiThuocTinh;
use App\Models\ThuocTinh;
use App\Models\SpThuocTinh;
use App\Models\SpHinh;
use App\Models\MetaData;
use App\Models\Compare;
use App\Models\SpTuongThich;
use App\Models\SpMucDich;

use Helper, File, Session, Auth, Hash, URL;

class ProductController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {

        $arrSearch['status'] = $status = isset($request->status) ? $request->status : 1;
        $arrSearch['is_hot'] = $is_hot = isset($request->is_hot) ? $request->is_hot : null;
        $arrSearch['is_sale'] = $is_sale = isset($request->is_sale) ? $request->is_sale : null;
        $arrSearch['loai_id'] = $loai_id = isset($request->loai_id) ? $request->loai_id : null;
        $arrSearch['cate_id'] = $cate_id = isset($request->cate_id) ? $request->cate_id : null;

        $arrSearch['het_hang'] = $het_hang = isset($request->het_hang) ? $request->het_hang : null;
        $arrSearch['chua_nhap_gia'] = $chua_nhap_gia = isset($request->chua_nhap_gia) ? $request->chua_nhap_gia : null;
        $arrSearch['thieu_can_nang'] = $thieu_can_nang = isset($request->thieu_can_nang) ? $request->thieu_can_nang : null;
        $arrSearch['thieu_kich_thuoc'] = $thieu_kich_thuoc = isset($request->thieu_kich_thuoc) ? $request->thieu_kich_thuoc : null;

        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';
        
        $query = SanPham::where('san_pham.status', $status);
        if( $is_hot ){
            $query->where('san_pham.is_hot', $is_hot);
        }
        if( $is_sale ){
            $query->where('san_pham.is_sale', $is_sale);
        }
        if( $loai_id ){
            $query->where('san_pham.loai_id', $loai_id);
        }
        if( $cate_id ){
            $query->where('san_pham.cate_id', $cate_id);
        }
        if( $het_hang ){
            $query->where('san_pham.so_luong_ton', 0);
        }
        if( $chua_nhap_gia ){
            $query->where('san_pham.price', 0);
        }
        if( $thieu_can_nang ){
            $query->where('san_pham.can_nang', 0);
        }
        if( $thieu_kich_thuoc ){
            $query->where('san_pham.chieu_dai', 0);
            $query->orWhere('san_pham.chieu_rong', 0);
            $query->orWhere('san_pham.chieu_cao', 0);
        }
        if( $name != ''){
            $query->where('san_pham.name', 'LIKE', '%'.$name.'%');
            $query->orWhere('name_extend', 'LIKE', '%'.$name.'%');
        }
        $query->join('users', 'users.id', '=', 'san_pham.created_user');
        $query->join('loai_sp', 'loai_sp.id', '=', 'san_pham.loai_id');
        $query->join('cate', 'cate.id', '=', 'san_pham.cate_id');
        $query->leftJoin('sp_hinh', 'sp_hinh.id', '=','san_pham.thumbnail_id');        
        $query->orderBy('san_pham.id', 'desc');
        $items = $query->select(['sp_hinh.image_url','san_pham.*','san_pham.id as sp_id', 'full_name' , 'san_pham.created_at as time_created', 'users.full_name', 'loai_sp.name as ten_loai', 'cate.name as ten_cate'])
        ->paginate(50);   

        $loaiSpArr = LoaiSp::all();  
        if( $loai_id ){
            $cateArr = Cate::where('loai_id', $loai_id)->orderBy('display_order', 'desc')->get();
        }else{
            $cateArr = (object) [];
        }

        return view('backend.product.index', compact( 'items', 'arrSearch', 'loaiSpArr', 'cateArr'));
    }
    public function short(Request $request)
    {
        
        $arrSearch['status'] = $status = isset($request->status) ? $request->status : 1;
        $arrSearch['loai_id'] = $loai_id = isset($request->loai_id) ? $request->loai_id : null;
        $arrSearch['cate_id'] = $cate_id = isset($request->cate_id) ? $request->cate_id : null;
        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';
        
        $query = SanPham::where('san_pham.status', $status);
        if( $loai_id ){
            $query->where('san_pham.loai_id', $loai_id);
        }
        if( $cate_id ){
            $query->where('san_pham.cate_id', $cate_id);
        }
        if( $name != ''){
            $query->where('san_pham.name', 'LIKE', '%'.$name.'%');
            $query->orWhere('name_extend', 'LIKE', '%'.$name.'%');
        }        
        $query->orderBy('san_pham.id', 'desc');
        $items = $query->select(['san_pham.*','san_pham.id as sp_id' , 'san_pham.created_at as time_created'])
        ->paginate(50);

        $loaiSpArr = LoaiSp::all();  
        if( $loai_id ){
            $cateArr = Cate::where('loai_id', $loai_id)->orderBy('display_order', 'desc')->get();
        }else{
            $cateArr = (object) [];
        }

        return view('backend.product.short', compact( 'items', 'arrSearch', 'loaiSpArr', 'cateArr'));
    }
    public function spTuongThich(Request $request){
        
        $id = $request->id;
        
        $detail = SanPham::find($id);

        $loaiSpArr = LoaiSp::all();  
        
        $tmpArr = SpTuongThich::where('sp_1', $id)->get();
        //var_dump("<pre>", $tmpArr->toArray());die;
        $spSelected = $productArr = [];
        $str_sp_mainboard = $str_sp_cpu = $str_sp_vga = $str_sp_ram = "";
        if( $tmpArr->count() > 0){
            foreach ($tmpArr as $value) {
                $spSelected[$value->cate_id][] = $value->sp_2;
                $productArr[$value->sp_2] = SanPham::find($value->sp_2);
                if($value->cate_id == 31){
                    $str_sp_mainboard .= $value->sp_2.",";
                }
                if($value->cate_id == 32){
                    $str_sp_cpu .= $value->sp_2.",";
                }
                if($value->cate_id == 35){
                    $str_sp_ram .= $value->sp_2.",";
                }
                if($value->cate_id == 85){
                    $str_sp_vga .= $value->sp_2.",";
                }
            }
        }
        
        $mucDichArr = SpMucDich::where('sp_id', $id)->lists('muc_dich')->toArray();

        $cateArr = Cate::where('loai_id', 7)->orderBy('display_order', 'desc')->get();
        
        return view('backend.product.tuong-thich', compact( 'detail', 'loaiSpArr', 'cateArr', 'spSelected', 'productArr', 'str_sp_mainboard','str_sp_cpu', 'str_sp_vga', 'mucDichArr', 'str_sp_ram'));   
    }
    public function ajaxSearch(Request $request){    
        $search_type = $request->search_type;
        $arrSearch['loai_id'] = $loai_id = isset($request->loai_id) ? $request->loai_id : -1;
        $arrSearch['cate_id'] = $cate_id = isset($request->cate_id) ? $request->cate_id : -1;
        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';
        
        $query = SanPham::whereRaw('1');
        
        if( $loai_id ){
            $query->where('san_pham.loai_id', $loai_id);
        }
        if( $cate_id ){
            $query->where('san_pham.cate_id', $cate_id);
        }
        if( $name != ''){
            $query->where('san_pham.name', 'LIKE', '%'.$name.'%');
            $query->orWhere('name_extend', 'LIKE', '%'.$name.'%');
        }
        $query->join('users', 'users.id', '=', 'san_pham.created_user');
        $query->join('loai_sp', 'loai_sp.id', '=', 'san_pham.loai_id');
        $query->join('cate', 'cate.id', '=', 'san_pham.cate_id');
        $query->leftJoin('sp_hinh', 'sp_hinh.id', '=','san_pham.thumbnail_id');        
        $query->orderBy('san_pham.id', 'desc');
        $items = $query->select(['sp_hinh.image_url','san_pham.*','san_pham.id as sp_id', 'full_name' , 'san_pham.created_at as time_created', 'users.full_name', 'loai_sp.name as ten_loai', 'cate.name as ten_cate'])
        ->paginate(1000);

        $loaiSpArr = LoaiSp::all();  
        if( $loai_id ){
            $cateArr = Cate::where('loai_id', $loai_id)->orderBy('display_order', 'desc')->get();
        }else{
            $cateArr = (object) [];
        }

        return view('backend.product.content-search', compact( 'items', 'arrSearch', 'loaiSpArr', 'cateArr', 'search_type'));
    }

    public function ajaxSearchTuongThich(Request $request){    
        $search_type = $request->search_type;
        $arrSearch['loai_id'] = $loai_id = 7;
        $arrSearch['cate_id'] = $cate_id = isset($request->cate_id) ? $request->cate_id : -1;
        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';
        
        $query = SanPham::whereRaw('1');
        
        
        $query->where('san_pham.loai_id', 7);
        
        if( $cate_id ){
            $query->where('san_pham.cate_id', $cate_id);
        }
        if( $name != ''){
            $query->where('san_pham.name', 'LIKE', '%'.$name.'%');
            $query->orWhere('name_extend', 'LIKE', '%'.$name.'%');
        }
        $query->join('users', 'users.id', '=', 'san_pham.created_user');
        $query->join('loai_sp', 'loai_sp.id', '=', 'san_pham.loai_id');
        $query->join('cate', 'cate.id', '=', 'san_pham.cate_id');
        $query->leftJoin('sp_hinh', 'sp_hinh.id', '=','san_pham.thumbnail_id');        
        $query->orderBy('san_pham.id', 'desc');
        $items = $query->select(['sp_hinh.image_url','san_pham.*','san_pham.id as sp_id', 'full_name' , 'san_pham.created_at as time_created', 'users.full_name', 'loai_sp.name as ten_loai', 'cate.name as ten_cate'])
        ->paginate(1000);

        $loaiSpArr = LoaiSp::all();  
        if( $loai_id ){
            $cateArr = Cate::where('loai_id', $loai_id)->orderBy('display_order', 'desc')->get();
        }else{
            $cateArr = (object) [];
        }

        return view('backend.product.tuong-thich.content-search-tuong-thich', compact( 'items', 'arrSearch', 'loaiSpArr', 'cateArr', 'search_type', 'cate_id'));
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        $loai_id = $request->loai_id ? $request->loai_id : null;
        $cate_id = $request->cate_id ? $request->cate_id : null;
        $cateArr = $loaiThuocTinhArr = (object) [];
        $thuocTinhArr = [];
        $loaiSpArr = LoaiSp::all();
        
        if( $loai_id ){
            
            $cateArr = Cate::where('loai_id', $loai_id)->select('id', 'name')->orderBy('display_order', 'desc')->get();
            
            $loaiThuocTinhArr = LoaiThuocTinh::where('loai_id', $loai_id)->orderBy('display_order')->get();

            if( $loaiThuocTinhArr->count() > 0){
                foreach ($loaiThuocTinhArr as $value) {

                    $thuocTinhArr[$value->id]['id'] = $value->id;
                    $thuocTinhArr[$value->id]['name'] = $value->name;

                    $thuocTinhArr[$value->id]['child'] = ThuocTinh::where('loai_thuoc_tinh_id', $value->id)->select('id', 'name')->orderBy('display_order')->get()->toArray();
                }
                
            }
        }
        $colorArr = Color::all();
        $mucDichArr = [];
        return view('backend.product.create', compact('loaiSpArr', 'cateArr', 'colorArr', 'loai_id', 'thuocTinhArr', 'cate_id', 'mucDichArr'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
    */
    public function store(Request $request)
    {
        $dataArr = $request->all();        
        
        $this->validate($request,[
            'name' => 'required',
            'slug' => 'required' ,
            'price' => 'required|numeric',
            'so_luong_ton' => 'required|numeric',
            'can_nang' => 'required|numeric',
            'chieu_dai' => 'required|numeric',
            'chieu_rong' => 'required|numeric',
            'chieu_cao' => 'required|numeric',
        ],
        [
            'name.required' => 'Bạn chưa nhập tên sản phẩm',
            'slug.required' => 'Bạn chưa nhập slug',
            'price.numeric' => 'Vui lòng nhập giá hợp lệ',
            'price.required' => 'Bạn chưa nhập giá',
            'so_luong_ton.required' => 'Bạn chưa nhập số lượng tồn',
            'so_luong_ton.numeric' => 'Vui lòng nhập số lượng tồn hợp lệ',
            'can_nang.required' => 'Bạn chưa nhập cân nặng',
            'can_nang.numeric' => 'Vui lòng nhập cân nặng hợp lệ',
            'chieu_dai.required' => 'Bạn chưa nhập chiều dài',
            'chieu_dai.numeric' => 'Vui lòng nhập chiều dài hợp lệ',
            'chieu_rong.required' => 'Bạn chưa nhập chiều rộng',
            'chieu_rong.numeric' => 'Vui lòng nhập chiều rộng hợp lệ',
            'chieu_cao.required' => 'Bạn chưa nhập chiều cao',
            'chieu_cao.numeric' => 'Vui lòng nhập chiều cao hợp lệ',
        ]);

        $dataArr['is_primary'] = isset($dataArr['is_primary']) ? 1 : 0;
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;
        $dataArr['is_sale'] = isset($dataArr['is_sale']) ? 1 : 0;        
        
        $dataArr['alias'] = Helper::stripUnicode($dataArr['name']);
        $dataArr['slug'] = str_replace(".", "-", $dataArr['slug']);
        $dataArr['slug'] = str_replace("(", "-", $dataArr['slug']);
        $dataArr['slug'] = str_replace(")", "", $dataArr['slug']);
        $dataArr['alias_extend'] = Helper::stripUnicode($dataArr['name_extend']);

        $dataArr['sp_phukien'] = rtrim( $dataArr['str_sp_phukien'], ',');
        $dataArr['sp_sosanh'] = rtrim( $dataArr['str_sp_sosanh'], ',');
        $dataArr['sp_tuongtu'] = rtrim( $dataArr['str_sp_tuongtu'], ',');
        
        $dataArr['status'] = 1;

        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;

        if($dataArr['image_pro'] && $dataArr['pro_name']){
            
            $tmp = explode('/', $dataArr['image_pro']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('icho.upload_path').$dataArr['image_pro'], config('icho.upload_path').$destionation);
            
            $dataArr['image_pro'] = $destionation;
        }  

        $rs = SanPham::create($dataArr);

        $sp_id = $rs->id;

        //muc_dich
        $mucDichArr = $request->muc_dich;
        SpMucDich::where('sp_id', $sp_id)->delete();
        if(!empty($mucDichArr)){
            foreach ($mucDichArr as $muc_dich) {
                SpMucDich::create(['sp_id' => $sp_id, 'muc_dich' => $muc_dich]);
            }
        }

        $this->storeThuocTinh( $sp_id, $dataArr);

        $this->storeImage( $sp_id, $dataArr);
        $this->storeMeta($sp_id, 0, $dataArr);
        Session::flash('message', 'Tạo mới sản phẩm thành công');

        return redirect()->route('product.index', ['loai_id' => $dataArr['loai_id'], 'cate_id' => $dataArr['cate_id']]);
    }

    public function storeMeta( $id, $meta_id, $dataArr ){
       
        $arrData = ['title' => $dataArr['meta_title'], 'description' => $dataArr['meta_description'], 'keywords'=> $dataArr['meta_keywords'], 'custom_text' => $dataArr['custom_text'], 'updated_user' => Auth::user()->id];
        if( $meta_id == 0){
            $arrData['created_user'] = Auth::user()->id;
            //var_dump(MetaData::create( $arrData ));die;
            $rs = MetaData::create( $arrData );
            $meta_id = $rs->id;
            //var_dump($meta_id);die;
            $modelSp = SanPham::find( $id );
            $modelSp->meta_id = $meta_id;
            $modelSp->save();
        }else {
            $model = MetaData::find($meta_id);           
            $model->update( $arrData );
        }              
    }
    public function storeThuocTinh($id, $dataArr){
        
        SpThuocTinh::where('sp_id', $id)->delete();

        if( !empty($dataArr['thuoc_tinh'])){
            foreach( $dataArr['thuoc_tinh'] as $k => $value){
                if( $value == ""){
                    unset( $dataArr['thuoc_tinh'][$k]);
                }
            }
            
            SpThuocTinh::create(['sp_id' => $id, 'thuoc_tinh' => json_encode($dataArr['thuoc_tinh'])]);
        }
    }

    public function storeImage($id, $dataArr){        
        //process old image
        $imageIdArr = isset($dataArr['image_id']) ? $dataArr['image_id'] : [];
        $hinhXoaArr = SpHinh::where('sp_id', $id)->whereNotIn('id', $imageIdArr)->lists('id');
        if( $hinhXoaArr )
        {
            foreach ($hinhXoaArr as $image_id_xoa) {
                $model = SpHinh::find($image_id_xoa);
                $urlXoa = config('icho.upload_path')."/".$model->image_url;
                if(is_file($urlXoa)){
                    unlink($urlXoa);
                }
                $model->delete();
            }
        }       

        //process new image
        if( isset( $dataArr['thumbnail_id'])){
            $thumbnail_id = $dataArr['thumbnail_id'];

            $imageArr = []; 

            if( !empty( $dataArr['image_tmp_url'] )){

                foreach ($dataArr['image_tmp_url'] as $k => $image_url) {

                    if( $image_url && $dataArr['image_tmp_name'][$k] ){

                        $tmp = explode('/', $image_url);

                        if(!is_dir('uploads/'.date('Y/m/d'))){
                            mkdir('uploads/'.date('Y/m/d'), 0777, true);
                        }

                        $destionation = date('Y/m/d'). '/'. end($tmp);
                        
                        File::move(config('icho.upload_path').$image_url, config('icho.upload_path').$destionation);

                        $imageArr['name'][] = $destionation;

                        $imageArr['is_thumbnail'][] = $dataArr['thumbnail_id'] == $image_url  ? 1 : 0;
                    }
                }
            }
            if( !empty($imageArr['name']) ){
                foreach ($imageArr['name'] as $key => $name) {
                    $rs = SpHinh::create(['sp_id' => $id, 'image_url' => $name, 'display_order' => 1]);                
                    $image_id = $rs->id;
                    if( $imageArr['is_thumbnail'][$key] == 1){
                        $thumbnail_id = $image_id;
                    }
                }
            }
            $model = SanPham::find( $id );
            $model->thumbnail_id = $thumbnail_id;
            $model->save();
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
    //
    }
    public function saveSpTuongThich(Request $request){
        $id = $request->id;
        
        $detail = SanPham::find($id);
        //muc_dich
        $mucDichArr = $request->muc_dich;
        SpMucDich::where('sp_id', $id)->delete();
        if(!empty($mucDichArr)){
            foreach ($mucDichArr as $muc_dich) {
                SpMucDich::create(['sp_id' => $id, 'muc_dich' => $muc_dich]);
            }
        }
        $sp_tuongthich_mainboard = $request->sp_tuongthich_31;
        $sp_tuongthich_cpu = $request->sp_tuongthich_32;
        $sp_tuongthich_vga = $request->sp_tuongthich_85;
        $sp_tuongthich_ram = $request->sp_tuongthich_35;
        
        SpTuongThich::where(['sp_1' => $id, 'cate_id' => 31])->delete();
        SpTuongThich::where(['sp_1' => $id, 'cate_id' => 32])->delete();
        SpTuongThich::where(['sp_1' => $id, 'cate_id' => 35])->delete();
        SpTuongThich::where(['sp_1' => $id, 'cate_id' => 85])->delete();

        SpTuongThich::where(['sp_2' => $id, 'cate_id' => $detail->cate_id])->delete();

        if( !empty($sp_tuongthich_mainboard)){
            foreach( $sp_tuongthich_mainboard as $sp_2){
                if( $sp_2 > 0){
                    $check1 = SpTuongThich::where('sp_1', $id)->where('sp_2', $sp_2)->first();
                    $check2 = SpTuongThich::where('sp_1', $sp_2)->where('sp_2', $id)->first();
                    if( !$check1 && !$check2){
                        SpTuongThich::create(['sp_1' => $id, 'sp_2' => $sp_2, 'cate_id' => 31]);
                        SpTuongThich::create(['sp_1' => $sp_2, 'sp_2' => $id, 'cate_id' => $detail->cate_id]);
                    }
                }
            }
        }
        if( !empty($sp_tuongthich_cpu)){
            foreach( $sp_tuongthich_cpu as $sp_2){
                if( $sp_2 > 0){
                    $check1 = SpTuongThich::where('sp_1', $id)->where('sp_2', $sp_2)->first();
                    $check2 = SpTuongThich::where('sp_1', $sp_2)->where('sp_2', $id)->first();
                    if( !$check1 && !$check2){
                        SpTuongThich::create(['sp_1' => $id, 'sp_2' => $sp_2, 'cate_id' => 32]);
                        SpTuongThich::create(['sp_1' => $sp_2, 'sp_2' => $id, 'cate_id' => $detail->cate_id]);
                    }
                }
            }
        }
        if( !empty($sp_tuongthich_ram)){
            foreach( $sp_tuongthich_ram as $sp_2){
                if( $sp_2 > 0){
                    $check1 = SpTuongThich::where('sp_1', $id)->where('sp_2', $sp_2)->first();
                    $check2 = SpTuongThich::where('sp_1', $sp_2)->where('sp_2', $id)->first();
                    if( !$check1 && !$check2){
                        SpTuongThich::create(['sp_1' => $id, 'sp_2' => $sp_2, 'cate_id' => 35]);
                        SpTuongThich::create(['sp_1' => $sp_2, 'sp_2' => $id, 'cate_id' => $detail->cate_id]);
                    }
                }
            }
        }
        if( !empty($sp_tuongthich_vga)){
            foreach( $sp_tuongthich_vga as $sp_2){
                if( $sp_2 > 0){
                    $check1 = SpTuongThich::where('sp_1', $id)->where('sp_2', $sp_2)->first();
                    $check2 = SpTuongThich::where('sp_1', $sp_2)->where('sp_2', $id)->first();
                    if( !$check1 && !$check2){
                        SpTuongThich::create(['sp_1' => $id, 'sp_2' => $sp_2, 'cate_id' => 85]);
                        SpTuongThich::create(['sp_1' => $sp_2, 'sp_2' => $id, 'cate_id' => $detail->cate_id]);
                    }
                }
            }
        }

        return redirect($request->back_url);
        
    }
    public function ajaxSaveRelated(Request $request){
        $type = $request->type;
        $dataArr = (object) [];
        $str_value = $request->str_value;
        if( $str_value ){
            $tmpArr = explode(',', $str_value);
            $dataArr = SanPham::whereIn( 'id', $tmpArr)->select('id', 'name', 'name_extend', 'price', 'price_sale', 'is_sale')->get();
        }
        return view('backend.product.save-related', compact('dataArr' , 'type'));

    }
    public function ajaxSaveTuongThich(Request $request){
        $cate_id = $request->cate_id;
        $dataArr = (object) [];
        $str_value = $request->str_value;
        if( $str_value ){
            $tmpArr = explode(',', $str_value);
            $dataArr = SanPham::whereIn( 'id', $tmpArr)->select('id', 'name', 'name_extend', 'price', 'price_sale', 'is_sale')->get();
        }
        return view('backend.product.tuong-thich.save-tuong-thich', compact('dataArr' , 'cate_id'));

    }
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        $thuocTinhArr = $phuKienArr = $soSanhArr = $tuongTuArr = [];
        $hinhArr = (object) [];
        $detail = SanPham::find($id);

        $hinhArr = SpHinh::where('sp_id', $id)->lists('image_url', 'id');
        //var_dump("<pre>", $hinhArr);die;
        $tmp = SpThuocTinh::where('sp_id', $id)->select('thuoc_tinh')->first();

        if( $tmp ){
            $spThuocTinhArr = json_decode( $tmp->thuoc_tinh, true);
        }
        $tmpPhuKien = explode(",", $detail->sp_phukien);
        $phuKienArr = SanPham::whereIn('id', $tmpPhuKien)->lists('name', 'id');
        //get compare
        $compare1 = Compare::where('sp_1', $id)->lists('sp_2')->toArray();              
        $compare2 = Compare::where('sp_2', $id)->lists('sp_1')->toArray();        
        $tmpSoSanh = array_merge($compare1, $compare2); 
        $soSanhArr = SanPham::whereIn('id', $tmpSoSanh)->lists('name', 'id');

        $tmpTuongTu = explode(",", $detail->sp_tuongtu);
        $tuongTuArr = SanPham::whereIn('id', $tmpTuongTu)->lists('name', 'id');

        $loaiSpArr = LoaiSp::all();
        
        $loai_id = $detail->loai_id; 
            
        $cateArr = Cate::where('loai_id', $loai_id)->select('id', 'name')->orderBy('display_order', 'desc')->get();
        
        $loaiThuocTinhArr = LoaiThuocTinh::where('loai_id', $loai_id)->orderBy('display_order')->get();
        $meta = (object) [];
        if ( $detail->meta_id > 0){
            $meta = MetaData::find( $detail->meta_id );
        }       
        if( $loaiThuocTinhArr->count() > 0){
            foreach ($loaiThuocTinhArr as $value) {

                $thuocTinhArr[$value->id]['id'] = $value->id;
                $thuocTinhArr[$value->id]['name'] = $value->name;

                $thuocTinhArr[$value->id]['child'] = ThuocTinh::where('loai_thuoc_tinh_id', $value->id)->select('id', 'name')->orderBy('display_order')->get()->toArray();
            }
            
        }        
        $colorArr = Color::all();
        $mucDichArr = SpMucDich::where('sp_id', $id)->lists('muc_dich')->toArray();
        return view('backend.product.edit', compact( 'detail', 'hinhArr', 'thuocTinhArr', 'spThuocTinhArr', 'colorArr', 'loaiSpArr', 'cateArr', 'meta', 'phuKienArr', 'tuongTuArr', 'soSanhArr', 'mucDichArr'));
    }
    public function ajaxDetail(Request $request)
    {       
        $id = $request->id;
        $detail = SanPham::find($id);
        return view('backend.product.ajax-detail', compact( 'detail' ));
    }
    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required|numeric',
            'so_luong_ton' => 'required|numeric',
            'can_nang' => 'required|numeric',
            'chieu_dai' => 'required|numeric',
            'chieu_rong' => 'required|numeric',
            'chieu_cao' => 'required|numeric',
        ],
        [
            'name.required' => 'Bạn chưa nhập tên sản phẩm',
            'slug.required' => 'Bạn chưa nhập slug',
            'price.numeric' => 'Vui lòng nhập giá hợp lệ',
            'price.required' => 'Bạn chưa nhập giá',
            'so_luong_ton.required' => 'Bạn chưa nhập số lượng tồn',
            'so_luong_ton.numeric' => 'Vui lòng nhập số lượng tồn hợp lệ',
            'can_nang.required' => 'Bạn chưa nhập cân nặng',
            'can_nang.numeric' => 'Vui lòng nhập cân nặng hợp lệ',
            'chieu_dai.required' => 'Bạn chưa nhập chiều dài',
            'chieu_dai.numeric' => 'Vui lòng nhập chiều dài hợp lệ',
            'chieu_rong.required' => 'Bạn chưa nhập chiều rộng',
            'chieu_rong.numeric' => 'Vui lòng nhập chiều rộng hợp lệ',
            'chieu_cao.required' => 'Bạn chưa nhập chiều cao',
            'chieu_cao.numeric' => 'Vui lòng nhập chiều cao hợp lệ',
        ]);

        $dataArr['is_primary'] = isset($dataArr['is_primary']) ? 1 : 0;
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;
        $dataArr['is_sale'] = isset($dataArr['is_sale']) ? 1 : 0;                
        $dataArr['slug'] = str_replace(".", "-", $dataArr['slug']);
        $dataArr['slug'] = str_replace("(", "-", $dataArr['slug']);
        $dataArr['slug'] = str_replace(")", "", $dataArr['slug']);
        $dataArr['alias'] = Helper::stripUnicode($dataArr['name']);

        $dataArr['alias_extend'] = Helper::stripUnicode($dataArr['name_extend']);

        $dataArr['sp_phukien'] = rtrim( $dataArr['str_sp_phukien'], ',');
        $soSanhArr = isset($dataArr['sp_sosanh']) ? $dataArr['sp_sosanh'] : [];        
        $dataArr['sp_tuongtu'] = rtrim( $dataArr['str_sp_tuongtu'], ',');

        $dataArr['updated_user'] = Auth::user()->id;
        //echo "<pre>";
        //print_r($dataArr);die;
        if($dataArr['image_pro'] && $dataArr['pro_name']){
            
            $tmp = explode('/', $dataArr['image_pro']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('icho.upload_path').$dataArr['image_pro'], config('icho.upload_path').$destionation);
            
            $dataArr['image_pro'] = $destionation;
        }  
        $model = SanPham::find($dataArr['id']);

        $model->update($dataArr);
        
        $sp_id = $dataArr['id'];
        //muc_dich
        $mucDichArr = $request->muc_dich;
        SpMucDich::where('sp_id', $sp_id)->delete();
        if(!empty($mucDichArr)){
            foreach ($mucDichArr as $muc_dich) {
                SpMucDich::create(['sp_id' => $sp_id, 'muc_dich' => $muc_dich]);
            }
        }

        $this->storeThuocTinh( $sp_id, $dataArr);

        $this->storeMeta( $sp_id, $dataArr['meta_id'], $dataArr);
        $this->storeImage( $sp_id, $dataArr);
        $this->storeSoSanh( $sp_id, $soSanhArr);

        Session::flash('message', 'Chỉnh sửa sản phẩm thành công');

        return redirect()->route('product.edit', $sp_id);
        
    }
    public function ajaxSaveInfo(Request $request){
        
        $dataArr = $request->all();

        $dataArr['alias'] = Helper::stripUnicode($dataArr['name']);
        
        $dataArr['updated_user'] = Auth::user()->id;
        
        $model = SanPham::find($dataArr['id']);

        $model->update($dataArr);
        
        $sp_id = $dataArr['id'];        

        Session::flash('message', 'Chỉnh sửa sản phẩm thành công');

    }
    public function storeSoSanh($sp_1, $soSanhArr){
        Compare::where('sp_1', $sp_1)->delete();              
        Compare::where('sp_2', $sp_1)->delete();  
        if( !empty($soSanhArr)){
            foreach( $soSanhArr as $sp_2){
                if( $sp_2 > 0){
                    $check1 = Compare::where('sp_1', $sp_1)->where('sp_2', $sp_2)->first();
                    $check2 = Compare::where('sp_1', $sp_2)->where('sp_2', $sp_1)->first();
                    if( !$check1 && !$check2){
                        Compare::create(['sp_1' => $sp_1, 'sp_2' => $sp_2]);
                    }
                }
            }
        }
        
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        // delete
        $model = SanPham::find($id);        
        $model->delete();
        SpHinh::where('sp_id', $id)->delete();
        SpMucDich::where('sp_id', $id)->delete();
        SpThuocTinh::where('sp_id', $id)->delete();
        SpTuongThich::where('sp_1', $id)->delete();
        SpTuongThich::where('sp_2', $id)->delete();
        // redirect
        Session::flash('message', 'Xóa sản phẩm thành công');
        
        return redirect(URL::previous());//->route('product.short');
        
    }
}

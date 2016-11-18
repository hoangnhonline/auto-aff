<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\MetaData;
use App\Models\ProductEvent;
use App\Models\SanPham;
use App\Models\LoaiSp;
use App\Models\Cate;

use Carbon\Carbon;
use Helper, File, Session, Auth;

class EventsController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $items = Events::all()->sortBy('display_order');
        return view('backend.events.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('backend.events.create');
    }
    public function ajaxSaveProduct(Request $request){
        $str_value = $request->str_sp_id;
        $event_id = $request->event_id;
        $tmpArr = explode(',', $str_value);
        $so_luong = $request->so_luong ? $request->so_luong : [];
        $rs = ProductEvent::where('event_id', $event_id)->where('status', 1)->get(); // status = 1
        $arrIdDb = [];
        if(!empty($rs)){
            foreach($rs as $tmp1){
                $arrIdDb[] = $tmp1->sp_id;
                if(!in_array($tmp1->sp_id, $tmpArr)){
                    $tmpPE1 =ProductEvent::where('event_id', $event_id)->where('sp_id', $tmp1->sp_id);
                    $tmpPE1->update(['status' => 0, 'so_luong' => 0]);
                    $tmpModel = SanPham::find($tmp1->sp_id);
                    $tmpModel->so_luong_ton = $tmp1->so_luong + $tmpModel->so_luong_ton;
                    $tmpModel->is_event = 0;
                    $tmpModel->save();
                }
            }
        }
        if(!empty($tmpArr)){
            $dataArr['created_user'] = Auth::user()->id;
            $dataArr['updated_user'] = Auth::user()->id;
            foreach ($tmpArr as $sp_id) {                

                if($sp_id > 0 && !in_array($sp_id, $arrIdDb)){
                    //check so luong hien tai
                    $tmpModel = SanPham::find($sp_id);
                    $so_luong_ton = $tmpModel->so_luong_ton;    

                    $dataArr['sp_id'] = $sp_id;
                    $dataArr['event_id'] = $event_id;
                    $dataArr['status'] = 1;
                    $dataArr['so_luong'] = !empty($so_luong) && isset($so_luong[$sp_id]) ? $so_luong[$sp_id] : 0;

                    $dataArr['so_luong'] = $dataArr['so_luong'] <= $so_luong_ton ? $dataArr['so_luong'] : $so_luong_ton;
                    $dataArr['so_luong_tam'] = $dataArr['so_luong'];
                    ProductEvent::create($dataArr);
                    $tmpModel->so_luong_ton = $so_luong_ton - $dataArr['so_luong'];
                    $tmpModel->is_event = 1;
                    $tmpModel->save();
                }
            }
        }
        if($request->is_add == 1){
            Session::flash('message', 'Thêm sản phẩm khuyến mãi thành công');
        }else{
            Session::flash('message', 'Cập nhật thành công');
        }
        return redirect()->route('events.product-event', $event_id);
    }
    public function ajaxSearch(Request $request){    
        
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

        return view('backend.events.content-search', compact( 'items', 'arrSearch', 'loaiSpArr', 'cateArr'));
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
            'slug' => 'required',
            'from_date' => 'required',
            'to_date' => 'required'
        ],
        [
            'name.required' => 'Bạn chưa nhập tên',
            'slug.required' => 'Bạn chưa nhập slug', 
            'from_date.required' => 'Bạn chưa nhập ngày bắt đầu',
            'to_date.required' => 'Bạn chưa nhập gày kết thúc'
        ]);               
        
        $dataArr['from_date'] = Carbon::parse($dataArr['from_date'])->format('Y-m-d H:i:s');
        $dataArr['to_date'] = Carbon::parse($dataArr['to_date'])->format('Y-m-d H:i:s');

        if($dataArr['small_banner'] && $dataArr['small_name']){
            
            $tmp = explode('/', $dataArr['small_banner']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('icho.upload_path').$dataArr['small_banner'], config('icho.upload_path').$destionation);
            
            $dataArr['small_banner'] = $destionation;
        }  
        if($dataArr['large_banner'] && $dataArr['large_name']){
            
            $tmp = explode('/', $dataArr['large_banner']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('icho.upload_path').$dataArr['large_banner'], config('icho.upload_path').$destionation);
            
            $dataArr['large_banner'] = $destionation;
        }
               
     
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;

        $rs = Events::create($dataArr);
        
        $id = $rs->id;

        $this->storeMeta( $id, 0, $dataArr);

        Session::flash('message', 'Tạo mới chương trình khuyến mãi thành công');

        return redirect()->route('events.index');
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

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        $detail = Events::find($id);

        $meta = (object) [];
        if ( $detail->meta_id > 0){

            $meta = MetaData::find( $detail->meta_id );

        }

        return view('backend.events.edit', compact( 'detail', 'meta'));
    }

    public function productEvent(Request $request)
    {
        $event_id = $request->event_id;
        $detail = Events::find($event_id);        
        $dataList = ProductEvent::where('event_id', $event_id)->where('product_event.status', 1)
                    ->join('san_pham', 'san_pham.id', '=', 'product_event.sp_id')
                    ->join('sp_hinh', 'san_pham.thumbnail_id', '=', 'sp_hinh.id')
                    ->join('loai_sp', 'san_pham.loai_id', '=', 'loai_sp.id')
                    ->join('cate', 'san_pham.cate_id', '=', 'cate.id')
                    ->select('san_pham.*', 'sp_hinh.*', 'loai_sp.name as ten_loai', 'cate.name as ten_cate', 'product_event.*', 'san_pham.id as sp_id')
                    ->get();        
        return view('backend.events.product-event', compact( 'detail', 'dataList'));
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
            'from_date' => 'required',
            'to_date' => 'required'
        ],
        [
            'name.required' => 'Bạn chưa nhập tên',
            'slug.required' => 'Bạn chưa nhập slug',
            'from_date.required' => 'Bạn chưa nhập ngày bắt đầu',
            'to_date.required' => 'Bạn chưa nhập gày kết thúc'
            
        ]);
        
        $dataArr['from_date'] = Carbon::parse($dataArr['from_date'])->format('Y-m-d H:i:s');
        $dataArr['to_date'] = Carbon::parse($dataArr['to_date'])->format('Y-m-d H:i:s');

        if($dataArr['small_banner'] && $dataArr['small_name']){
            
            $tmp = explode('/', $dataArr['small_banner']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('icho.upload_path').$dataArr['small_banner'], config('icho.upload_path').$destionation);
            
            $dataArr['small_banner'] = $destionation;
        }  
       
        if($dataArr['large_banner'] && $dataArr['large_name']){
            
            $tmp = explode('/', $dataArr['large_banner']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('icho.upload_path').$dataArr['large_banner'], config('icho.upload_path').$destionation);
            
            $dataArr['large_banner'] = $destionation;            
        }
        
        $dataArr['updated_user'] = Auth::user()->id;

        $model = Events::find($dataArr['id']);
        $model->update($dataArr);

        $this->storeMeta( $dataArr['id'], $dataArr['meta_id'], $dataArr);

        Session::flash('message', 'Cập nhật chương trình khuyến mãi thành công');

        return redirect()->route('events.edit', $dataArr['id']);
    }
    public function storeMeta( $id, $meta_id, $dataArr ){
       
        $arrData = [ 'title' => $dataArr['meta_title'], 'description' => $dataArr['meta_description'], 'keywords'=> $dataArr['meta_keywords'], 'custom_text' => $dataArr['custom_text'], 'updated_user' => Auth::user()->id ];
        if( $meta_id == 0){
            $arrData['created_user'] = Auth::user()->id;            
            $rs = MetaData::create( $arrData );
            $meta_id = $rs->id;
            
            $modelSp = Events::find( $id );
            $modelSp->meta_id = $meta_id;
            $modelSp->save();
        }else {
            $model = MetaData::find($meta_id);           
            $model->update( $arrData );
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
        $model = Events::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa chương trình khuyến mãi thành công');
        return redirect()->route('events.index');
    }
    public function destroyProduct(Request $request)
    {
        // delete
        $event_id = $request->event_id;
        $sp_id = $request->sp_id;       

        $tmpPE1 =ProductEvent::where('event_id', $event_id)->where('sp_id', $sp_id)->first();
        
        $tmpModel = SanPham::find($sp_id);
        $tmpModel->so_luong_ton = $tmpPE1->so_luong + $tmpModel->so_luong_ton;
        $tmpModel->is_event = 0;
        $tmpModel->save();

        $tmpPE1->update(['status' => 0, 'so_luong' => 0]);       

        // redirect
        Session::flash('message', 'Xóa sản phẩm khuyến mãi thành công');
        return redirect()->route('events.product-event', $event_id);
    }

}

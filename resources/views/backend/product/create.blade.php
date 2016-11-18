@extends('layout.backend')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Sản phẩm    
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('product.index') }}">Sản phẩm</a></li>
      <li class="active">Thêm mới</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('product.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('product.store') }}" id="dataForm">
    <div class="row">
      <!-- left column -->

      <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Thêm mới</h3>
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}          
            <div class="box-body">
                @if (count($errors) > 0)
                  <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                  </div>
                @endif
                <div>

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Thông tin cơ bản</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Thông tin chi tiết</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Hình ảnh</a></li>
                    <li role="presentation"><a href="#thuoctinh" aria-controls="thuoctinh" role="tab" data-toggle="tab">Thuộc tính</a></li>
                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Thông tin liên quan</a></li>  
                    <li role="presentation"><a href="#quatang" aria-controls="messages" role="tab" data-toggle="tab">Quà tặng</a></li>                    
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="form-group col-md-6 none-padding">
                          <label for="email">Danh mục cha<span class="red-star">*</span></label>
                          <select class="form-control" name="loai_id" id="loai_id">
                            <option value="">--Chọn--</option>
                            @foreach( $loaiSpArr as $value )
                            <option value="{{ $value->id }}" {{ $value->id == old('loai_id') || $value->id == $loai_id ? "selected" : "" }}>{{ $value->name }}</option>
                            @endforeach
                          </select>
                        </div>
                          <div class="form-group col-md-6 none-padding pleft-5">
                          <label for="email">Danh mục con<span class="red-star">*</span></label>

                          <select class="form-control" name="cate_id" id="cate_id">
                            <option value="">--Chọn--</option>
                            @foreach( $cateArr as $value )
                            <option value="{{ $value->id }}" {{ $value->id == old('cate_id') || $value->id == $cate_id ? "selected" : "" }}>{{ $value->name }}</option>
                            @endforeach
                          </select>
                        </div>  
                        <div class="form-group" >                  
                          <label>Tên <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">                  
                          <label>Slug <span class="red-star">*</span></label>                  
                          <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug') }}">
                        </div>
                        <div class="form-group" >                  
                          <label>Tên mở rộng</label>
                          <input type="text" class="form-control" name="name_extend" id="name_extend" value="{{ old('name_extend') }}">
                        </div>
                        <div class="form-group">                  
                          <label>Slug mở rộng</label>                  
                          <input type="text" class="form-control" name="slug_extend" id="slug_extend" value="{{ old('slug_extend') }}">
                        </div>
                        <div class="col-md-6 none-padding">
                          <div class="checkbox">
                              <label><input type="checkbox" name="is_hot" alue="1"> Sản phẩm HOT </label>
                          </div>                          
                        </div>
                        <div class="col-md-6 none-padding pleft-5">
                            <div class="checkbox">
                              <label><input type="checkbox" name="is_sale" alue="1"> Sản phẩm sale </label>
                          </div>
                        </div>
                        <div class="form-group" >                  
                            <label>Giá<span class="red-star">*</span></label>
                            <input type="text" class="form-control" name="price" id="price" value="{{ old('price') }}">
                        </div>
                        <div class="form-group col-md-6 none-padding" >                  
                            <label>Giá sale</label>
                            <input type="text" class="form-control" name="price_sale" id="price_sale" value="{{ old('price_sale') }}">
                        </div>
                        <div class="form-group col-md-6 none-padding pleft-5" >                  
                            <label>Phần trăm sale (%) </label>
                            <input type="text" class="form-control" name="sale_percent" id="sale_percent" value="{{ old('price_sale') }}">
                        </div>
                        <div class="clearfix"></div>
                    </div><!--end thong tin co ban-->                    
                    <div role="tabpanel" class="tab-pane" id="profile">
                      <div class="col-md-4 none-padding">
                        <label>Số lượng tồn<span class="red-star">*</span></label>                  
                        <input type="text" class="form-control" name="so_luong_ton" id="so_luong_ton" value="{{ old('so_luong_ton') }}">                        
                      </div>
                      <div class="col-md-4 none-padding pleft-5">
                          <label>Màu sắc</label>
                          <select name="color_id" id="color_id" class="form-control">
                              <option value="">--chọn--</option>
                              @if( $colorArr->count() > 0)
                                @foreach( $colorArr as $color )
                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                @endforeach
                              @endif

                          </select>
                      </div>
                      <div class="col-md-4 none-padding pleft-5">
                        <label>Cân nặng<span class="red-star">*</span></label>                  
                        <input type="text" class="form-control" name="can_nang" id="can_nang" value="{{ old('can_nang') }}">                        
                      </div>
                      <div class="col-md-4 none-padding">
                        <label>Chiều dài<span class="red-star">*</span></label>                  
                        <input type="text" class="form-control" name="chieu_dai" id="chieu_dai" value="{{ old('chieu_dai') }}">                        
                      </div>
                      <div class="col-md-4 none-padding pleft-5">
                        <label>Chiều rộng<span class="red-star">*</span></label>                  
                        <input type="text" class="form-control" name="chieu_rong" id="chieu_rong" value="{{ old('chieu_rong') }}">                        
                      </div>
                      <div class="col-md-4 none-padding pleft-5">
                        <label>Chiều cao<span class="red-star">*</span></label>                  
                        <input type="text" class="form-control" name="chieu_cao" id="chieu_cao" value="{{ old('chieu_cao') }}">                        
                      </div>
                      @if($loai_id == 7)
                      <div class="form-group">
                        <label>Số khe RAM (Mainboard)</label>                  
                        <input type="text" class="form-control" name="khe_ram" id="khe_ram" value="{{ old('khe_ram') }}">                        
                      </div>
                      @endif
                      <div class="clearfix"></div> 
                      <div class="form-group">
                        <div class="checkbox">
                            <label><input type="checkbox" name="is_primary" value="1"> Sản phẩm đại diện </label>
                        </div>                                                  
                          <input type="text" class="form-control" placeholder="Tên đại diện hiển thị" name="name_primary" id="name_primary" value="{{ old('name_primary') }}">
                      </div>
                      <div class="form-group">
                          
                      </div>
                      
                      <div class="form-group col-md-6 none-padding">
                          <label>Mô tả ngắn</label>
                          <textarea class="form-control" rows="4" name="mo_ta" id="mo_ta">{{ old('mo_ta') }}</textarea>
                        </div>
                      <div class="form-group col-md-6 none-padding pleft-5">
                        <label>Khuyến mãi</label>
                        <textarea class="form-control" rows="4" name="khuyen_mai" id="khuyen_mai">{{ old('khuyen_mai') }}</textarea>
                      </div>
                       
                      <div class="form-group">
                        <label>Chi tiết</label>
                        <textarea class="form-control" rows="10" name="chi_tiet" id="chi_tiet">{{ old('chi_tiet') }}</textarea>
                      </div>


                    </div><!--end thong tin chi tiet-->  
                     <div role="tabpanel" class="tab-pane" id="settings">
                        <div class="form-group" style="margin-top:10px;margin-bottom:10px">  
                         
                          <div class="col-md-12" style="text-align:center">                            
                            
                            <input type="file" id="file-image"  style="display:none" multiple/>
                         
                            <button class="btn btn-primary" id="btnUploadImage" type="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload</button>
                            <div class="clearfix"></div>
                            <div id="div-image" style="margin-top:10px"></div>
                          </div>
                          <div style="clear:both"></div>
                        </div>

                     </div><!--end hinh anh-->
                     <div role="tabpanel" class="tab-pane" id="thuoctinh">
                     
                     @if( !empty( $thuocTinhArr ))
                     <table class="table table-responsive table-bordered">
                      @foreach($thuocTinhArr as $loaithuoctinh)
                        <tr style="background-color:#CCC">
                          <td colspan="2">{{ $loaithuoctinh['name']}}</td>
                        </tr>
                        @if( !empty($loaithuoctinh['child']))
                          @foreach( $loaithuoctinh['child'] as $thuoctinh)
                          <tr>
                            <td width="150">{{ $thuoctinh['name']}}</td>
                            <td><input type="text" class="form-control" name="thuoc_tinh[{{ $thuoctinh['id'] }}]" ></td>
                          </tr>
                          @endforeach
                        @endif
                      @endforeach
                      </table>
                     @endif
                     
                     </div>
                     <div role="tabpanel" class="tab-pane" id="messages">
                     @if($loai_id == 3)
                        <div class="col-md-12">
                        <label>Mục đích sử dụng</label>
                        <ul id="list_muc_dich">
                          <li class="col-md-6"><div class="form-group">
                          <input type="checkbox" name="muc_dich[]" value="1" class="muc_dich" id="van_phong" {{ in_array(1, $mucDichArr) ? "checked" : "" }}>&nbsp;&nbsp;<label for="van_phong">Văn phòng</label>
                          </div>
                          </li>
                          <li class="col-md-6">
                            <div class="form-group">
                          <input type="checkbox" name="muc_dich[]" value="2" class="muc_dich" id="do_hoa" {{ in_array(2, $mucDichArr) ? "checked" : "" }}>&nbsp;&nbsp;<label for="do_hoa">Đồ họa</label></div></li>
                          <li class="col-md-6">
                            <div class="form-group">
                          <input type="checkbox" name="muc_dich[]" value="3" class="muc_dich" id="game" {{ in_array(3, $mucDichArr) ? "checked" : "" }}>&nbsp;&nbsp;<label for="game">Game</label></div></li>
                          <li class="col-md-6">
                            <div class="form-group">
                            <input type="checkbox" name="muc_dich[]" value="4" class="muc_dich" id="am_thanh" {{ in_array(4, $mucDichArr) ? "checked" : "" }}>&nbsp;&nbsp;<label for="am_thanh">Âm thanh</label></div></li>
                        </ul>
                      </div>
                      @endif
                        <div class="col-md-4">
                            <button class="btn btn-warning btn-sm btnLienQuan" data-value="phukien" type="button" id="btnPhuKien">Phụ kiện đi kèm</button>
                            <div class="clearfix"></div>
                            <div id="dataPhuKien" class="col-md-12 none-padding" style="min-height:150px; margin-top:5px"></div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-warning btn-sm btnLienQuan" data-value="tuongtu" type="button" id="btnTuongTu">Sản phẩm tương tự</button>
                            <div class="clearfix"></div>
                            <div id="dataTuongTu" class="col-md-12 none-padding" style="min-height:150px; margin-top:5px"></div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-warning btn-sm btnLienQuan" data-value="sosanh" type="button" id="btnSoSanh">Sản phẩm so sánh</button>
                            <div class="clearfix"></div>
                            <div id="dataSoSanh" class="col-md-12 none-padding" style="min-height:150px; margin-top:5px"></div>
                        </div>                        
                        <div class="clearfix"></div>
                     </div><!--end thong tin lien quan -->
                      <div role="tabpanel" class="tab-pane" id="quatang">
                        <div class="col-md-12 none-padding pleft-5">
                          <label>Kiểu hiển thị</label>
                          <select name="pro_style" id="pro_style" class="form-control">
                              <option value="0">Không có quà</option>
                              <option value="1">Hover ảnh</option>
                              <option value="2">Icon phía trên</option>                         </select>
                        </div>
                        <div class="form-group col-md-12" style="margin-top:10px;margin-bottom:10px">  
                          <label class="col-md-3 row">Ảnh quà tặng </label>
                          <div class="col-md-9">
                            <img id="thumbnail_image_pro" src="{{ old('image_pro') ? Helper::showImage(old('image_pro')) : URL::asset('backend/dist/img/img.png') }}" class="img-thumbnail" width="150">
                            
                            <input type="file" id="file-pro" style="display:none" />
                         
                            <button class="btn btn-default" id="btnUploadPro" type="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload</button>
                          </div>
                          <div style="clear:both"></div>
                        </div>
                        <div class="clearfix"></div>
                      </div><!--end quatang -->
                  </div>

                </div>
                  
            </div>
            <div class="box-footer">
              <input type="hidden" name="str_sp_sosanh" id="str_sp_sosanh" value="{{ old('str_sp_sosanh') }}" >
              <input type="hidden" name="str_sp_tuongtu" id="str_sp_tuongtu" value="{{ old('str_sp_tuongtu') }}" >
              <input type="hidden" name="str_sp_phukien" id="str_sp_phukien" value="{{ old('str_sp_phukien') }}" >
              <button type="button" class="btn btn-default" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary" id="btnSave">Lưu</button>
              <a class="btn btn-default" class="btn btn-primary" href="{{ route('product.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-4">      
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Thông tin SEO</h3>
          </div>

          <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <label>Meta title </label>
                <input type="text" class="form-control" name="meta_title" id="meta_title" value="{{ old('meta_title') }}">
              </div>
              <!-- textarea -->
              <div class="form-group">
                <label>Meta desciption</label>
                <textarea class="form-control" rows="6" name="meta_description" id="meta_description">{{ old('meta_description') }}</textarea>
              </div>  

              <div class="form-group">
                <label>Meta keywords</label>
                <textarea class="form-control" rows="4" name="meta_keywords" id="meta_keywords">{{ old('meta_keywords') }}</textarea>
              </div>  
              <div class="form-group">
                <label>Custom text</label>
                <textarea class="form-control" rows="6" name="custom_text" id="custom_text">{{ old('custom_text') }}</textarea>
              </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <!--/.col (left) -->      
    </div>
 <input type="hidden" name="image_pro" id="image_pro" value="{{ old('image_pro') }}"/> 
 <input type="hidden" name="pro_name" id="pro_name" value="{{ old('pro_name') }}"/>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@include ('backend.product.search-modal')
<input type="hidden" id="route_upload_tmp_image_multiple" value="{{ route('image.tmp-upload-multiple') }}">
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
<style type="text/css">
  .nav-tabs>li.active>a{
    color:#FFF !important;
    background-color: #3C8DBC !important;
  }

</style>
@stop
@section('javascript_page')
<script src="{{ URL::asset('backend/dist/js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
function filterAjax(type){  
  var str_params = $('#formSearchAjax').serialize();
  $.ajax({
          url: '{{ route("product.ajax-search") }}',
          type: "POST",
          async: true,      
          data: str_params + '&search_type=' + type,
          beforeSend:function(){
            $('#contentSearch').html('<div style="text-align:center"><img src="{{ URL::asset('backend/dist/img/loading.gif')}}"></div>');
          },        
          success: function (response) {
            $('#contentSearch').html(response);
            $('#myModalSearch').modal('show');
            //$('.selectpicker').selectpicker();            
            //check lai nhung checkbox da checked
            if( type == "phukien"){
              var str_checked = $('#str_sp_phukien').val();
              tmpArr = str_checked.split(",");              
              for (i = 0; i < tmpArr.length; i++) { 
                  $('input.checkSelect[value="'+ tmpArr[i] +'"]').prop('checked', true);
              }
            }else if( type == "tuongtu"){
              var str_checked = $('#str_sp_tuongtu').val();
              tmpArr = str_checked.split(",");              
              for (i = 0; i < tmpArr.length; i++) { 
                  $('input.checkSelect[value="'+ tmpArr[i] +'"]').prop('checked', true);
              }
            }else{
              var str_checked = $('#str_sp_sosanh').val();
              tmpArr = str_checked.split(",");              
              for (i = 0; i < tmpArr.length; i++) { 
                  $('input.checkSelect[value="'+ tmpArr[i] +'"]').prop('checked', true);
              }
            }
          }
    });
}
$(document).on('click', '.remove-image', function(){
  if( confirm ("Bạn có chắc chắn không ?")){
    $(this).parents('.col-md-3').remove();
  }
});
$(document).on('click', '.checkSelect', function(){
  var type = $('#search_type').val();
  var obj = $(this);
  if( type == "phukien"){
    var str_sp_phukien = $('#str_sp_phukien').val();
    if(obj.prop('checked') == true){
      str_sp_phukien += obj.val() + ',';
    }else{
      var str = obj.val() + ',';
      str_sp_phukien = str_sp_phukien.replace(str, '');
    }
    $('#str_sp_phukien').val(str_sp_phukien);
  }else if( type == "tuongtu"){
    var str_sp_tuongtu = $('#str_sp_tuongtu').val();
    if(obj.prop('checked') == true){
      str_sp_tuongtu += obj.val() + ',';
    }else{
      var str = obj.val() + ',';
      str_sp_tuongtu = str_sp_tuongtu.replace(str, '');
    }
    $('#str_sp_tuongtu').val(str_sp_tuongtu);
  }else{ // so sanh
    var str_sp_sosanh = $('#str_sp_sosanh').val();
    if(obj.prop('checked') == true){
      str_sp_sosanh += obj.val() + ',';
    }else{
      var str = obj.val() + ',';
      str_sp_sosanh = str_sp_sosanh.replace(str, '');
    }
    $('#str_sp_sosanh').val(str_sp_sosanh);
  }
});
$(document).on('click', '.btnRemoveRelated', function(){
  if( confirm ("Bạn có chắc chắn không ?")){
    var obj = $(this);
    var type = obj.attr('data-type');
    var value = obj.attr('data-value');
    var str_sp = $('#str_sp_' + type).val();
    console.log(str_sp);
      var str = value + ',';
      console.log(value);
      console.log(str);
      str_sp = str_sp.replace(str, '');
    console.log(str_sp);
    $('#str_sp_' + type).val(str_sp);
    $('#row-'+ type + '-' + value).remove();
    



  }
});
$(document).on('change', '#loai_id_search, #cate_id_search', function(){
  filterAjax($('#search_type').val());
});
$(document).on('click', '#btnSearchAjax', function(){
  filterAjax($('#search_type').val());
});
$(document).on('keypress', '#name_search', function(e){
  if(e.which == 13) {
      e.preventDefault();
      filterAjax($('#search_type').val());
  }
});
$(document).on('click', 'button.btnSaveSearch',function(){
  var type = $('#search_type').val();  
  if (type == "phukien"){
    str_value = $('#str_sp_phukien').val();
  }else if( type == "tuongtu"){
    str_value = $('#str_sp_tuongtu').val();
  }else{
    str_value = $('#str_sp_sosanh').val();
  }
  if( str_value != '' ){
    
    $.ajax({
          url: '{{ route("product.ajax-save-related") }}',
          type: "POST",
          async: true,      
          data: {          
            type : type,    
            str_value : str_value,
            _token: "{{ csrf_token() }}"
          },     
          success: function (response) {
            if (type == "phukien"){
              
              $('#dataPhuKien').html(response);

            }else if( type == "tuongtu"){

              $('#dataTuongTu').html(response);

            }else{

              $('#dataSoSanh').html(response);

            }
            $('#myModalSearch').modal('hide');
            
          }
    });
    
  }else{
    alert('Vui lòng chọn ít nhất 1 sản phẩm.');
    return false;
  }

});
    $(document).ready(function(){
      $('#btnUploadPro').click(function(){        
        $('#file-pro').click();
      });      
      var files = "";
      $('#file-pro').change(function(e){
         files = e.target.files;
         
         if(files != ''){
           var dataForm = new FormData();        
          $.each(files, function(key, value) {
             dataForm.append('file', value);
          });   
          
          dataForm.append('date_dir', 1);
          dataForm.append('folder', 'tmp');

          $.ajax({
            url: $('#route_upload_tmp_image').val(),
            type: "POST",
            async: false,      
            data: dataForm,
            processData: false,
            contentType: false,
            success: function (response) {
              if(response.image_path){
                $('#thumbnail_image_pro').attr('src',$('#upload_url').val() + response.image_path);
                $( '#image_pro' ).val( response.image_path );
                $( '#pro_name' ).val( response.image_name );
              }
              console.log(response.image_path);
                //window.location.reload();
            },
            error: function(response){                             
                var errors = response.responseJSON;
                for (var key in errors) {
                  
                }
                //$('#btnLoading').hide();
                //$('#btnSave').show();
            }
          });
        }
      });
      $('.btnLienQuan').click(function(){
        var type = $(this).attr('data-value');
        if( type == "phukien") {
          $('#label-search').html("phụ kiện đi kèm");
        }else if( type == "tuongtu" ){
          $('#label-search').html("sản phẩm tương tự");
        }else{
          $('#label-search').html("sản phẩm so sánh");
        }
        filterAjax(type);
      });      
      $('#loai_id').change(function(){
        location.href="{{ route('product.create') }}?loai_id=" + $(this).val();
      })
      $(".select2").select2();
      $('#dataForm').submit(function(){
        /*var no_cate = $('input[name="category_id[]"]:checked').length;
        if( no_cate == 0){
          swal("Lỗi!", "Chọn ít nhất 1 thể loại!", "error");
          return false;
        }
        var no_country = $('input[name="country_id[]"]:checked').length;
        if( no_country == 0){
          swal("Lỗi!", "Chọn ít nhất 1 quốc gia!", "error");
          return false;
        }        
        */
        $('#btnSave').hide();
        $('#btnLoading').show();
      });
      var editor = CKEDITOR.replace( 'chi_tiet',{
          language : 'vi',
          height: 300,
          filebrowserBrowseUrl: "{{ URL::asset('/backend/dist/js/kcfinder/browse.php?type=files') }}",
          filebrowserImageBrowseUrl: "{{ URL::asset('/backend/dist/js/kcfinder/browse.php?type=images') }}",
          filebrowserFlashBrowseUrl: "{{ URL::asset('/backend/dist/js/kcfinder/browse.php?type=flash') }}",
          filebrowserUploadUrl: "{{ URL::asset('/backend/dist/js/kcfinder/upload.php?type=files') }}",
          filebrowserImageUploadUrl: "{{ URL::asset('/backend/dist/js/kcfinder/upload.php?type=images') }}",
          filebrowserFlashUploadUrl: "{{ URL::asset('/backend/dist/js/kcfinder/upload.php?type=flash') }}"
      });
      var editor2 = CKEDITOR.replace( 'khuyen_mai',{
          language : 'vi',
          height : 100,
          toolbarGroups : [
            
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
            { name: 'links', groups: [ 'links' ] },           
            '/',
            
          ]
      });
      var editor3 = CKEDITOR.replace( 'mo_ta',{
          language : 'vi',
          height : 100,
          toolbarGroups : [
            
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
            { name: 'links', groups: [ 'links' ] },           
            '/',
            
          ]
      });
      $('#btnUploadImage').click(function(){        
        $('#file-image').click();
      }); 
     
      var files = "";
      $('#file-image').change(function(e){
         files = e.target.files;
         
         if(files != ''){
           var dataForm = new FormData();        
          $.each(files, function(key, value) {
             dataForm.append('file[]', value);
          });   
          
          dataForm.append('date_dir', 0);
          dataForm.append('folder', 'tmp');

          $.ajax({
            url: $('#route_upload_tmp_image_multiple').val(),
            type: "POST",
            async: false,      
            data: dataForm,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#div-image').append(response);
                if( $('input.thumb:checked').length == 0){
                  $('input.thumb').eq(0).prop('checked', true);
                }
            },
            error: function(response){                             
                var errors = response.responseJSON;
                for (var key in errors) {
                  
                }
                //$('#btnLoading').hide();
                //$('#btnSave').show();
            }
          });
        }
      });
     

      $('#name').change(function(){
         var name = $.trim( $(this).val() );
         if( name != '' && $('#slug').val() == ''){
            $.ajax({
              url: $('#route_get_slug').val(),
              type: "POST",
              async: false,      
              data: {
                str : name
              },              
              success: function (response) {
                if( response.str ){                  
                  $('#slug').val( response.str );
                }                
              },
              error: function(response){                             
                  var errors = response.responseJSON;
                  for (var key in errors) {
                    
                  }
                  //$('#btnLoading').hide();
                  //$('#btnSave').show();
              }
            });
         }
      });  
       $('#name_extend').change(function(){
         var name = $.trim( $(this).val() );
         if( name != '' && $('#slug_extend').val() == ''){
            $.ajax({
              url: $('#route_get_slug').val(),
              type: "POST",
              async: false,      
              data: {
                str : name
              },              
              success: function (response) {
                if( response.str ){                  
                  $('#slug_extend').val( response.str );
                }                
              },
              error: function(response){                             
                  var errors = response.responseJSON;
                  for (var key in errors) {
                    
                  }
                  //$('#btnLoading').hide();
                  //$('#btnSave').show();
              }
            });
         }
      });     
     
      
    });
    
</script>
@stop

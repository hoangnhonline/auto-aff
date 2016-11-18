@extends('layout.backend')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Sản phẩm tương thích : <span style="color:red">{{ $detail->name }}</span>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('product.index') }}">Sản phẩm</a></li>
      <li class="active">Sản phẩm tương thích</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ URL::previous() }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('product.save-sp-tuong-thich') }}" id="dataForm">
    <input type="hidden" name="id" value="{{ $detail->id }}" id="id">
    <input type="hidden" name="back_url" value="{{ URL::previous() }}">
    <div class="row">
      <!-- left column -->

      <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Chọn sản phẩm tương thích</h3>
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
                @if($detail->cate_id != 31)
                <div class="col-md-4">
                      <button class="btn btn-warning btn-sm btnLienQuan" data-value="31" type="button" id="btnMainboard">Mainboard</button>
                      <div class="clearfix"></div>
                      <div id="dataMainboard" class="col-md-12 none-padding" style="min-height:150px; margin-top:5px">
                        @if(isset($spSelected[31]) && !empty($spSelected[31]))
                        <table class="table table-responsive table-bordered">                       
                        @foreach($spSelected[31] as $sp_id)
                          <tr id="row-31-{{ $productArr[$sp_id]->id }}">
                            <td width="80%">{{ $productArr[$sp_id]->name }} 
                            <input type="hidden" name="sp_tuongthich_31[]" value="{{$productArr[$sp_id]->id }}">
                            </td>
                            <td>      
                            <button class="btn btn-sm btn-danger btnRemoveTuongThich" type="button" data-value="{{ $productArr[$sp_id]->id }}" data-type="31">Xóa</button>
                            </td>
                          </tr>
                         
                        @endforeach                        
                        </table>
                        @endif

                      </div>
                </div>
                @endif
                @if($detail->cate_id != 32)
                <div class="col-md-4">
                    <button class="btn btn-warning btn-sm btnLienQuan" data-value="32" type="button" id="btnCpu">CPU</button>
                    <div class="clearfix"></div>
                    <div id="dataCpu" class="col-md-12 none-padding" style="min-height:150px; margin-top:5px">
                        @if(isset($spSelected[32]) && !empty($spSelected[32]))
                        <table class="table table-responsive table-bordered">                       
                        @foreach($spSelected[32] as $sp_id)
                          <tr id="row-32-{{ $productArr[$sp_id]->id }}">
                            <td width="80%">{{ $productArr[$sp_id]->name }} 
                            <input type="hidden" name="sp_tuongthich_32[]" value="{{ $productArr[$sp_id]->id }}">
                            </td>
                            <td>      
                            <button class="btn btn-sm btn-danger btnRemoveTuongThich" type="button" data-value="{{ $productArr[$sp_id]->id }}" data-type="32">Xóa</button>
                            </td>
                          </tr>
                         
                        @endforeach                        
                        </table>
                        @endif

                    </div>
                </div>
                @endif
                @if($detail->cate_id != 85)
                <div class="col-md-4">
                    <button class="btn btn-warning btn-sm btnLienQuan" data-value="85" type="button" id="btnCpu">VGA</button>
                    <div class="clearfix"></div>
                    <div id="dataVga" class="col-md-12 none-padding" style="min-height:150px; margin-top:5px">
                        @if(isset($spSelected[85]) && !empty($spSelected[85]))
                        <table class="table table-responsive table-bordered">                       
                        @foreach($spSelected[85] as $sp_id)
                          <tr id="row-85-{{ $productArr[$sp_id]->id }}">
                            <td width="80%">{{ $productArr[$sp_id]->name }} 
                            <input type="hidden" name="sp_tuongthich_85[]" value="{{ $productArr[$sp_id]->id }}">
                            </td>
                            <td>      
                            <button class="btn btn-sm btn-danger btnRemoveTuongThich" type="button" data-value="{{ $productArr[$sp_id]->id }}" data-type="85">Xóa</button>
                            </td>
                          </tr>
                         
                        @endforeach                        
                        </table>
                        @endif

                    </div>
                </div>                
                @endif
                @if($detail->cate_id != 35)
                <div class="col-md-4">
                    <button class="btn btn-warning btn-sm btnLienQuan" data-value="35" type="button" id="btnRam">RAM</button>
                    <div class="clearfix"></div>
                    <div id="dataRam" class="col-md-12 none-padding" style="min-height:150px; margin-top:5px">
                        @if(isset($spSelected[35]) && !empty($spSelected[35]))
                        <table class="table table-responsive table-bordered">                       
                        @foreach($spSelected[35] as $sp_id)
                          <tr id="row-35-{{ $productArr[$sp_id]->id }}">
                            <td width="80%">{{ $productArr[$sp_id]->name }} 
                            <input type="hidden" name="sp_tuongthich_35[]" value="{{ $productArr[$sp_id]->id }}">
                            </td>
                            <td>      
                            <button class="btn btn-sm btn-danger btnRemoveTuongThich" type="button" data-value="{{ $productArr[$sp_id]->id }}" data-type="35">Xóa</button>
                            </td>
                          </tr>
                         
                        @endforeach                        
                        </table>
                        @endif

                    </div>
                </div>                
                @endif
                
                  
            </div>
            <div class="box-footer">
              <input type="hidden" name="str_sp_mainboard" id="str_sp_mainboard" value="{{ $str_sp_mainboard }}" >
              <input type="hidden" name="str_sp_vga" id="str_sp_vga" value="{{ $str_sp_vga }}" >
              <input type="hidden" name="str_sp_cpu" id="str_sp_cpu" value="{{ $str_sp_cpu }}" >
              <input type="hidden" name="str_sp_ram" id="str_sp_ram" value="{{ $str_sp_ram }}" >
              <button type="button" class="btn btn-default" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary" id="btnSave">Lưu</button>
              <a class="btn btn-default" class="btn btn-primary" href="{{ URL::previous() }}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
    
      <!--/.col (left) -->      
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@include ('backend.product.tuong-thich.search-modal-tuong-thich')
<input type="hidden" id="route_upload_tmp_image_multiple" value="{{ route('image.tmp-upload-multiple') }}">
<style type="text/css">
  .nav-tabs>li.active>a{
    color:#FFF !important;
    background-color: #3C8DBC !important;
  }
  #list_muc_dich li{
    list-style: none !important;
  }

</style>
@stop
@section('javascript_page')
<script src="{{ URL::asset('backend/dist/js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
function filterAjax(cate_id){  
  $('#loai_id_search').val(7);
  $('#cate_id_search').val(cate_id);  
  var str_params = $('#formSearchAjaxTuongThich').serialize();
  $.ajax({
          url: '{{ route("product.ajax-search-tuong-thich") }}',
          type: "POST",
          async: true,      
          data: str_params + '&cate_id=' + cate_id,
          beforeSend:function(){
            $('#contentSearch').html('<div style="text-align:center"><img src="{{ URL::asset('backend/dist/img/loading.gif')}}"></div>');
          },        
          success: function (response) {
            $('#contentSearchTuongThich').html(response);
            $('#myModalSearch').modal('show');
            //$('.selectpicker').selectpicker();            
            //check lai nhung checkbox da checked
            if( cate_id == "31"){
              var str_checked = $('#str_sp_mainboard').val();
              tmpArr = str_checked.split(",");              
              for (i = 0; i < tmpArr.length; i++) { 
                  $('input.checkSelect[value="'+ tmpArr[i] +'"]').prop('checked', true);
              }
            }else if( cate_id == "32"){
              var str_checked = $('#str_sp_cpu').val();
              tmpArr = str_checked.split(",");              
              for (i = 0; i < tmpArr.length; i++) { 
                  $('input.checkSelect[value="'+ tmpArr[i] +'"]').prop('checked', true);
              }
            }else if( cate_id == "35"){
              var str_checked = $('#str_sp_ram').val();
              tmpArr = str_checked.split(",");              
              for (i = 0; i < tmpArr.length; i++) { 
                  $('input.checkSelect[value="'+ tmpArr[i] +'"]').prop('checked', true);
              }
            }else{
              var str_checked = $('#str_sp_vga').val();
              tmpArr = str_checked.split(",");              
              for (i = 0; i < tmpArr.length; i++) { 
                  $('input.checkSelect[value="'+ tmpArr[i] +'"]').prop('checked', true);
              }
            }
          }
    });
}

$(document).on('click', '.checkSelect', function(){
  var cate_id = $('#cate_id_search').val();
  console.log(cate_id);
  var obj = $(this);
  if( cate_id == "31"){
    var str_sp_mainboard = $('#str_sp_mainboard').val();
    if(obj.prop('checked') == true){
      str_sp_mainboard += obj.val() + ',';
    }else{
      var str = obj.val() + ',';
      str_sp_mainboard = str_sp_mainboard.replace(str, '');
    }
    $('#str_sp_mainboard').val(str_sp_mainboard);
  }else if( cate_id == "32"){
    var str_sp_cpu = $('#str_sp_cpu').val();
    if(obj.prop('checked') == true){
      str_sp_cpu += obj.val() + ',';
    }else{
      var str = obj.val() + ',';
      str_sp_cpu = str_sp_cpu.replace(str, '');
    }
    $('#str_sp_cpu').val(str_sp_cpu);
  }else if( cate_id == "35"){
    var str_sp_ram = $('#str_sp_ram').val();
    if(obj.prop('checked') == true){
      str_sp_ram += obj.val() + ',';
    }else{
      var str = obj.val() + ',';
      str_sp_ram = str_sp_ram.replace(str, '');
    }
    $('#str_sp_ram').val(str_sp_ram);
  }else{ // so sanh
    var str_sp_vga = $('#str_sp_vga').val();
    if(obj.prop('checked') == true){
      str_sp_vga += obj.val() + ',';
    }else{
      var str = obj.val() + ',';
      str_sp_vga = str_sp_vga.replace(str, '');
    }
    $('#str_sp_vga').val(str_sp_vga);
  }
});
$(document).on('click', '.btnRemoveTuongThich', function(){
  if( confirm ("Bạn có chắc chắn không ?")){
    var obj = $(this);
    var type = obj.attr('data-type');
    var value = obj.attr('data-value');
    if( type == "31"){
      var name = "mainboard";
    }else if(type == "32"){
      var name = "cpu";
    }else if(type == "35"){
      var name = "ram";
    }else{
      var name = "vga";
    }
    var str_sp = $('#str_sp_' + name).val();
   
      var str = value + ',';
    
      str_sp = str_sp.replace(str, '');
    
    
    $('#str_sp_' + name).val(str_sp);
    $('#row-'+ type + '-' + value).remove(); 
  }
});

$(document).on('click', '#btnSearchAjax', function(){
  filterAjax($('#cate_id_search').val());
});
$(document).on('keypress', '#name_search', function(e){
  if(e.which == 13) {
      e.preventDefault();
      filterAjax($('#cate_id_search').val());
  }
});
$(document).on('click', 'button.btnSaveSearch',function(){
  var cate_id = $('#cate_id_search').val();  
  console.log(cate_id);
  if (cate_id == "31"){
    str_value = $('#str_sp_mainboard').val();
  }else if( cate_id == "32"){
    str_value = $('#str_sp_cpu').val();
  }else if( cate_id == "35"){
    str_value = $('#str_sp_ram').val();
  }else{
    str_value = $('#str_sp_vga').val();
  }
  if( str_value != '' ){
    
    $.ajax({
          url: '{{ route("product.ajax-save-tuong-thich") }}',
          type: "POST",
          async: true,      
          data: {          
            cate_id : cate_id,    
            str_value : str_value,
            _token: "{{ csrf_token() }}"
          },     
          success: function (response) {
            if (cate_id == "31"){
              
              $('#dataMainboard').html(response);

            }else if( cate_id == "32"){

              $('#dataCpu').html(response);

            }else if( cate_id == "35"){

              $('#dataRam').html(response);

            }else{

              $('#dataVga').html(response);

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
      $('.btnLienQuan').click(function(){
        var type = $(this).attr('data-value');
        if( type == "31") {
          $('#label-search').html("mainboard tương thích");
        }else if( type == "32" ){
          $('#label-search').html("CPU tương thích");
        }else if( type == "35" ){
          $('#label-search').html("RAM tương thích");
        }else{
          $('#label-search').html("VGA tương thích");
        }
        filterAjax(type);
      });      
      
      $(".select2").select2();
      $('#dataForm').submit(function(){      
        if($('input.muc_dich:checked').length == 0){
          alert('Vui lòng chọn ít nhất 1 mục đích sử dụng');
          return false;
        }  
        $('#btnSave').hide();
        $('#btnLoading').show();
      });
      
     
      
    });
    
</script>
@stop

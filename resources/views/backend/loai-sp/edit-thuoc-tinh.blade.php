@extends('layout.backend')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Thuộc tính hiển thị
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'loai-sp.list-thuoc-tinh', [ 'loai_id' => $detailLoai->id ] ) }}">Thuộc tính hiển thị</a></li>
    <li class="active">Cập nhật</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif    
      <form method="POST" action="{{ route('loai-sp.update-thuoc-tinh')}}" >
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Cập nhật thông tin hiển thị khi hover : <span style="color:red">{{ $detailLoai->name }}</span></h3>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ $detail->id }}">
        <!-- /.box-header -->
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
        <div class="form-group">
        	<label class="">Text hiển thị</label>
        	<input type="text" name="text_hien_thi" class="form-control" value="{{ $detail->text_hien_thi }}">
        </div>
        <input type="hidden" name="loai_id" value="{{ $detailLoai->id }}">
        <input type="hidden" name="display_order" value="{{ $detail->display_order }}">
        <label class="">Chọn thuộc tính</label>
         @if( !empty( $thuocTinhArr ))
         <table class="table table-responsive table-bordered">
          @foreach($thuocTinhArr as $loaithuoctinh)
            <tr style="background-color:#CCC">
              <td colspan="2">{{ $loaithuoctinh['name']}}</td>
            </tr>
            @if( !empty($loaithuoctinh['child']))
              @foreach( $loaithuoctinh['child'] as $thuoctinh)
              <tr>
              <td width="1%"><input type="checkbox" name="str_thuoc_tinh_id[]" value="{{ $thuoctinh['id'] }}" {{ in_array($thuoctinh['id'], $arrSelected) ? "checked" : "" }}></td>
                <td >{{ $thuoctinh['name']}}</td>
                
              </tr>
              @endforeach
            @endif
          @endforeach
          </table>
         @endif
         <div class="box-footer">
          <button type="submit" class="btn btn-primary">Lưu</button>
          <a class="btn btn-default" class="btn btn-primary" href="{{ route('loai-sp.list-thuoc-tinh', ['loai_id' => $detailLoai->id ])}}">Hủy</a>
        </div>
        </div>        
      </div>
      </form>
      <!-- /.box -->     
    </div>
    <!-- /.col -->  
  </div> 
</section>
<!-- /.content -->
</div>
<input type="hidden" id="route-ajax-get-thuoc-tinh-by-id" value="{{ route('loai-thuoc-tinh.ajax-get-loai-thuoc-tinh-by-id') }}">
@stop
@section('javascript_page')
<script type="text/javascript">
function callDelete(name, url){  
  swal({
    title: 'Bạn muốn xóa "' + name +'"?',
    text: "Dữ liệu sẽ không thể phục hồi.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then(function() {
    location.href= url;
  })
  return flag;
}
$(document).ready(function(){
  $('#loai_id, #loai_thuoc_tinh_id').change(function(){
    $('#searchForm').submit();
  });
  $('#loai_id').change(function(){
    $.ajax({
      url : $('#route-ajax-get-thuoc-tinh-by-id').val(),
      data : {
        loai_id : $(this).val()
      },
      type: "GET",
      success : function(data){
        $('#loai_thuoc_tinh_id').html(data);
      }
    })
  });
  $('#table-list-data tbody').sortable({
        placeholder: 'placeholder',
        handle: ".move",
        start: function (event, ui) {
                ui.item.toggleClass("highlight");
        },
        stop: function (event, ui) {
                ui.item.toggleClass("highlight");
        },          
        axis: "y",
        update: function() {
            var rows = $('#table-list-data tbody tr');
            var strOrder = '';
            var strTemp = '';
            for (var i=0; i<rows.length; i++) {
                strTemp = rows[i].id;
                strOrder += strTemp.replace('row-','') + ";";
            }     
            updateOrder("loai_thuoc-tinh", strOrder);
        }
    });
});
function updateOrder(table, strOrder){
  $.ajax({
      url: $('#route_update_order').val(),
      type: "POST",
      async: false,
      data: {          
          str_order : strOrder,
          table : table
      },
      success: function(data){
          var countRow = $('#table-list-data tbody tr span.order').length;
          for(var i = 0 ; i < countRow ; i ++ ){
              $('span.order').eq(i).html(i+1);
          }                        
      }
  });
}
</script>
@stop
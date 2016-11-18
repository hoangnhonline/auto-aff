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
    <li class="active">Danh sách</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
      <a href="{{ route('loai-sp.thuoc-tinh', ['loai_id' => $detailLoai->id]) }}" class="btn btn-info" style="margin-bottom:5px">Tạo mới</a>
       <a class="btn btn-default" class="btn btn-primary" href="{{ route('loai-sp.index')}}" style="margin-bottom:5px">Quay lại</a>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Thông tin hiển thị khi hover : <span style="color:red">{{ $detailLoai->name }}</span></h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>
              <th style="width: 1%;white-space:nowrap">Thứ tự</th>
              <th>Text hiển thị</th>
              <th>Thuộc tính hiển thị</th>             
              <th width="1%;white-space:nowrap">Thao tác</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order">{{ $i }}</span></td>
                <td style="vertical-align:middle;text-align:center">
                  <img src="{{ URL::asset('backend/dist/img/move.png')}}" class="move img-thumbnail" alt="Cập nhật thứ tự"/>
                </td>
                <td>                  
                  <a href="{{ route( 'loai-sp.edit', [ 'id' => $item->id ]) }}">{{ $item->text_hien_thi }}</a>
                  
                </td>
                <td>
                 <?php 
                 $tmp = explode(',', $item->str_thuoctinh_id);
                 foreach ($tmp as $key => $value) {
                   echo $thuoctinh[$value];
                   echo "<br>";
                 }
                 ?>
                </td>
                <td style="white-space:nowrap; text-align:right">
                 
                  <a href="{{ route( 'loai-sp.edit-thuoc-tinh', [ 'loai_id' => $item->loai_id,'id' => $item->id ]) }}" class="btn-sm btn btn-warning">Chỉnh sửa</a>                 
                  
                  <a onclick="return callDelete('{{ $item->text_hien_thi }}','{{ route( 'loai-sp.destroyThuocTinh', ['loai_id' => $item->loai_id, 'id' => $item->id ]) }}');" class="btn-sm btn btn-danger">Xóa</a>
                 
                </td>
              </tr> 
              @endforeach
            @else
            <tr>
              <td colspan="9">Không có dữ liệu.</td>
            </tr>
            @endif

          </tbody>
          </table>
        </div>        
      </div>
      <!-- /.box -->     
    </div>
    <!-- /.col -->  
  </div> 
</section>
<!-- /.content -->
</div>
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
            updateOrder("hover_info", strOrder);
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
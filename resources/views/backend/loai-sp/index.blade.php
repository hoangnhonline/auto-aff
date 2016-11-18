@extends('layout.backend')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Danh mục cha 
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'loai-sp.index' ) }}">Danh mục cha</a></li>
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
      <a href="{{ route('loai-sp.create') }}" class="btn btn-info" style="margin-bottom:5px">Tạo mới</a>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách</h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>
              <th style="width: 1%;white-space:nowrap">Thứ tự</th>
              <th>Tên</th>
              <th style="text-align:center">Danh mục con</th>
              <th style="text-align:center">Icon</th>         
              <th>Style hiển thị</th>
              <th style="text-align:center">Màu nền</th>
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
                  <a href="{{ route( 'loai-sp.edit', [ 'id' => $item->id ]) }}">{{ $item->name }}</a>
                  
                  @if( $item->is_hot == 1 )
                  <img class="img-thumbnail" src="{{ URL::asset('backend/dist/img/star.png')}}" alt="Nổi bật" title="Nổi bật" />
                  @endif
                   @if( $item->is_hover == 1 )
                  <a href="{{ route('loai-sp.thuoc-tinh', [ 'loai_id' => $item->id ]) }}" style="float:right"><label style="cursor:pointer" class="label label-info">Thuộc tính hover</label></a>
                  @endif
                  <p>{{ $item->description }}</p>
                </td>
                <td style="text-align:center"><a class="btn btn-info" href="{{ route('cate.index', [$item->id])}}">{{ $item->cates->count() }}</a></td>
                <td style="text-align:center">
                  <img class="img-thumbnail" src="{{ $item->icon_mau ? config( 'icho.upload_url' ).$item->icon_mau  : 'http://placehold.it/60x60' }}" width="40" />
                </td>               
                <td>
                 <?php
                  if( $item->home_style == 1 ) echo "Banner lớn đứng ";
                  elseif( $item->home_style == 2 ) echo "Banner nhỏ đứng ";
                  elseif( $item->home_style == 3 ) echo "Banner ngang ";
                  else echo "Không banner";
                  ?>
                </td>
                <td style="text-align:center">
                  @if( $item->bg_color )
                    <span class="img-thumbnail" style="width:40px; height:40px;background-color:{{ $item->bg_color }};display:block;margin:auto">&nbsp;</span>
                  @else
                  Mặc định
                  @endif
                </td>
                <td style="white-space:nowrap; text-align:right">
                  @if($item->home_style > 0)
                  <a class="btn btn-primary btn-sm" href="{{ route('banner.index', ['object_type' => 1, 'object_id' => $item->id]) }}" ><span class="badge">
                    {{ $item->banners->count() }}
                  </span> Banner </a>
                  @endif
                  <a href="{{ route( 'loai-sp.edit', [ 'id' => $item->id ]) }}" class="btn-sm btn btn-warning">Chỉnh sửa</a>                 
                  @if( $item->cates->count() == 0)
                  <a onclick="return callDelete('{{ $item->name }}','{{ route( 'loai-sp.destroy', [ 'id' => $item->id ]) }}');" class="btn-sm btn btn-danger">Xóa</a>
                  @endif
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
            updateOrder("loai_sp", strOrder);
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
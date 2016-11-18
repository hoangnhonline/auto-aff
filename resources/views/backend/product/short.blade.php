@extends('layout.backend')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@if(Auth::user()->email != "huongll@icho.vn")
<section class="content-header">
  <h1>
    Sản phẩm
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'product.short' ) }}">Sản phẩm</a></li>
    <li class="active">Danh sách</li>
  </ol>
</section>
@endif
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
        
      <div class="panel panel-default">        
        <div class="panel-body">
          <form class="form-inline" id="searchForm" role="form" method="GET" action="{{ route('product.short') }}">
           
          
            
            <div class="form-group">
              <label for="email">Danh mục cha&nbsp;</label>
              <select class="form-control" name="loai_id" id="loai_id">
                <option value="">--Tất cả--</option>
                @foreach( $loaiSpArr as $value )
                <option value="{{ $value->id }}" {{ $value->id == $arrSearch['loai_id'] ? "selected" : "" }}>{{ $value->name }}</option>
                @endforeach
              </select>
            </div>
              <div class="form-group">
              <label for="email">Danh mục con&nbsp;</label>

              <select class="form-control" name="cate_id" id="cate_id">
                <option value="">--Tất cả--</option>
                @foreach( $cateArr as $value )
                <option value="{{ $value->id }}" {{ $value->id == $arrSearch['cate_id'] ? "selected" : "" }}>{{ $value->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="email">Tên&nbsp;&nbsp;</label>
              <input type="text" class="form-control" name="name" value="{{ $arrSearch['name'] }}">
            </div>            
            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
          </form>         
        </div>
      </div>
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif   
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title col-md-5" style="padding-top:5px">Danh sách ( {{ $items->total() }} sản phẩm )</h3>
          <div class="col-md-7" style="text-align:left">{{ $items->appends( $arrSearch )->links() }}</div>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:center">
           
          </div>  
          <table class="table table-bordered" id="table-list-data" style="font-size:15px">
            <tr>
              <th style="width: 1%">#</th>              
              <th style="text-align:left">Tên sản phẩm</th>
              <th style="text-align:right">Giá</th>
              <th style="text-align:right">Giá khuyến mãi</th>
              <th style="text-align:right">Tồn kho</th>
              <th width="1%;white-space:nowrap">Thao tác</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; 

                ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order">{{ $i }}</span></td>                
               
                <td>                  
                  <a style="color:#333;" href="{{ route( 'product.edit', [ 'id' => $item->id ]) }}">{{ $item->name }} {{ $item->name_extend }}</a> &nbsp; @if( $item->is_hot == 1 )
                  <img class="img-thumbnail" src="{{ URL::asset('backend/dist/img/star.png')}}" alt="Nổi bật" title="Nổi bật" />
                  @endif
                  
                  
                </td>
                <td style="text-align:right">{{ number_format($item->price) }}</td>
                <td style="text-align:right">{{ ($item->price_sale > 0) ? number_format($item->price_sale) : "-"}}</td>
                <td style="text-align:right">{{ number_format($item->so_luong_ton) }}</td>               
                
                <td style="white-space:nowrap; text-align:right">                 
                  <button class="btn btn-warning btn-sm btnEdit" data-value="{{ $item->id }}">Chỉnh sửa</button>

                  <a onclick="return callDelete('{{ $item->name }}','{{ route( 'product.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm">Xóa</a>

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
          <div style="text-align:center">
           {{ $items->appends( $arrSearch )->links() }}
          </div>  
        </div>        
      </div>
      <!-- /.box -->     
    </div>
    <!-- /.col -->  
  </div> 
</section>

<!-- Modal -->
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">     
    <div class="modal-content">
      <div class="modal-body" id="loadDetailProduct">
        
      </div>      
    </div>

  </div>
</div>

<!-- /.content -->
</div>
<style type="text/css">
#searchForm div{
  margin-right: 7px;
}
.pagination{
  margin: 0px !important;
}
@if(Auth::user()->email == "huongll@icho.vn")
.content-wrapper{
  margin-left: 0px !important;
}
@endif
</style>
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
  $('input.submitForm').click(function(){
    var obj = $(this);
    if(obj.prop('checked') == true){
      obj.val(1);      
    }else{
      obj.val(0);
    } 
    obj.parent().parent().parent().submit(); 
  });
  
  $('#loai_id').change(function(){
    $('#cate_id').val('');
    $('#searchForm').submit();
  });
  $('#cate_id').change(function(){
    $('#searchForm').submit();
  });
  $('.btnEdit').click(function(){
    geDetail($(this).attr('data-value'));
  });
 
});
function geDetail(id){
  $.ajax({
      url: "{{ route('ajax-get-detail-product') }}",
      type: "GET",
      async: false,
      data: {          
          id : id
      },
      success: function(data){
          $('#loadDetailProduct').html(data);
          $('#editModal').modal('show');                  
      }
  });
}
</script>
@stop
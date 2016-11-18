@extends('layout.backend')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
   {{ $parent_id == 0 ? "Tỉnh/Thành" : "Quận/Huyện" }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'tinh.index' ) }}"> {{ $parent_id == 0 ? "Tỉnh/Thành" : "Quận/Huyện" }}</a></li>
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
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Bộ lọc</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" role="form" method="GET" action="{{ route('tinh.index') }}">                                  
            @if($parent_id > 0)
            @else
            <input type="hidden" name="parent_id" value="0">
            @endif

            <div class="form-group">
              <label for="name">Tên :</label>
              <input type="text" class="form-control" name="name" value="{{ $name }}">
            </div>
            <button type="submit" class="btn btn-default">Lọc</button>
          </form>         
        </div>
      </div>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( <span class="value">{{ $items->total() }} name )</span></h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:center">
            {{ $items->appends( ['parent_id' => $parent_id, 'name' => $name] )->links() }}
          </div>  
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>                            
              <th>Tiêu đề</th>
              @if($parent_id == 0)
              <th>Quận/Huyện</th>
              @endif
              <th width="1%;white-space:nowrap">Thao tác</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order">{{ $i }}</span></td>                       
                <td>                  
                  <a href="{{ route( 'tinh.edit', [ 'id' => $item->id ]) }}">{{ $item->name }}</a>           
                </td>
                @if($parent_id == 0)
                <td>Quận/Huyện</td>
                @endif
                <td style="white-space:nowrap">                  
                  <a href="{{ route( 'tinh.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning">Chỉnh sửa</a>                 
                  
                  <a onclick="return callDelete('{{ $item->name }}','{{ route( 'tinh.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger">Xóa</a>
                  
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
            {{ $items->appends( ['parent_id' => $parent_id, 'name' => $name] )->links() }}
          </div>  
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
</script>
@stop
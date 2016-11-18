@extends('layout.backend')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Khách hàng liên hệ
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'contact.index') }}">Khách hàng liên hệ</a></li>
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
          <form class="form-inline" role="form" method="GET" action="{{ route('contact.index') }}" id="frmContact">  
            <div class="form-group">
              <select class="form-control input-sm" id="type" name="type">                                
                  <option value="0" {{ $type == 0 ? "selected" : "" }}>Tất cả</option>
                  <option value="1" {{ $type == 1 ? "selected" : "" }}>Tư vấn mua hàng</option>
                  <option value="2" {{ $type == 2 ? "selected" : "" }}>Phản ánh dịch vụ</option>
                  <option value="3" {{ $type == 3 ? "selected" : "" }}>Hợp tác</option>
                  <option value="4" {{ $type == 4 ? "selected" : "" }}>Góp ý</option>
              </select> 
            </div>                                           
            <div class="form-group">
              <label for="name">Email :</label>
              <input type="text" class="form-control" name="email" value="{{ $email }}">
            </div>
            <div class="form-group">
              <label for="name">&nbsp;&nbsp;Phone :</label>
              <input type="text" class="form-control" name="phone" value="{{ $phone }}">
            </div>
            <button type="submit" class="btn btn-default">Lọc</button>
          </form>         
        </div>
      </div>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( <span class="value">{{ $items->total() }} liên hệ )</span></h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
        <a href="{{ route('contact.export') }}" class="btn btn-info btn-sm" style="margin-bottom:5px;float:right" target="_blank">Export</a>
          <div style="text-align:center">
            {{ $items->appends( ['status' => $status, 'email' => $email, 'phone' => $phone, 'type' => $type] )->links() }}
          </div>  
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>                            
              <th>Thông tin liên hệ</th>
              <th>Nội dung</th>
              <th width="10%">Thời gian tạo</th>
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
                  @if($item->full_name != '')
                  {{ $item->full_name }}</br>
                  @endif
                  @if($item->email != '')
                  <a href="{{ route( 'contact.edit', [ 'id' => $item->id ]) }}">{{ $item->email }}</a> -
                  @endif
                  @if($item->phone != '')
                  {{ $item->phone }}</br>
                  @endif
                </td>
                <td>
                  <strong>[@if($item->type == 1)
                    Tư vấn mua hàng
                  @elseif($item->type == 2)
                    Phản ánh dịch vụ
                  @elseif($item->type == 3)
                    Hợp tác
                  @else
                    Góp ý
                  @endif]-{{ $item->title }}</strong></br>
                  {{ $item->content }}

                </td>
                <td>{{ date('d-m-Y H:i', strtotime($item->created_at)) }}</td>
                <td style="white-space:nowrap">                                  
                  
                  <a onclick="return callDelete('{{ $item->email }}','{{ route( 'contact.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger">Xóa</a>
                  
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
            {{ $items->appends( ['status' => $status, 'email' => $email, 'phone' => $phone, 'type' => $type] )->links() }}
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
$(document).ready(function(){
  $('#type').change(function(){
    $('#frmContact').submit();
  });
});
</script>
@stop
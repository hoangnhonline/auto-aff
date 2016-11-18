<table class="table table-responsive table-bordered">
@if( $dataArr->count() > 0 )
@foreach($dataArr as $data)
  <tr id="row-{{ $cate_id }}-{{ $data->id }}">
    <td width="80%">{{ $data->name }} 
    <input type="hidden" name="sp_tuongthich_{{ $cate_id }}[]" value="{{ $data->id }}">
    </td>
    <td>      
    <button class="btn btn-sm btn-danger btnRemoveTuongThich" type="button" data-value="{{ $data->id }}" data-type="{{ $cate_id }}">Xóa</button>
    </td>
  </tr>
 
@endforeach
@endif
</table>
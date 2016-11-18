<table class="table table-responsive table-bordered">
@if( $dataArr->count() > 0 )
@foreach($dataArr as $data)
  <tr id="row-{{ $type }}-{{ $data->id }}">
    <td width="80%">{{ $data->name }} 
    <input type="hidden" name="sp_{{ $type }}[]" value="{{ $data->id }}">
    </td>
    <td>      
    <button class="btn btn-sm btn-danger btnRemoveRelated" type="button" data-value="{{ $data->id }}" data-type="{{ $type }}">Xóa</button>
    </td>
  </tr>
 
@endforeach
@endif
</table>
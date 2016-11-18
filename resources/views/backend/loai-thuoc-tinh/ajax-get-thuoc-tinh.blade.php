<option value="0">--Tất cả--</option>
@foreach($loaiThuocTinh as $loai)
<option value="{{ $loai->id }}">{{ $loai->name }}</option>
@endforeach
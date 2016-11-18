<form method="POST" action="" id="formAjax">
  {!! csrf_field() !!}    
  <input type="hidden" name="id" value="{{ $detail->id }}">
  <div class="form-group">
    <label for="name">Tên sản phẩm</label>
    <input type="text" class="form-control" id="name" autocomplete="off" name="name" value="{{ $detail->name }}">
  </div>
  <div class="form-group">
    <label for="pwd">Giá</label>
    <input type="text" class="form-control" id="price" autocomplete="off" name="price" value="{{ $detail->price }}">
  </div>
  <div class="form-group">
    <label for="pwd">Giá khuyến mãi</label>
    <input type="text" class="form-control" id="price_sale" autocomplete="off" name="price_sale" value="{{ $detail->price_sale }}">
  </div>
  <div class="form-group">
    <label for="pwd">Tồn kho</label>
    <input type="text" class="form-control" id="so_luong_ton" autocomplete="off" name="so_luong_ton" value="{{ $detail->so_luong_ton }}">
  </div>
  <div style="text-align:right">
  <button type="button" id="btnSaveAjax" class="btn btn-primary">Save</button>
  <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
  </div>
</form>
<script type="text/javascript">
  $(document).ready(function(){
    $('#btnSaveAjax').click(function(){
       $.ajax({
        url : "{{ route('product.ajax-save-info') }}",
        data : $('#formAjax').serialize(),
        type: "POST",
        success :function(data){
          window.location.reload();
        }
        });
    });
    $('#formAjax input').keypress(function(e) {
        if(e.which == 13) {
            $('#btnSaveAjax').click();
        }
    });
  });

</script>
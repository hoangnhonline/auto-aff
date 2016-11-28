@if($dataArr['title'])
<div style="width:40%;float:left">
    <a target="_blank" href="https://pub.accesstrade.vn/deep_link/4467482901532824352?url={{ $url }}" rel="nofollow"> 
        <img src="{{ $dataArr['img'] }}" width="90%" >
    </a>
</div>
<div style="width:60%;float:left;text-align:left">
    <h3 style="font-size:16px">
        <a style="color:#333;font-weight:bold" target="_blank" href="https://pub.accesstrade.vn/deep_link/4467482901532824352?url={{ $url }}" rel="nofollow"> {{ $dataArr['title'] }}</a>
    </h3>
<strong style="color:red; font-size:20px">{{ $dataArr['price'] }}</strong>
<strong style="text-decoration :line-through">{{ $dataArr['price_old'] }}</strong>
<p style="margin-top:15px">
<a class="btn btn-danger" target="_blank" href="https://pub.accesstrade.vn/deep_link/4467482901532824352?url={{ $url }}" rel="nofollow">Mua ngay</a>
</p>
</div>
<div style="clear:both"></div>
<style type="text/css">
    h3 a:hover{
        text-decoration: none;
    }

</style>
@else
<h3 style="color:red; font-style:italic;font-size:20px;padding:10px">Không tìm thấy sản phẩm!</h3>
@endif
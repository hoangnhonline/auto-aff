<div class="wrap-item">
@foreach($spArr as $sp)
  <div class="item col-md-2">
    <div class="item-product5">
      <div class="product-thumb product-thumb5">
        <a href="{{ $sp->url }}" target="_blank" class="product-thumb-link">
          <img class="first-thumb" src="{{ $sp->thumbnail_url }}" alt=""/> 
          <img class="second-thumb" src="{{ $sp->thumbnail_url }}" alt=""/>                
        </a>
        <div class="product-info-cart">                
          <a href="{{ $sp->url }}" target="_blank" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Mua ngay</a>
        </div>
      </div>
      <div class="product-info5">
        <h3 class="title-product"><a href="{{ $sp->url }}" target="_blank">{{ $sp->name }}</a></h3>
        <div class="info-price">
          <span>{{ Helper::showPriceAff($sp->aff_price) }} đ</span>
          <del>{{ Helper::showPriceAff($sp->aff_price_old) }} đ</del>
        </div>                
      </div>
    </div>
  </div>
  <!-- End Item -->     
  @endforeach     
</div>
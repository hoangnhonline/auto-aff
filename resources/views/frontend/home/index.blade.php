@extends('frontend.layout')
@section('content')
<div class="container">
    @include('frontend.partials.slider')
    @include('frontend.partials.shipping')    
    <div class="content-popular11">
      <div class="popular-cat-title">
        <ul class="ul-tab">
          <li class="active"><a href="javascript:;" class="tab-product" data-type="1" data-value="0">Tổng hợp</a></li>
          <li><a href="javascript:;" class="tab-product" data-type="1" data-value="1-2" >Thời trang</a></li>
          @foreach($cateDeal as $cate)
          <li><a href="javascript:;" class="tab-product" data-type="1" data-value="{{ $cate->id }}" >{{ $cate->name }}</a></li>
          @endforeach         
        </ul>
      </div>
      <div id="dataAff-1">
        <div class="wrap-item">
        @foreach($spDeal as $sp)
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
      </div>
      <div class="clearfix"></div>  
    </div>
    <!-- End Popular Product -->
    <div class="simple-adv11 item-adv-simple">
      <a href="#"><img src="{{ URL::asset('assets/images/home11/ad1.jpg') }}" alt="" /></a>
    </div>
    <!-- End Adv -->
    <div class="content-popular11">
      <div class="popular-cat-title">
        <ul class="ul-tab">
          <?php $i = 0; ?>
          @foreach($cateBest as $cate)
          <?php $i++; ?>
          <li {{ $i == 1 ? "class=active" : "" }}><a href="javascript:;" data-type="2" data-value="{{ $cate->id }}" class="tab-product">{{ $cate->name }}</a></li>
          @endforeach     
        </ul>
      </div>
      <div id="dataAff-2">
        <div class="wrap-item">
        @foreach($spBest as $sp)
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
        @endforeach         
        </div>
        <div class="clearfix"></div>  
      </div>  
    </div>
    <!-- End Popular Product -->
    <div class="simple-adv11 item-adv-simple">
      <a href="#"><img src="{{ URL::asset('assets/images/home11/ad2.jpg') }}" alt="" /></a>
    </div>
    <div class="content-popular11">
      <div class="popular-cat-title">
        <ul>
          <li class="active"><a href="#" data-toggle="tab">Sản Phẩm được kiểm chứng</a></li>
          <li><a href="#" data-toggle="tab">Đồ chơi trẻ em</a></li>
          <li><a href="#" data-toggle="tab">Túi xách nữ</a></li>
          <li><a href="#" data-toggle="tab">Nước hoa</a></li>
          <li><a href="#" data-toggle="tab">áo khoác nam</a></li>
          <li><a href="#" data-toggle="tab">bánh kem</a></li>
        </ul>
      </div>
      <div class="popular-cat-slider popular-cat-slider11 slider-home5">
        <div class="wrap-item">
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/fashion/1.png') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/fashion/2.png') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$40.60 </span>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/fashion/3.png') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/fashion/4.png') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$30.99 </span>
                  <del>$327.00</del>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/fashion/5.png') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/fashion/6.png') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$59.52</span>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/fashion/7.png') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/fashion/8.png') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$87.00 </span>
                  <del>$200.00</del>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/fashion/9.png') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/fashion/10.png') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$87.00 </span>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/fashion/11.png') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/fashion/12.png') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$87.00 </span>
                  <del>$200.00</del>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/fashion/13.png') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/fashion/14.png') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$87.00 </span>
                  <del>$200.00</del>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/fashion/2.png') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/fashion/3.png') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$87.00 </span>
                  <del>$200.00</del>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
        </div>
      </div>  
    </div>
    <!-- End Popular Product -->
    <div class="simple-adv11 item-adv-simple">
      <a href="#"><img src="{{ URL::asset('assets/images/home11/ad2.jpg') }}" alt="" /></a>
    </div>
    <!-- End Adv -->
    <div class="content-popular11">
      <div class="popular-cat-title">
        <ul>
          <li class="active"><a href="#" data-toggle="tab">Review sản phẩm</a></li>

        </ul>
      </div>
      <div class="popular-cat-slider popular-cat-slider11 slider-home5">
        <div class="wrap-item">
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/food/1.jpg') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/food/2.jpg') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$40.60 </span>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/food/3.jpg') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/food/4.jpg') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$30.99 </span>
                  <del>$327.00</del>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/food/5.jpg') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/food/6.jpg') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$59.52</span>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/food/7.jpg') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/food/8.jpg') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$87.00 </span>
                  <del>$200.00</del>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/food/9.jpg') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/food/10.jpg') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$87.00 </span>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/food/11.jpg') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/food/12.jpg') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$87.00 </span>
                  <del>$200.00</del>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/food/2.jpg') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/food/3.jpg') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$87.00 </span>
                  <del>$200.00</del>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
          <div class="item">
            <div class="item-product5">
              <div class="product-thumb product-thumb5">
                <a href="#" class="product-thumb-link">
                  <img class="first-thumb" src="{{ URL::asset('assets/images/photos/food/4.jpg') }}" alt=""/>
                  <img class="second-thumb" src="{{ URL::asset('assets/images/photos/food/5.jpg') }}" alt=""/>
                </a>
                <div class="product-info-cart">
                  <div class="product-extra-link">
                    <a href="#" class="wishlist-link"><i class="fa fa-heart-o"></i></a>
                    <a href="#" class="compare-link"><i class="fa fa-toggle-on"></i></a>
                    <a href="#" class="quickview-link"><i class="fa fa-search"></i></a>
                  </div>
                  <a href="#" class="addcart-link"><i class="fa fa-shopping-basket"></i>  Add to Cart</a>
                </div>
              </div>
              <div class="product-info5">
                <h3 class="title-product"><a href="#">Burberry Pink & black </a></h3>
                <div class="info-price">
                  <span>$87.00 </span>
                  <del>$200.00</del>
                </div>
                <div class="product-rating">
                  <div class="inner-rating" style="width:100%"></div>
                  <span>(1s)</span>
                </div>
              </div>
            </div>
          </div>
          <!-- End Item -->
        </div>
      </div>  
    </div>
    <!-- End Popular Product -->
    <div class="simple-adv11 item-adv-simple">
      <a href="#"><img src="{{ URL::asset('assets/images/home11/ad3.jpg') }}" alt="" /></a>
    </div>   
</div>
@endsection
@section('javascript')
  	<script type="text/javascript">
  		$(document).ready(function() {
        $('a.tab-product').click(function(){
          var obj = $(this);
          var type = obj.data('type');
          var value = obj.data('value');
          obj.parents('.ul-tab').find('li').removeClass('active');
          obj.parent().addClass('active');
          $.ajax({
            url : "{{ route('load-product-tab')}}",
            type : 'POST',
            data : {
              type : type,
              value : value
            },
            beforeSend : function(){

            },success : function(data){
              $('#dataAff-' + type).html(data);
            }
          });
        });
  		});
  	</script>
@endsection
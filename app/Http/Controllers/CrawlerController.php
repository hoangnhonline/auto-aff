<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Goutte, File;
use App\Helpers\simple_html_dom;

class CrawlerController extends Controller
{
   
    public function index(Request $request){

    	$this->adayroi($request);
    }
    public function lazada(Request $request){
        set_time_limit(10000);
        for($page = 1; $page <= 2; $page++){ 
             $crawler = Goutte::request('GET', 'http://www.lazada.vn/tui-xach-tay-nu/?dir=desc&page='.$page.'&sort=discountspecial'); 
               //var_dump('http://www.lazada.vn/ao-khoac-nu/?dir=desc&page='.$page.'&sort=discountspecial');die;
             $crawler->filter('.product-card')->each(function ($node){
                $title = $content = $image_url = $link = "";
                    if($node->filter('img')->count() > 0){
                     $image_url = $node->filter('img')->attr('data-original');
                    }   
                    var_dump($image_url);
                       echo "<br>";
                    
                
                    $link = $node->filter('a')->attr('href');
                  $title = $node->filter('div.product-card__name-wrap span')->text();
                  $price = $node->filter('div.product-card__price')->text();
                  $price_old = $node->filter('div.product-card__old-price')->text();
                  $sale_percent = $node->filter('div.product-card__sale')->text();
                
                var_dump($link);
                echo "<br>";
                var_dump($title);
                echo "<br>";
                 var_dump($price);
                echo "<br>";
                var_dump($price_old);
                echo "<br>";
                var_dump($sale_percent);
                    echo "<hr>";                
             });    
        }
    }
    public function adayroi(Request $request){
        
        set_time_limit(10000);
        for($page = 1; $page <= 1; $page++){ 
             $crawler = Goutte::request('GET', 'https://www.adayroi.com/tui-vi-m58?p='.$page.'&featured=isPromotion');             
             $crawler->filter('.col-lg-3.col-xs-4')->each(function ($node){
                if($node->filter('.out-of-stock')->count() == 0){
                $title = $content = $image_url = $link = "";
                    if($node->filter('img.imglist')->count() > 0){
                     $image_url = $node->filter('img.imglist')->attr('data-src');
                    }   
                    var_dump($image_url);
                    echo "<br>";
                    $link = "https://www.adayroi.com".$node->filter('a')->attr('href');
                    var_dump($link);
                    echo "<br>";
                     $title = $node->filter('.post-title')->text();
                    var_dump($title);
                    echo "<br>";
                 $price = $node->filter('.amount-1')->text();
                 var_dump($price);
                echo "<br>";
                if($node->filter('.amount-2')->count() > 0){
                    $price_old = $node->filter('.amount-2')->text();
                    var_dump($price_old);
                    echo "<br>";
                }
                if($node->filter('.sale-off')->count() > 0){
                    $sale_percent = $node->filter('.sale-off')->text();
                    var_dump($sale_percent);
                }
                    echo "<hr>";                
                
             });
              
        }
    }
    public function tiki(Request $request){
        
        set_time_limit(10000);
        for($page = 1; $page <= 1; $page++){ 
             //$crawler = Goutte::request('GET', 'https://tiki.vn/laptop/c2742?order=discount_percent%2Cdesc&page='.$page);   
             //var_dump('https://tiki.vn/laptop/c2742?order=discount_percent%2Cdesc&page='.$page);
             $url = 'https://tiki.vn/laptop/c2742?order=discount_percent%2Cdesc&page='.$page; 
             $chs = curl_init();

            // set URL and other appropriate options
            curl_setopt($chs, CURLOPT_URL, $url);
            curl_setopt($chs, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($chs, CURLOPT_HEADER, 0);

            // grab URL and pass it to the browser
            $result = curl_exec($chs);

            // close cURL resource, and free up system resources
            curl_close($chs);
         // Create a DOM object
            $crawler = new simple_html_dom();
            // Load HTML from a string
            $crawler->load($result);
            foreach($crawler->find('div.product-item') as $node){          
               
                $title = $content = $image_url = $link = "";
                $count_img = count($node->find('span.image img'));
                
                    if($count_img == 2){
                     $image_url = $node->find('span.image img',1)->src;
                    }
                    if($count_img == 1){
                     $image_url = $node->find('span.image img',0)->src;
                    }  
                    if($count_img == 3){
                     $image_url = $node->find('span.image img',2)->src;
                    }   
                    var_dump($image_url);
                    echo "<br>";
                    
                    $link = $node->find('a', 0)->href;
                    $link = strstr($link, '?', true);
                    var_dump($link);
                    echo "<br>";
                    
                     $title = trim($node->find('span.title', 0)->innertext);
                    var_dump($title);
                    echo "<br>";
                 
                 $price_tmp = $node->find('.price-sale', 0)->innertext;
                 $tmpArr = explode('<span', $price_tmp);
                 $price = $tmpArr[0];
                 var_dump($price);
                echo "<br>";
                  $price_old = $node->find('.price-regular', 0)->innertext;
                  var_dump($price_old);
                echo "<br>";
                  $sale_percent = $node->find('.sale-tag', 0)->innertext;
                  var_dump($sale_percent);               

                    echo "<hr>";

            };
              
        }
    }
    public function detail(Request $request){
    	set_time_limit(10000);
    	$all = Link::where('id', '>=', 1000)->where('id', '<', 1001)->where('status', 1)->get();

    	foreach ($all as $key => $value) {
    		$url = $value->link;
    		$id = $value->id;
    		$crawler = Goutte::request('GET', $url); 
    		$content = $crawler->filter('div.aboutus')->html();    		
    		$model = Link::find($id);
    		$model->status = 0;
    		$model->content = $content;
    		$model->save();
    	}
    }

    public function imageContent(Request $request)
    {
    	set_time_limit(10000);   	

    	$all = Link::where('status', 0)->get();
    	

    	$linkArr = [];
    	foreach($all as $link){
    		echo $link->link;
    		echo "<br>";
    		if( !in_array($link->link , ['http://www.androidgiare.vn/danh-gia-lg-f160/', 'http://www.androidgiare.vn/phablet-cao-cap-dien-thoai-sky-a920/'])){
    		//$link = Link::where('link', 'http://www.androidgiare.vn/dien-thoai-lg-gia-re-duoi-4-trieu/')->first();
    		$html = $link->content;
	    	$doc = new \DOMDocument();
			$doc->loadHTML( $html );

			$images = $doc->getElementsByTagName("img");

			for ( $i = 0; $i < $images->length; $i++ ) {
			  // Outputs: foo.jpg bar.png
			  $image_url = "http://www.androidgiare.vn".$images->item( $i )->attributes->getNamedItem( 'src' )->nodeValue;

			  echo "<br>";
			  if($image_url && strpos($image_url, 'wp-content/') && !strpos($image_url, '/wp-content/')) {
		    		$saveto = str_replace("http://www.androidgiare.vn/wp-content/", "", $image_url);
		    		$tmp = explode('/', $saveto);
		    	
		    		$dir = str_replace(end($tmp), "", $saveto);
		    		
		    		if(!is_dir(public_path() ."/".$dir)){
		    			mkdir(public_path() ."/".$dir, true);
		    		}
		    		var_dump($image_url);
		    		echo "<br>";
		    		var_dump($saveto);
		    		$this->grab_image($image_url, $saveto);
		    		echo "<br>";
		    		$i++;
		    		echo $i." - ".$link->id;
		    		
	    		}
			}	
			echo "<hr>";	
			}	
		}
    }
    public function update(Request $request){
    	$all = Link::all();
    	$linkArr = [];
    	foreach($all as $link){
    		$url = $link->link;
    		$post_name = str_replace("http://www.androidgiare.vn/", "", $url);
    		$post_name = str_replace("/", "", $post_name);
    		$id = $link->id;
    		$title = str_replace("http://www.androidgiare.vn", "", $link->title);
    		
    		$model = Link::find($id);
    		$model->title = $title;
    		$model->post_name = $post_name;
    		$model->save();
    	}  	
    	
    }
    public function saveImage(Request $request){
    	set_time_limit(10000);
    	$all = Link::all();
    	$i = 0;
    	foreach($all as $value){

    		$image_url = $value->image_url;
    		if($image_url){
	    		$saveto = str_replace("http://www.androidgiare.vn/wp-content/", "", $image_url);
	    		$tmp = explode('/', $saveto);
	    	
	    		$dir = str_replace(end($tmp), "", $saveto);
	    		
	    		if(!is_dir(public_path() ."/".$dir)){
	    			mkdir(public_path() ."/".$dir, true);
	    		}
	    		var_dump($image_url);
	    		var_dump($saveto);
	    		$this->grab_image($image_url, $saveto);
	    		$i++;
	    		echo $i." - ".$value->id;
	    		echo "<hr>";
    		}
    	}
    }
    public function grab_image($url,$saveto){
    	var_dump($url);
	    $ch = curl_init ($url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
	    $raw=curl_exec($ch);
	    var_dump($raw);die;
	    if($raw){
		    curl_close ($ch);
		    if(!file_exists($saveto)){
		        $fp = fopen($saveto,'x');
			    fwrite($fp, $raw);
			    fclose($fp);
		    }
		}
	    
	}
    public static function changeFileName($str) {
        $str = self::stripUnicode($str);
        $str = str_replace("?", "", $str);
        $str = str_replace("&", "", $str);
        $str = str_replace("'", "", $str);
        $str = str_replace("  ", " ", $str);
        $str = trim($str);
        $str = mb_convert_case($str, MB_CASE_LOWER, 'utf-8');
        $str = str_replace(" ", "-", $str);
        $str = str_replace("---", "-", $str);
        $str = str_replace("--", "-", $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('"', "", $str);
        $str = str_replace(":", "", $str);
        $str = str_replace("(", "", $str);
        $str = str_replace(")", "", $str);
        $str = str_replace(",", "", $str);
        $str = str_replace(".", "", $str);
        $str = str_replace(".", "", $str);
        $str = str_replace(".", "", $str);
        $str = str_replace("%", "", $str);
        return $str;
    }

    public static function stripUnicode($str) {
        if (!$str)
            return false;
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            '' => '?',
            '-' => '/'
        );
        foreach ($unicode as $khongdau => $codau) {
            $arr = explode("|", $codau);
            $str = str_replace($arr, $khongdau, $str);
        }
        return $str;
    }
}

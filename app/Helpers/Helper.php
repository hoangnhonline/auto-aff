<?php

use App\Helpers\simple_html_dom;
use Goutte\Client;

namespace App\Helpers;
use DB;
use App\Models\CounterIps;
use App\Models\CounterValues;
use App\Models\Report;

class Helper
{
    public static $privateKey = 'enilnohngnaoh';

    public static function crop_str($text, $limit = 155)
    {
        $len = strlen($text);
        
        if ($len < $limit) {
            return $text;
        }
        
        return str_limit($text, $limit);
    }
    public static function showPriceAff($price){
        $price = str_replace("vnđ", "", $price);
        $price = str_replace("vnd", "", $price);
        $price = str_replace(" ₫", "", $price);
        $price = str_replace("₫", "", $price);
        $price = str_replace(" đ", "", $price);
        $price = str_replace("đ", "", $price);        
        $price = str_replace("VND", "", $price);
        $price = str_replace("VNĐ", "", $price);
        $price = str_replace(" ", "", $price);
        return $price;
    }
    public static function cropWord($text = '', $numWord = 0)
    {
        $wordCount = str_word_count(str_slug($text, ' '));
        if ($wordCount <= $numWord)
        {
            return $text;
        }
        else
        {
            $arrWord = explode(' ', $text);
            foreach ($arrWord as $word)
            {
                if ($word)
                {
                    $tmp[] = $word;
                }
            }
            $str = implode(' ', array_slice($tmp, 0, $numWord));
            return $str . '...';
        }
    }
    public static function counter( $film_id ){
        // ip-protection in seconds
        $counter_expire = 600;

        // ignore agent list
        $counter_ignore_agents = array('bot', 'bot1', 'bot3');

        // ignore ip list
        $counter_ignore_ips = array('127.0.0.2', '127.0.0.3');

        // get basic information
        $counter_agent = $_SERVER['HTTP_USER_AGENT'];
        $counter_ip = $_SERVER['REMOTE_ADDR']; 
        $counter_time = time();

        $ignore = false; 
           
        // get counter information
        $sql = "SELECT * FROM counter_values WHERE film_id = $film_id LIMIT 1 ";
        $rs1 = CounterValues::where('film_id', $film_id)->first();
      //  var_dump($rs1);die;
       // $res = mysql_query($sql);

        // fill when empty
        if (!$rs1)
        {   

            $tmpArr = [
                'film_id' => $film_id,
                'day_id' => date("z"),
                'day_value' => 1,
                'all_value' => 1
            ];
          CounterValues::create($tmpArr);
          $rs1 = CounterValues::where('film_id', $film_id)->first();
          
          $ignore = true;
        }   
        //var_dump($rs1);die;
        /*
        $row = mysql_fetch_assoc($res);

        $day_id = $row['day_id'];
        $day_value = $row['day_value'];   
        $all_value = $row['all_value'];   
        */
        $day_id = $rs1->day_id;
        $day_value = $rs1->day_value;
        $all_value = $rs1->all_value;
        // check ignore lists
        $length = sizeof($counter_ignore_agents);
        for ($i = 0; $i < $length; $i++)
        {
          if (substr_count($counter_agent, strtolower($counter_ignore_agents[$i])))
          {
             $ignore = true;
             break;
          }
        }

        $length = sizeof($counter_ignore_ips);
        for ($i = 0; $i < $length; $i++)
        {
          if ($counter_ip == $counter_ignore_ips[$i])
          {
             $ignore = true;
             break;
          }
        }

        
        // delete free ips
        if ($ignore == false)
        {           
            $time = time();
            CounterIps::where(['film_id' =>$film_id, 'ip' => $counter_ip])->whereRaw("$time-visit >= $counter_expire")->delete();
        }
 
        // check for entry
        if ($ignore == false)
        {
            $rs2 = CounterIps::where(['ip' => $counter_ip, 'film_id' => $film_id])->get();
          
          if ( $rs2->count() > 0)
          {
            $modelCouterIps = CounterIps::where('ip', $counter_ip)->where('film_id', $film_id);
            $modelCouterIps->update(['visit' => time()]);   
            $ignore = true;          
          }
          else
          {
             // insert ip
             CounterIps::create(['ip' => $counter_ip, 'visit' => time(), 'film_id' => $film_id]);
          }       
        }
        // add counter
        if ($ignore == false)
        {
          // day
          if ($day_id == date("z")) 
          {
             $day_value++; 
          }
          else 
          {
             $day_value = 1;
             $day_id = date("z");
          }
          // all
          $all_value++; 

        $modelCouterValues = CounterValues::where('film_id', $film_id);
        $modelCouterValues->update([
                'day_id' => $day_id,
                'day_value' => $day_value,
                'all_value' => $all_value
        ]);
         
        }
    }
    public static function shout(string $string)
    {
        return strtoupper($string);
    }
    public static function checkHasReport($film_id, $episode_id){
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $rs = Report::where(['ip_address' => $ip_address, 'film_id' => $film_id, 'episode_id' => $episode_id])->first();
        return $rs ? true : false;
    }
    public static function getDisplayOrder($table, $params = []){
        $query = DB::table($table)->whereRaw('1');
        if(!empty($params)){
            foreach ($params as $column => $value) {
                $query->where($column, $value);
            }
        }
        $rs = $query->select('display_order')->orderBy('display_order', 'desc')->first();
        if($rs){
            $order = $rs->display_order + 1;
        }else{
            $order = 1;
        }  
       // var_dump($order);die;
        return $order;
    }

    public static function showImage($image_url){

        return strpos($image_url, 'http') === false ? config('aff.upload_url').$image_url : $image_url;        

    }
    public static function seo(){
        $seo = [];
        $arrTmpSeo = DB::table('info_seo')->get();
        $arrSeo = $arrUrl = [];
        foreach($arrTmpSeo as $tmpSeo){
          $arrSeo[$tmpSeo->url] = ['title' => $tmpSeo->title, 'description' => $tmpSeo->description, 'keywords' => $tmpSeo->keywords, 'image_url' => $tmpSeo->image_url];
          $arrUrl[] = $tmpSeo->url;

        }
        if(in_array(url()->current(), $arrUrl)){
          $seo = $arrSeo[url()->current()];
        }        
        return $seo;
    }
    public static function showQuality($quality){        
        switch ($quality) {
            case '1':
                $return = "Full HD";
                break;
            case '2':
                $return = "HD";
                break;
            case '3':
                $return = "SD";
                break;
            case '4':
                $return = "CAM";
                break;
            case '5':
                $return = "1080P";
                break;
            default:
                $return = "";
                break;
        }
        return $return;
    }    
    public static function encodeLink($string){
        $returnString = "";
        $charsArray = str_split("e7NjchMCEGgTpsx3mKXbVPiAqn8DLzWo_6.tvwJQ-R0OUrSak954fd2FYyuH~1lIBZ");
        $charsLength = count($charsArray);
        $stringArray = str_split($string);
        $keyArray = str_split(hash('sha256',self::$privateKey));
        $randomKeyArray = array();
        while(count($randomKeyArray) < $charsLength){
            $randomKeyArray[] = $charsArray[rand(0, $charsLength-1)];
        }
        for ($a = 0; $a < count($stringArray); $a++){
            $numeric = ord($stringArray[$a]) + ord($randomKeyArray[$a%$charsLength]);
            $returnString .= $charsArray[floor($numeric/$charsLength)];
            $returnString .= $charsArray[$numeric%$charsLength];
        }
        $randomKeyEnc = '';
        for ($a = 0; $a < $charsLength; $a++){
            $numeric = ord($randomKeyArray[$a]) + ord($keyArray[$a%count($keyArray)]);
            $randomKeyEnc .= $charsArray[floor($numeric/$charsLength)];
            $randomKeyEnc .= $charsArray[$numeric%$charsLength];
        }
        return $randomKeyEnc.hash('sha256',$string).$returnString;
    }
    public static function decodeLink($string){
        $returnString = "";
        $charsArray = str_split("e7NjchMCEGgTpsx3mKXbVPiAqn8DLzWo_6.tvwJQ-R0OUrSak954fd2FYyuH~1lIBZ");
        $charsLength = count($charsArray);
        $keyArray = str_split( hash( 'sha256', self::$privateKey ));
        $stringArray = str_split(substr($string, ( $charsLength * 2 ) + 64));
        $sha256 = substr( $string, ( $charsLength * 2 ), 64);
        $randomKeyArray = str_split( substr( $string, 0, $charsLength*2 ));
        $randomKeyDec = array();
        if(count($randomKeyArray) < 132) return false;
        for ($a = 0; $a < $charsLength*2; $a+=2){
            $numeric = array_search($randomKeyArray[$a],$charsArray) * $charsLength;
            $numeric += array_search($randomKeyArray[$a+1],$charsArray);
            $numeric -= ord($keyArray[floor($a/2)%count($keyArray)]);
            $randomKeyDec[] = chr($numeric);
        }
        for ($a = 0; $a < count($stringArray); $a+=2){
            $numeric = array_search($stringArray[$a],$charsArray) * $charsLength;
            $numeric += array_search($stringArray[$a+1],$charsArray);
            $numeric -= ord($randomKeyDec[floor($a/2)%$charsLength]);
            $returnString .= chr($numeric);
        }
        if(hash('sha256',$returnString) != $sha256){
            return false;
        }else{
            return $returnString;
        }
    }
    public static function getVideoZing($url){
        $arrReturn = [];
        $ch = curl_init($url);    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);        
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        $result = curl_exec($ch);    

        curl_close($ch);   

              
            preg_match_all('/<source src\=\"(.*?)\" type\=\"video\/mp4\" data\-res\=\"480\"\/\>/',$result,$arr_preg);            
            $arrReturn['f480'] = isset($arr_preg[1][1]) ? $arr_preg[1][1] : ""; 
            
            preg_match_all('/<source src\=\"(.*?)\" type\=\"video\/mp4\" data\-res\=\"360\"\/\>/',$result,$arr_preg);            
            $arrReturn['f360'] = isset($arr_preg[1][1]) ? $arr_preg[1][1] : "";

        
        return $arrReturn;    
    }
    public static function curl($url) {
         $url = trim($url);
         $ch = @curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         $head[] = "Connection: keep-alive";
         $head[] = "Keep-Alive: 300";
         $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
         $head[] = "Accept-Language: en-us,en;q=0.5";
         curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
         curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($ch, CURLOPT_TIMEOUT, 60);
         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
         curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
         $page = curl_exec($ch);
         curl_close($ch);
         return $page;
    }    

    public static function uploadPhoto($file, $base_folder = '', $date_dir=false){
    
        $return = [];

        $basePath = '';

        $basePath = $base_folder ? $basePath .= $base_folder ."/" : $basePath = $basePath;

        $basePath = $date_dir == true ? $basePath .= date('Y/m/d'). '/'  : $basePath = $basePath;        
        
        $desPath = config('aff.upload_path'). $basePath;
        
        //set name for file
        $fileName = $file->getClientOriginalName();
        
        $tmpArr = explode('.', $fileName);

        // Get image extension
        $imgExt = array_pop($tmpArr);

        // Get image name exclude extension
        $imgNameOrigin = preg_replace('/(.*)(_\d+x\d+)/', '$1', implode('.', $tmpArr));        

        $imgName = str_slug($imgNameOrigin, '-');
        
        $imgName = $imgName."-".time();

        $newFileName = "{$imgName}.{$imgExt}";
        
        if( $file->move($desPath, $newFileName) ){
            $imagePath = $basePath.$newFileName;
            $return['image_name'] = $newFileName;
            $return['image_path'] = $imagePath;
        }
        
        return $return;
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

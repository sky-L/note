<?php

 

// 系统加密方法
if (! function_exists('ucenter_encrypt')) {
    function ucenter_encrypt($data, $key = '', $expire = 0) {
        $key  = md5($key);
        $data = base64_encode($data);
        $x    = 0;
        $len  = strlen($data);
        $l    = strlen($key);
        $char =  '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x=0;
            $char  .= substr($key, $x, 1);
            $x++;
        }
        $str = sprintf('%010d', $expire ? $expire + time() : 0);
        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord(substr($data,$i,1)) + (ord(substr($char,$i,1)))%256);
        }
        return str_replace('=', '', base64_encode($str));
    }
}
// 系统解密方法
if (! function_exists('ucenter_decrypt')) {
    function ucenter_decrypt($data, $key = ''){
        $key    = md5($key);
        $x      = 0;
        $data   = base64_decode($data);
        $expire = substr($data, 0, 10);
        $data   = substr($data, 10);
        if($expire > 0 && $expire < time()) {
            return '';
        }
        $len  = strlen($data);
        $l    = strlen($key);
        $char = $str = '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char  .= substr($key, $x, 1);
            $x++;
        }
        for ($i = 0; $i < $len; $i++) {
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            }else{
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return base64_decode($str);
    }
}

if (! function_exists('format_output')) {

    function format_output($returnData = null, $return = array()) {
         
        $return =  array_merge($return,['data'=>$returnData]);
         
        $setlog =  setLog($return,$_REQUEST ? $_REQUEST['_url'] : 'null');

        echo json_encode($return,JSON_UNESCAPED_UNICODE);

        exit;

        return;
    }
}

if (! function_exists('setLog')) {
    function  setLog($data,$_url){
        $new_line = "\r\n";
        $str  = "生成时间:" . date("Y-m-d H:i:s"). $new_line;
        $str .= "请求URL:" . $_url. $new_line;
        $str .= "返回数据:" . json_encode($data,JSON_UNESCAPED_UNICODE) . $new_line;
        $str .= "请求IP:" .get_real_ip(). $new_line;
        $str .= $new_line;
        $file_path = Config::get('logPath','/logs/api_logs/');
        $file_path = rtrim($file_path, "/");
        $filename = $file_path.'/'.date('Ymd').'/'.date("H").".log";

        _write_file($filename, $str);
    }
}

if (! function_exists('_write_file')) {
    function _write_file($filename = '', $str = '', $mode = 'a+') {
        $result = FALSE;
        //是否新建目录
        $dirname = dirname($filename);
        if (!file_exists($dirname)) {
            mkdir($dirname, 0777, TRUE);
        }
        $file = fopen($filename, $mode);
        // 排它性的锁定
        if (flock($file, LOCK_EX)) {
            fwrite($file, $str);
            // release lock
            flock($file, LOCK_UN);
            $result = TRUE;
        }
        fclose($file);
        return $result;
    }
}

if (! function_exists('get_real_ip')) {
    function get_real_ip($type = 0)
    {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}

if (! function_exists('arraytoXml')) {
    function arraytoXml ($data,$root = "xml")
    {
        $xml = '<'.$root.'>';

        foreach ($data as $key => $value)
        {
            $xml .= "<$key>" . htmlentities($value) . "</$key>";
        }

        return   $xml .= '</'.$root.'>';
    }
}


    public function diffStr($str1,$str2){
        $sArr1 = str_split($str1);
        $sArr2 = str_split($str2);
         
        $num1  = count($sArr1);
        $num2  = count($sArr2);
         
        $aNew  = array();
         
        if($num1 > $num2){
            foreach($sArr1 as $k=>$val){
                if($num2 > $k && $val != $sArr2[$k]){
                    $aNew[] = array('s1'=>$val,'s2'=>$sArr2[$k]);
                }elseif($num2 <= $k){
                    $aNew[] = array("s1"=>$val);
                }
            }
        }elseif($num1 < $num2){
            foreach($sArr2 as $k=>$val){
                if($num1 > $k && $val != $sArr1[$k]){
                    $aNew[] = array('s1'=>$sArr1[$k],'s2'=>$val);
                }elseif($num1 <= $k){
                    $aNew[] = array("s2"=>$val);
                }
            }
        }elseif($num1 == $num2){
            foreach($sArr1 as $k=>$val){
                if($val != $sArr2[$k]){
                    $aNew[] = array('s1'=>$val,'s2'=>$sArr2[$k]);
                }
            }
        }
         
        return $aNew;
    }

<?php
/**
 * Created by PhpStorm.
 * User: sinor
 * Date: 07.03.2018
 * Time: 0:40
 */

function getClientIp() {
    $ipaddress = '';
    if (@$_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(@$_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(@$_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(@$_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(@$_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(@$_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    if ($ipaddress=='::1') {$ipaddress='127.0.0.1';}
    return $ipaddress;
}
function writeIP ($ip){
    $ip_file_txt=DATA_DIR.DIRECTORY_SEPARATOR.$ip.'.txt';
    $cur_data = _getIpAsArray($ip);
    $new_data = [date_timestamp_get(date_create())];
    $data = array_merge($new_data,$cur_data);
    $content = serialize($data);
    file_put_contents($ip_file_txt, $content);

}

function writeIPJson ($ip){
    $ip_file_txt=DATA_DIR_JSON.DIRECTORY_SEPARATOR.$ip.'.txt';
    $cur_data = _getIpAsArrayJson($ip);
    $new_data = [date_timestamp_get(date_create())];
    $data = array_merge($new_data,$cur_data);
    $content = json_encode($data);
    file_put_contents($ip_file_txt, $content);

}

function checkIpLimits ($ip) {
    $result=true;
    $wait_time=0;
    $ip_file_txt=DATA_DIR.DIRECTORY_SEPARATOR.$ip.'.txt';
    if (!file_exists($ip_file_txt)) {
        $result=false;
    }
    else {
        $ip_array = _getIpAsArray($ip);
        if (isset($ip_array)) {
            $arr_count = count($ip_array);
            if ($arr_count + 1 <= LIMIT) {
                $result = false;
            } else {
                $now = date_timestamp_get(date_create());
                foreach ($ip_array as $key => $arr_time) {
                    $time_diff = $now - $arr_time;
                    if ($time_diff >= TIME_LIMIT) {
                        if ($key+1 <= LIMIT) {
                            $result = false;
                        }
                        break;
                    }
                }
                $wait_time =  TIME_LIMIT - date_timestamp_get(date_create()) + $ip_array[0];
            }
        }
    }

    return array('result'=>$result,'wait'=>$wait_time);
}

function checkIpLimitsJson ($ip) {
    $result=true;
    $wait_time=0;
    $ip_file_txt=DATA_DIR_JSON.DIRECTORY_SEPARATOR.$ip.'.txt';
    if (!file_exists($ip_file_txt)) {
        $result=false;
    }
    else {
        $ip_array = _getIpAsArrayJson($ip);
        if (isset($ip_array)) {
            $arr_count = count($ip_array);
            if ($arr_count + 1 <= LIMIT) {
                $result = false;
            } else {
                $now = date_timestamp_get(date_create());
                foreach ($ip_array as $key => $arr_time) {
                    $time_diff = $now - $arr_time;
                    if ($time_diff >= TIME_LIMIT) {
                        if ($key+1 <= LIMIT) {
                            $result = false;
                        }
                        break;
                    }
                }
                $wait_time =  TIME_LIMIT - date_timestamp_get(date_create()) + $ip_array[0];
            }
        }
    }

    return array('result'=>$result,'wait'=>$wait_time);
}


function _getIpAsArray($ip) {

    $ip_file_txt=DATA_DIR.DIRECTORY_SEPARATOR.$ip.'.txt';
    $ip_data = [];

    if (file_exists($ip_file_txt)) {
        $content = file_get_contents($ip_file_txt);
        if (!empty($content)) {
            $ip_data = unserialize($content);
            if ($ip_data !== false) {
                return $ip_data;
            }
        }
    }
/*    echo "<pre>";
    var_dump($ip_data);
    echo "</pre>";
*/
    return $ip_data;
}

function _getIpAsArrayJson($ip) {

    $ip_file_txt=DATA_DIR_JSON.DIRECTORY_SEPARATOR.$ip.'.txt';
    $ip_data = [];

    if (file_exists($ip_file_txt)) {
        $content = file_get_contents($ip_file_txt);
        if (!empty($content)) {
            $ip_data = json_decode($content);
            if ($ip_data !== false) {
                return $ip_data;
            }
        }
    }
    return $ip_data;
}

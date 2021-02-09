<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Libadapter {

    function server_loc() {
        $ctr=& get_instance();
        $serpro = $ctr->config->item('adp2aaa');
        return $serpro;
    }

    function server_epg() {
        $serpro = 'http://10.0.1.15';
        return $serpro;
    }

    function request_execute($toURL, $post) {
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $toURL,
            CURLOPT_HEADER => 0,
            CURLOPT_VERBOSE => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($post),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function request_executes($toURL, $post) {
        $username = 'admin';
        $password = '1234';
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $toURL,
            CURLOPT_HEADER => 0,
            CURLOPT_VERBOSE => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
            CURLOPT_POST => true,
            CURLOPT_USERPWD => $username . ':' . $password,
            CURLOPT_POSTFIELDS => http_build_query($post),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    function execurl($toURL, $post) {
        if(stristr($toURL, 'olap')==true){
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $toURL=$toURL.'&ipclient='.$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }

        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $toURL,
            CURLOPT_HEADER => 0,
            CURLOPT_VERBOSE => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($post),
        );
        curl_setopt_array($ch, $options);
        $result = array('data' => curl_exec($ch), 'info' => curl_getinfo($ch));
        curl_close($ch);
        return $result;
    }

    function execurl_x($toURL, $post) {
        if(stristr($toURL, 'olap')==true){
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $toURL=$toURL.'&ipclient='.$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $toURL,
            CURLOPT_HEADER => 0,
            CURLOPT_VERBOSE => 0,
            CURLOPT_HTTPHEADER  => array('App-Token: denstvCodelabs'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($post),
        );
        // print_r($options);exit();
        curl_setopt_array($ch, $options);
        $result = array('data' => curl_exec($ch), 'info' => curl_getinfo($ch));
        curl_close($ch);
        return $result;
    }

    function request_execute_auth($toURL, $post) {
        $user = 'denstv';
        $pass = 'digdaya';
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $toURL,
            CURLOPT_HEADER => 0,
            CURLOPT_VERBOSE => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($post),
            CURLOPT_USERPWD => $user . ':' . $pass,
            CURLOPT_SSL_VERIFYPEER => false
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    function olap_log_v1($httpresponse="",$function=""){
        $respon=json_decode($httpresponse);
        if(isset($respon->response)){$_POST['response']=$respon->response;}
        if(isset($respon->msg)){$_POST['msg']=$respon->msg;}
        if(isset($respon->tor)){$_POST['tor']=$respon->tor;}
        $pst="";
        if(count($_POST)>0){
            $jp=array();
            $j=0;
            foreach ($_POST as $key => $value) {
                $jp[$j]=$key.'='.$value;
                $j++;
            }
            $pst=implode("/", $jp);
        }       
        $ctraaa='http://olap.dens.tv/'.$function.'/'.$pst;
        $this->execurl($ctraaa, array());
    }
    function olap_log_v2($jsonresponse=""){
        $respon=json_decode($jsonresponse);
        if(isset($respon->error)){$_POST['error']=$respon->error;}
        if(isset($respon->message)){$_POST['message']=$respon->message;}
        if(isset($respon->tor)){$_POST['tor']=$respon->tor;}
        $pst="";
        if(count($_POST)>0){
            $jp=array();
            $j=0;
            foreach ($_POST as $key => $value) {
                $jp[$j]=$key.'='.$value;
                $j++;
            }
            $pst=implode("/", $jp);
        }       
        $ctraaa='http://olap.dens.tv/'.$_SERVER['REQUEST_URI'].'/'.$pst;
        $this->execurl($ctraaa, array());
    }
}

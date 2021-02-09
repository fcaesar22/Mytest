<?php	if(!defined('BASEPATH')) exit('No direct script access allowed');
class Libadapterpod{	
	function server_loc(){

	$serpro='http://'.LB_INT_1;return $serpro;}
	function request_execute($toURL,$post){	
		$ch=curl_init();
		$options=array(
			CURLOPT_URL=>$toURL,
			CURLOPT_HEADER=>0,
			CURLOPT_VERBOSE=>0,
			CURLOPT_RETURNTRANSFER=>true,
			CURLOPT_USERAGENT=>"Mozilla/4.0 (compatible;)",
			CURLOPT_POST=>true,
			CURLOPT_POSTFIELDS=>http_build_query($post),
		);
		curl_setopt_array($ch, $options);
		$result=curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	function execurl($toURL,$post){	
		$ch=curl_init();
		$options=array(
			CURLOPT_URL=>$toURL,
			CURLOPT_HEADER=>0,
			CURLOPT_VERBOSE=>0,
			CURLOPT_RETURNTRANSFER=>true,
			CURLOPT_USERAGENT=>"Mozilla/4.0 (compatible;)",
			CURLOPT_POST=>true,
			CURLOPT_POSTFIELDS=>http_build_query($post),
		);
		curl_setopt_array($ch, $options);
		$result=array('data'=>curl_exec($ch),'info'=>curl_getinfo($ch));
		curl_close($ch);
		return $result;
	}
	function XCURL($toURL,$post){	
		$ch=curl_init();
		$options=array(
			CURLOPT_URL=>$toURL,
			CURLOPT_HEADER=>true,
			CURLOPT_VERBOSE=>0,
			CURLOPT_RETURNTRANSFER=>true,
			CURLOPT_USERAGENT=>"Mozilla/4.0 (compatible;)",
			CURLOPT_POST=>true,
			CURLOPT_POSTFIELDS=>http_build_query($post),
		);
		curl_setopt_array($ch, $options);
		$result->data=curl_exec($ch);
		$result->info=curl_getinfo($ch);
		curl_close($ch);
		return $result;
	}
	function olap_log($httpresponse="",$function=""){
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
}

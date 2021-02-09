<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Ads_video extends CI_Controller {
    public function __construct(){
        parent::__construct();
          $this->load->helper('url');
          $this->load->library('libadapter');
    }

    public function adsvideo_html(){
        $value = $this->input->get('s');
        if (!empty($value)) {
            $data = array('url_video'=>$value);
        }else{
            $data = array('url_video'=>"http://rr.digdaya.co.id/01/MVADS00005/index1.m3u8");
        }
        // print_r($data);die();
        $html = $this->load->view('ads_video', $data);
    }

}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Whatson extends CI_Controller {
    function __construct(){
        parent::__construct();
        check_not_login();
        $this->load->model('whatson/whatson_model');
        $this->load->library('session');
        $this->load->library('libadapter');
    }

    public function index()
    {
        // $data['whatson'] = $this->whatson_model->get_products();
        $this->template->load('template', 'whatson/wo_viewdev');
    }

    public function dataList(){
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->whatson_model->getdatatables($postData);

        echo json_encode($data);
    }

    // add new product
    public function add_new(){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        // print_r($exe['data']);die;
        $json_token=json_decode($exe['data']);
        // print_r($json_token);die;

        // $token = md5(date('iHiYimidi'));

        $data['token'] = $json_token->token;
        //  print_r($data);die;

        $url='http://wp.dens.tv/imagelist?CH=whatson_v2/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        // print_r($exe_url['data']);die;
        $url_token=json_decode($exe_url['data']);
        // print_r($url_token);die;
        // $this->load->model('whatson/whatson_model');
        // $urlimage = $this->whatson_model->getimage();
        

        $data['category'] = $this->whatson_model->get_category()->result();
        $data['subcategory'] = $this->whatson_model->get_sub_category()->result();
        $data['channelwo'] = $this->whatson_model->get_channel()->result();
        $data['thumbnailname'] = $this->whatson_model->get_thumbnail()->result();
        // $data['gallery'] = $this->compare();
        $this->template->load('template', 'whatson/new_form',$data);
    }

    public function get_token(){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $_token = json_decode($exe['data'],true);
        echo $_token['token'];
    }

    private function compare(){
        //get from folder upload
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);

        $url='http://wp.dens.tv/imagelist?CH=whatson_v2/1280x720&token='. $json_token->token;
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
       //  echo "<pre>";
       // var_dump($url_token->data);die;

        //get from database
        $this->load->model('whatson/whatson_model');
        $urlimage = $this->whatson_model->getimage();
        // print_r($urlimage);die;

        //formed array from folder
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        if($url_token!=null){
            foreach ($url_token->data as $key => $value) {
                $str = str_replace(' ','',$value->type);
                if($str==="f"){
                    array_push($_arrFolder, 'http://wp.dens.tv/'.$value->path);    
                }
            }
        }
        krsort($_arrFolder);
        // print_r($_arrFolder);die;

        //formed array from database
        if($urlimage!=null){
            foreach ($urlimage as $key => $value) {
                array_push($_urlimage, 'http://wp.dens.tv/img/whatson_v2/1280x720/'.$value['whatson_image'] );
            }
        }
        // print_r($_urlimage);die;

        $data=array_values(array_diff($_arrFolder,$_urlimage));
        // print_r($data);die;
        return $data;
    }

    public function compare_image(){
        echo json_encode($this->compare());
    }

    //save product to database ***
    public function save_product(){
        $whatson_title = $this->input->post('whatson_title',TRUE);
        $whatson_image = $this->input->post('whatson_image',TRUE);
        $whatson_image = basename($whatson_image);
        $whatson_video = $this->input->post('whatson_video',TRUE);
        $category_whatson_id = $this->input->post('category',TRUE);
        $sub_category_whatson_id = $this->input->post('subcategory',TRUE);
        $channel_whatson_id = $this->input->post('channelwo',TRUE);
        $thumbnail_whatson_id = $this->input->post('thumbnailname',TRUE);
        $content_id = $this->input->post('content_id',TRUE);
        $content_url = $this->input->post('content_url',TRUE);
        $content_url_image = $this->input->post('content_url_image',TRUE);
        $whatson_schedule_time = $this->input->post('whatson_schedule_time',TRUE);
        $whatson_purpose = $this->input->post('whatson_purpose',TRUE);
        $whatson_type = $this->input->post('whatson_type',TRUE);
        $link_url   = $this->input->post('link_url',TRUE);
        if ($link_url == null) {
            $link_url = NULL;
        }
        $_idWhatson = $this->whatson_model->save_product($whatson_title,$whatson_image,$whatson_video,$category_whatson_id,$sub_category_whatson_id,$channel_whatson_id,$thumbnail_whatson_id,$content_id,$content_url,$content_url_image,$whatson_schedule_time,$whatson_purpose,$whatson_type,$link_url);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('whatson/whatson/add_description/'.$_idWhatson);
    }

    public function add_description($whatson_id){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        // print_r($exe['data']);die;
        $json_token=json_decode($exe['data']);
        // print_r($json_token);die;

        // $token = md5(date('iHiYimidi'));

        $data['token'] = $json_token->token;
        //  print_r($data);die;

        $url='http://wp.dens.tv/imagelist?CH=whatson_v2/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        // print_r($exe_url['data']);die;
        $url_token=json_decode($exe_url['data']);
        // print_r($url_token);die;
        $this->load->model('whatson/whatson_model');
        $urlimage = $this->whatson_model->getimage();
        $whatson_id = $this->uri->segment(4);
        if (!isset($whatson_id)) redirect('whatson/whatson');
        $data['whatson_id'] = $whatson_id;
        $data['gallery'] = $this->compare();
        $this->template->load('template', 'whatson/new_description',$data);
    }

    public function save_description(){
        $whatson_id              = $this->input->post('whatson_id',TRUE);
        $whatson_description     = $this->input->post('whatson_description',FALSE);
        $whatson_summary = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($whatson_description));
        $whatson_summary = htmlentities($whatson_summary, ENT_QUOTES, "UTF-8");
        $whatson_summary = html_entity_decode($whatson_summary);
        $this->whatson_model->save_description($whatson_id,$whatson_description,$whatson_summary);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('whatson/wo_content/add_new/'.$whatson_id);
    }

    public function get_detail(){
        $whatson_id = $this->uri->segment(4);
        $data['whatson_id'] = $whatson_id;
        $data['category'] = $this->whatson_model->get_category()->result();
        $data['subcategory'] = $this->whatson_model->get_sub_category()->result();
        $data['channelwo'] = $this->whatson_model->get_channel()->result();
        $data['thumbnailname'] = $this->whatson_model->get_thumbnail()->result();
        $get_data = $this->whatson_model->get_product_by_id($whatson_id);
        $this->template->load('template', 'whatson/wo_detail',$data);
    }

    public function detail($id = null)
    {
        if (!isset($id)) redirect('whatson/whatson');
       
        $whatson = $this->whatson_model;
        $_data = $whatson->get_products_by_id($id);
        $data["whatson"] = null;
        if (!empty($_data)){
            $data["whatson"] =(object)$_data[0];
        }
        
        // print_r($whatson->get_products_by_id($id));die;
        if (!$data["whatson"]) show_404();
        
        $this->template->load('template', 'whatson/wo_detail', $data);
    }

    public function get_edit(){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        // print_r($exe['data']);die;
        $json_token=json_decode($exe['data']);
        // print_r($json_token);die;

        // $token = md5(date('iHiYimidi'));

        $data['token'] = $json_token->token;
        //  print_r($data);die;

        $url='http://wp.dens.tv/imagelist?CH=whatson_v2/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        // print_r($exe_url['data']);die;
        // $url_token=json_decode($exe_url['data']);
        // print_r($url_token);die;
        // $this->load->model('whatson/whatson_model');
        // $urlimage = $this->whatson_model->getimage();

        $whatson_id = $this->uri->segment(4);
        if (!isset($whatson_id)) redirect('whatson/whatson');
        $data['whatson_id'] = $whatson_id;
        $data['category'] = $this->whatson_model->get_category()->result();
        $data['subcategory'] = $this->whatson_model->get_sub_category()->result();
        $data['channelwo'] = $this->whatson_model->get_channel()->result();
        $data['thumbnailname'] = $this->whatson_model->get_thumbnail()->result();
        // $data['gallery'] = $this->compare();
        $get_data = $this->whatson_model->get_product_by_id($whatson_id);
        $this->template->load('template', 'whatson/edit_form',$data);
    }

    public function get_data_edit(){
        $whatson_id = $this->input->post('whatson_id',TRUE);
        $data = $this->whatson_model->get_product_by_id($whatson_id)->result();
        echo json_encode($data);
    }

    //update product to database ***
    public function update_product(){
        $whatson_id              = $this->input->post('whatson_id',TRUE);
        $whatson_title           = $this->input->post('whatson_title',TRUE);
        $whatson_image     		 = $this->input->post('whatson_image',TRUE);
        $whatson_image           = basename($whatson_image);
        $whatson_video           = $this->input->post('whatson_video',TRUE);
        $category_whatson_id     = $this->input->post('category',TRUE);
        $sub_category_whatson_id = $this->input->post('subcategory',TRUE);
        $channel_whatson_id      = $this->input->post('channelwo',TRUE);
        $thumbnail_whatson_id    = $this->input->post('thumbnailname',TRUE);
        $content_id              = $this->input->post('content_id',TRUE);
        $content_url             = $this->input->post('content_url',TRUE);
        $content_url_image       = $this->input->post('content_url_image',TRUE);
        $whatson_schedule_time   = $this->input->post('whatson_schedule_time',TRUE);
        $whatson_purpose   = $this->input->post('whatson_purpose',TRUE);
        $whatson_type   = $this->input->post('whatson_type',TRUE);
        $link_url   = $this->input->post('link_url',TRUE);
        if ($link_url == null) {
            $link_url = NULL;
        }
        // print_r($link_url);die();
        $this->whatson_model->update_product($whatson_id,$whatson_title,$whatson_image,$whatson_video,$category_whatson_id,$sub_category_whatson_id,$channel_whatson_id,$thumbnail_whatson_id,$content_id,$content_url,$content_url_image,$whatson_schedule_time,$whatson_purpose,$whatson_type,$link_url);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('whatson/whatson/get_edit_description/'.$whatson_id);
    }

    public function get_edit_description($whatson_id){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        // print_r($exe['data']);die;
        $json_token=json_decode($exe['data']);
        // print_r($json_token);die;

        // $token = md5(date('iHiYimidi'));

        $data['token'] = $json_token->token;
        //  print_r($data);die;

        $url='http://wp.dens.tv/imagelist?CH=whatson_v2/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        // print_r($exe_url['data']);die;
        $url_token=json_decode($exe_url['data']);
        // print_r($url_token);die;
        $this->load->model('whatson/whatson_model');
        $urlimage = $this->whatson_model->getimage();
        $whatson_id = $this->uri->segment(4);
        if (!isset($whatson_id)) redirect('whatson/whatson');
        $data['whatson_id'] = $whatson_id;
        $data['gallery'] = $this->compare();
        $this->template->load('template', 'whatson/edit_description',$data);
    }

    //update description to database
    public function update_description(){
        $whatson_id              = $this->input->post('whatson_id',TRUE);
        $whatson_description     = $this->input->post('whatson_description',FALSE);
        $whatson_summary = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($whatson_description));
        $whatson_summary = htmlentities($whatson_summary, ENT_QUOTES, "UTF-8");
        $whatson_summary = html_entity_decode($whatson_summary);
        $this->whatson_model->update_description($whatson_id,$whatson_description,$whatson_summary);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('whatson/whatson');
    }

    //Delete Product from Database
    public function delete($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->whatson_model->delete($id)) {
            redirect(site_url('whatson/whatson'));
        }
    }

    public function activated()
    {
        $id = $this->input->post('id_whon');
        $this->whatson_model->activated($id);
        echo json_encode(array("status" => TRUE));
    }

    public function inactivated()
    {
        $id = $this->input->post('id_whon');
        $this->whatson_model->inactivated($id);
        echo json_encode(array("status" => TRUE));
    }

    // ***
    public function pinbanner()
    {
        $id = $this->input->post('id_whonpin');
        $this->whatson_model->pinbanner($id);
        echo json_encode(array("status" => TRUE));
    }

    public function unpinbanner()
    {
        $id = $this->input->post('id_whonpin');
        $this->whatson_model->unpinbanner($id);
        echo json_encode(array("status" => TRUE));
    }

}
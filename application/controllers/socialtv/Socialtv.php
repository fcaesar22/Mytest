<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Socialtv extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // check_not_login();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('libadapter');
        $this->load->model("socialtv/socialtv_model");
        $this->load->library('form_validation');
    }

    public function index(){
        // $data["socialtvactive"] = $this->socialtv_model->get_socialtvactive();
        // $data["socialtvinactive"] = $this->socialtv_model->get_socialtvinactive();
        $this->template->load('template', 'socialtv/socialtv_viewdev');
    }

    public function list_dev(){
        $this->template->load('template', 'socialtv/socialtv_viewdev');
    }

    public function active_listdenslife(){
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->socialtv_model->active_listdenslife($postData);

        echo json_encode($data);
    }

    public function active_listdensknowledge(){
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->socialtv_model->active_listdensknowledge($postData);

        echo json_encode($data);
    }

    public function inactive_listdenslife(){
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->socialtv_model->inactive_listdenslife($postData);

        echo json_encode($data);
    }

    public function inactive_listdensknowledge(){
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->socialtv_model->inactive_listdensknowledge($postData);

        echo json_encode($data);
    }

    public function content_type(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->socialtv_model->content_type($searchTerm);
        echo json_encode($response);
    }

    public function category_densplay(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->socialtv_model->category_densplay($searchTerm);
        echo json_encode($response);
    }

    public function category_denslife(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->socialtv_model->category_denslife($searchTerm);
        echo json_encode($response);
    }

    public function category_knowledge(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->socialtv_model->category_knowledge($searchTerm);
        echo json_encode($response);
    }

    public function source_content(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->socialtv_model->source_content($searchTerm);
        echo json_encode($response);
    }

    public function save_keyword(){
        $this->form_validation->set_rules('keyword_name', 'Category name', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            alert('silahkan isi category!');
        }
        else
        {
            $keyword_ref = $this->input->post('contentid');
            if ($keyword_ref==39) {
                $keyword_refer='SDL';
            }
            if ($keyword_ref==40) {
                $keyword_refer='SCV';
            }
            if ($keyword_ref==96) {
                $keyword_refer='SDK';
            }
            $keyword_name = $this->input->post('keyword_name');
            if ($keyword_name != null && $keyword_refer != null) {
                $data = array(
                    'keyword_name'     => $keyword_name,
                    'keyword_sort'     => '1',
                    'keyword_child'    => 'SIN',
                    'keyword_sub'      => 'N',
                    'keyword_ref'      => $keyword_refer,
                    'keyword_visible'  => 'Y',
                    'keyword_parentid' => 'NULL'
                );
                $insert = $this->socialtv_model->save_keyword($data);
                echo json_encode(array("status" => TRUE));
            }else{
                alert('data gagal disimpan');
            }
        }
    }

    public function add_socialtv(){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        
        $urlimage = $this->socialtv_model->getimage();
        $json_image=json_encode($urlimage);
        
        $url='http://wp.dens.tv/imagelist?CH=socialtv_v1/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        $data['gallery'] = $this->compare($urlimage,'url');
        $this->template->load('template', 'socialtv/create_socialtv', $data);
    }

    public function save_socialtv(){
        $this->form_validation->set_rules('content_type', 'Content Type', 'trim');
        $this->form_validation->set_rules('category_content[]', 'Category Content', 'trim');
        $this->form_validation->set_rules('source_content', 'Source Content', 'trim|required');
        $this->form_validation->set_rules('socialtv_name', 'Social TV Name', 'trim|required');
        $this->form_validation->set_rules('socialtv_description', 'Social TV Description', 'trim|required');
        $this->form_validation->set_rules('channel_id', 'Channel ID', 'trim|required');
        $this->form_validation->set_rules('poster_content1', 'Poster Content', 'trim|required');
        $this->form_validation->set_rules('poster_content2', 'Poster Content', 'trim|required');
        $this->form_validation->set_rules('poster_content3', 'Poster Content', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Masih ada data yang belum terisi</div>');
            $this->add_socialtv();
        }
        else
        {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $by = $this->fungsi->user_login()->username;
            $content_type = $this->input->post('content_type',TRUE);
            $category_content = implode(",",$this->input->post('category_content',TRUE));
            $id_cat = ','.$content_type.','.$category_content.',';
            $source_content = $this->input->post('source_content',TRUE);
            $socialtv_name = $this->input->post('socialtv_name',TRUE);
            $socialtv_description = $this->input->post('socialtv_description',TRUE);
            $channel_id = $this->input->post('channel_id',TRUE);
            $poster_content1 = $this->input->post('poster_content1',TRUE);
            $poster_content2 = $this->input->post('poster_content2',TRUE);
            $poster_content3 = $this->input->post('poster_content3',TRUE);
            if($content_type == null || $channel_id == null){
                $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Silahkan isi kembali data Social TV dengan benar</div>');
                $this->add_socialtv();
            }else{
                $_idSocialtv = $this->socialtv_model->save_socialtv($id_cat, $source_content, $socialtv_name, $socialtv_description, $channel_id, $time, $by, $poster_content1, $poster_content2, $poster_content3);
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
                redirect('socialtv/socialtv');
            }
        }
    }

    public function getedit_socialtv($id=null){
        $socialtv_id = $this->uri->segment(4);
        if($id==null){
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>socialtv id kosong</div>');
            redirect('socialtv/socialtv');
        }
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        
        $urlimage = $this->socialtv_model->getimage();
        $json_image=json_encode($urlimage);
        
        $url='http://wp.dens.tv/imagelist?CH=socialtv_v1/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        
        $data['socialtv_id'] = $id;
        $data['poster'] = $this->socialtv_model->get_image_by_id($id);
        $typecat = trim($data['poster'][0]['keyword_parent_id'], ',');
        $typecateg = explode(',', $typecat); 
        $data['typecat'] = $typecateg[0];
        $data['gallery'] = $this->compare($urlimage,'url');
        $data['keyword'] = $this->socialtv_model->get_keyword()->result();
        $data['sockeyword'] = $this->socialtv_model->soc_keyword();
        $data['catcontent'] = $this->socialtv_model->cat_content()->result();
        $this->template->load('template', 'socialtv/edit_socialtv', $data);
    }

    public function get_poster_highlight(){
        $socialtv_id = $this->input->post('socialtv_id',TRUE);
        $socialtv = $this->socialtv_model->get_soctv_by_id($socialtv_id);
        if($socialtv!=null){
            $data = array(
                'socialtv_id' => $socialtv[0]->socialtv_id,
                'socialtv_name' => $socialtv[0]->socialtv_name,
                'socialtv_description' => $socialtv[0]->description,
                'channel_id' => $socialtv[0]->channel_id,
                'socialtv_source' => $socialtv[0]->source,
                'socialtv_category' => $socialtv[0]->keyword_parent_id,
                'poster_url' => $socialtv[0]->poster_url
            );
        }
        else{
            die("Data not found");
        }
        echo json_encode($data);
    }

    public function update_socialtv(){
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $by = $this->fungsi->user_login()->username;
        $content_type = $this->input->post('content_type',TRUE);
        $category_content = implode(",",$this->input->post('category_content',TRUE));
        $id_cat = ','.$content_type.','.$category_content.',';
        $source_content = $this->input->post('source_content',TRUE);
        $socialtv_name = $this->input->post('socialtv_name',TRUE);
        $socialtv_description = $this->input->post('socialtv_description',TRUE);
        $channel_id = $this->input->post('channel_id',TRUE);
        $poster_url1 = $this->input->post('poster_url1',TRUE);
        $poster_url2 = $this->input->post('poster_url2',TRUE);
        $poster_url3 = $this->input->post('poster_url3',TRUE);
        $socialtv_id = $this->input->post('socialtv_id',TRUE);
        $poster_id1 = $this->input->post('poster_id1',TRUE);
        $poster_id2 = $this->input->post('poster_id2',TRUE);
        $poster_id3 = $this->input->post('poster_id3',TRUE);
        $_idposter = $this->socialtv_model->update_socialtv($time, $by, $id_cat, $source_content, $socialtv_name, $socialtv_description, $channel_id, $poster_url1, $poster_url2, $poster_url3, $socialtv_id, $poster_id1, $poster_id2, $poster_id3);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('socialtv/socialtv');
    }

    public function get_token(){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $_token = json_decode($exe['data'],true);
        echo $_token['token'];
    }

    public function compare(){
        //get from folder upload
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        // print_r($json_token);die;

        $url='http://wp.dens.tv/imagelist?CH=socialtv_v1/1280x720&token='. $json_token->token;
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        // var_dump($url_token->data);die;

        //get from database
        $urlimage = $this->socialtv_model->getimage();
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

        //formed array from database
        if($urlimage!=null){
            foreach ($urlimage as $key => $value) {
                array_push($_urlimage, $value['poster_url'] );
            }
        }

        $data=array_values(array_diff($_arrFolder,$_urlimage));
        return $data;
    }

    public function compare_image($field = null){
        //get from database
        $urlimage = $this->socialtv_model->getimage();
        $_compare = $this->compare($urlimage, $field);
        echo json_encode($_compare);
    }


    public function detail($id){
        if (!isset($id)) redirect('socialtv');       
        $socialtv = $this->socialtv_model;
        $_data = $socialtv->get_detail_socialtv($id);
        
        $data["socialtv"] = null;
        if (!empty($_data)){
            $data["socialtv"] =(object)$_data[0];
        }
        if (!$data["socialtv"]) show_404();
        $this->template->load('template', 'socialtv/socialtv_detail', $data);
    }

    public function activated($id){
        if (!isset($id)) show_404();
        
        if ($this->socialtv_model->activated($id)) {
            redirect(site_url('socialtv/socialtv'));
        }
    }

    public function inactivated($id){
        if (!isset($id)) show_404();
        
        if ($this->socialtv_model->inactivated($id)) {
            redirect(site_url('socialtv/socialtv'));
        }
    }

}
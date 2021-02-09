<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Podcast_v2 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // check_not_login();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('libadapter');
        $this->load->model("podcast/podcast_model_v2");
        $this->load->library('form_validation');
    }

    public function index(){
        $this->template->load('template', 'podcast/view_podcast_v2');
    }

    public function active_podcast(){
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->podcast_model_v2->active_podcast($postData);

        echo json_encode($data);
    }

    public function inactive_podcast(){
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->podcast_model_v2->inactive_podcast($postData);

        echo json_encode($data);
    }

    public function content_type(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->podcast_model_v2->content_type($searchTerm);
        echo json_encode($response);
    }

    public function category_podcast(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->podcast_model_v2->category_podcast($searchTerm);
        echo json_encode($response);
    }

    public function source_content(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->podcast_model_v2->source_content($searchTerm);
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
            if ($keyword_ref==435) {
                $keyword_refer='POC';
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
                    'keyword_parentid' => ','.$keyword_ref.','
                );
                $insert = $this->podcast_model_v2->save_keyword($data);
                echo json_encode(array("status" => TRUE));
            }else{
                alert('data gagal disimpan');
            }
        }
    }

    public function add_podcast(){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        
        $urlimage = $this->podcast_model_v2->getimage();
        $json_image=json_encode($urlimage);
        
        $url='http://wp.dens.tv/imagelist?CH=podcast_v1/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        $data['gallery'] = $this->compare($urlimage,'url');
        $this->template->load('template', 'podcast/create_podcast_v2', $data);
    }

    public function save_podcast(){
        $this->form_validation->set_rules('content_type', 'Content Type', 'trim');
        $this->form_validation->set_rules('category_content[]', 'Category Content', 'trim');
        $this->form_validation->set_rules('source_content', 'Source Content', 'trim|required');
        $this->form_validation->set_rules('podcast_name', 'Podcast Name', 'trim|required');
        $this->form_validation->set_rules('podcast_description', 'Podcast Description', 'trim|required');
        $this->form_validation->set_rules('channel_id', 'Channel ID', 'trim|required');
        $this->form_validation->set_rules('poster_content1', 'Poster Content', 'trim|required');
        $this->form_validation->set_rules('poster_content2', 'Poster Content', 'trim|required');
        $this->form_validation->set_rules('poster_content3', 'Poster Content', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Masih ada data yang belum terisi</div>');
            $this->add_podcast();
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
            $podcast_name = $this->input->post('podcast_name',TRUE);
            $podcast_description = $this->input->post('podcast_description',TRUE);
            $channel_id = $this->input->post('channel_id',TRUE);
            $poster_content1 = $this->input->post('poster_content1',TRUE);
            $poster_content2 = $this->input->post('poster_content2',TRUE);
            $poster_content3 = $this->input->post('poster_content3',TRUE);
            if($content_type == null || $channel_id == null){
                $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Silahkan isi kembali data Podcast dengan benar</div>');
                $this->add_socialtv();
            }else{
                $_idSocialtv = $this->podcast_model_v2->save_podcast($id_cat, $source_content, $podcast_name, $podcast_description, $channel_id, $time, $by, $poster_content1, $poster_content2, $poster_content3);
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
                redirect('podcast/podcast_v2');
            }
        }
    }

    public function getedit_podcast($id=null){
        $podcast_id = $this->uri->segment(4);
        if($id==null){
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>podcast id kosong</div>');
            redirect('podcast/podcast_v2');
        }
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        
        $urlimage = $this->podcast_model_v2->getimage();
        $json_image=json_encode($urlimage);
        
        $url='http://wp.dens.tv/imagelist?CH=podcast_v1/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        
        $data['podcast_id'] = $id;
        $data['poster'] = $this->podcast_model_v2->get_image_by_id($id);
        $typecat = trim($data['poster'][0]['keyword_parent_id'], ',');
        $typecateg = explode(',', $typecat); 
        $data['typecat'] = $typecateg[0];
        $data['gallery'] = $this->compare($urlimage,'url');
        $data['keyword'] = $this->podcast_model_v2->get_keyword()->result();
        $data['podkeyword'] = $this->podcast_model_v2->pod_keyword();
        $data['catcontent'] = $this->podcast_model_v2->cat_content()->result();
        $this->template->load('template', 'podcast/edit_podcast_v2', $data);
    }

    public function get_poster_highlight(){
        $podcast_id = $this->input->post('podcast_id',TRUE);
        $podcast = $this->podcast_model_v2->get_soctv_by_id($podcast_id);
        if($podcast!=null){
            $data = array(
                'podcast_id' => $podcast[0]->podcast_id,
                'podcast_name' => $podcast[0]->podcast_name,
                'podcast_description' => $podcast[0]->description,
                'channel_id' => $podcast[0]->channel_id,
                'podcast_source' => $podcast[0]->source,
                'podcast_category' => $podcast[0]->keyword_parent_id,
                'poster_url' => $podcast[0]->poster_url
            );
        }
        else{
            die("Data not found");
        }
        echo json_encode($data);
    }

    public function update_podcast(){
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $by = $this->fungsi->user_login()->username;
        $content_type = $this->input->post('content_type',TRUE);
        $category_content = implode(",",$this->input->post('category_content',TRUE));
        $id_cat = ','.$content_type.','.$category_content.',';
        $source_content = $this->input->post('source_content',TRUE);
        $podcast_name = $this->input->post('podcast_name',TRUE);
        $podcast_description = $this->input->post('podcast_description',TRUE);
        $channel_id = $this->input->post('channel_id',TRUE);
        $poster_url1 = $this->input->post('poster_url1',TRUE);
        $poster_url2 = $this->input->post('poster_url2',TRUE);
        $poster_url3 = $this->input->post('poster_url3',TRUE);
        $podcast_id = $this->input->post('podcast_id',TRUE);
        $poster_id1 = $this->input->post('poster_id1',TRUE);
        $poster_id2 = $this->input->post('poster_id2',TRUE);
        $poster_id3 = $this->input->post('poster_id3',TRUE);
        $_idposter = $this->podcast_model_v2->update_podcast($time, $by, $id_cat, $source_content, $podcast_name, $podcast_description, $channel_id, $poster_url1, $poster_url2, $poster_url3, $podcast_id, $poster_id1, $poster_id2, $poster_id3);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('podcast/podcast_v2');
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

        $url='http://wp.dens.tv/imagelist?CH=podcast_v1/1280x720&token='. $json_token->token;
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        // var_dump($url_token->data);die;

        //get from database
        $urlimage = $this->podcast_model_v2->getimage();
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
        $urlimage = $this->podcast_model_v2->getimage();
        $_compare = $this->compare($urlimage, $field);
        echo json_encode($_compare);
    }


    public function detail($id){
        if (!isset($id)) redirect('podcast');       
        $podcast = $this->podcast_model_v2;
        $_data = $podcast->get_detail_podcast($id);
        
        $data["podcast"] = null;
        if (!empty($_data)){
            $data["podcast"] =(object)$_data[0];
        }
        if (!$data["podcast"]) show_404();
        $this->template->load('template', 'podcast/detail_podcast_v2', $data);
    }

    public function activated($id){
        if (!isset($id)) show_404();
        
        if ($this->podcast_model_v2->activated($id)) {
            redirect(site_url('podcast/podcast_v2'));
        }
    }

    public function inactivated($id){
        if (!isset($id)) show_404();
        
        if ($this->podcast_model_v2->inactivated($id)) {
            redirect(site_url('podcast/podcast_v2'));
        }
    }

}
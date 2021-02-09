<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Highlight extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // check_not_login();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('libadapter');
        $this->load->model("highlight/highlight_model");
        $this->load->library('form_validation');
    }

    // ***
    public function index(){
        // $data["highlight"] = $this->highlight_model->get_highlight();
        // $test = $this->highlight_model->get_title();
        // print_r($test);die();
        $this->template->load('template', 'highlight/highlight_view_new');
    }

    // ***
    public function type_category(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->highlight_model->type_category($searchTerm);
        echo json_encode($response);
    }

    // ***
    public function active_category(){
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->highlight_model->active_category($postData);

        echo json_encode($data);
    }

    public function getcategory(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->highlight_model->getcategory($searchTerm);
        echo json_encode($response);
    }

    public function gettypedensplay(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->highlight_model->gettypedensplay($searchTerm);
        echo json_encode($response);
    }

    public function gettypedenslife(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->highlight_model->gettypedenslife($searchTerm);
        echo json_encode($response);
    }

    public function getdenslife(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->highlight_model->getdenslife($searchTerm);
        echo json_encode($response);
    }

    public function getlistdenslife(){
        // POST data
        $postData = $this->input->post();
        // get data
        $data = $this->highlight_model->getlistdenslife($postData);

        echo json_encode($data);
    }

    public function getdenslifechannel(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->highlight_model->getdenslifechannel($searchTerm);
        echo json_encode($response);
    }

    public function getdensplay(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->highlight_model->getdensplay($searchTerm);
        echo json_encode($response);
    }

    public function getlistdensplay(){
        // POST data
        $postData = $this->input->post();
        // get data
        $data = $this->highlight_model->getlistdensplay($postData);

        echo json_encode($data);
    }

    public function getdensplaymovies(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->highlight_model->getdensplaymovies($searchTerm);
        echo json_encode($response);
    }

    public function getdensplaychannel(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->highlight_model->getdensplaychannel($searchTerm);
        echo json_encode($response);
    }

    //baru
    public function gettypewebinar(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->highlight_model->gettypewebinar($searchTerm);
        echo json_encode($response);
    }

    public function getwebinar(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->highlight_model->getwebinar($searchTerm);
        echo json_encode($response);
    }
    //baru

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

        $url='http://wp.dens.tv/imagelist?CH=highlight_v1/1280x720&token='. $json_token->token;
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        // var_dump($url_token->data);die;

        //get from database
        $urlimage = $this->highlight_model->getimage();
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
        $urlimage = $this->highlight_model->getimage();
        $_compare = $this->compare($urlimage, $field);
        echo json_encode($_compare);
    }

    public function add_highlight(){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        
        $urlimage = $this->highlight_model->getimage();
        $json_image=json_encode($urlimage);
        
        $url='http://wp.dens.tv/imagelist?CH=highlight_v1/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        $data['gallery'] = $this->compare($urlimage,'url');
        $this->template->load('template', 'highlight/create_highlight', $data);
    }

    public function save_highlight(){
        $this->form_validation->set_rules('cat_highlight', 'Category Highlight', 'trim|required');
        $this->form_validation->set_rules('type_highlight', 'Type Highlight', 'trim|required');
        $this->form_validation->set_rules('id_content', 'ID Content', 'trim|required');
        $this->form_validation->set_rules('title_content', 'Title Content', 'trim|required');
        $this->form_validation->set_rules('poster_content1', 'Poster Content', 'trim|required');
        $this->form_validation->set_rules('poster_content2', 'Poster Content', 'trim|required');
        $this->form_validation->set_rules('poster_content3', 'Poster Content', 'trim|required');
        $this->form_validation->set_rules('startdate_highlight', 'Start Date', 'trim|required');
        $this->form_validation->set_rules('enddate_highlight', 'End Date', 'trim|required');
        $this->form_validation->set_rules('highlight_update', 'Highlight Update', 'trim');
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Masih ada data yang belum terisi</div>');
            $this->add_highlight();
        }
        else
        {
            $category_highlight = $this->input->post('cat_highlight',TRUE);
            $type_highlight = $this->input->post('type_highlight',TRUE);
            $id_content = $this->input->post('id_content',TRUE);
            $title_content = $this->input->post('title_content',TRUE);
            $poster_content1 = $this->input->post('poster_content1',TRUE);
            $poster_content2 = $this->input->post('poster_content2',TRUE);
            $poster_content3 = $this->input->post('poster_content3',TRUE);
            $startdate_highlight = $this->input->post('startdate_highlight',TRUE);
            $enddate_highlight = $this->input->post('enddate_highlight',TRUE);
            $highlight_update = $this->input->post('highlight_update',TRUE);
            if($id_content == null || $poster_content1 == null){
                $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Poster Higlight/ID Content Kosong</div>');
                $this->add_highlight();
            }else{
                $_idHighlight = $this->highlight_model->save_highlight($category_highlight, $type_highlight, $id_content, $title_content, $poster_content1, $poster_content2, $poster_content3, $startdate_highlight, $enddate_highlight, $highlight_update);
                if($_idHighlight != null){
                    $set_highlight = $this->highlight_model->set_highlight($_idHighlight);
                    $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
                    redirect('highlight/highlight');
                }else{
                    $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Masih ada data yang belum terisi</div>');
                    $this->add_highlight();
                }
            }
        }
    }

    public function getedit_highlight($id=null){
        $highlight_id = $this->uri->segment(4);
        if($id==null){
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>highlight id kosong</div>');
            redirect('highlight');
        }
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        
        $urlimage = $this->highlight_model->getimage();
        $json_image=json_encode($urlimage);
        
        $url='http://wp.dens.tv/imagelist?CH=highlight_v1/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        
        $data['covers_id'] = $id;
        $typegoto = $_GET['s'];
        $data['poster'] = $this->highlight_model->get_image_by_id($id,$typegoto);
        $id_content = $data['poster'][0]['id_goto'];
        $data['content'] = $this->highlight_model->union_content($id_content);
        $data['gallery'] = $this->compare($urlimage,'url');
        $this->template->load('template', 'highlight/edit_highlight', $data);
    }

    public function get_poster_highlight(){
        $covers_id = $this->input->post('covers_id',TRUE);
        $covers = $this->highlight_model->get_highlight_by_id($covers_id);
        if($covers!=null){
            $data = array(
                'covers_id' => $covers[0]->covers_id,
                'category_highlight' => $covers[0]->category_covers,
                'startdate_highlight' => $covers[0]->start_date,
                'enddate_highlight' => $covers[0]->end_date,
                'poster' => $this->highlight_model->get_poster_by_id($covers_id),
            );
        }
        else{
            die("Data not found");
        }
        echo json_encode($data);
    }

    public function update_highlight(){
        $poster_url1 = $this->input->post('poster_url1',TRUE);
        $poster_url2 = $this->input->post('poster_url2',TRUE);
        $poster_url3 = $this->input->post('poster_url3',TRUE);
        $covers_id = $this->input->post('covers_id',TRUE);
        $poster_id1 = $this->input->post('poster_id1',TRUE);
        $poster_id2 = $this->input->post('poster_id2',TRUE);
        $poster_id3 = $this->input->post('poster_id3',TRUE);
        $startdate_highlight = $this->input->post('startdate_highlight',TRUE);
        $enddate_highlight = $this->input->post('enddate_highlight',TRUE);
        $poster_update = $this->input->post('poster_update',TRUE);
        $_idposter = $this->highlight_model->update_highlight($poster_url1,$poster_url2,$poster_url3,$covers_id,$poster_id1,$poster_id2,$poster_id3,$startdate_highlight,$enddate_highlight,$poster_update);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('highlight/highlight');
    }

    public function detail($id = null){
        if (!isset($id)) redirect('highlight/highlight');       
        $highlight = $this->highlight_model;
        $_data = $highlight->get_detail_highlights($id);
        $id_content = $_data[0]['id_goto'];
        
        $data["highlight"] = null;
        if (!empty($_data)){
            $data["highlight"] =(object)$_data[0];
            $data['content'] = $this->highlight_model->union_content($id_content);
        }
        if (!$data["highlight"]) show_404();
        $this->template->load('template', 'highlight/highlight_detail', $data);
    }

}
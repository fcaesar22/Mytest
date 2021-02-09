<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mng_category extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // check_not_login();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('libadapter');
        $this->load->model("mng_category/mngcat_model");
        $this->load->library('form_validation');
    }

    public function index(){
        $this->template->load('template', 'mng_category/mngcat_view');
    }

    public function type_category(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->mngcat_model->type_category($searchTerm);
        echo json_encode($response);
    }

    public function active_category(){
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->mngcat_model->active_category($postData);

        echo json_encode($data);
    }

    public function inactive_category(){
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->mngcat_model->inactive_category($postData);

        echo json_encode($data);
    }

    public function activated($keyword_id){
        if (!isset($keyword_id)) show_404();
        
        if ($this->mngcat_model->activated($keyword_id)) {
            redirect(site_url('mng_category/mng_category'));
        }
    }

    public function inactivated($keyword_id){
        if (!isset($keyword_id)) show_404();
        
        if ($this->mngcat_model->inactivated($keyword_id)) {
            redirect(site_url('mng_category/mng_category'));
        }
    }

    public function get_edit(){
        $keyword_id = $this->uri->segment(4);
        $data['keyword_id'] = $keyword_id;
        $this->template->load('template', 'mng_category/edit_form',$data);
    }

    public function get_data_edit(){
        $keyword_id = $this->input->post('keyword_id',TRUE);
        $data = $this->mngcat_model->get_product_by_id($keyword_id)->result();
        echo json_encode($data);
    }

    public function update_product(){
        $keyword_id        = $this->input->post('keyword_id',TRUE);
        $keyword_name     = $this->input->post('keyword_name',TRUE);
        $this->mngcat_model->update_product($keyword_id,$keyword_name);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('mng_category/mng_category');
    }

    public function get_edit_pod(){
        $keyword_id = $this->uri->segment(4);
        $data['keyword_id'] = $keyword_id;
        $this->template->load('template', 'mng_category/edit_form_pod',$data);
    }

    public function update_product_pod(){
        $keyword_id        = $this->input->post('keyword_id',TRUE);
        $keyword_name     = $this->input->post('keyword_name',TRUE);
        $keyword_icon     = $this->input->post('icon_category',TRUE);
        $this->mngcat_model->update_product_pod($keyword_id,$keyword_name,$keyword_icon);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('mng_category/mng_category');
    }

}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ch_wo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model("channel_whatson/chwo_model");
        $this->load->library('form_validation');
        $this->load->library('libadapter');
    }

    public function index()
    {
        $data["ch_wo"] = $this->chwo_model->getAll();
        $this->template->load('template', 'ch_wo/chwo_view', $data);
    }

    public function add()
    {
        $ch_wo = $this->chwo_model;
        $validation = $this->form_validation;
        $validation->set_rules($ch_wo->rules());

        if ($validation->run()) {
            $ch_wo->save();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
            redirect('channel_whatson/ch_wo');
        }
        
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
        $this->load->model('channel_whatson/chwo_model');
        $urlimage = $this->chwo_model->getimage();
        $data['gallery'] = $this->compare();
        $this->template->load('template', 'ch_wo/new_form',$data);
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

        $url='http://wp.dens.tv/imagelist?CH=whatson_v2/183x174&token='. $json_token->token;
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
       //  echo "<pre>";
       // var_dump($url_token->data);die;

        //get from database
        $this->load->model('channel_whatson/chwo_model');
        $urlimage = $this->chwo_model->getimage();
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
                array_push($_urlimage, $value['channel_whatson_logo'] );
            }
        }

        $data=array_values(array_diff($_arrFolder,$_urlimage));
        return $data;
    }

    public function compare_image(){
        echo json_encode($this->compare());
    }

    public function edit($id = null)
    {
        if (!isset($id)) redirect('channel_whatson/ch_wo');
       
        $ch_wo = $this->chwo_model;
        $validation = $this->form_validation;
        $validation->set_rules($ch_wo->rules());

        if ($validation->run()) {
            $ch_wo->update();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
            redirect('channel_whatson/ch_wo');
        }

        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        // print_r($exe['data']);die;
        $json_token=json_decode($exe['data']);
        // print_r($json_token);die;

        // $token = md5(date('iHiYimidi'));

        $data['token'] = $json_token->token;
        //  print_r($data);die;

        $url='http://wp.dens.tv/imagelist?CH=11_indomie/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        // print_r($exe_url['data']);die;
        $url_token=json_decode($exe_url['data']);
        // print_r($url_token);die;
        $this->load->model('channel_whatson/chwo_model');
        $urlimage = $this->chwo_model->getimage();

        $data["ch_wo"] = $ch_wo->getById($id);
        if (!$data["ch_wo"]) show_404();
        $data['gallery'] = $this->compare();
        
        $this->template->load('template', 'ch_wo/edit_form', $data);
    }

    public function get_data_edit(){
        $channel_whatson_id = $this->input->post('channel_whatson_id',TRUE);
        $data = $this->chwo_model->get_product_by_id($channel_whatson_id)->result();
        echo json_encode($data);
    }

    public function detail($id = null)
    {
        if (!isset($id)) redirect('channel_whatson/ch_wo');
       
        $ch_wo = $this->chwo_model;
        $validation = $this->form_validation;
        $validation->set_rules($ch_wo->rules());

        if ($validation->run()) {
            $ch_wo->update();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
            redirect('channel_whatson/ch_wo');
        }

        $data["ch_wo"] = $ch_wo->getById($id);
        if (!$data["ch_wo"]) show_404();
        
        $this->template->load('template', 'ch_wo/chwo_detail', $data);
    }

    public function delete($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->chwo_model->delete($id)) {
            redirect(site_url('channel_whatson/ch_wo'));
        }
    }
}
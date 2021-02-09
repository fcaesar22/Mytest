<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Wo_content extends CI_Controller {
	function __construct(){
        parent::__construct();
        check_not_login();
        $this->load->model('whatson/wocontent_model');
        $this->load->library('session');
        $this->load->library('libadapter');
        $this->load->helper('url');
    }

	public function index()
	{
		$data['whatson_content'] = $this->wocontent_model->get_products();
		$this->template->load('template', 'wo_content/wocontent_view', $data);
	}

	// add new product
    public function add_new($id=null){
        //cek jika whatson_id==null
        if($id==null){
            //alert whatson id tidak ada
            //redirect misal ke index wo contet
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>whatson id kosong</div>');
            redirect('whatson/wo_content');
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

        $this->load->model('whatson/wocontent_model');
        $urlimage = $this->wocontent_model->getimage();
        // print_r($urlimage);die;
        $json_image=json_encode($urlimage);
        // print_r($json_image);die;

        $url='http://wp.dens.tv/imagelist?CH=whatson_v2/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        // print_r($exe_url['data']);die;
        $url_token=json_decode($exe_url['data']);
        // print_r($url_token);die;
        
        $_det = $this->wocontent_model->get_products();
        $data['whatson_content'] = $_det;
        $data['whatson_id'] = $id;
        $data['gallery'] = $this->compare();
        $this->template->load('template', 'wo_content/new_form', $data);
    }

    public function get_token(){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $_token = json_decode($exe['data'],true);
        echo $_token['token'];
    }
    //save product to database
    public function batchInsert()
    {
        $this->load->model('whatson/wocontent_model');
        $result = $this->wocontent_model->batchInsert($_POST);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        if($result){
            echo 1;
        }
        else{
            echo 0;
        }
        exit;
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

        $this->load->model('whatson/wocontent_model');
        $urlimage = $this->wocontent_model->getimage();
        // print_r($urlimage);die;
        $json_image=json_encode($urlimage);
        // print_r($json_image);die;

        $url='http://wp.dens.tv/imagelist?CH=whatson_v2/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        // print_r($exe_url['data']);die;
        $url_token=json_decode($exe_url['data']);
        // print_r($url_token);die;
        
        $_det = $this->wocontent_model->get_products();
        $data['whatson_content'] = $_det;
        // $data['whatson_id'] = $id;
        $data['gallery'] = $this->compare();
        $whatson_content_id = $this->uri->segment(4);
        $data['whatson_content_id'] = $whatson_content_id;
        $get_data = $this->wocontent_model->get_product_by_id($whatson_content_id);
        $this->template->load('template', 'wo_content/edit_form',$data);
    }

    public function get_data_edit(){
        $whatson_content_id = $this->input->post('whatson_content_id',TRUE);
        $data = $this->wocontent_model->get_product_by_id($whatson_content_id)->result();
        echo json_encode($data);
    }

    //update product to database
    public function update_product(){
        $whatson_content_id   = $this->input->post('whatson_content_id',TRUE);
        $whatson_id           = $this->input->post('whatson_id',TRUE);
        $type  				  = $this->input->post('type',TRUE);
        $url  		          = $this->input->post('url',TRUE);
        $created_at           = $this->input->post('created_at',TRUE);
        $created_by           = $this->input->post('created_by',TRUE);
        $this->wocontent_model->update_product($whatson_content_id,$whatson_id,$type,$url,$created_at,$created_by);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('whatson/wo_content');
    }

    public function compare(){
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
        $this->load->model('whatson/wocontent_model');
        $urlimage = $this->wocontent_model->getimage();
        // print_r($urlimage);die;

        //formed array from folder
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        if($url_token!=null){
            foreach ($url_token->data as $key => $value) {
                $str = str_replace(' ','',$value->type);
                if($str==="f"){
                    array_push($_arrFolder, 'http://wp.dens.tv/img/whatson_v2/1280x720/'.$value->name);    
                }
            }
        }
        // print_r($_arrFolder);die;

        //formed array from database
        if($urlimage!=null){
            foreach ($urlimage as $key => $value) {
                array_push($_urlimage, 'http://wp.dens.tv/img/whatson_v2/1280x720/'.$value['whatson_image'] );
            }
        }
        // print_r($_urlimage);die;

        $data=array_values(array_diff($_arrFolder,$_urlimage));
        $data = array_slice($data, 0, 10);
        // print_r($data);die;
        return $data;
    }

    public function compare_image(){
        echo json_encode($this->compare());
    }

    public function detail($id = null)
    {
        $whatson_content = $this->wocontent_model;
        $_data = $whatson_content->get_products_by_id($id);
        $data["whatson_content"] = null;
         if (!empty($_data)){
            $data["whatson_content"] =(object)$_data[0];
        }
        $this->template->load('template', 'wo_content/wocontent_detail', $data);
    }

    //Delete Product from Database
    // public function delete($id)
    // {
    //     if (!isset($id)) show_404();
        
    //     if ($this->wocontent_model->delete($id)) {
    //         redirect(site_url('wo_content'));
    //     }
    // }

}
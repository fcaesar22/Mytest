<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Denslife extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('libadapter');
        $this->load->model("denslife_model");
        $this->load->library('form_validation');
    }

    public function index(){
        $data["denslife1"] = $this->denslife_model->get_products1();
        $data["denslife2"] = $this->denslife_model->get_products2();
        $this->template->load('template', 'denslife/denslife_view', $data);
    }

    public function add(){
        $data['keyword'] = $this->denslife_model->get_keyword()->result();
        $data['tags'] = $this->denslife_model->get_tags()->result();
        $data['child'] = $this->denslife_model->get_child()->result();
        $this->template->load('template', 'denslife/new_form', $data);
    }

    public function save_keyword(){
        $this->form_validation->set_rules('keyword_name', 'Category name', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            alert('silahkan isi category!');
        }
        else
        {
            $keyword_name = $this->input->post('keyword_name');
            if ($keyword_name != null) {
                $data = array(
                    'keyword_name'     => $keyword_name,
                    'keyword_sort'     => '1',
                    'keyword_child'    => 'SIN',
                    'keyword_sub'      => 'N',
                    'keyword_ref'      => 'ARC',
                    'keyword_visible'  => 'Y',
                    'keyword_parentid' => 'NULL'
                );
                $insert = $this->denslife_model->save_keyword($data);
                echo json_encode(array("status" => TRUE));
            }else{
                alert('data gagal disimpan');
            }
        }
    }

    public function save_tag(){
        $name_tag = $this->input->post('jtag',TRUE);
        $sort_tag = $this->input->post('jsort',TRUE);
        $child_tag = $this->input->post('jchild',TRUE);
        $sub_tag = $this->input->post('jsub',TRUE);
        $ref_tag = $this->input->post('jref',TRUE);
        $visible_tag = $this->input->post('jvis',TRUE);
        $par_tag = $this->input->post('jpar',TRUE);
        if ($name_tag != null) {
            $result = $this->denslife_model->save_tag($name_tag, $sort_tag, $child_tag, $sub_tag, $ref_tag, $visible_tag, $par_tag);
            if($result){
                echo 1;
            }else{
                echo 0;
            }
            exit;
        }
    }

    public function getkeywords(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->denslife_model->getkeywords($searchTerm);
        echo json_encode($response);
    }

    public function gettags(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->denslife_model->gettags($searchTerm);
        echo json_encode($response);
    }

    public function save_product(){
        $this->form_validation->set_rules('article_title', 'Article Title', 'trim|required');
        $this->form_validation->set_rules('kategori_id[]', 'Kategori Artikel', 'trim|required');
        $this->form_validation->set_rules('article_by', 'Article By', 'trim');
        $this->form_validation->set_rules('summary', 'Summary', 'trim');
        $this->form_validation->set_rules('tags[]', 'Tags Article', 'trim|required');
        $this->form_validation->set_rules('url_google_maps', 'URL Google Maps', 'trim');
        $this->form_validation->set_rules('created_by', 'Created by', 'trim');
        $this->form_validation->set_rules('updated_by', 'Updated by', 'trim');
        if ($this->form_validation->run() == FALSE)
        {
            $this->add();
        }
        else
        {
            $article_title     = $this->input->post('article_title',TRUE);
            $kategori_id       = implode(",",$this->input->post('kategori_id',TRUE));
            $article_by        = $this->input->post('article_by',TRUE);
            $summary           = $this->input->post('article_summary',TRUE);
            $tags              = implode(",",$this->input->post('tags',TRUE));
            $url_google_maps   = $this->input->post('url_google_maps',TRUE);
            $created_by        = $this->input->post('created_by',TRUE);
            $updated_by        = $this->input->post('updated_by',TRUE);
            $_idArticle        = $this->denslife_model->save_product($article_title,$kategori_id,$article_by,$summary,$tags,$url_google_maps,$created_by,$updated_by);
            if($_idArticle){
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
                redirect('denslife/add_article/'.$_idArticle);
            }
        }        
    }

    public function add_article($id=null){
        if($id==null){
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>article id kosong</div>');
            redirect('denslife');
        }
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        
        $this->load->model('denslife_model');
        $urlimage = $this->denslife_model->getimage();
        $json_image=json_encode($urlimage);
        
        $url='http://wp.dens.tv/imagelist?CH=denslife_v1/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        
        $data['article_id'] = $id;
        $data['gallery'] = $this->compare($urlimage,'url');
        $this->template->load('template', 'denslife/new_article', $data);
    }

    public function compare(){
        //get from folder upload
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        // print_r($json_token);die;

        $url='http://wp.dens.tv/imagelist?CH=denslife_v1/1280x720&token='. $json_token->token;
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        // var_dump($url_token->data);die;

        //get from database
        $this->load->model('denslife_model');
        $urlimage = $this->denslife_model->getimage();
        // print_r($urlimage);die;

        //formed array from folder
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        if($url_token!=null){
            foreach ($url_token->data as $key => $value) {
                $str = str_replace(' ','',$value->type);
                if($str==="f"){
                    array_push($_arrFolder, 'https://pic.dens.tv/wp/'.$value->path);    
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
        $this->load->model('denslife_model');
        $urlimage = $this->denslife_model->getimage();
        $_compare = $this->compare($urlimage, $field);
        echo json_encode($_compare);
    }

    public function get_token(){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $_token = json_decode($exe['data'],true);
        echo $_token['token'];
    }

    public function insert_artposter() {
        $urlimage = $this->input->post('image');
        $article_id = $this->input->post('art_id');
        $_idposter   = $this->denslife_model->insert_artposter($urlimage,$article_id);
    }

    public function save_article(){
        $this->form_validation->set_rules('article_content_1', 'Article Content 1', 'trim|required');
        $this->form_validation->set_rules('article_content_2', 'Article Content 2', 'trim');
        $this->form_validation->set_rules('article_id', 'Article ID', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            // $this->add_article($article_id);
            redirect('imagedenslife/add_article/'.$article_id);
            // echo "data not found";
        }
        else
        {
        $article_id        = $this->input->post('article_id',TRUE);
        $article_content_1 = $this->input->post('article_content_1',FALSE);
        $article_content_2 = $this->input->post('article_content_2',FALSE);
        $_idArticle        = $this->denslife_model->save_article($article_id,$article_content_1,$article_content_2);
            if($_idArticle){
                echo "data not found";
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
                redirect('imagedenslife/add_poster/'.$article_id);
            }
        }
    }

    public function get_edit(){
        $article_id = $this->uri->segment(3);
        $data['article_id'] = $article_id;
        $data['keyword'] = $this->denslife_model->get_keyword()->result();
        $data['tags'] = $this->denslife_model->get_tags();
        $this->template->load('template', 'denslife/edit_form',$data);
    }

    public function get_data_edit(){
        $article_id = $this->input->post('article_id',TRUE);
        $data = $this->denslife_model->get_product_by_id($article_id)->result();
        echo json_encode($data);
    }

    public function update_product(){
        $article_id        = $this->input->post('article_id',TRUE);
        $article_title     = $this->input->post('article_title',TRUE);
        $kategori_id       = implode(",",$this->input->post('kategori_id',TRUE));
        $article_by        = $this->input->post('article_by',TRUE);
        $summary           = $this->input->post('article_summary',TRUE);
        $tags              = implode(",",$this->input->post('tags',TRUE));
        $url_google_maps   = $this->input->post('url_google_maps',TRUE);
        $created_by        = $this->input->post('created_by',TRUE);
        $updated_by        = $this->input->post('updated_by',TRUE);
        $this->denslife_model->update_product($article_id,$article_title,$kategori_id,$article_by,$summary,$tags,$url_google_maps,$created_by,$updated_by);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('denslife/get_edit_article/'.$article_id);
    }

    public function get_edit_article($id=null){
        $article_id = $this->uri->segment(3);
        if($id==null){
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>article id kosong</div>');
            redirect('denslife');
        }
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        
        $this->load->model('denslife_model');
        $urlimage = $this->denslife_model->getimage();
        $json_image=json_encode($urlimage);
        
        $url='http://wp.dens.tv/imagelist?CH=denslife_v1/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        
        $data['gallery'] = $this->compare($urlimage,'url');
        $data['article_id'] = $article_id;
        $this->template->load('template', 'denslife/edit_article',$data);
    }

    public function update_article(){
        $article_id        = $this->input->post('article_id',TRUE);
        $article_content_1 = $this->input->post('article_content_1',FALSE);
        $article_content_2 = $this->input->post('article_content_2',FALSE);
        $this->denslife_model->update_article($article_id,$article_content_1,$article_content_2);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('imagedenslife/edit_poster/'.$article_id);
    }

    // public function detail($id = null){
    //     if (!isset($id)) redirect('denslife');       
    //     $denslife = $this->denslife_model;
    //     $_data = $denslife->get_products_by_id($id);
        
    //     $data["denslife"] = null;
    //     if (!empty($_data)){
    //         $data["denslife"] =(object)$_data[0];
    //     }
    //     if (!$data["denslife"]) show_404();
    //     $this->template->load('template', 'denslife/denslife_detail', $data);
    // }

    public function detail($id = null){
        if (!isset($id)) redirect('denslife');       
        $denslife = $this->denslife_model;
        $_data = $denslife->get_products_by_id($id);
        $_img = $denslife->get_image_by_id($id);
        $_vid = $denslife->get_video_by_id($id);
        // print_r($_vid);die;
        
        $data["denslife"] = null;
        if (!empty($_data)){
            $data["denslife"] =(object)$_data[0];
            $data["poster"] = $_img;
            $data["video"] = $_vid;
        }
        if (!$data["denslife"]) show_404();
        $this->template->load('template', 'denslife/denslife_detail', $data);
    }

    public function viewpdf($id){
        $article = $this->denslife_model->get_products_by_id($id);
        if($article!=null){
            $data = array(
                'article_title' => $article[0]['article_title'],
                'article_by' => $article[0]['article_by'],
                'article_content_1' => $article[0]['article_content_1'],
                'article_content_2' => $article[0]['article_content_2'],
                'poster_url' => $article[0]['poster_url'],
                'poster' => $this->denslife_model->get_poster_by_id($id)
            );
            // print_r($data);die;
            $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            try {
                $mpdf = new \Mpdf\Mpdf([
                    'tempDir' => FCPATH."uploads/tmp/", // uses the current directory's parent "tmp" subfolder
                    'setAutoTopMargin' => 'stretch',
                    'margin_footer' => 0,
                    'default_font' => 'montserrat'
                ]);
                $html = $this->load->view('pdf_view',$data,true);
                $pdfFilePath =$article[0]['article_id'].".pdf";
                // $mpdf->SetHTMLHeader('<img src="' . base_url() . 'assets/img/header.png"/>');
                // $mpdf->SetHTMLFooter('<img src="' . base_url() . 'assets/img/footer.png"/>');
                $mpdf->AddPage('', // L - landscape, P - portrait 
                '', '', '', '',
                15, // margin_left
                15, // margin right
                35, // margin top
                40, // margin bottom
                0, // margin header
                0); // margin footer
                $mpdf->SetDefaultBodyCSS('background', "url('http://aid.digdaya.co.id/assets/img/denslife2.png')");
                $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
                $mpdf->WriteHTML($html);
                $mpdf->Output(); // opens in browser
                $mpdf->Output(FCPATH.'uploads/pdf/'.$pdfFilePath,'F'); // it downloads the file into the user system, with give name
                $data = array(
                    'pdf_url'     => base_url().'uploads/pdf/'.$pdfFilePath,
                    'article_id'     => $article[0]['article_id']
                );
                $insert = $this->denslife_model->insert_pdf($data);
                echo json_encode(array("status" => TRUE));
            } catch (\Mpdf\MpdfException $e) {
                      print "Creating an mPDF object failed with" . $e->getMessage();
            }
        }else{
            die("Data not found");
        }

        // $html = $this->load->view('pdf_view',$data,true);
        // echo $html;
        // }else{
        //     die("Data not found");
        // }
    }

    public function activated($id){
        if (!isset($id)) show_404();
        
        if ($this->denslife_model->activated($id)) {
            redirect(site_url('denslife'));
        }
    }

    public function inactivated($id){
        if (!isset($id)) show_404();
        
        if ($this->denslife_model->inactivated($id)) {
            redirect(site_url('denslife'));
        }
    }

    public function compare_highlight(){
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
        $this->load->model('denslife_model');
        $urlimage = $this->denslife_model->getimage_highlight();
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

    public function compare_imagehighlight($field = null){
        //get from database
        $this->load->model('denslife_model');
        $urlimage = $this->denslife_model->getimage_highlight();
        $_compare = $this->compare_highlight($urlimage, $field);
        echo json_encode($_compare);
    }

    public function get_highlight($id){
        $article_id = $this->uri->segment(3);
        if($id==null){
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>whatson id kosong</div>');
            redirect('denslife');
        }
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        
        $this->load->model('denslife_model');
        $urlimage = $this->denslife_model->getimage_highlight();
        $json_image=json_encode($urlimage);
        
        $url='http://wp.dens.tv/imagelist?CH=highlight_v1/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        
        $data['article_id'] = $id;
        $data['gallery'] = $this->compare_highlight($urlimage,'url');
        $data['poster'] = $this->denslife_model->get_poster_highlight($id);
        // print_r($data['poster']);die;
        $this->template->load('template', 'denslife/add_highlight', $data);
    }

    public function add_highlight(){
        $id_article = $this->input->post('article_id',TRUE);
        $this->form_validation->set_rules('image_poster', 'Poster Highlight', 'trim|required');
        $this->form_validation->set_rules('startdate_highlight', 'Start Date', 'trim|required');
        $this->form_validation->set_rules('enddate_highlight', 'End Date', 'trim|required');
        $this->form_validation->set_rules('article_id', 'ID Article', 'trim|required');
        $this->form_validation->set_rules('highlight_update', 'Updated at', 'trim');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>masih ada field yang belum diisi, silahkan diisi kembali</div>');
            redirect("denslife/get_highlight/".$id_article);
        }else{
            $url_image1 = $this->input->post('image_poster',TRUE);
            $url_image2 = "http://wp.dens.tv/img/denslife_v1/1280x720/thumbnail/".basename($url_image1);
            $startdate = $this->input->post('startdate_highlight',TRUE);
            $enddate = $this->input->post('enddate_highlight',TRUE);
            $highlight_update = $this->input->post('highlight_update',TRUE);
            if($url_image1 == null || $id_article == null){
                $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Poster Higlight/ID Article Kosong</div>');
                redirect("denslife/get_highlight/".$id_article);
            }else{
                $_idHighlight = $this->denslife_model->add_highlight($url_image1, $url_image2, $startdate, $enddate, $id_article, $highlight_update);
                if($_idHighlight != null){
                    $set_highlight = $this->denslife_model->set_highlight($_idHighlight);
                    $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
                    redirect('highlight');
                }
            }
        }
    }
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Podcast_v1 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('libadapter');
        $this->load->model("podcast/podcast_model_v1");
        $this->load->library('form_validation');
    }

    public function index(){
        $this->template->load('template', 'podcast/view_podcast_v1');
    }

    public function active_podcast(){
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->podcast_model_v1->active_podcast($postData);

        echo json_encode($data);
    }

    public function inactive_podcast(){
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->podcast_model_v1->inactive_podcast($postData);

        echo json_encode($data);
    }

    public function save_podcast_recom(){
        $this->form_validation->set_rules('podcast_id', 'Podcast ID', 'trim|required');
        $this->form_validation->set_rules('datetimepickerstart', 'datetime start', 'trim|required');
        $this->form_validation->set_rules('datetimepickerend', 'datetime end', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Masih ada data yang belum terisi</div>');
            redirect('podcast/podcast_v1');
        }
        else
        {
            date_default_timezone_set("Asia/Jakarta"); 
            $time = date('Y-m-d H:i:s');
            $by = $this->fungsi->user_login()->username;
            $podcast_id = $this->input->post('podcast_id',TRUE);
            $datetimestart = $this->input->post('datetimepickerstart',TRUE);
            $datetimeend = $this->input->post('datetimepickerend',TRUE);
            print_r($podcast_id);echo "<br>";
            if($podcast_id==null){
                $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Silahkan isi kembali data Podcast Recommendation dengan benar</div>');
                redirect('podcast/podcast_v1');
            }else{
                $_idPodcast = $this->podcast_model_v1->save_podcast_recom($podcast_id, $datetimestart, $datetimeend, $time, $by);
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
                redirect('podcast/podcast_v1');
            }
        }
    }

    public function category_podcast(){
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->podcast_model_v1->category_podcast($searchTerm);
        echo json_encode($response);
    }

    public function sub_category_podcast(){
        $searchTerm = $this->input->post('searchTerm');
        $id_cat = $this->input->post('id_cat');
        $response = $this->podcast_model_v1->sub_category_podcast($searchTerm, $id_cat);
        echo json_encode($response);
    }

    public function save_category(){
        $this->form_validation->set_rules('keyword_namecategory', 'Category name', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            alert('silahkan isi category!');
        }
        else
        {
            $keyword_name = $this->input->post('keyword_namecategory');
            $keyword_icon = $this->input->post('icon_category');
            if ($keyword_name != null) {
                $data = array(
                    'keyword_name' => $keyword_name,
                    'keyword_sort' => '1',
                    'keyword_child' => 'SIN',
                    'keyword_sub' => 'N',
                    'keyword_ref' => 'POD',
                    'keyword_visible' => 'Y',
                    'icon' => $keyword_icon
                );
                $insert = $this->podcast_model_v1->save_category($data);
                echo json_encode(array("status" => TRUE));
            }else{
                alert('data gagal disimpan');
            }
        }
    }

    public function save_sub_category(){
        $this->form_validation->set_rules('keyword_name', 'Sub Category name', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            alert('silahkan isi category!');
        }
        else
        {
            $keyword_ref = $this->input->post('contentid');
            $keyword_name = $this->input->post('keyword_name');
            if ($keyword_name != null) {
                $data = array(
                    'keyword_name'     => $keyword_name,
                    'keyword_sort'     => '1',
                    'keyword_child'    => 'SIN',
                    'keyword_sub'      => 'N',
                    'keyword_ref'      => 'POD',
                    'keyword_visible'  => 'Y',
                    'keyword_parentid' => ','.$keyword_ref.','
                );
                $insert = $this->podcast_model_v1->save_sub_category($data);
                echo json_encode(array("status" => TRUE));
            }else{
                alert('data gagal disimpan');
            }
        }
    }

    public function add_podcast(){
        $this->template->load('template', 'podcast/create_podcast_v1');
    }

    public function save_podcast(){
        $this->form_validation->set_rules('category_podcast', 'Category', 'trim');
        $this->form_validation->set_rules('sub_category_podcast[]', 'Sub Category', 'trim');
        $this->form_validation->set_rules('podcast_name', 'Podcast Name', 'trim|required');
        $this->form_validation->set_rules('link_rss', 'Link RSS', 'trim|required');
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
            $category = $this->input->post('category_podcast',TRUE);
            $sub_category_podcast = implode(",",$this->input->post('sub_category_podcast',TRUE));
            $id_cat = ','.$category.','.$sub_category_podcast.',';
            $podcast_name = $this->input->post('podcast_name',TRUE);
            $link_rss = $this->input->post('link_rss',TRUE);
            if($category == null || $link_rss == null){
                $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Silahkan isi kembali data Podcast dengan benar</div>');
                $this->add_podcast();
            }else{
                $_idPodcast = $this->podcast_model_v1->save_podcast($id_cat, $podcast_name, $link_rss, $time, $by);
                $url_rss = $this->parse_rss($_idPodcast, $link_rss);
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
                redirect('podcast/podcast_v1');
            }
        }
    }

    public function getedit_podcast($id=null){
        $podcast_id = $this->uri->segment(4);
        if($id==null){
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>podcast id kosong</div>');
            redirect('podcast/podcast_v1');
        }
        
        $data['podcast_id'] = $id;
        $data['category'] = $this->podcast_model_v1->get_category_id($id);
        $typecat = trim($data['category'][0]['keyword_id'], ',');
        $typecateg = explode(',', $typecat);
        $data['typecat'] = $typecateg[0];
        $data['podkeyword'] = $this->podcast_model_v1->pod_keyword();
        $data['podsubkeyword'] = $this->podcast_model_v1->pod_sub_keyword();
        $data['catcontent'] = $this->podcast_model_v1->cat_content()->result();
        $this->template->load('template', 'podcast/edit_podcast_v1', $data);
    }

    public function get_podcast_id(){
        $podcast_id = $this->input->post('podcast_id',TRUE);
        $podcast = $this->podcast_model_v1->get_podcast_id($podcast_id);
        if($podcast!=null){
            $data = array(
                'podcast_id' => $podcast[0]->podcast_id,
                'podcast_name' => $podcast[0]->podcast_name,
                'link_rss' => $podcast[0]->podcast_link_rss,
                'podcast_category' => $podcast[0]->keyword_id,
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
        $category = $this->input->post('category_podcast',TRUE);
        $sub_category_podcast = implode(",",$this->input->post('sub_category_podcast',TRUE));
        $id_cat = ','.$category.','.$sub_category_podcast.',';
        $podcast_name = $this->input->post('podcast_name',TRUE);
        $link_rss = $this->input->post('link_rss',TRUE);
        $podcast_id = $this->input->post('podcast_id',TRUE);
        $_idposter = $this->podcast_model_v1->update_podcast($time, $by, $id_cat, $podcast_name, $link_rss, $podcast_id);
        $url_rss = $this->update_parse_rss($podcast_id, $link_rss);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('podcast/podcast_v1');
    }

    public function detail($id){
        if (!isset($id)) redirect('podcast');       
        $podcast = $this->podcast_model_v1;
        $_data = $podcast->get_detail_podcast($id);
        
        $data["podcast"] = null;
        if (!empty($_data)){
            $data["podcast"] =(object)$_data[0];
        }
        if (!$data["podcast"]) show_404();
        $this->template->load('template', 'podcast/detail_podcast_v1', $data);
    }

    public function activated($id){
        if (!isset($id)) show_404();
        
        if ($this->podcast_model_v1->activated($id)) {
            redirect(site_url('podcast/podcast_v1'));
        }
    }

    public function inactivated($id){
        if (!isset($id)) show_404();
        
        if ($this->podcast_model_v1->inactivated($id)) {
            redirect(site_url('podcast/podcast_v1'));
        }
    }

    public function parse_rss($_idPodcast="", $link_rss="") {
        $fileContents= file_get_contents($link_rss);
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml = simplexml_load_string($fileContents, 'SimpleXMLElement', LIBXML_NOCDATA);
        // $json = json_encode($simpleXml);
        $data = json_decode(json_encode($simpleXml),true);
        // print_r($data);die();
        
        if($data !=null){
            $podcast_data = array();
            if(array_key_exists('channel', $data)){
                $_podcastdata = $data['channel'];
                //podcast data
                $podcast_data['podcast_id'] = $_idPodcast; //podcast id
                $podcast_data['podcast_title'] = $_podcastdata['title'];
                $podcast_data['podcast_desc'] = $_podcastdata['description'];
                $podcast_data['podcast_link'] = $_podcastdata['link'];
                $podcast_data['podcast_image'] = $_podcastdata['image']['url'];
                $podcast_data['podacst_author'] = $_podcastdata['author'];
                $podcast_data['podcast_copyright'] = $_podcastdata['copyright'];
                $podcast_data['podcast_language'] = $_podcastdata['language'];
                $podcast_data['podcast_builddate'] = $_podcastdata['lastBuildDate'];
                $podcast_data['created_at'] = date('Y-m-d H:i:s');
                $podcast_data['updated_at'] = date('Y-m-d H:i:s'); //isi jika melakukan update
                $podcast_data['ctrloc'] = "/podcast/podcast_v1/parse_rss"; //isi ctrloc

                //save podcast
                //ambil id podcast_data
                $_idPodcast_data = $this->podcast_model_v1->save_podcast_data($podcast_data);

                //podcast item
                if(array_key_exists('item', $_podcastdata) && $_idPodcast_data != null){
                    $_item = $_podcastdata['item'];
                    krsort($_item);
                    if($_item!=null){
                        $podcast_episode = array();
                        foreach ($_item as $key => $value){
                            $podcast_episode[$key]['podcast_data_id'] = $_idPodcast_data;
                            $podcast_episode[$key]['episode_title'] = $value['title'];
                            $podcast_episode[$key]['episode_desc'] = preg_replace('/<[^>]*>/', '', $value['description']);
                            $podcast_episode[$key]['episode_pubdate'] = $value['pubDate'];
                            $_enclosure = array_key_exists('enclosure', $value)!=false?$value['enclosure']:null;
                            $podcast_episode[$key]['episode_enclosure_link'] = $_enclosure!=null?$_enclosure['@attributes']['url']:null;
                            $podcast_episode[$key]['episode_length'] =  $_enclosure!=null?$_enclosure['@attributes']['length']:null;
                            $podcast_episode[$key]['episode_image'] = null;
                            $podcast_episode[$key]['created_at'] = date('Y-m-d H:i:s');
                            $podcast_episode[$key]['updated_at'] = date('Y-m-d H:i:s'); //isi jika melakukan update
                            $podcast_episode[$key]['ctrloc'] = '/podcast/podcast_v1/parse_rss'; // isi ctrloc
                        }
                    }
                }
                $_idPodcast_episode = $this->podcast_model_v1->save_podcast_episode($podcast_episode);
            }
        }
    }

    public function update_parse_rss($podcast_id="", $link_rss="") {
        $fileContents= file_get_contents($link_rss);
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml = simplexml_load_string($fileContents, 'SimpleXMLElement', LIBXML_NOCDATA);
        $data = json_decode(json_encode($simpleXml),true);
        
        if($data !=null){
            $podcast_data = array();
            if(array_key_exists('channel', $data)){
                $_podcastdata = $data['channel'];
                //podcast data
                $podcast_data['podcast_id'] = $podcast_id; //podcast id
                $podcast_data['podcast_title'] = $_podcastdata['title'];
                $podcast_data['podcast_desc'] = $_podcastdata['description'];
                $podcast_data['podcast_link'] = $_podcastdata['link'];
                $podcast_data['podcast_image'] = $_podcastdata['image']['url'];
                $podcast_data['podacst_author'] = $_podcastdata['author'];
                $podcast_data['podcast_copyright'] = $_podcastdata['copyright'];
                $podcast_data['podcast_language'] = $_podcastdata['language'];
                $podcast_data['podcast_builddate'] = $_podcastdata['lastBuildDate'];
                $podcast_data['updated_at'] = date('Y-m-d H:i:s');
                $podcast_data['ctrloc'] = "/podcast/podcast_v1/update_parse_rss";

                $_idPodcast_data = $this->podcast_model_v1->update_podcast_data($podcast_data);

                //podcast item
                if(array_key_exists('item', $_podcastdata) && $podcast_id != null){
                    $_item = $_podcastdata['item'];
                    krsort($_item);
                    if($_item!=null){
                        $podcast_episode = array();
                        $i=1;
                        foreach ($_item as $key => $value){
                            $podcast_episode[$key]['podcast_seq'] = $i++;
                            $podcast_episode[$key]['podcast_data_id'] = $podcast_id;
                            $podcast_episode[$key]['episode_title'] = $value['title'];
                            $podcast_episode[$key]['episode_desc'] = preg_replace(['/<[^>]*>/', '/[\x{1F600}-\x{1F64F}]/u', '/[\x{1F300}-\x{1F5FF}]/u', '/[\x{1F680}-\x{1F6FF}]/u', '/[\x{2700}-\x{27BF}]/u', '/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{1F000}-\x{1FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F9FF}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F9FF}][\x{1F000}-\x{1FEFF}]?/u'], ['', '', '', '', '', ''], $value['description']);
                            $podcast_episode[$key]['episode_pubdate'] = $value['pubDate'];
                            $_enclosure = array_key_exists('enclosure', $value)!=false?$value['enclosure']:null;
                            $podcast_episode[$key]['episode_enclosure_link'] = $_enclosure!=null?$_enclosure['@attributes']['url']:null;
                            $podcast_episode[$key]['episode_length'] =  $_enclosure!=null?$_enclosure['@attributes']['length']:null;
                            $podcast_episode[$key]['episode_image'] = null;
                            $podcast_episode[$key]['created_at'] = date('Y-m-d H:i:s');
                            $podcast_episode[$key]['updated_at'] = date('Y-m-d H:i:s');
                            $podcast_episode[$key]['ctrloc'] = '/podcast/podcast_v1/update_parse_rss';
                        }
                    }

                    usort($podcast_episode, function($a, $b) {
                        return $a['podcast_seq'] - $b['podcast_seq'];
                    });
                    // print_r($podcast_episode);die();

                    $_idPodcast_episode = $this->podcast_model_v1->get_eps_data($podcast_id);

                    if($podcast_episode!=null && $_idPodcast_episode!=null){
                        $podcast_eps_seq = array();
                        foreach ($podcast_episode as $index => $content) {
                            foreach ($_idPodcast_episode as $keys => $values) {
                                $podcast_eps_seq[$keys]['podcast_episode_id'] = $values['podcast_episode_id'];
                                $podcast_eps_seq[$index]['podcast_data_id'] = $content['podcast_data_id'];
                                $podcast_eps_seq[$index]['episode_title'] = $content['episode_title'];
                                $podcast_eps_seq[$index]['episode_desc'] = $content['episode_desc'];
                                $podcast_eps_seq[$index]['episode_pubdate'] = $content['episode_pubdate'];
                                $podcast_eps_seq[$index]['episode_enclosure_link'] = $content['episode_enclosure_link'];
                                $podcast_eps_seq[$index]['episode_length'] = $content['episode_length'];
                                $podcast_eps_seq[$index]['episode_image'] = $content['episode_image'];
                                $podcast_eps_seq[$index]['created_at'] = $content['created_at'];
                                $podcast_eps_seq[$index]['updated_at'] = $content['updated_at'];
                                $podcast_eps_seq[$index]['ctrloc'] = $content['ctrloc'];
                            }
                        }
                        // print_r($podcast_eps_seq);die();
                        if($podcast_eps_seq!=null){
                            $update_podcast_eps=array();
                            foreach($podcast_eps_seq as $key1 => $value2){
                                if($value2["podcast_episode_id"]!=null){
                                    $update_podcast_eps[]=$value2;
                                }
                            }

                            $insert_podcast_eps=array();
                            foreach($podcast_eps_seq as $key2 => $value3){
                                if($value3["podcast_episode_id"]==null){
                                    $insert_podcast_eps[]=$value2;
                                }
                            }
                        }
                        // print_r($update_podcast_eps);echo "<br><br><hr>";
                        // print_r($insert_podcast_eps);die();
                    }else{
                        $podcast_batch = array();
                        foreach ($podcast_episode as $index1 => $content1) {
                            $podcast_batch[$index1]['podcast_data_id'] = $content1['podcast_data_id'];
                            $podcast_batch[$index1]['episode_title'] = $content1['episode_title'];
                            $podcast_batch[$index1]['episode_desc'] = $content1['episode_desc'];
                            $podcast_batch[$index1]['episode_pubdate'] = $content1['episode_pubdate'];
                            $podcast_batch[$index1]['episode_enclosure_link'] = $content1['episode_enclosure_link'];
                            $podcast_batch[$index1]['episode_length'] = $content1['episode_length'];
                            $podcast_batch[$index1]['episode_image'] = $content1['episode_image'];
                            $podcast_batch[$index1]['created_at'] = $content1['created_at'];
                            $podcast_batch[$index1]['updated_at'] = $content1['updated_at'];
                            $podcast_batch[$index1]['ctrloc'] = $content1['ctrloc'];
                        }
                    }
                    // print_r($podcast_batch);die();
                }

                if($update_podcast_eps!=null){
                    $update_pod_eps = $this->podcast_model_v1->update_pod_eps($update_podcast_eps);
                }

                if($insert_podcast_eps!=null){
                    $insert_pod_eps = $this->podcast_model_v1->insert_pod_eps($insert_podcast_eps);
                }

                if($update_podcast_eps==null && $insert_podcast_eps==null){
                    $insert_batch_pod = $this->podcast_model_v1->insert_batch_pod($podcast_batch);
                }
            }
        }
    }

}
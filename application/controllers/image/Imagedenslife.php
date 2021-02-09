<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Imagedenslife extends CI_Controller {
	function __construct(){
        parent::__construct();
        // check_not_login();
        $this->load->model('image/image_model');
        $this->load->library('session');
        $this->load->library('libadapter');
        $this->load->helper('url');
    }

	public function index()
	{
		$data['tmp_poster'] = $this->image_model->get_products();
		$this->template->load('template', 'imagedenslife/img_view', $data);
	}

    public function add_poster($id=null){
        if($id==null){
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>whatson id kosong</div>');
            redirect('imagedenslife');
        }
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        
        $this->load->model('image/image_model');
        $urlimage = $this->image_model->getimage();
        $json_image=json_encode($urlimage);
        
        $url='http://wp.dens.tv/imagelist?CH=denslife_v1/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        
        $_det = $this->image_model->get_products();
        $data['tmp_poster'] = $_det;
        $data['article_id'] = $id;
        $data['gallery'] = $this->compare($urlimage,'url');
        $this->template->load('template', 'imagedenslife/new_poster', $data);
    }

    public function save_poster(){
        $poster_url1 = $this->input->post('image_poster',TRUE);
        $poster_url2 = "http://wp.dens.tv/img/denslife_v1/1280x720/thumbnail/".basename($poster_url1);
        $poster_id   = $this->input->post('poster_id',TRUE);
        $poster_update   = $this->input->post('poster_update',TRUE);
        $_idposter   = $this->image_model->save_poster($poster_url1,$poster_url2,$poster_id,$poster_update);
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('image/imagedenslife/add_content/'.$poster_id);
    }

    public function edit_poster($id=null){
        $article_id = $this->uri->segment(4);
        if($id==null){
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>whatson id kosong</div>');
            redirect('denslife');
        }
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        
        $this->load->model('image/image_model');
        $urlimage = $this->image_model->getimage();
        $json_image=json_encode($urlimage);
        
        $url='http://wp.dens.tv/imagelist?CH=denslife_v1/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        
        $_det = $this->image_model->get_products();
        $data['tmp_poster'] = $_det;
        $data['article_id'] = $id;
        $data['gallery'] = $this->compare($urlimage,'url');
        $data['poster'] = $this->image_model->get_poster_by_id($id);
        // print_r($data['poster']);die;
        $this->template->load('template', 'imagedenslife/edit_poster', $data);
    }

    public function get_data_poster(){
        $article_id = $this->input->post('article_id',TRUE);
        $article = $this->image_model->get_article_by_id($article_id);
        if($article!=null){
            $data = array(
                'article_id' => $article[0]->article_id,
                'poster' => $this->image_model->get_poster_by_id($article_id),
            );
        }else{
            die("Data not found");
        }
        echo json_encode($data);
    }

    public function update_poster(){
        $poster_url1  = $this->input->post('image_poster',TRUE);
        $poster_url2 = "http://wp.dens.tv/img/denslife_v1/1280x720/thumbnail/".basename($poster_url1);
        $article_id   = $this->input->post('article_id',TRUE);
        $poster_id1   = $this->input->post('poster_id1',TRUE);
        $poster_id2   = $this->input->post('poster_id2',TRUE);
        $poster_id3   = $this->input->post('poster_id3',TRUE);
        $poster_update   = $this->input->post('poster_update',TRUE);

        if ($article_id != null && $poster_id1 != null) {
            $_idposter = $this->image_model->update_poster($poster_url1,$poster_url2,$article_id,$poster_id1,$poster_id2,$poster_id3,$poster_update);
        } else {
            $_idposteradd = $this->image_model->save_poster_new($poster_url1,$poster_url2,$article_id,$poster_update);
        }
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Disimpan</div>');
        redirect('image/imagedenslife/edit_content/'.$article_id);
    }

    // add new product
    public function add_content($id=null){
        if($id==null){
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>whatson id kosong</div>');
            redirect('image/imagedenslife');
        }
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        
        $this->load->model('image/image_model');
        $urlimage = $this->image_model->getimage();
        $json_image=json_encode($urlimage);
        
        $url='http://wp.dens.tv/imagelist?CH=denslife_v1/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        
        $_det = $this->image_model->get_products();
        $data['tmp_poster'] = $_det;
        $data['article_id'] = $id;
        $data['gallery1'] = $this->compare($urlimage,'url');
        $data['gallery2'] = $this->get_video($urlimage,'url');
        $this->template->load('template', 'imagedenslife/new_content', $data);
        // $this->template->load('template', 'imagedenslife/new_contentnewbc', $data);
    }

    public function save_content(){
        // Ambil data yang dikirim dari form
        $poster_url  = $this->input->post('poster_url',TRUE);
        $product_id  = $this->input->post('product_id',TRUE);

        $data = array();
        $date = date('Y-m-d h:i:s');
        foreach ($product_id as $key => $val) {
            if (! empty($poster_url[$key]))
            {
                array_push($data,
                    array(
                        'product_id'=>'ARPC_' . $val . '_' . ($key+1),
                        'poster_type'=>'arpc_1280x720',
                        'poster_url'=>"https://pic.dens.tv/wp/img/denslife_v1/1280x720/".basename($poster_url[$key]),
                        'poster_update'=>$date,
                        'poster_visible'=>'Y',
                    ),
                    array(
                        'product_id'=>'ARPC_' . $val . '_' . ($key+1),
                        'poster_type'=>'arpc_410x230',
                        'poster_url'=>"https://pic.dens.tv/wp/img/denslife_v1/1280x720/thumbnail/".basename($poster_url[$key]),
                        'poster_update'=>$date,
                        'poster_visible'=>'Y',
                    ),
                    array(
                        'product_id'=>'ARPC_' . $val . '_' . ($key+1),
                        'poster_type'=>'arpc_235x132',
                        'poster_url'=>"https://pic.dens.tv/wp/img/denslife_v1/1280x720/thumbnail/".basename($poster_url[$key]),
                        'poster_update'=>$date,
                        'poster_visible'=>'Y',
                    )
                );
            }
        }
        // print_r($data);die;

        if (count($data) <= 0)
        {
            echo "<script>alert('Data  kosong')</script>";
        }
        else
        {
            $sql = $this->image_model->save_content($data); // Panggil fungsi save_batch yang ada di model
        
            // Cek apakah query insert nya sukses atau gagal
            if($sql){ // Jika sukses
                echo "<script>alert('Data berhasil disimpan');window.location = '".base_url('denslife/denslife')."';</script>";
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Article berhasil ditambahkan</div>');
            }else{ // Jika gagal
                echo "<script>alert('Data gagal disimpan');window.location = '".base_url('denslife/denslife')."';</script>";
            }
        }    
    }

    public function save_video(){
        // Ambil data yang dikirim dari form
        $poster_url  = $this->input->post('stream_url',TRUE);
        $product_id  = $this->input->post('video_id',TRUE);
        $video_url  = $this->input->post('video_url',FALSE);
        $stream_type  = $this->input->post('stream_type',TRUE);
        $prodid  = $this->input->post('idprod',TRUE);
        // print_r($stream_type);echo "<br><br>";
        // print_r($prodid);die();
        
        $data = array();
        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d h:i:s');
        $i = 0;
        foreach($product_id as $key1 => $datas){
            foreach ($datas as $key2 => $value) {
                if (! empty($product_id[$key1][$key2]) && $poster_url[$key1][$key2] != "" && $poster_url[$key1][$key2]!= null) {
                    array_push($data,
                        array(
                            'product_id'=>'DLS_' . $product_id[$key1][$key2] . '_' . ($i+1),
                            'poster_type'=>'dls_1280x720',
                            'poster_url'=>$poster_url[$key1][$key2],
                            'poster_update'=>$date,
                            'poster_visible'=>'Y',
                        ),
                        array(
                            'product_id'=>'DLS_' . $product_id[$key1][$key2] . '_' . ($i+1),
                            'poster_type'=>'dls_410x230',
                            'poster_url'=>$poster_url[$key1][$key2],
                            'poster_update'=>$date,
                            'poster_visible'=>'Y',
                        ),
                        array(
                            'product_id'=>'DLS_' . $product_id[$key1][$key2] . '_' . ($i+1),
                            'poster_type'=>'dls_235x132',
                            'poster_url'=>$poster_url[$key1][$key2],
                            'poster_update'=>$date,
                            'poster_visible'=>'Y',
                        )
                    );
                }
                $i++;
            }
        }
        // print_r($data);echo "<br><br>";
        $vidpos = array();
        $i = 0;
        foreach($video_url as $key1 => $datas){
            foreach ($datas as $key2 => $value) {
                if (!empty($product_id[$key1][$key2]) && $video_url[$key1][$key2] != "" && $video_url[$key1][$key2]!= null) {
                    array_push($vidpos,
                        array(
                        'stream_type'=>$stream_type[$key1][$key2],
                        'stream_screen'=>'101',
                        'stream_length'=>'98',
                        'product_id'=>$prodid[$key1][$key2],
                        'stream_url'=>str_replace('"', "'", $video_url[$key1][$key2]),
                        'stream_pass'=>'0',
                        'stream_visible'=>'Y',
                        )
                    );
                }
                $i++;
            }
        }
        // print_r($vidpos);die();

        if (count($data) <= 0 && count($vidpos) <= 0)
        {
            echo "<script>alert('Data video kosong');window.location = '".base_url('denslife/denslife')."';</script>"; 

        }
        else
        {
            $sql = $this->image_model->save_video($data); // Panggil fungsi save_batch yang ada di model
            $sql = $this->image_model->save_vid_pos($vidpos); // Panggil fungsi save_batch yang ada di model
            
            // Cek apakah query insert nya sukses atau gagal
            if($sql){ // Jika sukses
                echo "<script>alert('Data berhasil disimpan');window.location = '".base_url('denslife/denslife')."';</script>";
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Article berhasil ditambahkan</div>');
            }else{ // Jika gagal
                echo "<script>alert('Data gagal disimpan');window.location = '".base_url('image/imagedenslife/add_content')."';</script>";
            }
        }
    }

    public function edit_content($id=null){
        $article_id = $this->uri->segment(4);
        if($id==null){
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>whatson id kosong</div>');
            redirect('denslife/denslife');
        }
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        
        $this->load->model('image/image_model');
        $urlimage = $this->image_model->getimage();
        $json_image=json_encode($urlimage);
        
        $url='http://wp.dens.tv/imagelist?CH=denslife_v1/1280x720&token='. $data['token'];
        $post=array();
        $exe_url = $this->libadapter->execurl($url, $post);
        $url_token=json_decode($exe_url['data']);
        
        $_det = $this->image_model->get_products();
        $data['tmp_poster'] = $_det;
        $data['article_id'] = $id;
        $data['gallery1'] = $this->compare($urlimage,'url');
        $data['gallery2'] = $this->get_video($urlimage,'url');
        // $data['poster'] = $this->image_model->get_content_by_id($id);
        // print_r($data['poster']);die;
        $this->template->load('template', 'imagedenslife/edit_content', $data);
    }

    public function get_data_image(){
        $article_id = $this->input->post('article_id',TRUE);
        $article = $this->image_model->get_article_by_id($article_id);
        if($article!=null){
            $group = $this->image_model->get_image_by_id($article_id);
            // var_dump($group);die;
            foreach ($group as $key => $value) {
                $size[$value['product_id']][] = $value;

                // if ($size[$value['product_id']]  == $value['product_id']) {
                //     array_push($size, array('poster_url'=>$value['poster_url'], 'detail'=>$value));
                //     $size[$value['product_id']]['poster_url'] = $value['poster_url'];
                //     $size[$value['product_id']]['detail'] = $value;
                // }
            }
            // var_dump($size);die;
            $data = array(
                'article_id' => $article[0]->article_id,
                'poster' => $size
            );
        }else{
            die("Data not found");
        }
        echo json_encode($data);
    }

    public function get_data_video(){
        $article_id = $this->input->post('article_id',TRUE);
        $article = $this->image_model->get_article_by_id($article_id);
        if($article!=null){
            $group = $this->image_model->get_video_by_id($article_id);
            // var_dump($group);die;
            foreach ($group as $key => $value) {
                $size[$value['productid_poster']][] = $value;

                // if ($size[$value['product_id']]  == $value['product_id']) {
                //     array_push($size, array('poster_url'=>$value['poster_url'], 'detail'=>$value));
                //     $size[$value['product_id']]['poster_url'] = $value['poster_url'];
                //     $size[$value['product_id']]['detail'] = $value;
                // }
            }
            // var_dump($size);die;
            $data = array(
                'article_id' => $article[0]->article_id,
                'poster' => $size
            );
        }else{
            die("Data not found");
        }
        echo json_encode($data);
    }

    public function update_content(){
        // Ambil data yang dikirim dari form
        $poster_url  = $this->input->post('poster_url',TRUE);
        $product_id  = $this->input->post('product_id',TRUE);
        $poster_id  = $this->input->post('poster_id',TRUE);
        $poster_type = $this->input->post('poster_type',TRUE);
        $test1 = 1;

        if($poster_type!=null && !empty($poster_type)){
            $pos_type = end($poster_type);
            $test = $pos_type[0];
            $test1 = substr($test,-1)+1;
        }

        $data = array();
        $date = date('Y-m-d h:i:s');
            // $i=0;
        if (! empty($poster_id) && ! empty($poster_url)) {
            foreach($poster_id as $key1 => $datas){
                foreach ($datas as $key2 => $value) {
                    if (! empty($poster_url[$key1][$key2]))
                    {
                        if($key2==0){
                            $data[] = array(
                                'poster_url'=>"https://pic.dens.tv/wp/img/denslife_v1/1280x720/".basename($poster_url[$key1][$key2]),
                                'poster_update'=>$date,
                                'poster_id' => $poster_id[$key1][$key2],
                            );
                        }else{
                            $data[] = array(
                                'poster_url'=>"https://pic.dens.tv/wp/img/denslife_v1/1280x720/thumbnail/".basename($poster_url[$key1][$key2]),
                                'poster_update'=>$date,
                                'poster_id' => $poster_id[$key1][$key2],
                            );
                        }
                    }
                }
                // $i++;
            }
        }
        // print_r($data); echo "<br/><br/>";

        $tambah = array();
        $date = date('Y-m-d h:i:s');
        foreach($poster_url as $key1 => $datas){
            foreach ($datas as $key2 => $value) {
                if (empty($poster_id[$key1][$key2]) && $poster_url[$key1][$key2] != null) {
                    array_push($tambah,
                        array(
                            'product_id'=>'ARPC_' . $product_id[$key1][$key2] . '_' . ($test1),
                            'poster_type'=>'arpc_1280x720',
                            'poster_url'=>"https://pic.dens.tv/wp/img/denslife_v1/1280x720/".basename($poster_url[$key1][$key2]),
                            'poster_update'=>$date,
                            'poster_visible'=>'Y',
                        ),
                        array(
                            'product_id'=>'ARPC_' . $product_id[$key1][$key2] . '_' . ($test1),
                            'poster_type'=>'arpc_410x230',
                            'poster_url'=>"https://pic.dens.tv/wp/img/denslife_v1/1280x720/thumbnail/".basename($poster_url[$key1][$key2]),
                            'poster_update'=>$date,
                            'poster_visible'=>'Y',
                        ),
                        array(
                            'product_id'=>'ARPC_' . $product_id[$key1][$key2] . '_' . ($test1),
                            'poster_type'=>'arpc_235x132',
                            'poster_url'=>"https://pic.dens.tv/wp/img/denslife_v1/1280x720/thumbnail/".basename($poster_url[$key1][$key2]),
                            'poster_update'=>$date,
                            'poster_visible'=>'Y',
                        )
                    );
                    ++$test1;
                }
            }
        }
        // print_r($tambah);die;

        if (count($data) <= 0 && count($tambah) <= 0) {
            echo "<script>alert('Data  kosong')</script>";           
        }else{
            if ($data != null) {
                // Panggil fungsi save_batch yang ada di model
                $sql1 = $this->image_model->update_content($data);
            }
            if ($tambah != null) {
                $sql2 = $this->image_model->tambah_content($tambah);
            }
        }

        // Cek apakah query insert nya sukses atau gagal
        if($sql1 || $sql2){ // Jika sukses
            echo "<script>alert('Data berhasil disimpan');window.location = '".base_url('denslife/denslife')."';</script>";
        }else{ // Jika gagal
            echo "<script>alert('Data gagal disimpan');window.location = '".base_url('denslife/denslife')."';</script>";
        }
    }

    public function update_video(){
        // Ambil data yang dikirim dari form
        $video_id  = $this->input->post('video_id',TRUE);
        $poster_url  = $this->input->post('poster_url',TRUE);
        $stream_url  = $this->input->post('video_url',FALSE);
        $poster_id  = $this->input->post('poster_id',TRUE);
        $stream_id  = $this->input->post('stream_id',TRUE);
        $stream_type  = $this->input->post('stream_type',TRUE);
        $idprod = $this->input->post('idprod',TRUE);
        $product_id = $this->input->post('product_id',TRUE); //utk gambar
        $productid_poster = $this->input->post('productid_poster',TRUE); //utk video
        $pos_test1  = 1;
        $vid_test1 = 1;

        if($product_id!=null && !empty($product_id)){
            $vid_type = end($product_id);
            $vid_types = end($vid_type);
            $vid_test1 = substr($vid_types,-1)+1;
        }

        if($productid_poster!=null && !empty($productid_poster)){
            $pos_type = end($productid_poster);
            $pos_test = $pos_type[0];
            $pos_test1 = substr($pos_test,-1)+1;
        }
        
        $data1 = array();
        $date = date('Y-m-d h:i:s');
        if (! empty($poster_id)) {
            foreach($poster_id as $key1 => $datas){
                foreach ($datas as $key2 => $value) {
                    if (! empty($poster_url[$key1][$key2]) && ! empty($poster_id[$key1][$key2])){
                        $data1[] = array(
                            'poster_url'=>$poster_url[$key1][$key2],
                            'poster_id' => $poster_id[$key1][$key2],
                            'poster_update'=>$date,
                        );
                    }
                }
            }
        }
        // print_r($data1); echo "<br/><br/>";

        $data2 = array();
        $date = date('Y-m-d h:i:s');
        if (! empty($stream_id)) {
            foreach($stream_id as $key1 => $datas){
                foreach ($datas as $key2 => $value) {
                    if (! empty($stream_url[$key1][$key2]) && ! empty($stream_id[$key1][$key2])){
                        $data2[] = array(
                            'stream_url'=>str_replace('"', "'", $stream_url[$key1][$key2]),
                            'stream_id' => $stream_id[$key1][$key2],
                            'product_id' => $product_id[$key1][$key2],
                            'stream_type' => $stream_type[$key1][$key2],
                        );
                    }
                }
            }
        }
        // print_r($data2); echo "<br/><br/>";

        $tambah_poster = array();
        $date = date('Y-m-d h:i:s');
        foreach($poster_url as $key1 => $datas){
            foreach ($datas as $key2 => $value) {
                if (empty($poster_id[$key1][$key2]) && $poster_url[$key1][$key2] != null) {
                    array_push($tambah_poster,
                        array(
                            'product_id'=>'DLS_' . $video_id[$key1][$key2] . '_' . ($pos_test1),
                            'poster_type'=>'dls_1280x720',
                            'poster_url'=>$poster_url[$key1][$key2],
                            'poster_update'=>$date,
                            'poster_visible'=>'Y',
                        ),
                        array(
                            'product_id'=>'DLS_' . $video_id[$key1][$key2] . '_' . ($pos_test1),
                            'poster_type'=>'dls_410x230',
                            'poster_url'=>$poster_url[$key1][$key2],
                            'poster_update'=>$date,
                            'poster_visible'=>'Y',
                        ),
                        array(
                            'product_id'=>'DLS_' . $video_id[$key1][$key2] . '_' . ($pos_test1),
                            'poster_type'=>'dls_235x132',
                            'poster_url'=>$poster_url[$key1][$key2],
                            'poster_update'=>$date,
                            'poster_visible'=>'Y',
                        )
                    );
                    ++$pos_test1;
                }
            }
        }
        // print_r($tambah_poster); echo "<br/><br/>";

        $tambah_video = array();
        $date = date('Y-m-d h:i:s');
        foreach($stream_url as $key1 => $datas){
            foreach ($datas as $key2 => $value) {
                if (empty($stream_id[$key1][$key2]) && $stream_url[$key1][$key2] != null) {
                    array_push($tambah_video,
                        array(
                        'stream_type'=>$stream_type[$key1][$key2],
                        'stream_screen'=>'101',
                        'stream_length'=>'98',
                        'product_id'=>$product_id[$key1][$key2],
                        'stream_url'=>str_replace('"', "'", $stream_url[$key1][$key2]),
                        'stream_pass'=>'0',
                        'stream_visible'=>'Y',
                        )
                    );
                    ++$vid_test1;
                }
            }
        }
        // print_r($tambah_video);die;
        
        if (count($data1) <= 0 && count($data2) <= 0 && count($tambah_poster) <= 0 && count($tambah_video) <= 0){
            echo "<script>alert('Data video kosong')</script>"; 
        }else{
            if ($data1 != null && $data2 != null) {
                $sql1 = $this->image_model->update_video($data1); // Panggil fungsi save_batch yang ada di model
                $sql2 = $this->image_model->update_vid_pos($data2); // Panggil fungsi save_batch yang ada di model
            }
            if ($tambah_poster != null && $tambah_video != null) {
                $sql1 = $this->image_model->tambah_poster($tambah_poster); // Panggil fungsi save_batch yang ada di model
                $sql2 = $this->image_model->tambah_video($tambah_video); // Panggil fungsi save_batch yang ada di model
            }
        }
            
        // Cek apakah query insert nya sukses atau gagal
        if($sql1 && $sql2 || $sql3 && $sql4){ // Jika sukses
            echo "<script>alert('Data berhasil disimpan');window.location = '".base_url('denslife/denslife')."';</script>";
        }else{ // Jika gagal
            echo "<script>alert('Data gagal disimpan');window.location = '".base_url('denslife/denslife')."';</script>";
        }
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
        $this->load->model('image/image_model');
        $urlimage = $this->image_model->getimage();
        // print_r($urlimage);die;

        //formed array from folder
        $data = array();
        $_arrFolder = array();
        $_urlimage = array();
        if($url_token!=null){
            foreach ($url_token->data as $key => $value) {
                $str = str_replace(' ','',$value->type);
                if($str==="f"){
                    array_push($_arrFolder, 'http://wp.dens.tv/img/denslife_v1/1280x720/'.basename($value->path));    
                }
            }
        }
        krsort($_arrFolder);

        //formed array from database
        if($urlimage!=null){
            foreach ($urlimage as $key => $value) {
                array_push($_urlimage, 'http://wp.dens.tv/img/denslife_v1/1280x720/'.basename($value['poster_url']) );
            }
        }

        $datas = array_values(array_diff($_arrFolder,$_urlimage));
        $data = array_slice($datas, 0, 10);
        // print_r($data);die();
        return $data;
    }

    public function compare_image($field = null){
        //get from database
        $this->load->model('image/image_model');
        $urlimage = $this->image_model->getimage();
        $_compare = $this->compare($urlimage, $field);
        echo json_encode($_compare);
    }

    public function compare_video($field = null){
        //get from database
        $this->load->model('image/image_model');
        $urlimage = $this->image_model->getimage();
        $_compare = $this->get_video($urlimage, $field);
        echo json_encode($_compare);
    }

    public function get_token(){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $_token = json_decode($exe['data'],true);
        echo $_token['token'];
    }

    public function get_test(){
        $toURL='http://aid.digdaya.co.id/uploader/getListMovie';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $_token = json_decode($exe['data'],true);
        // print_r($_token);die;
        return $_token;
    }

    public function get_video(){
        //get from folder upload
        $urlvideos = $this->get_test();
        $urlvideo = $urlvideos['data'];
        krsort($urlvideo);
        // print_r($urlvideo);die;
        $_urlimage = array();
        $this->load->model('image/image_model');
        $urlimage = $this->image_model->getimage();

        $tmpArray = array();

        if(is_array($urlvideo)&& count ($urlvideo)>0){
            foreach($urlvideo as $data1) {
                $duplicate = false;
                foreach($urlimage as $data2) {
                    if($data1['url_video_poster'] === $data2['poster_url']) $duplicate = true;
                }

                if($duplicate === false) $tmpArray[] = $data1;
            }
            // print_r($tmpArray);die();
            $tmpArray = array_slice($tmpArray, 0, 10);
            return $tmpArray;
        }
        else{
            $tmpArray = 'data image not found';
        }
        // print_r($tmpArray);die;
        return $tmpArray;
    }

    public function inactive_poster(){
        $id = $this->input->post("hid"); // this will return the hid POST parameter
        print_r($id);die();
        $this->image_model->inactive_poster($id);
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
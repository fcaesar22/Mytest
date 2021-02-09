<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Test_pdf extends CI_Controller {
    public function __construct(){
        parent::__construct();
          $this->load->helper('url');
          $this->load->model("pdf_model");
          $this->load->library('libadapter');
    }

    public function index(){
        $article = $this->pdf_model->get_article_by_id(1);
        if($article!=null){
            $data = array(
                'article_title' => $article[0]->article_title,
                'article_by' => $article[0]->article_by,
                'article_content_1' => $article[0]->article_content_1,
                'article_content_2' => $article[0]->article_content_2,
                'poster' => $this->pdf_model->get_poster_by_id(1)
            );
            $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            try {
                $mpdf = new \Mpdf\Mpdf([
                            'tempDir' => FCPATH."uploads/tmp/", // uses the current directory's parent "tmp" subfolder
                            'setAutoTopMargin' => 'stretch',
                            'setAutoBottomMargin' => 'stretch',
                    'default_font' => 'montserrat'
                      ]);
                  $html = $this->load->view('pdf_view',$data,true);
                  $mpdf->WriteHTML($html);
                      $mpdf->Output(); // opens in browser
                      // $mpdf->Output(FCPATH.'uploads/testname2.pdf','F'); // it downloads the file into the user system, with give name
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

    public function ads_html(){
        $html = $this->load->view('ex_ads.html');
    }

    public function adsvid_html(){
        $html = $this->load->view('ex_vid.html');
    }

    public function adsvideo_html(){
        $value = $this->input->get('s');
        if (!empty($value)) {
            $data = array('url_video'=>$value);
        }else{
            $data = array('url_video'=>"http://rr.digdaya.co.id/01/MVADS00005/index1.m3u8");
        }
        // print_r($data);die();
        $html = $this->load->view('ads_video', $data);
    }

    public function adsweb_html(){
        $html = $this->load->view('ex_adsweb');
    }

    public function get_web(){
        $toURL='https://cbn.id/';
        if(stristr($toURL, 'olap')==true){
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $toURL=$toURL.'&ipclient='.$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }

        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $toURL,
            CURLOPT_HEADER => 0,
            CURLOPT_VERBOSE => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
        );
        curl_setopt_array($ch, $options);
        $result = array('data' => curl_exec($ch), 'info' => curl_getinfo($ch));
        $modify = str_replace('="./', '="'.$toURL, $result['data']);
        echo $modify;
        curl_close($ch);
        // print_r($exe);die;
        // $_token = json_decode($exe['data'],true);
        // print_r($_token);die;
    }

    public function barutau()
    {
        $ch = curl_init();
        $url = "https://cbn.id/";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);

    //Execute request 
        $response = curl_exec($ch);

    //get the default response headers 
        
        $modify = str_replace('="./', '="'.$url, $response);
        echo $modify;

        header('Content-Type: text/html');
        header("Access-Control-Allow-Origin: *");

    //close connection 
        curl_close($ch);
        flush();
    }

    // public function simpenpdf($nama=''){
    //     $dimana="tmpr/";
    //     $filename=$nama.".pdf";
    //     $urllokasi="http://aid.digdaya.co.id/test_pdf/index/".$filename;
    //     echo exec("cd ".$dimana."\npwd;ls -l");//\nls\nwget ".$urllokasi."\nls -l\n"
    //     http://aid.digdaya.co.id/test_pdf/index/aid.pdf
    // }

    public function test_trumbo(){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        $this->load->model('image/image_model');
        $urlimage = $this->image_model->getimage();
        $json_image=json_encode($urlimage);
        $data['gallery2'] = $this->get_video($urlimage,'url');
        $html = $this->load->view('test_trumbo', $data);
    }

    public function save_video(){
        $url_vid = $this->input->post('vid_url',false);
        $url_vid1 = $this->input->post('con_vid',false);
        // print_r($url_vid);echo "<br><br>";;
        // print_r($url_vid1);die();
        if ($url_vid1!=null) {
            $dir = FCPATH . "ads_frame\\";
            $myFile = "filename1.html"; // or .php 
            $naming = $dir.$myFile;  
            $fh = fopen($naming, 'w'); // or die("error");  
            $stringData = '<!DOCTYPE html><html><head><meta name="viewport" content="width=device-width, initial-scale=1"><script type="text/javascript" src="http://aid.digdaya.co.id/assets/jwplayer/jwplayer.js"></script><script>jwplayer.key="O43oQ2NyiFFoHAYtP5twBStX9zBfUA836LoDx0p3WiM=";</script><style>body, html {height: 100%;margin: 0;}#myVideo {position: fixed;right: 0;bottom: 0;min-width: 100%; min-height: 100%;}</style></head><body><div class="selm-player" id="jwplayers" ></div><script type="text/javascript">var playerInstance = jwplayer("jwplayers");playerInstance.setup({autostart: true,controls: false,file:"'.$url_vid1;
            $stringData = $stringData.'",mute: false,displaytitle: false,displaydescription: false,stretching: "fill",height: "100%",width: "100%"});</script></body></html>';
            fwrite($fh, $stringData);
            fclose($fh);
            echo "Berhasil";
        }else{
            echo "data not found";
        }
    }

    public function get_token(){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $_token = json_decode($exe['data'],true);
        echo $_token['token'];
    }

    public function compare_video($field = null){
        //get from database
        $this->load->model('image/image_model');
        $urlimage = $this->image_model->getimage();
        $_compare = $this->get_video($urlimage, $field);
        echo json_encode($_compare);
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

    public function test_text(){
        $toURL='http://wp.dens.tv/gettoken';
        $post=array();
        $exe = $this->libadapter->execurl($toURL, $post);
        $json_token=json_decode($exe['data']);
        $data['token'] = $json_token->token;
        $this->load->model('image/image_model');
        $urlimage = $this->image_model->getimage();
        $json_image=json_encode($urlimage);
        $data['gallery2'] = $this->get_video($urlimage,'url');
        $html = $this->load->view('test_textarea', $data);
    }

    public function save_text(){
        $test = $this->input->post('url_test', true);
        print_r($test);die();
        $_idWhatson = $this->pdf_model->save_testarea($test);
    }

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Whatson_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    // ***
    public function getdatatables($postData=null){
        $response = array();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        ## Search 
        $searchQuery = "";
        if($searchValue != ''){
            $searchQuery = " (whatson_id like '%".$searchValue."%' or 
            whatson_title like '%".$searchValue."%' or 
            whatson_description like'%".$searchValue."%' ) ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $records = $this->db->get('whatson')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $records = $this->db->get('whatson')->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('whatson_id,whatson_title,whatson_description,whatson_image,whatson_video,category_whatson.category_whatson_name,sub_category_whatson.sub_category_whatson_name,channel_whatson.channel_whatson_name,content_id,content_url,content_url_image,whatson_schedule_time,created_date_whatson,whatson.deleted,whatson_purpose, whatson.category_whatson_id, whatson.channel_whatson_id, whatson_banner_active,is_pinned');
        $this->db->from('whatson');
        $this->db->join('category_whatson','whatson.category_whatson_id = category_whatson.category_whatson_id');
        $this->db->join('sub_category_whatson','whatson.sub_category_whatson_id = sub_category_whatson.sub_category_whatson_id');
        $this->db->join('channel_whatson','whatson.channel_whatson_id = channel_whatson.channel_whatson_id');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();

        $data = array();
        foreach($records as $record ){
            if ($record->deleted==0) {
                $data[] = array( 
                    "whatson_id"=>$record->whatson_id,
                    "whatson_title"=>$record->whatson_title,
                    "whatson_description"=>$record->whatson_description,
                    "category_whatson_name"=>$record->category_whatson_name,
                    "category_whatson_id"=>$record->category_whatson_id,
                    "content_url_image"=>$record->content_url_image,
                    "whatson_purpose"=>$record->whatson_purpose,
                    "whatson_banner_active"=>$record->whatson_banner_active,
                    "content_id"=>$record->content_id,
                    "is_pinned"=>$record->is_pinned,
                );
            }
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        return $response;
    }
    
    public function get_category(){
        // $query = $this->db->get_where('category_whatson', array('deleted' => '0'));
        $query = $this->db->order_by('category_whatson_name', 'ASC')->get_where('category_whatson', array('deleted' => '0'));
        return $query;  
    }

    public function get_sub_category(){
        // $query = $this->db->get_where('sub_category_whatson', array('deleted' => '0'));
        $query = $this->db->order_by('sub_category_whatson_name', 'ASC')->get_where('sub_category_whatson', array('deleted' => '0'));
        return $query;  
    }

    public function get_channel(){
        // $query = $this->db->get_where('channel_whatson', array('deleted' => '0'));
        $query = $this->db->order_by('channel_whatson_name', 'ASC')->get_where('channel_whatson', array('deleted' => '0'));
        return $query;  
    }

    public function get_thumbnail(){
        // $query = $this->db->get_where('thumbnail_whatson', array('deleted' => '0'));
        $query = $this->db->order_by('thumbnail_whatson_name', 'ASC')->get_where('thumbnail_whatson', array('deleted' => '0'));
        return $query;  
    }

    public function getimage(){
        // $data = $this->db->query("SELECT url FROM whatson_content where type = 'image' group by whatson_id  order by created_at desc");
        $data = $this->db->query("SELECT `content_url_image` FROM whatson UNION ALL SELECT `url` FROM whatson_content");
        $query = $data->result_array();
        if($query!=null){
            $i=0;
            foreach ($query as $key => $value) {
                $_categories = (explode('/', $value['content_url_image']));
                $_arr[$i] = array(
                    'whatson_image'=>$_categories[6],
                );
                $i++;
            }
            // print_r($_arr);die;
        }
        $test = $this->db->query("SELECT `whatson_image` FROM whatson UNION ALL SELECT `channel_whatson_logo` FROM channel_whatson");
        $query2 = $test->result_array();
        // print_r($query2);die;
        return (array_merge($_arr,$query2));
    }

    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["whatson_id" => $id])->row();
    }

    public function get_products_by_id($id){
        $this->db->select('whatson_id,whatson_title,whatson_description,whatson_image,whatson_video,category_whatson.category_whatson_name,sub_category_whatson.sub_category_whatson_name,channel_whatson.channel_whatson_name,thumbnail_whatson.thumbnail_whatson_name,thumbnail_whatson.thumbnail_whatson_logo,content_id,content_url,content_url_image,whatson_schedule_time,created_date_whatson,whatson.deleted,whatson_purpose,whatson_type');
        $this->db->from('whatson');
        $this->db->join('category_whatson','whatson.category_whatson_id = category_whatson.category_whatson_id');
        $this->db->join('sub_category_whatson','whatson.sub_category_whatson_id = sub_category_whatson.sub_category_whatson_id');
        $this->db->join('channel_whatson','whatson.channel_whatson_id = channel_whatson.channel_whatson_id');
        $this->db->join('thumbnail_whatson','whatson.thumbnail_whatson_id = thumbnail_whatson.thumbnail_whatson_id');
        $this->db->where(array('whatson.deleted' => '0'));
        $this->db->where(array('whatson.whatson_id' => $id));
        $this->db->order_by('whatson_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_products(){
        $this->db->select('whatson_id,whatson_title,whatson_description,whatson_image,whatson_video,category_whatson.category_whatson_name,sub_category_whatson.sub_category_whatson_name,channel_whatson.channel_whatson_name,thumbnail_whatson.thumbnail_whatson_name,thumbnail_whatson.thumbnail_whatson_logo,content_id,content_url,content_url_image,whatson_schedule_time,created_date_whatson,whatson.deleted,whatson_purpose, whatson.category_whatson_id, whatson.channel_whatson_id, whatson_banner_active');
        $this->db->from('whatson');
        $this->db->join('category_whatson','whatson.category_whatson_id = category_whatson.category_whatson_id');
        $this->db->join('sub_category_whatson','whatson.sub_category_whatson_id = sub_category_whatson.sub_category_whatson_id');
        $this->db->join('channel_whatson','whatson.channel_whatson_id = channel_whatson.channel_whatson_id');
        $this->db->join('thumbnail_whatson','whatson.thumbnail_whatson_id = thumbnail_whatson.thumbnail_whatson_id');
        $this->db->where(array('whatson.deleted' => '0'));
        $this->db->order_by('whatson_id', 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_product_by_id($whatson_id){
        $query = $this->db->get_where('whatson', array('whatson_id' =>  $whatson_id));
        return $query;
    }

    // ***
    public function save_product($whatson_title,$whatson_image,$whatson_video,$category_whatson_id,$sub_category_whatson_id,$channel_whatson_id,$thumbnail_whatson_id,$content_id,$content_url,$content_url_image,$whatson_schedule_time,$whatson_purpose,$whatson_type,$link_url){
        $data = array(
            'whatson_title' => $whatson_title,
            'whatson_image' => $whatson_image,
            'whatson_thumbnail' => 'thumbnail/'.$whatson_image,
            'whatson_video' => $whatson_video,
            'category_whatson_id' => $category_whatson_id,
            'sub_category_whatson_id' => $sub_category_whatson_id,
            'channel_whatson_id' => $channel_whatson_id,
            'thumbnail_whatson_id' => $thumbnail_whatson_id,
            'content_id' => $content_id,
            'content_url' => $content_url,
            'content_url_image' => $content_url_image,
            'whatson_schedule_time' => $whatson_schedule_time,
            'whatson_purpose' => $whatson_purpose,
            'whatson_type' => $whatson_type,
            'link_url' => $link_url 
        );
        $this->db->insert('whatson',$data);
        return $this->db->insert_id();
    }

    public function save_description($whatson_id,$whatson_description,$whatson_summary){
        $this->db->set('whatson_description', $whatson_description);
        $this->db->set('whatson_summary', $whatson_summary);
        $this->db->where('whatson_id', $whatson_id);
        $this->db->update('whatson');
    }

    public function update_product($whatson_id,$whatson_title,$whatson_image,$whatson_video,$category_whatson_id,$sub_category_whatson_id,$channel_whatson_id,$thumbnail_whatson_id,$content_id,$content_url,$content_url_image,$whatson_schedule_time,$whatson_purpose,$whatson_type,$link_url){
        $this->db->set('whatson_title', $whatson_title);
        $this->db->set('whatson_image', $whatson_image);
        $this->db->set('whatson_thumbnail', 'thumbnail/'.$whatson_image);
        $this->db->set('whatson_video', $whatson_video);
        $this->db->set('category_whatson_id', $category_whatson_id);
        $this->db->set('sub_category_whatson_id', $sub_category_whatson_id);
        $this->db->set('channel_whatson_id', $channel_whatson_id);
        $this->db->set('thumbnail_whatson_id', $thumbnail_whatson_id);
        $this->db->set('content_id', $content_id);
        $this->db->set('content_url', $content_url);
        $this->db->set('content_url_image', $content_url_image);
        $this->db->set('whatson_schedule_time', $whatson_schedule_time);
        $this->db->set('whatson_purpose', $whatson_purpose);
        $this->db->set('whatson_type', $whatson_type);
        $this->db->set('link_url', $link_url);
        $this->db->where('whatson_id', $whatson_id);
        $this->db->update('whatson');
    }

    public function update_description($whatson_id,$whatson_description,$whatson_summary){
        $this->db->set('whatson_description', $whatson_description);
        $this->db->set('whatson_summary', $whatson_summary);
        $this->db->where('whatson_id', $whatson_id);
        $this->db->update('whatson');
    }

    //Delete Product
    public function delete($id)
    {
        $data = array(
            'whatson_id'   => $id,     
            'deleted'      => $deleted='1'
        );
        $this->db->where('whatson_id', $id);
        $this->db->update('whatson', $data);
        redirect(site_url('whatson'));
    }

    public function activated($id)
    {
        $data = array(
            'whatson_id' => $id,     
            'whatson_banner_active' => $whatson_banner_active='1'
        );
        $this->db->where('whatson_id', $id);
        $this->db->update('whatson', $data);
        return $this->db->affected_rows();
    }

    public function inactivated($id)
    {
        $data = array(
            'whatson_id'   => $id,     
            'whatson_banner_active' => $whatson_banner_active='0'
        );
        $this->db->where('whatson_id', $id);
        $this->db->update('whatson', $data);
        return $this->db->affected_rows();
    }

    // ***
    public function pinbanner($id)
    {
        $this->db->select('count(*) as allcount');
        $this->db->from('whatson');
        $this->db->where(array('is_pinned' => 'Y', 'deleted' => '0'));
        $query = $this->db->get()->result();
        $totalRecord = $query[0]->allcount;
        // print_r($totalRecord);die();

        if ($totalRecord >= 2) {
            $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Tidak berhasil pin whatson. Jumlah pin sudah maksimal, silahkan unpin salah satu whatson!</div>');
            redirect(site_url('whatson/whatson'));
        }else{
            $this->db->set('is_pinned', "Y");
            $this->db->where('whatson_id', $id);
            $this->db->update('whatson');
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Pin Whatson</div>');
            return $this->db->affected_rows();
        }
    }

    public function unpinbanner($id)
    {
        $this->db->set('is_pinned', "N");
        $this->db->where('whatson_id', $id);
        $this->db->update('whatson');
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Unpin Whatson</div>');
        return $this->db->affected_rows();
    }

    private function _uploadImage()
    {
        $config['upload_path']          = './media/img/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']            = $this->whatson_id;
        $config['overwrite']            = true;
        $config['max_size']             = 1024; // 1MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('channel_whatson_image')) {
            return $this->upload->data("file_name");
        }
        
        return "default.jpg";
    }
    
}
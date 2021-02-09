<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Podcast_model_v1 extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
        // $this->db= $this->load->database('dbprod',true);
    }

    function active_podcast($postData=null){
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
            $searchQuery = " (podcast_id like '%".$searchValue."%' or 
            podcast_name like '%".$searchValue."%' ) ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->where('visible', 'Y');
        $records = $this->db->get('podcast')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->where('visible', 'Y');
        $records = $this->db->get('podcast')->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('A.*, B.podcast_image, C.podcast_id as id_pod_rec, C.start_periode, C.end_periode');
        $this->db->from('podcast AS A');
        $this->db->join('podcast_data AS B','B.podcast_id = A.podcast_id','Left');
        $this->db->join('podcast_recommendation AS C','C.podcast_id = A.podcast_id','Left');
        $this->db->where(array('A.visible' => 'Y'));
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result_array();
        $data = array();
        date_default_timezone_set("Asia/Jakarta"); 
        $date_now = date('Y-m-d');
        $i=0;
        foreach ($records as $key => $value) {
            if ($date_now > $value['end_periode']) {
                $status = 'FALSE';
            }else{
                $status = 'TRUE';
            }
          // if(stripos($value['keyword_id'], ',435,') !== FALSE){
            $_categories = $this->getCategoryName(explode(',', trim($value['keyword_id'], ',')));
            $data[$i] = array(
                'podcast_id'=>$value['podcast_id'],
                'podcast_name'=>$value['podcast_name'],
                'podcast_image'=>$value['podcast_image'],
                'visible'=>$value['visible'],
                'categories'=>implode(', ', $_categories),
                'id_pod_rec'=>$value['id_pod_rec'],
                'start_periode'=>$value['start_periode'],
                'end_periode'=>$value['end_periode'],
                'status'=>$status,
            );
            $i++;
          // }
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

    function inactive_podcast($postData=null){
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
            $searchQuery = " (podcast_id like '%".$searchValue."%' or 
            podcast_name like '%".$searchValue."%' ) ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->where('visible', 'N');
        $records = $this->db->get('podcast')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->where('visible', 'N');
        $records = $this->db->get('podcast')->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('A.*, B.podcast_image');
        $this->db->from('podcast AS A');
        $this->db->join('podcast_data AS B','B.podcast_id = A.podcast_id','Left');
        $this->db->where(array('A.visible' => 'N'));
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result_array();

        $data = array();
        $i=0;
        foreach ($records as $key => $value) {
          // if(stripos($value['keyword_id'], ',435,') !== FALSE){
            $_categories = $this->getCategoryName(explode(',', trim($value['keyword_id'], ',')));
            $data[$i] = array(
                'podcast_id'=>$value['podcast_id'],
                'podcast_name'=>$value['podcast_name'],
                'podcast_image'=>$value['podcast_image'],
                'visible'=>$value['visible'],
                'categories'=>implode(', ', $_categories),
            );
            $i++;
          // }
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

    public function save_podcast_recom($podcast_id, $datetimestart, $datetimeend, $time, $by){
        $this->db->select('*');
        $this->db->from('podcast_recommendation');
        $this->db->where(array('podcast_id' => $podcast_id));
        $query = $this->db->get()->result_array();
        if ($query==null) {
            $data = array(
                'podcast_id' => $podcast_id,
                'start_periode' => $datetimestart,
                'end_periode' => $datetimeend,
                'created_at' => $time,
                'created_by' => $by,
                'updated_at' => $time,
                'updated_by' => $by,
                'ctrloc' => '/podcast/podcast_v1/save_podcast_recom'
            );
            $this->db->insert('podcast_recommendation',$data);
            return $this->db->insert_id();
        }else{
            $this->db->set('start_periode', $datetimestart);
            $this->db->set('end_periode', $datetimeend);
            $this->db->set('updated_at', $time);
            $this->db->set('updated_by', $by);
            $this->db->set('ctrloc', '/podcast/podcast_v1/save_podcast_recom');
            $this->db->where('podcast_id', $podcast_id);
            $this->db->update('podcast_recommendation');
        }
    }

    //return category name
    public function getCategoryName($id){
        $_arr = array();
        $sql = $this->db->select('*')
                        ->from('keywords')
                        ->where_in('keyword_id', $id)
                        ->get()
                        ->result_array();
        if(count($sql)==0){
            return false;
        }
        foreach ($sql as $key => $value) {
            array_push($_arr, $value['keyword_name']);
        }
        return $_arr;
    }

    public function category_podcast($searchTerm=""){
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'POD', 'keywords.keyword_parentid' => null));
        $this->db->order_by('keyword_id', 'DESC');
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], "icon"=>$cat['icon']);
        }
        return $data;
    }

    public function save_category($data)
    {
        $this->db->insert('keywords', $data);
        return $this->db->insert_id();
    }

    public function sub_category_podcast($searchTerm="", $id_cat=""){
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'POD', 'keywords.keyword_parentid' => ','.$id_cat.','));
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], $cat);
        }
        return $data;
    }

    public function save_sub_category($data)
    {
        $this->db->insert('keywords', $data);
        return $this->db->insert_id();
    }

    public function save_podcast($id_cat, $podcast_name, $link_rss, $time, $by){
        // id doesn't exist
        $data = array(
            'podcast_name' => $podcast_name,
            'podcast_link_rss' => $link_rss,
            'visible' => 'N',
            'keyword_id' => $id_cat,
            'created_at' => $time,
            'created_by' => $by,
            'updated_at' => $time,
            'updated_by' => $by,
            'ctrloc' => '/podcast/podcast_v1/save_podcast'
        );
        $this->db->insert('podcast',$data);
        return $this->db->insert_id();
    }

    public function save_podcast_data($podcast_data){
        $data = array(
            'podcast_id' => $podcast_data['podcast_id'],
            'podcast_title' => $podcast_data['podcast_title'],
            'podcast_desc' => $podcast_data['podcast_desc'],
            'podcast_link' => $podcast_data['podcast_link'],
            'podcast_image' => $podcast_data['podcast_image'],
            'podcast_author' => $podcast_data['podacst_author'],
            'podcast_copyright' => $podcast_data['podcast_copyright'],
            'podcast_builddate' => $podcast_data['podcast_builddate'],
            'podcast_lang' => $podcast_data['podcast_language'],
            'created_at' => $podcast_data['created_at'],
            'updated_at' => $podcast_data['updated_at'],
            'ctrloc' => $podcast_data['ctrloc']
        );
        $this->db->insert('podcast_data',$data);
        return $this->db->insert_id();
    }

    public function save_podcast_episode($podcast_episode){
        // $this->db->insert_batch('podcast_episode',$podcast_episode);
        // return $this->db->insert_id();

        $this->db->trans_start();
        $_datas = array_chunk($podcast_episode, 100);
        foreach ($_datas as $key => $data) {
            $this->db->insert_batch('podcast_episode', $data);
        }
        $this->db->trans_complete();
    }

    public function get_category_id($podcast_id){
        $this->db->select('A.*');
        $this->db->from('podcast AS A');
        $this->db->where(array('A.podcast_id' => $podcast_id));
        $this->db->limit(10);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function pod_keyword(){
        $ids = array('POD');
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where(array('keyword_visible' => 'Y', 'keyword_parentid' => null));
        $this->db->where_in('keyword_ref', $ids );
        $this->db->order_by('keyword_id', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function pod_sub_keyword(){
        $ids = array('POD');
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where(array('keyword_visible' => 'Y', 'keyword_parentid !=' => null));
        $this->db->where_in('keyword_ref', $ids );
        $this->db->order_by('keyword_id', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function cat_content(){
        $query = $this->db->order_by('keyword_name', 'ASC')->get_where('keywords', array('keyword_visible' => 'Y', 'keyword_ref' => 'POD', 'keyword_parentid' => null));
        return $query;  
    }

    public function get_podcast_id($podcast_id){
        $this->db->select('A.*');
        $this->db->from('podcast AS A');
        $this->db->where(array('A.podcast_id' => $podcast_id));
        $query = $this->db->get()->result();
        return $query;
    }

    public function update_podcast($time, $by, $id_cat, $podcast_name, $link_rss, $podcast_id){
        $this->db->set('podcast_name', $podcast_name);
        $this->db->set('podcast_link_rss', $link_rss);
        $this->db->set('keyword_id', $id_cat);
        $this->db->set('updated_at', $time);
        $this->db->set('updated_by', $by);
        $this->db->set('ctrloc', '/podcast/podcast_v1/update_podcast');
        $this->db->where('podcast_id', $podcast_id);
        $this->db->update('podcast');
    }

    public function update_podcast_data($podcast_data){
        $this->db->set('podcast_title', $podcast_data['podcast_title']);
        $this->db->set('podcast_desc', $podcast_data['podcast_desc']);
        $this->db->set('podcast_link', $podcast_data['podcast_link']);
        $this->db->set('podcast_image', $podcast_data['podcast_image']);
        $this->db->set('podcast_author', $podcast_data['podacst_author']);
        $this->db->set('podcast_copyright', $podcast_data['podcast_copyright']);
        $this->db->set('podcast_builddate', $podcast_data['podcast_builddate']);
        $this->db->set('podcast_lang', $podcast_data['podcast_language']);
        $this->db->set('updated_at', $podcast_data['updated_at']);
        $this->db->set('ctrloc', $podcast_data['ctrloc']);
        $this->db->where('podcast_id', $podcast_data['podcast_id']);
        $this->db->update('podcast_data');
    }

    public function get_pod_data_id($podcast_id){
        $this->db->select('podcast_data_id');
        $this->db->from('podcast_data');
        $this->db->where(array('podcast_id' => $podcast_id));
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_eps_data($podcast_id){
        $this->db->select('A.*');
        $this->db->from('podcast_episode AS A');
        $this->db->where(array('A.podcast_data_id' => $podcast_id));
        // $this->db->order_by('podcast_episode_id', 'DESC');
        $query = $this->db->get()->result_array();
        // print_r($query);die();
        $_arr = array();
        if ($query!=null) {
            $i=0;
            foreach ($query as $key => $value) {
                $_arr[$i] = array(
                    'podcast_episode_id'=>$value['podcast_episode_id']
                );
                $i++;
            }
        }
        // print_r($_arr);die();
        return $_arr;
    }

    public function update_pod_eps($update_podcast_eps){
        $this->db->update_batch('podcast_episode', $update_podcast_eps, 'podcast_episode_id');
    }

    public function insert_pod_eps($insert_podcast_eps){
        $this->db->insert_batch('podcast_episode',$insert_podcast_eps);
        return $this->db->insert_id();
    }

    public function insert_batch_pod($podcast_batch){
        $this->db->insert_batch('podcast_episode',$podcast_batch);
        return $this->db->insert_id();
    }

    public function get_eps_pod($_idPodcast){
        $this->db->select('A.*');
        $this->db->from('podcast_episode AS A');
        $this->db->where(array('A.podcast_data_id' => $_idPodcast));
        $query = $this->db->get()->result_array();
        $_arr = array();
        if ($query!=null) {
            $i=0;
            foreach ($query as $key => $value) {
                $_arr[$i] = array(
                    'podcast_data_id'=>$value['podcast_data_id'],
                    'episode_title'=>$value['episode_title'],
                    'episode_desc'=>$value['episode_desc'],
                    'episode_pubdate'=>$value['episode_pubdate'],
                    'episode_enclosure_link'=>$value['episode_enclosure_link'],
                    'episode_length'=>$value['episode_length'],
                    'episode_image'=>$value['episode_image'],
                    'created_at'=>$value['created_at'],
                    'updated_at'=>$value['updated_at'],
                    'ctrloc'=>$value['ctrloc']
                );
                $i++;
            }
        }
        return $_arr;
    }

    public function insert_new_eps($result){
        $this->db->insert_batch('podcast_episode',$result);
        return $this->db->insert_id();
    }

    public function get_detail_podcast($id){
        $_arr = array();
        $this->db->select('A.*, B.podcast_image, C.podcast_id as id_pod_rec, C.start_periode, C.end_periode');
        $this->db->from('podcast AS A');
        $this->db->join('podcast_data AS B','B.podcast_id = A.podcast_id','Left');
        $this->db->join('podcast_recommendation AS C','C.podcast_id = A.podcast_id','Left');
        $this->db->where(array('A.podcast_id' => $id));
        $this->db->order_by('A.podcast_id', 'DESC');
        $query = $this->db->get()->result_array();
        if($query!=null){
            $i=0;
            foreach ($query as $key => $value) {
                $_categories = $this->getCategoryName(explode(',', trim($value['keyword_id'], ',')));
                $_arr[$i] = array(
                    'podcast_id'=>$value['podcast_id'],
                    'podcast_name'=>$value['podcast_name'],
                    'podcast_image'=>$value['podcast_image'],
                    'link_rss'=>$value['podcast_link_rss'],
                    'created_at'=>$value['created_at'],
                    'updated_at'=>$value['updated_at'],
                    'created_by'=>$value['created_by'],
                    'categories'=>implode(', ', $_categories),
                    'id_pod_rec'=>$value['id_pod_rec'],
                    'start_periode'=>$value['start_periode'],
                    'end_periode'=>$value['end_periode'],
                );
                $i++;
            }
            // print_r($_arr);die;
        }
        return $_arr;
    }

    public function activated($id)
    {
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $data = array(
            'podcast_id' => $id,     
            'visible' => 'Y',
            'ctrloc' => '/podcast/podcast_v1/activated',
            'updated_at' => $time
        );
        $this->db->where('podcast_id', $id);
        $this->db->update('podcast', $data);
        redirect(site_url('podcast/podcast_v1'));
    }

    public function inactivated($id)
    {
        date_default_timezone_set("Asia/Jakarta"); 
        $time = date('Y-m-d H:i:s');
        $data = array(
            'podcast_id'   => $id,     
            'visible' => 'N',
            'ctrloc' => '/podcast/podcast_v1/inactivated',
            'updated_at' => $time
        );
        $this->db->where('podcast_id', $id);
        $this->db->update('podcast', $data);
        redirect(site_url('podcast/podcast_v1'));
    }

}
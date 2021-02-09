<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Podcast_model_v2 extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
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
            podcast_name like '%".$searchValue."%' or 
            description like'%".$searchValue."%' ) ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->like('keyword_parent_id', ',435,');
        $this->db->where('visible', 'Y');
        $records = $this->db->get('tmp_podcast')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->like('keyword_parent_id', ',435,');
        $this->db->where('visible', 'Y');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $records = $this->db->get('tmp_podcast')->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('A.*, C.*');
        $this->db->from('tmp_podcast AS A');
        $this->db->join('poster AS C','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.podcast_id','Left');
        $this->db->like(array('C.poster_type' => 'podp_1280x720'));
        $this->db->where(array('A.visible' => 'Y'));
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result_array();

        $data = array();
        $i=0;
        foreach ($records as $key => $value) {
          if(stripos($value['keyword_parent_id'], ',435,') !== FALSE){
            $_categories = $this->getCategoryName(explode(',', trim($value['keyword_parent_id'], ',')));
            $data[$i] = array(
                'podcast_id'=>$value['podcast_id'],
                'podcast_name'=>$value['podcast_name'],
                'visible'=>$value['visible'],
                'categories'=>implode(', ', $_categories),
                'poster_url'=>$value['poster_url'],
            );
            $i++;
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
            podcast_name like '%".$searchValue."%' or 
            description like'%".$searchValue."%' ) ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->like('keyword_parent_id', ',435,');
        $this->db->where('visible', 'N');
        $records = $this->db->get('tmp_podcast')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->like('keyword_parent_id', ',435,');
        $this->db->where('visible', 'N');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $records = $this->db->get('tmp_podcast')->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('A.*, C.*');
        $this->db->from('tmp_podcast AS A');
        $this->db->join('poster AS C','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.podcast_id','Left');
        $this->db->like(array('C.poster_type' => 'podp_1280x720'));
        $this->db->where(array('A.visible' => 'N'));
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result_array();

        $data = array();
        $i=0;
        foreach ($records as $key => $value) {
          if(stripos($value['keyword_parent_id'], ',435,') !== FALSE){
            $_categories = $this->getCategoryName(explode(',', trim($value['keyword_parent_id'], ',')));
            $data[$i] = array(
                'podcast_id'=>$value['podcast_id'],
                'podcast_name'=>$value['podcast_name'],
                'visible'=>$value['visible'],
                'categories'=>implode(', ', $_categories),
                'poster_url'=>$value['poster_url'],
            );
            $i++;
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

    public function content_type($searchTerm=""){
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'POD'));
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], $cat);
        }
        return $data;
    }

    public function category_podcast($searchTerm=""){
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'POC'));
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], $cat);
        }
        return $data;
    }

    public function source_content($searchTerm=""){
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'SPD'));
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], $cat);
        }
        return $data;
    }

    public function save_keyword($data)
    {
        $this->db->insert('keywords', $data);
        return $this->db->insert_id();
    }

    public function save_podcast($id_cat, $source_content, $podcast_name, $podcast_description, $channel_id, $time, $by, $poster_content1, $poster_content2, $poster_content3){
        // id doesn't exist
        $data = array(
            'podcast_name' => $podcast_name,
            'description' => $podcast_description,
            'channel_id' => $channel_id,
            'source' => $source_content,
            'sortid' => '1',
            'visible' => 'Y',
            'keyword_parent_id' => $id_cat,
            'created_at' => $time,
            'created_by' => $by,
            'updated_at' => $time,
            'updated_by' => $by,
            'ctrloc' => '/podcast_v1/save_podcast'
        );
        $this->db->insert('tmp_podcast',$data);
        $id_podcast = $this->db->insert_id();

        $entries = [array(
            'poster_type' => 'podp_1280x720',
            'poster_url' => $poster_content1,
            'poster_visible' => 'Y',
            'product_id' => 'PODP_'.$id_podcast.'_1',
            'poster_update' => $time
        ),
        array(
            'poster_type' => 'podp_410x230',
            'poster_url' => $poster_content2,
            'poster_visible' => 'Y',
            'product_id' => 'PODP_'.$id_podcast.'_1',
            'poster_update' => $time
        ),
        array(
            'poster_type' => 'podp_235x132',
            'poster_url' => $poster_content3,
            'poster_visible' => 'Y',
            'product_id' => 'PODP_'.$id_podcast.'_1',
            'poster_update' => $time
        )];
        $this->db->insert_batch('poster',$entries);
        $id_poster = $this->db->insert_id();
        return array(
            'id_podcast' => $id_podcast,
            'id_poster' => $id_poster,
        );
    }

    public function get_image_by_id($podcast_id){
        $this->db->select('A.*, D.*');
        $this->db->from('tmp_podcast AS A');
        $this->db->join('poster AS D','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.podcast_id','Left');
        $this->db->like(array('D.product_id' => 'PODP_'));
        $this->db->where(array('D.poster_visible' => 'Y'));
        $this->db->where(array('A.podcast_id' => $podcast_id));
        $this->db->order_by('D.poster_id', 'ASC');
        $this->db->limit(10);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_soctv_by_id($podcast_id){
        $_arr = array();
        $this->db->select('A.*, D.*');
        $this->db->from('tmp_podcast AS A');
        $this->db->join('poster AS D','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.podcast_id','Left');
        $this->db->like(array('D.poster_type' => 'podp_1280x720'));
        $this->db->where(array('A.podcast_id' => $podcast_id));
        $this->db->order_by('A.podcast_id', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_keyword(){
        $query = $this->db->order_by('keyword_name', 'ASC')->get_where('keywords', array('keyword_visible' => 'Y', 'keyword_ref' => 'SPD'));
        return $query;  
    }

    public function cat_content(){
        $query = $this->db->order_by('keyword_name', 'ASC')->get_where('keywords', array('keyword_visible' => 'Y', 'keyword_ref' => 'POD'));
        return $query;  
    }

    public function pod_keyword(){
        $ids = array('POC');
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where(array('keyword_visible' => 'Y'));
        $this->db->where_in('keyword_ref', $ids );
        $this->db->order_by('keyword_id', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function update_podcast($time, $by, $id_cat, $source_content, $podcast_name, $podcast_description, $channel_id, $poster_url1, $poster_url2, $poster_url3, $podcast_id, $poster_id1, $poster_id2, $poster_id3){
        $this->db->set('podcast_name', $podcast_name);
        $this->db->set('description', $podcast_description);
        $this->db->set('channel_id', $channel_id);
        $this->db->set('source', $source_content);
        $this->db->set('sortid', '1');
        $this->db->set('visible', 'Y');
        $this->db->set('keyword_parent_id', $id_cat);
        $this->db->set('updated_at', $time);
        $this->db->set('updated_by', $by);
        $this->db->set('ctrloc', '/podcast/podcast_v1');
        $this->db->where('podcast_id', $podcast_id);
        $this->db->update('tmp_podcast');

        $entries = [array(
            'poster_url' => $poster_url1,
            'poster_id' => $poster_id1,
            'poster_update' => $poster_update
        ),
        array(
            'poster_url' => $poster_url2,
            'poster_id' => $poster_id2,
            'poster_update' => $poster_update
        ),
        array(
            'poster_url' => $poster_url3,
            'poster_id' => $poster_id3,
            'poster_update' => $poster_update
        )];
        $this->db->update_batch('poster',$entries, 'poster_id');
    }

    public function getimage(){
        $data = $this->db->query("select poster_url from poster where poster_visible='Y' and `product_id` like 'PODP_%'");
        return $data->result_array();
    }

    public function get_detail_podcast($id){
        $_arr = array();
        $this->db->select('A.*, C.*');
        $this->db->from('tmp_podcast AS A');
        $this->db->join('poster AS C','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.podcast_id','Left');
        $this->db->like(array('C.poster_type' => 'podp_1280x720'));
        $this->db->where(array('A.podcast_id' => $id));
        $this->db->order_by('A.podcast_id', 'DESC');
        $query = $this->db->get()->result_array();
        if($query!=null){
            $i=0;
            foreach ($query as $key => $value) {
                $_categories = $this->getCategoryName(explode(',', trim($value['keyword_parent_id'], ',')));
                $_source = $this->getCategoryName($value['source']);
                $_arr[$i] = array(
                    'podcast_id'=>$value['podcast_id'],
                    'podcast_name'=>$value['podcast_name'],
                    'podcast_description'=>$value['description'],
                    'created_at'=>$value['created_at'],
                    'updated_at'=>$value['updated_at'],
                    'created_by'=>$value['created_by'],
                    'categories'=>implode(', ', $_categories),
                    'source_content'=>$_source[0],
                    'poster_url'=>$value['poster_url'],
                );
                $i++;
            }
            // print_r($_arr);die;
        }
        return $_arr;
    }

    public function activated($id)
    {
        $data = array(
            'podcast_id' => $id,     
            'visible' => 'Y'
        );
        $this->db->where('podcast_id', $id);
        $this->db->update('tmp_podcast', $data);
        redirect(site_url('podcast/podcast_v2'));
    }

    public function inactivated($id)
    {
        $data = array(
            'podcast_id'   => $id,     
            'visible' => 'N'
        );
        $this->db->where('podcast_id', $id);
        $this->db->update('tmp_podcast', $data);
        redirect(site_url('podcast/podcast_v2'));
    }

}
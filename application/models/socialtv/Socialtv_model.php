<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Socialtv_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    function active_listdenslife($postData=null){
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
            $searchQuery = " (socialtv_id like '%".$searchValue."%' or 
            socialtv_name like '%".$searchValue."%' or 
            description like'%".$searchValue."%' ) ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->like('keyword_parent_id', ',246,');
        $this->db->where('visible', 'Y');
        $records = $this->db->get('tmp_socialtv')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->like('keyword_parent_id', ',246,');
        $this->db->where('visible', 'Y');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $records = $this->db->get('tmp_socialtv')->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('A.*, C.*');
        $this->db->from('tmp_socialtv AS A');
        $this->db->join('poster AS C','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.socialtv_id','Left');
        $this->db->like(array('C.poster_type' => 'scvp_1280x720'));
        $this->db->where(array('A.visible' => 'Y'));
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result_array();

        $data = array();
        $i=0;
        foreach ($records as $key => $value) {
          if(stripos($value['keyword_parent_id'], ',246,') !== FALSE){
            $_categories = $this->getCategoryName(explode(',', trim($value['keyword_parent_id'], ',')));
            $data[$i] = array(
                'socialtv_id'=>$value['socialtv_id'],
                'socialtv_name'=>$value['socialtv_name'],
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

    function active_listdensknowledge($postData=null){
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
            $searchQuery = " (socialtv_id like '%".$searchValue."%' or 
            socialtv_name like '%".$searchValue."%' or 
            description like'%".$searchValue."%' ) ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->like('keyword_parent_id', ',325,');
        $this->db->where('visible', 'Y');
        $records = $this->db->get('tmp_socialtv')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->like('keyword_parent_id', ',325,');
        $this->db->where('visible', 'Y');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $records = $this->db->get('tmp_socialtv')->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('A.*, C.*');
        $this->db->from('tmp_socialtv AS A');
        $this->db->join('poster AS C','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.socialtv_id','Left');
        $this->db->like(array('C.poster_type' => 'scvp_1280x720'));
        $this->db->where(array('A.visible' => 'Y'));
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result_array();
        krsort($records);
        // print_r($records);die();

        $data = array();
        $i=0;
        foreach ($records as $key => $value) {
            if(stripos($value['keyword_parent_id'], ',325,') !== FALSE){
                $_categories = $this->getCategoryName(explode(',', trim($value['keyword_parent_id'], ',')));
                $data[$i] = array(
                    'socialtv_id'=>$value['socialtv_id'],
                    'socialtv_name'=>$value['socialtv_name'],
                    'visible'=>$value['visible'],
                    'categories'=>implode(', ', $_categories),
                    'poster_url'=>$value['poster_url'],
                );
                $i++;
            }
        }
        // print_r($data);die();

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );
        return $response; 
    }

    function inactive_listdenslife($postData=null){
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
            $searchQuery = " (socialtv_id like '%".$searchValue."%' or 
            socialtv_name like '%".$searchValue."%' or 
            description like'%".$searchValue."%' ) ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->like('keyword_parent_id', ',246,');
        $this->db->where('visible', 'N');
        $records = $this->db->get('tmp_socialtv')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->like('keyword_parent_id', ',246,');
        $this->db->where('visible', 'N');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $records = $this->db->get('tmp_socialtv')->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('A.*, C.*');
        $this->db->from('tmp_socialtv AS A');
        $this->db->join('poster AS C','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.socialtv_id','Left');
        $this->db->like(array('C.poster_type' => 'scvp_1280x720'));
        $this->db->where(array('A.visible' => 'N'));
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result_array();

        $data = array();
        $i=0;
        foreach ($records as $key => $value) {
          if(stripos($value['keyword_parent_id'], ',246,') !== FALSE){
            $_categories = $this->getCategoryName(explode(',', trim($value['keyword_parent_id'], ',')));
            $data[$i] = array(
                'socialtv_id'=>$value['socialtv_id'],
                'socialtv_name'=>$value['socialtv_name'],
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

    function inactive_listdensknowledge($postData=null){
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
            $searchQuery = " (socialtv_id like '%".$searchValue."%' or 
            socialtv_name like '%".$searchValue."%' or 
            description like'%".$searchValue."%' ) ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->like('keyword_parent_id', ',325,');
        $this->db->where('visible', 'N');
        $records = $this->db->get('tmp_socialtv')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->like('keyword_parent_id', ',325,');
        $this->db->where('visible', 'N');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $records = $this->db->get('tmp_socialtv')->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('A.*, C.*');
        $this->db->from('tmp_socialtv AS A');
        $this->db->join('poster AS C','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.socialtv_id','Left');
        $this->db->like(array('C.poster_type' => 'scvp_1280x720'));
        $this->db->where(array('A.visible' => 'N'));
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result_array();

        $data = array();
        $i=0;
        foreach ($records as $key => $value) {
          if(stripos($value['keyword_parent_id'], ',325,') !== FALSE){
            $_categories = $this->getCategoryName(explode(',', trim($value['keyword_parent_id'], ',')));
            $data[$i] = array(
                'socialtv_id'=>$value['socialtv_id'],
                'socialtv_name'=>$value['socialtv_name'],
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

    public function get_socialtvactive(){
        $_arr = array();
        $this->db->select('A.*, C.*');
        $this->db->from('tmp_socialtv AS A');
        $this->db->join('poster AS C','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.socialtv_id','Left');
        $this->db->like(array('C.poster_type' => 'scvp_1280x720'));
        $this->db->where(array('A.visible' => 'Y'));
        $this->db->order_by('A.socialtv_id', 'ASC');
        $query = $this->db->get()->result_array();
        if($query!=null){
            $i=0;
            foreach ($query as $key => $value) {
                $_categories = $this->getCategoryName(explode(',', trim($value['keyword_parent_id'], ',')));
                $_arr[$i] = array(
                    'socialtv_id'=>$value['socialtv_id'],
                    'socialtv_name'=>$value['socialtv_name'],
                    'visible'=>$value['visible'],
                    'categories'=>implode(', ', $_categories),
                    'poster_url'=>$value['poster_url'],
                );
                $i++;
            }
            // print_r($_arr);die;
        }
        return $_arr;
    }

    public function get_socialtvinactive(){
        $_arr = array();
        $this->db->select('A.*, C.*');
        $this->db->from('tmp_socialtv AS A');
        $this->db->join('poster AS C','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.socialtv_id','Left');
        $this->db->like(array('C.poster_type' => 'scvp_1280x720'));
        $this->db->where(array('A.visible' => 'N'));
        $this->db->order_by('A.socialtv_id', 'ASC');
        $query = $this->db->get()->result_array();
        if($query!=null){
            $i=0;
            foreach ($query as $key => $value) {
                $_categories = $this->getCategoryName(explode(',', trim($value['keyword_parent_id'], ',')));
                $_arr[$i] = array(
                    'socialtv_id'=>$value['socialtv_id'],
                    'socialtv_name'=>$value['socialtv_name'],
                    'visible'=>$value['visible'],
                    'categories'=>implode(', ', $_categories),
                    'poster_url'=>$value['poster_url'],
                );
                $i++;
            }
            // print_r($_arr);die;
        }
        return $_arr;
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
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'CYC'));
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], $cat);
        }
        return $data;
    }

    public function category_densplay($searchTerm=""){
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'SCV'));
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], $cat);
        }
        return $data;
    }

    public function category_denslife($searchTerm=""){
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'SDL'));
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], $cat);
        }
        return $data;
    }

    public function category_knowledge($searchTerm=""){
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'SDK'));
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
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'SSC'));
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

    public function save_socialtv($id_cat, $source_content, $socialtv_name, $socialtv_description, $channel_id, $time, $by, $poster_content1, $poster_content2, $poster_content3){
        // id doesn't exist
        $data = array(
            'socialtv_name' => $socialtv_name,
            'description' => $socialtv_description,
            'channel_id' => $channel_id,
            'source' => $source_content,
            'sortid' => '1',
            'visible' => 'Y',
            'keyword_parent_id' => $id_cat,
            'created_at' => $time,
            'created_by' => $by,
            'updated_at' => $time,
            'updated_by' => $by,
            'ctrloc' => '/socialtv/save_socialtv'
        );
        $this->db->insert('tmp_socialtv',$data);
        $id_socialtv = $this->db->insert_id();

        $entries = [array(
            'poster_type' => 'scvp_1280x720',
            'poster_url' => $poster_content1,
            'poster_visible' => 'Y',
            'product_id' => 'SCVP_'.$id_socialtv.'_1',
            'poster_update' => $time
        ),
        array(
            'poster_type' => 'scvp_410x230',
            'poster_url' => $poster_content2,
            'poster_visible' => 'Y',
            'product_id' => 'SCVP_'.$id_socialtv.'_1',
            'poster_update' => $time
        ),
        array(
            'poster_type' => 'scvp_235x132',
            'poster_url' => $poster_content3,
            'poster_visible' => 'Y',
            'product_id' => 'SCVP_'.$id_socialtv.'_1',
            'poster_update' => $time
        )];
        $this->db->insert_batch('poster',$entries);
        $id_poster = $this->db->insert_id();
        return array(
            'id_socialtv' => $id_socialtv,
            'id_poster' => $id_poster,
        );
    }

    public function get_image_by_id($socialtv_id){
        $this->db->select('A.*, D.*');
        $this->db->from('tmp_socialtv AS A');
        $this->db->join('poster AS D','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.socialtv_id','Left');
        $this->db->like(array('D.product_id' => 'SCVP_'));
        $this->db->where(array('D.poster_visible' => 'Y'));
        $this->db->where(array('A.socialtv_id' => $socialtv_id));
        $this->db->order_by('D.poster_id', 'ASC');
        $this->db->limit(10);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_soctv_by_id($socialtv_id){
        $_arr = array();
        $this->db->select('A.*, D.*');
        $this->db->from('tmp_socialtv AS A');
        $this->db->join('poster AS D','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.socialtv_id','Left');
        $this->db->like(array('D.poster_type' => 'scvp_1280x720'));
        $this->db->where(array('A.socialtv_id' => $socialtv_id));
        $this->db->order_by('A.socialtv_id', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_keyword(){
        $query = $this->db->order_by('keyword_name', 'ASC')->get_where('keywords', array('keyword_visible' => 'Y', 'keyword_ref' => 'SSC'));
        return $query;  
    }

    public function cat_content(){
        $query = $this->db->order_by('keyword_name', 'ASC')->get_where('keywords', array('keyword_visible' => 'Y', 'keyword_ref' => 'CYC'));
        return $query;  
    }

    public function soc_keyword(){
        $ids = array('SCV', 'SDL', 'SDK');
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->where(array('keyword_visible' => 'Y'));
        $this->db->where_in('keyword_ref', $ids );
        $this->db->order_by('keyword_id', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function update_socialtv($time, $by, $id_cat, $source_content, $socialtv_name, $socialtv_description, $channel_id, $poster_url1, $poster_url2, $poster_url3, $socialtv_id, $poster_id1, $poster_id2, $poster_id3){
        $this->db->set('socialtv_name', $socialtv_name);
        $this->db->set('description', $socialtv_description);
        $this->db->set('channel_id', $channel_id);
        $this->db->set('source', $source_content);
        $this->db->set('sortid', '1');
        $this->db->set('visible', 'Y');
        $this->db->set('keyword_parent_id', $id_cat);
        $this->db->set('updated_at', $time);
        $this->db->set('updated_by', $by);
        $this->db->set('ctrloc', '/socialtv/update_socialtv');
        $this->db->where('socialtv_id', $socialtv_id);
        $this->db->update('tmp_socialtv');

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
        $data = $this->db->query("select poster_url from poster where poster_visible='Y' and `product_id` like 'SCVP_%'");
        return $data->result_array();
    }

    public function get_detail_socialtv($id){
        $_arr = array();
        $this->db->select('A.*, C.*');
        $this->db->from('tmp_socialtv AS A');
        $this->db->join('poster AS C','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.socialtv_id','Left');
        $this->db->like(array('C.poster_type' => 'scvp_1280x720'));
        $this->db->where(array('A.socialtv_id' => $id));
        $this->db->order_by('A.socialtv_id', 'DESC');
        $query = $this->db->get()->result_array();
        if($query!=null){
            $i=0;
            foreach ($query as $key => $value) {
                $_categories = $this->getCategoryName(explode(',', trim($value['keyword_parent_id'], ',')));
                $_source = $this->getCategoryName($value['source']);
                $_arr[$i] = array(
                    'socialtv_id'=>$value['socialtv_id'],
                    'socialtv_name'=>$value['socialtv_name'],
                    'socialtv_description'=>$value['description'],
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
            'socialtv_id' => $id,     
            'visible' => 'Y'
        );
        $this->db->where('socialtv_id', $id);
        $this->db->update('tmp_socialtv', $data);
        redirect(site_url('socialtv/socialtv'));
    }

    public function inactivated($id)
    {
        $data = array(
            'socialtv_id'   => $id,     
            'visible' => 'N'
        );
        $this->db->where('socialtv_id', $id);
        $this->db->update('tmp_socialtv', $data);
        redirect(site_url('socialtv/socialtv'));
    }

}
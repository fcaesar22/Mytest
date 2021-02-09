<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mngcat_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function type_category($searchTerm=""){
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'CYC'));
        $fetched_records = $this->db->get();
        $query = $fetched_records->result_array();
        $pod = array(array(
            'keyword_id' => 'POD',
            'keyword_name' => 'Podcast',
            'keyword_sort' => '2',
            'keyword_child' => 'SIN',
            'keyword_sub' => 'N',
            'keyword_ref' => 'POD',
            'keyword_visible' => 'Y',
            'keyword_parentid' => null,
            'icon' => null,
            )
        );
        $category = array_merge($query,$pod);

        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], $cat);   
        }
        return $data;
    }

    // Get DataTable data
    function active_category($postData=null){
        $response = array();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        // Custom search filter 
        $searchRefActive = $postData['searchRefActive'];
        $searchNameActive = $postData['searchNameActive'];

        ## Search 
        $search_arr = array();
        $searchQuery = "";
        if($searchValue != ''){
          $search_arr[] = " (keyword_name like '%".$searchValue."%') ";
        }
        if($searchRefActive != ''){
          $search_arr[] = " (keyword_parentid like '%".$searchRefActive."%' or 
          keyword_ref like'%".$searchRefActive."%') ";
        }
        if($searchNameActive != ''){
          $search_arr[] = " keyword_name like '%".$searchNameActive."%' ";
        }
        if(count($search_arr) > 0){
          $searchQuery = implode(" and ",$search_arr);
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->where_in('keyword_ref', ['ARC','SDK','SDL','POD']);
        $this->db->where('keyword_visible', 'Y');
        $records = $this->db->get('keywords')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->where_in('keyword_ref', ['ARC','SDK','SDL','POD']);
        $this->db->where('keyword_visible', 'Y');
        $records = $this->db->get('keywords')->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('*');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->where_in('keyword_ref', ['ARC','SDK','SDL','POD']);
        $this->db->where('keyword_visible', 'Y');
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('keywords')->result();

        $data = array();
        foreach($records as $record ){
            $data[] = array( 
                "keyword_id"=>$record->keyword_id,
                "keyword_name"=>$record->keyword_name,
                "keyword_ref"=>$record->keyword_ref,
                "keyword_parentid"=>$record->keyword_parentid,
                "keyword_visible"=>$record->keyword_visible
            );
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

    // Get DataTable data
    function inactive_category($postData=null){
        $response = array();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        // Custom search filter 
        $searchRefInactive = $postData['searchRefInactive'];
        $searchNameInactive = $postData['searchNameInactive'];

        ## Search 
        $search_arr = array();
        $searchQuery = "";
        if($searchValue != ''){
          $search_arr[] = " (keyword_name like '%".$searchValue."%') ";
        }
        if($searchRefInactive != ''){
          $search_arr[] = " (keyword_parentid like '%".$searchRefInactive."%' or 
          keyword_ref like'%".$searchRefInactive."%') ";
        }
        if($searchNameInactive != ''){
          $search_arr[] = " keyword_name like '%".$searchNameInactive."%' ";
        }
        if(count($search_arr) > 0){
          $searchQuery = implode(" and ",$search_arr);
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->where_in('keyword_ref', ['ARC','SDK','SDL','POD']);
        $this->db->where('keyword_visible', 'N');
        $records = $this->db->get('keywords')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->where_in('keyword_ref', ['ARC','SDK','SDL','POD']);
        $this->db->where('keyword_visible', 'N');
        $records = $this->db->get('keywords')->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('*');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->where_in('keyword_ref', ['ARC','SDK','SDL','POD']);
        $this->db->where('keyword_visible', 'N');
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('keywords')->result();

        $data = array();
        foreach($records as $record ){
            $data[] = array( 
                "keyword_id"=>$record->keyword_id,
                "keyword_name"=>$record->keyword_name,
                "keyword_ref"=>$record->keyword_ref,
                "keyword_parentid"=>$record->keyword_parentid,
                "keyword_visible"=>$record->keyword_visible
            );
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

    public function activated($keyword_id)
    {
        $data = array(
            'keyword_id' => $keyword_id,     
            'keyword_visible' => $keyword_visible='Y'
        );
        $this->db->where('keyword_id', $keyword_id);
        $this->db->update('keywords', $data);
        redirect(site_url('mng_category/mng_category'));
    }

    public function inactivated($keyword_id)
    {
        $data = array(
            'keyword_id'   => $keyword_id,     
            'keyword_visible' => $keyword_visible='N'
        );
        $this->db->where('keyword_id', $keyword_id);
        $this->db->update('keywords', $data);
        redirect(site_url('mng_category/mng_category'));
    }

    public function get_product_by_id($keyword_id){
        $query = $this->db->get_where('keywords', array('keyword_id' =>  $keyword_id));
        return $query;
    }

    public function update_product($keyword_id,$keyword_name){
        $this->db->set('keyword_name', $keyword_name);
        $this->db->where('keyword_id', $keyword_id);
        $this->db->update('keywords');
    }

    public function update_product_pod($keyword_id,$keyword_name,$keyword_icon){
        $this->db->set('keyword_name', $keyword_name);
        $this->db->set('icon', $keyword_icon);
        $this->db->where('keyword_id', $keyword_id);
        $this->db->update('keywords');
    }
}
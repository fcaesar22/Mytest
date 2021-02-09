<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Denslife_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function testing(){
        //cara awal
        // $sql = $this->db->query('SELECT * from `article` WHERE active="Y" AND kategori_id rlike "^'.implode('|', $New_Array).'$" ORDER BY `article_id` DESC');
        // $art = $sql->result_array();
        //
        //denslife
        // $data = $this->db->query("select keyword_id from keywords where keyword_parentid=',246,' and keyword_visible='Y'");
        // $query = $data->result_array();
        // $New_Array = array();
        // foreach ($query as $key => $value) {
        //     $New_Array[] = ','.$value["keyword_id"].',';
        // }
        // $this->db->select('*');
        // $this->db->from('article');
        // foreach($New_Array as $key => $value) {
        //     if($key == 0) {
        //         $this->db->like('kategori_id', $value);
        //     } else {
        //         $this->db->or_like('kategori_id', $value);
        //     }
        // }
        // $this->db->order_by('article_id', 'DESC');
        // $art = $this->db->get()->result_array();
        // print_r($art);die();
        //
        //densknowledge
        $data = $this->db->query("select keyword_id from keywords where keyword_parentid=',325,' and keyword_visible='Y'");
        $query = $data->result_array();
        $New_Array = array();
        foreach ($query as $key => $value) {
            $New_Array[] = ','.$value["keyword_id"].',';
        }
        // print_r($New_Array);die();
        $this->db->select('*');
        $this->db->from('article');
        foreach($New_Array as $key => $value) {
            if($key == 0) {
                $this->db->like('kategori_id', $value);
            } else {
                $this->db->or_like('kategori_id', $value);
            }
        }
        $this->db->order_by('article_id', 'DESC');
        $art = $this->db->get()->result_array();
        // print_r($art);die();
        //
        $_arr = array();
        if($art!=null){
            $i=0;
            foreach ($art as $key => $value) {
                $_categories = $this->getCategoryName(explode(',', trim($value['kategori_id'], ',')));
                $_arr[$i] = array(
                    'article_id'=>$value['article_id'],
                    'article_title'=>$value['article_title'],
                    'article_by'=>$value['article_by'],
                    'categories'=>implode(', ', $_categories),
                    'active'=>$value['active'],
                    'pdf_url'=>$value['pdf_url'],
                    'status_highlight'=>$value['status_highlight'],
                );
                $i++;
            }
            // print_r($_arr);die;
        }
        return $_arr;
    }

    public function active_listdenslife($postData=null){
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
          $searchQuery = " (article_id like '%".$searchValue."%' or 
                article_title like '%".$searchValue."%' or 
                kategori_id like '%".$searchValue."%' or 
                article_by like'%".$searchValue."%' ) ";
        }

        $New_Array = array();
        $data = $this->db->query("select keyword_id from keywords where keyword_parentid=',246,' and keyword_visible='Y'");
        $query = $data->result_array();
        foreach ($query as $key => $value) {
          $New_Array[] = ','.$value["keyword_id"].',';
        }

        ## Total number of records without filtering
        $total = $this->db->query('SELECT * from `article` WHERE active="Y" AND kategori_id rlike "^'.implode('|', $New_Array).'$" ORDER BY `article_id` DESC');
        $totalRecords = $total->num_rows();

        ## Total number of record with filtering
        $totals = $this->db->query('SELECT * from `article` WHERE active="Y" AND kategori_id rlike "^'.implode('|', $New_Array).'$" ORDER BY `article_id` DESC');
        $totalRecordwithFilter = $totals->num_rows();

        ## Fetch records
        $this->db->select('*');
        $this->db->from('article');
        $this->db->where('active', 'Y');
        $this->db->order_by('article_id', 'DESC');      
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result_array();

        $_arr = array();
        $i=0;
        foreach ($records as $key => $value) {
            $pattern = '/(' . implode('|', $New_Array) . ')/'; // $pattern = /(one|two|three)/
            $result = preg_match($pattern, $value['kategori_id']);
            if ($result==1) {
                $_categories = $this->getCategoryName(explode(',', trim($value['kategori_id'], ',')));
                $_arr[$i] = array(
                    'article_id'=>$value['article_id'],
                    'article_title'=>$value['article_title'],
                    'article_by'=>$value['article_by'],
                    'categories'=>implode(', ', $_categories),
                    'active'=>$value['active'],
                    'pdf_url'=>$value['pdf_url'],
                    'status_highlight'=>$value['status_highlight'],
                );
                $i++;
            }
        }

        ## Response
        $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $_arr
        );

        return $response; 
    }

    public function active_listnewdenslife($postData=null){
        $response = array();

        $New_Array = array();
        $data = $this->db->query("select keyword_id from keywords where keyword_parentid=',246,' and keyword_visible='Y'");
        $query = $data->result_array();
        foreach ($query as $key => $value) {
          $New_Array[] = ','.$value["keyword_id"].',';
        }

        ## Fetch records
        $this->db->select('*');
        $this->db->from('article');
        $this->db->where('active', 'Y');  
        $records = $this->db->get()->result_array();

        $_arr = array();
        $i=0;
        foreach ($records as $key => $value) {
            $pattern = '/(' . implode('|', $New_Array) . ')/'; // $pattern = /(one|two|three)/
            $result = preg_match($pattern, $value['kategori_id']);
            if ($result==1) {
                $_categories = $this->getCategoryName(explode(',', trim($value['kategori_id'], ',')));
                $_arr[$i] = array(
                    'article_id'=>$value['article_id'],
                    'article_title'=>$value['article_title'],
                    'article_by'=>$value['article_by'],
                    'categories'=>implode(', ', $_categories),
                    'active'=>$value['active'],
                    'pdf_url'=>$value['pdf_url'],
                    'status_highlight'=>$value['status_highlight'],
                );
                $i++;
            }
        }

        ## Response
        $response = array(
          "data" => $_arr
        );

        return $response; 
    }

    public function inactive_listdenslife($postData=null){
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
          $searchQuery = " (article_id like '%".$searchValue."%' or 
                article_title like '%".$searchValue."%' or 
                kategori_id like '%".$searchValue."%' or 
                article_by like'%".$searchValue."%' ) ";
        }

        $New_Array = array();
        $data = $this->db->query("select keyword_id from keywords where keyword_parentid=',246,' and keyword_visible='Y'");
        $query = $data->result_array();
        foreach ($query as $key => $value) {
          $New_Array[] = ','.$value["keyword_id"].',';
        }

        ## Total number of records without filtering
        $total = $this->db->query('SELECT * from `article` WHERE active="N" AND kategori_id rlike "^'.implode('|', $New_Array).'$" ORDER BY `article_id` DESC');
        $totalRecords = $total->num_rows();

        ## Total number of record with filtering
        $totals = $this->db->query('SELECT * from `article` WHERE active="N" AND kategori_id rlike "^'.implode('|', $New_Array).'$" ORDER BY `article_id` DESC');
        $totalRecordwithFilter = $totals->num_rows();

        ## Fetch records
        $this->db->select('*');
        $this->db->from('article');
        $this->db->where('active', 'N');
        $this->db->order_by('article_id', 'DESC');      
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result_array();

        $_arr = array();
        $i=0;
        foreach ($records as $key => $value) {
            $pattern = '/(' . implode('|', $New_Array) . ')/'; // $pattern = /(one|two|three)/
            $result = preg_match($pattern, $value['kategori_id']);
            if ($result==1) {
                $_categories = $this->getCategoryName(explode(',', trim($value['kategori_id'], ',')));
                $_arr[$i] = array(
                    'article_id'=>$value['article_id'],
                    'article_title'=>$value['article_title'],
                    'article_by'=>$value['article_by'],
                    'categories'=>implode(', ', $_categories),
                    'active'=>$value['active'],
                    'pdf_url'=>$value['pdf_url'],
                    'status_highlight'=>$value['status_highlight'],
                );
                $i++;
            }
        }
        // $testing = count($_arr);
        // print_r($testing);die();

        ## Response
        $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $_arr
        );

        return $response; 
    }

    public function active_listdensknowledge($postData=null){
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
          $searchQuery = " (article_id like '%".$searchValue."%' or 
                article_title like '%".$searchValue."%' or 
                kategori_id like '%".$searchValue."%' or 
                article_by like'%".$searchValue."%' ) ";
        }

        $New_Array = array();
        $data = $this->db->query("select keyword_id from keywords where keyword_parentid=',325,' and keyword_visible='Y'");
        $query = $data->result_array();
        foreach ($query as $key => $value) {
          $New_Array[] = ','.$value["keyword_id"].',';
        }

        ## Total number of records without filtering
        $total = $this->db->query('SELECT * from `article` WHERE active="Y" AND kategori_id rlike "^'.implode('|', $New_Array).'$" ORDER BY `article_id` DESC');
        $totalRecords = $total->num_rows();

        ## Total number of record with filtering
        $totals = $this->db->query('SELECT * from `article` WHERE active="Y" AND kategori_id rlike "^'.implode('|', $New_Array).'$" ORDER BY `article_id` DESC');
        $totalRecordwithFilter = $totals->num_rows();

        ## Fetch records
        $this->db->select('*');
        $this->db->from('article');
        $this->db->where('active', 'Y');
        $this->db->order_by('article_id', 'DESC');      
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result_array();

        $_arr = array();
        $i=0;
        foreach ($records as $key => $value) {
            $pattern = '/(' . implode('|', $New_Array) . ')/'; // $pattern = /(one|two|three)/
            $result = preg_match($pattern, $value['kategori_id']);
            if ($result==1) {
                $_categories = $this->getCategoryName(explode(',', trim($value['kategori_id'], ',')));
                $_arr[$i] = array(
                    'article_id'=>$value['article_id'],
                    'article_title'=>$value['article_title'],
                    'article_by'=>$value['article_by'],
                    'categories'=>implode(', ', $_categories),
                    'active'=>$value['active'],
                    'pdf_url'=>$value['pdf_url'],
                    'status_highlight'=>$value['status_highlight'],
                );
                $i++;
            }
        }

        ## Response
        $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $_arr
        );

        return $response; 
    }

    public function inactive_listdensknowledge($postData=null){
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
          $searchQuery = " (article_id like '%".$searchValue."%' or 
                article_title like '%".$searchValue."%' or 
                kategori_id like '%".$searchValue."%' or 
                article_by like'%".$searchValue."%' ) ";
        }

        $New_Array = array();
        $data = $this->db->query("select keyword_id from keywords where keyword_parentid=',325,' and keyword_visible='Y'");
        $query = $data->result_array();
        foreach ($query as $key => $value) {
          $New_Array[] = ','.$value["keyword_id"].',';
        }

        ## Total number of records without filtering
        $total = $this->db->query('SELECT * from `article` WHERE active="N" AND kategori_id rlike "^'.implode('|', $New_Array).'$" ORDER BY `article_id` DESC');
        $totalRecords = $total->num_rows();

        ## Total number of record with filtering
        $totals = $this->db->query('SELECT * from `article` WHERE active="N" AND kategori_id rlike "^'.implode('|', $New_Array).'$" ORDER BY `article_id` DESC');
        $totalRecordwithFilter = $totals->num_rows();

        ## Fetch records
        $this->db->select('*');
        $this->db->from('article');
        $this->db->where('active', 'N');
        $this->db->order_by('article_id', 'DESC');      
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result_array();

        $_arr = array();
        $i=0;
        foreach ($records as $key => $value) {
            $pattern = '/(' . implode('|', $New_Array) . ')/'; // $pattern = /(one|two|three)/
            $result = preg_match($pattern, $value['kategori_id']);
            if ($result==1) {
                $_categories = $this->getCategoryName(explode(',', trim($value['kategori_id'], ',')));
                $_arr[$i] = array(
                    'article_id'=>$value['article_id'],
                    'article_title'=>$value['article_title'],
                    'article_by'=>$value['article_by'],
                    'categories'=>implode(', ', $_categories),
                    'active'=>$value['active'],
                    'pdf_url'=>$value['pdf_url'],
                    'status_highlight'=>$value['status_highlight'],
                );
                $i++;
            }
        }

        ## Response
        $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $_arr
        );

        return $response; 
    }

    public function get_products1(){
        $_arr = array();
        $this->db->select('*');
        $this->db->from('article');
        $this->db->where('active', 'Y');
        $this->db->order_by('article_id', 'DESC');
        $query = $this->db->get()->result_array();
        if($query!=null){
            $i=0;
            foreach ($query as $key => $value) {
                $_categories = $this->getCategoryName(explode(',', trim($value['kategori_id'], ',')));
                $_arr[$i] = array(
                    'article_id'=>$value['article_id'],
                    'article_title'=>$value['article_title'],
                    'article_by'=>$value['article_by'],
                    'categories'=>implode(', ', $_categories),
                    'active'=>$value['active'],
                    'pdf_url'=>$value['pdf_url'],
                    'status_highlight'=>$value['status_highlight'],
                );
                $i++;
            }
            // print_r($_arr);die;
        }
        return $_arr;
    }

    public function get_products2(){
        $_arr = array();
        $this->db->select('*');
        $this->db->from('article');
        $this->db->where('active', 'N');
        $this->db->order_by('article_id', 'DESC');
        $query = $this->db->get()->result_array();
        if($query!=null){
            $i=0;
            foreach ($query as $key => $value) {
                $_categories = $this->getCategoryName(explode(',', trim($value['kategori_id'], ',')));
                $_arr[$i] = array(
                    'article_id'=>$value['article_id'],
                    'article_title'=>$value['article_title'],
                    'article_by'=>$value['article_by'],
                    'categories'=>implode(', ', $_categories),
                    'active'=>$value['active'],
                    'pdf_url'=>$value['pdf_url'],
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

    public function getimage(){
        // $data = $this->db->query("SELECT url FROM whatson_content where type = 'image' group by whatson_id  order by created_at desc");
        $data = $this->db->query("select poster_url from poster where poster_visible='Y'");
        return $data->result_array();
    }

    public function getimage_highlight(){
        // $data = $this->db->query("SELECT url FROM whatson_content where type = 'image' group by whatson_id  order by created_at desc");
        $data = $this->db->query("select poster_url from poster where poster_visible='Y' and `product_id` like 'CRP_%'");
        return $data->result_array();
    }
    
    public function get_keyword(){
        $query = $this->db->order_by('keyword_name', 'ASC')->get_where('keywords', array('keyword_visible' => 'Y', 'keyword_ref' => 'ARC'));
        return $query;  
    }

    //new
    public function category_densplay($searchTerm=""){
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'SCV'));
        $this->db->limit(10);
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], $cat);
        }
        return $data;
    }

    //new
    public function category_denslife($searchTerm=""){
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'ARC', 'keywords.keyword_parentid' => ',246,'));
        $this->db->order_by("keyword_id", "desc");
        $this->db->limit(10);
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], $cat);
        }
        return $data;
    }

    //new
    public function category_knowledge($searchTerm=""){
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'ARC', 'keywords.keyword_parentid' => ',325,'));
        $this->db->order_by("keyword_id", "desc");
        $this->db->limit(10);
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], $cat);
        }
        return $data;
    }

    public function get_tags(){
        $query = $this->db->order_by('keyword_id', 'desc')->get_where('keywords', array('keyword_visible' => 'Y', 'keyword_ref' => 'TDL'));
        return $query;  
    }

    //new
    public function tag_denslife($searchTerm=""){
        $this->db->select('*');
        $this->db->from('keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('keywords.keyword_visible' => 'Y', 'keywords.keyword_ref' => 'TDL'));
        $this->db->order_by("keyword_id", "desc");
        $this->db->limit(10);
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], $cat);
        }
        return $data;
    }

    public function get_child(){
        $this->db->distinct();
        $this->db->select('keyword_child'); 
        return $result = $this->db->get('keywords');  
    }

    public function get_products_by_id($id){
        $_arr = array();
        // $this->db->select('*');
        // $this->db->from('article');
        // // $this->db->where('active','Y');
        // $this->db->where(array('article.article_id' => $id));
        // $this->db->order_by('article_id', 'DESC');
        // $query = $this->db->get()->result_array();
        $this->db->select('article.*, poster.*');
        $this->db->from('article');
        $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = article.article_id','Left');
        $this->db->like(array('poster.poster_type' => 'ARP_1280x720'));
        $this->db->where(array('poster.poster_visible' => 'Y'));
        $this->db->where(array('article.article_id' => $id));
        $this->db->order_by('poster.poster_type', 'ASC');
        $query = $this->db->get()->result_array();
        if($query!=null){
            $i=0;
            foreach ($query as $key => $value) {
                $_categories = $this->getCategoryName(explode(',', trim($value['kategori_id'], ',')));
                $_tags = $this->getCategoryName(explode(',', trim($value['tags'], ',')));
                $_arr[$i] = array(
                    'article_id'=>$value['article_id'],
                    'article_title'=>$value['article_title'],
                    'article_by'=>$value['article_by'],
                    'article_summary'=>$value['article_summary'],
                    'article_content_1'=>$value['article_content_1'],
                    'article_content_2'=>$value['article_content_2'],
                    'url_google_maps'=>$value['url_google_maps'],
                    'categories'=>implode(', ', $_categories),
                    'tags'=>implode(', ', $_tags),
                    'pdf_url'=>$value['pdf_url'],
                    'poster_url'=>$value['poster_url'],
                );
                $i++;
            }
        }
        return $_arr;
    }

    public function get_image_by_id($id){
        $sql =' SELECT article.article_id, poster.* FROM article LEFT JOIN poster ON SUBSTRING_INDEX(SUBSTRING_INDEX(poster.product_id,"_",2),"_",-1) = article.article_id WHERE poster.poster_visible=? AND article.article_id=? AND poster.poster_type LIKE ?  ORDER BY poster.poster_id ASC ';
        $query = $this->db->query($sql, array('Y', $id, 'ARPC_1280x720'));
        $query = $query->result_array();
        return $query;
    }

    public function get_video_by_id($id){
        $sql =' SELECT article.article_id, poster.*, poster.product_id FROM article LEFT JOIN poster ON SUBSTRING_INDEX(SUBSTRING_INDEX(poster.product_id,"_",2),"_",-1) = article.article_id WHERE poster.poster_visible=? AND article.article_id=? AND poster.poster_type LIKE ?  ORDER BY poster.poster_id ASC ';
        $query = $this->db->query($sql, array('Y', $id, 'DLS_1280x720'));
        $query = $query->result_array();
        return $query;
    }

    public function get_product_by_id($article_id){
        $query = $this->db->get_where('article', array('article_id' =>  $article_id));
        return $query;
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

    public function getkeywords($searchTerm=""){
        $this->db->select('*');
        $this->db->where("keyword_name like '%".$searchTerm."%' ");
        $this->db->where(array('keywords.keyword_visible' => 'Y'));
        $this->db->where(array('keywords.keyword_ref' => 'ARC'));
        $fetched_records = $this->db->get('keywords');
        $users = $fetched_records->result_array();
        $data = array();
        foreach($users as $user){
            $data[] = array("id"=>$user['keyword_id'], "text"=>$user['keyword_name']);
        }
        return $data;
    }

    function gettags($searchTerm=""){
        $this->db->select('*');
        $this->db->where("keyword_name like '%".$searchTerm."%' ");
        $this->db->where(array('keywords.keyword_visible' => 'Y'));
        $this->db->where(array('keywords.keyword_ref' => 'TDL'));
        $fetched_records = $this->db->get('keywords');
        $users = $fetched_records->result_array();
        $data = array();
        foreach($users as $user){
            $data[] = array("id"=>$user['keyword_id'], "text"=>$user['keyword_name']);
        }
        return $data;
    }

    function save_product($article_title,$kategori_id,$article_by,$summary,$tags,$url_google_maps,$created_by,$updated_by){
        $data = array(
            'article_title' => $article_title,
            'kategori_id' => ','.$kategori_id.',',
            'article_by' => $article_by,
            'article_summary' => $summary,
            'tags' => ','.$tags.',',
            'url_google_maps' => $url_google_maps,
            'created_by' => $created_by,
            'updated_by' => $updated_by,
            'ctrloc' => 'denslife/save_product'
        );
        $this->db->insert('article',$data);
        return $this->db->insert_id();
    }

    function save_article($article_id,$article_content_1,$article_content_2){
        $this->db->set('article_content_1', $article_content_1);
        $this->db->set('article_content_2', $article_content_2);
        $this->db->where('article_id', $article_id);
        return $this->db->update('article');
    }

    public function save_keyword($data)
    {
        $this->db->insert('keywords', $data);
        return $this->db->insert_id();
    }

    public function save_tag($name_tag, $sort_tag, $child_tag, $sub_tag, $ref_tag, $visible_tag, $par_tag){ 
        $count = count($name_tag);
        // for($i = 0; $i<$count; $i++){
        //     $entries[] = array(
        //         'keyword_name'=>$data['jtag'][$i],
        //         'keyword_sort'=>$data['jsort'][$i],
        //         'keyword_child'=>$data['jchild'][$i],
        //         'keyword_sub'=>$data['jsub'][$i],
        //         'keyword_ref'=>$data['jref'][$i],
        //         'keyword_visible'=>$data['jvis'][$i],
        //         'keyword_parentid'=>$data['jpar'][$i],
        //     );
        // }
        for($i = 0; $i<$count; $i++){
            $entries[] = array(
                'keyword_name'=>$name_tag[$i],
                'keyword_sort'=>$sort_tag[$i],
                'keyword_child'=>$child_tag[$i],
                'keyword_sub'=>$sub_tag[$i],
                'keyword_ref'=>$ref_tag[$i],
                'keyword_visible'=>$visible_tag[$i],
                'keyword_parentid'=>$par_tag[$i],
            );
        }
        $this->db->insert_batch('keywords', $entries); 
        if($this->db->affected_rows() > 0)
            return 1;
        else
            return 0;
    }

    //new
    public function get_key($article_id){
        $this->db->select('kategori_id');
        $this->db->from('article');
        $this->db->where(array('article.article_id' => $article_id));
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['kategori_id']);
        }
        $datas = $data[0]['id'];
        $key = trim($datas, ',');
        $keyword = explode(',', $key);
        $keyword_id = implode( ", ", $keyword );
        // print_r($post);die();
        $data = $this->db->query("select * from keywords where keyword_visible='Y' and keyword_id in ($keyword_id)");
        $query = $data->result();
        return $query;
    }

    //new
    public function get_tg($article_id){
        $this->db->select('tags');
        $this->db->from('article');
        $this->db->where(array('article.article_id' => $article_id));
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['tags']);
        }
        $datas = $data[0]['id'];
        $key = trim($datas, ',');
        $keyword = explode(',', $key);
        $keyword_id = implode( ", ", $keyword );
        // print_r($post);die();
        $data = $this->db->query("select * from keywords where keyword_visible='Y' and keyword_id in ($keyword_id)");
        $query = $data->result();
        return $query;
    }

    public function update_product($article_id,$article_title,$kategori_id,$article_by,$summary,$tags,$url_google_maps,$created_by,$updated_by){
        $this->db->set('article_title', $article_title);
        $this->db->set('kategori_id', ','.$kategori_id.',');
        $this->db->set('article_by', $article_by);
        $this->db->set('article_summary', $summary);
        $this->db->set('tags', ','.$tags.',');
        $this->db->set('url_google_maps', $url_google_maps);
        $this->db->set('created_by', $created_by);
        $this->db->set('updated_by', $updated_by);
        $this->db->where('article_id', $article_id);
        $this->db->update('article');
    }

    public function update_article($article_id,$article_content_1,$article_content_2){
        $this->db->set('article_content_1', $article_content_1);
        $this->db->set('article_content_2', $article_content_2);
        $this->db->where('article_id', $article_id);
        $this->db->update('article');
    }

    public function get_article_by_id($id){
        $_arr = array();
        $this->db->select('*');
        $this->db->from('article');
        $this->db->where(array('article.active' => 'Y'));
        $this->db->where(array('article.article_id' => $id));
        $this->db->order_by('article_id', 'DESC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_poster_by_id($id){
        $this->db->select('article.article_id, poster.*');
        $this->db->from('article');
        $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = article.article_id','Left');
        $this->db->where(array('article.active' => 'Y'));
        $this->db->like(array('poster.poster_type' => '1280x720'));
        $this->db->where(array('poster.poster_visible' => 'Y'));
        $this->db->where(array('article.article_id' => $id));
        $this->db->order_by('poster.poster_type', 'ASC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function insert_pdf($data){
        $this->db->set('pdf_url', $data['pdf_url']);
        $this->db->where('article_id', $data['article_id']);
        $this->db->update('article');
    }

    public function activated($id)
    {
        $data = array(
            'article_id' => $id,     
            'active' => $active='Y'
        );
        $this->db->where('article_id', $id);
        $this->db->update('article', $data);
        redirect(site_url('denslife'));
    }

    public function inactivated($id)
    {
        $data = array(
            'article_id'   => $id,     
            'active' => $active='N'
        );
        $this->db->where('article_id', $id);
        $this->db->update('article', $data);
        redirect(site_url('denslife'));
    }

    public function delete($id){
        $data = array(
            'article_id'   => $id,     
            'active'       => $deleted='N'
        );
        $this->db->where('article_id', $id);
        $this->db->update('article', $data);
        redirect(site_url('denslife'));
    }

    public function insert_artposter($urlimage,$article_id){
        $data = array(
            'poster_type' => 'art_1280x720',
            'poster_url' => $urlimage,
            'poster_visible' => 'Y',
            'product_id' => 'ART_'.$article_id.'_1',
            'poster_update' => date("Y-m-d H:i:s")
        );
        $this->db->insert('poster',$data);
        return $this->db->insert_id();
    }

    public function get_poster_highlight($id){
        $this->db->select('article.article_id, article.article_title, poster.*');
        $this->db->from('article');
        $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = article.article_id','Left');
        $this->db->like(array('poster.poster_type' => 'arp_1280x720'));
        // $this->db->like(array('poster.poster_type' => '1280x720'));
        $this->db->where(array('poster.poster_visible' => 'Y'));
        $this->db->where(array('article.article_id' => $id));
        $this->db->order_by('poster.poster_id', 'ASC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function add_highlight($url_image1, $url_image2, $startdate, $enddate, $id_article, $highlight_update){
        $sql =' SELECT * FROM covers WHERE id_goto = ? ';
        $query = $this->db->query($sql, array($id_article));
        $count = $query->row_array();

        If($count!=0){
            // id exists
            $covers_id = $count['covers_id'];
            $this->db->set('start_date', $startdate);
            $this->db->set('end_date', $enddate);
            $this->db->set('updated_at', $highlight_update);
            $this->db->where('covers_id', $covers_id);
            $this->db->update('covers');

            $this->db->select('covers.covers_id, poster.*');
            $this->db->from('covers');
            $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = covers.covers_id','Left');
            $this->db->where(array('poster.poster_visible' => 'Y'));
            $this->db->where(array('covers.covers_id' => $covers_id));
            $this->db->order_by('poster.poster_id', 'ASC');
            $query = $this->db->get()->result_array();

            $poster_id1 = $query[0]['poster_id'];
            $poster_id2 = $query[1]['poster_id'];
            $poster_id3 = $query[2]['poster_id'];

            $entries = [array(
                'poster_url' => $url_image1,
                'poster_id' => $poster_id1,
                'poster_update' => $highlight_update
            ),
            array(
                'poster_url' => $url_image2,
                'poster_id' => $poster_id2,
                'poster_update' => $highlight_update
            ),
            array(
                'poster_url' => $url_image2,
                'poster_id' => $poster_id3,
                'poster_update' => $highlight_update
            )];
            $this->db->update_batch('poster',$entries, 'poster_id');
        } else {
            // id doesn't exist
            $sh = 'Y';
            $this->db->set('status_highlight', $sh);
            $this->db->set('updated_at', $highlight_update);
            $this->db->where('article_id', $id_article);
            $this->db->update('article');

            $data = array(
            'type_goto' => '38',
            'id_goto' => $id_article,
            'category_covers' => '246',
            'start_date' => $startdate,
            'end_date' => $enddate,
            'created_at' => $highlight_update,
            'updated_at' => $highlight_update
            );
            $this->db->insert('covers',$data);
            $id_covers = $this->db->insert_id();

            $entries = [array(
                'poster_type' => 'crp_1280x720',
                'poster_url' => $url_image1,
                'poster_visible' => 'Y',
                'product_id' => 'CRP_'.$id_covers.'_1',
                'poster_update' => $highlight_update
            ),
            array(
                'poster_type' => 'crp_410x230',
                'poster_url' => $url_image2,
                'poster_visible' => 'Y',
                'product_id' => 'CRP_'.$id_covers.'_1',
                'poster_update' => $highlight_update
            ),
            array(
                'poster_type' => 'crp_235x132',
                'poster_url' => $url_image2,
                'poster_visible' => 'Y',
                'product_id' => 'CRP_'.$id_covers.'_1',
                'poster_update' => $highlight_update
            )];
            $this->db->insert_batch('poster',$entries);
            $id_poster = $this->db->insert_id();
        }
        return array(
            'id_covers' => $id_covers,
            'id_poster' => $id_poster,
        );
    }

    public function set_highlight($_idHighlight){
        $test = $_idHighlight['id_poster']+1;
        $testing = $_idHighlight['id_poster']+2;
        $id_images = ','.$_idHighlight['id_poster'].','.$test.','.$testing.',';
        $this->db->set('images', $id_images);
        $this->db->where('covers_id', $_idHighlight['id_covers']);
        $this->db->update('covers');
    }

}
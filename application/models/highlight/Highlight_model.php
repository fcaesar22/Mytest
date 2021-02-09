<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Highlight_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function get_title($id_goto){
        $sql = 'SELECT movie_id AS id, movie_title AS title FROM movies WHERE movie_parentype="DPL" AND movie_visible="Y" UNION SELECT article_id AS id, article_title AS title FROM tmp_article WHERE active="Y" UNION SELECT seq AS id, title AS title FROM tv_channel WHERE visible="Y"';
        $query1 = $this->db->query($sql);
        $query1 = $query1->result_array();
        
        $this->db->select('whatson_id AS id, whatson_title AS title');
        $this->db->from('whatson');
        $this->db->where(array('whatson_purpose' => '1', 'deleted' => '0'));
        $query2 = $this->db->get()->result_array();

        $query = array_merge($query1,$query2);
        
        $data = array();
        foreach($query as $row)
        {
            if ($row['id']==$id_goto) {
                $data = $row;
            }
        }
        return $data;
    }

    public function get_highlight(){
        $this->db->select('A.*, B.keyword_name as cat_highlight, C.keyword_name as type_highlight, D.*');
        $this->db->from('covers AS A');
        $this->db->join('tmp_keywords AS B', 'A.category_covers = B.keyword_id', 'INNER');
        $this->db->join('tmp_keywords AS C', 'A.type_goto = C.keyword_id', 'INNER');
        $this->db->join('tmp_poster AS D','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.covers_id','Left');
        $this->db->like(array('D.poster_type' => 'crp_1280x720'));
        $this->db->order_by('A.covers_id', 'DESC');
        $query = $this->db->get()->result_array();
        $_arr = array();
        if($query!=null){
            $i=0;
            foreach ($query as $key => $value) {
                $_categories = $this->get_title($value['id_goto']);
                $_arr[$i] = array(
                    'covers_id'=>$value['covers_id'],
                    'id_goto'=>$_categories['id'],
                    'title_goto'=>$_categories['title'],
                    'poster_url'=>$value['poster_url'],
                    'category_covers'=>$value['cat_highlight'],
                    'type_highlight'=>$value['type_highlight'],
                    'start_date'=>$value['start_date'],
                    'end_date'=>$value['end_date'],
                );
                $i++;
            }
            // print_r($_arr);die;
        }
        return $_arr;
    }

    // ***
    public function type_category($searchTerm=""){
        $this->db->select('*');
        $this->db->from('tmp_keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('tmp_keywords.keyword_visible' => 'Y', 'tmp_keywords.keyword_ref' => 'CYC'));
        $fetched_records = $this->db->get();
        $query = $fetched_records->result_array();

        $data = array();
        foreach($query as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], $cat);   
        }
        return $data;
    }

    // ***
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
        if($searchRefActive != ''){
          $search_arr[] = " (A.category_covers like '%".$searchRefActive."%' ) ";
        }
        if($searchNameActive != ''){
          $search_arr[] = " (E.article_title like '%".$searchNameActive."%' OR
          F.movie_title like '%".$searchNameActive."%' OR
          G.title like '%".$searchNameActive."%') ";
        }
        if(count($search_arr) > 0){
          $searchQuery = implode(" and ",$search_arr);
        }

        ## Total number of records without filtering
        $this->db->select('A.*, B.keyword_name as cat_highlight, C.keyword_name as type_highlight, D.*');
        $this->db->from('covers AS A');
        $this->db->join('tmp_keywords AS B', 'A.category_covers = B.keyword_id', 'INNER');
        $this->db->join('tmp_keywords AS C', 'A.type_goto = C.keyword_id', 'INNER');
        $this->db->join('tmp_poster AS D','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.covers_id','Left');
        $this->db->like(array('D.poster_type' => 'crp_1280x720'));
        $this->db->order_by('A.covers_id', 'DESC');
        $records = $this->db->get();
        $result = $records->result_array();
        $totalRecords = count($result);

        ## Total number of record with filtering
        $this->db->select('A.*, B.keyword_name as cat_highlight, C.keyword_name as type_highlight, D.*');
        $this->db->from('covers AS A');
        $this->db->join('tmp_keywords AS B', 'A.category_covers = B.keyword_id', 'INNER');
        $this->db->join('tmp_keywords AS C', 'A.type_goto = C.keyword_id', 'INNER');
        $this->db->join('tmp_poster AS D','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.covers_id','Left');
        $this->db->like(array('D.poster_type' => 'crp_1280x720'));
        $this->db->order_by('A.covers_id', 'DESC');
        $records = $this->db->get();
        $result = $records->result_array();
        $totalRecordwithFilter = count($result);

        ## Fetch records
        $this->db->select('A.*, B.keyword_name as cat_highlight, C.keyword_name as type_highlight, D.*, E.article_title as article_highlight, F.movie_title as movie_highlight, G.title as tv_highlight, H.topic as webinar_highlight');
        $this->db->from('covers AS A');
        $this->db->join('tmp_keywords AS B', 'A.category_covers = B.keyword_id', 'INNER');
        $this->db->join('tmp_keywords AS C', 'A.type_goto = C.keyword_id', 'INNER');
        $this->db->join('tmp_poster AS D','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.covers_id','Left');
        $this->db->join('tmp_article AS E', 'A.id_goto = E.article_id', 'Left');
        $this->db->join('movies AS F', 'A.id_goto = F.movie_id', 'Left');
        $this->db->join('tv_channel AS G', 'A.id_goto = G.seq', 'Left');
        $this->db->join('tab_webinar AS H', 'A.id_goto = H.webinar_id', 'Left'); //baru
        $this->db->like(array('D.poster_type' => 'crp_1280x720'));
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $query = $this->db->get()->result_array();
        // print_r($query);die();

        $data = array();
        date_default_timezone_set("Asia/Jakarta"); 
        $date_now = date('Y-m-d');
        $i = 0;
        foreach ($query as $key => $value) {
            if ($value['article_highlight']!=null) {
                $title_highlight = $value['article_highlight'];
            }
            if ($value['movie_highlight']!=null) {
                $title_highlight = $value['movie_highlight'];
            }
            if ($value['tv_highlight']!=null) {
                $title_highlight = $value['tv_highlight'];
            }
            if ($value['webinar_highlight']!=null) {
                $title_highlight = $value['webinar_highlight'];
            }
            if ($date_now > $value['end_date']) {
                $status = 'FALSE';
            }else{
                $status = 'TRUE';
            }
            $data[$i] = array(
                'covers_id'=>$value['covers_id'],
                'id_goto'=>$title_highlight,
                'type_goto'=>$value['type_goto'],
                'poster_url'=>$value['poster_url'],
                'category_covers'=>$value['cat_highlight'],
                'type_highlight'=>$value['type_highlight'],
                'start_date'=>$value['start_date'],
                'end_date'=>$value['end_date'],
                'status'=>$status,
            );
            $i++;
        }

        // $data = array();
        // if($query!=null){
        //     $i=0;
        //     foreach ($query as $key => $value) {
        //         $_categories = $this->get_title($value['id_goto']);
        //         $data[$i] = array(
        //             'covers_id'=>$value['covers_id'],
        //             'id_goto'=>$_categories['id'],
        //             'title_goto'=>$_categories['title'],
        //             'poster_url'=>$value['poster_url'],
        //             'category_covers'=>$value['cat_highlight'],
        //             'type_highlight'=>$value['type_highlight'],
        //             'start_date'=>$value['start_date'],
        //             'end_date'=>$value['end_date'],
        //         );
        //         $i++;
        //     }
        // }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        return $response; 
    }

    public function getcategory($searchTerm=""){
        $this->db->select('*');
        $this->db->from('tmp_keywords');
        $this->db->like("keyword_name", $searchTerm);
        $this->db->where(array('tmp_keywords.keyword_visible' => 'Y', 'tmp_keywords.keyword_ref' => 'CYC'));
        $fetched_records = $this->db->get();
        $category = $fetched_records->result_array();
        $data = array();
        foreach($category as $cat){
            $data[] = array("id"=>$cat['keyword_id'], "text"=>$cat['keyword_name'], $cat);
        }
        return $data;
    }

    public function gettypedensplay($searchTerm=""){
        $this->db->select('*');
        $this->db->where("keyword_name like '%".$searchTerm."%' ");
        $this->db->where(array('tmp_keywords.keyword_visible' => 'Y', 'tmp_keywords.keyword_ref' => 'TYC'));
        $fetched_records = $this->db->get('tmp_keywords');
        $type = $fetched_records->result_array();
        $data = array();
        foreach($type as $types){
            $data[] = array("id"=>$types['keyword_id'], "text"=>$types['keyword_name'], $types);
        }
        return $data;
    }

    public function gettypedenslife($searchTerm=""){
        $this->db->select('*');
        $this->db->where("keyword_name like '%".$searchTerm."%' ");
        $this->db->where(array('tmp_keywords.keyword_visible' => 'Y', 'tmp_keywords.keyword_ref' => 'TYC'));
        $this->db->not_like(array('tmp_keywords.keyword_name' => 'Movie', 'tmp_keywords.keyword_name' => 'Webinar'));
        $fetched_records = $this->db->get('tmp_keywords');
        $type = $fetched_records->result_array();
        $data = array();
        foreach($type as $types){
            $data[] = array("id"=>$types['keyword_id'], "text"=>$types['keyword_name'], $types);
        }
        return $data;
    }

    public function getdenslife($searchTerm=""){
        $this->db->select('tmp_article.article_id, tmp_article.article_title, tmp_poster.*');
        $this->db->from('tmp_article');
        $this->db->where("tmp_article.article_title like '%".$searchTerm."%' ");
        $this->db->join('tmp_poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = tmp_article.article_id','Left');
        $this->db->like(array('tmp_poster.poster_type' => 'arp_1280x720'));
        $this->db->where(array('tmp_poster.poster_visible' => 'Y'));
        $this->db->order_by('tmp_poster.poster_id', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get()->result_array();
        $data = array();
        foreach($query as $content){
            $data[] = array("id"=>$content['article_id'], "text"=>$content['article_title'], $content);
        }
        return $data;
    }

    public function getlistdenslife($postData){
        $response = array();
        if($postData['denslife'] ){
            $this->db->select('tmp_article.article_id, tmp_article.article_title, tmp_poster.*');
            $this->db->from('tmp_article');
            $this->db->join('tmp_poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = tmp_article.article_id','Left');
            $this->db->like(array('tmp_poster.poster_type' => 'arp_1280x720'));
            $this->db->where('tmp_article.article_id', $postData['denslife']);
            $this->db->where(array('tmp_poster.poster_visible' => 'Y'));
            $this->db->order_by('tmp_poster.poster_id', 'DESC');
            $this->db->limit(10);
            $response = $this->db->get()->result_array();
        }
        return $response;
    }

    public function getdenslifechannel($searchTerm=""){
        $this->db->select('*');
        $this->db->from('tv_channel');
        $this->db->like(array('genrelist' => ',10,'));
        $this->db->where(array('visible' => 'Y'));
        $this->db->order_by('seq', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get()->result_array();
        $data = array();
        foreach($query as $content){
            $data[] = array("id"=>$content['seq'], "text"=>$content['title'], $content);
        }
        return $data;
    }

    public function getdensplay($searchTerm=""){
        $this->db->select('*');
        $this->db->from('whatson');
        $this->db->where("whatson_title like '%".$searchTerm."%' ");
        $this->db->where(array('deleted' => '0', 'whatson_purpose' => '1'));
        $this->db->order_by('whatson_id', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get()->result_array();
        $data = array();
        foreach($query as $content){
            $data[] = array("id"=>$content['whatson_id'], "text"=>$content['whatson_title'], $content);
        }
        return $data;
    }

    public function getlistdensplay($postData){
        $response = array();
        if($postData['whatson'] ){
            $this->db->select('*');
            $this->db->where('whatson_id', $postData['whatson']);
            $q = $this->db->get('whatson');
            $response = $q->result_array();
        }
        return $response;
    }

    public function getdensplaymovies($searchTerm=""){
        $this->db->select('movies.*, poster.*');
        $this->db->from('movies');
        $this->db->join('poster','product_id = movies.movie_code','Left');
        $this->db->like(array('poster.poster_type' => '1280x720'));
        $this->db->where(array('poster.poster_visible' => 'Y'));
        $this->db->order_by('poster.poster_id', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get()->result_array();
        $data = array();
        foreach($query as $content){
            $data[] = array("id"=>$content['movie_code'], "text"=>$content['movie_title'], $content);
        }
        return $data;
    }

    public function getdensplaychannel($searchTerm=""){
        $this->db->select('*');
        $this->db->from('tv_channel');
        $this->db->like(array('genrelist' => ',4,'));
        $this->db->where(array('visible' => 'Y'));
        $this->db->order_by('seq', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get()->result_array();
        $data = array();
        foreach($query as $content){
            $data[] = array("id"=>$content['seq'], "text"=>$content['title'], $content);
        }
        return $data;
    }

    //baru
    public function gettypewebinar($searchTerm=""){
        $this->db->select('*');
        $this->db->where("keyword_name like '%".$searchTerm."%' ");
        $this->db->where(array('tmp_keywords.keyword_visible' => 'Y', 'tmp_keywords.keyword_ref' => 'TYC', 'tmp_keywords.keyword_name' => 'Webinar'));
        $fetched_records = $this->db->get('tmp_keywords');
        $type = $fetched_records->result_array();
        $data = array();
        foreach($type as $types){
            $data[] = array("id"=>$types['keyword_id'], "text"=>$types['keyword_name'], $types);
        }
        return $data;
    }

    public function getwebinar($searchTerm=""){
        $this->db->select('tab_webinar.webinar_id, tab_webinar.topic, tmp_poster.*');
        $this->db->from('tab_webinar');
        $this->db->where("tab_webinar.topic like '%".$searchTerm."%' ");
        $this->db->join('tmp_poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = tab_webinar.webinar_id','Left');
        $this->db->like(array('tmp_poster.poster_type' => 'wbr_1280x720'));
        $this->db->where(array('tmp_poster.poster_visible' => 'Y'));
        $this->db->order_by('tmp_poster.poster_id', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get()->result_array();
        $data = array();
        foreach($query as $content){
            $data[] = array("id"=>$content['webinar_id'], "text"=>$content['topic'], $content);
        }
        return $data;
    }
    //baru

    public function getimage(){
        $data = $this->db->query("select poster_url from tmp_poster where poster_visible='Y' and `product_id` like 'CRP_%'");
        return $data->result_array();
    }

    public function save_highlight($category_highlight, $type_highlight, $id_content, $title_content, $poster_content1, $poster_content2, $poster_content3, $startdate_highlight, $enddate_highlight, $highlight_update){
        // id doesn't exist
        $data = array(
        'type_goto' => $type_highlight,
        'id_goto' => $id_content,
        'category_covers' => $category_highlight,
        'start_date' => $startdate_highlight,
        'end_date' => $enddate_highlight,
        'created_at' => $highlight_update,
        'updated_at' => $highlight_update
        );
        $this->db->insert('covers',$data);
        $id_covers = $this->db->insert_id();

        $entries = [array(
            'poster_type' => 'crp_1280x720',
            'poster_url' => $poster_content1,
            'poster_visible' => 'Y',
            'product_id' => 'CRP_'.$id_covers.'_1',
            'poster_update' => $highlight_update
        ),
        array(
            'poster_type' => 'crp_410x230',
            'poster_url' => $poster_content2,
            'poster_visible' => 'Y',
            'product_id' => 'CRP_'.$id_covers.'_1',
            'poster_update' => $highlight_update
        ),
        array(
            'poster_type' => 'crp_235x132',
            'poster_url' => $poster_content3,
            'poster_visible' => 'Y',
            'product_id' => 'CRP_'.$id_covers.'_1',
            'poster_update' => $highlight_update
        )];
        $this->db->insert_batch('tmp_poster',$entries);
        $id_poster = $this->db->insert_id();
        return array(
            'id_covers' => $id_covers,
            'id_poster' => $id_poster,
        );
    }

    public function set_highlight($_idHighlight){
        $id_image2 = $_idHighlight['id_poster']+1;
        $id_image3 = $_idHighlight['id_poster']+2;
        $id_images = ','.$_idHighlight['id_poster'].','.$id_image2.','.$id_image3.',';
        $this->db->set('images', $id_images);
        $this->db->where('covers_id', $_idHighlight['id_covers']);
        $this->db->update('covers');
    }

    public function get_image_by_id($id,$typegoto){
        $types=$typegoto;
        $this->db->select('A.*, B.keyword_name as cat_highlight, C.keyword_name as type_highlight, D.*, E.*');
        $this->db->from('covers AS A');
        $this->db->join('tmp_keywords AS B', 'A.category_covers = B.keyword_id', 'INNER');
        $this->db->join('tmp_keywords AS C', 'A.type_goto = C.keyword_id', 'INNER');
        if ($types==36) {
            $this->db->join('tv_channel AS E', 'A.id_goto = E.seq', 'INNER');
        }
        if ($types==37) {
            $this->db->join('movies AS E', 'A.id_goto = E.movie_id', 'INNER');
        }
        if ($types==38) {
            $this->db->join('tmp_article AS E', 'A.id_goto = E.article_id', 'INNER');
        }
        if ($types==109) {
            $this->db->join('tab_webinar AS E', 'A.id_goto = E.webinar_id', 'INNER');
        }
        $this->db->join('tmp_poster AS D','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.covers_id','Left');
        $this->db->like(array('D.product_id' => 'CRP_'));
        $this->db->where(array('D.poster_visible' => 'Y'));
        $this->db->where(array('A.covers_id' => $id));
        $this->db->order_by('D.poster_id', 'ASC');
        $this->db->limit(10);
        $query = $this->db->get()->result_array();
        // print_r($query);die();
        return $query;
    }

    public function union_content($id_content){
        $sql = 'SELECT whatson_id AS id, whatson_title AS title FROM whatson WHERE whatson_purpose="1" AND deleted="0" UNION SELECT movie_id AS id, movie_title AS title FROM movies WHERE movie_parentype="DPL" AND movie_visible="Y" UNION SELECT article_id AS id, article_title AS title FROM tmp_article WHERE active="Y" UNION SELECT seq AS id, title AS title FROM tv_channel WHERE visible="Y" UNION SELECT webinar_id AS id, topic AS title FROM tab_webinar WHERE is_visible="Y"';
        $query = $this->db->query($sql);
        $query = $query->result_array();
        $data = array();
        foreach($query as $row)
        {
            if ($row['id']==$id_content) {
                $data[$row['id']] = $row;
            }
        }
        return $data;
    }

    public function get_highlight_by_id($covers_id){
        $_arr = array();
        $this->db->select('A.*, B.keyword_name as cat_highlight, C.keyword_name as type_highlight, D.*');
        $this->db->from('covers AS A');
        $this->db->join('tmp_keywords AS B', 'A.category_covers = B.keyword_id', 'INNER');
        $this->db->join('tmp_keywords AS C', 'A.type_goto = C.keyword_id', 'INNER');
        $this->db->join('tmp_poster AS D','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.covers_id','Left');
        $this->db->like(array('D.poster_type' => 'crp_1280x720'));
        $this->db->where(array('A.covers_id' => $covers_id));
        $this->db->order_by('A.covers_id', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_poster_by_id($covers_id){
        $this->db->select('covers.covers_id, tmp_poster.*');
        $this->db->from('covers');
        $this->db->join('tmp_poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = covers.covers_id','Left');
        $this->db->like(array('tmp_poster.product_id' => 'CRP_'));
        $this->db->where(array('tmp_poster.poster_visible' => 'Y'));
        $this->db->where(array('covers.covers_id' => $covers_id));
        $this->db->order_by('tmp_poster.poster_id', 'ASC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function update_highlight($poster_url1,$poster_url2,$poster_url3,$highlight_id,$poster_id1,$poster_id2,$poster_id3,$startdate_highlight,$enddate_highlight,$poster_update){
        $this->db->set('start_date', $startdate_highlight);
        $this->db->set('end_date', $enddate_highlight);
        $this->db->set('updated_at', $poster_update);
        $this->db->where('covers_id', $highlight_id);
        $this->db->update('covers');

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
        $this->db->update_batch('tmp_poster',$entries, 'poster_id');
    }

    public function get_detail_highlights($id){
        $this->db->select('A.*, B.keyword_name as cat_highlight, C.keyword_name as type_highlight, D.*');
        $this->db->from('covers AS A');
        $this->db->join('tmp_keywords AS B', 'A.category_covers = B.keyword_id', 'INNER');
        $this->db->join('tmp_keywords AS C', 'A.type_goto = C.keyword_id', 'INNER');
        $this->db->join('tmp_poster AS D','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = A.covers_id','Left');
        $this->db->like(array('D.poster_type' => 'crp_1280x720'));
        $this->db->where(array('A.covers_id' => $id));
        $this->db->order_by('A.covers_id', 'DESC');
        $query = $this->db->get()->result_array();
        return $query;
    }

}
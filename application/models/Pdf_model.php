<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    public function get_keyword($id){
        // $test = $this->db->query("SELECT tmp_article.article_id, tmp_poster.* FROM tmp_article LEFT JOIN tmp_poster ON SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,'_',2),'_',-1) = tmp_article.article_id WHERE tmp_article.`active`='Y' AND tmp_poster.poster_type LIKE '%1280x720%' AND tmp_poster.poster_visible='Y' AND tmp_article.article_id=$id ORDER BY tmp_poster.poster_type ASC");
        // $data = $test->result_array();
        // return $data;

        $this->db->select('tmp_article.article_id, tmp_poster.*');
        $this->db->from('tmp_article');
        $this->db->join('tmp_poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = tmp_article.article_id','Left');
        $this->db->where(array('tmp_article.active' => 'Y'));
        $this->db->like(array('tmp_poster.poster_type' => '1280x720'));
        $this->db->where(array('tmp_poster.poster_visible' => 'Y'));
        $this->db->where(array('tmp_article.article_id' => $id));
        $this->db->order_by('tmp_poster.poster_type', 'ASC');
        $query = $this->db->get()->result_array();
        print_r($query);
        return $query;
    }

    public function get_article_by_id($id){
        $_arr = array();
        $this->db->select('*');
        $this->db->from('tmp_article');
        $this->db->where(array('tmp_article.active' => 'Y'));
        $this->db->where(array('tmp_article.article_id' => $id));
        $this->db->order_by('article_id', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_poster_by_id($id){
        $this->db->select('*');
        $this->db->from('view_article_content');
        $this->db->where(array('view_article_content.poster_visible' => 'Y'));
        $this->db->like(array('view_article_content.poster_type' => '1280x720'));
        $this->db->where(array('view_article_content.sptr' => $id));
        $this->db->order_by('poster_type', 'ASC');
        $query = $this->db->get()->result_array();
        // print_r($query);
        return $query;
    }

    function save_testarea($test){
        $data = array(
            'cityname' => $test 
        );
        $this->db->insert('city',$data);
        return $this->db->insert_id();
    }

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }
    
    function get_products(){
        $this->db->select('poster.*, article.article_title, poster_id');
        $this->db->from('poster');
        $this->db->join('article', 'poster.product_id = article.article_id');
        $this->db->order_by('poster.poster_id', 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function save_poster($poster_url1,$poster_url2,$poster_id,$poster_update){
        $entries = [array(
            'poster_type' => 'arp_1280x720',
            'poster_url' => $poster_url1,
            'poster_visible' => 'Y',
            'product_id' => 'ARP_'.$poster_id.'_1',
            'poster_update' => $poster_update
        ),
        array(
            'poster_type' => 'arp_410x230',
            'poster_url' => $poster_url2,
            'poster_visible' => 'Y',
            'product_id' => 'ARP_'.$poster_id.'_1',
            'poster_update' => $poster_update
        ),
        array(
            'poster_type' => 'arp_235x132',
            'poster_url' => $poster_url2,
            'poster_visible' => 'Y',
            'product_id' => 'ARP_'.$poster_id.'_1',
            'poster_update' => $poster_update
        )];
        $this->db->insert_batch('poster',$entries);
    }

    function update_poster($poster_url1,$poster_url2,$article_id,$poster_id1,$poster_id2,$poster_id3,$poster_update){
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
            'poster_url' => $poster_url2,
            'poster_id' => $poster_id3,
            'poster_update' => $poster_update
        )];
        $this->db->update_batch('poster',$entries, 'poster_id');
    }

    public function save_poster_new($poster_url1,$poster_url2,$article_id,$poster_update){
        $entries = [array(
            'poster_type' => 'arp_1280x720',
            'poster_url' => $poster_url1,
            'poster_visible' => 'Y',
            'product_id' => 'ARP_'.$article_id.'_1',
            'poster_update' => $poster_update
        ),
        array(
            'poster_type' => 'arp_410x230',
            'poster_url' => $poster_url2,
            'poster_visible' => 'Y',
            'product_id' => 'ARP_'.$article_id.'_1',
            'poster_update' => $poster_update
        ),
        array(
            'poster_type' => 'arp_235x132',
            'poster_url' => $poster_url2,
            'poster_visible' => 'Y',
            'product_id' => 'ARP_'.$article_id.'_1',
            'poster_update' => $poster_update
        )];
        $this->db->insert_batch('poster',$entries);
    }

    public function get_article_by_id($article_id){
        $_arr = array();
        $this->db->select('*');
        $this->db->from('article');
        $this->db->where(array('article.article_id' => $article_id));
        $this->db->order_by('article_id', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_poster_by_id($article_id){
        $this->db->select('article.article_id, poster.*');
        $this->db->from('article');
        $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = article.article_id','Left');
        $this->db->like(array('poster.product_id' => 'ARP_'));
        // $this->db->like(array('poster.poster_type' => '1280x720'));
        $this->db->where(array('poster.poster_visible' => 'Y'));
        $this->db->where(array('article.article_id' => $article_id));
        $this->db->order_by('poster.poster_id', 'ASC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function save_content($data){
        return $this->db->insert_batch('poster', $data);
    }

    public function save_video($data){
        return $this->db->insert_batch('poster', $data);
    }

    public function save_vid_pos($vidpos){
        return $this->db->insert_batch('streams', $vidpos);
    }

    public function get_image_by_id($article_id){
        // $this->db->select('article.article_id, poster.*');
        // $this->db->from('article');
        // $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = article.article_id','Left');
        // $this->db->where(array('article.active' => 'Y'));
        // $this->db->like(array('poster.product_id' => 'ARPC_' ));
        // $this->db->like(array('poster.poster_type' => '1280x720'));
        // $this->db->where(array('poster.poster_visible' => 'Y'));
        // $this->db->where(array('article.article_id' => $article_id));
        // $this->db->order_by('poster.poster_id', 'ASC');
        // $query = $this->db->get()->result_array();
        $sql =' SELECT article.article_id, poster.* FROM article LEFT JOIN poster ON SUBSTRING_INDEX(SUBSTRING_INDEX(poster.product_id,"_",2),"_",-1) = article.article_id WHERE poster.poster_visible=? AND article.article_id=? AND poster.product_id LIKE ?  ORDER BY poster.poster_id ASC ';
        $query = $this->db->query($sql, array('Y', $article_id, 'ARPC_%'));
        $query = $query->result_array();
        return $query;
    }

    public function get_video_by_id($article_id){
        // $this->db->select('article.article_id, poster.*');
        // $this->db->from('article');
        // $this->db->join('poster','SUBSTRING_INDEX(SUBSTRING_INDEX(product_id,"_",2),"_",-1) = article.article_id','Left');
        // $this->db->where(array('article.active' => 'Y'));
        // $this->db->like(array('poster.product_id' => 'ARPC_' ));
        // $this->db->like(array('poster.poster_type' => '1280x720'));
        // $this->db->where(array('poster.poster_visible' => 'Y'));
        // $this->db->where(array('article.article_id' => $article_id));
        // $this->db->order_by('poster.poster_id', 'ASC');
        $sql =' SELECT article.article_id, poster.*, poster.product_id as productid_poster, streams.* FROM article LEFT JOIN poster ON SUBSTRING_INDEX(SUBSTRING_INDEX(poster.product_id,"_",2),"_",-1) = article.article_id LEFT JOIN streams ON SUBSTRING_INDEX(SUBSTRING_INDEX(streams.product_id,"_",2),"_",-1) = article.article_id WHERE poster.poster_visible=? AND streams.stream_visible=? AND article.article_id=? AND poster.product_id LIKE ?  ORDER BY poster.poster_id ASC ';
        $query = $this->db->query($sql, array('Y', 'Y', $article_id, 'DLS_%'));
        $query = $query->result_array();
        // print_r($query);die;
        return $query;
    }

    public function update_content($data){
        return $this->db->update_batch('poster', $data, 'poster_id');
    }

    public function tambah_content($tambah){
        return $this->db->insert_batch('poster', $tambah);
    }

    public function update_video($data1){
        return $this->db->update_batch('poster', $data1, 'poster_id');
    }

    public function update_vid_pos($data2){
        return $this->db->update_batch('streams', $data2, 'stream_id');
    }

    public function tambah_poster($tambah_poster){
        return $this->db->insert_batch('poster', $tambah_poster);
    }

    public function tambah_video($tambah_video){
        return $this->db->insert_batch('streams', $tambah_video);
    }

    public function getimage(){
        // $data = $this->db->query("SELECT url FROM whatson_content where type = 'image' group by whatson_id  order by created_at desc");
        $data = $this->db->query("select poster_url from poster where poster_visible='Y'");
        return $data->result_array();
    }

    public function inactive_poster($id = NULL){
        $this->db->set('poster_visible', 'N');
        $this->db->where('poster_id', $id);
        $this->db->update("poster");
    }

    // public function delete($id)
    // {
    //     $this->db->where('whatson_content_id', $id);
    //     $this->db->delete('whatson_content');
    //     redirect(site_url('wo_content'));
    // }
    
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wocontent_model extends CI_Model{
    
    function get_products(){
        $this->db->select('whatson_content.*, whatson.whatson_title, whatson_content_id');
        $this->db->from('whatson_content');
        $this->db->join('whatson', 'whatson_content.whatson_id = whatson.whatson_id');
        $this->db->order_by('whatson_content.whatson_content_id', 'DESC');
        $query = $this->db->get();
        return $query;
    }

    function get_products_by_id($id){
        $this->db->select('whatson_content.*, whatson.whatson_title, whatson_content_id');
        $this->db->from('whatson_content');
        $this->db->join('whatson', 'whatson_content.whatson_id = whatson.whatson_id');
        $this->db->where(array('whatson_content.whatson_content_id' => $id));
        $this->db->order_by('whatson_content.whatson_content_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function batchInsert($data){
        $count = count($data['count']);
        for($i = 0; $i<$count; $i++){
            $entries[] = array(
                'whatson_id'=>$data['whatson_id'][$i],
                'type'=>$data['type'][$i],
                'url'=>$data['url'][$i],
                'created_at'=>$data['created_at'][$i],
                'created_by'=>$data['created_by'][$i],
                );
        }
        $this->db->insert_batch('whatson_content', $entries); 
        if($this->db->affected_rows() > 0)
            return 1;
        else
            return 0;
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
        $test = $this->db->query("SELECT `whatson_image` FROM whatson");
        $query2 = $test->result_array();
        // print_r($query2);die;
        return (array_merge($_arr,$query2));
    }

    function get_product_by_id($whatson_content_id){
        $query = $this->db->get_where('whatson_content', array('whatson_content_id' =>  $whatson_content_id));
        return $query;
    }

    function update_product($whatson_content_id,$whatson_id,$type,$url,$created_at,$created_by){
        $this->db->set('type', $type);
        $this->db->set('url', $url);
        $this->db->set('created_at', $created_at);
        $this->db->set('created_by', $created_by);
        $this->db->where('whatson_content_id', $whatson_content_id);
        $this->db->update('whatson_content');
    }

    public function delete($id)
    {
        $this->db->where('whatson_content_id', $id);
        $this->db->delete('whatson_content');
        redirect(site_url('wo_content'));
    }
    
}
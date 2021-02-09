<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cat_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }

    private $_table = "category_whatson";

    public $category_whatson_id;
    public $category_whatson_name;
    public $category_whatson_description;
    public $deleted = "0";

    public function rules()
    {
        return [
            ['field' => 'category_whatson_name',
            'label' => 'category_whatson_name',
            'rules' => 'required'],
            
            ['field' => 'category_whatson_description',
            'label' => 'category_whatson_description',
            'rules' => 'required']
        ];
    }


    public function getAll()
    {
        return $this->db->order_by('category_whatson_id', 'DESC')->get_where($this->_table, array('deleted' => '0'))->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["category_whatson_id" => $id])->row();
    }

    public function save()
    {
        $post = $this->input->post();
        // $this->category_whatson_id = uniqid();
        $this->category_whatson_name = $post["category_whatson_name"];
        $this->category_whatson_description = $post["category_whatson_description"];
        $this->db->insert($this->_table, $this);
    }

    public function update()
    {
        $post = $this->input->post();
        $this->category_whatson_id = $post["id"];
        $this->category_whatson_name = $post["category_whatson_name"];
        $this->category_whatson_description = $post["category_whatson_description"];        

        $this->db->update($this->_table, $this, array('category_whatson_id' => $post['id']));
    }

    public function delete($id)
    {
		$data = array(
            'category_whatson_id'   => $id,     
            'deleted'               => $deleted='1'
        );
        $this->db->where('category_whatson_id', $id);
        $this->db->update('category_whatson', $data);
        redirect(site_url('category_whatson/cat_wo'));
	}

}
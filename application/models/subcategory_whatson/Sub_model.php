<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }
    
    private $_table = "sub_category_whatson";

    public $sub_category_whatson_id;
    public $sub_category_whatson_name;
    public $sub_category_whatson_description;
    public $deleted = "0";

    public function rules()
    {
        return [
            ['field' => 'sub_category_whatson_name',
            'label' => 'sub_category_whatson_name',
            'rules' => 'required'],
            
            ['field' => 'sub_category_whatson_description',
            'label' => 'sub_category_whatson_description',
            'rules' => 'required']
        ];
    }

    public function getAll()
    {
        return $this->db->order_by('sub_category_whatson_id', 'DESC')->get_where($this->_table, array('deleted' => '0'))->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["sub_category_whatson_id" => $id])->row();
    }

    public function save()
    {
        $post = $this->input->post();
        // $this->sub_category_whatson_id = uniqid();
        $this->sub_category_whatson_name = $post["sub_category_whatson_name"];
        $this->sub_category_whatson_description = $post["sub_category_whatson_description"];
        $this->db->insert($this->_table, $this);
    }

    public function update()
    {
        $post = $this->input->post();
        $this->sub_category_whatson_id = $post["id"];
        $this->sub_category_whatson_name = $post["sub_category_whatson_name"];
        $this->sub_category_whatson_description = $post["sub_category_whatson_description"];        

        $this->db->update($this->_table, $this, array('sub_category_whatson_id' => $post['id']));
    }

    public function delete($id)
    {
		$data = array(
            'sub_category_whatson_id'   => $id,     
            'deleted'                   => $deleted='1'
        );
        $this->db->where('sub_category_whatson_id', $id);
        $this->db->update('sub_category_whatson', $data);
        redirect(site_url('subcategory_whatson/sub_wo'));
	}

}
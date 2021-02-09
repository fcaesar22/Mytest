<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chwo_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default',true);
    }
    
    private $_table = "channel_whatson";

    public $channel_whatson_id;
    public $channel_whatson_name;
    public $channel_whatson_description;
    public $channel_whatson_logo = "default.jpg";

    public function rules()
    {
        return [
            ['field' => 'channel_whatson_name',
            'label' => 'channel_whatson_name',
            'rules' => 'required'],
            
            ['field' => 'channel_whatson_description',
            'label' => 'channel_whatson_description',
            'rules' => 'required']
        ];
    }

    public function getAll()
    {
        return $this->db->order_by('channel_whatson_id', 'DESC')->get_where($this->_table, array('deleted' => '0'))->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["channel_whatson_id" => $id])->row();
    }

    public function getimage(){
        // $data = $this->db->query("SELECT url FROM whatson_content where type = 'image' group by whatson_id  order by created_at desc");
        $data = $this->db->query("select * from channel_whatson");
        return $data->result_array();
    }

    public function save()
    {
        $channel_whatson_name = $this->input->post('channel_whatson_name');
        $channel_whatson_description = $this->input->post('channel_whatson_description');
        $channel_whatson_logos = $this->input->post('channel_whatson_logo');
        $channel_whatson_logo = basename($channel_whatson_logos);
        $data = array(
            'channel_whatson_name' => $channel_whatson_name,
            'channel_whatson_description' => $channel_whatson_description,
            'channel_whatson_logo' => $channel_whatson_logo
        );
        $this->db->insert($this->_table, $data);

        $tw = array(
            'thumbnail_whatson_name' => $channel_whatson_name,
            'thumbnail_whatson_logo' => $channel_whatson_logo,
            'deleted' => '0'
        );
        $this->db->insert('thumbnail_whatson', $tw);
    }

    public function get_product_by_id($channel_whatson_id){
        $query = $this->db->get_where('channel_whatson', array('channel_whatson_id' =>  $channel_whatson_id));
        return $query;
    }

    public function update()
    {
        $channel_whatson_id = $this->input->post('channel_whatson_id');
        $channel_whatson_name = $this->input->post('channel_whatson_name');
        $channel_whatson_description = $this->input->post('channel_whatson_description');
        $channel_whatson_logos = $this->input->post('channel_whatson_logo');
        $channel_whatson_logo = "wp/".basename($channel_whatson_logos);
        $this->db->set('channel_whatson_name', $channel_whatson_name);
        $this->db->set('channel_whatson_description', $channel_whatson_description);
        $this->db->set('channel_whatson_logo', $channel_whatson_logo);
        $this->db->where('channel_whatson_id', $channel_whatson_id);
        $this->db->update('channel_whatson');

        $this->db->set('thumbnail_whatson_name', $channel_whatson_name);
        $this->db->set('thumbnail_whatson_logo', $channel_whatson_logo);
        $this->db->where('thumbnail_whatson_name', $channel_whatson_name);
        $this->db->update('thumbnail_whatson');        
    }

    public function delete($id)
    {
		$data = array(
            'channel_whatson_id'   => $id,     
            'deleted'               => $deleted='1'
        );
        $this->db->where('channel_whatson_id', $id);
        $this->db->update('channel_whatson', $data);
        redirect(site_url('channel_whatson/ch_wo'));
	}
	
	private function _uploadImage()
	{
		$config['upload_path']          = './media/img/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['overwrite']			= true;
		$config['max_size']             = 1024; // 1MB
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('channel_whatson_logo')) {
			return $this->upload->data("file_name");
		}
		
		return "default.jpg";
	}

	private function _deleteImage($id)
	{
		$product = $this->getById($id);
		if ($product->channel_whatson_logo != "default.jpg") {
			$filename = explode(".", $product->channel_whatson_logo)[0];
			return array_map('unlink', glob(FCPATH."media/img/$filename.*"));
		}
	}

}
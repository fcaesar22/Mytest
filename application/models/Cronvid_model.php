<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cronvid_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default', true);
    }

    private $_table = "tmp_cron_transcode";

    public function getMovie2Transcode()
    {
        return $this->db->get_where($this->_table, array(
            'status_transcode' => '0',
            'status_transfer' => '0',
        ))->result();
    }

    public function checkMovie2Transcode($condition)
    {
        $this->db->select('filename, status_transcode, filename_transcode, status_transfer');
        return $this->db->get_where($this->_table, $condition)->result();
    }

    public function getMovie2Transfer()
    {
        return $this->db->get_where($this->_table, array('status_transfer' => '0'))->result();
    }

    public function checkMovie2Transfer($condition)
    {
        $this->db->select('filename, status_transcode, filename_transcode, status_transfer');
        return $this->db->get_where($this->_table, $condition)->result();
	}

	public function getListMovie($keyword = null)
	{
		$this->db->select('filename, status_transcode, date_transcode, filename_transcode, status_transfer, date_transfer');
		$this->db->where('status_transcode', '1');
		$this->db->where('status_transfer', '1');

		if (!empty($keyword))
		{
			$this->db->like('filename_transcode', $keyword, 'both');
		}

		$query = $this->db->get($this->_table);

        return $query->result();
	}

    public function save($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    public function update($data, $condition = null)
    {
        return $this->db->update($this->_table, $data, $condition);
    }

}

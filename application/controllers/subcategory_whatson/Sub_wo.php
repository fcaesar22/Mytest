<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_wo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model("subcategory_whatson/sub_model");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["sub_wo"] = $this->sub_model->getAll();
        $this->template->load('template', 'subcategory/sub_view', $data);
    }

    public function add()
    {
        $sub_wo = $this->sub_model;
        $validation = $this->form_validation;
        $validation->set_rules($sub_wo->rules());

        if ($validation->run()) {
            $sub_wo->save();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
            redirect('subcategory_whatson/sub_wo');
        }

        $this->template->load('template', 'subcategory/new_form');
    }

    public function edit($id = null)
    {
        if (!isset($id)) redirect('subcategory_whatson/sub_wo');
       
        $sub_wo = $this->sub_model;
        $validation = $this->form_validation;
        $validation->set_rules($sub_wo->rules());

        if ($validation->run()) {
            $sub_wo->update();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
            redirect('subcategory_whatson/sub_wo');
        }

        $data["sub_wo"] = $sub_wo->getById($id);
        if (!$data["sub_wo"]) show_404();
        
        $this->template->load('template', 'subcategory/edit_form', $data);
    }

    public function detail($id = null)
    {
        if (!isset($id)) redirect('subcategory_whatson/sub_wo');
       
        $sub_wo = $this->sub_model;
        $validation = $this->form_validation;
        $validation->set_rules($sub_wo->rules());

        if ($validation->run()) {
            $sub_wo->update();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
            redirect('subcategory_whatson/sub_wo');
        }

        $data["sub_wo"] = $sub_wo->getById($id);
        if (!$data["sub_wo"]) show_404();
        
        $this->template->load('template', 'subcategory/sub_detail', $data);
    }

    public function delete($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->sub_model->delete($id)) {
            redirect(site_url('subcategory_whatson/sub_wo'));
        }
    }
}

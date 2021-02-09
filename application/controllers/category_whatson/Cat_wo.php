<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cat_wo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model("category_whatson/cat_model");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["cat_wo"] = $this->cat_model->getAll();
        $this->template->load('template', 'category/catwo_view', $data);
    }

    public function add()
    {
        $cat_wo = $this->cat_model;
        $validation = $this->form_validation;
        $validation->set_rules($cat_wo->rules());

        if ($validation->run()) {
            $cat_wo->save();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
            redirect('cat_wo');
        }

        $this->template->load('template', 'category/new_form');
    }

    public function edit($id = null)
    {
        if (!isset($id)) redirect('cat_wo');
       
        $cat_wo = $this->cat_model;
        $validation = $this->form_validation;
        $validation->set_rules($cat_wo->rules());

        if ($validation->run()) {
            $cat_wo->update();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
            redirect('category_whatson/cat_wo');
        }

        $data["cat_wo"] = $cat_wo->getById($id);
        if (!$data["cat_wo"]) show_404();
        
        $this->template->load('template', 'category/edit_form', $data);
    }

    public function detail($id = null)
    {
        if (!isset($id)) redirect('category_whatson/cat_wo');
       
        $cat_wo = $this->cat_model;
        $validation = $this->form_validation;
        $validation->set_rules($cat_wo->rules());

        if ($validation->run()) {
            $cat_wo->update();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
            redirect('category_whatson/cat_wo');
        }

        $data["cat_wo"] = $cat_wo->getById($id);
        if (!$data["cat_wo"]) show_404();
        
        $this->template->load('template', 'category/catwo_detail', $data);
    }

    public function delete($id)
    {
        if (!isset($id)) show_404();
        
        if ($this->cat_model->delete($id)) {
            redirect(site_url('category_whatson/cat_wo'));
        }
    }
}

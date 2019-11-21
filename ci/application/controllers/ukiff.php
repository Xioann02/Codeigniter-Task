<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class ukiff extends CI_Controller{

        public function __construct()
        {
            parent::__construct();
            $this->load->model('ukiff_model');
            $this->load->helper('url_helper');
            $this->load->helper('form');
            $this->load->library('form_validation');
        }

        public function index()
        {
            $this->load->model('ukiff_model');
            $this->load->view('addContent');
        }

        function searchNames() {
            $result = $this->ukiff_model->search($this->input->post('term'));
            echo json_encode($result);
        }

        public function ajaxRequestPost() {

            $rules = array(
                array(
                    'field' => 'name',
                    'label' => 'Name',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'Name is required.',
                    )
                ),
                array(
                    'field' => 'description',
                    'label' => 'Description',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'Description is required.',
                    )
                )
            );

            $this->form_validation->set_rules($rules);
            $time = date ("Y-m-d H:i:s", time());
            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'date_time' => $time
                );
                $this->ukiff_model->insert($data);

                redirect(base_url(''));
            } else {
                $this->load->model('ukiff_model');
                $this->load->view('addContent');
            }
        }
    }
?>
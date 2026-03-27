<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Welcome Controller — Trang chủ SPA
 * Chỉ load view, không query DB trực tiếp.
 * JavaScript sẽ fetch data từ /api/movies và /api/characters.
 */
class Welcome extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load helper 'url' để dùng base_url() trong view
        $this->load->helper('url');
        $this->load->model('Mcu_model');
    }

    public function index()
    {
        $data['phases'] = $this->Mcu_model->get_all_phases();
        $data['movies'] = $this->Mcu_model->get_all_movies();
        $this->load->view('main', $data);
    }
}

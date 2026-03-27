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
    }

    public function index()
    {
        $this->load->view('main');
    }
}

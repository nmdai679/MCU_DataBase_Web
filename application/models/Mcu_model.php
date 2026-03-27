<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Mcu_model
 * ─────────────────────────────────────────────────────────────
 * Model duy nhất cho toàn bộ dữ liệu MCU.
 * Load tự động trong controller bằng:   $this->load->model('Mcu_model');
 */
class Mcu_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // ──────────── MOVIES ─────────────────────────────────────

    /**
     * Lấy tất cả phim, JOIN với bảng phases để có thêm tên phase,
     * sắp xếp theo view_order (thứ tự xem theo timeline).
     */
    public function get_all_movies()
    {
        $this->db
            ->select('m.*, p.phase_num, p.ten_phase, p.saga')
            ->from('movies m')
            ->join('phases p', 'p.id = m.phase_id', 'left')
            ->order_by('m.view_order', 'ASC');

        return $this->db->get()->result_array();
    }

    /**
     * Lấy một phim theo slug (dùng cho modal).
     */
    public function get_movie_by_slug($slug)
    {
        $this->db
            ->select('m.*, p.phase_num, p.ten_phase, p.saga')
            ->from('movies m')
            ->join('phases p', 'p.id = m.phase_id', 'left')
            ->where('m.slug', $slug)
            ->limit(1);

        return $this->db->get()->row_array();
    }

    /**
     * Lấy movies theo phase_num.
     */
    public function get_movies_by_phase($phase_num)
    {
        $this->db
            ->select('m.*, p.phase_num, p.ten_phase, p.saga')
            ->from('movies m')
            ->join('phases p', 'p.id = m.phase_id', 'left')
            ->where('p.phase_num', (int) $phase_num)
            ->order_by('m.view_order', 'ASC');

        return $this->db->get()->result_array();
    }

    // ──────────── CHARACTERS ─────────────────────────────────

    /**
     * Lấy tất cả nhân vật, sắp xếp theo id.
     */
    public function get_all_characters()
    {
        return $this->db
            ->order_by('id', 'ASC')
            ->get('characters')
            ->result_array();
    }

    /**
     * Lấy một nhân vật theo slug.
     */
    public function get_character_by_slug($slug)
    {
        return $this->db
            ->where('slug', $slug)
            ->limit(1)
            ->get('characters')
            ->row_array();
    }

    // ──────────── PHASES ────────────────────────────────────

    /**
     * Lấy tất cả phases, sắp xếp theo phase_num.
     */
    public function get_all_phases()
    {
        return $this->db
            ->order_by('phase_num', 'ASC')
            ->get('phases')
            ->result_array();
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Api Controller
 * ─────────────────────────────────────────────────────────────
 * RESTful JSON API cho MCUverse.
 *
 * Endpoints:
 *   GET /api/movies            → danh sách tất cả phim (+ tên phase)
 *   GET /api/movies/{slug}     → chi tiết một phim
 *   GET /api/characters        → danh sách nhân vật
 *   GET /api/phases            → danh sách phases
 */
class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mcu_model');

        // Cho phép cross-origin (local dev)
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json; charset=UTF-8');

        // Nếu là pre-flight OPTIONS request → trả về ngay
        if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
            exit(0);
        }
    }

    // ─────────────────────────────────────────────────────────
    //  GET /api/movies
    // ─────────────────────────────────────────────────────────
    public function movies($slug = NULL)
    {
        if ($slug !== NULL) {
            // GET /api/movies/{slug}
            return $this->movie_detail($slug);
        }

        $movies = $this->Mcu_model->get_all_movies();

        // Chuẩn hóa kiểu dữ liệu trước khi trả JSON
        $movies = array_map([$this, '_cast_movie'], $movies);

        $this->_json([
            'status' => 'success',
            'count'  => count($movies),
            'data'   => $movies,
        ]);
    }

    // ─────────────────────────────────────────────────────────
    //  GET /api/movies/{slug}
    // ─────────────────────────────────────────────────────────
    public function movie_detail($slug)
    {
        $movie = $this->Mcu_model->get_movie_by_slug($slug);

        if (empty($movie)) {
            $this->_json(['status' => 'error', 'message' => 'Movie not found'], 404);
            return;
        }

        $this->_json([
            'status' => 'success',
            'data'   => $this->_cast_movie($movie),
        ]);
    }

    // ─────────────────────────────────────────────────────────
    //  GET /api/characters
    // ─────────────────────────────────────────────────────────
    public function characters()
    {
        $chars = $this->Mcu_model->get_all_characters();

        $chars = array_map(function ($c) {
            // Chuyển phase_1..phase_6 từ string sang bool array
            $c['phases'] = [
                (bool)(int) $c['phase_1'],
                (bool)(int) $c['phase_2'],
                (bool)(int) $c['phase_3'],
                (bool)(int) $c['phase_4'],
                (bool)(int) $c['phase_5'],
                (bool)(int) $c['phase_6'],
            ];
            // Xóa các cột riêng lẻ
            unset($c['phase_1'], $c['phase_2'], $c['phase_3'],
                  $c['phase_4'], $c['phase_5'], $c['phase_6']);
            $c['id'] = (int) $c['id'];
            return $c;
        }, $chars);

        $this->_json([
            'status' => 'success',
            'count'  => count($chars),
            'data'   => $chars,
        ]);
    }

    // ─────────────────────────────────────────────────────────
    //  GET /api/phases
    // ─────────────────────────────────────────────────────────
    public function phases()
    {
        $phases = $this->Mcu_model->get_all_phases();

        $phases = array_map(function ($p) {
            $p['id']         = (int) $p['id'];
            $p['phase_num']  = (int) $p['phase_num'];
            $p['film_count'] = (int) $p['film_count'];
            $p['phase_hue']  = (int) $p['phase_hue'];
            return $p;
        }, $phases);

        $this->_json([
            'status' => 'success',
            'count'  => count($phases),
            'data'   => $phases,
        ]);
    }

    // ─────────────────────────────────────────────────────────
    //  PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────

    /** Encode và in JSON, kết thúc request. */
    private function _json($data, $status_code = 200)
    {
        $this->output
            ->set_status_header($status_code)
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    /** Chuẩn hóa kiểu dữ liệu cho một movie row. */
    private function _cast_movie($m)
    {
        $m['id']         = (int)   $m['id'];
        $m['year']       = (int)   $m['year'];
        $m['rating']     = (float) $m['rating'];
        $m['view_order'] = (int)   $m['view_order'];
        $m['phase_num']  = (int)   $m['phase_num'];
        $m['phase_id']   = (int)   $m['phase_id'];
        return $m;
    }
}

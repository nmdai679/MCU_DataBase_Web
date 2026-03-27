<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 | -------------------------------------------------------------------
 |  BASE URL
 | -------------------------------------------------------------------
 | Chỉnh lại nếu tên thư mục của bạn khác "cuoi ki"
 */
$config['base_url'] = 'http://localhost/php/cuoi%20ki/';

$config['index_page']   = '';        // Bỏ trống khi dùng .htaccess
$config['uri_protocol'] = 'AUTO';

/*
 | Cấu hình ký tự cho URL
 */
$config['charset'] = 'UTF-8';

/*
 | Log lỗi (0 = tắt, 1 = Error, 2 = Debug)
 */
$config['log_threshold'] = 1;
$config['log_path']      = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';

/*
 | Các config bắt buộc khác
 */
$config['encryption_key'] = 'mcu-verse-secret-key-2025';
$config['sess_driver']    = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = NULL;
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

$config['cookie_prefix']   = '';
$config['cookie_domain']   = '';
$config['cookie_path']     = '/';
$config['cookie_secure']   = FALSE;
$config['cookie_httponly']  = FALSE;

$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire']     = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

$config['compress_output'] = FALSE;
$config['time_reference']  = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;
$config['uncacheable_methods'] = array('POST');

$config['subclass_prefix'] = 'MY_';
$config['composer_autoload'] = FALSE;
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['allow_get_array'] = TRUE;
$config['enable_hooks'] = FALSE;
$config['output_compression'] = FALSE;
$config['global_xss_filtering'] = FALSE;
$config['url_suffix'] = '';
$config['language'] = 'english';
$config['language_file'] = '';
$config['menu_items'] = array();
$config['use_page_cache'] = FALSE;
$config['cache_only'] = FALSE;
$config['proxy_ips'] = '';
$config['reverse_proxy_ips'] = '';
$config['reverse_proxy_header'] = 'X-Forwarded-For';
$config['uncacheable_file_extensions'] = '';

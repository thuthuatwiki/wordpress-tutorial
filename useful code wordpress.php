//* Loại bỏ Query String trong WordPress
function remove_cssjs_ver($src)
{
    if (strpos($src, '?ver='))
        $src = remove_query_arg('ver', $src);
    return $src;
}
add_filter('style_loader_src', 'remove_cssjs_ver', 10, 2);
add_filter('script_loader_src', 'remove_cssjs_ver', 10, 2);
//Tắt lựa chọn ngôn ngữ trong trang đăng nhập WordPress	
add_filter('login_display_language_dropdown', '__return_false');
//loại global style nội tuyến
add_action('after_setup_theme', 'wptangtoc_xoa_style_global_css');
function wptangtoc_xoa_style_global_css()
{
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
    remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
    remove_action('in_admin_header', 'wp_global_styles_render_svg_filters');
}
//loại bỏ tự viết hoa
$filters = array('the_content', 'the_title', 'wp_title', 'comment_text');
foreach ($filters as $filter) {
    $priority = has_filter($filter, 'capital_P_dangit');
    if ($priority !== false) {
        remove_filter($filter, 'capital_P_dangit', $priority);
    }
}
//ẩn phiên bản WordPress để nâng cao bảo mật
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', 'wptangtoc_hide_wp_version');
function wptangtoc_hide_wp_version()
{
    return '';
}
// Tắt XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Tắt REST API
add_action('init', function () {
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    remove_action('template_redirect', 'rest_output_link_header', 11, 0);
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_action('wp_head', 'wp_resource_hints', 2);
}, 999);

// Tắt Heartbeat API
add_action('init', function () {
    wp_deregister_script('heartbeat');
}, 1);

// Tắt Embeds
add_action('init', function () {
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
}, 999);

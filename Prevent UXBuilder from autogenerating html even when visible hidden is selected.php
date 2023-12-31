// Ngăn UXBuilder tự tạo html kể cả khi chọn visible hidden
add_filter('do_shortcode_tag', 'add_filter_shortcode_ux_visibility', 10, 3);
function add_filter_shortcode_ux_visibility($output, $tag, $attr)
{
    if (!isset($attr['visibility']))
        return $output;
    if ($attr['visibility'] == 'hidden')
        return;
    if (($attr['visibility'] == 'hide-for-medium') && wp_is_mobile())
        return;
    elseif (($attr['visibility'] == 'show-for-small') && !wp_is_mobile())
        return;
    elseif (($attr['visibility'] == 'show-for-medium') && !wp_is_mobile())
        return;
    elseif (($attr['visibility'] == 'hide-for-small') && wp_is_mobile())
        return;
    return $output;
}

//Comment cookies consent text
add_filter('comment_form_default_fields', 'tu_comment_form_change_cookies_consent');
function tu_comment_form_change_cookies_consent($fields)
{
    $commenter = wp_get_current_commenter();

    $consent = empty($commenter['comment_author_email']) ? '' : ' checked="checked"';

    $fields['cookies'] = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
        '<label for="wp-comment-cookies-consent">Lưu tên và email trong trình duyệt này cho lần bình luận kế tiếp của tôi.</label></p>';
    return $fields;
}

//nội quy bình luận
function crunchify_modify_text_before_comment_form($arg)
{
    $arg['comment_notes_before'] = 'p class=comment-notes' . __('We welcome relevant and respectful comments.  All comments are manually moderated and those deemed to be spam or solely promotional will be deleted.') . 'p';
    return $arg;
}
add_filter('comment_form_defaults', 'crunchify_modify_text_before_comment_form');

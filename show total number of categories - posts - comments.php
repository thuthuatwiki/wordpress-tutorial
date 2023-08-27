// hiển thị tổng số chuyên mục - bài viết - bình luận
// cách sử dụng [thongke]
function thong_ke() {
    $categories_count = wp_count_terms('category');
    $posts_count = wp_count_posts()->publish;
    $comments_count = wp_count_comments()->total_comments;
    $thong_ke = $categories_count . ' chuyên mục - ' . $posts_count . ' bài viết - ' . $comments_count . ' bình luận';
    return $thong_ke;
}
add_shortcode('thongke', 'thong_ke');

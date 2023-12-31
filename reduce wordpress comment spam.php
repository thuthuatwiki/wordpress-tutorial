/**
 * Giảm spam bình luận WordPress
 */

// Hàm để tạo câu hỏi bảo mật ngẫu nhiên
function generate_security_question()
{
    $questions = array(
        "8+2-5= ?" => "5",
        "10*2-5= ?" => "15",
        "3*5+1-6= ?" => "10"
    );

    // Lấy ngẫu nhiên một câu hỏi và câu trả lời
    $random_index = array_rand($questions);
    $random_question = $random_index;
    $answer = $questions[$random_index];

    // Trả về đoạn mã HTML cho câu hỏi
    return "<input type='hidden' name='comment_security_question' value='" . base64_encode($random_index) . "' /><p><label for='comment_security_answer'>Câu hỏi bảo mật: " . $random_question . "</label><input type='text' name='comment_security_answer' id='comment_security_answer' required /></p>";
}

// Hook để thêm câu hỏi bảo mật vào biểu mẫu bình luận
function add_security_question_to_comment_form()
{
    // Check if the user is an administrator
    if (!current_user_can('manage_options')) {
        echo generate_security_question();
    }
}
add_action('comment_form_before_fields', 'add_security_question_to_comment_form');

// Kiểm tra câu trả lời khi người dùng gửi bình luận
function check_security_question($commentdata)
{
    // Check if the user is an administrator
    if (current_user_can('manage_options')) {
        return $commentdata; // Bypass security question check for admins
    }

    $user_answer = $_POST['comment_security_answer'];
    $encoded_question = $_POST['comment_security_question'];
    $correct_index = base64_decode($encoded_question);

    if (empty($user_answer)) {
        wp_die('Vui lòng nhập đáp án câu hỏi bảo mật.');
    }

    $questions = array(
        "8+2-5= ?" => "5",
        "10*2-5= ?" => "15",
        "3*5+1-6= ?" => "10"
    );

    if (!array_key_exists($correct_index, $questions)) {
        wp_die('Câu trả lời bảo mật không chính xác. Vui lòng thử lại.');
    }

    $correct_answer = $questions[$correct_index];

    if ($user_answer !== $correct_answer) {
        wp_die('Câu trả lời bảo mật không chính xác. Vui lòng thử lại.');
    }

    return $commentdata;
}
add_filter('preprocess_comment', 'check_security_question');

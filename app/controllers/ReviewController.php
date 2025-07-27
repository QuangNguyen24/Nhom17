<?php

class ReviewController extends Controller {
    public function index() {
        header("Location: " . BASE_URL);
        exit();
    }

    public function submit() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng nhập']);
            return;
        }

        $product_id = intval($_POST['product_id'] ?? 0);
        $rating     = intval($_POST['rating'] ?? 0);
        $comment    = trim($_POST['comment'] ?? '');
        $user_id    = $_SESSION['user_id'];

        if ($product_id <= 0 || $rating < 1 || $rating > 5 || $comment === '') {
            echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
            return;
        }

        $reviewModel = $this->model('Review');

        // ✅ Kiểm tra đã đánh giá chưa
        if ($reviewModel->hasReviewed($product_id, $user_id)) {
            echo json_encode(['success' => false, 'message' => 'Bạn đã đánh giá sản phẩm này rồi.']);
            return;
        }

        // ✅ Thêm đánh giá mới
        $success = $reviewModel->insert($product_id, $user_id, $rating, $comment);

        // ✅ Lấy tên người dùng
        $username = $_SESSION['user']['username'] ?? null;
        if (!$username) {
            $db = (new Database())->connect();
            $stmt = $db->prepare("SELECT username FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $username = $stmt->get_result()->fetch_assoc()['username'] ?? 'Người dùng';
        }

        echo json_encode([
            'success'  => $success,
            'username' => htmlspecialchars($username),
            'rating'   => $rating,
            'comment'  => htmlspecialchars($comment)
        ]);
    }
}

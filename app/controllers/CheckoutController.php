<?php

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            $this->view('cart/empty');
            return;
        }

        $productModel = $this->model('Product');
        $cart_items = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = $productModel->findDetailById($productId);
            if ($product) {
                $price = ($product['discount_price'] > 0) ? $product['discount_price'] : $product['price'];
                $subtotal = $price * $quantity;
                $product['quantity'] = $quantity;
                $product['price'] = $price;
                $product['subtotal'] = $subtotal;
                $cart_items[] = $product;
                $total += $subtotal;
            }
        }

        $this->view('checkout/index', [
            'cart_items' => $cart_items,
            'total' => $total
        ]);
    }

    public function process()
    {
        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            header("Location: " . BASE_URL . "/index.php?url=cart/index");
            exit();
        }

        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $method_payment = $_POST['method_payment'] ?? '';

        $productModel = $this->model('Product');
        $total_calc = $productModel->calculateCartTotal($cart);

        $orderModel = $this->model('Order');
        $order_id = $orderModel->create([
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'total_price' => $total_calc,
            'method_payment' => $method_payment,
            'status' => $method_payment === 'vnpay' ? 'đã xác nhận' : 'đang chờ',
            'user_id' => $_SESSION['user_id'] ?? null
        ]);

        $orderDetail = $this->model('OrderDetail');
        $orderDetail->saveDetails($order_id, $cart);

        unset($_SESSION['cart']);

        switch ($method_payment) {
           case 'vnpay':
            header("Location: " . BASE_URL . "/index.php?url=checkout/vnpay_payment&order_id=$order_id");
            break;

            case 'chuyển khoản':
                header("Location: " . BASE_URL . "/index.php?url=checkout/bank_transfer&order_id=$order_id");
                break;
            case 'tiền mặt':
                header("Location: " . BASE_URL . "/index.php?url=checkout/success&order_id=$order_id");
                break;
            default:
                echo "<h3>Phương thức thanh toán không hợp lệ</h3>";
                break;
        }
    }

    public function success()
    {
        $order_id = intval($_GET['order_id'] ?? 0);
        if ($order_id <= 0) {
            echo "<h2>Mã đơn hàng không hợp lệ</h2>";
            return;
        }

        $orderModel = $this->model('Order');
        $order = $orderModel->getById($order_id);

        if (!$order) {
            echo "<h2>Không tìm thấy đơn hàng</h2>";
            return;
        }

        $this->view('checkout/success', ['order' => $order]);
    }

    public function bank_transfer()
    {
        $order_id = intval($_GET['order_id'] ?? 0);
        if ($order_id <= 0) {
            echo "<div class='container mt-5'><h2>Mã đơn hàng không hợp lệ</h2></div>";
            return;
        }

        $orderModel = $this->model('Order');
        $order = $orderModel->getById($order_id);

        if (!$order || $order['status'] !== 'đang chờ') {
            echo "<div class='container mt-5'><h2>Đơn hàng không tồn tại hoặc đã được thanh toán.</h2></div>";
            return;
        }

        $this->view('checkout/bank_transfer', ['order' => $order]);
    }

    public function vnpay_payment()
{
    $order_id = intval($_GET['order_id'] ?? 0);
    $orderModel = $this->model('Order');
    $order = $orderModel->getById($order_id);

    if (!$order || $order['total_price'] <= 0) {
        echo '<div class="container mt-5"><h2>Đơn hàng không tồn tại hoặc không hợp lệ.</h2></div>';
        return;
    }

    $vnp_TmnCode = "2QXUI4W6";
    $vnp_HashSecret = "YTU)&FIBUZKAXCNMQLBPGPWXN2Y1O3CZ";
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_ReturnUrl = "https://a302-58-187-140-79.ngrok-free.app/index.php?url=checkout/vnpay_return";
    

    $vnp_TxnRef = $order_id;
    $vnp_OrderInfo = "Thanh toán đơn hàng #" . $order_id;
    $vnp_Amount = $order['total_price'] * 100;
    $vnp_Locale = "vn";
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

    $inputData = [
        "vnp_Version" => "2.1.0",
        "vnp_Command" => "pay",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_TxnRef" => $vnp_TxnRef,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => "billpayment",
        "vnp_Locale" => $vnp_Locale,
        "vnp_ReturnUrl" => $vnp_ReturnUrl,
        "vnp_IpAddr" => $vnp_IpAddr
    ];

    ksort($inputData);
    $query = http_build_query($inputData);
    $hashdata = urldecode($query);
    $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $inputData['vnp_SecureHash'] = $vnp_SecureHash;

    $redirectUrl = $vnp_Url . '?' . http_build_query($inputData);
    header("Location: " . $redirectUrl);
    exit();
}

public function vnpay_return()
{
    $vnp_HashSecret = "YTU)&FIBUZKAXCNMQLBPGPWXN2Y1O3CZ";
    $inputData = [];

    foreach ($_GET as $key => $value) {
        if (substr($key, 0, 4) == "vnp_") {
            $inputData[$key] = $value;
        }
    }

     file_put_contents("vnpay_log.txt", json_encode($inputData, JSON_PRETTY_PRINT));

    $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
    unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

    ksort($inputData);
    $hashData = urldecode(http_build_query($inputData));
    $secureHashCheck = hash_hmac('sha512', $hashData, $vnp_HashSecret);

    $order_id = intval($inputData['vnp_TxnRef'] ?? 0);
    $orderModel = $this->model('Order');

    if ($secureHashCheck === $vnp_SecureHash) {
        if ($inputData['vnp_ResponseCode'] == '00') {
            $orderModel->updateStatus($order_id, 'đã xác nhận');
            $order = $orderModel->getById($order_id);
            $this->view('checkout/success', ['order' => $order]);
        } else {
            echo "<div class='container mt-5'><h2>Thanh toán thất bại. Mã lỗi: {$inputData['vnp_ResponseCode']}</h2></div>";
        }
    } else {
        echo "<div class='container mt-5'><h2>Chuỗi xác thực không hợp lệ. Dữ liệu có thể bị thay đổi.</h2></div>";
    }
}




// public function momo_payment()
//     {
//         $order_id = intval($_GET['order_id'] ?? 0);
//         $orderModel = $this->model('Order');
//         $order = $orderModel->getById($order_id);

//         if (!$order || $order['total_price'] <= 0) {
//             echo '<div class="container mt-5"><h2>Đơn hàng không tồn tại hoặc không hợp lệ.</h2></div>';
//             return;
//         }

//         $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
//         $partnerCode = "MOMOXYZAUTO";
//         $accessKey = "F8BBA842ECF85";
//         $secretKey = "K951B6PE1waDMi640xX08PD3vg6EkVlz";
//         $redirectUrl = BASE_URL . "/index.php?url=checkout/success&order_id=$order_id";
//         $ipnUrl = BASE_URL . "/index.php?url=checkout/momo_ipn";

//         $requestId = time() . "";
//         $orderInfo = "Thanh toán đơn hàng #$order_id";
//         $amount = $order['total_price'];
//         $orderId = $order_id . "";

//         $requestType = "captureWallet";
//         $extraData = "";

//         $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";

//         $signature = hash_hmac("sha256", $rawHash, $secretKey);

//         $data = [
//             'partnerCode' => $partnerCode,
//             'accessKey' => $accessKey,
//             'requestId' => $requestId,
//             'amount' => $amount,
//             'orderId' => $orderId,
//             'orderInfo' => $orderInfo,
//             'redirectUrl' => $redirectUrl,
//             'ipnUrl' => $ipnUrl,
//             'extraData' => $extraData,
//             'requestType' => $requestType,
//             'signature' => $signature,
//             'lang' => 'vi'
//         ];

//         $ch = curl_init($endpoint);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//         $result = curl_exec($ch);
//         curl_close($ch);

//         $response = json_decode($result, true);

//         if (!empty($response['payUrl'])) {
//             header("Location: " . $response['payUrl']);
//             exit();
//         } else {
//             echo "<h3>Không thể khởi tạo thanh toán MOMO</h3>";
//         }
//     }

//     public function momo_ipn()
// {
//     $data = $_POST ?: json_decode(file_get_contents('php://input'), true);

//     // Log để test
//     file_put_contents('momo_ipn_log.txt', json_encode($data, JSON_PRETTY_PRINT));

//     if (!empty($data['orderId']) && $data['resultCode'] == 0) {
//         // Trả về thành công
//         $orderModel = $this->model('Order');

//         // Giả sử orderId gốc là ID thực (có thể sửa nếu cậu sinh `orderId` theo thời gian)
//         $order_id = $_GET['order_id'] ?? 0;
//         $orderModel->updateStatus($order_id, 'đã xác nhận');
//     }

//     http_response_code(200); // Bắt buộc gửi về cho MOMO
//     echo json_encode(['message' => 'IPN received']);
// }

}

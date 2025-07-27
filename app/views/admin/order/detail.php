
<style>
  body {
    font-family: Arial;
    background-color: white !important;
    color: #000 !important;
  }
  table, th, td {
    color: #000 !important;
  }
</style>


<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>

    <div class="container mt-4" id="receipt-content">
        <div class="store-header text-center mb-4 pb-2 border-bottom border-dark">
        <img src="../public/images/logo/Nexore_logo_unback.png" alt="Logo" width="120" style="margin-bottom: 10px;">
        <h1 class="fw-bold">HÓA ĐƠN BÁN HÀNG</h1>
        <p> Nexore E-Shop </p>
        <p>Hotline: 0123 456 789 - Địa chỉ: 140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, TP.HCM</p>
    </div>


    <div class="info-block mb-4">
        <p><strong>Mã đơn hàng: #</strong> <?= $order['id'] ?></p>
        <p><strong>Tài khoản:</strong> <?= $order['username'] ?></p>
        <p><strong>Họ tên:</strong> <?= $order['fullname'] ?></p>
        <p><strong>Email:</strong> <?= $order['email'] ?></p>
        <p><strong>Điện thoại:</strong> <?= $order['phone'] ?></p>
        <p><strong>Địa chỉ:</strong> <?= $order['address'] ?></p>
        <p><strong>Phương thức thanh toán:</strong>
            <?= isset($order['method_payment']) && $order['method_payment']
                ? ucfirst($order['method_payment']) : 'Chưa cập nhật' ?>
        </p>
        <p><strong>Ngày đặt hàng:</strong> <?= date('d-m-Y H:i:s', strtotime($order['created_at'])) ?></p>
        <p><strong>Trạng thái đơn hàng:</strong> <?= ucfirst($order['status']) ?></p>
    </div>

    <h5 class="mt-4 mb-2">Danh sách sản phẩm</h5>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; foreach ($details as $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td><img src="<?= $item['image'] ?>" width="60"></td>
                <td><?= $item['name'] ?></td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($item['price']) ?> VND</td>
                <td><?= number_format($subtotal) ?> VND</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Tổng cộng:</th>
                <th><?= number_format($total) ?> VND</th>
            </tr>
        </tfoot>
    </table>

    <div class="mt-5 text-end signature">
        <p> --------------------------</p>
        <strong>Nexorevn</strong>
    </div>
    <div class="text-center mt-4">
        <p class="text-muted">Cảm ơn bạn đã mua sắm tại Nexore E-Shop!</p>
        <p class="text-muted">Đây là biên lai mua hàng của bạn.</p>
    </div>

    <div class="mt-4 no-print text-center">
        <a href="admin.php?url=order/index" class="btn btn-secondary">Quay lại</a>
        <button onclick="printReceipt()" class="btn btn-primary">In biên lai</button>
    </div>
</div>

<script>
function printReceipt() {
    const content = document.getElementById("receipt-content").innerHTML;
    const win = window.open('', '', 'width=800,height=600');
    win.document.write(`<!DOCTYPE html>
    <html>
    <head>
        <title>Biên lai đơn hàng</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <style>
            body {
                padding: 40px;
                font-family: 'Arial', sans-serif;
                color: #000;
                background: #fff;
            }
            .store-header {
                text-align: center;
                border-bottom: 2px solid #000;
                margin-bottom: 30px;
                padding-bottom: 10px;
            }
            .store-header h1 {
                margin: 0;
                font-size: 28px;
                font-weight: bold;
            }
            .info-block {
                margin-bottom: 25px;
            }
            .info-block p {
                margin: 2px 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
            }
            table, th, td {
                border: 1px solid #333;
            }
            th, td {
                padding: 10px;
                text-align: center;
            }
            tfoot th {
                font-size: 16px;
                text-align: right;
            }
            .signature {
                margin-top: 50px;
                text-align: right;
            }
            .signature p {
                margin-bottom: 80px;
            }
            .no-print {
        display: none !important;
    }
            @media print {
                .no-print {
                    display: none !important;
                }
            }   

        </style>
    </head>
    <body>
        ${content}
    </body>
    </html>`);
    win.document.close();
    win.focus();
    setTimeout(() => {
        win.print();
        win.close();
    }, 500);
}
</script>

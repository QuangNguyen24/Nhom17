<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <!-- Biểu đồ -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm p-3">
                <h6 class="mb-3 text-center">📊 Doanh thu theo tháng</h6>
                <canvas id="salesChart" height="200"></canvas>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm p-3">
                <h6 class="mb-3 text-center">👤 Người dùng mới</h6>
                <canvas id="userChart" height="200"></canvas>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm p-3">
                <h6 class="mb-3 text-center">📦 Sản phẩm theo danh mục</h6>
                <canvas id="categoryChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Thống kê -->
    <div class="row">
        <?php
        $stats = [
            ['Tổng đơn hàng', 'bi-cart', $data['total_orders']],
            ['Doanh thu', 'bi-currency-dollar', number_format($data['total_revenue'], 0, ',', '.') . ' VND'],
            ['Đơn hàng đang chờ', 'bi-hourglass-split', $data['total_pending_orders']],
            ['Liên hệ khách hàng', 'bi-envelope', $data['total_contacts']],
            ['Quản trị viên', 'bi-shield-lock', $data['total_admins']],
            ['Người dùng thường', 'bi-person', $data['total_normal_users']],
            ['Danh mục', 'bi-tags', $data['total_categories']],
            ['Hãng sản xuất', 'bi-building', $data['total_brands']],
        ];
        foreach ($stats as [$label, $icon, $value]) {
            echo <<<HTML
            <div class="col-md-3 mb-4">
                <div class="card p-3 h-100 shadow-sm">
                    <h6 class="mb-2">{$label}</h6>
                    <h4><i class="bi {$icon} me-2"></i>{$value}</h4>
                </div>
            </div>
            HTML;
        }
        ?>
    </div>
</div>

<!-- Chart.js (nếu chưa có) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Biểu đồ -->
<script>
const salesCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($data['months']) ?>,
        datasets: [{
            label: 'Doanh thu',
            data: <?= json_encode($data['monthly_sales']) ?>,
            borderColor: 'blue',
            backgroundColor: 'rgba(0,0,255,0.1)',
            tension: 0.4,
        }]
    }
});

const userCtx = document.getElementById('userChart').getContext('2d');
new Chart(userCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($data['months']) ?>,
        datasets: [{
            label: 'Người dùng mới',
            data: <?= json_encode($data['monthly_users']) ?>,
            backgroundColor: 'orange'
        }]
    }
});

const categoryCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(categoryCtx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($data['category_labels']) ?>,
        datasets: [{
            label: 'Sản phẩm',
            data: <?= json_encode($data['category_counts']) ?>,
            backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#4bc0c0']
        }]
    }
});
</script>

<?php include_once __DIR__ . '/../../layouts/admin_footer.php'; ?>

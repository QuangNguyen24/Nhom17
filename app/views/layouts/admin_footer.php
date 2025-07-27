</div> <!-- .content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Dữ liệu PHP → JavaScript
const salesLabels = <?= json_encode($sales_labels ?? []) ?>;
const salesData = <?= json_encode($sales_data ?? []) ?>;

const userLabels = <?= json_encode(array_keys($user_roles ?? [])) ?>;
const userData = <?= json_encode(array_values($user_roles ?? [])) ?>;

const categoryLabels = <?= json_encode($category_labels ?? []) ?>;
const categoryData = <?= json_encode($category_counts ?? []) ?>;

// Biểu đồ Doanh thu (Line)
const ctxSales = document.getElementById('salesChart')?.getContext('2d');
if (ctxSales) {
    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: salesLabels,
            datasets: [{
                label: 'Doanh thu (VND)',
                data: salesData,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: '📈 Doanh thu 7 ngày gần nhất',
                    color: '#000'
                },
                legend: { labels: { color: '#000' } }
            },
            scales: {
                x: { ticks: { color: '#000' }, grid: { color: '#ccc' } },
                y: { ticks: { color: '#000' }, grid: { color: '#ccc' } }
            }
        }
    });
}

// Biểu đồ Người dùng (Bar)
const ctxUser = document.getElementById('userChart')?.getContext('2d');
if (ctxUser) {
    new Chart(ctxUser, {
        type: 'bar',
        data: {
            labels: userLabels,
            datasets: [{
                label: 'Số lượng người dùng',
                data: userData,
                backgroundColor: ['#007bff', '#28a745'],
                borderColor: ['#0056b3', '#1e7e34'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: '👤 Người dùng theo vai trò',
                    color: '#000'
                },
                legend: { display: false }
            },
            scales: {
                x: { ticks: { color: '#000' }, grid: { color: '#eee' } },
                y: { ticks: { color: '#000' }, grid: { color: '#eee' }, beginAtZero: true }
            }
        }
    });
}

// Biểu đồ sản phẩm theo danh mục (Pie)
const ctxCategory = document.getElementById('categoryChart')?.getContext('2d');
if (ctxCategory) {
    new Chart(ctxCategory, {
        type: 'pie',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'Sản phẩm theo danh mục',
                data: categoryData,
                backgroundColor: [
                    '#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#2ecc71', '#e67e22', '#3498db'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: '📊 Tỷ lệ sản phẩm theo danh mục',
                    color: '#000'
                },
                legend: {
                    labels: {
                        color: '#000'
                    }
                }
            }
        }
    });
}
</script>

</body>
</html>

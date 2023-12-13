<?php
$query = "select authors.name as name, sum(order_detail.quantity) as value
            from authors join products on authors.id=products.author_id
            join order_detail on products.id=order_detail.productId
            join orders on orders.id=order_detail.orderId
            where orders.status != 4
            group by name";

$result = $connect->query($query);

// Kiểm tra và lấy dữ liệu
if ($result) {
    $data = array();

    // Lặp qua các dòng dữ liệu và đưa vào mảng
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Chuyển đổi dữ liệu sang JSON
    $json_data = json_encode($data);
} else {
    echo "Lỗi trong quá trình thực hiện truy vấn: " . $connect->error;
}
?>
<div class="card">
    <div class="card-body pb-0">
        <h5 class="card-title">Thống kê lượt mua theo tác giả</h5>

        <div id="trafficChart" style="min-height: 800px;" class="echart"></div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                        trigger: 'item',
                        textStyle: {
                            fontSize: 12, // Kích thước font chữ
                            fontFamily: 'Cambria, sans-serif' // Font chữ
                        }
                    },
                    legend: {
                        top: '5%',
                        left: 'center',
                        textStyle: {
                            fontSize: 12, // Kích thước font chữ
                            fontFamily: 'Nunito, sans-serif' // Font chữ
                        }
                    },
                    series: [{
                        name: 'Tác giả',
                        type: 'pie',
                        radius: ['40%', '70%'],
                        avoidLabelOverlap: false,
                        label: {
                            show: false,
                            position: 'center',
                        },
                        emphasis: {
                            label: {
                                show: true,
                                fontWeight: 'bold',
                                textStyle: {
                                    fontSize: 15, 
                                    fontFamily: 'Nunito, sans-serif' 
                                }
                            }
                        },
                        labelLine: {
                            show: false
                        },
                        data: <?= $json_data ?>,
                        
                    }]
                });
            });
        </script>

    </div>
</div>
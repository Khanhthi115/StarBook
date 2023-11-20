<?php
$query = "select date(orders.order_date) as date, sum(order_detail.quantity * order_detail.price) as purchases
    from order_detail join orders on orders.id=order_detail.orderId
    where orders.status != 4
    group by date
    order by date DESC";

$result = $connect->query($query);

// Kiểm tra và lấy dữ liệu
if ($result) {
    $dataRevenue = array();
    $data = array();

    // Lặp qua các dòng dữ liệu và đưa vào mảng
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    foreach ($data as $item) {
        // echo $item['date']," ", $item['purchases'], "<br/>";
        $dataRevenue[] = (int)($item['purchases'])/1000;
        $dataDate[] = ($item['date']);
    }
    // Chuyển đổi dữ liệu sang JSON
    $json_data = json_encode($dataRevenue);
    // echo $json_data;
    $json_data_date = json_encode($dataDate);
    // echo $json_data_date;
} else {
    echo "Lỗi trong quá trình thực hiện truy vấn: " . $connect->error;
}

$query2 = "select count(id) from orders group by date(order_date) order by date(order_date) DESC";
$result2 = $connect->query($query2);
if ($result2) {
    while ($row = $result2->fetch_row()) {
        // echo $row[0] . '<br>';
        $dataOrders[] = (int)($row[0]);
    }
    $json_data_orders = json_encode($dataOrders);
    // echo $json_data_orders;
}

?>
<div class="col-12">
    <div class="card">

        <div class="card-body">
            <h5 class="card-title">Thống kê doanh thu ( x 1000 VND)</h5>

            <!-- Line Chart -->
            <div id="reportsChart"></div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                            name: 'Số đơn',
                            data: <?=$json_data_orders?>
                        }, {
                            name: 'Doanh thu',
                            data: <?=$json_data?>
                        }],
                        chart: {
                            height: 350,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                        },
                        markers: {
                            size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.3,
                                opacityTo: 0.4,
                                stops: [0, 90, 100]
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        xaxis: {
                            type: 'datetime',
                            categories: <?=$json_data_date?>,
                        },
                        tooltip: {
                            x: {
                                format: 'yyyy-MM-dd'
                            },
                        }
                    }).render();
                });
            </script>
            <!-- End Line Chart -->

        </div>

    </div>
</div>
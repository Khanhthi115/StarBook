<?php
$query = "select products.name as product_name, sum(order_detail.quantity) as product_quantity
            from products join order_detail on products.id=order_detail.productId
            join orders on orders.id=order_detail.orderId
            where orders.status != 4
            group by product_name
            order by product_quantity DESC
            limit 10";
$result = $connect->query($query);
if ($result) {
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $dataProductName[] = $row['product_name'];
        $dataProductQuantity[] = (int)($row['product_quantity']);
    }
    $json_data_name = json_encode($dataProductName);
    $json_data_quantity = json_encode($dataProductQuantity);
} else {
    echo "Lỗi trong quá trình thực hiện truy vấn: " . $connect->error;
}
?>
<div class="col-12">
    <div class="card top-selling overflow-auto">
        <div class="card-body pb-0">
            <h5 class="card-title">Sách bán chạy nhất</span></h5>
            <div id="chart" style="height: 400px;"></div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        new ApexCharts(document.querySelector("#chart"), {
            series: [{
                data: <?= $json_data_quantity ?>
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: <?= $json_data_name ?>
            }
        }).render();
    })
</script>
<?php
$query = "select categories.name as categories, sum(order_detail.quantity) as purchases
            from categories join products on categories.id=products.cat_id
            join order_detail on products.id=order_detail.productId
            join orders on orders.id=order_detail.orderId
            group by categories.name";

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

<h1>Thống kê lượt mua theo danh mục</h1>
<div id="chart" style="height: 500px;"></div>

<script>
new Morris.Bar({
  // ID of the element in which to draw the chart.
  element: 'chart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: <?php echo $json_data; ?>,
  // The name of the data record attribute that contains x-values.
  xkey: 'categories',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['purchases'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Purchases']
});
</script>

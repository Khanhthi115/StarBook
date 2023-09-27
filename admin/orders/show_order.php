<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $connect->query("delete from order_detail where order_id = $id");
    $connect->query("delete from orders where id = $id");
    header("location: ?option=order&status=4");
}
?>
<?php
$status = $_GET['status'];
$query = "select * from orders where status = " . $_GET['status'];
$result = $connect->query($query);
?>
<h1>DANH SÁCH ĐƠN HÀNG <?= $status == 1 ? 'CHƯA XỬ LÝ' : ($status == 2 ? 'ĐANG XỬ LÝ' : ($status == 3 ? 'ĐÃ XỬ LÝ' : 'HỦY')) ?></h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã đơn hàng</th>
            <th>Ngày tạo</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $count = 1; ?>
        <?php foreach ($result as $item) : ?>
            <tr>
                <td><?= $count++ ?></td>
                <td><?= $item['id'] ?></td>
                <td><?= $item['order_date'] ?></td>
                <td>
                    <a class="btn btn-sm btn-info" href="?option=order_detail&id=<?= $item['id'] ?>">Detail</a>
                    <!-- delete button only display when status = 'HUY' -->
                    <a class="btn btn-sm btn-danger" href="?option=order&id=<?= $item['id'] ?>" onclick="return confirm('Are you sure to delete this product?')">Delete</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
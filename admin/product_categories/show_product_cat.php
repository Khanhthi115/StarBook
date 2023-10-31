<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $product = $connect->query("select * from products where cat_id = $id");
    if (mysqli_num_rows($product) != 0) {
        $query = "update categories set status=0 where id = $id";
        $connect->query($query);
       
    } else {
        $connect->query("delete from categories where id = $id");
        
    }
}
?>
<?php
$query = "select * from categories";
$result = $connect->query($query);
?>
<h1>DANH SÁCH DANH MỤC SẢN PHẨM</h1>
<section style="text-align:center">
    <a href="?option=product_cat_add" class="btn btn-success">Thêm danh mục sản phẩm</a>
</section>
<table class="table table-bordered" style="text-align: center">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã danh mục sản phẩm</th>
            <th>Tên danh mục sản phẩm</th>
            <th>Trạng thái</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $count = 1; ?>
        <?php foreach ($result as $item) : ?>
        <tr>
            <td><?= $count++ ?></td>
            <td><?= $item['id'] ?></td>
            <td><?= $item['name'] ?></td>
            <td><?= $item['status'] == 1 ? 'Active' : 'Unactive' ?></td>
            <td>
                <a class="btn btn-sm btn-info" href="?option=product_cat_update&id=<?= $item['id'] ?>">Update</a>
                <a class="btn btn-sm btn-danger" href="?option=product_categories&id=<?= $item['id'] ?>" o
                    onclick="return confirm('Are you sure to delete this product category?')">Delete</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
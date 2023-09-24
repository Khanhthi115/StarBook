<?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $product = $connect->query("select * from products where author_id = $id");
        if (mysqli_num_rows($product)!=0) {
            $query = "update authors set status=0 where id = $id";
            $connect->query($query);
        }else {
            $connect->query("delete from authors where id = $id");
        }
    }
?>
<?php
    $query = "select * from products";
    $result = $connect->query($query);
?>
<h1>DANH SÁCH SẢN PHẨM</h1>
<section style="text-align:center">
    <a href="?option=product_add" class="btn btn-success">Thêm sản phẩm</a>
</section>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Ảnh</th>
            <th>Giá</th>
            <th>Trạng thái</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $count = 1; ?>
        <?php foreach ($result as $item) : ?>
            <tr>
                <td><?=$count++?></td>
                <td><?=$item['id']?></td>
                <td><?=$item['name']?></td>
                <td><img width="100px" src="../images/<?=$item['image']?>" alt=""></td>
                <td><?=number_format($item['price'],0,',','.')?> VND</td>
                <td><?=$item['status']==1?'Active':'Unactive'?></td>
                <td>
                    <a class="btn btn-sm btn-info" href="?option=product_update&id=<?=$item['id']?>">Update</a>
                    <a class="btn btn-sm btn-danger" href="?option=product&id=<?=$item['id']?>" onclick="return confirm('Are you sure to delete this product?')">Delete</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
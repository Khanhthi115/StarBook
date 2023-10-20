<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $product = $connect->query("select * from articles where article_cat_id = $id");
    if (mysqli_num_rows($product) != 0) {
        $query = "update article_categories set status=0 where id = $id";
        $connect->query($query);
        echo "heloooooooo";
    } else {
        $connect->query("delete from article_categories where id = $id");
        echo "heloooooooo";
    }
}
?>
<?php
$query = "select * from article_categories";
$result = $connect->query($query);
?>
<h1>DANH SÁCH DANH MỤC BÀI VIẾT</h1>
<section style="text-align:center">
    <a href="?option=article_categories_add" class="btn btn-success">Thêm danh mục bài viết</a>
</section>
<table class="table table-bordered" style="text-align: center">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã danh mục bài viết</th>
            <th>Tên danh mục bài viết</th>
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
                    <a class="btn btn-sm btn-info" href="?option=article_categories_update&id=<?= $item['id'] ?>">Update</a>
                    <a class="btn btn-sm btn-danger" href="?option=article_categories&id=<?= $item['id'] ?>" onclick="return confirm('Are you sure to delete this article category?')">Delete</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
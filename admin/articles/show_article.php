<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // delete article and its image
    $connect->query("delete from articles where id = $id");
    unlink("../images/" . $_GET['image']);
}
?>
<?php
$query = "select * from articles";
$result = $connect->query($query);
?>
<h1>DANH SÁCH BÀI VIẾT</h1>
<section style="text-align:center">
    <a href="?option=article_add" class="btn btn-success">Thêm mới bài viết</a>
</section>
<table class="table table-bordered" style="text-align: center">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã bài viết</th>
            <th>Ngày tạo</th>
            <th width="300px">Tiêu đề bài viết</th>
            <th>Ảnh</th>
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
                <td><?= $item['create_date'] ?></td>
                <td><?= $item['name'] ?></td>
                <td><img width="60px" src="../images/<?= $item['image'] ?>" alt=""></td>
                <td><?= $item['status'] == 1 ? 'Active' : 'Unactive' ?></td>
                <td>
                    <a class="btn btn-sm btn-info" href="?option=article_update&id=<?= $item['id'] ?>">Update</a>
                    <a class="btn btn-sm btn-danger" href="?option=article&id=<?= $item['id'] ?>&image=<?= $item['image'] ?>" onclick="return confirm('Are you sure to delete this article?')">Delete</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
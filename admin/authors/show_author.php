<?php
$query = "select * from authors";
$result = $connect->query($query);
?>
<h1>Hãng sản xuất</h1>
<section style="text-align:center">
    <a href="?option=author_add" class="btn btn-success">Thêm tác giả</a>
</section>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã tác giả</th>
            <th>Tên tác giả</th>
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
                <td><?=$item['status']==1?'Active':'Unactive'?></td>
                <td>
                    <a class="btn btn-sm btn-info" href="?option=author_update&id=<?=$item['id']?>">Update</a>
                    <a class="btn btn-sm btn-danger" href="">Delete</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
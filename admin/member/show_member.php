<?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $member = $connect->query("select * from orders where member_id = $id");
        if (mysqli_num_rows($member)!=0) {
            $query = "update member set status=0 where id = $id";
            $connect->query($query);
        }else {
            $connect->query("delete from member where id = $id");
        }
    }
?>
<?php
    $query = "select * from member";
    $result = $connect->query($query);
?>
<<h1>DANH SÁCH NGƯỜI DÙNG</h1>
<section style="text-align:center">
    <a href="?option=member_add" class="btn btn-success">Thêm người dùng</a>
</section>
<table class="table table-bordered" style="text-align: center">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã người dùng</th>
            <th>Username</th>
            <th>Password</th>
            <th>Tên đầy đủ</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Email</th>
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
                <td><?=$item['username']?></td>
                <td><?=$item['password']?></td>
                <td><?=$item['fullname']?></td>
                <td><?=$item['phonenumber']?></td>
                <td><?=$item['address']?></td>
                <td><?=$item['email']?></td>
                <td><?=$item['status']==1?'Active':'Unactive'?></td>
                <td>
                    <a class="btn btn-sm btn-info" href="?option=member_update&id=<?=$item['id']?>">Update</a>
                    <a class="btn btn-sm btn-danger" href="?option=member&id=<?=$item['id']?>" onclick="return confirm('Are you sure to delete this member?')">Delete</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

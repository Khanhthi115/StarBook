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
    <a href="?option=member_add" class="btn btn-success mb-3">Thêm người dùng</a>
</section>
<table class="table table-bordered" style="text-align: center">
    <thead>
        <tr>
            <th width="20px">Id</th>
            <th>Username</th>
            <th>Full name</th>
            <th>SĐT</th>
            <th>Address</th>
            <th>Email</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $count = 1; ?>
        <?php foreach ($result as $item) : ?>
            <tr>
                <td width="20px"><?=$item['id']?></td>
                <td><?=$item['username']?></td>
                <td><?=$item['fullname']?></td>
                <td><?=$item['phonenumber']?></td>
                <td><?=$item['address']?></td>
                <td><?=$item['email']?></td>
                <td><?=$item['status']==1?'Active':'Unactive'?></td>
                <td>
                    <a class="btn btn-sm btn-info text-white" href="?option=member_update&id=<?=$item['id']?>">Update</a>
                    <a class="btn btn-sm btn-danger" href="?option=members&id=<?=$item['id']?>" onclick="return confirm('Are you sure to delete this member?')">Delete</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

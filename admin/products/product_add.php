<?php
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $query = "select * from products where name='$name'";
    if (mysqli_num_rows($connect->query($query)) != 0) {
        $alert = "Sản phẩm đã tồn tại";
    } else {
        $author_id = $_POST['author_id'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $status = $_POST['status'];

        // Deal with upload images
        // destination to save images
        $store = "../images/";
        $imageName = $_FILES['image']['name'];
        // save the temp path of file uploaded 
        $imageTemp = $_FILES['image']['tmp_name'];
        // take the expand of file
        $exp3 = substr($imageName, strlen($imageName) - 3); #abcd.jpg;
        $exp4 = substr($imageName, strlen($imageName) - 4); #abcd.jpeg;
        if (
            $exp3 == 'jpg' || $exp3 == 'png' || $exp3 == 'bmp' || $exp3 == 'gif' || $exp4 == 'webp' || $exp4 == 'jpeg' ||
            $exp3 == 'JPG' || $exp3 == 'PNG' || $exp3 == 'GIF' || $exp3 == 'BMP' || $exp4 == 'WEBP' || $exp4 == 'JPEG'
        ) {
            // change the name of image, difference 1/1/1970 -> now (ms)
            $imageName = time() . '_' . $imageName;
            // move file upload to the destination want to save
            move_uploaded_file($imageTemp, $store . $imageName);
            $connect->query("insert products(author_id, name, image, price, description, status)
            values ($author_id, '$name', '$imageName', $price, '$description', '$status')");
            header("Location: ?option=product");
        } else {
            $alert = "File đã chọn không hợp lệ";
        }
    }
}
?>
<?php
$author = $connect->query("select * from authors");
?>
<h1>Thêm sản phẩm</h1>
<section style="color: red; text-align:center"><?= isset($alert) ? $alert : '' ?></section>
<section class="container col-md-6">
    <form method="post" enctype="multipart/form-data">
        <section class="form-group">
            Tên hãng:
            <select name="author_id" class="form-control">
                <option hidden>--Chọn tác giả--</option>
                <?php foreach ($author as $item) : ?>
                    <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </section>
        <section class="form-group">
            Tên sản phẩm: <input name="name" class="form-control">
        </section>
        <section class="form-group">
            Ảnh: <input name="image" type="file" class="form-control">
        </section>
        <section class="form-group">
            <label>Mô tả: </label>
            <textarea id="description" name="description"></textarea>
        </section>
        <section class="form-group">
            Giá: <input name="price" type="number" min="10000" class="form-control">
        </section>
        <section class="form-group">
            Trạng thái:<br>
            <input name="status" type="radio" value="1" checked>
            Active
            <input type="radio" name="status" value="0">
            Unactive
        </section>
        <section>
            <input type="submit" value="Thêm" class="btn btn-success">
            <a href="?option=product" class="btn btn-outline-primary">&lt;&lt;Back</a>
        </section>
    </form>
</section>
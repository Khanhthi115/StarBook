<?php
$product = mysqli_fetch_array($connect->query("select * from articles where id=" . $_GET['id']));
?>
<?php
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $query = "select * from articles where name='$name' and id!=" . $product['id'];
    if (mysqli_num_rows($connect->query($query)) != 0) {
        $alert = "Bài viết đã tồn tại";
    } else {
        $article_cat_id = $_POST['article_cat_id'];
        $content = $_POST['content'];
        $status = $_POST['status'];
        $summary = $_POST['summary'];
        $youtube = $_POST['youtube'];
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
            // if ("../images" . $product['image']) unlink("../images" . $product['image']);
            // delete the old image after update new image to save the memory
            unlink($store . $product['image']);
        } else {
            $alert = "File đã chọn không hợp lệ";
        }
        if (empty($imageName)) {
            //if admin don't change the image it will be the old
            $imageName = $product['image'];
        }
        // echo $author_id, $name, $price, $description, $status, "image: ", $imageName;
        $query = ("update articles set article_cat_id = $article_cat_id, name='$name',
            image='$imageName', content='$content', summary='$summary', status='$status', youtube='$youtube' where id=" . $product['id']);
        $connect->query($query);
        header("Location: ?option=article");
    }
}
?>
<?php
$author = $connect->query("select * from article_categories");
?>
<h1>Update bài viết</h1>
<section style="color: red; text-align:center"><?= isset($alert) ? $alert : '' ?></section>
<section class="container col-md-6">
    <form method="post" enctype="multipart/form-data">
        <section class="form-group">
            Tên danh mục bài viết:
            <select name="article_cat_id" class="form-control">
                <option hidden>--Chọn danh mục bài viết--</option>
                <?php foreach ($author as $item) : ?>
                    <option value="<?= $item['id'] ?>" <?= $item['id'] == $product['article_cat_id'] ? 'selected' : '' ?>><?= $item['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </section>
        <section class="form-group">
            Tiêu đề bài viết: <input name="name" class="form-control" value="<?= $product['name'] ?>">
        </section>
        <section class="form-group">
            Ảnh: <br>
            <img src="../images/<?= $product['image'] ?>" width="100px" alt=''>
            <input name="image" type="file" class="form-control">
        </section>
        <section class="form-group">
            <label>Tóm tắt bài viết: </label>
            <textarea style="width: 100%" cols="5" id="summary" name="summary"><?= $product['summary'] ?></textarea>
        </section>
        <section class="form-group">
            <label>Nội dung bài viết: </label>
            <textarea id="description" name="content"><?= $product['content'] ?></textarea>
        </section>
        <section class="form-group">
            <label>Link youtube: </label>
            <textarea style="width: 100%" cols="5" id="youtube" name="youtube"><?= $product['youtube'] ?></textarea>
        </section>
        <section class="form-group">
            Trạng thái:<br>
            <input name="status" type="radio" value="1" <?= $product['status'] == 1 ? 'checked' : '' ?>>
            Active
            <input type="radio" name="status" value="0" <?= $product['status'] == 0 ? 'checked' : '' ?>>
            Unactive
        </section>
        <section>
            <input type="submit" value="Update" class="btn btn-success">
            <a href="?option=article" class="btn btn-outline-primary">&lt;&lt;Back</a>
        </section>
    </form>
</section>
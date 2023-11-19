<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$chuaXuLy = mysqli_num_rows($connect->query("select * from orders where status=1"));
$dangXuLy = mysqli_num_rows($connect->query("select * from orders where status=2"));
$daXuLy = mysqli_num_rows($connect->query("select * from orders where status=3"));
$huy = mysqli_num_rows($connect->query("select * from orders where status=4"));
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - StarBook</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="?option=home" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">StarBook</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">Admin</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Admin</h6>
              <span>Staff of Starbook</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="?option=logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="?option=dashboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->


      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="?option=members">
          <i class="bi bi-person"></i>
          <span>Quản lý tài khoản</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="?option=product_categories">
          <i class="ri-product-hunt-line"></i>
          <span>Quản lý danh mục sản phẩm</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="?option=product">
          <i class="ri-product-hunt-line"></i>
          <span>Quản lý sản phẩm</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="?option=author">
          <i class="bi bi-person"></i>
          <span>Quản lý tác giả</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="?option=article_categories">
          <i class="bx bx-book-open"></i>
          <span>Quản lý danh mục bài viết</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="?option=article">
          <i class="bx bx-book-open"></i>
          <span>Quản lý bài viết</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Đơn hàng</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="?option=order&status=1">
              <i class="bi bi-circle"></i><span>Đơn hàng chưa xử lý</span>
            </a>
          </li>
          <li>
            <a href="?option=order&status=2">
              <i class="bi bi-circle"></i><span>Đơn hàng đang xử lý</span>
            </a>
          </li>
          <li>
            <a href="?option=order&status=3">
              <i class="bi bi-circle"></i><span>Đơn hàng đã xử lý</span>
            </a>
          </li>
          <li>
            <a href="?option=order&status=4">
              <i class="bi bi-circle"></i><span>Đơn hàng đã hủy</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <?php
    if (isset($_GET['option'])) {
      switch ($_GET['option']) {
        case 'logout':
          unset($_SESSION['admin']);
          header("Location: .");
          break;
        case 'members':
          include "./members/show_member.php";
          break;
        case 'member_add':
          include "members/member_add.php";
          break;
        case 'member_update':
          include "members/update_member.php";
          break;
        case 'author':
          include "./authors/show_author.php";
          break;
        case 'author_add':
          include "authors/author_add.php";
          break;
        case 'author_update':
          include "authors/update_author.php";
          break;
        case 'product':
          include "./products/show_product.php";
          break;
        case 'product_add':
          include "./products/product_add.php";
          break;
        case "product_update":
          include "./products/product_update.php";
          break;
        case "product_categories":
          include "./product_categories/show_product_cat.php";
          break;
        case "product_cat_add":
          include "./product_categories/product_cat_add.php";
          break;
        case "product_cat_update":
          include "./product_categories/product_cat_update.php";
          break;
        case "article_categories":
          include "./article_categories/show_articles_cat.php";
          break;
        case "article_categories_add":
          include "./article_categories/articles_cat_add.php";
          break;
        case "article_categories_update":
          include "./article_categories/articles_cat_update.php";
          break;
        case "article":
          include "./articles/show_article.php";
          break;
        case "article_update":
          include "./articles/article_update.php";
          break;
        case "article_add":
          include "./articles/article_add.php";
          break;
        case "order":
          include "./orders/show_order.php";
          break;
        case "order_detail":
          include "./orders/order_detail.php";
          break;
        case 'dashboard':
          include 'C:\xampp\htdocs\project-php\admin-v2\dashboard.php';
          break;
        default:
          include 'C:\xampp\htdocs\project-php\admin-v2\dashboard.php';
          break;
      }
    } else {
      include 'C:\xampp\htdocs\project-php\admin-v2\dashboard.php';
    }
    ?>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <p class="text-center">From Group 3 - 20231IT6022003</p>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
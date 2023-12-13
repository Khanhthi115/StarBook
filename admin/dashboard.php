<?php
$queryNumberOfOrders = "select * from orders where status != 4";
$resultNumberOfOrders = mysqli_num_rows($connect->query($queryNumberOfOrders));
$queryNumberOfMembers = "select * from member";
$resultNumberOfMembers = mysqli_num_rows($connect->query($queryNumberOfMembers));
$queryRevenue = "select price, quantity from order_detail join orders on orders.id = order_detail.orderId where orders.status != 4";
$resultRevenue = $connect->query($queryRevenue);
if ($resultRevenue && $resultRevenue->num_rows > 0) {
  $total = 0;
  while ($row = $resultRevenue->fetch_assoc()) {
    $price = $row['price'] * $row['quantity'];
    $total += $price;
  }
}
?>

<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="?option=home">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-8">
      <div class="row">

        <!-- Sales Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Đơn hàng</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cart"></i>
                </div>
                <div class="ps-3">
                  <h6><?= $resultNumberOfOrders ?></h6>
                  <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                </div>
              </div>
            </div>

          </div>
        </div><!-- End Sales Card -->

        <!-- Revenue Card -->
        <div class="col-xxl-6 col-md-6">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Doanh thu</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                  <h6><?= number_format($total) ?> VND</h6>
                  <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                </div>
              </div>
            </div>

          </div>
        </div><!-- End Revenue Card -->

        <!-- Customers Card -->
        <div class="col-xxl-3 col-xl-12">

          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">Khách hàng</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6><?= $resultNumberOfMembers ?></h6>
                  <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> -->
                </div>
              </div>

            </div>
          </div>

        </div><!-- End Customers Card -->

        <?php include('../admin/statistical/byRenevueAndOrders.php') ?>
        <?php include('../admin/statistical/byProducts.php') ?>
      </div>
    </div>
    <div class="col-lg-4">
      <?php include('../admin/statistical/byAuthors.php') ?>
    </div>
  </div>
</section>
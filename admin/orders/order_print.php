
<?php
require('../../tfpdf/tfpdf.php');
$connect = mysqli_connect("localhost", "root", "", "starbook_databse");

$pdf = new tFPDF();
$pdf->AddPage();
$pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
$pdf->SetFont('DejaVu', '', 14);

$order_id = $_GET['id'];
$query = "select a.fullname, a.phonenumber as 'member_phone', a.address as 'member_address', a.email  as 'member_email',
    b.*, c.name as 'order_method_name' from member a join orders b on a.id = b.member_id
    join order_methods c on b.order_method_id = c.id
    where b.id = " . $_GET['id'];
$order = mysqli_fetch_array($connect->query($query));

$pageWidth = $pdf->GetPageWidth();
// Lấy kích thước của chữ "HÓA ĐƠN NHÀ SÁCH STARBOOK"
$textWidth = $pdf->GetStringWidth('HÓA ĐƠN NHÀ SÁCH STARBOOK');

// Tính toán tọa độ x để căn giữa chữ trong trang
$x = ($pageWidth - $textWidth) / 2;

$pdf->Image('../../images/logo_new.png', $pdf->GetX(), $pdf->GetY(), 30);
// In chữ "HÓA ĐƠN NHÀ SÁCH STARBOOK" ở tọa độ x, y
$pdf->Text($x, 20, 'HÓA ĐƠN NHÀ SÁCH STARBOOK');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(40, 40, 'Mã đơn hàng: ' . $order['id']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Ngày đặt: ' . $order['order_date']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Người nhận: ' . $order['fullname']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Số điện thoại: ' . $order['phone']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Địa chỉ nhận hàng: ' . $order['address']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Hình thức thanh toán: ' . $order['order_method_name']);
$pdf->Ln();
$pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
$pdf->SetFont('DejaVu', '', 14);

$pdf->Cell(40, 10, 'Chi tiết đơn hàng:');
$pdf->Ln();
$pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
$pdf->SetFont('DejaVu', '', 14);

$pdf->Cell(10, 10, 'STT', 1, 0, 'C');
$pdf->Cell(140, 10, 'Tên sách', 1, 0, 'C');
$pdf->Cell(30, 10, 'Giá', 1, 0, 'C');
$pdf->Cell(10, 10, 'SL', 1, 0, 'C');
$pdf->Ln();
$query = "select a.status, b.*, c.name, c.image 
    from orders a join order_detail b on a.id = b.orderId 
    join products c on b.productId = c.id 
    where a.id = " . $order['id'];
$order_detail = $connect->query($query);
$i = 0;
$tong = 0;
while ($row = mysqli_fetch_array($order_detail)) {
    $i++;
    $pdf->Cell(10, 10, $i, 1, 0, 'C');
    $pdf->Cell(140, 10, $row['name'], 1, 0, 'C');
    $pdf->Cell(30, 10, number_format($row['price']) . "đ", 1, 0, 'C');
    $pdf->Cell(10, 10, $row['quantity'], 1, 0, 'C');
    $pdf->Ln();
    $tong += $row['price'] * $row['quantity'];
}
if ($tong >= 200000) $ship = 0;
else $ship = 30000;

$pdf->Ln();
$pdf->Cell(40, 10, 'Tổng tiền hàng: ' . number_format($tong) . "đ");
$pdf->Ln();
$pdf->Cell(40, 10, 'Phí ship: ' . number_format($ship) . "đ");
$pdf->Ln();
$pdf->Cell(40, 10, 'Thành tiền: ' . number_format($tong + $ship) . "đ");
$pdf->Ln();
if ($order['order_method_name'] != "Thanh toán khi nhận hàng") $pdf->Cell(40, 10, 'Đã thanh toán');
else $pdf->Cell(40, 10, 'Shipper thu hộ ' . number_format($tong + $ship) . "đ");
$pdf->Output();
?>
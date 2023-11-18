 <?php
    $query = "select * from `article_categories`";
    $result = $connect->query($query);

    if (isset($_SESSION['member'])) {
        $memberId = mysqli_fetch_array($connect->query("select * from `member` where `username`='" . $_SESSION['member'] . "'"));
        $memberId = $memberId['id'];

        $queryWishlist = "select * from `wishlist` where `member_id` = " . $memberId;
        $numberOfProductsInWishlist = mysqli_num_rows($connect->query($queryWishlist));

        $queryCart = "select * from `cart` where `member_id` = " . $memberId;
        $numberOfProductsInCart = mysqli_num_rows($connect->query($queryCart));
    }

    ?>
 <div class="humberger__menu__overlay"></div>
 <div class="humberger__menu__wrapper">
     <div class="humberger__menu__logo">
         <a href="#"><img src="img/logo.png" alt=""></a>
     </div>
     <div class="humberger__menu__cart">
         <ul>
             <li><a href="#"><i class="fa fa-heart"></i> <?php if ($numberOfProductsInWishlist > 0) echo "<span>$numberOfProductsInWishlist</span>";
                                                            else echo "0"; ?></a></li>
             <li><a href="?option=signin.php"><i class="fa fa-shopping-bag"></i><?php if ($numberOfProductsInCart > 0) echo "<span>$numberOfProductsInCart</span>";
                                                                                else echo "0"; ?></a></li>
         </ul>
     </div>
     <div class="humberger__menu__widget">
         <div class="header__top__right__auth">
             <a href="?option=register"><i class="fa fa-user"></i> Đăng ký</a>
         </div>
         <div class="header__top__right__auth">
             <a href="?option=signin"><i class="fa fa-user"></i> Đăng nhập</a>
         </div>
     </div>
     <nav class="humberger__menu__nav mobile-menu">
         <ul>
             <li class="active"><a href="./index.html">Home</a></li>
             <li><a href="./shop-grid.html">Books</a></li>
             <li><a href="#">Authors</a>
                 <ul class="header__menu__dropdown">
                     <?php foreach ($result as $item) : ?>
                         <li><a href="?option=article&article_cat=<?= $item['id'] ?>"><?= $item['name'] ?></a></li>
                     <?php endforeach; ?>
                     <li><a href="./shop-details.html">Nguyễn Nhật Ánh</a></li>
                     <li><a href="./shoping-cart.html">Trần Đăng Khoa</a></li>
                 </ul>
             </li>
             <li><a href="./blog.html">Cart</a></li>
             <li><a href="./contact.html">Contact</a></li>
         </ul>
     </nav>
     <div id="mobile-menu-wrap"></div>
     <div class="header__top__right__social">
         <a href="#"><i class="fa fa-facebook"></i></a>
         <a href="#"><i class="fa fa-twitter"></i></a>
         <a href="#"><i class="fa fa-linkedin"></i></a>
         <a href="#"><i class="fa fa-pinterest-p"></i></a>
     </div>
     <div class="humberger__menu__contact">
         <ul>
             <li><i class="fa fa-envelope"></i> starbook@gmail.com</li>
             <li>Free shipping cho các đơn hàng có giá trên 200K</li>
         </ul>
     </div>
 </div>
 <header class="header">
     <div class="header__top">
         <div class="container">
             <div class="row">
                 <div class="col-lg-6 col-md-6">
                     <div class="header__top__left">
                         <ul>
                             <li><i class="fa fa-envelope"></i> starbook@gmail.com</li>
                             <li>Free Shipping cho các đơn hàng có giá từ 200K</li>
                         </ul>
                     </div>
                 </div>
                 <div class="col-lg-6 col-md-6">
                     <div class="header__top__right">
                         <?php if (empty($_SESSION['member'])) : ?>
                             <div class="header__top__right__auth">
                                 <a href="?option=register"><i class="fa fa-user"></i> Đăng ký</a>
                             </div>
                             <div class="header__top__right__auth">
                                 <a href="?option=signin"><i class="fa fa-user"></i> Đăng nhập</a>
                             </div>
                         <?php else : ?>
                             <div class="header__top__right__social">
                                 Hello: <span style="color: green; margin-right: 30px;"><?= $_SESSION['member'] ?></span>
                                 <a href="?option=change_password"><i class="fa fa-edit"></i> Đổi mật khẩu</a>
                                 <a href="?option=logout"><i class="fa fa-user"></i> Đăng xuất</a>
                             </div>
                         <?php endif; ?>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="container">
         <div class="row">
             <div class="col-lg-3">
                 <div class="header__logo">
                     <a href="./index.php"><img style="margin: auto;" height="80px" src="../images/logo_new.png" alt=""></a>
                 </div>
             </div>
             <div class="col-lg-6">
                 <nav class="header__menu">
                     <ul>
                         <li class="active"><a href="?option=home">Home</a></li>
                         <li><a href="?option=show_products">Sách</a></li>
                         <li><a href="?option=cart">Giỏ hàng</a></li>
                         <li><a href="?option=show_articles">Bài viết</a>
                             <ul class="header__menu__dropdown">
                                 <?php foreach ($result as $item) : ?>
                                     <li><a href="?option=show_articles&article_cat=<?= $item['id'] ?>"><?= $item['name'] ?></a></li>
                                 <?php endforeach; ?>
                                 <li><a href="?option=show_articles">Tất Cả</a></li>
                             </ul>
                         </li>
                         <li><a href="?option=contact">Liên hệ</a></li>
                     </ul>
                 </nav>
             </div>
             <div class="col-lg-3">
                 <div class="header__cart">
                     <ul>
                         <li><a href="?option=wishlist"><i class="fa fa-heart"></i> <span><?= $numberOfProductsInWishlist > 0 ? $numberOfProductsInWishlist : "0" ?></span></a></li>
                         <li><a href="?option=cart"><i class="fa fa-shopping-bag"></i> <span><?= $numberOfProductsInCart > 0 ? $numberOfProductsInCart : "0" ?></a></li>
                     </ul>
                 </div>
             </div>
         </div>
         <div class="humberger__open">
             <i class="fa fa-bars"></i>
         </div>
     </div>
 </header>
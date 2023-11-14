 <!-- Blog Section Begin -->
 <?php
    $query = "select * from articles where status = 1";

    // take products from current page
    $query .= " order by rand() limit 3";
    $result = $connect->query($query);
    $number = mysqli_num_rows($result);
    ?>

 <section class="from-blog spad">
     <div class="container">
         <div class="row">
             <div class="col-lg-12">
                 <div class="section-title from-blog__title">
                     <h2>Bài Viết</h2>
                 </div>
             </div>
         </div>
         <div class="row"  style="animation-name: fadeInUp; animation-duration: 3s">
             <?php if ($number > 0) : ?>
                 <?php foreach ($result as $item) : ?>
                     <a class="col-lg-4 col-md-4 col-sm-6" href="?option=article_detail&id=<?= $item['id'] ?>">
                         <!-- <div class="col-lg-4 col-md-4 col-sm-6"> -->
                         <div class="blog__item">
                             <div class="blog__item__pic">
                                 <img style="object-fit:cover" width="300px" height="300px" src="../images/<?= $item['image'] ?>" alt="">
                             </div>
                             <div class="blog__item__text" style="height: 250px; overflow: hidden;">
                                 <ul>
                                     <li><i class="fa fa-calendar-o"></i> <?= $item['create_date'] ?></li>
                                     <li><i class="fa fa-comment-o"></i></li>
                                 </ul>
                                 <h5><?= $item['name'] ?></h5>
                                 <p><?= $item['summary'] ?> </p>
                             </div>
                         </div>
                         <!-- </div> -->
                     </a>
                 <?php endforeach; ?>
             <?php else : ?>
                 <p style="color: red">Không tìm thấy sản phẩm</p>
             <?php endif; ?>

         </div>
     </div>
 </section>
 <!-- Blog Section End -->
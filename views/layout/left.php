<?php
$query = "select * from authors where status";
$result = $connect->query($query);
?>
<?php foreach($result as $item):?>
    <nav>
        <section><a href="?option=show_products&authorId=<?=$item['id']?>"><?=$item['name']?></a></section>
    </nav>
<?php endforeach;?>
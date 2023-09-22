<?php
$result = $connect->query("select * from member");
foreach ($result as $item) {
    echo "<br>" . $item['fullname'];
}

<?php
include "../../parts/index.php";

$query = $db->prepare(
    "SELECT b.*, u.full_name, c.name
    FROM blogs AS b
    LEFT JOIN categories AS c
    ON b.category_id = c.id
    LEFT JOIN users AS u
    ON u.id = b.created_by
    WHERE b.id = ?
 "
);
$query->execute([
    get('id')
]);
$data = $query->fetch(PDO::FETCH_ASSOC);
?>
<div class="container-sm">
    <img width="100%" src="../../imgs/blogImgs/<?= $data['image'] ?>" alt="">
    <h3><?= $data['title'] ?></h3>
    <p><b><i class="fa-solid fa-user"></i><?= $data['full_name'] ?></b></p>
    <p><?= $data['description'] ?></p>
    <p><?= $data['name'] ?></p>
    <p><?php
    $date = date('y/m/d', strtotime($data['created_at']));
    echo $date;
    ?></p>
</div>
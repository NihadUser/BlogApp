<?php
include "../../parts/index.php";

$query = $db->prepare(
    "SELECT b.*, u.full_name as userName, c.name as catName
    FROM blogs AS b
    LEFT JOIN categories AS c 
    ON b.category_id = c.id
    LEFT JOIN users AS u
    ON u.id = b.created_by
    WHERE b.id = ?
"
);
$query->execute([
    $_GET['id']
]);
$data = $query->fetch(PDO::FETCH_ASSOC);
?>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Blog Name</th>
                <th>Creator Name</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Created date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?= $data['title'] ?>
                </td>
                <td>
                    <?= $data['userName'] ?>
                </td>
                <td>
                    <?= $data['catName'] ?>
                </td>
                <td>
                    <?= $data['description'] ?>
                </td>
                <td>
                    <?= $data['image'] ?>
                </td>
                <td>
                    <?= $data['created_at'] ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="container mt-3">
    <div style="display:flex;width:60%; gap:20px;">
        <div>
            <img style="border-radius:50%;width: 75px;height:75px;"
                src="https://plus.unsplash.com/premium_photo-1664457233868-d2a40c759998?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="">
        </div>
        <p>Comments</p>
    </div>
</div>
<div class="container mt-3">
    <div style="display:flex;width:60%; gap:20px;">
        <div>
            <img style="border-radius:50%;width: 75px;height:75px;"
                src="https://plus.unsplash.com/premium_photo-1664457233868-d2a40c759998?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="">
        </div>
        <form action="" style="width:100%;" class="form">
            <div class="form-group">
                <input type="text" class="form-control">
                <input type="submit" class="btn mt-2 btn-primary">
            </div>
        </form>
    </div>
</div>
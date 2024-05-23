<?php
include "../../parts/index.php";
function insertDb($db)
{
    if (post('name') == null) {
        return [
            'success' => false,
            'message' => "Name can not be null"
        ];
    }

    $query = $db->prepare('SELECT name FROM categories where name = ?');
    $query->execute([post('name')]);
    $name = $query->fetch(PDO::FETCH_ASSOC);
    if ($name != null) {
        return [
            'success' => false,
            'message' => "This name has alredy var"
        ];
    }

    $query = $db->prepare('INSERT INTO categories(name, created_by) VALUES (?, ?)');
    $query->execute([
        post('name'),
        $_SESSION['userId']
    ]);
    return [
        'success' => true,
        'message' => "Inserted successfully!"
    ];
}

if (post('sbumitBtn')) {
    $insert = insertDb($db);
    if ($insert['success'] == false) {
        echo "
        <div class='alert alert-danger'>{$insert['message']}</div>
        ";
    } else {
        echo "
         <div class='alert alert-primary'>{$insert['message']}</div>
         ";
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-6">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Category Name</label>
                    <input type="text" class="form-control" name="name" id="" placeholder="Enter cat name">
                </div>
                <input type="submit" name="sbumitBtn" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
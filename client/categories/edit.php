<?php
include "../../parts/index.php";
function updateName($db)
{
    if (post('name') == null) {
        return [
            'success' => false,
            'message' => 'Name can not be null'
        ];
    }

    $query = $db->prepare('SELECT name FROM categories WHERE name = ?');
    $query->execute([
        post('name')
    ]);
    $data = $query->fetch(PDO::FETCH_ASSOC);
    if ($data != null) {
        return [
            'success' => false,
            'message' => "Name already exsists!"
        ];
    }

    $query = $db->prepare("UPDATE categories SET name = ? WHERE id = ? and created_by = ?");
    $update = $query->execute([
        post('name'),
        $_GET['id'],
        $_SESSION['userId']
    ]);
    if ($update) {
        return [
            'success' => true,
            'message' => 'Category name update successfully'
        ];
    }
}

if (post('submitBtn')) {
    $update = updateName($db);
    echo $update['message'];
}

$query = $db->prepare("SELECT name FROM categories WHERE id = ? AND created_by = ? ");
$query->execute([
    $_GET['id'],
    $_SESSION['userId']
]);
$catName = $query->fetch(PDO::FETCH_ASSOC);
if ($catName == null) {
    return (header("location: index.php"));
}
?>
<div class="container">
    <div class="row">
        <div class="col-6">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Edit Category Name</label>
                    <input type="text" class="form-control" name="name" value="<?= $catName['name'] ?>" name="name"
                        id="" placeholder="Enter cat name">
                </div>
                <input type="submit" name="submitBtn" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
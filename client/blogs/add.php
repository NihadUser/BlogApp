<?php
include "../../parts/index.php";

$query = $db->prepare("SELECT id, name FROM categories");
$query->execute([]);
$categories = $query->fetchAll(PDO::FETCH_ASSOC);
function insertBlog($db)
{
    if (isset($_FILES['file'])) {
        $img = $_FILES['file'];
        $image = imageUpload($img, 'blogImgs');
    }
    if (post('title') == null) {
        return [
            'success' => false,
            'message' => "Blog title cannot be empty"
        ];
    } elseif (post('description') == null) {
        return [
            'success' => false,
            'message' => 'Blog description cannot be empty '
        ];
    }
    $query = $db->prepare('INSERT INTO blogs (title, description, category_id, created_by, image) VALUES (?, ?, ?, ?, ?)');
    $query->execute([
        post('title'),
        post('description'),
        post('categoryId'),
        $_SESSION['userId'],
        $image
    ]);
    return [
        'success' => true,
        'message' => "Inserted successfully"
    ];

}
if (post('submitBtn')) {
    $insert = insertBlog($db);
    $success = $insert['success'] == true ? 'success' : 'danger';
    echo "<div class='alert alert-{$success}'>{$insert['message']}}</div>";

    // if ($insert['success']) {
    //     echo "<div class='alert alert-success'>{$insert['message']}}</div>";
    // } else {
    //     echo "<div class='alert alert-danger'>{$insert['message']}}</div>";
    // }
}


?>
<div class="container-sm mt-4">
    <div class="col-6">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group mt-3">
                <input type="file" name="file" class="form-control">
            </div>
            <div class="form-group mt-3">
                <select name="categoryId" class="form-select" id="">
                    <?php
                    foreach ($categories as $item):
                        ?>
                    <option value="<?php echo $item['id'] ?>"><?= $item['name'] ?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
            </div>
            <textarea name="description" cols="30" class="mt-3" rows="10"></textarea><br>
            <input type="submit" class="btn btn-primary" name="submitBtn">
        </form>
    </div>
</div>
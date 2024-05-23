<?php
include "../../parts/index.php";

if (post('insertBtn')) {
    $insert = storeBlog($db);

    if ($insert['success'] == false) {
        echo "<div class='alert alert-danger'>{$insert['message']}</div>";
    } else {
        echo "<div class='alert alert-success'>{$insert['message']}</div>";
    }
}

function storeBlog($db)
{
    global $fileNameWithDir;
    if (post('title') == null) {
        return [
            'success' => false,
            'message' => 'Please fill title input.'
        ];
    }
    $insertBlogQuery = $db->prepare(
        "INSERT INTO blogs (title, description, category_id, created_by, cover_img)
         VALUES (?, ?, ?, ?, ?)"
    );
    $insertBlogQuery->execute([
        post('title'),
        post('description'),
        post('category_id'),
        $_SESSION['id'],
        $fileNameWithDir
    ]);
    return [
        'success' => true,
        'message' => 'Stored successfully.'
    ];
}

$dir = "uploads/";
$fileNameWithDir = $dir . time() . rand(1, 999) . basename($_FILES['cover_img']['name'] ?? "");

$isPhotoExits = isset($_FILES['cover_img']['error']) && $_FILES['photo']['error'] == 0;

if ($isPhotoExits == false) {
    return [
        'success' => false,
        'message' => 'Cover image is required.'
    ];
}

$check = getimagesize($_FILES['photo']['tmp_name']);
if ($check === false) {
    return [
        'success' => false,
        'message' => 'Photo input is not an image.'
    ];
}

if ($_FILES['cover_img']['size'] > 5000000) {
    return [
        'success' => false,
        'message' => 'File is too large.'
    ];
}

$imageFileType = strtolower(pathinfo($fileNameWithDir, PATHINFO_EXTENSION));
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    return [
        'success' => 'false',
        'message' => 'Sorry, only JPG, JPEG, PNG files are allowed.'
    ];
}

$upload = move_uploaded_file($_FILES['cover_img']['tmp_name'], '../' . $fileNameWithDir);
if (!$upload) {
    return [
        'success' => false,
        'message' => 'Photo cannot be uploaded.'
    ];

}
$categoriesQuery = $db->prepare("SELECT id, name FROM categories");
$categoriesQuery->execute([]);
$categories = $categoriesQuery->fetchALL(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h3>Create Blog</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="title">Title</label>
        <div class="form-group">
            <input type="text" class="form-control" name="title" id="title">
        </div>

        <label for="description">Description</label>
        <div class="form-group">
            <textarea class="form-control" name="description" id="description"></textarea>
        </div>
        <label for="category">Category</label>
        <div class="form-group">
            <select name="category_id" id="category" class="form-control">
                <?php
                foreach ($categories as $category):
                    ?>
                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php
                endforeach;
                ?>

            </select>
        </div>
        <label for="cover">Cover Image</label>
        <div class="form-group">
            <input type="file" class="form-control" id="cover_img" name="cover_img">
        </div>
        <br>
        <input type="submit" name="insertBtn" class="btn btn-primary">
    </form>
</div>
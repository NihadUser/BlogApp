<?php
include "../../parts/index.php";
$blog = '';

$query = $db->prepare("SELECT * FROM categories");
$query->execute([]);
$categories = $query->fetchAll(PDO::FETCH_ASSOC);


function updateBlog($db)
{
    global $blog;
    $imageName = $blog != null ? $blog['image'] : '';
    if (post('title') == null) {
        return [
            'success' => false,
            'message' => 'Title can not be empty!'
        ];
    }
    if (isset($_FILES['file'])) {
        $newFileName = imageUpload($_FILES['file'], 'blogImgs');
    }
    $query = $db->prepare("UPDATE blogs SET title = ?, description = ?, image = ?, category_id = ?, update_at = ? WHERE id = ? and created_by = ?");
    $query->execute([
        post('title'),
        post('description'),
        $newFileName ?? $imageName,
        post('category'),
        date("y/m/d H:i:s"),
        post('id'),
        $_SESSION['userId']
    ]);
    return [
        'success' => true,
        'message' => "Updated scsflly"
    ];

}

if (post('submitBtn')) {
    $update = updateBlog($db);
    $str = $update['message'] ? 'success' : 'danger';
    echo "<div class='alert alert-{$str}'>{$update['message']}</div>";
}

$query = $db->prepare("SELECT * FROM blogs WHERE id = ?");
$query->execute([
    $_GET['id']
]);
$blog = $query->fetch(PDO::FETCH_ASSOC);
print_r($blog);
echo $blog['image'];

?>
<div class="container mt-5">
    <h1>Edit Blog</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $blog['id'] ?>">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" value="<?= $blog['title'] ?>" name="title" id="title"
                placeholder="Enter title">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"
                placeholder="Enter description"><?= $blog['description'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image </label>
            <input type="file" name="image" class="form-control">
            <img src="../../imgs/blogImgs/<?= $blog['image'] ?>" width="250" height="250" alt="">
        </div>
        <div class="form-group">
            <label for="categories">Categories</label>
            <select class="form-control" name="category" id="categories">
                <?php
                foreach ($categories as $category):
                    ?>
                    <option <?php if ($category['id'] == $blog['category_id']): ?> selected <?php endif; ?>
                        value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php
                endforeach;
                ?>
            </select>
        </div>
        <input type="submit" name="submitBtn" class="btn btn-primary">
    </form>
</div>
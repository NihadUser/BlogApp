<?php
include "../../parts/index.php";

// $query = $db->prepare(
//     "SELECT b.*, u.full_name AS userName, c.name AS catName FROM blogs AS b
//     LEFT JOIN users AS u ON u.id = b.created_by
//     LEFT JOIN categories AS c ON b.category_id = c.id
//     "
// );

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$executeArr = [];
$isFilter = false;
$where = " WHERE ";


if (get('searchTitle')) {
    $where .= " title LIKE ? ";
    $isFilter = true;
    $executeArr[] = "%" . get('searchTitle') . "%";
}
if (get('id')) {
    $where .= !$isFilter ? " category_id = ? " : " and category_id = ?";
    $isFilter = true;
    $executeArr[] = get('id');
}

$where = !$isFilter ? "" : $where;

$query = "SELECT b.*, u.full_name as userName, c.name as catName
        FROM blogs AS b
        LEFT JOIN categories AS c 
        ON b.category_id = c.id
        LEFT JOIN users AS u
        ON u.id = b.created_by
        $where
        LIMIT $limit OFFSET $offset";
echo $query;
$query = $db->prepare($query);
$query->execute($executeArr);
$blogs = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $db->prepare("SELECT count(id) as total FROM blogs");
$query->execute([]);
$totalBlogCount = $query->fetch(PDO::FETCH_ASSOC)['total'];
$paginationCount = ceil($totalBlogCount / $limit);

$query = $db->prepare("SELECT c.id, count(c.id) AS countId, c.name AS catName, b.title AS blogName 
        FROM categories AS c
        LEFT JOIN blogs AS b
        ON b.category_id = c.id
        GROUP BY c.id
        ");
$query->execute([]);
$categories = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <form action="" method="GET">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <input type="text" name="searchName" value="<?= get('searchName') ?>" class="form-control">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <input type="text" name="searchAuthor" value="<?= get('searchAuthor') ?>" class="form-control">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <button>
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <!-- <input type="submit" name="searchBtn" class="btn btn-primary" value="Search"> -->
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-8 d-flex justify-content-between align-items-center">
            <h1>
                Categories
            </h1>
            <a href="add.php" class="btn btn-primary">Add</a>
        </div>
    </div>
    <!-- <div class="row"> -->
    <div class="col-9">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Image</th>
                    <th scope="col">Creator</th>
                    <th scope="col">Created_at</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($blogs as $blog):
                    ?>
                    <tr>
                        <th scope="row"><?= $count++ ?></th>
                        <td><?= $blog['title'] ?></td>
                        <td><?= $blog['description'] ?></td>
                        <td><img width="100px" src="../../imgs/blogImgs/<?= $blog['image'] ?>" alt=""></td>
                        <td><?= $blog['userName'] ?></td>
                        <td><?= $blog['created_at'] ?></td>
                        <?php
                        if (isset($_SESSION['userId'])):
                            ?>
                            <td>
                                <a <?php if ($_SESSION['userId'] == $blog['created_by'])
                                    echo "href='delete.php?id={$blog['id']}'";
                                ?> class="btn btn-danger danger">Delete</a>
                                <a class="btn btn-primary " <?php if ($_SESSION['userId'] == $blog['created_by']): ?>
                                        href="edit.php?id=<?= $blog['id'] ?> <?php endif; ?>">Edit</a>
                            </td>
                            <?php
                        endif;
                        ?>
                    </tr>
                    <?php
                endforeach;
                ?>
            </tbody>
        </table>
        <!-- </div> -->
    </div>
    <div class="container">
        <ul class="pagination">

            <?php
            $searchName = get('searchName');
            $searchAuthor = get('searchAuthor');
            $previous = $page - 1;
            $href = $page == 1 ? '' : "http://localhost/Coders/PROJECT/admin/blogs/blogs.php/?page={$previous}";
            $previousButtonDisable = $page == 1 ? 'disabled' : "";

            $next = $page == $paginationCount ? $paginationCount : $page + 1;
            $nextHref = "http://localhost/Coders/PROJECT/admin/blogs/blogs.php/?page={$next}";
            $nextButtonDisable = $page == $paginationCount ? 'disabled' : '';
            ?>
            <li class="page-item <?= $previousButtonDisable ?>">
                <a class="page-link" href=<?= $href ?>>Previous</a>
            </li>

            <?php
            for ($i = 1; $i <= $paginationCount; $i++) {
                ?>
                <li class="page-item"><a class="page-link"
                        href=<?= "http://localhost/Coders/PROJECT/admin/blogs/blogs.php/?page=$i" ?>><?php echo $i ?></a>
                </li>
                <?php
            }
            ?>

            <li class="page-item <?= $nextButtonDisable ?>">
                <a class="page-link" href="<?= $nextHref ?>">Next</a>
            </li>
        </ul>
    </div>
</div>
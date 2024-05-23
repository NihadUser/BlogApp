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

$query = "SELECT id, title, description, image 
        FROM blogs
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

$query = $db->prepare(
    "SELECT c.id, count(c.id) AS countId, c.name AS catName, b.title AS blogName 
        FROM categories AS c
        LEFT JOIN blogs AS b
        ON b.category_id = c.id
        GROUP BY c.id
        "
);
$query->execute([]);
$categories = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="conatiner d-flex">
    <div class="col-3">
        <div class="container">
            <form action="" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" value="<?= get('searchTitle') ?>" name="searchTitle">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <?php
        foreach ($categories as $item):
            ?>
            <a style="color:black;text-decoration:none;margin-left:20px;"
                href="index.php?id=<?= $item['id'] ?>&searchTitle=<?= $_GET['searchTitle'] ?? '' ?>"
                class=" link-body-emphasis link-offset-2 link-underline-opacity-25 link-underline-opacity-75-hover">
                <?= $item['catName'] ?> (<?= $item['blogName'] == '' ? 0 : $item['countId'] ?>)</a><br>
            <?php
        endforeach;
        ?>
    </div>
    <div class="col-9">
        <div class="row d-flex gap-3">
            <?php
            foreach ($blogs as $item):
                ?>
                <div class="card" style="width: 18rem;">
                    <img src="<?= $item['image'] ?>" style="height: 200px;" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><a href="blogDetails.php?id=<?= $item['id'] ?>"><?= $item['title'] ?></a>
                        </h5>
                        <p class="card-text"><?= $item['description'] ?></p>
                        <a href="#" class="btn btn-primary">Details</a>
                    </div>
                </div>
                <?php
            endforeach;
            ?>
        </div>
        <?php
        if (count($blogs) >= $limit):
            ?>
            <div class="container">
                <?php
                $next = $page != $paginationCount ? $page + 1 : $page;
                $disableNextButton = $page == $paginationCount ? 'disabled' : '';

                $previous = $page != 1 ? $page - 1 : 1;
                $disablePrevButton = $page == 1 ? 'disabled' : '';
                ?>
                <ul class="pagination">
                    <li class="page-item <?= $disablePrevButton ?>">
                        <a class="page-link" href=<?= "http://localhost/Coders/PROJECT/client/blogs/?page=$previous" ?>
                            tabindex="-1">Previous</a>
                    </li>
                    <?php
                    for ($i = 1; $i <= $paginationCount; $i++):
                        ?>
                        <li class="page-item"><a class="page-link"
                                href=<?= "http://localhost/Coders/PROJECT/client/blogs/?page=$i" ?>><?= $i ?></a></li>
                        <?php
                    endfor;
                    ?>
                    <li class="page-item <?= $disableNextButton ?>">
                        <a class="page-link" href=<?= "http://localhost/Coders/PROJECT/client/blogs/?page=$next" ?>>Next</a>
                    </li>
                </ul>
            </div>
            <?php
        endif;
        ?>
    </div>
</div>



<div class="container d-flex">

    <!-- Pagination -->
    <?php if (count($blogs) >= $limit): ?>
        <div class="container">
            <!-- Pagination Links -->
        </div>
    <?php endif; ?>
</div>
</div>
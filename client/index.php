<?php
include "../parts/index.php";

$allCategoriesQuery = $db->prepare("SELECT COUNT(id) FROM categories");
$allCategoriesQuery->execute([]);
$allCategories = $allCategoriesQuery->fetch(PDO::FETCH_ASSOC);
// print_r($allCategories);
$allBlogsQuery = $db->prepare("SELECT COUNT(id) FROM blogs");
$allBlogsQuery->execute([]);
$allBlogs = $allBlogsQuery->fetch(PDO::FETCH_ASSOC);

$allViewsQuery = $db->prepare("SELECT sum(view) FROM blogs");
$allViewsQuery->execute([]);
$allViews = $allViewsQuery->fetch(PDO::FETCH_ASSOC);

$myViewsQuery = $db->prepare("SELECT sum(view) FROM blogs WHERE created_by = ?");
$myViewsQuery->execute([
    $_SESSION['userId']
]);
$myViews = $myViewsQuery->fetch(PDO::FETCH_ASSOC);

$thisMothBlogsQuery = $db->prepare("SELECT count(id) FROM blogs WHERE MONTH(created_at) = ?");
$thisMothBlogsQuery->execute([
    date('m')
]);
$thisMothBlogs = $thisMothBlogsQuery->fetch(PDO::FETCH_ASSOC);

$topThreeQuery = $db->prepare(
    "SELECT title from blogs order by view desc limit 3"
);
$topThreeQuery->execute([
]);
$topThreeBlog = $topThreeQuery->fetchAll(PDO::FETCH_ASSOC);

$topThreeMonthQuery = $db->prepare(
    "SELECT title from blogs where MONTH(created_at) = ? order by view desc limit 3 "
);
$topThreeMonthQuery->execute([
    date('m')
]);
$topThreeMonthBlog = $topThreeMonthQuery->fetchAll(PDO::FETCH_ASSOC);

$userBlogViewCount = $db->prepare(
    "SELECT u.full_name, b.view
    FROM users AS u
    JOIN blogs AS b
    ON b.created_by = u.id
    WHERE u.id = ?
    ORDER BY b.view DESC
    LIMIT 3
    "
);
$userBlogViewCount->execute([$_SESSION['userId']]);
$userBlogView = $userBlogViewCount->fetchAll(PDO::FETCH_ASSOC);

$countUserCategoryQuery = $db->prepare(
    "select count(u.id), u.full_name
    from users as u
    join categories as c
    on u.id = c.created_by
    group by u.id
    having u.id = ?
    "
)
    ?>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    Category count
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $allCategories['COUNT(id)'] ?></h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    Blog Count
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $allBlogs['COUNT(id)'] ?></h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    View Count
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $allViews['sum(view)'] ?></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    My blogs View Count
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $myViews['sum(view)'] ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    My Deactive Blog Count
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $thisMothBlogs['count(id)'] ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    This month blog count
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $thisMothBlogs['count(id)'] ?></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    TOP 3 Blog
                </div>
                <div class="card-body">
                    <?php
                    foreach ($topThreeBlog as $item):
                        ?>
                        <h5 class="card-title"><?= $item['title'] ?? '' ?></h5>
                        <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    TOP 3 Blog in this month
                </div>
                <div class="card-body">
                    <?php
                    foreach ($topThreeMonthBlog as $item):
                        ?>
                        <h5 class="card-title"><?= $item['title'] ?? '' ?></h5>
                        <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    Users blog view count
                </div>
                <div class="card-body">
                    <?php
                    foreach ($userBlogView as $item):
                        ?>
                        <h5><?= $item['full_name'] ?> : <?= $item['view'] ?></h5>
                        <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    Blog count by Categories
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    Blog count by Creator
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-4">

        </div>
        <div class="col-md-4">

        </div>
    </div>
</div>
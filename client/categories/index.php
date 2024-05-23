<?php
include "../../parts/index.php";

function sqlQuery()
{
    $sqlQuery = " WHERE";
    $arr = [];
    $isFilter = false;
    if (get("searchName") != null) {
        $query = " c.name LIKE  ?";
        $sqlQuery .= $query;
        $isFilter = true;
        $arr[] = '%' . get('searchName') . '%';
    }
    if (get("searchAuthor") != null) {
        $query = " u.full_name LIKE ? ";
        $sqlQuery .= !$isFilter ? $query : " and " . $query;
        $arr[] = '%' . get('searchAuthor') . '%';
        $isFilter = true;
    }
    $sqlQuery = !$isFilter ? "" : $sqlQuery;
    return [
        'query' => $sqlQuery,
        'execute' => $arr
    ];
}

$arr = sqlQuery();
$str = $arr['query'];

$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
$limit = 5;
$offset = ($page - 1) * $limit;

$query = "SELECT c.id as catId, c.name as catName,  c.created_at, u.full_name as userName, u.id as creatorId
    FROM categories AS c
    LEFT JOIN users as u
    ON u.id = c.created_by 
    $str
    ORDER BY c.id DESC
    LIMIT $limit OFFSET $offset
    ";
$query = $db->prepare($query);
$query->execute($arr['execute']);
$data = $query->fetchAll(PDO::FETCH_ASSOC);


$query = $db->prepare("SELECT COUNT(*) as total, u.full_name as userName, u.id as creatorId
    FROM categories AS c
    LEFT JOIN users as u
    ON u.id = c.created_by 
    $str
    ");
$query->execute($arr['execute']);
$count = $query->fetch(PDO::FETCH_ASSOC);
$totalPage = ceil($count['total'] / $limit);
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
                    <th scope="col">Category Name</th>
                    <th scope="col">Creator</th>
                    <th scope="col">Created_at</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($data as $item):
                    ?>
                    <tr>
                        <th scope="row"><?= $count++ ?></th>
                        <td><?= $item['catName'] ?></td>
                        <td><?= $item['userName'] ?></td>
                        <td><?= $item['created_at'] ?></td>
                        <?php
                        if (isset($_SESSION['userId'])):
                            ?>
                            <td>
                                <a <?php if ($_SESSION['userId'] == $item['creatorId'])
                                    echo "href='delete.php?id={$item['catId']}'";
                                ?> class="btn btn-danger danger">Delete</a>
                                <a class="btn btn-primary " <?php if ($_SESSION['userId'] == $item['creatorId']): ?>
                                        href="edit.php?id=<?= $item['catId'] ?> <?php endif; ?>">Edit</a>
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
            $href = $page == 1 ? '' : "http://localhost/Coders/PROJECT/client/categories/?page={$previous}&searchAuthor=$searchAuthor&searchName=$searchName";
            $previousButtonDisable = $page == 1 ? 'disabled' : "";

            $next = $page == $totalPage ? $totalPage : $page + 1;
            $nextHref = "http://localhost/Coders/PROJECT/client/categories/?page={$next}&&searchAuthor=$searchAuthor&searchName=$searchName";
            $nextButtonDisable = $page == $totalPage ? 'disabled' : '';
            ?>
            <li class="page-item <?= $previousButtonDisable ?>">
                <a class="page-link" href="<?= $href ?>">Previous</a>
            </li>

            <?php
            for ($i = 1; $i <= $totalPage; $i++) {
                ?>
                <li class="page-item"><a class="page-link"
                        href="<?= "http://localhost/Coders/PROJECT/client/categories/?page=$i&&searchAuthor=$searchAuthor&searchName=$searchName" ?>"><?php echo $i ?></a>
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
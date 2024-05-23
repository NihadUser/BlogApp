<?php
include "../../parts/index.php";

function sqlQuery()
{
    if (post('searchName') && post('searchAuthor') == null) {
        $query = "SELECT c.id as catId, c.name as catName, c.created_at, u.full_name as userName, u.id as creatorId
            FROM categories AS c
            JOIN users as u
            ON u.id = c.created_by 
            WHERE c.name LIKE " . " '%' ? '%' " . "
            ORDER BY c.id DESC 
         ";
        return [
            'query' => $query,
            'execute' => [post('searchName')]
        ];
    } elseif (post('searchAuthor') && post('searchName') == null) {
        $query = "SELECT c.id as catId, c.name as catName, c.created_at, u.full_name as userName, u.id as creatorId
        FROM categories AS c
        JOIN users as u
        ON u.id = c.created_by 
        WHERE u.full_name LIKE " . " '%' ? '%' " . "
        ORDER BY c.id DESC
        ";
        return [
            'query' => $query,
            'execute' => [post('searchAuthor')]
        ];
    } elseif (post('searchAuthor') && post('searchName')) {
        $query = "SELECT c.id as catId, c.name as catName, c.created_at, u.full_name as userName, u.id as creatorId
        FROM categories AS c
        JOIN users as u
        ON u.id = c.created_by 
        WHERE u.full_name LIKE " . " '%' ? '%' " . " AND c.name LIKE " . " '%' ? '%' " . "
        ORDER BY c.id DESC
        ";
        return [
            'query' => $query,
            'execute' => [post('searchAuthor'), post('searchName')]
        ];
    } else {
        $query = "SELECT c.id as catId, c.name as catName, c.created_at, u.full_name as userName, u.id as creatorId
            FROM categories AS c
            JOIN users as u
            ON u.id = c.created_by 
            ORDER BY c.id DESC
        ";
        return [
            'query' => $query,
            'execute' => []
        ];
    }
}

$arr = sqlQuery();
$query = $db->prepare($arr['query']);
$query->execute($arr['execute']);
$data = $query->fetchAll(PDO::FETCH_ASSOC);


?>
<div class="container">
    <form action="" method="POST">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <input type="text" name="searchName" class="form-control">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <input type="text" name="searchAuthor" class="form-control">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <!-- <button>
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button> -->
                    <input type="submit" name="searchBtn" class="btn btn-primary" value="Search">
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
                        <td>
                            <a <?php if ($_SESSION['userId'] == $item['creatorId']) {
                                echo "href='delete.php?id={$item['catId']}'";
                            } ?> class="btn btn-danger danger">Delete</a>
                            <a class="btn btn-primary" href="edit.php?id=<?= $item['catId'] ?>">Edit</a>
                        </td>
                    </tr>
                    <?php
                endforeach;
                ?>
            </tbody>
        </table>
        <!-- </div> -->
    </div>
</div>
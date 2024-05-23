<?php
include "../../parts/index.php";
if (isset($_GET['id'])) {
    $query = $db->prepare("DELETE FROM categories WHERE id = ?");
    $isDelte = $query->execute([
        $_GET['id']
    ]);
    if ($isDelte) {
        header('location: index.php');
    }
}
// function deleteItem($tableName, $id, $db)
// {
//     $query = $db->prepare("DELETE FROM $tableName WHERE id = ?");
//     $isDelete = $query->execute([$id]);
//     if ($isDelete) {
//         return header("Location: http://localhost/Coders/PROJECT/client/categories/index.php");
//     }
// }
?>
<?php
include "../parts/index.php";

$query = $db->prepare("DELETE FROM categories WHERE created_by = ?");
$query->execute([$_SESSION['userId']]);
header('location: userPage.php');
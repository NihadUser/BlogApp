<?php
function post($key)
{
    return $_POST[$key] ?? null;
}
function get($key)
{
    return $_GET[$key] ?? null;
}
function findUser($userId, $db)
{
    $query = $db->prepare("SELECT * FROM users WHERE id = ?");
    $query->execute([
        $userId
    ]);
    $userName = $query->fetch(PDO::FETCH_ASSOC);
    return $userName ?? null;
}
function loginMiddleware()
{
    if (isset($_SESSION['role']) && ($_SERVER['REQUEST_URI'] == '/Coders/PROJECT/auth/login.php' || $_SERVER['REQUEST_URI'] == '/Coders/PROJECT/auth/register.php')) {
        $route = $_SESSION['role'] == 'admin' ? '../admin/index.php' : '../client/index.php';
        return header("location: $route");

    } elseif (!isset($_SESSION['role']) && $_SERVER['REQUEST_URI'] == '/Coders/PROJECT/client/index.php') {
        return header("location: ../auth/login.php");
    }
    // return null;
    // $db = sqlConnection();
    // $query = $db->prepare("SELECT full_name FROM users WHERE id = ?");
    // $query->execute([
    //     $userId
    // ]);
    // $user = $query->fetch(PDO::FETCH_ASSOC);
    // if ($user['role'] == 'admin') {
    //     return header('location: ../admin/index.php');
    // } else {
    //     return header('location: ../client/index.php');
    // }
}
loginMiddleware();
function imageUpload($file, $folder)
{
    // $nameArr = explode(".", $file['name']);
    // $extension = end($nameArr);
    $newFileName = "imgs/{$folder}/" . uniqid() . basename($file['name']);

    $check = getimagesize($file['tmp_name']);
    if ($check == false) {
        return [
            'response' => false,
            'message' => 'Photo input is not image!'
        ];
    }

    if ($file['size'] > 5000000) {
        return [
            'response' => false,
            'message' => 'File is too large'
        ];
    }

    $imageArr = explode(".", $file['name']);
    $imageFileType = end($imageArr);
    if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg') {
        return [
            'response' => false,
            'message' => 'Only JPG, PNG, JPEG files are allowed!'
        ];
    }

    $root = $_SERVER['REQUEST_URI'] == "/Coders/PROJECT/client/blogs/add.php" ? '../../' : "../";

    move_uploaded_file($file['tmp_name'], $root . $newFileName);
    return "http://localhost/Coders/PROJECT/" . $newFileName;
}
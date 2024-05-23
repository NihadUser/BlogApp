<?php
include "../parts/index.php";
function checkLogin($db)
{
    if (post("email") == null) {
        return [
            'response' => false,
            'message' => "Email can not be empty",
        ];
    } else if (post("password") == null) {
        return [
            'response' => false,
            'message' => "Password can not be empty",
        ];
    }

    $query = $db->prepare("SELECT * FROM users where email = ?");
    $query->execute([
        post('email')
    ]);

    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user == null) {
        return [
            'response' => false,
            'message' => "User not found",
        ];
    } elseif (!password_verify(post('password'), $user['password'])) {
        return [
            'response' => false,
            'message' => "Please enter valid email or password",
        ];
    }

    $_SESSION['userName'] = $user['full_name'];
    $_SESSION['userId'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['userImg'] = $user['image'];

    $route = $user['role'] == 'admin' ? '../admin/index.php' : '../client/index.php';
    header("location: $route");

    // elseif ($user['role'] == 'admin') {
    //     $_SESSION['user'] = $user['id'];

    //     header('location: ../admin/index.php');
    // } elseif ($user['role'] == 'user') {
    //     $_SESSION['user'] = $user['id'];
    //     header('location: ../client/index.php');
    // }
}

if (post('loginSubmit')) {
    $login = checkLogin($db);
    if ($login['response'] == false) {
        echo "<div class='alert alert-danger'>{$login['message']}</div>";
    }
}
?>
<div class="container" style="width: 40%;">
    <form action="" method="POST">
        <h3>Login</h3>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>

        <br>

        <input type="submit" class="btn btn-primary" name="loginSubmit" value="Login">
    </form>
</div>
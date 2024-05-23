<?php
include "../parts/index.php";

$user = findUser($_SESSION['userId'], $db);

$query = $db->prepare("SELECT * FROM categories WHERE created_by = ?");
$query->execute([$_SESSION['userId']]);
$categories = $query->fetchAll(PDO::FETCH_ASSOC);
function validate()
{
    if (post('fullname') == null) {
        return [
            'response' => false,
            'message' => "Name input cannot be empty"
        ];
    } elseif (strlen(post('email')) == 0 && post('email') == null) {
        return [
            'response' => false,
            'message' => "Email input cannot be empty"
        ];
    } elseif (!filter_var(post('email'), FILTER_VALIDATE_EMAIL)) {
        return [
            'response' => false,
            'message' => "Invalid email"
        ];
    }
    if (post('password') != null || post('password_verify') != null) {
        if (strlen(post('password')) < 5) {
            return [
                'response' => false,
                'message' => "Plase Enter Long password"
            ];
        } else if (post('password') != post('password_verify')) {
            return [
                'response' => false,
                'message' => "Password fields doesnt match!"
            ];
        }
    }

    return [
        'response' => true,
        'message' => "Ok."
    ];

}
function updateUser($db, $user)
{
    $validate = validate();
    if ($validate['response'] == false) {
        return [
            'response' => false,
            'message' => $validate['message']
        ];
    }

    $query = $db->prepare(
        "SELECT id, email FROM users WHERE email = ? and id != ?"
    );
    $query->execute([post('email'), $_SESSION['userId']]);
    $checkUser = $query->fetch(PDO::FETCH_ASSOC);

    if ($checkUser != null) {
        return [
            'response' => false,
            'message' => "User has already exists"
        ];
    }

    
    // exit;
    $executeArr = [
        post('fullname'),
        post('email'),
        post('password') != null ? password_hash(post('password'), PASSWORD_DEFAULT) : $user['password'],
        post('birth'),
        post('gender'),
        $_FILES['image']['name'] != null ? imageUpload($_FILES['image'], "userProfiles") : $user['image'],
        $_SESSION['userId']
    ];
    $query = $db->prepare(
        "UPDATE users SET full_name = ?, email = ?, password = ?, birth = ?, gender = ?, image = ? WHERE id = ?"
    );
    $query->execute($executeArr);

    return [
        'response' => true,
        'message' => "salam"
    ];
}

if (post('submitBtn')) {
    // print_r($user);
    $update = updateUser($db, $user);

    $user = findUser($_SESSION['userId'], $db);
    $_SESSION['userName'] = $user['full_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['userImg'] = $user['image'];


    $alert = $update['response'] == true ? 'success' : 'danger';
    echo "<div class='alert alert-{$alert}'>{$update['message']}</div>";
    // header("refresh:1;url=" . $_SERVER['PHP_SELF']);
}


echo $user['password'];


?>
<div class="container">
    <h2>User Update</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fullname">Full Name:</label>
            <input type="text" class="form-control" id="fullname" value="<?= $user['full_name'] ?>" name="fullname"
                placeholder="Enter full name">
        </div>
        <div class="form-group">
            <label for="birth">Date of Birth:</label>
            <input type="date" class="form-control" id="birth" value="<?= $user['birth'] ?>" name="birth">
        </div>
        <div class="form-group">
            <label>Gender:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender"
                    <?php echo $user['gender'] == 0 ? "checked" : '' ?> id="male" value="male">
                <label class="form-check-label" for="male">Male</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" <?php echo $user['gender'] == 1 ? "checked" : '' ?> type="radio"
                    name="gender" id="female" value="female">
                <label class="form-check-label" for="female">Female</label>
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" value="<?= $user['email'] ?>" name="email"
                placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
        </div>
        <div class="form-group">
            <label for="password_verify">Confirm Password:</label>
            <input type="password" class="form-control" id="password_verify" name="password_verify"
                placeholder="Confirm password">
        </div>
        <div class="form-group">
            <label for="image">Profile Picture:</label>
            <input type="file" class="form-control" id="image" name="image">
        </div><br>
        <input type="submit" value="Update" name="submitBtn" class="btn btn-primary">
    </form>
    <h1>Categories</h1>
    <?php
    foreach ($categories as $c):
        ?>
    <li><?= $c['name'] ?></li>
    <?php
    endforeach;
    ?>
    <a href="clearCategories.php" class="btn btn-danger">Clear all</a>
</div>
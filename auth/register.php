<?php
include "../parts/index.php";
// loginMiddleware();
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function validate()
{
    $name = explode(" ", post('fullname'));
    $fName = $name[0] ?? '';
    $sName = $name[1] ?? '';
    $file = $_FILES['image']['name'] != null ? imageUpload($_FILES['image'], 'userProfiles') : "https://ui-avatars.com/api/?name={$fName}+{$sName}";

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
    } else if (strlen(post('password')) < 5) {
        return [
            'response' => false,
            'message' => "Plase Enter Long password"
        ];
    } elseif (!filter_var(post('email'), FILTER_VALIDATE_EMAIL)) {
        return [
            'response' => false,
            'message' => "Invalid email"
        ];
    } else if (post('password') != post('password_verify')) {
        return [
            'response' => false,
            'message' => "Password fields doesnt match!"
        ];
    } else {
        return [
            'response' => true,
            'data' => [
                test_input(post('fullname')),
                password_hash(test_input(post('password')), PASSWORD_DEFAULT),
                test_input(post('birth')),
                test_input(post('gender')),
                test_input(post('email')),
                $file
            ]
        ];
    }
}
function insertDb($db)
{
    $query = $db->prepare("SELECT count(id) as countid FROM users WHERE email = ?");
    $query->execute([post('email')]);
    $userCount = $query->fetch(PDO::FETCH_ASSOC);
    $validate = validate();
    print_r($userCount);
    print_r($validate);
    if ($validate['response'] == false) {
        $message = $validate['message'];
        return $message;
    } elseif ($userCount['countid'] != 0) {
        $message = "User has already exsist!";
        return $message;
    }

    $query = $db->prepare("INSERT INTO users(full_name, password, birth, gender, email, image) VALUES (?, ?, ?, ?, ?, ?)");
    $insert = $query->execute(
        $validate['data']
    );
    if ($insert) {
        header("location: login.php");
    }


}

if (post('registerSubmit')) {
    $response = insertDb($db);
    if (isset($response)) {
        echo "
        <div class='alert alert-danger'>{$response}</div>
        ";
    }
}


?>
<div class="container">
    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Register</h3>

        <div class="form-group">
            <label for="fullname">Name Surname</label>
            <input type="text" id="fullname" name="fullname" class="form-control">
        </div>

        <div class="form-group">
            <label for="birth">Birth</label>
            <input type="date" id="birth" name="birth" class="form-control">
        </div>

        <label for="cins">Cins</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="cins" id="man" value="1">
            <label class="form-check-label" for="man">
                Male
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="cins" id="woman" value="2">
            <label class="form-check-label" for="woman">
                Female
            </label>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="password_verify">Password Verify</label>
            <input type="password" id="password_verify" name="password_verify" class="form-control">
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>

        <br>

        <input type="submit" class="btn btn-primary" name="registerSubmit" value="Register">
    </form>
</div>
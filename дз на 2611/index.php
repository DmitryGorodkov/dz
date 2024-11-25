<?php
$errors = array();
$data = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $errors[] = "Имя пользователя обязательно.";
    } else {
        $data['username'] = htmlspecialchars($_POST["username"]);
    }

    if (empty($_POST["email"])) {
        $errors[] = "Email обязателен.";
    } else {
        $data['email'] = htmlspecialchars($_POST["email"]);
    }

    if (empty($_POST["password"])) {
        $errors[] = "Пароль обязателен.";
    } else {
        $data['password'] = htmlspecialchars($_POST["password"]);
    }

    if (isset($_POST["gender"])) {
        $data['gender'] = htmlspecialchars($_POST["gender"]);
    } else {
        $errors[] = "Пол обязателен.";
    }

    if (!empty($_POST["favoriteNumber"])) {
        $data['favoriteNumber'] = htmlspecialchars($_POST["favoriteNumber"]); // Сохраняем возраст
    }else {
      $errors[] = "Любимое число обязательно.";
  }

    if (isset($_POST["terms"])) {
        $data['terms'] = true;
    } else {
        $errors[] = "Вы должны согласиться с условиями.";
    }

    if (empty($errors)) {
        $data['created_at'] = date("Y-m-d H:i:s");
        $json_data = json_encode($data);
        $filename = "registration_" . time() . ".json";
        
        file_put_contents($filename, $json_data);

        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Type: application/json');
        readfile($filename);
        unlink($filename);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма регистрации</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            margin-top: 10px;
            display: block;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Регистрация</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <label for="username">Имя пользователя:</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required>

            <label>Пол:</label>
            <input type="radio" name="gender" value="male" required> Мужчина
            <input type="radio" name="gender" value="female"> Женщина<br>

            <label for="favoriteNumber">Любимое число:</label>
            <input type="number" name="favoriteNumber" id="favoriteNumber">

            <label for="country">Страна:</label>
            <select name="country" id="country">
                <option value="ru">Россия</option>
                <option value="us">США</option>
                <option value="fr">Франция</option>
            </select>

            <label>
                <input type="checkbox" name="terms"> Я согласен с условиями
            </label>

            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>
</body>
</html>
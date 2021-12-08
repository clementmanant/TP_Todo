<?php session_start(); 
$databaseHost = 'localhost';
$databasePort = '3306';
$databaseDbname = 'ToDo';
$databaseUser = 'root';
$databasePassword = '';
$databaseCharset = 'UTF8';

try {
    $pdo = new PDO(
        'mysql:host=' . $databaseHost . 
        ';port=' . $databasePort . 
        ';dbname=' . $databaseDbname . 
        ';charset=' . $databaseCharset, 
        $databaseUser,
        $databasePassword
    );

} catch (PDOException $exception) {
    echo $exception->getMessage();
    die();
}

?>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="./style.css">
    </head>
    <body>
    <h1>ToDo</h1>
    <a href="/login.php">Se connecter</a>
    <div>
        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_POST['username'];
                $password = hash('sha512', $_POST['password'], false);
                $confirm = hash('sha512', $_POST['confirm'], false);
                $queryString = "INSERT INTO users(Username, Password) VALUES(:username, :password)";
                $datas = [
                    'username' => $username,
                    'password' => $password
                ]; 
                if (isset($_POST['login']) && $password === $confirm) {
                    $query = $pdo->prepare($queryString);
                    $query->execute($datas);
                    $_SESSION['username'] = htmlspecialchars($_POST['username']);
                    $_SESSION['connected'] = true;
                    header('Location: todo.php');
                } else {
                    echo ("Inscription incorrecte.");
                }
            }
        ?>
    </div>
    <div id="form">
            <form method="post">
                <div id="label">
                <label for="username">
                    Nom d'utilisateur :
                    <input type="text" name="username" placeholder="Username" required autofocus>
                </label>
                </div>
                <br />
                <div id="label">
                <label for="password">
                    Mot de passe :
                    <input type="password" name="password" placeholder="Password" required>
                </label>
                </div>
                <br />
                <div id="label">
                <label for="confirm">
                    Confirmer le mot de passe :
                    <input type="password" name="confirm" placeholder="Password" required>
                </label>
                </div>
                <br />
                <button type="submit" name="login">S'incrire</button>
            </form>
        </div>
    </body>
</html>
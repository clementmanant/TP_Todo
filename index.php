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
        <title>ToDo</title>
        <link rel="stylesheet" href="./style.css">
    </head>
    <body>
        
    <div>
        <?php
            $username = $_POST['username'] ?? "";
            $query = "SELECT Password FROM users WHERE Username = \"$username\"";
            $results = $pdo->prepare($query);
            $results->execute();

            $pass = $results->fetch(PDO::FETCH_ASSOC);

            if (
                isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])
                && $pass['Password'] === hash('sha512', $_POST['password'], false)
            ) {
                $_SESSION['username'] = htmlspecialchars($_POST['username']);
                $_SESSION['connected'] = true;
            }
        ?>
    </div>

    <?php if (!isset($_SESSION['connected']) || !$_SESSION['connected']) { ?>
        <?php include './login.php'; ?>
    <?php } else { ?>
        <?= header('Location: todo.php'); ?>
    <?php } ?>
    
</body>
</html>
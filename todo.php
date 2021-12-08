<?php require_once 'checkConnection.php';
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

function create_todo(string $todo, int $id, PDO $pdo) {
    $queryString = "INSERT INTO todos(Description, User_id) VALUES(:todo, :id)";
    $datas = [
        'todo' => $todo,
        'id' => $id
    ];
    $query = $pdo->prepare($queryString);
    $query->execute($datas);
}

$todo = $_POST['create_todo'] ?? "";
$username = ($_SESSION['username']);
$query = "SELECT Id FROM users WHERE Username = \"$username\"";
$results = $pdo->prepare($query);
$results->execute();
$id = $results->fetch(PDO::FETCH_ASSOC);
$user_id = $id['Id'];

if(array_key_exists('create_button', $_POST)) {
    create_todo($todo, $user_id, $pdo);
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
    <h1>ToDo</h1>
    <a href="/logout.php">Se déconnecter</a></br>
    <div id="form">
            <form method="post">
                <div id="label">
                    <label for="create_todo">
                        Write ToDo : 
                        <input type="text" name="create_todo" required>
                    </label>
                </div>
                <br />
                <button type="submit" id="create_button" name="create_button">Create ToDo</button>
            </form>
        </div>
        <div>
            <?php 

            function check_todo(int $id, int $check, PDO $pdo) {
                $queryString = "UPDATE todos SET todos.Check = :checked WHERE Id = :id";
                $datas = [
                    'checked' => $check,
                    'id' => $id
                ];
                $query = $pdo->prepare($queryString);
                $query->execute($datas);
                header("Refresh:0");
            }

            function delete_todo(int $id, PDO $pdo) {
                $queryString = "DELETE FROM todos WHERE Id = :id";
                $datas = [
                    'id' => $id
                ];
                $query = $pdo->prepare($queryString);
                $query->execute($datas);
                header("Refresh:0");
            }

            $query = "SELECT * FROM todos WHERE User_id = \"$user_id\"";

            $results = $pdo->prepare($query);
            $results->execute();

            $user_todos = $results->fetchAll(PDO::FETCH_ASSOC);

            foreach ($user_todos as $user_todo) { ?>
                <div id="one_todo">
                    <p>
                        <form method="post">
                            <button type="submit" id="check" name="check_button<?=$user_todo['Id']?>">Check</button>
                            <button type="submit" id="delete" name="delete_button<?=$user_todo['Id']?>">Delete</button></br>
                        
                        <?php if ($user_todo['Check']) { ?>
                            Check ! - 
                        <?php } ?>
                            To Do : <?= $user_todo['Description'] ?>
                        </form>
                    </p>
                </div>
                
            <?php } ?>
            <?php 
            for ($i = 0; $i < sizeof($user_todos); $i++) {
                if(array_key_exists('check_button'.$user_todos[$i]['Id'], $_POST)) {
                    $user_todos[$i]['Check'] = !$user_todos[$i]['Check'];
                    check_todo($user_todos[$i]['Id'], $user_todos[$i]['Check'], $pdo);
                }
            }

            for ($i = 0; $i < sizeof($user_todos); $i++) {
                if(array_key_exists('delete_button'.$user_todos[$i]['Id'], $_POST)) {
                    $user_todos[$i]['Check'] = !$user_todos[$i]['Check'];
                    delete_todo($user_todos[$i]['Id'], $pdo);
                }
            }
            ?>
        </div>
    </body>
</html>

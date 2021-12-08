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
    <a href="/inscription.php">S'inscrire</a>
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
                <button type="submit" name="login">Connexion</button>
            </form>
        </div>
    </body>
</html>
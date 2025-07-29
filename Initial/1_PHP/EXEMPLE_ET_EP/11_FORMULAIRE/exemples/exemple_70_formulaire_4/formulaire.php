<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemple 70</title>
    <style>
        input {
            border : 1px solid;
            display: block;
            width: 10%;
            margin: 10px 0px;
        }
    </style>
</head>
<body>
    <form action="./traitement.php" method="POST">
        <input type="text" name="text_input">
        <input type="checkbox" name="check_box">
        <input type="date" name="date_input">
        <input type="email" name="email_input">
        <input type="file" name="file_input">
        <input type="radio" name="radio_input">
        <input type="color" name="color_input">
        <input type="submit" value="Envoyer">
    </form>
</body>
</html>

<?php
require 'includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
    $time = htmlspecialchars(trim($_POST['time']), ENT_QUOTES, 'UTF-8');
    $date = htmlspecialchars(trim($_POST['date']), ENT_QUOTES, 'UTF-8');
    $attendant = htmlspecialchars(trim($_POST['attendant']), ENT_QUOTES, 'UTF-8');

    $stmt = $pdo->prepare("INSERT INTO appointments (name, time, date, attendant) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $time, $date, $attendant]);

    header("Location: appointments.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Agendar Compromisso</title>
</head>

<body>
    <h1>Agendar</h1>
    <form method="POST">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" required>

        <label for="time">Hora:</label>
        <input type="time" id="time" name="time" required>

        <label for="date">Data:</label>
        <input type="date" id="date" name="date" required>

        <label for="attendant">Atendente:</label>
        <input type="text" id="attendant" name="attendant" required>

        <button type="submit">Agendar</button>
        <a href="appointments.php">
            <button type="button">Ver Agendados</button>
        </a>
    </form>

</body>

</html>

<?php
require 'includes/database.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
       
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_SPECIAL_CHARS);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
        $attendant = filter_input(INPUT_POST, 'attendant', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

     
        if (!$name || !$time || !$date || !$attendant) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        $stmt = $pdo->prepare("INSERT INTO appointments (name, time, date, attendant) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $time, $date, $attendant]);

        header("Location: appointments.php");
        exit();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
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

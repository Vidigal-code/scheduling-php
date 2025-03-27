<?php
require 'includes/database.php';

$error_message = '';

try {
  
    if (isset($_GET['delete'])) {
        $idToDelete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);

        if (!$idToDelete) {
            throw new Exception("ID inválido.");
        }

        $deleteStmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
        $deleteStmt->execute([$idToDelete]);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $stmt = $pdo->prepare("SELECT * FROM appointments WHERE name LIKE ? OR attendant LIKE ?");
    $stmt->execute(["%$search%", "%$search%"]);
    
    $appointments = $stmt->fetchAll();

} catch (Exception $e) {
    $error_message = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Agendamentos</title>
</head>

<body>
    <h1>Agendamentos</h1>

    <form method="GET" style="margin-bottom: 20px;">
        <input type="text" name="search" value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
            placeholder="Buscar por Nome ou Atendente" required>
        <button type="submit">Buscar</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Hora</th>
            <th>Data</th>
            <th>Atendente</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($appointments as $appointment): ?>
        <tr>
            <td><?= htmlspecialchars($appointment['id'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($appointment['name'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($appointment['time'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($appointment['date'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($appointment['attendant'], ENT_QUOTES, 'UTF-8') ?></td>
            <td>
                <a href="?delete=<?= urlencode($appointment['id']) ?>"
                    onclick="return confirm('Tem certeza que deseja deletar este compromisso?');">
                    <button type="button">Deletar</button>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php">
        <button type="button">Voltar</button>
    </a>
</body>

</html>

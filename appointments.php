<?php
require 'includes/database.php';

if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    $deleteStmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
    $deleteStmt->execute([$idToDelete]);
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit();
}

$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $stmt = $pdo->prepare("SELECT * FROM appointments WHERE name LIKE ? OR attendant LIKE ?");
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM appointments");
}

$appointments = $stmt->fetchAll();
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
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
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
            <td><?= htmlspecialchars($appointment['id']) ?></td>
            <td><?= htmlspecialchars($appointment['name']) ?></td>
            <td><?= htmlspecialchars($appointment['time']) ?></td>
            <td><?= htmlspecialchars($appointment['date']) ?></td>
            <td><?= htmlspecialchars($appointment['attendant']) ?></td>
            <td>
                <a href="?delete=<?= $appointment['id'] ?>"
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
<?php
require 'connexion.php';

// Si le formulaire est soumis, on ajoute un employé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $poste = $_POST['poste'];
    $salaire = $_POST['salaire'];

    $stmt = $pdo->prepare("INSERT INTO employes (nom, poste, salaire) VALUES (?, ?, ?)");
    $stmt->execute([$nom, $poste, $salaire]);
    header("Location: index.php"); // rafraîchit
    exit;
}

// Lister les employés
$stmt = $pdo->query("SELECT * FROM employes ORDER BY id DESC");
$employes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Gestion des Employés</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
  <h1 class="mb-4">Gestion des Employés</h1>

  <!-- Formulaire d'ajout -->
  <div class="card p-3 mb-4">
    <h4>Ajouter un Employé</h4>
    <form method="POST">
      <div class="mb-2">
        <label>Nom</label>
        <input class="form-control" name="nom" required>
      </div>
      <div class="mb-2">
        <label>Poste</label>
        <input class="form-control" name="poste" required>
      </div>
      <div class="mb-2">
        <label>Salaire</label>
        <input class="form-control" name="salaire" required>
      </div>
      <button class="btn btn-primary">Ajouter</button>
    </form>
  </div>

  <!-- Liste des employés -->
  <h3>Liste des Employés</h3>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Poste</th>
        <th>Salaire</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($employes as $e): ?>
        <tr>
          <td><?= $e['id'] ?></td>
          <td><?= htmlspecialchars($e['nom']) ?></td>
          <td><?= htmlspecialchars($e['poste']) ?></td>
          <td><?= $e['salaire'] ?> €</td>
          <td>
            <a href="modifier.php?id=<?= $e['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="supprimer.php?id=<?= $e['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet employé ?')">Supprimer</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>

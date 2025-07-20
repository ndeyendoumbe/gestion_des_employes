<?php
require 'connexion.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID manquant");
}

// Charger l'employé
$stmt = $pdo->prepare("SELECT * FROM employes WHERE id=?");
$stmt->execute([$id]);
$emp = $stmt->fetch();

if (!$emp) {
    die("Employé introuvable");
}

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $poste = $_POST['poste'];
    $salaire = $_POST['salaire'];

    $update = $pdo->prepare("UPDATE employes SET nom=?, poste=?, salaire=? WHERE id=?");
    $update->execute([$nom, $poste, $salaire, $id]);
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Modifier Employé</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
  <h1>Modifier Employé</h1>
  <form method="POST">
    <div class="mb-2">
      <label>Nom</label>
      <input class="form-control" name="nom" value="<?= htmlspecialchars($emp['nom']) ?>" required>
    </div>
    <div class="mb-2">
      <label>Poste</label>
      <input class="form-control" name="poste" value="<?= htmlspecialchars($emp['poste']) ?>" required>
    </div>
    <div class="mb-2">
      <label>Salaire</label>
      <input class="form-control" name="salaire" value="<?= $emp['salaire'] ?>" required>
    </div>
    <button class="btn btn-success">Enregistrer</button>
    <a href="index.php" class="btn btn-secondary">Annuler</a>
  </form>
</body>
</html>

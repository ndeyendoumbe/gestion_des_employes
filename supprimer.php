<?php
require 'connexion.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM employes WHERE id=?");
    $stmt->execute([$id]);
}
header("Location: index.php");

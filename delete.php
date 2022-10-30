<?php
include './configuration/database.php';
$id = $_POST['id'] ?? null;


//  echo "<pre>";
//  var_dump($id);
//  echo "</pre>";

$statement = $pdo->prepare("DELETE FROM contacts WHERE id = :id");
$statement->bindValue(':id', $id);
$statement->execute();

header('Location: index.php');
exit;

if (!$id) {
    header("Location: index.php");
    exit;
}

<?php include './configuration/database.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$statement = $pdo->prepare("SELECT * FROM contacts WHERE id = :id");
$statement->bindValue(':id', $id);
$statement->execute();
$contact = $statement->fetch(PDO::FETCH_ASSOC);

$first_name = $contact['first_name'];
$last_name = $contact['last_name'];
$email = $contact['email'];
$phone = $contact['phone_number'];
$image = $contact['image'];
?>
<h1> <strong><em><?php echo $contact['first_name'] . ' ' . $contact['last_name'] ?></em></strong></h1>
<div class="container d-flex justify-content-center">
    <div class="row">
        <?php if ($contact['image']) { ?>
            <img src="<?php echo $contact['image'] ?>" width="100">
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-sm"><?php echo $contact['first_name'] ?></div>
        <div class="col-sm"><?php echo $contact['last_name'] ?></div>
    </div>
</div>


<div class="mt-2 d-flex justify-content-end">
    <a href="index.php">Back to All Contacts</a>
</div>
<?php require './partials/footer.php' ?>
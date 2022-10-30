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
<?php require './partials/header.php' ?>

<h1 class="mx-auto d-flex justify-content-center"> <strong><em><?php echo $first_name . ' ' . $last_name ?></em></strong></h1>
<div class="container d-flex justify-content-center">
    <div class="card" style="width: 18rem;">
        <div class="row">
            <?php if ($contact['image']) { ?>
                <img src="<?php echo $contact['image'] ?>" width="100">
            <?php } ?>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm d-flex justify-content-between">
                    <div class="col-3">Name: </div>
                    <div class="col-9"><strong><?php echo $first_name . ' ' . $last_name  ?></strong></div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm d-flex justify-content-between">
                    <div class="col-3">Phone: </div>
                    <div class="col-9"><strong><?php echo $phone ?></strong></div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm d-flex justify-content-between">
                    <div class="col-3">Email: </div>
                    <div class="col-9"><strong><?php echo $email ?></strong></div>

                </div>
            </div>
            <div class="d-flex justify-content-between mt-2">
                <a href="index.php" class="btn btn-sm btn-secondary">Back to All Contacts</a>
                <a href="update.php?id=<?php echo $contact['id'] ?>" type="button" class="btn btn-sm btn-primary" style="display:inline-block">Edit</a>
            </div>
        </div>
    </div>
</div>


<?php require './partials/footer.php' ?>
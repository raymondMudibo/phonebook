<?php include './configuration/database.php';

$statement = $pdo->prepare('SELECT * FROM contacts ORDER BY created_at DESC');
$statement->execute();
$contacts = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<?php require './partials/header.php' ?>


<h1>Contacts</h1>

<p>
    <a class="btn btn-success" href="create.php">Create Contact</a>
</p>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone Number</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contacts as $i => $contact) { ?>

            <tr>
                <th scope="row"><?php echo $i + 1 ?></th>
                <td>
                    <img src="<?php echo $contact['image'] ?>" height="50" width="50" />
                </td>
                <td><?php echo $contact['first_name'] ?></td>
                <td><?php echo $contact['last_name'] ?></td>
                <td><?php echo $contact['email'] ?></td>
                <td><?php echo $contact['phone_number'] ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary">Edit</button>

                    <form method="post" action="delete.php" style="display:inline-block">
                        <input type="hidden" name="cid" value="<?php echo $contact['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>

        <?php } ?>
    </tbody>
</table>


<?php require './partials/footer.php' ?>
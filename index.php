<?php include './configuration/database.php';

$search = $_GET['search'] ?? '';
if ($search) {
    $statement = $pdo->prepare('SELECT * FROM contacts WHERE first_name LIKE :search OR last_name LIKE :search 
                                    OR email LIKE :search OR phone_number LIKE :search ORDER BY created_at DESC');
    $statement->bindValue(':search', "%$search%");
} else {

    $statement = $pdo->prepare('SELECT * FROM contacts ORDER BY created_at DESC');
}
$statement->execute();
$contacts = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<?php require './partials/header.php' ?>


<h1>Contacts</h1>

<p>
    <a class="btn btn-success" href="create.php">Create Contact</a>
</p>
<form>
    <div class="input-group mb-3 row ">
        <div class="col-md-4 d-flex justify-content-end">
            <input type="text" class="form-control" placeholder="Search For Contacts" name="search" value="<?php echo $search ?>">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </div>
    </div>
</form>

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
                    <a href="update.php?id=<?php echo $contact['id'] ?>" type="button" class="btn btn-sm btn-primary">Edit</a>

                    <form method="post" action="delete.php" style="display:inline-block">
                        <input type="hidden" name="id" value="<?php echo $contact['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            https://raymondMudibo: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@github.com/raymondMudibo/phonebook.gitgit 
        <?php } ?>
    </tbody>
</table>


<?php require './partials/footer.php' ?>
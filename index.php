<?php include './configuration/database.php';

if (isset($_POST['multiple_delete'])) {
    if (isset($_POST['deleteId'])) {
        foreach ($_POST['deleteId'] as $id) {
            $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = :id');
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        }
    }
}


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

<form action="index.php" method="post">
    <button type="submit" class="btn btn-sm btn-danger" name="multiple_delete" onclick="return confirm('Are you sure?')">
        Delete
    </button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col" class="d-flex justify-content-center">
                    <input type="checkbox" id="checkBoxAll" />
                </th>
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
                    <!-- <td class="d-flex justify-content-center">
                        <input type="checkbox" name="deleteId[]" value="">
                    </td> -->
                    <!-- <td><input type="checkbox" class="chkCheckBoxId" value="<?php echo $account->username; ?>" name="username[]" /></td> -->
                    <td><input type="checkbox" class="chkCheckBoxId" value="<?php echo $contact['id'] ?>" name="deleteId[]" /></td>
                    <th scope="row"><?php echo $i + 1 ?></th>
                    <td>
                        <img src="<?php echo $contact['image'] ?>" height="50" width="50" />
                    </td>
                    <td><?php echo $contact['first_name'] ?></td>
                    <td><?php echo $contact['last_name'] ?></td>
                    <td><?php echo $contact['email'] ?></td>
                    <td><?php echo $contact['phone_number'] ?></td>
                    <td>
                        <a href="view.php?id=<?php echo $contact['id'] ?>" type="button" class="btn btn-sm btn-warning">view</a>
                        <a href="update.php?id=<?php echo $contact['id'] ?>" type="button" class="btn btn-sm btn-primary">Edit</a>

                        <form method="post" action="delete.php" style="display:inline-block">
                            <input type="hidden" name="id" value="<?php echo $contact['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</form>



<script type="text/javascript" src="js/jquery-1.6.2.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#checkBoxAll').click(function() {
            if ($(this).is(":checked"))
                $('.chkCheckBoxId').prop('checked', true);
            else
                $('.chkCheckBoxId').prop('checked', false);
        });
    });
</script>

<?php require './partials/footer.php' ?>
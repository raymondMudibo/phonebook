<?php $pdo = require './configuration/database.php';


$error = [];

$first_name = '';
$last_name = '';
$email = '';
$phone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $created_at = date('Y-m-d H:i:s');



    if (!$first_name) {
        $errors[] = "First Name is required";
    }
    if (!$last_name) {
        $errors[] = "Last Name is required";
    }
    if (!$email) {
        $errors[] = "Email is required";
    }
    if (!$phone) {
        $errors[] = "phone is required";
    }
    if (!is_dir('images')) {
        mkdir('images');
    }
    if (empty($errors)) {
        $image = $_FILES['image'] ?? null;
        $imagePath = '';
        if ($image && $image[tmp_name]) {
            $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
        $statement = $pdo->prepare("INSERT INTO contacts(image, first_name, last_name, phone_number, email, created_at) 
                                    VALUES(:image,:first_name, :last_name, :phone, :email,  :created_at)");
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':phone', $phone);
        $statement->bindValue(':created_at', $created_at);
        $statement->execute();
        //header('Location : index.php');

    }
}

function randomString($number)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTVWXYZ';
    $string = '';

    for ($i = 0; $i < $number; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $string .= $characters[$index];
    }
    return $string;
}
?>
<?php require './partials/header.php' ?>

<h1>Create New Contact</h1>

<?php if (!empty($errors)) { ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error) { ?>
            <div>
                <?php echo $error ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>

<form action="create.php" method="post" enctype="multipart/form-data">

    <div class="mb-3 form-group">
        <label for="image" class="form-label">Contact Image</label>
        <div>
            <input type="file" id="image" name="image">
        </div>
    </div>
    <div class="mb-3 form-group">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name ?>">
    </div>
    </div>
    <div class="mb-3 form-group">
        <label for="last_name" class="form-label">last Name</label>
        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $last_name ?>">
    </div>
    <div class="mb-3 form-group">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" value="<?php echo $email ?>">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3 form-group">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $phone ?>">
    </div>

    <button type="submit" class="btn btn-primary mb-3">Submit</button>

    <div class="mt-2 d-flex justify-content-end">
        <a href="index.php">Back to All Contacts</a>
    </div>
</form>
<?php require './partials/footer.php' ?>
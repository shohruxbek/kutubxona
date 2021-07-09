<?php
// Include config file
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$student_id = "";
$book_id = "";
$bookdate = "";
$total = "";
$issue_date = "";
$return_date = "";

$student_id_err = "";
$book_id_err = "";
$bookdate_err = "";
$total_err = "";
$issue_date_err = "";
$return_date_err = "";


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $student_id = trim($_POST["student_id"]);
		$book_id = trim($_POST["book_id"]);
		$bookdate = trim($_POST["bookdate"]);
		$total = trim($_POST["total"]);
		$issue_date = trim($_POST["issue_date"]);
		$return_date = trim($_POST["return_date"]);
		

        $dsn = "mysql:host=$db_server;dbname=$db_name;charset=utf8mb4";
        $options = [
          PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];
        try {
          $pdo = new PDO($dsn, $db_user, $db_password, $options);
        } catch (Exception $e) {
          error_log($e->getMessage());
          exit('Something weird happened'); //something a user can understand
        }

        $vars = parse_columns('reserv', $_POST);
        $stmt = $pdo->prepare("INSERT INTO reserv (student_id,book_id,bookdate,total,issue_date,return_date) VALUES (?,?,?,?,?,?)");

        if($stmt->execute([ $student_id,$book_id,$bookdate,$total,$issue_date,$return_date  ])) {
                $stmt = null;
                header("location: reserv-index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add a record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <div class="form-group">
                                <label>Talaba id</label>
                                <input type="number" name="student_id" class="form-control" value="<?php echo $student_id; ?>">
                                <span class="form-text"><?php echo $student_id_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>kitob id</label>
                                <input type="number" name="book_id" class="form-control" value="<?php echo $book_id; ?>">
                                <span class="form-text"><?php echo $book_id_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Band qilish sanasi</label>
                                <input type="number" name="bookdate" class="form-control" value="<?php echo $bookdate; ?>">
                                <span class="form-text"><?php echo $bookdate_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>soni</label>
                                <input type="number" name="total" class="form-control" value="<?php echo $total; ?>">
                                <span class="form-text"><?php echo $total_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Olish sanasi</label>
                                <input type="number" name="issue_date" class="form-control" value="<?php echo $issue_date; ?>">
                                <span class="form-text"><?php echo $issue_date_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Qaytarish sanasi</label>
                                <input type="number" name="return_date" class="form-control" value="<?php echo $return_date; ?>">
                                <span class="form-text"><?php echo $return_date_err; ?></span>
                            </div>

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="reserv-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
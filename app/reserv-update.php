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
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    $student_id = trim($_POST["student_id"]);
		$book_id = trim($_POST["book_id"]);
		$bookdate = trim($_POST["bookdate"]);
		$total = trim($_POST["total"]);
		$issue_date = trim($_POST["issue_date"]);
		$return_date = trim($_POST["return_date"]);
		

    // Prepare an update statement
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
        exit('Something weird happened');
    }

    $vars = parse_columns('reserv', $_POST);
    $stmt = $pdo->prepare("UPDATE reserv SET student_id=?,book_id=?,bookdate=?,total=?,issue_date=?,return_date=? WHERE id=?");

    if(!$stmt->execute([ $student_id,$book_id,$bookdate,$total,$issue_date,$return_date,$id  ])) {
        echo "Something went wrong. Please try again later.";
        header("location: error.php");
    } else {
        $stmt = null;
        header("location: reserv-read.php?id=$id");
    }
} else {
    // Check existence of id parameter before processing further
	$_GET["id"] = trim($_GET["id"]);
    if(isset($_GET["id"]) && !empty($_GET["id"])){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM reserv WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Set parameters
            $param_id = $id;

            // Bind variables to the prepared statement as parameters
			if (is_int($param_id)) $__vartype = "i";
			elseif (is_string($param_id)) $__vartype = "s";
			elseif (is_numeric($param_id)) $__vartype = "d";
			else $__vartype = "b"; // blob
			mysqli_stmt_bind_param($stmt, $__vartype, $param_id);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value

                    $student_id = $row["student_id"];
					$book_id = $row["book_id"];
					$bookdate = $row["bookdate"];
					$total = $row["total"];
					$issue_date = $row["issue_date"];
					$return_date = $row["return_date"];
					

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.<br>".$stmt->error;
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

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

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="reserv-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

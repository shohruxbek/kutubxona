<?php
include_once 'session.php';
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$number = "";
$name = "";
$author = "";
$year = "";
$total = "";
$gettotal = "";
$optradio = "";

$number_err = "";
$name_err = "";
$year_err = "";
$total_err = "";
$gettotal_err = "";
$alert = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $number = trim($_POST["number"]);
    $optradio = trim($_POST["optradio"]);
    $name = trim($_POST["name"]);
    $author = trim($_POST["author"]);
    $year = trim($_POST["year"]);
    $total = trim($_POST["total"]);
    $gettotal = 0;


    switch ($optradio) {
        case 0:
        $ars = explode(PHP_EOL, $number);
        break;
        case 1:
        $ars = explode(' ', $number);
        break;
        case 2:
        $ars = explode(',', $number);
        break;
        case 3:
        $ars = explode('/', $number);
        break;
        case 4:
        $ars = explode('-', $number);
        break;

        default:
        $alert =  '<div class="alert alert-danger alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
        <strong>Xatolik!</strong> Ma\'lumotlar saqlanmadi.
        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
        </button>
        </div>';
        break;
    }

    $num=" ";
    foreach($ars as $key){
        $num.="$key ";
    }


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
          $alert =  '<div class="alert alert-danger alert-dismissible fade show">
          <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
          <strong>Xatolik!</strong> Ma\'lumotlar saqlanmadi.
          <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
          </button>
          </div>';
      }

      $vars = parse_columns('book', $_POST);
      $stmt = $pdo->prepare("INSERT INTO book (number,name,author,year,total,gettotal) VALUES (?,?, ?,?,?,?)");

      if($stmt->execute([ $num,$name,$author,$year,$total,$gettotal  ])) {
        $stmt = null;
                // header("location: addbook.php");
        $alert =  '<div class="alert alert-secondary alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
        <strong>Qo\'shildi!</strong> Kitob ma\'lumotlar bazasiga qo\'shildi.
        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
        </button>
        </div>';
    } else{
        $alert =  '<div class="alert alert-danger alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
        <strong>Xatolik!</strong> Ma\'lumotlar saqlanmadi.
        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
        </button>
        </div>';
    }

}
?> 
<?php
include 'tepa.php';
?>
<?php
include 'header.php';
?>
<?php
include 'menu.php';
?>
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
         <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javascript:void(0)">Bosh menyu</a></li>
          <li class="breadcrumb-item active"><a href="javascript:void(0)">Kitob kiritish</a></li>
      </ol>
  </div>
  <!-- row -->
  <div class="row">
    <div class="col-12">   
        <?php
        echo $alert;
        ?>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Kitob kiritish</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="" method="post">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kitob raqami</label>
                            <div class="col-sm-9">
                                <textarea name="number" class="form-control" placeholder="Kitob raqami" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kitob raqamlari nima bilan ajratilgan?</label>
                            <div class="col-sm-9">
                                <label class="radio-inline mr-3">
                                    <input type="radio" name="optradio" value="0" required> ENTER (↵)</label>
                                    <label class="radio-inline mr-3">
                                        <input type="radio" name="optradio" value="1" required> Probel ('  ')</label>
                                        <label class="radio-inline mr-3">
                                            <input type="radio" name="optradio" value="2" required> Vergul (',')</label>
                                            <label class="radio-inline mr-3">
                                                <input type="radio" name="optradio"value="3" required> Slash ('/')</label>
                                                <label class="radio-inline mr-3">
                                                    <input type="radio" name="optradio"value="4" required> Tire ('-')</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kitob nomi</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="name" class="form-control" placeholder="Kitob nomi" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kitob yozuvchisi</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="author" class="form-control" placeholder="Kitob yozuvchisi" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kitob yili</label>
                                                <div class="col-sm-9">
                                                    <input type="text"  name="year" class="form-control" placeholder="Kitob yili" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kitoblar soni</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="total" class="form-control" placeholder="Kitoblar soni" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <button type="submit" class="btn btn-primary right">Qo'shish</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        <!--**********************************
            Content body end
            ***********************************-->

        <!--**********************************
            Footer start
            ***********************************-->
            <?php
            include 'footer.php';
        ?>
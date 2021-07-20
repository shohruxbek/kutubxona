<?php
include_once 'session.php';
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$numbers = "";
$firstname = "";
$lastname = "";
$sharifname = "";
$direction = "";
$group = "";

$numbers_err = "";
$firstname_err = "";
$lastname_err = "";
$sharifname_err = "";
$direction_err = "";
$group_err = "";
$alert = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $numbers = trim($_POST["numbers"]);
        $firstname = trim($_POST["firstname"]);
		$lastname = trim($_POST["lastname"]);
		$sharifname = trim($_POST["sharifname"]);
		$direction = trim($_POST["direction"]);
		$group = trim($_POST["group"]);
		

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

        $vars = parse_columns('student', $_POST);
        $stmt = $pdo->prepare("INSERT INTO student (numbers,firstname,lastname,sharifname,direction,groups) VALUES (?,?,?,?,?,?)");
		try {
        if($stmt->execute([$numbers,  $firstname,$lastname,$sharifname,$direction,$group  ])) {
                $stmt = null;
                // header("location: addbook.php");
                $alert =  '<div class="alert alert-secondary alert-dismissible fade show">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                <strong>Qo\'shildi!</strong> Talaba ma\'lumotlar bazasiga qo\'shildi.
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
		catch (Exception $e) {
			$alert =  '<div class="alert alert-danger alert-dismissible fade show">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <strong>Xatolik!</strong> Ushbu talaba raqami oldin kiritilgan
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
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Talaba kiritish</a></li>
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
                                <h4 class="card-title">Talaba kiritish</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="" method="post">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Talaba raqami</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="numbers"  class="form-control" placeholder="Talaba raqami" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Ismi</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="firstname" class="form-control" placeholder="ismi" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Familiyasi</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="lastname" class="form-control" placeholder="familiyasi" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Sharifi</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="sharifname" class="form-control" placeholder="sharifi">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Yo'nalishi</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="direction" class="form-control" placeholder="yo'nalishi" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Guruhi</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="group" class="form-control" placeholder="guruhi" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary right">Talabani kiritish</button>
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
<?php
include_once 'session.php';
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$oldpass = "";
$newpass1 = "";
$newpass2 = "";
$alert = "";


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if($_POST['newpass2']){
    $oldpass = trim($_POST["oldpass"]);
    $newpass1 = trim($_POST["newpass1"]);
    $newpass2 = trim($_POST["newpass2"]);


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


      if($newpass1!=$newpass2){
        $alert =  '<div class="alert alert-danger alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
        <strong>Xatolik!</strong> Yangi parollar bir xil yozilmadi.
        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
        </button>
        </div>';
    }else{
$idh = $_SESSION['id'];
      $sqdl3 = "SELECT * FROM `user` WHERE `id`='$idh'";
      $resultd3 = mysqli_query($link, $sqdl3);
      $rowq3 = mysqli_fetch_assoc($resultd3);
      if($rowq3!=null){

        if($rowq3['password']==sha1($oldpass)){
            $vars = parse_columns('user', $_POST);
            $password = sha1($newpass1);
            $stmt = $pdo->prepare("UPDATE user SET password=? WHERE id='$idh'");

            if($stmt->execute([$password])) {
                $stmt = null;
                // header("location: addbook.php");
                $alert =  '<div class="alert alert-secondary alert-dismissible fade show">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                <strong>Almashtirildi!</strong> Administrator paroli almashtirildi
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
        }else{
            $alert =  '<div class="alert alert-danger alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
            <strong>Xatolik!</strong> eski parolni xato yozdingiz.
            <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
            </button>
            </div>';
        }
    }else{
        $alert =  '<div class="alert alert-danger alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
        <strong>Xatolik!</strong> Administrator topilmadi.
        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
        </button>
        </div>';
    }

}
}

if($_POST['login']){
    $oldpass = trim($_POST["oldpass"]);
    $name = trim($_POST["name"]);
    $login = trim($_POST["login"]);


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
$idh = $_SESSION['id'];
      $sqdl3 = "SELECT * FROM `user` WHERE `id`='$idh'";
      $resultd3 = mysqli_query($link, $sqdl3);
      $rowq3 = mysqli_fetch_assoc($resultd3);
      if($rowq3!=null){

        if($rowq3['password']==sha1($oldpass)){
            $vars = parse_columns('user', $_POST);
            
            $stmt = $pdo->prepare("UPDATE user SET login=?,name=? WHERE id='$idh'");
 $login = mysqli_real_escape_string($link,$login);
 $name = mysqli_real_escape_string($link,$name);
            if($stmt->execute([$login, $name])) {
                $_SESSION['name']=$name;
                $stmt = null;
                // header("location: addbook.php");
                $alert =  '<div class="alert alert-secondary alert-dismissible fade show">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                <strong>Almashtirildi!</strong> Administrator ma\'lumotlari almashtirildi
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
        }else{
            $alert =  '<div class="alert alert-danger alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
            <strong>Xatolik!</strong> eski parolni xato yozdingiz.
            <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
            </button>
            </div>';
        }
    }else{
        $alert =  '<div class="alert alert-danger alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
        <strong>Xatolik!</strong> Administrator topilmadi.
        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
        </button>
        </div>';
    }


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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profilni sozlash</a></li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-xl-6 col-xxl-8">   
                <?php
                echo $alert;
                ?>
            </div>
        </div>
        <div class="row">

            <div class="col-xl-6 col-xxl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Parolni almashtirish</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="" method="post">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Eski parol</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="oldpass"  class="form-control" placeholder="Eski parol" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Yangi parol</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="newpass1" class="form-control" placeholder="Yangi parol" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Yangi parol qayta</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="newpass2" class="form-control" placeholder="Yangi parol qayta" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit"class="btn btn-primary right">Yangilash</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-xxl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ism va loginni almashtirish</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="" method="post">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Parol</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="oldpass"  class="form-control" placeholder="Parol" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Yangi ism</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" class="form-control" placeholder="Yangi ism" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Yangi login</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="login" class="form-control" placeholder="Yangi login" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary right">Yangilash</button>
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
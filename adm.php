<?php
include_once 'session.php';
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$oldpass = "";
$newpass1 = "";
$newpass2 = "";
$alert = "";
$alerts = "";
        if(isset($_GET["del"]) && !empty($_GET["del"])){
                $para = trim($_GET["del"]);

                        $sql = "DELETE FROM `user` WHERE `id` = $para";
                        $result = mysqli_query($link, $sql);
                        
                    if($result) {
                                        $alert =  '<div class="alert alert-secondary alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                        <strong>Olib tashlandi!</strong> Admin ma\'lumotlar bazasidan o\'chirildi
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                        </button>
                    </div>';
                                    } else{
                                        $alert =  '<div class="alert alert-danger alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        <strong>Xatolik!</strong> Ma\'lumotlar o\'zgarmadi.
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                        </button>
                    </div>';
                                    }
            
    }

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
if($_POST['login']){
    $name = trim($_POST["name"]);
    $login = trim($_POST["login"]);
    $password = trim($_POST["password"]);


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
$sqdl3 = "SELECT * FROM `user`";
    $resultd3 = mysqli_query($link, $sqdl3);
    $k=0;
    while($rowq3 = mysqli_fetch_array($resultd3)){
    
if($rowq3['password']==sha1($password) and $rowq3['login']==$login){
$alert =  '<div class="alert alert-danger alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
            <strong>Xatolik!</strong> bu foydalanuvchi bazada bor
            <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
            </button>
            </div>';
                $k++;
}
        }

if($k==0){
 $vars = parse_columns('user', $_POST);
            $stmt = $pdo->prepare("INSERT INTO user (name,login,password) VALUES (?,?,?)");
 $login = mysqli_real_escape_string($link,$login);
 $name = mysqli_real_escape_string($link,$name);
 $password = sha1($password);
            if($stmt->execute([$name, $login, $password])) {
                $stmt = null;
                // header("location: addbook.php");
                $alert =  '<div class="alert alert-secondary alert-dismissible fade show">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                <strong>Qo\'shildi!</strong> Yangi administrator qo\'shildi
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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Administrator</a></li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-12">   
                <?php
                echo $alert;
                ?>
            </div>
        </div>
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Administrator qo'shish</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="" method="post">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Ism</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name"  class="form-control" placeholder="Ism" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Login</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="login" class="form-control" placeholder="Login" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Parol</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="password" class="form-control" placeholder="Parol" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit"class="btn btn-primary right">Qo'shish</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">   
                        <?php
                        echo $alerts;
                    ?>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Administratorlar</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="1example" class="display min-w850 nowrap">
                                        <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Admin ismi</th>
                                                <th>Admin Login</th>
                                                <th>Admin Parol</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM user";
        $result = mysqli_query($link, $sql);
$i=1;
while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>".$i."</td>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['login']."</td>";
    echo "<td>".$row['password']."</td>";
    echo '<td><div class="d-flex">
        <a href="adm.php?del='.$row['id'].'" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></a>
    </div></td>';
    echo "</tr>";
    $i++;
}
                                            ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                                <th>#ID</th>
                                                <th>Admin ismi</th>
                                                <th>Admin Login</th>
                                                <th>Admin Parol</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
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
            <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

    <script type="text/javascript">
        $('#1example').DataTable({
            dom: 'Bfrtip',
            buttons: [
            { extend: 'csv', className: 'btn btn-primary' },
            { extend: 'excel', className: 'btn btn-primary' },
            { extend: 'pdf', className: 'btn btn-primary' },
            { extend: 'print', className: 'btn btn-primary' }
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    </script>
            <?php
            include 'footer.php';
        ?>
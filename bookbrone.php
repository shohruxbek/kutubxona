<?php
include_once 'session.php';
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$alert = "";
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
		$bookdate = date('Y-m-d H:i:s');
		$total = 1;
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
          $alert =  '<div class="alert alert-danger alert-dismissible fade show">
          <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
          <strong>Xatolik!</strong> Ma\'lumotlar saqlanmadi.
          <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
          </button>
      </div>';
        }

        $output = preg_replace('/[^0-9]/', '', $book_id );
        $stu = preg_replace('/[^0-9]/', '', $student_id );
        $sqdl5 = "SELECT * FROM `reserv` WHERE `student_id`='$stu' and `book_id`='$output' LIMIT 1";
        $resultd5 = mysqli_query($link, $sqdl5);
        $rowq5 = mysqli_fetch_assoc($resultd5);
    if($rowq5!=null){


$vars = parse_columns('reserv', $_POST);
$sql = "UPDATE reserv SET total=? WHERE id=?";
$stmt= $pdo->prepare($sql);
$totals = $rowq5['total']+$total;

if($stmt->execute([$totals, $rowq5['id']])) {
    $stmt = null;
    $output = trim($output);
    $sqdl3 = "SELECT * FROM `book` WHERE `number` LIKE '% ".$output." %' LIMIT 1";
$resultd3 = mysqli_query($link, $sqdl3);
$rowq3 = mysqli_fetch_assoc($resultd3);
if($rowq3!=null){
    $sqlr = "UPDATE book SET total=?, gettotal=? WHERE id=?";
    $stmt= $pdo->prepare($sqlr);
    $totalsa = $rowq3['total']-$total;
    $totalsb = $rowq3['gettotal']+$total;
    $idf = $rowq3['id'];
    if($stmt->execute([$totalsa, $totalsb, $idf])){
$alert =  '<div class="alert alert-secondary alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
    <strong>Band qilindi!</strong> Kitob talaba uchun band qilindi.
    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
    </button>
</div>';
    }else{
$alert =  '<div class="alert alert-danger alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
    <strong>Xatolik!</strong> Kitob ma\'lumotlari saqlanmadi
    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
    </button>
</div>';
    }
}else{
    $alert =  '<div class="alert alert-danger alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
    <strong>Xatolik!</strong> Kitob topilmadi.
    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
    </button>
</div>';
}
    
} else{
    $alert =  '<div class="alert alert-danger alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
    <strong>Xatolik!</strong> Ma\'lumotlar saqlanmadi.
    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
    </button>
</div>';
}

    }else{

        $vars = parse_columns('reserv', $_POST);
        $stmt = $pdo->prepare("INSERT INTO reserv (student_id,book_id,bookdate,total,issue_date,return_date) VALUES (?,?,?,?,?,?)");

        if($stmt->execute([ $student_id,$book_id,$bookdate,$total,$issue_date,$return_date  ])) {
                $stmt = null;
                $sqdl3 = "SELECT * FROM `book` WHERE `number` LIKE '% $output %' LIMIT 1";
                $resultd3 = mysqli_query($link, $sqdl3);
                $rowq3 = mysqli_fetch_assoc($resultd3);
                if($rowq3!=null){
                    $sqlr = "UPDATE book SET total=?, gettotal=? WHERE id =?";
                    $stmt= $pdo->prepare($sqlr);
                    $totalsa = $rowq3['total']-$total;
                    $totalsb = $rowq3['gettotal']+$total;
                    $id = $rowq3['id'];
                    $stmt->execute([$totalsa, $totalsb, $id]);
                }
                $alert =  '<div class="alert alert-secondary alert-dismissible fade show">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                <strong>Band qilindi!</strong> Kitob talaba uchun band qilindi.
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
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Talabaga kitob berish</a></li>
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
                                <h4 class="card-title">Talabaga kitob berish</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="" method="post">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Talaba raqami</label>
                                            <div class="col-sm-3">
                                                <input type="text" id="student_id" name="student_id" class="form-control" placeholder="Talaba raqami"  required>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" id="student_id_result" name="student_id_result" class="form-control" placeholder="ismi" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kitob raqami</label>
                                            <div class="col-sm-3">
                                                <input type="text" id="book_id" name="book_id" class="form-control" placeholder="Kitob raqami"  required>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" id="book_id_result" name="book_id_result" class="form-control" placeholder="ma'lumoti" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"> Olish sanasi</label>
                                            <div class="col-sm-9">
                                                
                                                <input name="issue_date" class="datepicker-default form-control" id="datepicker" placeholder="olish sanasi" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"> Qaytarish sanasi</label>
                                            <div class="col-sm-9">
                                            <input name="return_date" class="datepicker-default form-control" id="datepicker" placeholder="qaytarish sanasi" required>
                                           
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary right">Talaba nomiga biriktirish</button>
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
<script>
$(function () {
  $("#student_id").keyup(function () {
    $.ajax({
      type: "POST",
      url: "api.php",
      data: {
        student: $('input[name="student_id"]').val(),
      },
      success: function(data) {
        $('input[name="student_id_result"]').val(data).show();
      }
    });
  });
});
</script>
<script>
$(function () {
  $("#book_id").keyup(function () {
    $.ajax({
      type: "POST",
      url: "api.php",
      data: {
        book: $('input[name="book_id"]').val(),
        students: $('input[name="student_id"]').val(),
      },
      success: function(data) {
       var datas = JSON.parse(data);
        $('input[name="book_id_result"]').val(datas.result).show();

        if(datas.ok=="false"){
            $('button[type="submit"]').prop('disabled', true);
            $('button[type="submit"]').attr('class', 'btn btn-primary right no-drop');
        }else{
            $('button[type="submit"]').prop('disabled', false);
            $('button[type="submit"]').attr('class', 'btn btn-primary right');
        }
        
      }
    });
  });
});
</script>
        <!--**********************************
            Footer start
        ***********************************-->
         <?php
        include 'footer.php';
        ?>
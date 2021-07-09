<?php

include('config.php');
include('helpers.php');

if ($_POST) {
    
	
   if (isset($_POST['student'])) {
       $nim = $_POST['student'];
       $output = preg_replace('/[^0-9]/', '', $nim );
       if(strlen($nim)<1){
        echo "Bunday talaba mavjud emas...";
        exit;
       }
    $sqdl = "SELECT * FROM `student` WHERE `numbers`=$output LIMIT 1";
    $resultd = mysqli_query($link, $sqdl);
    $rowq = mysqli_fetch_assoc($resultd);
if($rowq!=null){
    echo $rowq['firstname']." ".$rowq['lastname']." ".$rowq['sharifname'];
}else{
    echo "Bunday talaba mavjud emas...";
}
    }


   if (isset($_POST['book'])) {
       $nim = $_POST['book'];
       $student = $_POST['students'];

       $output = preg_replace('/[^0-9]/', '', $nim );
       $stu = preg_replace('/[^0-9]/', '', $student );

       if(strlen($stu)<1){
        echo "Talaba id'si kam yoki kiritilmagan";
        exit;
       }

       $sqdl1 = "SELECT * FROM `student` WHERE `numbers`=$stu LIMIT 1";
    $resultd1 = mysqli_query($link, $sqdl1);
    $rowq1 = mysqli_fetch_assoc($resultd1);
if($rowq1==null){
    echo "Ushbu talaba bazada yo'q";
    exit;
}
       if(strlen($nim)<1){
        echo "Bunday kitob mavjud emas...";
        exit;
       }

       $sqdl = "SELECT * FROM `book` WHERE `number`=$output LIMIT 1";
       $resultd = mysqli_query($link, $sqdl);
       $rowq = mysqli_fetch_assoc($resultd);
   if($rowq!=null){
    $sum = $rowq['total']-$rowq['gettotal'];

    $sqdl5 = "SELECT * FROM `reserv` WHERE `student_id`='$stu' and `book_id`='$output' LIMIT 1";
    $resultd5 = mysqli_query($link, $sqdl5);
    $rowq5 = mysqli_fetch_assoc($resultd5);
if($rowq5!=null){
    echo "⚠️ Bu kitob avval olingan (".$rowq['name']." - ".$rowq['year']."yil)";
    exit;
}
      
       echo $rowq['name']." - ".$rowq['year']."yil - ".$sum." dona bor";
   }else{
       echo "Bunday kitob mavjud emas...";
   }
       }


       


    


}

?>
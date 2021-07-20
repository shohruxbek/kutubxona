<?php

include('config.php');
include('helpers.php');

if ($_POST) {
    
	
   if (isset($_POST['student'])) {
       $nim = $_POST['student'];
       $output = preg_replace('/[^0-9]/', '', $nim );
       if(strlen($output)<1){
        echo "Bunday talaba mavjud emas...";
       }else{
        $sqdl = "SELECT * FROM `student` WHERE `numbers`=$output LIMIT 1";
    $resultd = mysqli_query($link, $sqdl);
    $rowq = mysqli_fetch_assoc($resultd);
if($rowq!=null){
    echo $rowq['firstname']." ".$rowq['lastname']." ".$rowq['sharifname'];
}else{
    echo "Bunday talaba mavjud emas...";
}
       }
    
    }


   if (isset($_POST['book'])) {
       $nim = $_POST['book'];
       $student = $_POST['students'];

       $output = preg_replace('/[^0-9]/', '', $nim );
       $stu = preg_replace('/[^0-9]/', '', $student );

       if(strlen($stu)<1){
        echo json_encode(["result"=>"Talaba id'si kam yoki kiritilmagan","ok"=>"false"]);
        exit;
       }

       $sqdl1 = "SELECT * FROM `student` WHERE `numbers`=$stu LIMIT 1";
    $resultd1 = mysqli_query($link, $sqdl1);
    $rowq1 = mysqli_fetch_assoc($resultd1);
if($rowq1==null){
    echo json_encode(["result"=>"Ushbu talaba bazada yo'q","ok"=>"false"]);
    exit;
}
       if(strlen($nim)<1){
        echo json_encode(["result"=>"Bunday kitob mavjud emas...","ok"=>"false"]);
        
        exit;
       }

       $sqdl = "SELECT * FROM `book` WHERE `number` LIKE '% $output %'  LIMIT 1";
       $resultd = mysqli_query($link, $sqdl);
       $rowq = mysqli_fetch_assoc($resultd);
   if($rowq!=null){
    $sqdl5 = "SELECT * FROM `reserv` WHERE `student_id`='$stu' and `book_id`='$output' LIMIT 1";
    $resultd5 = mysqli_query($link, $sqdl5);
    $rowq5 = mysqli_fetch_assoc($resultd5);
if($rowq5!=null){
    echo json_encode(["result"=>"⚠️ Bu kitob avval olingan (".$rowq['name'].")","ok"=>"true"]);
    exit;
}
      
       echo json_encode(["result"=>$rowq['name'],"ok"=>"true"]);
   }else{
       echo json_encode(["result"=>"Bunday kitob mavjud emas...","ok"=>"false"]);
   }
       }


       


    


}

?>
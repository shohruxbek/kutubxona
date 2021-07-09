 <?php
        include 'tepa.php';
        require_once "config.php";
        require_once "helpers.php";
 $alert="";
        if(isset($_GET["del"]) && !empty($_GET["del"])){
   
        
            
                $para = trim($_GET["del"]);
                
                $sqdl5 = "SELECT * FROM `reserv` WHERE `id`='$para' LIMIT 1";
                $resultd5 = mysqli_query($link, $sqdl5);
                $rowq5 = mysqli_fetch_assoc($resultd5);

                // Set parameters
                
                    $total = $rowq5['total'];
                    $or = $rowq5['book_id'];

                    $sqdl3 = "SELECT * FROM `book` WHERE `number`= '$or' LIMIT 1";
                    $resultd3 = mysqli_query($link, $sqdl3);
                    $rowq3 = mysqli_fetch_assoc($resultd3);
                    
                    if($rowq3!=null){
                        
                        $totalsa = $rowq3['total']+$total;
                        $totalsb = $rowq3['gettotal']-$total;
                        $idf = $rowq3['id'];
                        $sqlr = "UPDATE `book` SET total=$totalsa, gettotal=$totalsb WHERE id =$idf";
                        $resultd5 = mysqli_query($link, $sqlr);
                        $sql = "DELETE FROM `reserv` WHERE `id` = $para";
                        $result = mysqli_query($link, $sql);
                        
                    if($resultd5 && $result) {
                        
                                        // Records deleted successfully. Redirect to landing page
                                        $alert =  '<div class="alert alert-secondary alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                        <strong>Olib tashlandi!</strong> Kitob esa ma\'lumotlar bazasiga qo\'shildi.
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

        }



        $sql = "SELECT * FROM reserv";
        $result = mysqli_query($link, $sql);
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
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Qarzdorlar ro'yxati</a></li>
					</ol>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <?php
                            if(!empty($alert)){
                                echo '<div class="card-body">';
                            echo $alert;
                            echo '</div>';
                            }
                            ?>
                            <div class="card-header">
                                <h4 class="card-title">Qarzdorlar ro'yxati</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display min-w850">
                                        <thead>
                                            <tr>
                                                <th>Talaba raqami</th>
                                                <th>Talaba F.I.SH</th>
                                                <th>Yo'nalishi</th>
                                                <th>Guruhi</th>
                                                <th>Kitob raqami</th>
                                                <th>Kitob nomi</th>
                                                <th>Ro'yxat vaqti</th>
                                                <th>Soni</th>
                                                <th>Olish</th>
                                                <th>Qaytarish</th>
                                                <th>Kitob qaytib olindi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
$i=1;
if($result){
    while($row = mysqli_fetch_array($result)){
        echo "<tr>";
        $sql2 = "SELECT * FROM `student` WHERE `numbers` =".$row['student_id'];
        $result2 = mysqli_query($link, $sql2);
        $rowq = mysqli_fetch_assoc($result2);
        echo "<td>".$rowq['numbers']."</td>";
        echo "<td>".$rowq['firstname']." ".$rowq['lastname']." ".$rowq['sharifname']."</td>";
        echo "<td>".$rowq['direction']."</td>";
        echo "<td>".$rowq['groups']."</td>";
    
        $sql3 = "SELECT * FROM `book` WHERE `number` =".$row['book_id'];
        $result3 = mysqli_query($link, $sql3);
        $roww = mysqli_fetch_assoc($result3);
        echo "<td>".$roww['number']."</td>";
        echo "<td>".$roww['name']."</td>";
    
        echo "<td>".$row['bookdate']."</td>";
        echo "<td>".$row['total']."</td>";
        echo "<td>".$row['issue_date']."</td>";
        echo "<td>".$row['return_date']."</td>";
        echo '<td><div class="d-flex">
    
    
        <a href="debt.php?del='.$row['id'].'" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></a>
    </div></td>';
    
        echo "</tr>";
        $i++;
    }   
}

                                            ?>
                                           
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Talaba raqami</th>
                                                <th>Talaba F.I.SH</th>
                                                <th>Yo'nalishi</th>
                                                <th>Guruhi</th>
                                                <th>Kitob raqami</th>
                                                <th>Kitob nomi</th>
                                                <th>Ro'yxat vaqti</th>
                                                <th>Soni</th>
                                                <th>Olish</th>
                                                <th>Qaytarish</th>
                                                <th>Kitob qaytib olindi</th>
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
         <?php
        include 'footer.php';
        ?>
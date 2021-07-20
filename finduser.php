<?php
        include 'tepa.php';

    
        require_once "config.php";
        require_once "helpers.php";
        $status = 0;
        if(isset($_GET["id"]) && !empty($_GET["id"])){
            $stu = preg_replace('/[^0-9]/', '', $_GET['id'] );
        $sql = "SELECT * FROM reserv WHERE student_id = '$stu'";
        $result = mysqli_query($link, $sql);
        $status = 2;
        $result1 = mysqli_query($link, $sql);
        $rowqq = mysqli_fetch_assoc($result1);
          if($rowqq==NULL){
            $alert =  '<div class="alert alert-danger alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        <strong>Talaba mavjud emas!</strong> yoki kitob olmagan.
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                        </button>
                    </div>';
                    $status=1;
        }
        }
        ?>
		<?php
        include 'header.php';
        ?>
        <div class="nav-header">
    <a href="index.php" class="brand-logo">
        <img class="logo-abbr" src="./images/logo.png" alt="">
        <img class="logo-compact" src="./images/logo-text.png" alt="">
        <img class="brand-title" src="./images/logo-text.png" alt="">
    </a>

    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
<div class="header">  
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        Axborot resurs markazi
                    </div>
                </div>
                <ul class="navbar-nav header-right">
                            
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="login.php" role="button">
                                    <img src="images/1.png" width="20" alt=""/>
                                    <div class="header-info">
                                        <span>Kirish</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
            </div>
        </nav>
    </div>
</div>

<div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <li><a href="finduser.php" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-notepad"></i>
							<span class="nav-text">Qarzdorlikni tekshirish</span>
						</a>
					</li>
                </ul>
                 <ul class="metismenu" id="menu">
                    <li><a href="findbook.php" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-layer-1"></i>
							<span class="nav-text">Kitob qidirish</span>
						</a>
					</li>
                </ul>
			</div>
        </div>


        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                        <div class="card-header">
                                <h4 class="card-title">Kutubxonadan qarzdorikni tekshirish</h4>
                            </div>
                            <div class="card-body">
                            
                            <form action="" method="get">
                            <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="id" placeholder="Talaba id'si">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">Qidirish</button>
                                            </div>
                                        </div>
                                    </form>


<?php
if($status==1){
    if(!empty($alert)){
    echo $alert;
    }
}else if($status==2){



?>

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
    
        $sql3 = "SELECT * FROM `book` WHERE `number` LIKE '% ".$row['book_id']." %' LIMIT 1";
        $result3 = mysqli_query($link, $sql3);
        $roww = mysqli_fetch_assoc($result3);
        echo "<td>".$row['book_id']."</td>";
        echo "<td>".$roww['name']."</td>";
    
        echo "<td>".$row['bookdate']."</td>";
        echo "<td>".$row['total']."</td>";
        echo "<td>".$row['issue_date']."</td>";
        echo "<td>".$row['return_date']."</td>";
       

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
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <?php

}?>
                            </div>
                        </div>
                    </div>
				</div>
                
            </div>
        </div>
        <!--**********************************
            Footer start
        ***********************************-->
         <?php
        include 'footer.php';
        ?>
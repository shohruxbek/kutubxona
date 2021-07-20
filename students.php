<?php
include_once 'session.php';
        include 'tepa.php';
 require_once "config.php";
        require_once "helpers.php";
 $alert="";
        if(isset($_GET["del"]) && !empty($_GET["del"])){
                $para = trim($_GET["del"]);


                $sqdl3 = "SELECT * FROM `reserv` WHERE `student_id`= '$para' LIMIT 1";
                    $resultd3 = mysqli_query($link, $sqdl3);
                    $rowq3 = mysqli_fetch_assoc($resultd3);
                    
                    if($rowq3==null){

                        $sql = "DELETE FROM `student` WHERE `numbers` = $para";
                        $result = mysqli_query($link, $sql);
                        
                    if($result) {
                                        $alert =  '<div class="alert alert-secondary alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                        <strong>Olib tashlandi!</strong> Talaba ma\'lumotlar bazasidan o\'chirildi
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
                

        }else{
        $alert =  '<div class="alert alert-danger alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        <strong>Xatolik!</strong> Bu talaba qarzdor
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                        </button>
                    </div>';
    }
    }

        $sql = "SELECT * FROM student";
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
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Talabalar</a></li>
					</ol>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="col-12">   
                        <?php
                        echo $alert;
                    ?>
                    </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Talabalar</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="1example" class="display min-w850 nowrap">
                                        <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Talaba raqami</th>
                                                <th>Talaba ismi</th>
                                                <th>Talaba familiyasi</th>
                                                <th>Talaba sharifi</th>
                                                <th>Yo'nalishi</th>
                                                <th>Guruhi</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
$i=1;
while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>".$i."</td>";
    echo "<td>".$row['numbers']."</td>";
    echo "<td>".$row['firstname']."</td>";
    echo "<td>".$row['lastname']."</td>";
    echo "<td>".$row['sharifname']."</td>";
    echo "<td>".$row['direction']."</td>";
    echo "<td>".$row['groups']."</td>";
    echo '<td><div class="d-flex">
        <a href="students.php?del='.$row['numbers'].'" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></a>
    </div></td>';
    echo "</tr>";
    $i++;
}
                                            ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                                <th>#ID</th>
                                                <th>Talaba raqami</th>
                                                <th>Talaba ismi</th>
                                                <th>Talaba familiyasi</th>
                                                <th>Talaba sharifi</th>
                                                <th>Yo'nalishi</th>
                                                <th>Guruhi</th>
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
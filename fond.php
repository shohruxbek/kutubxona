 <?php
        include 'tepa.php';
        require_once "config.php";
        require_once "helpers.php";
        $sql = "SELECT * FROM book";
        $result = mysqli_query($link, $sql);
        ?>
        <!--**********************************
            Nav header end
        ***********************************-->
		
		<!--**********************************
            Chat box start
        ***********************************-->
	
		<!--**********************************
            Chat box End
        ***********************************-->
		
		<!--**********************************
            Header start
        ***********************************-->
         <?php
        include 'header.php';
        ?>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
         <?php
        include 'menu.php';
        ?>
        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
       <div class="content-body">
            <div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="javascript:void(0)">Bosh menyu</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Kitoblar fondi</a></li>
					</ol>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Kitoblar fondi</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display min-w850">
                                        <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Kitob raqami</th>
                                                <th>Kitob nomi</th>
                                                <th>Kitob yili</th>
                                                <th>Qolgan kitoblar</th>
                                                <th>Talabalardagi soni</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
$i=1;
while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>".$i."</td>";
    echo "<td>".$row['number']."</td>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['year']."</td>";
    echo "<td>".$row['total']."</td>";
    echo "<td>".$row['gettotal']."</td>";
    echo "</tr>";
    $i++;
}
                                            ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                        <th>#ID</th>
                                                <th>Kitob raqami</th>
                                                <th>Kitob nomi</th>
                                                <th>Kitob yili</th>
                                                <th>Qolgan kitoblar</th>
                                                <th>Talabalardagi soni</th>
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
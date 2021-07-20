<?php
session_start();
if(isset($_GET['exit'])){
    session_destroy();
    header('location:index.php');
}
        include 'tepa.php';
        ?>

        <div class="container" style="margin-top:100px">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Admin panelga kirish</h4>
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Login</strong></label>
                                            <input type="email" class="form-control" value="">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Parol</strong></label>
                                            <input type="password" class="form-control" value="">
                                        </div>
                                        <!-- <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                                <a href="page-forgot-password.html">Parolni unutdingizmi?</a>
                                            </div>
                                        </div> -->
                                        <div class="text-center">
                                            <button type="submit" name="submit" class="btn btn-primary btn-block">Kirish</button>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
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
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
//header("location:../under-maintenance.jpg");
ini_set('memory_limit', '1024M');
foreach ($_GET as $key => $data) {
    $url = $_GET[$key] = base64_decode(urldecode($data));
}
if (isset($_POST['save'])) {

    $result = mysqli_query($con, "SELECT * FROM tbl_employee WHERE Emp_Email ='" . $_POST['EmailAdd'] . "' LIMIT 1") or die("Query data error");
    $row = mysqli_fetch_assoc($result);

    $_SESSION['Per_Name'] = $row['Emp_LName'] . ', ' . $row['Emp_FName'];
    $_SESSION['EmpID'] = $row['Emp_ID'];
    $_SESSION['Email'] = $row['Emp_Email'];

    $pass = md5($_POST['password']);
    $query = mysqli_query($con, "SELECT * FROM tbl_teacher_account WHERE Teacher_TIN='" . $_POST['EmailAdd'] . "' AND Teacher_Password='" . $pass . "' LIMIT 1") or die("Error Teacher Account");
    $pass_hash = mysqli_fetch_assoc($query);
    $password = $pass_hash['Teacher_Password'];


    if ($password == $pass) {

        //mysqli_query($con,"UPDATE tbl_teacher_account SET Last_login='".date('Y/m/d H:i:s')."',Teacher_status='Online' WHERE No='".$pass_hash['No']."' LIMIT 1") or die ('Error data');			
        header('location:mycert.php?code=' . urlencode(base64_encode($_POST['code'])));
    } else {
?>
        <script>
            {
                alert("Invalid Email Add and Password please try agian!!");
                window.location.href = "./";
            }
        </script>
<?php
    }
}

mysqli_query($con, "UPDATE tbl_number_of_visitors SET No_of_visitors = No_of_visitors + 1 LIMIT 1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns='http://www.w3.org/1999/xhtml'>

<head>

    <META name='author' content='Marlon E. Caduyac'>
    <META http-equiv='Content-Type' content='text/html; charset=windows-1252'>
    <META HTTP-EQUIV='expires' CONTENT='FRI, 13 MAR 2020 12:00:00 GMT'>
    <META HTTP-EQUIV='Pragma' CONTENT='no-cache'>
    <META HTTP-EQUIV='Cache-Control' CONTENT='no-cache'>
    <META http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DepEd Pagadian">

    <title>Login </title>
    <link rel="shortcut icon" href="../logo/logo.png">

    <!-- Bootstrap Core CSS -->
    <link href="../pcdmis/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../pcdmis/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../pcdmis/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../pcdmis/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div class="navbar navbar-fixed-top navbar-default hidden-print" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#deped-uis-nav-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span><span class="icon-bar">
                    </span><span class="icon-bar"></span></button><span class="navbar-brand">
                    <img class="logo" src="../pcdmis/logo/logo.png" alt="DepEd" style="height: 20px; margin-top: -2px" /></span>
            </div>
            <div class="navbar-collapse collapse" id="deped-uis-nav-collapse">
                <div class="nav navbar-nav"><span class="navbar-brand">DCDMIS CERTIFICATE VERIFICATION PORTAL</span></div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8" style="margin-top:100px;text-align:center;">
                <img src="../pcdmis/logo/network.png" style="width:50%;height:50%;">
            </div>
            <div class="col-lg-4" style="float:left;">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please sign in to verify your certificate!!</h3>
                    </div>
                    <div class="panel-body">

                        <form role="form" action="./?login" Method="POST" enctype="multipart/form-data">
                            <fieldset>
                                <div class="form-group">
                                    <label>Email Add:</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input class="form-control" name="EmailAdd" type="email" placeholder="DepEd Email" required autofocus><br />
                                        <input class="form-control" name="code" type="hidden" value="<?php echo $url; ?>"><br />
                                    </div>
                                    <label>Password:</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input class="form-control" placeholder="Password" name="password" id="password" type="password">
                                    </div>
                                </div>
                                <br />
                                <!-- Change this to a button or input when using this as a form -->
                                <button name="save" class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>

                            <p> </p>

                    </div>
                </div>



            </div>




        </div>

        <!-- jQuery -->
        <script src="../pcdmis/vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../pcdmis/vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../pcdmis/vendor/metisMenu/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../pcdmis/dist/js/sb-admin-2.js"></script>

</body>

</html>
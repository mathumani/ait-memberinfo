<?php 

ob_start();
session_start(); 

if(!is_array($_SESSION['data']))
{
    header("Location: index.php");
    exit;
}

$url = null;
$dt = 0;
foreach($_SESSION['data'] as $key => $value)
{
    if($key != 'id' || $key != 'sync')
        $url .= "$key=".urlencode($value)."&";
    $dt++;
}
$photo = $_SESSION['data']['photo'];

$photoURL = "../photo/".$photo;
if(file_exists($photoURL))
    copy($photoURL, "photo/$photo");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title Page-->
    <title>AIT - Member Infor Update</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">

    <link rel="stylesheet" href="css/bootstrap.4.3.1.min.css" rel="stylesheet", media="all">
</head>

<body>
    <div class="page-wrapper bg-gra-01 p-t-180 p-b-100 font-poppins">
        <div class="wrapper wrapper--w780">

            <div class="card mb-3" style="max-width: 800px;">
              <div class="row no-gutters">
                <div class="col-md-4">
                <img src="photo/<?php echo $photo; ?>" width='240px' height='300px' 
                    class="card-img" alt="Member passport">
                </div>

                <div class="col-md-8">
                  <div class="card-body">
                    <div class="card-header font-weight-bold heading-color">
                     <?php echo $_SESSION['data']['company']; ?>
                    </div>
                    <div class="row watermark">

                        <div class="col-4 font-weight-bold">NAME:</div>
                        <div class="col-8">
                            <?php echo $_SESSION['data']['fullname']; ?>
                        </div>

                        <div class="col-4 font-weight-bold">MemberNo:</div>
                        <div class="col-8">
                            <?php echo $_SESSION['data']['membership_no']; ?>
                        </div>

                        <div class="col-4 font-weight-bold">Gender:</div>
                        <div class="col-8">
                            <?php echo $_SESSION['data']['gender']; ?> 
                        </div>

                        <div class="col-4 font-weight-bold">Date of Birth:</div>
                        <div class="col-8">
                            <?php echo $_SESSION['data']['dob']; ?>
                        </div>

                        <div class="col-4 font-weight-bold">Phone:</div>
                        <div class="col-8">
                            <?php echo $_SESSION['data']['phone']; ?>
                        </div>

                        <div class="col-4 font-weight-bold">E-mail:</div>
                        <div class="col-8">
                            <?php echo $_SESSION['data']['email']; ?>
                        </div>

                        <div class="col-12 font-italic" style="padding: 10px; color: blue;"><p>Thank you for updating your information. Kindly verify the details and if correct confirm it. You can go back to correct if you have make mistake. For Help call: +255 768 983 800</div>

                        <div class="col-6">
                        <a type="button" class="btn btn-primary btn-lg" role="button" href="<?php echo './?'.$url ?>">BACK</a>
                        </div>
                        <div class="col-6">
                        <a type="button" class="btn btn-success btn-lg" href="./?photo=<?php echo $photo; ?>&confirm=yes" role="button">CONFIRM</a>
                        </div>

                    </div>

                  </div>
                </div>
              </div>
            </div>


        </div>
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>
    <script src="js/bootstrap.4.3.1.min.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>

</body>

</html>
<!-- end document-->


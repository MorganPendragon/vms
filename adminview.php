<?php ob_start() ?>
<!doctype html>
<html lang="en">
<!--TODO:Idiotproofing-->
<!--TODO:Pagination on table-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminView</title>
    <!--font-->
    <link href="https://fonts.cdnfonts.com/css/montserrat" rel="stylesheet">
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!--bootstrap icons--->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!--bootstrap js lib-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!--jQuery-->
    <script src="./node_modules/jquery/dist/jquery.js"></script>
    <!--Validation plugin for jQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--Date Picker-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/9dd1cea6a6.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>

    <style>
        th {
            cursor: pointer;
        }

        .window-height {
            height: 100vh;
            position: fixed;
        }


        * {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat';
        }

        table {
            font-size: 16px;

        }


        .nav-pills {
            --bs-nav-pills-link-active-bg: rgb(14, 32, 45);
        }

        .lg {
            box-sizing: border-box;
            width: 398px;
            height: 478px;
            left: 495px;
            top: 154px;
            background: #ffffff;
            box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
        }

        .sm {
            width: 1331px;
            height: 233px;
            left: 495px;
            top: 735px;
            background: #ffffff;
            box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
        }

        .hf {
            width: 496px;
            height: 230px;
            left: 912px;
            top: 399px;

            background: #FFFFFF;
            box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
        }
        .vacmanu{
            height: 300px;
            width: 85%;
            margin-left: 8%;

        }
    </style>
    <script>
        $(function() {
            var dataPoints = [];
            var chart = new CanvasJS.Chart("brandOverall", {
                showInLegend: true,
                data: [{
                    type: "pie",
                    dataPoints: dataPoints,
                }]
            });
            /*Ajax request for charts on dashboard*/
            $.getJSON("conn.php", {
                    chart: 'overall'
                })
                .done(function(data) {
                    $.each(data, function(index, value) {
                        console.log(index);
                        dataPoints.push({
                            label: index,
                            y: parseInt(value)
                        });
                    });
                    chart.render();
                })
                .fail(function(jqxhr, textStatus, error) {
                    var err = textStatus + ", " + error;
                    console.log("Request Failed: " + err);
                });
        });
    </script>
</head>

<body>
    <header>
        <!--navbar gen rep place-->
        <!--
        <nav class="navbar justify-content-end px-5" style="background-color:#022e43;">
            <ul class="nav">
                <li><a class="btn" type="button" href="adminview.php?report=1">
                        <span class="badge text-bg-light">GENERATE REPORTS</span>
                        </i>
                    </a>
                </li>
            </ul>
        </nav>
        -->
    </header>
    <main>
        <div class="row">
            <!--sidebar-->
            <div class="container-fluid window-height" aria-orientation="vertical">
                <div class="d-flex">
                    <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0" style="background-color:#022e43;font-size:20px;">
                        <img src="img\logo.png" class="img-fluid" alt="...">
                        <div class="d-flex flex-column align-items-center align-items-sm-center px-3 pt-1 min-vh-100">
                            <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="tableTab">
                                <li class="nav-item ">
                                    <a href="#dashboard" class="nav-link" data-bs-toggle="tab" style="color:rgb(232, 177, 62);"><i class="bi bi-stack"></i>&nbsp;&nbsp;Dashboard</a>
                                </li>
                                <li class="nav-item active">
                                    <a href="#student" class="nav-link active" data-bs-toggle="tab" style="color:rgb(232, 177, 62);"><i class="bi bi-database"></i>&nbsp;&nbsp;Student Database</a>
                                </li>
                                <li class="nav-item ">
                                    <a href="#faculty" class="nav-link" data-bs-toggle="tab" style="color:rgb(232, 177, 62);"><i class="bi bi-database"></i>&nbsp;&nbsp;Faculty Database</a>
                                </li>
                                <li class="nav-item ">
                                    <a href="#vaccine" class="nav-link" data-bs-toggle="modal" data-bs-target="#vacManufacturerModal" style="color:rgb(232, 177, 62);"><i class="bi bi-database"></i>&nbsp;&nbsp;Brand Database</a>
                                </li>
                                <li class="nav-item ">
                                    <button type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#reports" style="color:rgb(232, 177, 62);"><i class="bi bi-clipboard-data-fill"></i>&nbsp;&nbsp;Reports</a></button>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <?php
            include('conn.php');
            $vac = new connection();
            $brand = $vac->display('vacbrand');
            $genders = array('Male', 'Female');


            if (!isset($_GET['submit'])) {
                $_GET['submit'] = 0;
            }
            if (!isset($_GET['edit'])) {
                $_GET['edit'] = 0;
            }
            if (!isset($_GET['delete'])) {
                $_GET['delete'] = 0;
            }
            //insert
            switch ($_GET['submit']) {
                case 1:
                    $table = array('student', 'vaccinestatus', 'logcredentials');
                    $vac->insertInfo($_POST, $table, true, 0);
                    header('location:adminview.php');
                    break;
                case 2:
                    $table = array('faculty', 'vaccinestatus', 'logcredentials');
                    $vac->insertInfo($_POST, $table, true, 2);
                    header('location:adminview.php');
                    break;
                case 3:
                    $table = array('vacbrand');
                    $vac->insertInfo($_POST, $table, true, 0);
                    header('location:adminview.php');
                    break;
                default:
                    break;
            }

            //delete
            switch ($_GET['delete']) {
                case 1:
                    $table = array('student', 'vaccinestatus', 'logcredentials');
                    $vac->deleteInfo($table, 'id', $_GET['delStudentID']);
                    header('location:adminview.php');
                    break;
                case 2:
                    $table = array('faculty', 'vaccinestatus', 'logcredentials');
                    $vac->deleteInfo($table, 'id', $_GET['delFacultyID']);
                    header('location:adminview.php');
                    break;
                case 3:
                    $table = array('vacbrand');
                    $vac->deleteInfo($table, 'brand', $_GET['delVacID']);
                    header('location:adminview.php');
                    break;
                default:
                    break;
            }

            //edit
            switch ($_GET['edit']) {
                case 1:
                    $table = array('student', 'vaccinestatus', 'logcredentials');
                    $vac->updateInfo($_POST, $table, 'id', $_GET['editStudent'], true, 1);
                    header('location:adminview.php');
                    break;
                case 2:
                    $table = array('faculty', 'vaccinestatus', 'logcredentials');
                    $vac->updateInfo($_POST, $table, 'id', $_GET['editFaculty'], true, 3);
                    header('location:adminview.php');
                    break;
                case 3:
                    $table = array('vacbrand');
                    $vac->updateInfo($_POST, $table, 'brand', $_GET['editVac'], true, 1);
                    header('location:adminview.php');
                    break;
                default:
                    break;
            }


            if (isset($_GET['report'])) {
                $vac->report();
            }

            ?>
            <!--content div-->
            <div class="container-fluid col-8">
                <div class="tab-content" id="tableTabContent">
                    <!--Dashboard Tab-->
                    <div class="tab-pane fade position-absolute" style="margin-left:30;" id="dashboard">
                        <p class="fs-2 py-3" style="margin-left:5%; font-weight:900;">Dashboard</p>
                        <div class="container text-center" style="margin-left: 10%;">
                            <div class="row">

                                <div class="lg col-lg mx-3">
                                    <!--Chart-->
                                    <p class="fs-5 pt-2  text-start" style="font-weight:900;" >Vaccine Manufacturer</p>
                                    <p class="text-start">This data shows the percentage of vaccine brands on the data gathered on the population</p>
                                    <div class="vacmanu" id="brandOverall">
                                    </div>
                                    
                                    
                                </div>
                                <div class="col-xl">
                                    <div class="hf col mb-3">
                                        content
                                    </div>
                                    <div class="hf col mt-3">
                                        content
                                    </div>
                                </div>
                                <div class="lg col-lg mx-3">
                                    content
                                </div>
                            </div>
                            <div class="row my-5">
                                <div class="sm col-sm mx-3">
                                    content
                                </div>
                                <div class="sm col-sm mx-3">
                                    content
                                </div>
                                <div class="sm col-sm mx-3">
                                    content
                                </div>
                                <div class="sm col-sm mx-3">
                                    content
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Student Tab-->
                    <div class="tab-pane fade show active position-absolute" style="margin-left:5%;" id="student">
                        <!--search and filter-->
                        <div class="d-flex " style="padding-top:2%; padding-bottom:5%;">
                            <!--year level filter-->
                            <div class="input-group mx-5 ">
                                <select class="form-select" id="yearLevel" autocomplete="off">
                                    <option value="0" hidden>Year Level</option>b
                                    <option value="0">---</option>
                                    <option value="Grade 7">Grade 7</option>
                                    <option value="Grade 8">Grade 8</option>
                                    <option value="Grade 9">Grade 9</option>
                                    <option value="Grade 10">Grade 10</option>
                                    <option value="Grade 11">Grade 11</option>
                                    <option value="Grade 12">Grade 12</option>
                                </select>
                            </div>
                            <!--brand filter-->
                            <div class="input-group mx-5">
                                <select class="form-select" id="brandFilter" autocomplete="off">
                                    <option value="0" hidden>Brand Name</option>
                                    <option value="0">---</option>
                                </select>
                            </div>
                            <!--status filter-->
                            <div class="input-group mx-5">
                                <select class="form-select" id="studentStatus" autocomplete="off">
                                    <option value="0" hidden>Status</option>
                                    <option value="0">---</option>
                                    <option value="Enrolled">Enrolled</option>
                                    <option value="Dropped">Dropped</option>
                                </select>
                            </div>
                            <!--search-->
                            <div>
                                <div class="d-flex mx-5">
                                    <input class="search" type="search" placeholder="Search" aria-label="Search" data-table="#studentContent">
                                    <span class="input-group-text border-0" id="search-addon">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!--table div-->
                        <div class="container mx-5 px-5">
                            <table class="table table-stripe table-borderless" style="display:inline-block;" id="studentTable" data-sortlist="[[0,0], [2,0]]">
                                <thead>
                                    <tr style="background-color:rgb(2, 46, 67) ; color:white;">
                                        <th class="border" scope="col" role="button">ID</th>
                                        <th class="border" scope="col" role="button">Name</th>
                                        <th class="border" scope="col" role="button">Gender</th>
                                        <th class="border" scope="col" role="button">Year Level</th>
                                        <th class="border" scope="col" role="button">Status</th>
                                        <th class="border" scope="col" role="button">1st Dose</th>
                                        <th class="border" scope="col" role="button">2nd Dose</th>
                                        <th class="border" scope="col" role="button">Brand</th>
                                        <th class="border" scope="col" role="button">Booster</th>
                                        <th class="border" scope="col" role="button">Booster Brand</th>
                                    </tr>
                                </thead>

                                <tbody id="studentContent">
                                    <?php
                                    $data = $vac->display('student');
                                    $i = 0;
                                    if (count($data) != 0) {
                                        foreach ($data as $info) {
                                            $vacStatus = $vac->display('vaccinestatus', 'id', $info['id']);
                                            $i++;
                                            $name = str_replace(':', ' ', $info['name']);
                                    ?>
                                            <tr>
                                                <td class="border"> <?php echo $info['id'] ?> </td>
                                                <td class="border"> <?php echo $name ?> </td>
                                                <td class="border"> <?php echo $info['gender'] ?> </td>
                                                <td class="border" id="yearTd" data-yr="<?php echo $info['yearLevel'] ?>"><?php echo $info['yearLevel'] ?></td>
                                                <td class="border" id="statusTd" data-status="<?php echo $info['status'] ?>"><?php echo $info['status'] ?></td>
                                                <td class="border"><?php echo $vacStatus['firstdose'] ?></td>
                                                <td class="border"><?php echo $vacStatus['seconddose'] ?></td>
                                                <td class="border" name="brandTd[0]" data-brand="<?php echo $vacStatus['vacbrand'] ?>"><?php echo $vacStatus['vacbrand'] ?></td>
                                                <td class="border"><?php echo $vacStatus['booster'] ?></td>
                                                <td class="border" name="brandTd[1]"><?php echo $vacStatus['boosterbrand'] ?></td>
                                                <!--edit-->
                                                <td>
                                                    <!--TODO:resize-->
                                                    <a cla type="button" data-bs-toggle="modal" href="adminview.php?editID=<?php echo $info['id'] ?>" data-bs-target="#editStudentModal<?php echo $i ?>">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </a>
                                                </td>
                                                <!--delete info-->
                                                <td>
                                                    <!--TODO:resize-->
                                                    <a type="button" data-bs-toggle="modal" data-bs-target="#deleteStudentModal<?php echo $i ?>">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <!--Edit Student Modal-->
                                            <div class="modal fade" id="editStudentModal<?php echo $i ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" style="margin-left:7%;">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <p class="modal-title fs-2" style="font-weight:900;" id="createStudentLabel">Edit</p>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!--put content here-->
                                                        <?php
                                                        $name = explode(':', $info['name']);
                                                        ?>
                                                        <form action="adminview.php?edit=1&editStudent=<?php echo $info['id'] ?>" method="POST" data-validation="1">
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">ID No.</span>
                                                                        <input type="text" class="form-control" name="id[1]" placeholder="ID No." value="<?php echo $info['id'] ?>" autocomplete="off" required>
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">First Name</span>
                                                                        <input type="text" name="fname[1]" class="form-control" value="<?php echo $name[0] ?>" autocomplete="off" required>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Middle Name</span>
                                                                        <input type="text" name="mname[1]" class="form-control" value="<?php echo $name[1] ?>" autocomplete="off" required>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Last Name</span>
                                                                        <input type="text" name="lname[1]" class="form-control" value="<?php echo $name[2] ?>" autocomplete="off" required>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                        <input type="hidden" name="name[1]">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Year</span>
                                                                        <select class="form-select text-center" name="yearLevel[1]" required>
                                                                            <option value="" hidden>---</option>
                                                                            <option value="Grade 7">Grade 7</option>
                                                                            <option value="Grade 8">Grade 8</option>
                                                                            <option value="Grade 9">Grade 9</option>
                                                                            <option value="Grade 10">Grade 10</option>
                                                                            <option value="Grade 11">Grade 11</option>
                                                                            <option value="Grade 12">Grade 12</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Status</span>
                                                                        <select class="form-select text-center" name="status[1]" required>
                                                                            <option value="" hidden>---</option>
                                                                            <option value="Enrolled">Enrolled</option>
                                                                            <option value="Dropped">Dropped</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Email</span>
                                                                        <input type="email" name="email[1]" class="form-control" id="emailFormControl" value="<?php echo $info['email'] ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Telephone No.</span>
                                                                        <input type="text" name="tel[1]" class="form-control" placeholder="09XXXXXXXX" value="<?php echo $info['tel'] ?>" required>
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Gender</span>
                                                                        <select class="form-select text-center" name="gender[1]" required>
                                                                            <option value="" hidden>Gender</option>
                                                                            <?php
                                                                            foreach ($genders as $gender) {
                                                                                (strcmp($gender, $info['gender']) == 0) ? $state = 'selected' : $state = '';
                                                                            ?>
                                                                                <option value="<?php echo $gender ?>" <?php echo $state ?>><?php echo $gender ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Birthday</span>
                                                                        <input type="date" name="birthday[1]" class="form-control" value="<?php echo $info['birthday'] ?>" required>
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Adress</span>
                                                                        <input type="text" name="address[1]" class="form-control" value="<?php echo $info['address'] ?>" placeholder="Address" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <?php
                                                                    (isset($vacStatus['firstdose'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>
                                                                    <hr>
                                                                    <p class="fs-2" style="font-weight:900;">Vaccine Status</p>
                                                                    <p class="fs-4 fw-bold text-center">1st Dose</p>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Date</span>
                                                                        <input type="hidden" name="firstdose[1]" class="form-control" value="">
                                                                        <input type="date" name="firstdose[1]" data-activate='input[type="text"][name="firstdoctor[1]"], input[type="date"][name="seconddose[1]"], select[name="vacbrand[1]"]' data-required='input[type="text"][name="firstdoctor[1]"], select[name="vacbrand[1]"]' class="form-control" value="<?php echo $vacStatus['firstdose'] ?>" autocomplete="off">
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Doctor</span>
                                                                        <input type="hidden" name="firstdoctor[1]" class="form-control" value="">
                                                                        <input type="text" name="firstdoctor[1]" class="form-control" placeholder="Doctor" value="<?php echo $vacStatus['firstdoctor'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <?php
                                                                    (isset($vacStatus['firstdose'])) ? $state = '' : $state = 'disabled';
                                                                    ?>
                                                                    <p class="fs-4 fw-bold text-center">2nd Dose</p>
                                                                    <div class="col ">
                                                                        <span class="fs-5 fw-semibold">Date</span>
                                                                        <input type="hidden" name="seconddose[1]" class="form-control" value="">
                                                                        <input type="date" name="seconddose[1]" data-activate='input[type="text"][name="seconddoctor[1]"], input[type="date"][name="booster[1]"]' data-required='input[type="text"][name="seconddoctor[1]"]' class="form-control" value="<?php echo $vacStatus['seconddose'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <?php
                                                                    (isset($vacStatus['seconddose'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Date</span>
                                                                        <input type="hidden" name="seconddoctor[1]" class="form-control" value="">
                                                                        <input type="text" name="seconddoctor[1]" class="form-control" placeholder="Doctor" value="<?php echo $vacStatus['seconddoctor'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <?php
                                                                    (isset($vacStatus['firstdose'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>

                                                                    <div class="col text-center">
                                                                        <span class="fs-5 fw-semibold me-4">Vaccine Brand</span>
                                                                        <input type="hidden" name="vacbrand[1]" class="form-control" value="">
                                                                        <select class="form-select text-center" name="vacbrand[1]" value="<?php echo $vacStatus['vacbrand'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                            <option value="" hidden>---</option>
                                                                            <?php
                                                                            foreach ($brand as $data) {
                                                                                (strcmp($data['brand'], $vacStatus['vacbrand']) == 0) ? $state = 'selected' : $state = '';
                                                                            ?>
                                                                                <option value="<?php echo $data['brand'] ?>" <?php echo $state ?>><?php echo $data['brand'] ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <?php
                                                                    (isset($vacStatus['seconddose'])) ? $state = '' : $state = 'disabled';
                                                                    ?>
                                                                    <p class="fs-4 fw-bold text-center">Booster</p>
                                                                    <div class="col ">
                                                                        <span class="fs-5 fw-semibold">Date</span>
                                                                        <input type="hidden" name="booster[1]" class="form-control" value="">
                                                                        <input type="date" name="booster[1]" data-activate='input[type="text"][name="boosterdoctor[1]"], select[name="boosterbrand[1]"]' data-required='input[type="text"][name="boosterdoctor[1]"], select[name="boosterbrand[1]"]' class="form-control" value="<?php echo $vacStatus['booster'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <?php
                                                                    (isset($vacStatus['booster'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Doctor</span>
                                                                        <input type="hidden" name="boosterdoctor[1]" class="form-control" value="">
                                                                        <input type="text" name="boosterdoctor[1]" class="form-control" placeholder="Doctor" value="<?php echo $vacStatus['boosterdoctor'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3 ">
                                                                    <div class="col text-center">
                                                                        <span class="fs-5 fw-semibold me-4">Vaccine Brand</span>
                                                                        <input type="hidden" name="boosterbrand[1]" class="form-control" value="">
                                                                        <select class="form-select text-center" name="boosterbrand[1]" value="<?php echo $vacStatus['boosterbrand'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                            <option value="" hidden>---</option>
                                                                            <?php
                                                                            foreach ($brand as $data) {
                                                                                (strcmp($data['brand'], $vacStatus['boosterbrand']) == 0) ? $state = 'selected' : $state = '';
                                                                            ?>
                                                                                <option value="<?php echo $data['brand'] ?>" <?php echo $state ?>><?php echo $data['brand'] ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn " style="background-color:rgb(16, 45, 65); color:white" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn " style="background-color:rgb(237, 126, 0); color:white">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Delete Student Modal-->
                                            <div class="modal fade" id="deleteStudentModal<?php echo $i ?>" tabindex="-1" aria-labelledby="delStudentLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="Edit" id="delStudentLabel">Confirmation</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!--put content here-->
                                                        <div class="modal-body">
                                                            Are you sure about the deletion?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                            <a type="button" class="btn btn-primary" href="adminview.php?delete=1&delStudentID=<?php echo $info['id'] ?>">Yes</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--insert button-->
                        <div class="d-flex justify-content-center py-2">
                            <button class="btn btn-outline-success" role="button" data-bs-toggle="modal" data-bs-target="#createStudentModal">+</button>
                        </div>
                        <!--Student Insert Modal-->
                        <div class="modal fade" id="createStudentModal" tabindex="-1" aria-labelledby="createStudentLabel" aria-hidden="true" style="margin-left:7%;">
                            <div class="modal-dialog modal-dialog-centered modal-lg overflow-auto">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <p class="modal-title fs-2" style="font-weight:900;" id="createStudentLabel">Student</p>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!--invalid feedback formatting-->
                                    <!--CSS on form-->
                                    <form action="adminview.php?submit=1" method="POST" data-validation="1" data-password="1">
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">ID no.</span>
                                                    <input type="text" class="form-control" name="id[0]" autocomplete="off" required>
                                                    <input type="hidden" name="password[0]" val="">
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">First Name</span>
                                                    <input type="text" name="fname[0]" class="form-control" autocomplete="off" required>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Middle Name</span>
                                                    <input type="text" name="mname[0]" class="form-control" autocomplete="off" required>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Last Name</span>
                                                    <input type="text" name="lname[0]" class="form-control" autocomplete="off" required>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                    <input type="hidden" name="name[0]">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Year Level</span>
                                                    <select class="form-select text-center" name="yearLevel[0]" required>
                                                        <option value="" hidden>---</option>
                                                        <option value="Grade 7">Grade 7</option>
                                                        <option value="Grade 8">Grade 8</option>
                                                        <option value="Grade 9">Grade 9</option>
                                                        <option value="Grade 10">Grade 10</option>
                                                        <option value="Grade 11">Grade 11</option>
                                                        <option value="Grade 12">Grade 12</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Status</span>
                                                    <select class="form-select text-center" name="status[0]" required>
                                                        <option value="" hidden>---</option>
                                                        <option value="Enrolled">Enrolled</option>
                                                        <option value="Dropped">Dropped</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Email</span>
                                                    <input type="email" name="email[0]" class="form-control" id="emailFormControl" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Telephone No.</span>
                                                    <input type="text" name="tel[0]" class="form-control" placeholder="09XXXXXXXXX" required>
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Gender</span>
                                                    <select class="form-select text-center" name="gender[0]" required>
                                                        <option value="" hidden>Gender</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Birthday</span>
                                                    <input type="date" name="birthday[0]" class="form-control" required>
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Address</span>
                                                    <input type="text" name="address[0]" class="form-control" required>
                                                </div>
                                            </div>
                                            <hr>
                                            <p class="fs-2" style="font-weight:900;">Vaccine Status</p>
                                            <div class="row mb-3">
                                                <p class="fs-4 fw-bold text-center">1st Dose</p>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Date</span>
                                                    <input type="hidden" name="firstdose[0]" class="form-control" value="">
                                                    <input type="date" name="firstdose[0]" data-activate='input[type="text"][name="firstdoctor[0]"], input[type="date"][name="seconddose[0]"], select[name="vacbrand[0]"]' data-required='input[type="text"][name="firstdoctor[0]"], select[name="vacbrand[0]"]' class="form-control" autocomplete="off">
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Doctor</span>
                                                    <input type="hidden" name="firstdoctor[0]" class="form-control" value="">
                                                    <input type="text" name="firstdoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="fs-4 fw-bold text-center">2nd Dose</p>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Date</span>
                                                    <input type="hidden" name="seconddose[0]" class="form-control" value="">
                                                    <input type="date" name="seconddose[0]" data-activate='input[type="text"][name="seconddoctor[0]"], input[type="date"][name="booster[0]"]' data-required='input[type="text"][name="seconddoctor[0]"]' class="form-control" autocomplete="off" disabled>
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Doctor</span>
                                                    <input type="hidden" name="seconddoctor[0]" class="form-control" value="">
                                                    <input type="text" name="seconddoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col text-center me-4">
                                                    <span class="fs-5 fw-semibold">Vaccine Brand</span>
                                                    <input type="hidden" name="vacbrand[0]" class="form-control" value="">
                                                    <select class="form-select text-center " name="vacbrand[0]" autocomplete="off" disabled>
                                                        <option value="" hidden>Brand</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="fs-4 fw-bold text-center">Booster</p>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Date</span>
                                                    <input type="hidden" name="booster[0]" class="form-control" value="">
                                                    <input type="date" name="booster[0]" data-activate='input[type="text"][name="boosterdoctor[0]"], select[name="boosterbrand[0]"]' data-required='input[type="text"][name="boosterdoctor[0]"], select[name="boosterbrand[0]"]' class="form-control" autocomplete="off" disabled>
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Doctor</span>
                                                    <input type="hidden" name="boosterdoctor[0]" class="form-control" value="">
                                                    <input type="text" name="boosterdoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col text-center">
                                                    <span class="fs-5 fw-semibold me-4">Vaccine Brand</span>
                                                    <input type="hidden" name="boosterbrand[0]" class="form-control" value="">
                                                    <select class="form-select text-center" name="boosterbrand[0]" autocomplete="off" disabled>
                                                        <option value="" hidden>Booster Brand</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn " style="background-color:rgb(16, 45, 65); color:white" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn " style="background-color:rgb(237, 126, 0); color:white">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Faculty-->
                    <div class=" tab-pane fade position-absolute" style="margin-left:15%;" id="faculty">
                        <!--search and filter-->
                        <div class="d-flex justify-content-end " style="padding-top:2%; padding-bottom:5%; margin-right:8%;">
                            <div class="">
                                <div class="d-flex">
                                    <input class="search" type="search" placeholder="Search" aria-label="Search" data-table="#facultyContent">
                                    <span class="input-group-text border-0" id="search-addon">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--table div-->
                        <div class="container mt-4">
                            <table class="table table-stripe table-borderless" style="display:inline-block;" data-sortlist="[[0,0], [2,0]]">
                                <thead>
                                    <tr style="background-color:rgb(2, 46, 67); color:white;">
                                        <th class="border" scope="col" role="button">ID</th>
                                        <th class="border" scope="col" role="button">Name</th>
                                        <th class="border" scope="col" role="button">Gender</th>
                                        <th class="border" scope="col" role="button">1st Dose</th>
                                        <th class="border" scope="col" role="button">2nd Dose</th>
                                        <th class="border" scope="col" role="button">Brand</th>
                                        <th class="border" scope="col" role="button">Booster</th>
                                        <th class="border" scope="col" role="button">Booster Brand</th>
                                    </tr>
                                </thead>
                                <tbody id="facultyContent">
                                    <?php
                                    $data = $vac->display('faculty');
                                    $i = 0;
                                    if (count($data) != 0) {
                                        foreach ($data as $info) {
                                            $vacStatus = $vac->display('vaccinestatus', 'id', $info['id']);
                                            $i++;
                                            $name = str_replace(':', ' ', $info['name']);
                                    ?>
                                            <tr>
                                                <td class="border"><?php echo $info['id'] ?></td>
                                                <td class="border"><?php echo $name ?></td>
                                                <td class="border"><?php echo $info['gender'] ?></td>
                                                <td class="border"><?php echo $vacStatus['firstdose'] ?></td>
                                                <td class="border"><?php echo $vacStatus['seconddose'] ?></td>
                                                <td class="border"><?php echo $vacStatus['vacbrand'] ?></td>
                                                <td class="border"><?php echo $vacStatus['booster'] ?></td>
                                                <td class="border"><?php echo $vacStatus['boosterbrand'] ?></td>
                                                <!--edit-->
                                                <td>
                                                    <!--TODO:resize-->
                                                    <a cla type="button" data-bs-toggle="modal" href="adminview.php?editID=<?php echo $info['id'] ?>" data-bs-target="#editFacultyModal<?php echo $i ?>">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </a>
                                                </td>
                                                <!--delete info-->
                                                <td>
                                                    <!--TODO:resize-->
                                                    <a type="button" data-bs-toggle="modal" data-bs-target="#deleteFacultyModal<?php echo $i ?>">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <!--Edit Faculty modal-->
                                            <div class="modal fade" id="editFacultyModal<?php echo $i ?>" tabindex="-1" aria-labelledby="editFacultyLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <p class="fs-2" style="font-weight:900;">Edit</p>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!--put content here-->
                                                        <?php
                                                        $name = explode(':', $info['name']);
                                                        ?>
                                                        <form action="adminview.php?edit=2&editFaculty=<?php echo $info['id'] ?>" method="POST" data-validation="2">
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">ID No.</span>
                                                                        <input type="text" class="form-control" name="id[3]" value="<?php echo $info['id'] ?>" autocomplete="off" required>
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">]
                                                                        <span class="fs-5 fw-semibold">First Name</span>
                                                                        <input type="text" name="fname[3]" class="form-control" value="<?php echo $name[0] ?>" autocomplete="off" required>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Middle Name</span>
                                                                        <input type="text" name="mname[3]" class="form-control" value="<?php echo $name[1] ?>" autocomplete="off" required>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Last Name</span>
                                                                        <input type="text" name="lname[3]" class="form-control" value="<?php echo $name[2] ?>" autocomplete="off" required>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                        <input type="hidden" name="name[3]">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Email</span>
                                                                        <input type="email" name="email[3]" class="form-control" id="emailFormControl" value="<?php echo $info['email'] ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Telephone No.</span>
                                                                        <input type="text" name="tel[3]" class="form-control" placeholder="09XXXXXXXX" value="<?php echo $info['tel'] ?>" required>
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Gender</span>
                                                                        <select class="form-select" name="gender[3]" required>
                                                                            <option value="" hidden>Gender</option>
                                                                            <?php
                                                                            foreach ($genders as $gender) {
                                                                                (strcmp($gender, $info['gender']) == 0) ? $state = 'selected' : $state = '';
                                                                            ?>
                                                                                <option value="<?php echo $gender ?>" <?php echo $state ?>><?php echo $gender ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Birthday</span>
                                                                        <input type="date" name="birthday[3]" class="form-control" value="<?php echo $info['birthday'] ?>" required>
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Address</span>
                                                                        <input type="text" name="address[3]" class="form-control" value="<?php echo $info['birthday'] ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <?php
                                                                    (isset($vacStatus['firstdose'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>
                                                                    <hr>
                                                                    <p class="fs-2" style="font-weight:900;">Vaccine Status</p>
                                                                    <p class="fs-4 fw-bold text-center">1st Dose</p>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Date</span>
                                                                        <input type="hidden" name="firstdose[3]" class="form-control" value="">
                                                                        <input type="date" name="firstdose[3]" data-activate='input[type="text"][name="firstdoctor[3]"], input[type="date"][name="seconddose[3]"], select[name="vacbrand[3]"]' data-required='input[type="text"][name="firstdoctor[3]"], select[name="vacbrand[3]"]' class="form-control" value="<?php echo $vacStatus['firstdose'] ?>" autocomplete="off">
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Doctor</span>
                                                                        <input type="hidden" name="firstdoctor[3]" class="form-control" value="">
                                                                        <input type="text" name="firstdoctor[3]" class="form-control" placeholder="Doctor" value="<?php echo $vacStatus['firstdoctor'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <?php
                                                                    (isset($vacStatus['firstdose'])) ? $state = '' : $state = 'disabled';
                                                                    ?>
                                                                    <p class="fs-4 fw-bold text-center">2nd Dose</p>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Date</span>
                                                                        <input type="hidden" name="seconddose[3]" class="form-control" value="">
                                                                        <input type="date" name="seconddose[3]" data-activate='input[type="text"][name="seconddoctor[3]"], input[type="date"][name="booster[3]"]' data-required='input[type="text"][name="seconddoctor[3]"]' class="form-control" value="<?php echo $vacStatus['seconddose'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <?php
                                                                    (isset($vacStatus['seconddose'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Doctor</span>
                                                                        <input type="hidden" name="seconddoctor[3]" class="form-control" value="">
                                                                        <input type="text" name="seconddoctor[3]" class="form-control" placeholder="Doctor" value="<?php echo $vacStatus['seconddoctor'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3 text-center">
                                                                    <?php
                                                                    (isset($vacStatus['firstdose'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>
                                                                    <span class="fs-5 fw-semibold me-4">Vaccine Brand</span>
                                                                    <div class="col text-center">
                                                                        <input type="hidden" name="vacbrand[3]" class="form-control" value="">
                                                                        <select class="form-select text-center" name="vacbrand[3]" value="<?php echo $vacStatus['vacbrand'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                            <option value="" hidden>---</option>
                                                                            <?php
                                                                            $brand = $vac->getData('vacbrand', 'brand');
                                                                            foreach ($brand as $data) {
                                                                                (strcmp($data['brand'], $vacStatus['vacbrand']) == 0) ? $state = 'selected' : $state = '';
                                                                            ?>
                                                                                <option value="<?php echo $data['brand'] ?>" <?php echo $state ?>><?php echo $data['brand'] ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <?php
                                                                    (isset($vacStatus['seconddose'])) ? $state = '' : $state = 'disabled';
                                                                    ?>
                                                                    <p class="fs-4 fw-bold text-center">Booster</p>
                                                                    <div class="col ">
                                                                        <span class="fs-5 fw-semibold me-4">Date</span>
                                                                        <input type="hidden" name="booster[3]" class="form-control" value="">
                                                                        <input type="date" name="booster[3]" data-activate='input[type="text"][name="boosterdoctor[3]"], select[name="boosterbrand[3]"]' data-required='input[type="text"][name="boosterdoctor[3]"], select[name="boosterbrand[3]"]' class="form-control" value="<?php echo $vacStatus['booster'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <?php
                                                                    (isset($vacStatus['booster'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold me-4">Doctor</span>
                                                                        <input type="hidden" name="boosterdoctor[3]" class="form-control" value="">
                                                                        <input type="text" name="boosterdoctor[3]" class="form-control" placeholder="Doctor" value="<?php echo $vacStatus['boosterdoctor'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3 text-center">
                                                                    <span class="fs-5 fw-semibold me-4">Vaccine Brand</span>
                                                                    <div class="col text-center">
                                                                        <input type="hidden" name="boosterbrand[3]" class="form-control" value="">
                                                                        <select class="form-select text-center" name="boosterbrand[3]" autocomplete="off" <?php echo $state ?>>
                                                                            <option value="" hidden>---</option>
                                                                            <?php
                                                                            foreach ($brand as $data) {
                                                                                (strcmp($data['brand'], $vacStatus['boosterbrand']) == 0) ? $state = 'selected' : $state = '';
                                                                            ?>
                                                                                <option value="<?php echo $data['brand'] ?>" <?php echo $state ?>><?php echo $data['brand'] ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn " style="background-color:rgb(16, 45, 65); color:white" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn " style="background-color:rgb(237, 126, 0); color:white">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Delete Modal-->
                                            <div class="modal fade" id="deleteFacultyModal<?php echo $i ?>" tabindex="-1" aria-labelledby="delFacultyLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="Edit" id="delFacultyLabel">Confirmation</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!--put content here-->
                                                        <div class="modal-body">
                                                            Are you sure about the deletion?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                            <a type="button" class="btn btn-primary" href="adminview.php?delete=2&delFacultyID=<?php echo $info['id'] ?>">Yes</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--insert button-->
                        <div class="d-flex justify-content-center py-2">
                            <button class="btn btn-outline-success" role="button" data-bs-toggle="modal" data-bs-target="#createFacultyModal">+</button>
                        </div>
                        <!--Faculty Insert Modal-->
                        <div class="modal fade" id="createFacultyModal" tabindex="-1" aria-labelledby="createFacultyLabel" aria-hidden="true" style="margin-left:7%;">
                            <div class="modal-dialog modal-dialog-centered modal-lg overflow-auto">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <p class="modal-title fs-2" style="font-weight:900;" id="createStudentLabel">Faculty</p>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="adminview.php?submit=2" method="POST" data-validation="2">
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">ID No.</span>
                                                    <input type="text" name="id[2]" class="form-control" autocomplete="off" required>
                                                    <input type="hidden" name="password[2]" val="">
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">First Name</span>
                                                    <input type="text" name="fname[2]" class="form-control" autocomplete="off" required>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Middle Name</span>
                                                    <input type="text" name="mname[2]" class="form-control" autocomplete="off" required>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Last Name</span>
                                                    <input type="text" name="lname[2]" class="form-control" autocomplete="off" required>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                    <input type="hidden" name="name[2]">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Email</span>
                                                    <input type="email" name="email[2]" class="form-control" id="emailFormControl" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Phone No.</span>
                                                    <input type="text" name="tel[2]" class="form-control" placeholder="09XXXXXXXXX" required>
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Gender</span>
                                                    <select class="form-select text-center" name="gender[2]" required>
                                                        <option value="" hidden>---</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Birthday</span>
                                                    <input type="date" name="birthday[2]" class="form-control" required>
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Address</span>
                                                    <input type="text" name="address[2]" class="form-control" required>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mb-3">
                                                <p class="fs-2" style="font-weight:900;">Vaccine Status</p>
                                                <p class="fs-4 fw-bold text-center">1st Dose</p>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Date</span>
                                                    <input type="hidden" name="firstdose[2]" class="form-control" value="">
                                                    <input type="date" name="firstdose[2]" data-activate='input[type="text"][name="firstdoctor[2]"], input[type="date"][name="seconddose[2]"], select[name="vacbrand[2]"]' data-required='input[type="text"][name="firstdoctor[2]"], select[name="vacbrand[2]"]' class="form-control" autocomplete="off">
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Doctor</span>
                                                    <input type="hidden" name="firstdoctor[2]" class="form-control" value="">
                                                    <input type="text" name="firstdoctor[2]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="fs-4 fw-bold text-center">2nd Dose</p>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Date</span>
                                                    <input type="hidden" name="seconddose[2]" class="form-control" value="">
                                                    <input type="date" name="seconddose[2]" data-activate='input[type="text"][name="seconddoctor[2]"], input[type="date"][name="booster[2]"]' data-required='input[type="text"][name="seconddoctor[2]"]' class="form-control" autocomplete="off" disabled>
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Doctor</span>
                                                    <input type="hidden" name="seconddoctor[2]" class="form-control" value="">
                                                    <input type="text" name="seconddoctor[2]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col text-center">
                                                    <span class="fs-5 fw-semibold me-4">Vaccine Brand</span>
                                                    <input type="hidden" name="vacbrand[2]" class="form-control" value="">
                                                    <select class="form-select text-center" name="vacbrand[2]" autocomplete="off" disabled>
                                                        <option hidden>Brand</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="fs-4 fw-bold text-center">Booster</p>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Date</span>
                                                    <input type="hidden" name="booster[2]" class="form-control" value="">
                                                    <input type="date" name="booster[2]" data-activate='input[type="text"][name="boosterdoctor[2]"], select[name="boosterbrand[2]"]' data-required='input[type="text"][name="boosterdoctor[2]"], select[name="boosterbrand[2]"]' class="form-control" autocomplete="off" disabled>
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Doctor</span>
                                                    <input type="hidden" name="boosterdoctor[2]" class="form-control" value="">
                                                    <input type="text" name="boosterdoctor[2]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3 text-center">
                                                <div class="col text-center">
                                                    <span class="fs-5 fw-semibold me-4">Vaccine Brand</span>
                                                    <input type="hidden" name="boosterbrand[2]" class="form-control" value="">
                                                    <select class="form-select text-center" name="boosterbrand[2]" autocomplete="off" disabled>
                                                        <option hidden>Booster Brand</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn" style="background-color:rgb(16, 45, 65); color:white" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn" style="background-color:rgb(237, 126, 0); color:white">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- vaccine modal -->
                    <!--TODO:Modal on Edit and Create not working-->
                    <!--Vac Manufacturer Modal-->
                    <div class="modal fade" id="vacManufacturerModal" tabindex="-1" aria-labelledby="vacManufacturerLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg overflow-auto">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="vacManufacturerLabel">Vaccine Manufacturer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="d-flex" style="margin-left:44%;">
                                        <div class="d-flex">
                                            <input class="search" type="search" placeholder="Search" aria-label="Search" data-table="#vacContent">
                                            <span class="input-group-text border-0" id="search-addon">
                                                <i class="bi bi-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="container mt-4">
                                        <table class="table table-stripe table-borderless rounded" style="margin-left:10%;">
                                            <!--table-->
                                            <thead>
                                                <tr style="background-color:rgb(2, 46, 67) ; color:white;">
                                                    <th class="border" scope="col">Vaccine Brand</th>
                                                </tr>
                                            </thead>
                                            <tbody id="vacContent">
                                                <?php
                                                $i = 0;
                                                $data = $vac->display('vacbrand');
                                                if (count($data) != 0) {
                                                    foreach ($data as $info) {
                                                        $i++;
                                                ?>
                                                        <tr>
                                                            <td class="border"> <?php echo $info['brand'] ?> </td>

                                                            <!--edit vac-->
                                                            <td>
                                                                <!--resize-->
                                                                <a cla type="button" data-bs-toggle="modal" href="adminview.php?editID=<?php echo $info['brand'] ?>" data-bs-target="#upVacModal<?php echo $i ?>">
                                                                    <i class="bi bi-pencil-fill"></i>
                                                                </a>
                                                            </td>

                                                            <!--delete vac-->
                                                            <td>
                                                                <!--resize-->
                                                                <a type="button" data-bs-toggle="modal" data-bs-target="#deleteVacModal<?php echo $i ?>">
                                                                    <i class="bi bi-trash-fill"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <!--update vac-->
                                                        <div class="modal fade" id="upVacModal<?php echo $i ?>" tabindex="-1" aria-labelledby="upVacModal">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="upVacLabel">Edit</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="adminview.php?edit=3&editVac=<?php echo $info['brand'] ?>" method="POST">
                                                                        <div class="modal-body">
                                                                            <div class="row mb-2">
                                                                                <div class="col">
                                                                                    <input type="text" name="brand[1]" class="form-control" placeholder="Brand Name" value="<?php echo $info['brand']; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                                            <button type="submit" class="btn btn-primary">Save Changes</submit>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--Delete Modal-->
                                                        <div class="modal fade" id="deleteVacModal<?php echo $i ?>" tabindex="-1" aria-labelledby="delVacLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="Edit" id="delVacLabel">Confirmation</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <!--put content here-->
                                                                    <div class="modal-body">
                                                                        Are you sure about the deletion?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                                        <a type="button" class="btn btn-primary" href="adminview.php?delete=3&delVacID=<?php echo $info['brand'] ?>">Yes</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center py-2">
                                        <button class="btn btn-outline-success" role="button" data-bs-toggle="modal" data-bs-target="#createVacModal">+</button>
                                    </div>
                                    <!--Create Vac brand modal-->
                                    <div class="modal fade" id="createVacModal" tabindex="-1" aria-labelledby="createVacLabel">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <p class="modal-title fs-2" style="font-weight:900;" id="createStudentLabel">Create</p>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="adminview.php?submit=3" method="POST">
                                                    <div class="modal-body">
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <input type="text" name="brand[0]" class="form-control" placeholder="Brand Name" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Reports modal-->
                    <div class="modal fade" id="reports" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    content here
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--Table Sorter plugin for jQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js" integrity="sha512-qzgd5cYSZcosqpzpn7zF2ZId8f/8CHmFKZ8j7mU4OUXTNRd5g+ZHBPsgKEwoqxCtdQvExE5LprwwPAgoicguNg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('table').tablesorter();
    </script>
</body>

</html>
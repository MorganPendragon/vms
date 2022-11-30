<!doctype html>
<html lang="en">
<!--TODO:Idiotproofing-->
<!--TODO:Pagination on table-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminView</title>
    <link rel="shortcut icon" href="#">
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
            min-width: 697px;
            height: 400px;
            background: #ffffff;
            box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
        }

        .sm {
            width: 300px;
            height: 300px;
            margin-top: 2%;
            margin-right: 20%;
        }

        .vacmanu {
            width: 85%;
            height: 50%;
            margin-left: 10%;



        }

        .chart {
            min-width: 450px;
            height: 400px;
            background: #ffffff;
            box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, 0.25);
            border-radius: 10px;

        }

        .logout {
            margin-top: 100%;
            margin-left: 110px;
            font-size: 24px;
        }
    </style>
    <script type="text/javascript">
        $(function() {
            var chartId = ['firstAndSecond', 'booster', 'firstDoseStudent', 'firstDoseFaculty', 'completeDoseStudent', 'completeDoseFaculty', 'boosterStudent', 'boosterFaculty'];
            var chartTitle = ['Vaccine Brand for First and Second Doses', 'Vaccine Brand for Booster', 'Student', 'Faculty', 'Student', 'Faculty', 'Student', 'Faculty'];
            var chartType = ['doughnut', 'pie'];
            var chart = [];
            var type;
            CanvasJS.addColorSet('chart', [
                '#87bfda',
                '#1e96b3',
                '#022e43',
                '#dd9426',
                '#ed7e00',
                '#3a557a',
                '#90b7cd',
                '#d4eeee',
                '#e2674a',
                '#282f3e',
            ]);
            //chart instantiate
            $.each(chartId, function(index, value) {
                var dataPoints = [];
                //randomizer
                type = Math.floor((Math.random() * 2));
                chart.push(new CanvasJS.Chart(value, {
                    colorSet: 'chart',
                    animationEnabled: true,
                    showInLegend: true,
                    exportFileName: chartTitle[index],
                    exportEnabled: true,
                    data: [{
                        type: chartType[type],
                        dataPoints: dataPoints,
                    }]
                }));
                //Ajax request for charts on dashboard
                $.getJSON("conn.php", {
                        chart: value
                    })
                    .done(function(data) {
                        $.each(data, function(index, value) {
                            dataPoints.push({
                                label: index,
                                y: parseInt(value)
                            });
                        });
                        chart[index].render();
                    });
            });

            $('a[name="editbrand"]').on('click', function() {
                $('input[type="hidden"][name="condition"]').val($(this).data('editbrand'));
                $('input[type="hidden"][name="condition"]').siblings('input[type="text"]').val($(this).data('editbrand'));
            });
            $('a[name="delete"]').on('click', function() {
                $('input[type="hidden"][name="delete"]').val($(this).data('delete'));
            });
        });
    </script>
</head>

<body>
    <header>
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
                                <li class="nav-item ">
                                    <a href="#logout" class="logout nav-link" data-bs-toggle="modal" style="color:rgb(232, 177, 62);"><i class="bi bi-box-arrow-left"></i>&nbsp;&nbsp;Logout</a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <?php
            include('conn.php');
            $vac = new connection();
            $genders = array('Male', 'Female');
            $brand = $vac->display('*', 'vacbrand');

            ?>
            <!--content div-->
            <div class="container-fluid col-8">
                <div class="tab-content" id="tableTabContent">
                    <!--Dashboard Tab-->
                    <div class="tab-pane fade position-absolute" id="dashboard">
                        <p class="fs-2 py-2" style="margin-left:6%; font-weight:900;">Dashboard</p>
                        <div class="container text-center">
                            <div class="d-flex" style="margin-left:49px;">

                                <div class="lg col-lg mx-3">
                                    <!--Chart-->
                                    <p class="text-start ms-3" style="font-weight:900; margin-top:1vh;font-size:24px;">Vaccine Brand for First and Second Dose</p>
                                    <p class="text-start ms-3">This data shows the percentage of first And second dose vaccine on the data gathered on the population</p>
                                    <div class="vacmanu" id="firstAndSecond">
                                    </div>


                                </div>
                                <div class="lg col-lg mx-3">
                                    <p class="text-start ms-3" style="font-weight:900; margin-top:1vh; font-size:24px;">Vaccine Brand for Booster</p>
                                    <p class="text-start ms-3">This data shows the percentage of booster vaccine brands on the data gathered on the population</p>
                                    <div class="vacmanu" id="booster"></div>
                                </div>
                            </div>
                            <div class="d-flex" style="margin-left:1%;">
                                <div class="chart row mb-3 mt-4" style="margin-left:4%;">
                                    <span class="fs-5" style="margin-top:1vh;font-weight:900">First Dose Only</span>
                                    <div id="firstDoseStudent" class="sm col mx-2">
                                    </div>
                                    <div id="firstDoseFaculty" class="sm col mx-3">
                                    </div>
                                </div>
                                <div class="chart row mb-3 mt-4" style="margin-left:4%;">
                                    <span class="fs-5" style="margin-top:1vh;font-weight:900">Complete Dose</span>
                                    <div id="completeDoseStudent" class="sm col mx-2">
                                    </div>
                                    <div id="completeDoseFaculty" class="sm col mx-3">
                                    </div>
                                </div>
                                <div class="chart row mb-3 mt-4" style="margin-left:4%;">
                                    <span class="fs-5" style="margin-top:1vh;font-weight:900">Booster</span>
                                    <div id="boosterStudent" class="sm col mx-2">
                                    </div>
                                    <div id="boosterFaculty" class="sm col mx-3 ">
                                    </div>
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
                                    <?php
                                    foreach ($brand as $data) {
                                    ?>
                                        <option value="<?php echo $data['brand'] ?>"><?php echo $data['brand'] ?></option>
                                    <?php
                                    }
                                    ?>

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
                                        <i class="bi bi-search rounded-pill"></i>
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
                                    $data = $vac->display('*', 'student INNER JOIN vaccinestatus ON student.id = vaccinestatus.id');
                                    $i = 0;
                                    $brand = $vac->display('*', 'vacbrand');

                                    if (count($data) != 0) {
                                        foreach ($data as $info) {
                                            $id = $info['id'];
                                            $name = str_replace(':', ' ', $info['name']);
                                    ?>
                                            <tr>
                                                <td class="border"> <?php echo $info['id'] ?> </td>
                                                <td class="border"> <?php echo $name ?> </td>
                                                <td class="border"> <?php echo $info['gender'] ?> </td>
                                                <td class="border" id="yearTd" data-yr="<?php echo $info['yearLevel'] ?>"><?php echo $info['yearLevel'] ?></td>
                                                <td class="border" id="statusTd" data-status="<?php echo $info['status'] ?>"><?php echo $info['status'] ?></td>
                                                <td class="border"><?php echo $info['firstdose'] ?></td>
                                                <td class="border"><?php echo $info['seconddose'] ?></td>
                                                <td class="border" name="brandTd[0]" data-brand="<?php echo $info['vacbrand'] ?>"><?php echo $info['vacbrand'] ?></td>
                                                <td class="border"><?php echo $info['booster'] ?></td>
                                                <td class="border" name="brandTd[1]"><?php echo $info['boosterbrand'] ?></td>
                                                <!--edit-->
                                                <td>
                                                    <!--TODO:resize-->
                                                    <a cla type="button" data-bs-toggle="modal" href="adminview.php?id=<?php echo $info['id'] ?>" data-bs-target="#editStudentModal<?php echo $i ?>">
                                                        <i class="fa-solid fa-pen-to-square" style="color:rgb(237, 126, 0);"></i>

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
                                                        <form method="POST" data-validation="student" data-action="update"  data-condition="<?php echo $info['id']?>">
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
                                                                        <input type="email" name="email[1]" class="form-control" value="<?php echo $info['email'] ?>" required>
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
                                                                    (isset($info['firstdose'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>
                                                                    <hr>
                                                                    <p class="fs-2" style="font-weight:900;">Vaccine Status</p>
                                                                    <p class="fs-4 fw-bold text-center">1st Dose</p>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Date</span>
                                                                        <input type="date" name="firstdose[1]" data-activate='input[type="text"][name="firstdoctor[1]"], input[type="date"][name="seconddose[1]"], select[name="vacbrand[1]"]' data-required='input[type="text"][name="firstdoctor[1]"], select[name="vacbrand[1]"]' class="form-control" value="<?php echo $info['firstdose'] ?>" autocomplete="off">
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Doctor</span>
                                                                        <input type="text" name="firstdoctor[1]" class="form-control" placeholder="Doctor" value="<?php echo $info['firstdoctor'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <?php
                                                                    (isset($info['firstdose'])) ? $state = '' : $state = 'disabled';
                                                                    ?>
                                                                    <p class="fs-4 fw-bold text-center">2nd Dose</p>
                                                                    <div class="col ">
                                                                        <span class="fs-5 fw-semibold">Date</span>
                                                                        <input type="date" name="seconddose[1]" data-activate='input[type="text"][name="seconddoctor[1]"], input[type="date"][name="booster[1]"]' data-required='input[type="text"][name="seconddoctor[1]"]' class="form-control" value="<?php echo $info['seconddose'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <?php
                                                                    (isset($info['seconddose'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Date</span>
                                                                        <input type="text" name="seconddoctor[1]" class="form-control" placeholder="Doctor" value="<?php echo $info['seconddoctor'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <?php
                                                                    (isset($info['firstdose'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>

                                                                    <div class="col text-center">
                                                                        <span class="fs-5 fw-semibold me-4">Vaccine Brand</span>
                                                                        <select class="form-select text-center" name="vacbrand[1]" autocomplete="off" <?php echo $state ?>>
                                                                            <option value="" hidden>---</option>
                                                                            <?php
                                                                            foreach ($brand as $data) {
                                                                                (strcmp($data['brand'], $info['vacbrand']) == 0) ? $state = 'selected' : $state = '';
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
                                                                    (isset($info['seconddose'])) ? $state = '' : $state = 'disabled';
                                                                    ?>
                                                                    <p class="fs-4 fw-bold text-center">Booster</p>
                                                                    <div class="col ">
                                                                        <span class="fs-5 fw-semibold">Date</span>
                                                                        <input type="date" name="booster[1]" data-activate='input[type="text"][name="boosterdoctor[1]"], select[name="boosterbrand[1]"]' data-required='input[type="text"][name="boosterdoctor[1]"], select[name="boosterbrand[1]"]' class="form-control" value="<?php echo $info['booster'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <?php
                                                                    (isset($info['booster'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Doctor</span>
                                                                        <input type="text" name="boosterdoctor[1]" class="form-control" placeholder="Doctor" value="<?php echo $info['boosterdoctor'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3 ">
                                                                    <div class="col text-center">
                                                                        <span class="fs-5 fw-semibold me-4">Vaccine Brand</span>

                                                                        <select class="form-select text-center" name="boosterbrand[1]" autocomplete="off" <?php echo $state ?>>
                                                                            <option value="" hidden>---</option>
                                                                            <?php
                                                                            foreach ($brand as $data) {
                                                                                (strcmp($data['brand'], $info['boosterbrand']) == 0) ? $state = 'selected' : $state = '';
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
                                                        <form data-action="delete">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="delete" value="<?php echo $info['id'] ?>">
                                                                <input type="hidden" name="table" value="student">
                                                                Are you sure about the deletion?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                                <button type="submit" class="btn btn-primary">Yes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                            $i++;
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
                                    <form data-validation="student" data-action="submit">
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">ID no.</span>
                                                    <input type="text" class="form-control" name="id[0]" autocomplete="off" required>
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
                                                    <input type="email" name="email[0]" class="form-control" required>
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
                                                    <input type="date" name="firstdose[0]" data-activate='input[type="text"][name="firstdoctor[0]"], input[type="date"][name="seconddose[0]"], select[name="vacbrand[0]"]' data-required='input[type="text"][name="firstdoctor[0]"], select[name="vacbrand[0]"]' class="form-control" autocomplete="off">
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Doctor</span>
                                                    <input type="text" name="firstdoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="fs-4 fw-bold text-center">2nd Dose</p>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Date</span>
                                                    <input type="date" name="seconddose[0]" data-activate='input[type="text"][name="seconddoctor[0]"], input[type="date"][name="booster[0]"]' data-required='input[type="text"][name="seconddoctor[0]"]' class="form-control" autocomplete="off" disabled>
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Doctor</span>
                                                    <input type="text" name="seconddoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col text-center me-4">
                                                    <span class="fs-5 fw-semibold">Vaccine Brand</span>
                                                    <select class="form-select text-center " name="vacbrand[0]" autocomplete="off" disabled>
                                                        <option value="" hidden>Brand</option>
                                                        <?php
                                                        foreach ($brand as $data) {
                                                        ?>
                                                            <option value="<?php echo $data['brand'] ?>"><?php echo $data['brand'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="fs-4 fw-bold text-center">Booster</p>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Date</span>
                                                    <input type="date" name="booster[0]" data-activate='input[type="text"][name="boosterdoctor[0]"], select[name="boosterbrand[0]"]' data-required='input[type="text"][name="boosterdoctor[0]"], select[name="boosterbrand[0]"]' class="form-control" autocomplete="off" disabled>
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Doctor</span>
                                                    <input type="text" name="boosterdoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col text-center">
                                                    <span class="fs-5 fw-semibold me-4">Vaccine Brand</span>
                                                    <select class="form-select text-center" name="boosterbrand[0]" autocomplete="off" disabled>
                                                        <option value="" hidden>Booster Brand</option>
                                                        <?php
                                                        foreach ($brand as $data) {
                                                        ?>
                                                            <option value="<?php echo $data['brand'] ?>"><?php echo $data['brand'] ?></option>
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
                    </div>
                    <!--Faculty-->
                    <div class=" tab-pane fade position-absolute" style="margin-left:15%;" id="faculty">
                        <!--search and filter-->
                        <div class="input-group mx-5">
                            <select class="form-select" id="brandFilter" autocomplete="off">
                                <option value="0" hidden>Brand Name</option>
                                <?php
                                foreach ($brand as $data) {
                                ?>
                                    <option value="<?php echo $data['brand'] ?>"><?php echo $data['brand'] ?></option>
                                <?php
                                }
                                ?>

                            </select>
                        </div>
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
                                    $data = $vac->display('*', 'faculty INNER JOIN vaccinestatus ON faculty.id = vaccinestatus.id');
                                    $brand = $vac->display('*', 'vacbrand');
                                    $i = 0;
                                    if (count($data) != 0) {
                                        foreach ($data as $info) {
                                            $name = str_replace(':', ' ', $info['name']);
                                    ?>
                                            <tr>
                                                <td class="border"><?php echo $info['id'] ?></td>
                                                <td class="border"><?php echo $name ?></td>
                                                <td class="border"><?php echo $info['gender'] ?></td>
                                                <td class="border"><?php echo $info['firstdose'] ?></td>
                                                <td class="border"><?php echo $info['seconddose'] ?></td>
                                                <td class="border"><?php echo $info['vacbrand'] ?></td>
                                                <td class="border"><?php echo $info['booster'] ?></td>
                                                <td class="border"><?php echo $info['boosterbrand'] ?></td>
                                                <!--edit-->
                                                <td>
                                                    <!--TODO:resize-->
                                                    <a cla type="button" data-bs-toggle="modal" data-bs-target="#editFacultyModal<?php echo $i ?>">
                                                        <i class="fa-solid fa-pen-to-square" style="color:rgb(237, 126, 0);"></i>
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
                                                        <form data-validation="faculty" data-action="update" data-condition="<?php echo $info['id']?>">
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
                                                                        <input type="email" name="email[3]" class="form-control" value="<?php echo $info['email'] ?>" required>
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
                                                                    (isset($info['firstdose'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>
                                                                    <hr>
                                                                    <p class="fs-2" style="font-weight:900;">Vaccine Status</p>
                                                                    <p class="fs-4 fw-bold text-center">1st Dose</p>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Date</span>
                                                                        <input type="date" name="firstdose[3]" data-activate='input[type="text"][name="firstdoctor[3]"], input[type="date"][name="seconddose[3]"], select[name="vacbrand[3]"]' data-required='input[type="text"][name="firstdoctor[3]"], select[name="vacbrand[3]"]' class="form-control" value="<?php echo $info['firstdose'] ?>" autocomplete="off">
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Doctor</span>
                                                                        <input type="text" name="firstdoctor[3]" class="form-control" placeholder="Doctor" value="<?php echo $info['firstdoctor'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <?php
                                                                    (isset($info['firstdose'])) ? $state = '' : $state = 'disabled';
                                                                    ?>
                                                                    <p class="fs-4 fw-bold text-center">2nd Dose</p>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Date</span>
                                                                        <input type="date" name="seconddose[3]" data-activate='input[type="text"][name="seconddoctor[3]"], input[type="date"][name="booster[3]"]' data-required='input[type="text"][name="seconddoctor[3]"]' class="form-control" value="<?php echo $info['seconddose'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <?php
                                                                    (isset($info['seconddose'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold">Doctor</span>
                                                                        <input type="text" name="seconddoctor[3]" class="form-control" placeholder="Doctor" value="<?php echo $info['seconddoctor'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3 text-center">
                                                                    <?php
                                                                    (isset($info['firstdose'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>
                                                                    <span class="fs-5 fw-semibold me-4">Vaccine Brand</span>
                                                                    <div class="col text-center">
                                                                        <select class="form-select text-center" name="vacbrand[3]" autocomplete="off" <?php echo $state ?>>
                                                                            <option value="" hidden>---</option>
                                                                            <?php
                                                                            foreach ($brand as $data) {
                                                                                (strcmp($data['brand'], $info['vacbrand']) == 0) ? $state = 'selected' : $state = '';
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
                                                                    (isset($info['seconddose'])) ? $state = '' : $state = 'disabled';
                                                                    ?>
                                                                    <p class="fs-4 fw-bold text-center">Booster</p>
                                                                    <div class="col ">
                                                                        <span class="fs-5 fw-semibold me-4">Date</span>
                                                                        <input type="date" name="booster[3]" data-activate='input[type="text"][name="boosterdoctor[3]"], select[name="boosterbrand[3]"]' data-required='input[type="text"][name="boosterdoctor[3]"], select[name="boosterbrand[3]"]' class="form-control" value="<?php echo $info['booster'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--Invalid Feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                    <?php
                                                                    (isset($info['booster'])) ? $state = 'required' : $state = 'disabled';
                                                                    ?>
                                                                    <div class="col">
                                                                        <span class="fs-5 fw-semibold me-4">Doctor</span>
                                                                        <input type="text" name="boosterdoctor[3]" class="form-control" placeholder="Doctor" value="<?php echo $info['boosterdoctor'] ?>" autocomplete="off" <?php echo $state ?>>
                                                                        <!--invalid feedback-->
                                                                        <p class="fw-bolder text-center text-danger"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3 text-center">
                                                                    <span class="fs-5 fw-semibold me-4">Vaccine Brand</span>
                                                                    <div class="col text-center">
                                                                        <select class="form-select text-center" name="boosterbrand[3]" autocomplete="off" <?php echo $state ?>>
                                                                            <option value="" hidden>---</option>
                                                                            <?php
                                                                            foreach ($brand as $data) {
                                                                                (strcmp($data['brand'], $info['boosterbrand']) == 0) ? $state = 'selected' : $state = '';
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
                                                        <form data-action="delete">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="delete" value="<?php echo $info['id'] ?>">
                                                                <input type="hidden" name="table" value="faculty">
                                                                Are you sure about the deletion?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                                <button type="submit" class="btn btn-primary">Yes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                            $i++;
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
                                    <form data-validation="faculty" data-action="submit">
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">ID No.</span>
                                                    <input type="text" name="id[2]" class="form-control" autocomplete="off" required>
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
                                                    <input type="email" name="email[2]" class="form-control" required>
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
                                                    <input type="date" name="firstdose[2]" data-activate='input[type="text"][name="firstdoctor[2]"], input[type="date"][name="seconddose[2]"], select[name="vacbrand[2]"]' data-required='input[type="text"][name="firstdoctor[2]"], select[name="vacbrand[2]"]' class="form-control" autocomplete="off">
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Doctor</span>
                                                    <input type="text" name="firstdoctor[2]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="fs-4 fw-bold text-center">2nd Dose</p>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Date</span>
                                                    <input type="date" name="seconddose[2]" data-activate='input[type="text"][name="seconddoctor[2]"], input[type="date"][name="booster[2]"]' data-required='input[type="text"][name="seconddoctor[2]"]' class="form-control" autocomplete="off" disabled>
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Doctor</span>
                                                    <input type="text" name="seconddoctor[2]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col text-center">
                                                    <span class="fs-5 fw-semibold me-4">Vaccine Brand</span>
                                                    <select class="form-select text-center" name="vacbrand[2]" autocomplete="off" disabled>
                                                        <option value="" hidden>Booster Brand</option>
                                                        <?php
                                                        foreach ($brand as $data) {
                                                        ?>
                                                            <option value="<?php echo $data['brand'] ?>"><?php echo $data['brand'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="fs-4 fw-bold text-center">Booster</p>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Date</span>
                                                    <input type="date" name="booster[2]" data-activate='input[type="text"][name="boosterdoctor[2]"], select[name="boosterbrand[2]"]' data-required='input[type="text"][name="boosterdoctor[2]"], select[name="boosterbrand[2]"]' class="form-control" autocomplete="off" disabled>
                                                    <!--Invalid Feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <span class="fs-5 fw-semibold">Doctor</span>
                                                    <input type="text" name="boosterdoctor[2]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3 text-center">
                                                <div class="col text-center">
                                                    <span class="fs-5 fw-semibold me-4">Vaccine Brand</span>
                                                    <select class="form-select text-center" name="boosterbrand[2]" autocomplete="off" disabled>
                                                        <option value="" hidden>Booster Brand</option>
                                                        <?php
                                                        foreach ($brand as $data) {
                                                        ?>
                                                            <option value="<?php echo $data['brand'] ?>"><?php echo $data['brand'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
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
                    <div>
                        <div class="modal fade position-absolute" id="vacManufacturerModal" tabindex="-1" aria-labelledby="vacManufacturerLabel" aria-hidden="true">
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
                                                    if (count($brand) != 0) {
                                                        foreach ($brand as $info) {
                                                            $i++;
                                                    ?>
                                                            <tr>
                                                                <td class="border"> <?php echo $info['brand'] ?> </td>

                                                                <!--edit vac-->
                                                                <td>
                                                                    <!--resize-->
                                                                    <a type="button" data-bs-toggle="modal" data-bs-dismiss="modal" data-editbrand="<?php echo $info['brand'] ?>" name="editbrand" data-bs-target="#upVacModal">
                                                                        <i class="fa-solid fa-pen-to-square" style="color:rgb(237, 126, 0);"></i>
                                                                    </a>
                                                                </td>

                                                                <!--delete vac-->
                                                                <td>
                                                                    <!--resize-->
                                                                    <a type="button" data-bs-toggle="modal" data-bs-dismiss="modal" data-delete="<?php echo $info['brand'] ?>" name="delete" data-bs-target="#deleteVacModal">
                                                                        <i class="bi bi-trash-fill"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-center py-2">
                                            <button class="btn btn-outline-success" role="button" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#createVacModal">+</button>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Update Modal-->
                        <div class="modal fade" id="upVacModal" tabindex="-1" aria-labelledby="upVacModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="upVacLabel">Edit</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form data-action="update" data-table="vacbrand">
                                        <div class="modal-body">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <input type="hidden" name="condition">
                                                    <input type="text" name="brand" class="form-control" placeholder="Brand Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save Changes</submit>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!--Delete Modal-->
                        <div class="modal fade" id="deleteVacModal" tabindex="-1" aria-labelledby="delVacLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="Edit" id="delVacLabel">Confirmation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!--put content here-->
                                    <form data-action="delete" data-table="vacbrand">
                                        <div class="modal-body">
                                            <input type="hidden" name="delete">
                                            Are you sure about the deletion?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                            <button type="submit" class="btn btn-primary">Yes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--Create Vac brand modal-->
                        <div class="modal fade" id="createVacModal" tabindex="-1" aria-labelledby="createVacLabel">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <p class="modal-title fs-2" style="font-weight:900;" id="createStudentLabel">Create</p>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form data-action="submit" data-table="vacbrand">
                                        <div class="modal-body">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <input type="text" name="brand" class="form-control" placeholder="Brand Name" required>
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
                    <!--Reports modal-->
                    <div class="modal fade" id="reports" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form data-action="report">
                                        <div class="input-group mb-5">
                                            <!--Student Table Filter-->
                                            <select name="yearLevel" class="form-select ms-2" autocomplete="off">
                                                <option value="" hidden>Year Level</option>
                                                <option value="Grade 7">Grade 7</option>
                                                <option value="Grade 8">Grade 8</option>
                                                <option value="Grade 9">Grade 9</option>
                                                <option value="Grade 10">Grade 10</option>
                                                <option value="Grade 11">Grade 11</option>
                                                <option value="Grade 12">Grade 12</option>
                                            </select>
                                            <select class="form-select ms-2" name="vacbrand[0]" autocomplete="off">
                                                <option value="" hidden>Vac Brand</option>
                                                <?php
                                                foreach ($brand as $data) {
                                                ?>
                                                    <option value="<?php echo $data['brand'] ?>"><?php echo $data['brand'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <select class="form-select ms-2" name="boosterbrand[0]" autocomplete="off">
                                                <option value="" hidden>Vac Brand</option>
                                                <?php
                                                foreach ($brand as $data) {
                                                ?>
                                                    <option value="<?php echo $data['brand'] ?>"><?php echo $data['brand'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <!--Faculty Table Filter-->
                                            <select class="form-select ms-2" name="vacbrand[1]" autocomplete="off">
                                                <option value="" hidden>Vac Brand</option>
                                                <?php
                                                foreach ($brand as $data) {
                                                ?>
                                                    <option value="<?php echo $data['brand'] ?>"><?php echo $data['brand'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <select class="form-select ms-2" name="boosterbrand[1]" autocomplete="off">
                                                <option value="" hidden>Vac Brand</option>
                                                <?php
                                                foreach ($brand as $data) {
                                                ?>
                                                    <option value="<?php echo $data['brand'] ?>"><?php echo $data['brand'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div>
                                            <button type="submit" class="btn" style="color:white;background-color:rgb(232, 177, 62); width:200px;">Download Report <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-down" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708l2 2z" />
                                                    <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                                                </svg>
                                            </button>

                                       </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Log out-->
                    <div class="modal" id="logout" tabindex="+1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Log out</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color:rgb(16, 45, 65);color:white;">Cancel</button>
                                    <a href="login.html"><button type="button" class="btn" style="background-color:rgb(232, 177, 62);color:white;">Logout</button></a>
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
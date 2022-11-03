<?php ob_start() ?>
<!doctype html>
<html lang="en">
<!--TODO:Idiotproofing-->
<!--TODO:Pagination on table-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminView</title>
    <!--googlefont-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!--bootstrap icons--->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!--bootstrap js lib-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!--jQuery-->
    <script src="./node_modules/jquery/dist/jquery.js"></script>
    <!--Validation plugin for jQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--Table Sorter plugin for jQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js" integrity="sha512-qzgd5cYSZcosqpzpn7zF2ZId8f/8CHmFKZ8j7mU4OUXTNRd5g+ZHBPsgKEwoqxCtdQvExE5LprwwPAgoicguNg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--Date Picker-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/9dd1cea6a6.js" crossorigin="anonymous"></script>
    <style>
        th {
            cursor: pointer;
        }

        .window-height {
            height: auto;
            position: absolute;
        }


        * {
            margin: 0;
            padding: 0;
        }

        table {
            font-size: 16px;

        }
    </style>
</head>


<body>
    <header>
        <!--navbar gen rep place-->
        <nav class="navbar justify-content-end px-5" style="background-color:#022e43;">
            <ul class="nav">
                <li><a class="btn" type="button" href="adminview.php?report=1">
                        <span class="badge text-bg-light">GENERATE REPORTS</span>
                        </i>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="row">

            <!--sidebar-->
            <div class="container-fluid window-height" aria-orientation="vertical">
                <div class=" row flex-nowrap">
                    <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0" style="background-color:#022e43">
                        <img src="img\logo.png" class="img-fluid" alt="...">
                        <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                            <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="tableTab">
                                <li class="nav-item active">
                                    <a href="#student" class="nav-link active" data-bs-toggle="tab"><i class="fs-2 fa-sharp fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;Student</a>
                                </li>
                                <li class="nav-item active">
                                    <a href="#faculty" class="nav-link" data-bs-toggle="tab"><i class="fs-2 fa-sharp fa-solid fa-user-tie"></i>&nbsp;&nbsp;Faculty</a>
                                </li>
                                <li class="nav-item active">
                                    <a href="#vaccine" class="nav-link" data-bs-toggle="tab"><i class="fs-2 fa-solid fa-syringe"></i>&nbsp;&nbsp;Brand</a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <?php
            include('conn.php');
            $vac = new connection();
            $i = 1;
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
                    $table = array('student', 'vaccineStatus');
                    $vac->insertInfo($_POST, $table);
                    header('location:adminview.php');
                    break;
                case 2:
                    $vac->insertInfo($_POST, 'faculty', 1, true, 1);
                    break;
                case 3:
                    $table = array('vacBrand');
                    $vac->insertInfo($_POST, $table);
                    header('location:adminview.php');
                    break;
                default:
                    break;
            }

            //delete
            switch ($_GET['delete']) {
                case 1:
                    $table = array('student', 'vaccineStatus');
                    $col = array('id', 'id');
                    $vac->deleteInfo($table, $col, $_GET['delStudentID']);
                    header('location:adminview.php');
                    break;
                case 2:
                    $vac->deleteInfo('faculty', 'id', $_GET['delFacultyID']);
                    break;
                case 3:
                    $table = array('vacBrand');
                    $col = array('brand');
                    $vac->deleteInfo($table, $col, $_GET['delVacID']);
                    header('location:adminview.php');
                    break;
                default:
                    break;
            }

            switch ($_GET['edit']) {
                case 1:
                    $vac->updateInfo($_POST, 'student', 'id', $_GET['editStudent'], false);
                    break;
                case 2:
                    $vac->updateInfo($_POST, 'faculty', 'id', $_GET['editFaculty'], true, 1);
                    break;
                case 3:
                    $vac->updateInfo($_POST, 'vacBrand', 'brand', $_GET['editVac']);
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
                    <!--Student Tab-->
                    <div class="tab-pane fade show active position-absolute" id="student">
                        <!--search and filter-->
                        <div class="d-flex py-3">
                            <!--year level filter-->
                            <div class="input-group mx-5">
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
                                    <?php
                                    $data = $vac->displayTable('vacBrand');
                                    foreach ($data as $info) {
                                    ?>
                                        <option value="<?php echo $info['brand'] ?>"><?php echo $info['brand'] ?></option>
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
                                    <input class="search" id="searchStudent" type="search" placeholder="Search" aria-label="Search" data-table="1">
                                    <span class="input-group-text border-0" id="search-addon">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!--table div-->
                        <div class="container mx-5 px-5">
                            <table class="table table-stripe table-borderless" style="display:inline-block; " id="studentTable" data-sortlist="[[0,0], [2,0]]">
                                <thead>
                                    <tr>
                                        <th class="border" scope="col" role="button">ID</th>
                                        <th class="border" scope="col" role="button">Name</th>
                                        <th class="border" scope="col" role="button">Gender</th>
                                        <th class="border" scope="col" role="button">Year Level</th>
                                        <th class="border" scope="col" role="button">Status</th>
                                        <th class="border" scope="col" role="button">Address</th>
                                        <th class="border" scope="col" role="button">Email</th>
                                    </tr>
                                </thead>

                                <tbody id="studentContent">
                                    <?php
                                    $info = $vac->displayTable('student');
                                    for ($i = 0; $i < count($info); $i++) {
                                        $vacStatus = $vac->displayRowByID('vaccineStatus', 'id', $info[$i]['id']);
                                    ?>
                                        <tr>
                                            <td class="border"> <?php echo $info[$i]['id'] ?> </td>
                                            <td class="border"> <?php echo $info[$i]['name'] ?> </td>
                                            <td class="border"> <?php echo $info[$i]['gender'] ?> </td>
                                            <td class="border" id="yearTd" data-yr="<?php echo $info[$i]['yearLevel'] ?>"><?php echo $info[$i]['yearLevel'] ?></td>
                                            <td class="border" id="statusTd" data-status="<?php echo $info[$i]['status'] ?>"><?php echo $info[$i]['status'] ?></td>
                                            <td class="border"> <?php echo $info[$i]['address'] ?> </td>
                                            <td class="border"> <?php echo $info[$i]['email'] ?> </td>
                                            <!--edit-->
                                            <td>
                                                <!--resize-->
                                                <a cla type="button" data-bs-toggle="modal" href="adminview.php?editID=<?php echo $info[$i]['id'] ?>" data-bs-target="#editStudentModal<?php echo $i ?>">
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
                                        <div class="modal fade" id="editStudentModal<?php echo $i ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="Edit" id="editModalLabel">Edit</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <!--put content here-->
                                                    <?php
                                                    $name = explode(' ', $info[$i]['name']);
                                                    ?>
                                                    <form action="adminview.php?edit=1&editStudent=<?php echo $info[$i]['id'] ?>" method="POST" data-form="2">
                                                        <div class="modal-body">
                                                            <input type="text" name="id[0]" placeholder="ID No." autocomplete="off" required>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <input type="text" name="fname[1]" class="form-control" placeholder="First name" value="<?php echo $name[0] ?>" autocomplete="off" required>
                                                                    <!--invalid feedback-->
                                                                    <p class="fw-bolder text-center text-danger"></p>
                                                                </div>
                                                                <div class="col">
                                                                    <input type="text" name="mname[1]" class="form-control" placeholder="Middle name" value="<?php echo $name[1] ?>" autocomplete="off" required>
                                                                    <!--invalid feedback-->
                                                                    <p class="fw-bolder text-center text-danger"></p>
                                                                </div>
                                                                <div class="col">
                                                                    <input type="text" name="lname[1]" class="form-control" placeholder="Last name" value="<?php echo $name[2] ?>" autocomplete="off" required>
                                                                    <!--invalid feedback-->
                                                                    <p class="fw-bolder text-center text-danger"></p>
                                                                    <input type="hidden" name="name[1]">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col input-group">
                                                                    <select class="form-select" name="yearLevel[1]" required>
                                                                        <option value="Grade 7">Grade 7</option>
                                                                        <option value="Grade 8">Grade 8</option>
                                                                        <option value="Grade 9">Grade 9</option>
                                                                        <option value="Grade 10">Grade 10</option>
                                                                        <option value="Grade 11">Grade 11</option>
                                                                        <option value="Grade 12">Grade 12</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col input-group">
                                                                    <select class="form-select" name="status[1]" required>
                                                                        <option value="Enrolled">Enrolled</option>
                                                                        <option value="Dropped">Dropped</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col">
                                                                    <input type="email" name="email[1]" class="form-control" id="emailFormControl" placeholder="Email" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Delete Student Modal-->
                                        <div class="modal fade" id="deleteStudentModal<?php echo $i ?>" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="Edit" id="delModalLabel">Confirmation</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <!--put content here-->
                                                    <div class="modal-body">
                                                        Are you sure about the deletion?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                        <a type="button" class="btn btn-primary" href="adminview.php?delete=1&delStudentID=<?php echo $info[$i]['id'] ?>">Yes</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
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
                        <div class="modal fade" id="createStudentModal" tabindex="-1" aria-labelledby="createStudentLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg overflow-auto">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createModalLabel">Create</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!--TODO:invalid feedback formatting-->
                                    <!--TODO:CSS on form-->
                                    <form action="adminview.php?submit=1" method="POST" data-form="1">
                                        <div class="modal-body">
                                            <input type="hidden" name="id[0]" placeholder="ID No." autocomplete="off" required>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="text" name="fname[0]" class="form-control" placeholder="First name" autocomplete="off" required>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="mname[0]" class="form-control" placeholder="Middle name" autocomplete="off" required>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="lname[0]" class="form-control" placeholder="Last name" autocomplete="off" required>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                    <input type="hidden" name="name[0]">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col input-group">
                                                    <select class="form-select" name="yearLevel[0]" required>
                                                        <option value="Grade 7">Grade 7</option>
                                                        <option value="Grade 8">Grade 8</option>
                                                        <option value="Grade 9">Grade 9</option>
                                                        <option value="Grade 10">Grade 10</option>
                                                        <option value="Grade 11">Grade 11</option>
                                                        <option value="Grade 12">Grade 12</option>
                                                    </select>
                                                </div>
                                                <div class="col input-group">
                                                    <select class="form-select" name="status[0]" required>
                                                        <option value="Enrolled">Enrolled</option>
                                                        <option value="Dropped">Dropped</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="email" name="email[0]" class="form-control" id="emailFormControl" placeholder="Email" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="text" name="tel[0]" class="form-control" placeholder="Telephone No." required>
                                                    <!--Invalid Feedback-->
                                                    <p></p>
                                                </div>
                                                <div class="col input-group">
                                                    <select class="form-select" name="gender[0]" required>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="date" name="birthday[0]" class="form-control" required>
                                                    <!--TODO:Invalid Feedback-->
                                                    <p></p>
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="address[0]" class="form-control" placeholder="Address" required>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mb-3 text-center">
                                                <p class="h5">Vaccine Status</p>
                                                <p class="h6">1st Dose</p>
                                                <div class="col text-center">
                                                    <input type="hidden" name="firstdose[0]" class="form-control" value="">
                                                    <input type="date" name="firstdose[0]" data-activate='input[type="text"][name="firstdoctor[0]"], input[type="date"][name="seconddose[0]"], select[name="vacbrand[0]"]' data-required='input[type="text"][name="firstdoctor[0]"], select[name="vacbrand[0]"]' class="form-control" autocomplete="off">
                                                    <!--TODO:Invalid Feedback-->
                                                    <p></p>
                                                </div>
                                                <div class="col">
                                                    <input type="hidden" name="firstdoctor[0]" class="form-control" value="">
                                                    <input type="text" name="firstdoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3 text-center">
                                                <p class="h6">2nd Dose</p>
                                                <div class="col text-center">
                                                    <input type="hidden" name="seconddose[0]" class="form-control" value="">
                                                    <input type="date" name="seconddose[0]" data-activate='input[type="text"][name="seconddoctor[0]"], input[type="date"][name="booster[0]"]' data-required='input[type="text"][name="seconddoctor[0]"]' class="form-control" autocomplete="off" disabled>
                                                    <!--TODO:Invalid Feedback-->
                                                    <p></p>
                                                </div>
                                                <div class="col">
                                                    <input type="hidden" name="seconddoctor[0]" class="form-control" value="">
                                                    <input type="text" name="seconddoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3 text-center">
                                                <p class="h6">Brand</p>
                                                <div class="col text-center">
                                                    <input type="hidden" name="vacbrand[0]" class="form-control" value="">
                                                    <select id="brandStudent" class="form-select" name="vacbrand[0]" autocomplete="off" disabled>
                                                        <option value=""></option>
                                                        <?php
                                                        $brand = $vac->getData('vacBrand', 'brand');
                                                        foreach ($brand as $data) {
                                                        ?>
                                                            <option value="<?php echo $data['brand'] ?>"><?php echo $data['brand'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3 text-center">
                                                <p class="h6">Booster</p>
                                                <div class="col text-center">
                                                    <input type="hidden" name="booster[0]" class="form-control" value="">
                                                    <input type="date" name="booster[0]" data-activate='input[type="text"][name="boosterdoctor[0]"], select[name="boosterbrand[0]"]' data-required='input[type="text"][name="boosterdoctor[0]"], select[name="boosterbrand[0]"]' class="form-control" autocomplete="off" disabled>
                                                    <!--TODO:Invalid Feedback-->
                                                    <p></p>
                                                </div>
                                                <div class="col">
                                                    <input type="hidden" name="boosterdoctor[0]" class="form-control" value="">
                                                    <input type="text" name="boosterdoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
                                                    <!--invalid feedback-->
                                                    <p class="fw-bolder text-center text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3 text-center">
                                                <p class="h6">Brand</p>
                                                <div class="col text-center">
                                                    <input type="hidden" name="boosterbrand[0]" class="form-control" value="">
                                                    <select id="brandStudent" class="form-select" name="boosterbrand[0]" autocomplete="off" disabled>
                                                        <option value=""></option>
                                                        <?php
                                                        $brand = $vac->getData('vacBrand', 'brand');
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
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Faculty-->
                    <div class="tab-pane fade position-absolute" id="faculty">
                        <div class="d-flex py-3">
                            <div class="input-group mx-5">
                                <select class="form-select" autocomplete="off">
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
                                <select class="form-select" autocomplete="off">
                                    <option value="0" hidden>Brand Name</option>
                                    <option value="0">---</option>
                                    <?php
                                    $data = $vac->displayTable('vacBrand');
                                    foreach ($data as $info) {
                                    ?>
                                        <option value="<?php echo $info['brand'] ?>"><?php echo $info['brand'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!--search-->
                            <div>
                                <div class="d-flex mx-5">
                                    <input class="search " type="search" placeholder="Search" aria-label="Search">
                                    <span class="input-group-text border-0" id="search-addon">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="container mx-5 px-5">
                            <table id="facultyTable" class="table table-stripe table-borderless">
                                <thead>
                                    <th class="border" scope="col" role="button">ID</th>
                                    <th class="border" scope="col" role="button">Name</th>
                                    <th class="border" scope="col" role="button">Gender</th>
                                    <th class="border" scope="col" role="button">Birthday</th>
                                    <th class="border" scope="col">First Dose</th>
                                    <th class="border" scope="col">Second Dose</th>
                                    <th class="border" scope="col" role="button">Brand</th>
                                </thead>
                                <tbody id="facultyContent">
                                    <?php
                                    $info = $vac->displayTable('faculty');
                                    for ($i = 0; $i < count($info); $i++) {
                                    ?>

                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--create modal-->
                        <div class="d-flex justify-content-center py-2">
                            <button class="btn btn-outline-success" role="button" data-bs-toggle="modal" data-bs-target="#createFacultyModal">+</button>
                        </div>

                        <!--Faculty Insert Modal-->
                        <div class="modal fade" id="createFacultyModal" tabindex="-1" aria-labelledby="createFacultyLabel">
                            <div class="modal-dialog modal-dialog-centered modal-lg overflow-auto">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createModalLabel">Create</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="adminview.php?submit=2" method="post" data-form="3">
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="text" name="id[3]" class="form-control" placeholder="ID No." required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="text" name="fname[3]" class="form-control" placeholder="First name" required>
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="mname[3]" class="form-control" placeholder="Middle name" required>
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="lname[3]" class="form-control" placeholder="Last name" required>
                                                </div>
                                                <input type="hidden" name="name[3]">
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col input-group">
                                                    <select class="form-select" name="gender[3]" required>
                                                        <option></option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <input type="date" name="birthday[3]" class="form-control" name="date-field" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="email" name="email[3]" class="form-control" id="emailFormControl" placeholder="Email" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="text" name="address[3]" class="form-control" placeholder="Address" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="text" name="tel[3]" class="form-control" placeholder="Telephone No." required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col text-center">
                                                    <label class="form-check-label" for="firstDose">
                                                        1st Dose
                                                    </label>
                                                    <input type="date" name="firstdose[3]" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col text-center">
                                                    <label class="form-check-label" for="secondDose">
                                                        2nd Dose
                                                    </label>
                                                    <input type="date" name="seconddose[3]" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col text-center">
                                                    <label for="brand">
                                                        Brand
                                                    </label>
                                                    <select class="form-select" name="brand[3]">
                                                        <option></option>
                                                        <?php
                                                        $brand = $vac->getData('vacBrand', 'brand');
                                                        foreach ($brand as $data) {
                                                        ?>
                                                            <option value="<?php echo $data['brand']; ?>"><?php echo $data['brand']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Vaccine Tab-->
                    <div class="tab-pane fade position-absolute w-75" id="vaccine">
                        <div class="d-flex justify-content-center  my-3">
                            <div class="d-flex">
                                <form class="d-flex" role="search">
                                    <input class="search " id="searchVaccine" type="search" placeholder="Search" aria-label="Search">
                                    <span class="input-group-text border-0" id="search-addon">
                                        <i class="bi bi-search"></i>
                                    </span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <table class="table table-stripe table-borderless rounded mx-auto w-auto">
                                <!--table-->
                                <thead>
                                    <tr>
                                        <th class="border" scope="col">Vaccine Brand</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    $data = $vac->displayTable('vacBrand');
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
                                                                    <input type="text" name="brandName[0]" class="form-control" placeholder="Brand Name" value="<?php echo $info['brand']; ?>">
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
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center py-2">
                            <button class="btn btn-outline-success" role="button" data-bs-toggle="modal" data-bs-target="#createVacModal">+</button>
                        </div>
                        <!--Create Vac brand modal-->
                        <div class="modal fade" id="createVacModal" tabindex="-1" aria-labelledby="createVacModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createModalLabel">Create</h5>
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
                </div>
            </div>
        </div>
    </main>
    <script>
        $('table').tablesorter();
    </script>
</body>

</html>
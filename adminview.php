<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminView</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <!--bootstrap js lib-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        //caches selected tab before the page reload and shows the tab on reload
        $(document).ready(function() {
            $('a[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('#myTab a[href="' + activeTab + '"]').tab('show');
            }
        });
        //search on student table
        $(document).ready(function() {
            $("#searchStudent").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#studentContent tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
        //search on faculty
        $(document).ready(function() {
            $("#searchFaculty").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#facultyContent tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</head>

<body>
    <!--navbar-->
    <nav class="nav" style="background-color: #e3f2fd;">
        <ul class="nav nav-tabs" id="myTab">
            <li class="nav-item">
                <a href="#student" class="nav-link" data-bs-toggle="tab">Student</a>
            </li>
            <li class="nav-item">
                <a href="#faculty" class="nav-link" data-bs-toggle="tab">Faculty</a>
            </li>
            <li class="nav-item">
                <a href="#vaccine" class="nav-link" data-bs-toggle="tab">Vaccine</a>
            </li>
        </ul>
    </nav>
    <?php
    include('conn.php');
    $vac = new connection();
    $i = 1;

    //insert
    switch ($_GET['submit']) {
        case 1:
            $vac->insertInfo($_POST, 'student');
            break;
        case 2:
            $vac->insertInfo($_POST, 'faculty', true, 1);
            break;
        case 3:
            $vac->insertInfo($_POST, 'vacBrand');
            break;
        default:
            break;
    }

    //delete
    switch ($_GET['delete']) {
        case 1:
            $vac->deleteInfo('student', 'id', $_GET['delStudentID']);
            break;
        case 2:
            $vac->deleteInfo('faculty', 'id', $_GET['delFacultyID']);
            break;
        case 3:
            $vac->deleteInfo('vacBrand', 'brand', $_GET['delVacID']);
            break;
        default:
            break;
    }

    switch ($_GET['edit']) {
        case 1:
            $vac->updateInfo($_POST, 'student', 'id', $_GET['editStudent']);
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
    <div class="tab-content" id="myTabContent">
        <!--Student Tab-->
        <div class="tab-pane fade" id="student">
            <!--search and insert-->
            <div class="d-flex justify-content-sm-evenly">
                <div>
                    <button class="btn btn-outline-success" role="button" data-bs-toggle="modal" data-bs-target="#createStudentModal">+</button>
                </div>
                <div class="d-flex">
                    <form class="d-flex" role="search">
                        <input class="search " id="searchStudent" type="search" placeholder="Search" aria-label="Search">
                        <span class="input-group-text border-0" id="search-addon">
                            <i class="fas fa-search"></i>
                </div>
            </div>
            <!--table div-->
            <div class="d-flex justify-content-center">
                <table class="table table-striped table-borderless mx-auto w-75" id="studentTable">
                    <thead>
                        <tr>
                            <th class="border" scope="col" onclick="sortTable(0, 'studentTable')" role="button">ID</th>
                            <th class="border" scope="col" onclick="sortTable(1, 'studentTable')" role="button">Name</th>
                            <th class="border" scope="col" onclick="sortTable(2, 'studentTable')" role="button">Gender</th>
                            <th class="border" scope="col" onclick="sortTable(3, 'studentTable')" role="button">Birthdate</th>
                            <th class="border" scope="col" onclick="sortTable(4, 'studentTable')" role="button">Address</th>
                            <th class="border" scope="col" onclick="sortTable(5, 'studentTable')" role="button">Contact No.</th>
                            <th class="border" scope="col" onclick="sortTable(6, 'studentTable')" role="button">Email</th>
                            <th class="border" scope="col">1st Dose</th>
                            <th class="border" scope="col">2nd Dose</th>
                            <th class="border" scope="col" onclick="sortTable(9, 'studentTable')" role="button">Brand</th>
                        </tr>
                    </thead>

                    <tbody id="studentContent">
                        <?php
                        $data = $vac->displayTable('student');
                        $colName = $vac->getColumnName('student');
                        foreach ($data as $info) {
                        ?>
                            <tr>
                                <td class="border"> <?php echo $info['id'] ?> </td>
                                <td class="border"> <?php echo $info['name'] ?> </td>
                                <td class="border"> <?php echo $info['gender'] ?> </td>
                                <td class="border"> <?php echo $info['birthday'] ?> </td>
                                <td class="border"> <?php echo $info['address'] ?> </td>
                                <td class="border"> <?php echo $info['tel']; ?> </td>
                                <td class="border"> <?php echo $info['email'] ?> </td>
                                <td class="border">
                                    <?php
                                    if (isset($info['firstdose'])) {
                                    ?>
                                        <i class="bi bi-check"></i>
                                    <?php
                                    } else {
                                    ?>
                                        <i class="bi bi-x"></i>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td class="border">
                                    <?php
                                    if (isset($info['seconddose'])) {
                                    ?>
                                        <i class="bi bi-check"></i>
                                    <?php
                                    } else {
                                    ?>
                                        <i class="bi bi-x"></i>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td class="border"><?php echo $info['brand'] ?></td>
                                <!--edit-->
                                <td>
                                    <!--resize-->
                                    <a cla type="button" data-bs-toggle="modal" href="adminview.php?editID=<?php echo $info['id'] ?>" data-bs-target="#editStudentModal<?php echo $i ?>">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                </td>
                                <!--delete info-->
                                <td>
                                    <!--resize-->
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
                                        $name = explode(' ', $info['name']);
                                        ?>
                                        <form action="adminview.php?editStudent=<?php echo $info['id']; ?>&edit=1" method="POST">
                                            <div class="modal-body">
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <input type="text" name="upID[0]" class="form-control" placeholder="First name" value="<?php echo $info['id'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <input type="text" name="upFirstName[0]" class="form-control" placeholder="First name" value="<?php echo $name[0] ?>">
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" name="upMiddleName[0]" class="form-control" placeholder="Middle name" value="<?php echo $name[1] ?>">
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" name="upLastName[0]" class="form-control" placeholder="Last name" value="<?php echo $name[2] ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <input type="email" name="upEmail[0]" class="form-control" id="emailFormControl" placeholder="Email" value="<?php echo $info['email']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <input type="text" name="upTel[0]" class="form-control" placeholder="Telephone No." value="<?php echo $info['tel']; ?>">
                                                    </div>
                                                    <div class="col input-group">
                                                        <select class="form-select" name="upGender[0]" required>
                                                            <option></option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <input type="date" name="upDate[0]" class="form-control" name="date-field" value="<?php echo $info['birthday']; ?>">
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" name="upAddress[0]" class="form-control" placeholder="Address" value="<?php echo $info['address']; ?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col text-center">
                                                        <label class="form-check-label" for="firstDose">
                                                            1st Dose
                                                        </label>
                                                        <input type="date" id="firstDose" name="upFirstDose[0]" class="form-control" name="date-field" value="<?php echo $info['firstdose']; ?>">
                                                    </div>
                                                    <div class="col text-center">
                                                        <label class="form-check-label" for="secondDose">
                                                            2nd Dose
                                                        </label>
                                                        <input type="date" id="secondDose" name="upSecondDose[0]" class="form-control" name="date-field" value="<?php echo $info['seconddose']; ?>">
                                                    </div>
                                                    <div class="col text-center">
                                                        <label for="brand">
                                                            Brand
                                                        </label>
                                                        <select id="brand" class="form-select" name="brand[0]" required>
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
                                            <a type="button" class="btn btn-primary" href="adminview.php?delete=1&delStudentID=<?php echo $info['id'] ?>">Yes</a>
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
            <!--Student Insert Modal-->
            <div class="modal fade" id="createStudentModal" tabindex="-1" aria-labelledby="createStudentLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg overflow-auto">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Create</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="adminview.php?submit=1" method="POST">
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" name="id[0]" class="form-control" placeholder="ID No." required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" name="firstName[0]" class="form-control" placeholder="First name" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="middleName[0]" class="form-control" placeholder="Middle name" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="lastName[0]" class="form-control" placeholder="Last name" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="email" name="email[0]" class="form-control" id="emailFormControl" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" name="telephone[0]" class="form-control" placeholder="Telephone No." required>
                                    </div>
                                    <div class="col input-group">
                                        <select class="form-select" name="gender[0]" required>
                                            <option></option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="date" name="birthday[0]" class="form-control" name="date-field" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="address[0]" class="form-control" placeholder="Address" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col text-center">
                                        <label for="firstDose">
                                            1st Dose
                                        </label>
                                        <input type="date" id="firstDose" name="firstdose[0]" class="form-control" name="date-field">
                                    </div>
                                    <div class="col text-center">
                                        <label for="secondDose">
                                            2nd Dose
                                        </label>
                                        <input type="hidden" name="seconddose[0]" class="form-control" name="date-field" value="">
                                        <input type="date" id="secondDose" name="seconddose[0]" class="form-control" name="date-field" disabled>
                                    </div>
                                    <div class="col text-center">
                                        <label for="brand">
                                            Brand
                                        </label>
                                        <select id="brand" class="form-select" name="brand[0]">
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
        <!--Faculty-->
        <div class="tab-pane fade" id="faculty">
            <div class="d-flex">
                <div>
                    <button class="btn btn-outline-success" role="button" data-bs-toggle="modal" data-bs-target="#createFacultyModal">+</button>
                </div>
                <div class="input-group rounded">
                    <input type="text" id="searchFaculty" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                    <span class="input-group-text border-0" id="search-addon">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <table id="facultyTable" class="table table-strip table-borderless mx-auto w-75">
                    <thead>
                        <th class="border" scope="col" onclick="sortTable(0, 'facultyTable')" role="button">ID</th>
                        <th class="border" scope="col" onclick="sortTable(1, 'facultyTable')" role="button">Name</th>
                        <th class="border" scope="col" onclick="sortTable(2, 'facultyTable')" role="button">Gender</th>
                        <th class="border" scope="col" onclick="sortTable(3, 'facultyTable')" role="button">Birthday</th>
                        <th class="border" scope="col" onclick="sortTable(4, 'facultyTable')" role="button">Address</th>
                        <th class="border" scope="col" onclick="sortTable(5, 'facultyTable')" role="button">Telephone</th>
                        <th class="border" scope="col" onclick="sortTable(6, 'facultyTable')" role="button">Email</th>
                        <th class="border" scope="col">First Dose</th>
                        <th class="border" scope="col">Second Dose</th>
                        <th class="border" scope="col" onclick="sortTable(9, 'facultyTable')" role="button">Brand</th>
                    </thead>
                    <?php
                    $i = 1;
                    $data = $vac->displayTable('faculty');
                    foreach ($data as $info) {
                    ?>
                        <tbody id="facultyContent">
                            <td class="border"> <?php echo $info['id'] ?> </td>
                            <td class="border"> <?php echo $info['name'] ?> </td>
                            <td class="border"> <?php echo $info['gender'] ?> </td>
                            <td class="border"> <?php echo $info['birthday'] ?> </td>
                            <td class="border"><?php echo $info['address'] ?></td>
                            <td class="border"> <?php echo $info['tel'] ?></td>
                            <td class="border"> <?php echo $info['email'] ?> </td>
                            <td class="border">
                                <?php
                                if (isset($info['firstdose'])) {
                                ?>
                                    <i class="bi bi-check"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="bi bi-x"></i>
                                <?php
                                }
                                ?>
                            </td>
                            <td class="border">
                                <?php
                                if (isset($info['seconddose'])) {
                                ?>
                                    <i class="bi bi-check"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="bi bi-x"></i>
                                <?php
                                }
                                ?>
                            </td>
                            <td class="border"> <?php echo $info['brand'] ?></td>
                            <!--edit-->
                            <td>
                                <!--Edit Button-->
                                <!--resize-->
                                <a cla type="button" data-bs-toggle="modal" href="adminview.php?editID=<?php echo $info['id'] ?>" data-bs-target="#editFacultyInfoModal<?php echo $i ?>">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </td>
                            <!--delete-->
                            <td>
                                <!--Delete Button-->
                                <!--resize-->
                                <a type="button" data-bs-toggle="modal" data-bs-target="#deleteFacultyInfoModal<?php echo $i ?>">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tbody>
                        <!--Faculty Update Modal-->
                        <div class="modal fade" id="editFacultyInfoModal<?php echo $i ?>" tabindex="-1" aria-labelledby="editFacultyInfoModalLabel<?php echo $i ?>">
                            <div class="modal-dialog modal-dialog-centered modal-lg overflow-auto">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editFacultyInfoModalLabel<?php echo $i ?>">Create</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <?php
                                    $name = explode(' ', $info['name']);
                                    ?>
                                    <form action="adminview.php?editFaculty=<?php echo $info['id']; ?>&edit=2" method="post">
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="text" name="upId[1]" class="form-control" placeholder="ID No." value="<?php echo $info['id'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="text" name="upFirstName[1]" class="form-control" placeholder="First name" value="<?php echo $name[0] ?>" required>
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="upMiddleName[1]" class="form-control" placeholder="Middle name" value="<?php echo $name[1] ?>" required>
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="upLastName[1]" class="form-control" placeholder="Last name" value="<?php echo $name[2] ?>" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col input-group">
                                                    <select class="form-select" name="upGender[1]" required>
                                                        <option></option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <input type="date" name="upBirthday[1]" class="form-control" name="date-field" value="<?php echo $info['birthday'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="email" name="upEmail[1]" class="form-control" id="emailFormControl" placeholder="Email" value="<?php echo $info['email'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="text" name="upAddress[1]" class="form-control" placeholder="Address" value="<?php echo $info['address'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="text" name="upTelephone[1]" class="form-control" placeholder="Telephone No." value="<?php echo $info['tel'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col text-center">
                                                    <label class="form-check-label" for="firstDose">
                                                        1st Dose
                                                    </label>
                                                    <input type="date" id="firstDose" name="upFirstdose[1]" class="form-control" name="date-field" value="<?php echo $info['firstdose'] ?>">
                                                </div>
                                                <div class="col text-center">
                                                    <label class="form-check-label" for="secondDose">
                                                        2nd Dose
                                                    </label>
                                                    <input type="date" id="secondDose" name="upSecondDose[1]" class="form-control" name="date-field" value="<?php echo $info['seconddose'] ?>">
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

                        <!--Faculty Delete Modal-->
                        <div class="modal fade" id="deleteFacultyInfoModal<?php echo $i ?>" tabindex="-1" aria-labelledby="delFacultyLabel" aria-hidden="true">
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
                    ?>
                </table>
            </div>
            <!--Faculty Insert Modal-->
            <div class="modal fade" id="createFacultyModal" tabindex="-1" aria-labelledby="createFacultyLabel">
                <div class="modal-dialog modal-dialog-centered modal-lg overflow-auto">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Create</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="adminview.php?submit=2" method="post">
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" name="id[1]" class="form-control" placeholder="ID No." required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" name="firstName[1]" class="form-control" placeholder="First name" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="middleName[1]" class="form-control" placeholder="Middle name" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="lastName[1]" class="form-control" placeholder="Last name" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col input-group">
                                        <select class="form-select" name="gender[1]" required>
                                            <option></option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="date" name="birthday[1]" class="form-control" name="date-field" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="email" name="email[1]" class="form-control" id="emailFormControl" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" name="address[1]" class="form-control" placeholder="Address" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" name="telephone[1]" class="form-control" placeholder="Telephone No." required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col text-center">
                                        <label class="form-check-label" for="firstDose">
                                            1st Dose
                                        </label>
                                        <input type="date" id="firstDose" name="firstdose[1]" class="form-control" name="date-field">
                                    </div>
                                    <div class="col text-center">
                                        <label class="form-check-label" for="secondDose">
                                            2nd Dose
                                        </label>
                                        <input type="date" id="secondDose" name="seconddose[1]" class="form-control" name="date-field">
                                    </div>
                                    <div class="col text-center">
                                        <label for="brand">
                                            Brand
                                        </label>
                                        <select id="brand" class="form-select" name="brand[1]">
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
        <div class="tab-pane fade" id="vaccine">
            <div class="d-flex">
                <div class="d-flex justify-content-center">
                    <button class="btn btn-outline-success" role="button" data-bs-toggle="modal" data-bs-target="#createVacModal">+</button>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <table class="table table-strip table-borderless">
                    <thead>
                        <tr>
                            <th class="border" scope="col">No.</th>
                            <th class="border" scope="col">Vaccine Brand</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = $vac->displayTable('vacBrand');
                        $i = 1;
                        foreach ($data as $info) {
                        ?>
                            <tr>
                                <th class="border" scope="row"> <?php echo $i++ ?> </th>
                                <td class="border"> <?php echo $info['brand'] ?> </td>

                                <!--edit vac-->
                                <td>
                                    <!--resize-->
                                    <a cla type="button" data-bs-toggle="modal" href="adminview.php?editID=<?php echo $info['id'] ?>" data-bs-target="#upVacModal<?php echo $i ?>">
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
    <div class="d-flex justify-content-center">
        <a href="adminview.php?report=1">Generate Report</a>
    </div>
    <script>
        function sortTable(n, table) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById(table);
            switching = true;
            // Set the sorting direction to ascending:
            dir = "asc";
            /* Make a loop that will continue until
            no switching has been done: */
            while (switching) {
                // Start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /* Loop through all table rows (except the
                first, which contains table headers): */
                for (i = 1; i < (rows.length - 1); i++) {
                    // Start by saying there should be no switching:
                    shouldSwitch = false;
                    /* Get the two elements you want to compare,
                    one from current row and one from the next: */
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    /* Check if the two rows should switch place,
                    based on the direction, asc or desc: */
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    /* If a switch has been marked, make the switch
                    and mark that a switch has been done: */
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    // Each time a switch is done, increase this count by 1:
                    switchcount++;
                } else {
                    //switches to desc
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
</body>

</html>
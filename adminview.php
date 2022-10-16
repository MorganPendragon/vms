<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminView</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</head>

<body>
    <!--navbar-->
    <nav class="navbar" style="background-color: #e3f2fd;">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="home" aria-selected="true">Info</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="vaccine-tab" data-bs-toggle="tab" data-bs-target="#vaccine" type="button" role="tab" aria-controls="vaccine" aria-selected="false">Vaccine</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="dosage-tab" data-bs-toggle="tab" data-bs-target="#dosage" type="button" role="tab" aria-controls="dosage" aria-selected="false">Dosage</button>
            </li>
        </ul>
    </nav>
    <!--content div-->
    <div class="tab-content" id="myTabContent">
        <!--Info Tab-->
        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
            <table class="table table-strip table-borderless">
                <thead>
                    <tr>
                        <th class="border" scope="col">No.</th>
                        <th class="border" scope="col">Name</th>
                        <th class="border" scope="col">Gender</th>
                        <th class="border" scope="col">Birthdate</th>
                        <th class="border" scope="col">Address</th>
                        <th class="border" scope="col">Contact No.</th>
                        <th class="border" scope="col">Email</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    include('conn.php');
                    $vac = new vaccination();
                    $data = $vac->displayTable('info');
                    $i = 1;

                    //Info CUD
                    if (isset($_POST['submitInfo'])) {
                        $vac->insertInfo($_POST);
                    }
                    if (isset($_GET['editID'])) {
                        $vac->updateInfo($_POST, $_GET['editID']);
                    }
                    if (isset($_GET['delID'])) {
                        $vac->deleteInfo('info', 'id', $_GET['delID']);
                    }

                    //Vac CUD
                    if (isset($_POST['submitVac'])) 
                    {
                        $vac->insertVac($_POST);
                    }
                    if(isset($_GET['editVac']))
                    {
                        $vac->updateVac($_POST, $_GET['editVac']);
                    }
                    if (isset($_GET['delVacID'])) 
                    {
                        $vac->deleteInfo('vacBrand', 'id', $_GET['delVacID']);
                    }

                    foreach ($data as $info) {
                    ?>
                        <tr>
                            <th class="border" scope="row"> <?php echo $i++ ?> </th>
                            <td class="border"> <?php echo $info['name'] ?> </td>
                            <td class="border"> <?php echo $info['gender'] ?> </td>
                            <td class="border"> <?php echo $info['birthday'] ?> </td>
                            <td class="border"><?php echo $info['address'] ?></td>
                            <td class="border"> <?php echo $info['tel']; ?></td>
                            <td class="border"> <?php echo $info['email'] ?> </td>

                            <!--edit-->
                            <td>
                                <!--resize-->
                                <a cla type="button" data-bs-toggle="modal" href="adminview.php?editID=<?php echo $info['id'] ?>" data-bs-target="#editInfoModal<?php echo $i ?>">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                <!--Edit Modal-->
                                <div class="modal fade" id="editInfoModal<?php echo $i ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
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
                                            <form action="adminview.php?editID=<?php echo $info['id']; ?>" method="POST">
                                                <div class="modal-body">
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <input type="text" name="upFirstName" class="form-control" placeholder="First name" value="<?php echo $name[0] ?>">
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" name="upMiddleName" class="form-control" placeholder="Middle name" value="<?php echo $name[1] ?>">
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" name="upLastName" class="form-control" placeholder="Last name" value="<?php echo $name[2] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <input type="email" name="upEmail" class="form-control" id="emailFormControl" placeholder="Email" value="<?php echo $info['email']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <input type="text" name="upTel" class="form-control" placeholder="Telephone No." value="<?php echo $info['tel']; ?>">
                                                        </div>
                                                        <div class="col input-group">
                                                            <select class="form-select" name="upGender" required>
                                                                <option></option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <input type="date" name="upDate" class="form-control" name="date-field" value="<?php echo $info['birthday']; ?>" />
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" name="upAddress" class="form-control" placeholder="Address" value="<?php echo $info['address']; ?>">
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
                            </td>

                            <!--delete info-->
                            <td>
                                <!--resize-->
                                <a type="button" data-bs-toggle="modal" data-bs-target="#deleteInfoModal<?php echo $i ?>">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                                <!--Delete Modal-->
                                <div class="modal fade" id="deleteInfoModal<?php echo $i ?>" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
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
                                                <a type="button" class="btn btn-primary" href="adminview.php?delID=<?php echo $info['id'] ?>">Yes</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                <button class="btn btn-outline-success" role="button" data-bs-toggle="modal" data-bs-target="#createInfoModal">+</button>
            </div>
            <!--Create Modal-->
            <div class="modal fade" id="createInfoModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg overflow-auto">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Create</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="adminview.php" method="POST">
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" name="firstName" class="form-control" placeholder="First name" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="middleName" class="form-control" placeholder="Middle name" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="lastName" class="form-control" placeholder="Last name" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="email" name="email" class="form-control" id="emailFormControl" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" name="tel" class="form-control" placeholder="Telephone No." required>
                                    </div>
                                    <div class="col input-group">
                                        <select class="form-select" name="gender" required>
                                            <option></option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="date" name="date" class="form-control" name="date-field" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="address" class="form-control" placeholder="Address" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="submitInfo" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Vaccine Tab-->
        <div class="tab-pane fade" id="vaccine" role="tabpanel" aria-labelledby="vaccine-tab">
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
                                <!--update vac-->
                                <div class="modal fade" id="upVacModal<?php echo $i?>" tabindex="-1" aria-labelledby="upVacModal">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="upVacLabel">Edit</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="adminview.php?editVac=<?php echo $info['id']?>" method="POST">
                                                <div class="modal-body">
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <input type="text" name="brandName" class="form-control" placeholder="Brand Name" value="<?php echo $info['brand'];?>">
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
                            </td>

                            <!--delete vac-->
                            <td>
                                <!--resize-->
                                <a type="button" data-bs-toggle="modal" data-bs-target="#deleteVacModal<?php echo $i ?>">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
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
                                                <a type="button" class="btn btn-primary" href="adminview.php?delVacID=<?php echo $info['id'] ?>">Yes</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
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
                        <form action="adminview.php" method="POST">
                            <div class="modal-body">
                                <div class="row mb-2">
                                    <div class="col">
                                        <input type="text" name="brandName" class="form-control" placeholder="Brand Name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                <button type="submit" name="submitVac" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Dosage Tab-->
        <div class="tab-pane fade" id="dosage" role="tabpanel" aria-labelledby="dosage-tab">
        </div>
    </div>
    <footer>
        <button>
            Generate Reports
        </button>
    </footer>
</body>

</html>
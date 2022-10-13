<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</head>

<body>
    <!---->
    <nav class="navbar" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <div class="d-flex gap-2 col-6 mx-auto">
                <button class="btn btn-outline-success" role="button" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
            </div>
            <form class="search d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <table class="table table-strip">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Name</th>
                <th scope="col">Birthdate</th>
                <th scope="col">Address</th>
                <th scope="col">Contact No.</th>
                <th scope="col">Email</th>
            </tr>
        </thead>

        <tbody>
            <?php
            include('conn.php');
            $vac = new vaccination();
            $data = $vac->displayTable('info');
            $i = 1;

            if (isset($_POST['submit'])) {
                $vac->insertInfo($_POST);
            }
            if (isset($_GET['editID'])) {
                echo $_GET['editID'];
            }
            if (isset($_GET['delID'])) {
                $vac->deleteInfo('info', 'id', $_GET['delID']);
            }
            foreach ($data as $info) {
            ?>
                <tr>
                    <th scope="row"> <?php echo $i++ ?> </th>
                    <td> <?php echo $info['name'] ?> </td>
                    <td> <?php echo $info['birthday'] ?> </td>
                    <td><?php echo $info['address'] ?></td>
                    <td> <?php echo $info['tel']; ?></td>
                    <td> <?php echo $info['email'] ?> </td>

                    <!--edit-->
                    <td>
                        <a type="button" data-bs-toggle="modal" href="adminview.php?editID=<?php echo $info['id'] ?>" data-bs-target="#editModal<?php echo $i ?>">
                            <i class="bi bi-pencil-fill"></i>
                        </a>

                        <!--Edit Modal-->
                        <div class="modal fade" id="editModal<?php echo $i ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
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
                                                    <input type="email" name="email" class="form-control" id="emailFormControl" placeholder="Email" value="<?php echo $info['email']; ?>" required>
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="upTel" class="form-control" placeholder="Telephone No." value="<?php echo $info['tel']; ?>">
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
                    <!--delete-->
                    <td>
                        <a type="button" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $i ?>">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                        <!--Delete Modal-->
                        <div class="modal fade" id="deleteModal<?php echo $i ?>" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
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
                                        <a type="button" class="btn btn-primary" href="adminview.php?delID=<?php echo $info['id'] ?>" ?>Yes</a>
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

    <!--Create Modal-->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="adminview.php" method="POST">
                    <div class="modal-body">
                        <div class="row mb-2">
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
                        <div class="row mb-2">
                            <div class="col">
                                <input type="email" name="email" class="form-control" id="emailFormControl" placeholder="Email" required>
                            </div>
                            <div class="col">
                                <input type="text" name="tel" class="form-control" placeholder="Telephone No." required>
                            </div>
                        </div>
                        <div class="row mb-2">
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
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
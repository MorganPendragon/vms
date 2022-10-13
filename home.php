<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <form>
                <div class="d-flex gap-2 col-6 mx-auto">
                    <a href="#" class="btn btn-outline-success" role="button">Create</a>
                </div>

            </form>
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
                <th scope="col">Contact No.</th>
                <th scope="col">Email</th>
                <th scope="col">Birthdate</th>
                <th scope="col">1st dose</th>
                <th scope="col">2nd dose</th>
            </tr>
        </thead>

        <tbody>
            <?php
            include('conn.php');
            $vac = new vaccination();
            $data = $vac->displayInfo();
            $i = 1;
            if(isset($_GET['delID']))
            {
                header('location:home.php', true, 5);
            }
            foreach ($data as $info) 
            {
                $name = $info['firstName'] . $info['middleName'] . $info['lastName'];
            ?>
                <tr>
                    <th scope="row"> <?php echo $i++ ?> </th>
                    <td> <?php echo $name ?> </td>
                    <td> <?php echo $info['tel']; ?></td>
                    <td> <?php echo $info['email'] ?> </td>
                    <td> <?php echo $info['birthday'] ?> </td>
                    <td>
                        <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox for following text input">
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox for following text input">
                    </td>
                    <!--edit-->
                    <td>
                        <button type ="button" data-bs-toggle = "modal" data-bs-target="#editModal">
                            <i class="bi bi-pencil-fill"></i>
                        </button>

                        <!--Edit Modal-->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="Edit" id="editModalLabel">Edit</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!--put content here-->
                                    <div class="modal-body">
                                        ...
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <?php echo'<a type="button" class="btn btn-primary" href ="home.php?updateID=' . $info['id'].'">Save changes</a>'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <!--delete-->
                    <td>
                        <button type ="button" data-bs-toggle = "modal" data-bs-target="#delModal">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                        <!--Delete Modal-->
                        <div class="modal fade" id="delModal" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="Edit" id="delModalLabel">Confirmation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!--put content here-->
                                    <div class="modal-body">
                                        ...
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <?php echo '<a type="button" class="btn btn-primary" href ="home.php?delID=' . $info['id'] . '">Save changes</a>' ?>
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
</body>

</html>
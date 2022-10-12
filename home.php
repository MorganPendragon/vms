<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<style>
    
</style>
<body>
    <nav class="navbar" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <form>
                <div class="d-flex gap-2 col-6 mx-auto">
                    <a href="#" class="btn btn-outline-success" role="button">Create</a>
                    <a href="#link" class="btn btn-outline-primary" role="button">Read</a>
                    <a href="#link" class="btn btn-outline-success" role="button">Update</a>
                    <a href="#link" class="btn btn-outline-danger" role="button">Delete</a>
                </div>

            </form>
            <form class="search d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>
    </nav>
            <table class="table table-strip">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Email</th>
                    <th scope="col">Birthdate</th>
                    <th scope="col">1st dose</th>
                    <th scope="col">2nd dose</th>
                </tr>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>tite</td>
                    <td>tite</td>
                    <td>tite</td>
                    <td>tite</td>
                    <td>
                        <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox for following text input">
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox for following text input">
                    </td>
                    <!--create-->
                    <td><a href="#"><i class="bi bi-plus-square-fill"></i></a></td>
                    <!--edit-->
                    <td><a href="#"><i class="bi bi-pencil-fill"></i></a></td>
                     <!--delete-->
                    <td><a href="#"><i class="bi bi-trash-fill"></i></td></a>
                    
                </tr>
            </tbody>
            </thead>
        </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>
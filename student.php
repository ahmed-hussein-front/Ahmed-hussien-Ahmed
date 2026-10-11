<?php
require_once('navbar.php');
require_once('config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['score'])) {
    $name = $_POST['name'];
    $score = $_POST['score'];
    if (isset($name,$score) && trim($name)!== "" && trim($score)!== "") {
        $name=trim($name);
        $score=trim($score);
        $safeName = mysqli_real_escape_string($conn, $name);
        $safeScore = mysqli_real_escape_string($conn, $score);

        $insert_sql = "INSERT INTO student( name, score) VALUES ('$safeName', '$safeScore')";
        if(mysqli_query($conn, $insert_sql)){
            header("Location: Student.php");
            exit;
        }
        if(!mysqli_query($conn ,$insert_sql)){
            die("Error inserting data: " . mysqli_connect_error());
        }
    }
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $delete_sql = "DELETE FROM student WHERE id ='$id'";
    mysqli_query($conn, $delete_sql);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./faield traning/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #212529;
            font-weight: 600;
        }

        .form-control {
            border-radius: 6px;
        }

        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn:hover {
            opacity: 0.95;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-lg-5">
            <div class="container-fluid py-5">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <form class="p-4 border rounded-3 shadow-sm bg-white" method="POST">
                            <h1 class="mb-4 text-center">Admin Portal</h1>

                            <div class="mb-3 row align-items-center flex-column">
                                <label for="name" class="col-sm-8 col-form-label fw-bold fs-6">name:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Student Name">
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center flex-column">
                                <label for="score" class="col-sm-8 col-form-label fw-bold fs-6">Score:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="score" id="score" placeholder="Student Score">
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="container-fluid py-5">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Score</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $select_sql = "SELECT * FROM student";
                            $result = mysqli_query($conn, $select_sql);
                            $status = "";

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if ($row["score"] >= 65) {
                                        $status = "Pass";
                                        $statusClass = "bg-success";
                                    } else {
                                        $status = "Fail";
                                        $statusClass = "bg-danger";
                                    }
                                    $delete_sql = "DELETE FROM student WHERE id ='{$row['id']}'";

                                    echo "<tr>
                                     <td>{$row["id"]} </td>
                                     <td> {$row["name"]} </td>
                                    <td> {$row["score"]} </td>
                                    <td class='text-center p-1'>
                                        <span class='badge $statusClass rounded-pill px-2 py-1'>$status</span>
                                    </td>
                                    <td class='text-center p-1'>
                                     <form method='POST' class='d-inline'>
                                         <input type='hidden' height='0' width='0' name='id' value='{$row["id"]}'>
                                         <button type='submit' class='btn btn-danger btn-sm px-2 py-1' name='delete'>Delete</button>
                                     </form>
                                    </td>
                                    </tr>";
                                }
                            }
                            ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
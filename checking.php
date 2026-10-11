<?php
require_once('navbar.php');
require_once('config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./faield traning/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #eef4ff 100%);
            min-height: 100vh;
        }

        .portal-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 0;
            border-radius: 24px;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.12);
        }

        .portal-card .form-control {
            border-radius: 14px;
            border: 1px solid #dfe7ff;
            background: #f8fbff;
            padding: 0.85rem 1rem;
        }

        .portal-card .form-control:focus {
            border-color: #7c8cff;
            box-shadow: 0 0 0 0.2rem rgba(124, 140, 255, 0.15);
        }

        .score-card {
            max-width: 520px;
            margin: 2rem auto 0;
            border: 0;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 18px 40px rgba(37, 99, 235, 0.12);
            background: #ffffff;
        }

        .score-card .card-header {
            background: linear-gradient(135deg, #3b82f6 0%, #7c3aed 100%);
            color: #fff;
            padding: 1.2rem 1.5rem;
            border-bottom: 0;
        }

        .score-card .card-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.04em;
        }

        .score-card .card-body {
            padding: 1.6rem 1.5rem 1rem;
        }

        .student-info-block {
            position: relative;
            padding-top: 1.6rem;
            text-align: center;
        }

        .info-label {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #64748b;
        }

        .status-pill {
            border-radius: 999px;
            padding: 0.6rem 1rem;
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            display: inline-block;
        }

        .score-box {
            background: linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            border-radius: 18px;
            padding: 1.3rem 1rem;
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        .score-label {
            display: block;
            color: #64748b;
            font-size: 0.75rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .score-value {
            font-size: clamp(2.2rem, 5vw, 3.2rem);
            font-weight: 800;
            line-height: 1;
            color: #1e293b;
        }

        .score-card .card-footer {
            background: #fff;
            border-top: 0;
            padding: 1rem 1.5rem 1.4rem;
            color: #64748b;
            font-size: 0.82rem;
            text-align: center;
        }

        .submit-btn {
            background:  #2563eb;
            border: 0;
            border-radius: 14px;
            padding: 0.8rem 1.8rem;
            font-weight: 600;
            box-shadow: 0 12px 24px rgba(79, 70, 229, 0.2);
        }

        .submit-btn:hover {
            filter: brightness(1.05);
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form class="portal-card p-4 p-md-5" method="GET">
                    <h1 class="mb-4 text-center fw-bold text-dark">Student Portal</h1>

                    <div class="mb-3 row align-items-center flex-column">
                        <label for="name" class="col-sm-8 col-form-label fw-bold fs-6 text-center">Enter your name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Student Name">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn submit-btn px-4">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['name'])) {
    $name = trim($_GET['name']);
    if ($name === "") {
        exit;
    }


    $select_sql = "SELECT * FROM student WHERE name LIKE '%$name%'";
    if (mysqli_query($conn, $select_sql)) {
        $result = mysqli_query($conn, $select_sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $name = $row['name'];
                $score = $row['score'];
                $color='';
                $status = '';
                if ($score >=65) {
                    $status = "Pass";
                    $color = "success";
                } else {
                    $status = "Fail";
                    $color = "danger";
                }
                echo "<div class='score-card'>
                        <div class='card-header text-center'>
                            <h2>Official Score</h2>
                        </div>
                        <div class='card-body'>
                            <div class='student-info-block'>
                                <span class='info-label'>Name</span>
                                <h3 class='card-title fw-bold fs-3 mb-0 text-dark text-center'>$name</h3>
                            </div>
                            <div class='student-info-block mt-4'>
                                <span class='info-label'>Status</span>
                                <div class='text-center'>
                                    <span class='status-pill bg-$color text-white'>$status</span>
                                </div>
                            </div>
                            <div class='score-box mt-4'>
                                <span class='score-label'>Score</span>
                                <span class='score-value text-$color'>$score</span>
                            </div>
                        </div>
                        <div class='card-footer'>
                            Created: " . date("Y-m-d H:i") . "
                        </div>
                    </div>";
            }
        }
    }
}

?>
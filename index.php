<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>flights</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
        .btn {
    background-color: #682f2f; 
    color: #ffffff; 
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

h2 {
   font-weight: bold;
   font-family: georgia;
   color: #682f2f; 
}
.btn:hover {
    background-color: #9f6767; 
}
        table tr td:last-child {
            width: 120px;
        }
        td {
            font-weight: bold;
        }
        th {
            color: #682f2f;
        }
        img {
	display: block;
	margin: auto;
	width: 30%;
    border-radius:90%;
  border: 3px solid black;
}   
    </style>
    <img src="Images/booking.jpeg" alt="flights",</img>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Flight Information</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Information</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";

                    // Attempt select query execution 
                    $sql = "SELECT * FROM flights";
                    if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>id</th>";
                            echo "<th>flightnumber</th>";
                            echo "<th>departurecity</th>";
                            echo "<th>destinationcity</th>";
                            echo "<th>departuretime</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['flightnumber'] . "</td>";
                                echo "<td>" . $row['departurecity'] . "</td>";
                                echo "<td>" . $row['destinationcity'] . "</td>";
                                echo "<td>" . $row['departuretime'] . "</td>";
                                echo "<td>";
                                echo '<a href="read.php?id=' . $row['id'] . '" class="mr-3" title="View Information" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                echo '<a href="update.php?id=' . $row['id'] . '" class="mr-3" title="Update Information" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                echo '<a href="delete.php?id=' . $row['id'] . '" title="Delete Information" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else {
                            echo '<div class="alert alert-danger"><em>No information were found.</em></div>';
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>
    </div>
  <!-- Footer Section -->
  <footer>
    <p>&copy; 2023 Sagar Airlines. All Rights Reserved.</p>
  </footer>
<?php
// Include config file
require_once "config.php"; 

// Define variables and initialize with empty values
$flightnumber = $departurecity = $destinationcity = $departuretime = "";
$flightnumber_err = $departurecity_err = $destinationcity_err = $departuretime_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

     // Validate Flight number
     $input_flightnumber = trim($_POST["flightnumber"]);
     if (empty($input_flightnumber)) {
         $flightnumber_err = "Please enter the Flight number.";
     } else {
         $flightnumber = $input_flightnumber;
     }

    // Validate Departure city
    $input_departurecity = trim($_POST["departurecity"]);
    if (empty($input_departurecity)) {
        $departurecity_err = "Please enter a Departure city.";
    } else {
        $departurecity = $input_departurecity;
    }

    // Validate Destination city
    $input_destinationcity = trim($_POST["destinationcity"]);
    if (empty($input_destinationcity)) {
        $destinationcity_err = "Please enter an destination city.";
    } else {
        $destinationcity = $input_destinationcity;
    }

    // Validate Departure time
    $input_departuretime = trim($_POST["departuretime"]);
    if (empty($input_departuretime)) {
        $departuretime_err = "Please enter the Departure time.";
    } else {
        $departuretime = $input_departuretime;
    }

    // Check input errors before inserting in database
    if (empty($flightnumber_err) && empty($departurecity_err) && empty($destinationcity_err) && empty($departuretime_err)) {
        // Prepare an update statement
$sql = "UPDATE flights SET flightnumber=?, departurecity=?, destinationcity=?, departuretime=? WHERE id=?";

if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ssssi", $param_flightnumber, $param_departurecity, $param_destinationcity, $param_departuretime, $param_id);

    // Set parameters
    $param_flightnumber = $flightnumber;
    $param_departurecity = $departurecity;
    $param_destinationcity = $destinationcity;
    $param_departuretime = $departuretime;
    $param_id = $id;

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Records updated successfully. Redirect to landing page
        header("location: index.php");
        exit();
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM flights WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $flightnumber = $row["flightnumber"];
                    $departurecity = $row["departurecity"];
                    $destinationcity = $row["destinationcity"];
                    $departuretime = $row["departuretime"];
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;   
        }
            h2 {
              font-weight: bold;
              font-family: georgia;
              text-shadow: 1px 1px black;
              color:#34c845;
              font-size: 38px;
                }
            p{
                font-weight: bold; 
                font-family: serif;
                font-size: 18px; 
            }
            label{
                font-family: serif;  
                font-size: 20px;
                color: #0c5014; 
            }
            .btn-primary {
    background-color: #34c845; 
    color: #ffffff; 
    border: none;
    padding: 10px 20px;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
.btn-secondary {
    border: none;
    padding: 10px 20px;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
.btn:hover {
    background-color: #88d591; 
}
img {
	display: block;
	margin: auto;
	width: 30%;
    border-radius: 90%;
  border: 3px solid black;
}   
    </style>
      <img src="Images/planes.jpeg" alt="flights",</img>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Information</h2>
                    <p>Please edit the input values and submit to update the flights information.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                            <label>Flight number</label>
                            <input type="text" name="flightnumber" class="form-control <?php echo (!empty($flightnumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $flightnumber; ?>">
                            <span class="invalid-feedback"><?php echo $flightnumber_err; ?></span>
                        </div>   
                    <div class="form-group">
                            <label>Departure city</label>
                            <input type="text" name="departurecity" class="form-control <?php echo (!empty($departurecity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $departurecity; ?>">
                            <span class="invalid-feedback"><?php echo $departurecity_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Destination city</label>
                            <input type="text" name="destinationcity" class="form-control <?php echo (!empty($destinationcity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $destinationcity; ?>">
                            <span class="invalid-feedback"><?php echo $destinationcity_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Departure time</label>
                            <input type="text" name="departuretime" class="form-control <?php echo (!empty($departuretime_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $departuretime; ?>">
                            <span class="invalid-feedback"><?php echo $departuretime_err; ?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
 <!-- Footer Section -->
 <footer>
    <p>&copy; 2023 Sagar Airlines. All Rights Reserved.</p>
  </footer>
</html>
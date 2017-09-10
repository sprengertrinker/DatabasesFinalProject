<?php
    include('empConnectionData.txt');
    $conn = mysqli_connect($server, $user, $pass, $dbname, $port)
    or die('Error connecting to MySQL server.');
?>
<html>
<head>
    <!-- Latest compiled and minified CSS for bootstrap from Max CDN-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <!-- Link to my own stylesheet -->
    <link rel="stylesheet" href="http://ix.cs.uoregon.edu/~moch/CSS/employee.css">
    <title>Employee Added</title>
</head>
<h1>Employee Added</h1>
<hr>
<body>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <ul class="nav nav-pills">
            <li role="presentation"><a href="employeehome.html">Home</a></li>
            <li role="presentation"><a href="viewschedule.php">View Current Schedule</a></li>
            <li role="presentation"><a href="updateschedule.html">Update Schedule</a></li>
            <li role="presentation" class="active"><a href="newemployee.html">Add a New Employee</a></li>
            <li role="presentation"><a href="viewinventories.php">View Store & Online Inventories</a></li>
            <li role="presentation"><a href="updatestore.html">Update Inventory</a></li>
            <li role="presentation"><a href="../Customer_View/customerhome.html">Customer View</a></li>
        </ul>
    </div>
</nav>
<p>Employee Added: </p>

<?php
echo '<pre>';
    $ssn = trim($_POST['ssn']);
    print $ssn;
    print ", ";

    $fname = trim($_POST['fname']);
    print $fname;
    print ", ";

    $lname = trim($_POST['lname']);
    print $lname;
    print ", ";

    $shiftid = trim($_POST['shiftid']);
    print $shiftid;
    print ".";

    $query1 = "INSERT INTO employees (ssn, fname, lname, shiftid) VALUES (?, ?, ?, ?); ";

    $stmt1 = mysqli_prepare($conn, $query1);

    mysqli_stmt_bind_param($stmt1, "issi", $ssn, $fname, $lname, $shiftid);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);

    $query2 = "INSERT INTO payroll (ssn, wage) VALUES (?, 9.95); ";
    $stmt2 = mysqli_prepare($conn, $query2);
    mysqli_stmt_bind_param($stmt2, "i", $ssn);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);

    $query3 = "SELECT * FROM employees ORDER BY shiftid; ";
    $result3 = mysqli_query($conn, $query3) or die(mysqli_error($conn));

    echo "<p><h3>Updated Employees</h3></p>";
    echo "<table style='width:70%'>";
    echo "<tr><th>SSN</th> <th>First Name</th> <th>Last Name</th> <th>Shift #</th></tr>";

    while($row = mysqli_fetch_array($result3, MYSQLI_BOTH)) {
        echo "<tr>";
        echo "<td>$row[ssn]</td> <td>$row[fname]</td> <td>$row[lname]</td> <td>$row[shiftid]</td>";
        echo "</tr>";
    }

    mysqli_free_result($result3);
    echo "</table>";


echo '</pre>';

mysqli_close($conn);
?>

</body>
</html>
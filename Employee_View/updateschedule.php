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
    <link rel="stylesheet" type="text/css" href="http://ix.cs.uoregon.edu/~moch/CSS/employee.css">
    <title>Schedule Updated</title>
</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <ul class="nav nav-pills">
            <li role="presentation"><a href="employeehome.html">Home</a></li>
            <li role="presentation"><a href="viewschedule.php">View Current Schedule</a></li>
            <li role="presentation" class="active"><a href="updateschedule.html">Update Schedule</a></li>
            <li role="presentation"><a href="newemployee.html">Add a New Employee</a></li>
            <li role="presentation"><a href="viewinventories.php">View Store & Online Inventories</a></li>
            <li role="presentation"><a href="updatestore.html">Update Inventory</a></li>
            <li role="presentation"><a href="../Customer_View/customerhome.html">Customer View</a></li>
        </ul>
    </div>
</nav>
<h2>Schedule Updated!</h2>

<?php
echo '<pre>';
    print "Changing Information for: ";
    $empssn = trim($_POST['ssn']);
    $shift = trim($_POST['shift']);
    print $empssn;
    print " is switching to shift: ";
    print $shift;
    print "\n";

    $query1="UPDATE employees SET shiftid = ? WHERE ssn = ?;";
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "ii", $shift, $empssn);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);

    $query2="SELECT fname, lname, shiftid FROM employees; ";
    $result2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));

    echo "<p><h2>New Schedule:</h2></p>";
    echo "<table style='width:70%'>";
    echo "<tr><th>First Name</th> <th>Last Name</th> <th>Shift#</th></tr>";

    while($row = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
        echo "<tr>";
        echo "<td>$row[fname]</td> <td>$row[lname]</td> <td>$row[shiftid]</td>";
        echo "</tr>";
    }

    echo "</table>";



echo '</pre>';

mysqli_close($conn);
?>

</body>
</html>
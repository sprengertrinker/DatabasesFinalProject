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
    <title>Current Schedule</title>
</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <ul class="nav nav-pills">
            <li role="presentation"><a href="employeehome.html">Home</a></li>
            <li role="presentation" class="active"><a href="viewschedule.php">View Current Schedule</a></li>
            <li role="presentation"><a href="updateschedule.html">Update Schedule</a></li>
            <li role="presentation"><a href="newemployee.html">Add a New Employee</a></li>
            <li role="presentation"><a href="viewinventories.php">View Store & Online Inventories</a></li>
            <li role="presentation"><a href="updatestore.html">Update Inventory</a></li>
            <li role="presentation"><a href="../Customer_View/customerhome.html">Customer View</a></li>
        </ul>
    </div>
</nav>
<h1>Current Schedule:</h1>
<?php
echo '<pre>';
    $query1 = "SELECT fname, lname, shiftid FROM employees ORDER BY shiftid; ";

    $result1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));

    echo "<h3>Employees:</h3>";
    echo "<table style='width:70%'>";
    echo "<tr><th>First Name</th> <th>Last Name</th> <th>Shift#</th></tr>";

    while($row = mysqli_fetch_array($result1, MYSQLI_BOTH)) {
        echo "<tr>";
        echo "<td>$row[fname]</td> <td>$row[lname]</td> <td>$row[shiftid]</td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "<h3>Managers:</h3>";
    echo "<table style='width:70%'>";
    echo "<tr><th>First Name</th> <th>Last Name</th> <th>Shift#</th></tr>";

    $query2 = "SELECT fname, lname, shiftid FROM managers ORDER BY shiftid; ";
    $result2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));

    while($row = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
        echo "<tr>";
        echo "<td>$row[fname]</td> <td>$row[lname]</td> <td>$row[shiftid]</td>";
        echo "</tr>";
    }

    echo "</table>";
echo '</pre>';

mysqli_free_result($result);
mysqli_close($conn);
?>



</body>
</html>
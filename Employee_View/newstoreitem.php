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
    <title>Add Item to Store</title>
</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <ul class="nav nav-pills">
            <li role="presentation"><a href="employeehome.html">Home</a></li>
            <li role="presentation"><a href="viewschedule.php">View Current Schedule</a></li>
            <li role="presentation"><a href="updateschedule.html">Update Schedule</a></li>
            <li role="presentation"><a href="newemployee.html">Add a New Employee</a></li>
            <li role="presentation"><a href="viewinventories.php">View Store & Online Inventories</a></li>
            <li role="presentation" class="active"><a href="updatestore.html">Update Inventory</a></li>
            <li role="presentation"><a href="../Customer_View/customerhome.html">Customer View</a></li>
        </ul>
    </div>
</nav>
<center><h1>Adding New Item</h1></center>
<?php
echo '<pre>';
$item_name = trim($_POST['item_name']);
$quantity = trim($_POST['quantity']);
$price = trim($_POST['price']);
$descr = trim($_POST['descr']);

echo "Adding: ";
echo $item_name;
echo "\n";

$query1 = "INSERT INTO allitems (item_name,description) VALUES (?, ?); ";
$stmt1 = mysqli_prepare($conn, $query1);
mysqli_stmt_bind_param($stmt1, "ss", $item_name, $descr);
mysqli_stmt_execute($stmt1);
mysqli_stmt_close($stmt1);

$query2 = "SELECT * FROM allitems; ";
$result2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));

echo "<p><h2>Updated Items</h2></p>";
echo "<table style='width:70%'>";
echo "<tr><th>Item#</th> <th>Item Name</th> <th>Description</th></tr>";

while($row = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
    echo "<tr>";
    echo "<td>$row[item_num]</td> <td>$row[item_name]</td> <td>$row[description]</td>";
    echo "</tr>";
}

mysqli_free_result($result2);
echo "</table>";

$query3 = "SELECT MAX(item_num) AS maxnum FROM allitems; ";
$result3 = mysqli_query($conn, $query3) or die(mysqli_error($conn));
while($row = mysqli_fetch_array($result3, MYSQLI_BOTH)) {
    $item_num = $row[maxnum];
}

mysqli_free_result($result3);

$query4 = "INSERT INTO storeinv (item_num,item_name,quantity,price) VALUES ($item_num, ?, ?, ?); ";
$stmt4 = mysqli_prepare($conn, $query4);
mysqli_stmt_bind_param($stmt4, "sii", $item_name, $quantity, $price);
mysqli_stmt_execute($stmt4);
mysqli_stmt_close($stmt4);

$query5 = "SELECT * FROM storeinv; ";
$result5 = mysqli_query($conn, $query5) or die(mysqli_error($conn));

echo "<p><h2>Updated Store Inventory</h2></p>";
echo "<table style='width:70%'>";
echo "<tr><th>Item#</th> <th>Item Name</th> <th>Quantity</th> <th>Price Per Unit</th></tr>";

while($row = mysqli_fetch_array($result5, MYSQLI_BOTH)) {
    echo "<tr>";
    echo "<td>$row[item_num]</td> <td>$row[item_name]</td> <td>$row[quantity]</td> <td>&#36;$row[price]</td>";
    echo "</tr>";
}

mysqli_free_result($result5);
echo "</table>";

if(isset($_POST['online'])) {
    echo "<p>";
    $onlinequant = trim($_POST['onlinequant']);
    $query6 = "INSERT INTO onlineinv (item_num,item_name,quantity,price) VALUES ($item_num, ?, ?, ?); ";
    $stmt6 = mysqli_prepare($conn, $query6);
    mysqli_stmt_bind_param($stmt6, "sii", $item_name, $onlinequant, $price);
    mysqli_stmt_execute($stmt6);
    mysqli_stmt_close($stmt6);

    $query7 = "SELECT * FROM onlineinv; ";
    $result7 = mysqli_query($conn, $query7) or die(mysqli_error($conn));

    echo "<h2>Updated Online Inventory</h2>";
    echo "<table style='width:70%'>";
    echo "<tr><th>Item#</th> <th>Item Name</th> <th>Quantity</th> <th>Price Per Unit</th></tr>";

    while($row = mysqli_fetch_array($result7, MYSQLI_BOTH)) {
        echo "<tr>";
        echo "<td>$row[item_num]</td> <td>$row[item_name]</td> <td>$row[quantity]</td> <td>&#36;$row[price]</td>";
        echo "</tr>";
    }

    mysqli_free_result($result7);
    echo "</table>";
    echo "</p>";
}



echo '</pre>';

mysqli_close($conn);

?>

</body>
</html>
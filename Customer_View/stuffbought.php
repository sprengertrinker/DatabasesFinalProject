<?php
    include('custConnectionData.txt');
    $conn = mysqli_connect($server, $user, $pass, $dbname, $port) or die('Error connecting to MySQL server.');
?>
<html>
<head>
    <!-- Latest compiled and minified CSS for bootstrap from Max CDN-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <!-- Link to my own stylesheet -->
    <link rel="stylesheet" type="text/css" href="http://ix.cs.uoregon.edu/~moch/CSS/customer.css">
    <title>Thank You!</title>
</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <ul class="nav nav-pills">
            <li role="presentation"><a href="customerhome.html">Customer View</a></li>
            <li role="presentation"><a href="vieworigins.php">View Bean Origins</a></li>
            <li role="presentation" class="active"><a href="buystuff.php">Buy Stuff</a></li>
            <li role="presentation"><a href="../Employee_View/employeehome.html">Employee View</a></li>
        </ul>
    </div>
</nav>
<?php
echo '<pre>';
    $item_num = trim($_POST['item_num']);
    $want = trim($_POST['want']);

    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $addr1 = trim($_POST['addr1']);
    $addr2 = trim($_POST['addr2']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $zipcode = trim($_POST['zipcode']);

    $query1 = "SELECT quantity, item_name, price FROM onlineinv WHERE item_num = $item_num; ";
    $result1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));

    while($row = mysqli_fetch_array($result1, MYSQLI_BOTH)) {
        $curr_num = $row[quantity];
        $name = $row[item_name];
        $price = $row[price];
    }

    $operation = "*";
    $total = eval('return '.$price.$operation.$want.';');


    echo "\n";
    echo "Your Total is: &#36;".$total.".";
    echo "\n";

    if($want <= $curr_num) {
        echo "<h2>Thank you for your purchase!</h2>";

        $query2 = "UPDATE onlineinv SET onlineinv.quantity = onlineinv.quantity - $want WHERE item_num = $item_num; ";
        $result2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));
        echo $want." ".$name."(s) successfully purchased!";

        $query3 = "INSERT INTO customers (fname,lname,address1,address2,city,state,zipcode) VALUES ('$fname','$lname','$addr1','$addr2','$city','$state','$zipcode'); ";
        $result3 = mysqli_query($conn, $query3) or die(mysqli_error($conn));

        $query4 = "SELECT MAX(customer_num) AS maxnum FROM customers; ";
        $result4 = mysqli_query($conn, $query4) or die(mysqli_error($conn));
        while($row = mysqli_fetch_array($result4, MYSQLI_BOTH)) {
             $customer_num = $row[maxnum];
        }

        $query5 = "INSERT INTO orders (order_date,customer_num,ship_charge) VALUES (CURRENT_TIMESTAMP,$customer_num,5.95); ";
        $result5 = mysqli_query($conn, $query5) or die(mysqli_error($conn));

    } else {
        echo "<h2>There are not enough of that item available for you to purchase that many.</h2>";
    }

echo '</pre>';
mysqli_free_result($result1);
mysqli_free_result($result2);
mysqli_free_result($result3);
mysqli_free_result($result4);
mysqli_close($conn);
?>

</body>
</html>
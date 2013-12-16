<!DOCTYPE HTML>
<html ng-app>
<head>
    <title>Package Tracker</title>
    <link rel="stylesheet" href="css/style.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.5/angular.min.js"></script>
</head>
<body>
<header></header>
<div class="wrapper">

    <h1>Package Tracker</h1>


    <br />
    <br />
    <br />


    <div class="login">
        <h2>Login</h2>
        <button>Login with Facebook</button>
        <button>Login with Google+</button>
    </div>

    <br />
    <br />
    <br />


    <h2>Add a New Package</h2>
    <div class="newPackage">
        <form method="post" action="index.php">
            <br />
            <label for="product_name" >Product Name</label>
            <input type="text" id="product_name" name="product_name" placeholder="Product Name" />
            <br />

            <label for="tracking_number" >Tracking Number</label>
            <input type="text" id="tracking_number" name="tracking_number" placeholder="Enter your tracking number here [Optional]" />
            <br />

            <label for="arrival_date">Arrival Date <small>[Optional]</small></label>
            <input type="date" id="arrival_date" name="arrival_date" />
            <br />

            <input type="submit" value="Add Package" />
        </form>
    </div>


    <br />
    <br />
    <br />

    <h2>API</h2>
    <a href="api/index.php">TEST API</a>
</div>
<footer></footer>
</body>
</html>

<!DOCTYPE HTML>
<html ng-app>
<head>
    <title>Package Tracker | Packages</title>
    <link rel="stylesheet" href="bower_components/foundation/css/normalize.css">
    <link rel="stylesheet" href="bower_components/foundation/css/foundation.css">
    <link rel="stylesheet" href="css/style.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.5/angular.min.js"></script>
    <script src="js/packages.js" type="application/javascript"></script>
    <script src="bower_components/moment/min/moment.min.js" type="application/javascript"></script>


</head>
<body>
<header>
    <h1>Package Tracker</h1>
</header>
<div class="wrapper" ng-controller="PackageCtrl">

    <h1>View your Packages</h1>


    <div class="packageItem" ng-repeat="package in packages">

        <div ng-if="package.isEditing">

            <form name="packageForm">

                <div class="row">
                    <div class="small-6 columns" ng-class="{error: packageForm.name.$dirty && packageForm.name.$invalid}">
                        <label for="name">Product Name</label>
                        <input type="text" placeholder="Product Name" ng-model="package.name" id="name" name="name" required />
                        <small ng-show="packageForm.name.$dirty && packageForm.name.$invalid">Product name is required</small>
                    </div>
                </div>

                <div class="row">
                    <div class="small-2 columns">
                        <label for="status">Status</label>
                        <select ng-model="package.status" name="status" id="status">
                            <option>PROCESSING</option>
                            <option>SHIPPING</option>
                            <option>ARRIVED</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-4 columns" ng-class="{error: packageForm.tracking_number.$dirty && packageForm.tracking_number.$invalid}">
                        <label for="tracking_number">Tracking Number</label>
                        <input type="text" placeholder="Tracking Number" ng-model="package.tracking_number" name="tracking_number" id="tracking_number" />
                        <small ng-show="packageForm.tracking_number.$dirty && packageForm.tracking_number.$invalid">Invalid Tracking Number</small>
                    </div>
                </div>

                <div class="row">
                    <div class="small-4 columns" ng-class="{error: packageForm.order_date.$dirty && packageForm.order_date.$invalid}">
                        <label for="order_date" >Order Date</label>
                        <input type="date" placeholder="Order Date" ng-model="package.order_date" name="order_date" id="order_date" />
                        <small ng-show="packageForm.order_date.$dirty && packageForm.order_date.$invalid">Invalid Date</small>
                    </div>
                </div>

                <div class="row">
                    <div class="small-4 columns" ng-class="{error: packageForm.estimated_arrival_date.$dirty && packageForm.estimated_arrival_date.$invalid}">
                        <label for="estimated_arrival_date">Estimated Arrival Date</label>
                        <input type="date" placeholder="Estimated Arrival Date" ng-model="package.estimated_arrival_date" name="estimated_arrival_date" id="estimated_arrival_date" />
                        <small ng-show="packageForm.estimated_arrival_date.$dirty && packageForm.estimated_arrival_date.$invalid">Invalid Date</small>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns" ng-class="{error: packageForm.link.$dirty && packageForm.link.$invalid}">
                        <label for="link">Product Link</label>
                        <input type="url" placeholder="http://www.website.com" ng-model="package.link" name="link" id="link" />
                        <small ng-show="packageForm.link.$dirty && packageForm.link.$invalid">Invalid URL</small>
                    </div>
                </div>

                <div class="row">
                    <div class="small-2 columns" ng-class="{error: packageForm.price.$dirty && packageForm.price.$invalid}">
                        <label for="price">Product Price</label>
                        <input type="number" placeholder="Price" ng-model="package.price" name="price" id="price" />
                        <small ng-show="packageForm.price.$dirty && packageForm.price.$invalid">Invalid Price</small>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <button ng-disabled="packageForm.$invalid" ng-click="savePackage($index)">Save Changes</button>
                        <button ng-click="removePackage($index)">Remove</button>
                    </div>
                </div>
            </form>
        </div>

        <div ng-if="!package.isEditing">

            <label>Product Name: {{package.name}}</label>

            <label>Status: {{package.status}}</label>

            <label>Tracking Number: {{package.tracking_number}}</label>

            <label>Order Date: {{package.order_date}}</label>

            <label>Estimated Arrival Date: {{package.estimated_arrival_date}}</label>

            <label>Estimated Time Until Arrival: {{numberOfDays($index)}} day(s)</label>



            <label>Product Link: <a href="{{package.link}}">{{package.link}}</a></label>

            <label>Product Price: ${{package.price}}</label>

            <div class="row">
                <div class="small-6 columns">
                    <button ng-click="editPackage($index)">Edit</button>
                    <button ng-click="markAsArrived($index)" ng-show="package.status !== 'ARRIVED'">Mark as Arrived</button>
                    <button ng-click="removePackage($index)">Remove</button>
                </div>
            </div>
        </div>
    </div>

    <h2>Add a New Package</h2>
    <div class="newPackage">
            <form name="packageForm">

                <div class="row">
                    <div class="small-6 columns" ng-class="{error: packageForm.name.$invalid}">
                        <label for="name">Product Name</label>
                        <input type="text" placeholder="Product Name" ng-model="package.name" id="name" name="name" required />
                        <small ng-show="packageForm.name.$invalid">Product name is required</small>
                    </div>
                </div>

                <div class="row">
                    <div class="small-2 columns">
                        <label for="status">Status</label>
                        <select ng-model="package.status" name="status" id="status">
                            <option>PROCESSING</option>
                            <option>SHIPPING</option>
                            <option>ARRIVED</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-4 columns" ng-class="{error: packageForm.tracking_number.$invalid}">
                        <label for="tracking_number">Tracking Number</label>
                        <input type="text" placeholder="Tracking Number" ng-model="package.tracking_number" name="tracking_number" id="tracking_number" />
                        <small ng-show="packageForm.tracking_number.$invalid">Invalid Tracking Number</small>
                    </div>
                </div>

                <div class="row">
                    <div class="small-4 columns" ng-class="{error: packageForm.estimated_arrival_date.$invalid}">
                        <label for="estimated_arrival_date">Estimated Arrival Date</label>
                        <input type="date" placeholder="Estimated Arrival Date" ng-model="package.estimated_arrival_date" name="estimated_arrival_date" id="estimated_arrival_date" />
                        <small ng-show="packageForm.estimated_arrival_date.$invalid">Invalid Date</small>
                    </div>
                </div>

                <div class="row">
                    <div class="small-4 columns" ng-class="{error: packageForm.order_date.$invalid}">
                        <label for="order_date" >Order Date</label>
                        <input type="date" placeholder="Order Date" ng-model="package.order_date" name="order_date" id="order_date" />
                        <small ng-show="packageForm.order_date.$invalid">Invalid Date</small>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns" ng-class="{error: packageForm.link.$invalid}">
                        <label for="link">Product Link</label>
                        <input type="url" placeholder="http://www.website.com" ng-model="package.link" name="link" id="link" />
                        <small ng-show="packageForm.link.$invalid">Invalid URL</small>
                    </div>
                </div>

                <div class="row">
                    <div class="small-2 columns" ng-class="{error: packageForm.price.$invalid}">
                        <label for="price">Product Price</label>
                        <input type="number" placeholder="Price" ng-model="package.price" name="price" id="price" />
                        <small ng-show="packageForm.price.$invalid">Invalid Price</small>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <button ng-disabled="packageForm.$invalid" ng-click="addPackage()">Add Package</button>
                        <button ng-click="resetPackage()">Reset</button>
                    </div>
                </div>
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

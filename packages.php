<!DOCTYPE HTML>
<html ng-app>
<head>
    <title>Package Tracker | Packages</title>
    <link rel="stylesheet" href="bower_components/foundation/css/normalize.css">
    <link rel="stylesheet" href="bower_components/foundation/css/foundation.css">
    <link rel="stylesheet" href="css/style.css" >
    <script src="bower_components/moment/min/moment.min.js" type="application/javascript"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.5/angular.min.js"></script>
    <script src="js/packages.js" type="application/javascript"></script>
</head>
<body>
<header>
    <h1>Package Tracker</h1>
</header>
<div class="wrapper" ng-controller="PackageCtrl">

<h1>View your Packages</h1>


<div data-alert class="info alert-box" ng-show="packages.length == 0 && packagesLoaded">
    <h6>Add a new package to get started.</h6>
    <a href="#" class="close">&times;</a>
</div>

<div id="myModal" class="reveal-modal small" data-reveal>
    <h4>Are you sure you want to remove this package?</h4>
    <form name="confirmDeleteForm" ng-submit="closeDialog(true)">
        <button class="alert" type="submit">Confirm</button>
        <button type="button" ng-click="closeDialog(false)">Cancel</button>
    </form>
    <a class="close-reveal-modal">&#215;</a>
</div>

<div class="packageItem" ng-repeat="package in packages">

    <div ng-if="package.isEditing">

        <form name="packageForm" ng-submit="savePackage($index)">

            <div class="row">
                <div class="small-6 columns" ng-class="{error: packageForm.product_name.$dirty && packageForm.product_name.$invalid}">
                    <label for="name">Product Name <small>Required</small></label>
                    <input type="text" placeholder="Product Name" ng-model="package.product_name" id="product_name" name="product_name" required />
                    <small ng-show="packageForm.product_name.$dirty && packageForm.product_name.$invalid">Product name is required</small>
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
                    <button class="" type="submit" ng-disabled="packageForm.$invalid" ng-click="savePackage($index)">Save Changes</button>
                    <button class="alert" type="button" ng-click="requestRemovePackage($index)">Remove</button>
                </div>
            </div>
        </form>
    </div>

    <div ng-if="!package.isEditing">

        <div class="row">
            <div class="small-6 columns">
                <h5>Product Name <small>{{package.product_name}}</small></h5>
            </div>
        </div>
        <div class="row">
            <div class="small-6 columns">
                <h5>Status <small class="{{package.status}}">{{package.status}}</small></h5>
            </div>
        </div>
        <div class="row">
            <div class="small-6 columns">
                <h5>Tracking Number <small>{{package.tracking_number}}</small></h5>
            </div>
        </div>
        <div class="row">
            <div class="small-6 columns">
                <h5>Order Date <small>{{package.order_date}}</small></h5>
            </div>
        </div>
        <div class="row">
            <div class="small-6 columns">
                <h5>Estimated Arrival Date <small>{{package.estimated_arrival_date}}</small></h5>
            </div>
        </div>
        <div class="row">
            <div class="small-6 columns">
                <h5>Estimated Time Until Arrival <small>{{numberOfDays($index)}} day(s)</small></h5>
            </div>
        </div>
        <div class="row">
            <div class="small-6 columns">
                <h5>Product Link <small><a href="{{package.link}}">{{package.link}}</a></small></h5>
            </div>
        </div>

        <div class="row">
            <div class="small-6 columns">
                <h5>Product Price <small>${{package.price.toFixed(2)}}</small></h5>
            </div>
        </div>

        <div class="row">
            <div class="small-6 columns">
                <button class="" ng-click="editPackage($index)">Edit</button>
                <button class="success" ng-click="markAsArrived($index)" ng-show="package.status !== 'ARRIVED'">Mark as Arrived</button>
                <button class="alert" ng-click="requestRemovePackage($index)">Remove</button>
            </div>
        </div>
    </div>
</div>

<h2>Add a New Package</h2>
<div class="newPackage">
    <form name="packageForm" ng-submit="addPackage()">

        <div class="row">
            <div class="small-6 columns" ng-class="{error: packageForm.product_name.$invalid}">
                <label for="name">Product Name <small>Required</small></label>
                <input type="text" placeholder="Product Name" ng-model="package.product_name" id="product_name" name="product_name" required />
                <small ng-show="packageForm.product_name.$invalid">Product name is required</small>
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
                <input type="number" placeholder="Price" ng-model="package.price" step=".01" name="price" id="price" />
                <small ng-show="packageForm.price.$invalid">Invalid Price</small>
            </div>
        </div>

        <div class="row">
            <div class="small-6 columns">
                <button class="" type="submit" ng-disabled="packageForm.$invalid">Add Package</button>
                <button class="alert" type="reset" ng-click="resetPackage()">Reset</button>
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

<script src="bower_components/foundation/js/vendor/jquery.js" type="application/javascript"></script>
<script src="bower_components/foundation/js/foundation.min.js" type="application/javascript"></script>
<script src="bower_components/foundation/js/foundation/foundation.reveal.js" type="application/javascript"></script>
<script>
    $(document).foundation();
</script>
</body>
</html>

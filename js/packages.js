
function PackageCtrl($scope,$http) {

    $scope.packagesLoaded = false;

    $scope.package =
    {
        product_name:'',
        status: 'PROCESSING',
        tracking_number: '',
        estimated_arrival_date: '',
        order_date: moment().format('YYYY-MM-DD'),
        link: '',
        price: '',
        isEditing: false
    };

    $scope.selectedIndex = -1;

    $scope.packages = [];


    $scope.verifyTrackingNumber = function(tracking_number) {

        var isValid = $scope.isFedex(tracking_number);
        return isValid;
    };

    $scope.isFedex = function(tracking_number) {
        return $scope.isFedexGround(tracking_number) || $scope.isFedexExpress(tracking_number);
    };

    $scope.isFedexGround = function(tracking_number) {
        return false;
    };

    $scope.isFedexExpress = function(tracking_number) {

        if (tracking_number.length != 12 || !(/^\d+$/).test(tracking_number)) {
            return false;
        }

        var checkDigits = [1,3,7];
        var numCheckDigits = 3;

        var sum = 0;

        for (var i=10; i>=0; i--) {
            sum += (checkDigits[(10 - i) % numCheckDigits] * tracking_number[i]);
        }
        var remainder = ((sum % 11) % 10);

        return (remainder == tracking_number[11]);
    };

    $http.get('api/index.php/packages').success(function(data) {

        $scope.packagesLoaded = true;

        /*
        UPS
         UPS Tracking Numbers appear in the following formats:
         1Z 999 999 99 9999 999 9
         9999 9999 999
         T999 9999 999
         */
        console.log("IS FEDEX: " + $scope.isFedex("111111111111"));
        console.log("IS FEDEX: " + $scope.isFedex("123456789012"));
        console.log('https://www.fedex.com/fedextrack/?tracknumbers=111111111111');

        data.forEach(function(pPackage) {
            pPackage.isEditing = false;

            if(pPackage.order_date != null) {
                pPackage.order_date = moment(pPackage.order_date).format('YYYY-MM-DD');
            }

            if (pPackage.estimated_arrival_date != null) {
                pPackage.estimated_arrival_date = moment(pPackage.estimated_arrival_date).format('YYYY-MM-DD');
            }

            if (pPackage.price != null) {
                pPackage.price = parseFloat(pPackage.price);
            }

            $scope.packages.push(pPackage);
        });
    });



    $scope.requestRemovePackage = function(index) {
        $scope.selectedIndex = index;

        $('#myModal').foundation('reveal', 'open', 'http://some-url');

    };

    $scope.removePackage = function(index) {

        var pPackage = $scope.packages[index];

        $http({
            url: 'api/index.php/packages/' + pPackage['id'],
            method: 'DELETE'
        }).success(function () {
                $scope.packages.splice(index, 1);
            });

    };

    $scope.resetPackage = function() {
        $scope.package =
        {
            name:'',
            status: 'PROCESSING',
            tracking_number: '',
            estimated_arrival_date: '',
            order_date: '',
            link: '',
            price: '',
            isEditing: false
        };

    };

    $scope.markAsArrived = function(index) {
        var pPackage = $scope.packages[index];
        pPackage.status = 'ARRIVED';

        $scope.updatePackage(pPackage);
    };

    $scope.updatePackage = function(pPackage) {

        $http({
            url: 'api/index.php/packages/' + pPackage.id,
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            data: pPackage
        }).success(function () {

            });
    };


    $scope.editPackage = function(index) {
        var pPackage = $scope.packages[index];
        pPackage.isEditing = true;
    };

    $scope.savePackage = function(index) {
        var pPackage = $scope.packages[index];
        pPackage.isEditing = false;

        $scope.updatePackage(pPackage);
    };

    $scope.addPackage = function() {


        if ($scope.package.estimated_arrival_date == '') {
            $scope.package.estimated_arrival_date = null;
        }

        if ($scope.package.order_date == '') {
            $scope.package.order_date = null;
        }

        if ($scope.package.price == '') {
            $scope.package.price = null;
        }

        $http({
            url: 'api/index.php/packages',
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            data: $scope.package
        }).success(function () {
                $scope.packages.push($scope.package);
                $scope.resetPackage();
            });
    };

    $scope.closeDialog = function(confirm) {
        $('#myModal').foundation('reveal', 'close');

        if(confirm) {
            $scope.removePackage($scope.selectedIndex);
        }
    };

    $scope.numberOfDays = function(index) {
        var pPackage = $scope.packages[index];
        var startDate = moment(pPackage.order_date);
        var endDate = moment(pPackage.estimated_arrival_date);

        return moment.duration(endDate.diff(startDate)).asDays();
    };



}
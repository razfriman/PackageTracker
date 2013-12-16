
function PackageCtrl($scope) {

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
    $scope.packages =
        [
            {
                name:'Pink Scarf',
                status: 'SHIPPING',
                tracking_number: '00180925010211',
                estimated_arrival_date: '2013-01-11',
                order_date: '2013-01-05',
                link: 'http://www.google.com',
                price: 41.50,
                isEditing: true
            },
            {
                name:'Blue Hat',
                status: 'PROCESSING',
                tracking_number: '009124999934',
                estimated_arrival_date: '2013-01-08',
                order_date: '2013-01-02',
                link: 'http://www.google.com',
                price: 9.99,
                isEditing: false
            }
        ];

    $scope.removePackage = function(index) {
        $scope.packages.splice(index, 1);
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
        var package = $scope.packages[index];
        package.status = 'ARRIVED';
    };

    $scope.editPackage = function(index) {
        var package = $scope.packages[index];
        package.isEditing = true;
    };

    $scope.savePackage = function(index) {
        var package = $scope.packages[index];
        package.isEditing = false;
    };

    $scope.addPackage = function() {
        $scope.packages.push($scope.package);
        $scope.resetPackage();
    };

    $scope.numberOfDays = function(index) {
        var package = $scope.packages[index];
        var startDate = moment(package.order_date);
        var endDate = moment(package.estimated_arrival_date);

        return moment.duration(endDate.diff(startDate)).asDays();
    };



}
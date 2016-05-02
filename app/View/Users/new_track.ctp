<html xmlns:ng="http://angularjs.org" id='ng-app' ng-app="angular-google-maps-example">
<head>
    <meta charset="UTF-8">
    <title>angular-google-maps example page</title>
   
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet"
          type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,600,300,700'
          rel='stylesheet' type='text/css'>
    <link href="<?php echo $this->Html->Url('/');?>css/map.css" rel="stylesheet" type="text/css">
</head>

<body ng-controller="controller">
<!--	You can use either a div having class 'google-map' or the '<google-map>' element; in
	the latter case, uncomment the style above to make sure the custom elements gets block display	-->
<div class="page-title ">
    <h2 ng-cloak>angular-google-maps example {{version}}</h2>
</div>
<div class="container">
    <div class="row">
		<google-map center="map.center" draggable="true" zoom="map.zoom">
            <markers models="locations" coords="'self'" idkey="'title'" labelContent="'title'" doCluster="true"></markers>
            <polyline path="locations" draggable="false" geodesic="true" stroke="map.lineStyle" fit="true"></polyline>
        </google-map>
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCX1SGbjQbXFBLjBa-6BQtE6TWZ-Vi6oGI&sensor=false"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.min.js"></script>
<!--script src="http://maps.googleapis.com/maps/api/js?libraries=weather,visualization&sensor=false&language=en&v=3.13"></script-->
<script src="<?php echo $this->Html->Url('/');?>js/lodash.js" type="text/javascript"></script>
<script src="<?php echo $this->Html->Url('/');?>js/angular-google-maps.js"></script>
<script>


(function () {


angular.module("angular-google-maps-example", ["google-maps"]).value("rndAddToLatLon",function () {
  return Math.floor(((Math.random() < 0.5 ? -1 : 1) * 2) + 1);
}).controller("controller", ['$rootScope', '$scope', '$location', '$http', function ($rootScope, $scope, $location, $http) {
    $scope.map = {
        // http://angular-google-maps.org/use
        center: {
            latitude: 28.58702141,
            longitude: 77.33094661
        },
        zoom: 9,
		draggingCursor: 'url(http://icons.iconarchive.com/icons/yellowicon/game-stars/256/Mario-icon.png), auto;',
		mapMaker:'true',
        lineStyle: {
            color: '#333',
            weight: 5,
            opacity: 0.7
        }
    };
    $scope.locations =<?php echo $arrLocations;?>;
}]);

}());

</script>
<style>
.angular-google-map-container { height: 700px; }
</style>

</body>

</html>
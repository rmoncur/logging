// JavaScript Document

Highcharts.setOptions({
	global: {
		useUTC: false
	}
});

var myapp = angular.module('myapp', ["highcharts-ng"]);

function myController($scope,$http){
	$scope.yucky = "I'm in a place called Vertigo";
	
	//The chartSeries Variable
	$scope.chartSeries = [];	
	$scope.chartConfig1 = {
		options: {
			chart: {type: 'spline'},
			credits: {enabled: false},
			title: {
				text: 'Moncur Home Temperature Data',
				style:{"fontSize":"12px"}
			},			
//			tooltip: {pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'},
			xAxis: {
				type: 'datetime',
				dateTimeLabelFormats: { // don't display the dummy year
					second: '%Y-%m-%d<br/>%l:%M',
					minute: '%Y-%m-%d<br/>%l:%M',
					hour: '%Y-%m-%d<br/>%l:%M',
					day: '%Y<br/>%b-%d',
					week: '%Y<br/>%b-%d',
					month: '%Y-%m',
					year: '%Y'
            	}
			}
		},		
		height:150,
		series: $scope.chartSeries,
		loading: false,
		size: {}
	}

	$scope.chartSeries2 = [];	
	$scope.chartConfig2 = {
		options: {
			chart: {type: 'spline'},
			//credits: {enabled: false},
			title: {text: 'Latest Temperature',style:{"fontSize":"12px"} },			
			tooltip: {pointFormat: '{series.name}: <b>{point.y}°</b>'},
			xAxis: {
				type: 'datetime',
				dateTimeLabelFormats: { // don't display the dummy year
					second: '%Y-%m-%d<br/>%l:%M %p',
					minute: '%Y-%m-%d<br/>%l:%M %p',
					  hour: '%Y-%m-%d<br/>%l:%M %p',
					   day: '%Y-%m-%d<br/>%l:%M %p',
					  week: '%Y<br/>%b-%d',
					 month: '%Y-%m',
					  year: '%Y'
            	}
			}
		},		
		height:150,
		series: $scope.chartSeries2,
		loading: false,
		size: {}
	}

	//Getting the data from the server
	$scope.getData = function(){
		
		//Getting all data
		$http({method: 'GET', url: 'api/data/all/index.php'}).
		success(function(data, status, headers, config) {
			
			//Processing highcharts data
			for(var i in data.dht11){
				data.dht11[i][0] = Date.parse(data.dht11[i][0]);
			}
			for(var i in data.tmp36){
				data.tmp36[i][0] = Date.parse(data.tmp36[i][0]);
			}
			
			$scope.tempData = data;
			$scope.chartSeries[0] = {"data":$scope.tempData.dht11, type: 'spline',name: '°F (DHT11)'};
			$scope.chartSeries[1] = {"data":$scope.tempData.tmp36, type: 'spline',name: '°F (TMP36)'};
			//$scope.chartTemperatures();
		}).error(function(data, status, headers, config) {});
		
		//Get the temperature by date
		var d = new Date();
		var curr_date = d.getDate() + 1;
		var curr_month = d.getMonth() + 1; //Months are zero based
		var curr_year = d.getFullYear();
		var dStringEnd = curr_year + "-" + curr_month + "-" + curr_date;
		var dStringStart = curr_year + "-" + curr_month + "-" + (curr_date-2);
		var url = 'api/data/temperature/bounded/index.php?start='+dStringStart+'&end='+dStringEnd+'&sensor=DHT11';
		console.log("Date String",dStringStart,dStringEnd,url);
		
		$http({method: 'GET', url: url}).
		success(function(data, status, headers, config) {
			
			console.log("Bounded Data",data);
			
			//Processing highcharts data
			for(var i in data){
				data[i][0] = Date.parse(data[i][0]);
			}
			$scope.bounded = data;
			$scope.chartSeries2[0] = {"data":$scope.bounded, type: 'spline',name: '°F (Minute)'};
			//$scope.chartConfig2

		}).
		error(function(data, status, headers, config) {});
		
	}

	/*
	$scope.chartTemperatures = function(){
					
		//Creating the data object
		$scope.testdata = {
			labels : $scope.tempData.labels,
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					data : $scope.tempData.avg_f
				}
				//,
				//{
				//	fillColor : "rgba(151,187,205,0.5)",
				//	strokeColor : "rgba(151,187,205,1)",
				//	pointColor : "rgba(151,187,205,1)",
				//	pointStrokeColor : "#fff",
				//	data : $scope.tempData.avg_humidity
				//}
			]
		};            
		
		$scope.testoptions = {
			pointDot : false,
			animation: true,
			tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>"
		} 
		
		console.log("Chart Data",$scope.testdata, $scope.testoptions);
		
		//Generating the chart
		$scope.myTempChart = {
			"data": $scope.testdata, 
			"options": $scope.testoptions
		};
		
		//document.getElementById('myCoolChart').setAttribute('type', 'Doughnut');
		$scope.test();
	}

	$scope.test = function(){
		//$scope.chartTempData();
		
		//console.log("Testing",$scope.testdata, $scope.testoptions);
		var ctx = document.getElementById("myChart").getContext("2d");
		ctx.canvas.width = 900;
		ctx.canvas.height = 200;
		
		var myLineChart = new Chart(ctx).Line($scope.testdata, $scope.testoptions);
		//console.log("Done Testing");
		
	}
	*/



	

	//Getting the data
	$scope.getData();

}

/*
$scope.chartConfig = {
		options: {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: 0,
				plotShadow: false,
				height:400,
				width:400
			},
			plotOptions: {
				pie: {
					dataLabels: {
						enabled: true,
						distance: -50,
						style: {
							fontWeight: 'bold',
							color: 'white',
							textShadow: '0px 1px 2px black'
						}
					},
					startAngle: -90,
					endAngle: 90,
					center: ['50%', '75%']
				}
			},
			title: {
				text: 'Browser<br>shares',
				align: 'center',
				verticalAlign: 'middle',
				y: 0,
				style:{"fontSize":"10px"}
			},
			tooltip: {pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'}
		},
		title: {
			text: 'Directory Location',
			align: 'center',
			verticalAlign: 'middle',
			y: 50,
			style:{"fontSize":"10px"}
		},
		height:150,
		series: $scope.chartSeries,
		credits: {enabled: true},
		loading: false,
		size: {}
	}
	*/

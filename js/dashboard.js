 angular.module("sah", [])
    .controller('dashboardCtrl',function($scope, $http) {

        $scope.showData = false;
        
        var initChart = function(){
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);    
        };

        var drawChart = function() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Justificativa');
            data.addColumn('number', 'Hours');

            var details = $scope.model.period.details;
            for (var index = 0; index < details.length; index++) {
                data.addRow([details[index].description,parseInt(details[index].hours)]);
            }

            var options = {'title':'Horas Trabalhadas',
                        'width':350,
                        'height':200,
                        legend:{
                            alignment: 'center',
                            position: 'bottom'
                        }
                    };

            var chart = new google.visualization.PieChart($('#chart')[0]);
            chart.draw(data, options);
        };

        var getModel = $http.get('/sah/php/dashboard.php').then(function(data){
            $scope.model = data.data;
            $scope.showData = $scope.model.period != null;

            if($scope.model.period!=null){
                $scope.model.period.startFomated = function(){return moment($scope.model.period.start).format('DD/MM/YYYY')};
                $scope.model.period.endFomated = function(){return moment($scope.model.period.end).format('DD/MM/YYYY')};
                $scope.model.period.totalDetails = function(){
                    var details = $scope.model.period.details;
                    var total = 0;
                    for (var index = 0; index < details.length; index++) {
                        total += parseInt(details[index].hours);
                    }
                    return total;
                };
                initChart();
            }
        }, function(data){
            alert(data.data);
            if(data.status == 402){
                window.location.href = '/sah/html/index';
            }
        });
    });
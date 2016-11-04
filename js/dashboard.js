 angular.module("sah", [])
    .controller('dashboardCtrl',function($scope) {

        $scope.model = {
            user:{
                name: 'Teste',
                profile: 'Trabalhador'
            },
            period:{
                start: new Date(2016,11,1),
                end: new Date(2016,11,30),
                status: 'Encaminhada para o Coordenador de Curso',
                details:[
                    {description:'Versionamento', hours:3},
                    {description:'Produção', hours:2},
                    {description:'Capacitação', hours:7},
                ]
            }
        };

        $scope.model.period.startFomated = function(){return moment($scope.model.period.start).format('DD/MM/YYYY')};
        $scope.model.period.endFomated = function(){return moment($scope.model.period.end).format('DD/MM/YYYY')};
        $scope.model.period.totalDetails = function(){
            var details = $scope.model.period.details;
            var total = 0;
            for (var index = 0; index < details.length; index++) {
                total += details[index].hours;
            }
            return total;
        };

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
                data.addRow([details[index].description,details[index].hours]);
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

        initChart();
    });
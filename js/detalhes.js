 angular.module("sah", [])
    .controller('detailsCtrl',function($scope, $http) {

        var getAction = function(){
            return location.search.split('action=')[1];
        }

        $scope.model = {
            user:{
                name: 'Teste',
                profile: 'Trabalhador'
            },
            action: getAction(),
            inputPanel:{
                title: function (){
                    return $scope.model.action == "inserir"? "Inserir" : "Consultar";
                },
                startDateLabel:function (){
                    return $scope.model.action == "inserir"? "Data" : "Data Inicial";
                },
                showInputForInserirAction: function (){
                    return $scope.model.action == "inserir";
                },
                inputsSize: function(){
                    return $scope.model.action == "inserir"? "3": "4";
                },
                description: {id:"1", text:"Produção de Conteúdo"},
                descriptionList:[
                    {id:"1", text:"Produção de Conteúdo"},
                    {id:"2", text:"Versionamento"},
                    {id:"3", text:"Capacitação"},
                    {id:"4", text:"Empréstimo"},
                ]
            },
            results:[
                {id:1, date: moment(new Date(2016,10,1)).format('DD/MM/YYYY'), startHour: '08:00', endHour:'12:00', totalHours:4, description:'Versionamento'},
                {id:2, date: moment(new Date(2016,10,1)).format('DD/MM/YYYY'), startHour: '13:00', endHour:'17:00', totalHours:4, description:'Produção'}
            ]
        };

        $scope.model.editResult = function(index){
            alert('Editando registro da data: ' + $scope.model.results[index].date);
        }

        $scope.model.removeResult = function (index){
            if(confirm('Remover registro da data: ' + $scope.model.results[index].date + ' ?')){
                $http.delete('/sah/php/detalhes.php?id=' + 21 /*$scope.model.results[index].id*/)
                .then(function(data){
                    console.log(data.data);
                }, function (data){
                    alert(data.data);                    
                });
            };
        }

        $scope.model.inputPanel.add = function (){
            var inputModel = $scope.model.inputPanel;

            inputModel.startHourFormatted = moment(inputModel.startHour).format('HH:mm:ss');
            inputModel.endHourFormatted = moment(inputModel.endHour).format('HH:mm:ss');
            inputModel.dateFormatted = moment(inputModel.date).format('YYYY-MM-DD');

            $http.post('/sah/php/detalhes.php', inputModel)
                .then(function (data){
                    console.log(data.data);
                }, function (data){
                    alert(data.data);                    
                });

            
        };

        $scope.model.inputPanel.filter = function (){
            return false;
        };

        $scope.model.inputPanel.submit = function (){
            if(!$('form').validate().valid())
                return false;

            if( $scope.model.action == 'inserir'){
                return $scope.model.inputPanel.add();
            }else{
                return $scope.model.inputPanel.filter();
            }
        };
    });
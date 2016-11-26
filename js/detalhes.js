 angular.module("sah", [])
    .controller('detailsCtrl',function($scope, $http) {
        
        var getAction = function(){
            return location.search.split('action=')[1];
        }

        $http.get('/sah/php/entry_types.php').then(function(data){
            $scope.model.inputPanel.descriptionList = data.data;
            if(getAction() == 'inserir')
                $scope.model.inputPanel.description = $scope.model.inputPanel.descriptionList[0];
        }, function(data){
            alert(data.data);            
        });

        $scope.model = {
            filterModel: {},
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
            }
        };

        $scope.model.inputPanel.filter = function (useScope){
            var model = useScope ? {
                startDate: $scope.model.filterModel.startDate ? moment($scope.model.filterModel.startDate).format('YYYY-MM-DD') : null,
                endDate: $scope.model.filterModel.endDate ? moment($scope.model.filterModel.endDate).format('YYYY-MM-DD') : null,
                entryType: $scope.model.filterModel.description ? $scope.model.filterModel.description.id : null  
            } : null;

            $http.get('/sah/php/detalhes.php?' + $.param(model||{})).then(function(data){
                $scope.model.user = data.data.user;
                $scope.model.results = data.data.results;
                for (var index in $scope.model.results) {
                    var item = $scope.model.results[index];
                    item.formattedDate = moment(item.date).format('DD/MM/YYYY')
                }
            }, function(data){
                alert(data.data);            
            });
        };
        
        $scope.model.inputPanel.filter(false);

        $scope.model.removeResult = function (index){
            if(confirm('Remover registro da data: ' + $scope.model.results[index].date + ' ?')){
                $http.delete('/sah/php/detalhes.php?id=' + $scope.model.results[index].id)
                .then(function(data){
                    $scope.model.inputPanel.filter(true);
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
                    $scope.model.inputPanel.filter(false);
                }, function (data){
                    alert(data.data);                    
                });
        };

        $scope.model.inputPanel.submit = function (){
            var validator =$('form').validate(); 
            if(!validator.valid()
                || !validator.element($('#data'))
                || !validator.element($('#hora-entrada'))
                || !validator.element($('#hora-saida')))
                return false;

            if( $scope.model.action == 'inserir'){
                return $scope.model.inputPanel.add();
            }else{
                $scope.model.filterModel = angular.copy($scope.model.inputPanel); 
                return $scope.model.inputPanel.filter(true);
            }
        };
    });
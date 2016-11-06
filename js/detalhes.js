 angular.module("sah", [])
    .controller('detailsCtrl',function($scope) {

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
                {date: moment(new Date(2016,10,1)).format('DD/MM/YYYY'), startHour: '08:00', endHour:'12:00', totalHours:4, description:'Versionamento'},
                {date: moment(new Date(2016,10,1)).format('DD/MM/YYYY'), startHour: '13:00', endHour:'17:00', totalHours:4, description:'Produção'}
            ]
        };

        $scope.model.editResult = function(index){
            alert('Editando registro da data: ' + $scope.model.results[index].date);
        }

        $scope.model.removeResult = function (index){
            if(confirm('Remover registro da data: ' + $scope.model.results[index].date + ' ?')){
                $scope.model.results.splice(index,1);
            };
        }

        $scope.model.inputPanel.add = function (){
            var inputModel = $scope.model.inputPanel;
            $scope.model.results.push({
                date: moment(inputModel.date).format('DD/MM/YYYY'), startHour: moment(inputModel.startHour).format("HH:mm"), endHour:moment(inputModel.endHour).format("HH:mm"), totalHours:moment(inputModel.endHour).diff(moment(inputModel.startHour),'hours'), description:inputModel.description.text
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
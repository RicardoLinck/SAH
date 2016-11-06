 angular.module("sah", [])
    .controller('selecaoPerfilCtrl',function($scope) {
        $scope.profiles = [
            { id:1, name:'Trabalhador' },
            { id:2, name:'Coordenador de Curso' },
            { id:3, name:'Coordenador do Núcleo Pedagógico' },
        ];

        $scope.selectedProfile = $scope.profiles[0];

        $scope.submit = function(){
            location.href = "dashboard.html";
        } 
    });
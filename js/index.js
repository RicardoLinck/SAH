 angular.module("sah", [])
    .controller('indexCtrl',function($scope) {
        $scope.submit = function(){

            if(!validateLogin()){
                $scope.emailValidationResult = "";
                return false;
            }

            $scope.emailValidationResult = 'hidden';
            location.href = "selecao-perfil.html";
        }

        $scope.emailValidationResult = 'hidden';

        var validateLogin = function(){
            return $scope.model.email == 'teste@teste.com' && $scope.model.password == '123';
        }
    });
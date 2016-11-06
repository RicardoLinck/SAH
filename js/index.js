 angular.module("sah", [])
    .controller('indexCtrl',function($scope) {
        $scope.submit = function(){
            if(!$('form').validate().valid())
                return false;
                
            if(!validateLogin()){
                $scope.emailValidationResult = "";
                return false;
            }
            
            $scope.emailValidationResult = 'hidden';

            if ($scope.model.hasManyProfiles)
                location.href = "selecao-perfil.html";
            else
                location.href = "dashboard.html";
        }

        $scope.emailValidationResult = 'hidden';

        var validateLogin = function(){
            $scope.model.hasManyProfiles = true;
            return $scope.model.email == 'teste@teste.com' && $scope.model.password == '123';
        }
    });
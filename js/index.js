 angular.module("sah", [])
    .controller('indexCtrl',function($scope, $http) {
        $scope.submit = function(){
            if(!$('form').validate().valid())
                return false;

            var callback = function (success){
                if (success){
                    $scope.emailValidationResult = 'hidden';
                    if ($scope.model.hasManyProfiles)
                        location.href = "selecao-perfil.html";
                    else
                        location.href = "dashboard.html";
                    }
                else{
                    $scope.emailValidationResult = "";
                }
            };

            validateLogin(callback)
        }

        $scope.emailValidationResult = 'hidden';

        var validateLogin = function(callback){
            $http.post('/sah/php/index.php', $scope.model).then(function(data){
                $scope.model.hasManyProfiles = data.data.hasManyProfiles;
                callback(data.data.success);
            }, function (data){
                alert(data.data);
            })
        }
    });
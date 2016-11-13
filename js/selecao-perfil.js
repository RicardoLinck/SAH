 angular.module("sah", [])
    .controller('selecaoPerfilCtrl', function($scope, $http) {
        var getProfiles = $http.get('/sah/php/selecao-perfil.php').then(function(data){
            $scope.profiles = data.data;
            $scope.selectedProfile = $scope.profiles[0];
        }, function(data){
            alert(data.data);
            if(data.status == 402){
                window.location.href = '/sah/html/index';
            }
        });

        $scope.submit = function(){
            $http.post('/sah/php/selecao-perfil.php',$scope.selectedProfile).then(function(data){
                location.href = "dashboard.html";
            }, function(data){
                alert(data.data);
                if(data.status == 402){
                    window.location.href = '/sah/html/index';
                }
            })
            
        } 
    });
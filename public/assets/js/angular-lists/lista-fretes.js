var app = angular.module("app", []);

app.controller('HttpGetController', function ($scope, $http) {
    $scope.BuscarInformacao = function () {

        $http.get('/painel/fretes/lista-fretes')
            .success(function (data) {
                $scope.fretes = data["data"];
            }).error(
            function (data, status, header, config) {
                $scope.Resposta = $scope.fretes;
            });
        ;
    };
    $scope.reverseOrder = true;
    $scope.sortField = 'nome';

    $scope.sortBy = function(sortField) {
        $scope.reverseOrder = ($scope.sortField === sortField) ? !$scope.reverseOrder : false;
        $scope.sortField = sortField;
    };
    $scope.BuscarInformacao();
});
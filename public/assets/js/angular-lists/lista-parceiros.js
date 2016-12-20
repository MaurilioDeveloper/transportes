var app = angular.module("app", []);

app.controller('CtrlListaParceiros', function ($scope, $http, $filter) {
    $scope.BuscarInformacao = function () {

        $http.get('/painel/parceiros/listaParceiros')
            .success(function (data) {
                $scope.parceiros = data["data"];
            }).error(
            function (data, status, header, config) {
                $scope.Resposta = $scope.parceiros;
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

var app = angular.module("app", []);

app.controller('CtrlListaParceirosSearch', function ($scope, $http) {
    $scope.SearchInformacao = function (nome) {

        console.log(nome);
        $http.get('/painel/parceiros/busca-parceiros/'+nome)
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
    $scope.SearchInformacao(pesquisa);
});


angular.module('paketprivat', [])
    .controller('ActionController', ['$http', '$scope', function ($http, $scope) {
        $scope.actions = [];
        //$scope.carryType = true;
        $scope.btnPacket = false;
        //$scope.btnPacketEdit = true,
        $scope.btnLocation = true;
        //$scope.btnLocationEdit = true,
        $scope.btnSearch = true;
        //$scope.location = true;
        //$scope.packet = true;
        //$scope.packetName = false;
        $scope.hideEdit = false;
if($("#type").val() == 1){
    $scope.carryType = false;
    $scope.packetName = true;
}
        else{
    $scope.carryType = true;
    $scope.packetName = false;
}

        this.showPacketName = function(){

            $scope.carryType = true;
            $scope.packetName = false;
        };
        this.showCarryType = function(){
            $scope.carryType = false;
            $scope.packetName = true;
        };
        this.enabledSecondDiv = function(){
            $("#div_packet").addClass("disabledbutton");
            $("#div_location").removeClass("disabledbutton");
            $("#columna3").addClass("disabledbutton");
            $scope.btnPacket = true;
            //$scope.btnPacketEdit = false;

            $scope.btnLocation = false;
            //$scope.btnLocationEdit = true;

            $scope.btnSearch = true;
        };
        this.enabledFirstDiv = function(){
            $("#div_packet").removeClass("disabledbutton");
            $("#div_location").addClass("disabledbutton");
            $("#columna3").addClass("disabledbutton");

            $scope.btnPacket = false;
            //$scope.btnPacketEdit = true;

            $scope.btnLocation = true;
            //$scope.btnLocationEdit = true;

            $scope.btnSearch = true;
        };
        this.enabledThirdDiv = function(){
            $("#div_packet").addClass("disabledbutton");
            $("#div_location").addClass("disabledbutton");
            $("#columna3").removeClass("disabledbutton");

            $scope.btnPacket = true;
            //$scope.btnPacketEdit = false;

            $scope.btnLocation = true;
            //$scope.btnLocationEdit = false;

            $scope.btnSearch = false;
        };
        this.resetComponents = function(){
            $("#div_packet").removeClass("disabledbutton");
            $("#div_location").removeClass("disabledbutton");
            $("#columna3").removeClass("disabledbutton");
        };
        this.packet_new_trip = function () {
            console.info($('#appbundle_action_direction_countryFrom').val());
            $http({
                method: 'POST',
                url: 'app_back_search',
                //url: Routing.generate('packet_new_trip', true),
                params: {
                    countryFrom:  $('#appbundle_action_direction_countryFrom').val(),
                    cityFrom:  $('#appbundle_action_direction_cityFrom').val(),
                    stateFrom:  $('#appbundle_action_direction_stateFrom').val(),
                    countryTo:  $('#appbundle_action_direction_countryTo').val(),
                    cityTo:  $('#appbundle_action_direction_cityTo').val(),
                    stateTo:  $('#appbundle_action_direction_stateTo').val(),
                    weight: $('#appbundle_action_weight').val(),
                    volumen: $('#appbundle_action_volumen').val(),
                    type: $('#type').val()
                }
            }).then(function (response) {
                $scope.actions = response.data;
            }, function (errResponse) {
                console.error('Error while fetching notes');
            });
        };
    }])
    .controller('ActionEditController', ['$http', '$scope', function ($http, $scope) {
        $scope.actions = [];
        $scope.hideEdit = true;
        if($("#type").val() == 1){
            $scope.carryType = false;
            $scope.packetName = true;
        }
        else{
            $scope.carryType = true;
            $scope.packetName = false;
        }

        this.resetComponents = function(){
            $("#div_packet").removeClass("disabledbutton");
            $("#div_location").removeClass("disabledbutton");
            $("#columna3").removeClass("disabledbutton");
        };
    }])
    .controller('LoginController', ['$http', '$scope', function ($http, $scope) {
        $scope.formLogin = false;
        this.forgetPass = function () {
            if($scope.formLogin){
                $scope.formLogin = false;
            } else {
                $scope.formLogin = true;
            }
        };
    }])
    .controller('AppBackendController', ['$http', '$scope', function ($http, $scope) {
        this.profileItemTab = 1;
        this.ItemTab = 1;
        this.TripTab = 1;
        this.NotTab = 1;
        this.mainMenuTab = 1;

        $scope.actions = [];

        this.delete_items = function(id){
            console.info($scope.actions);
        $http({
            method: 'POST',
            url: 'action/'+id+'/delete',
            params: {
                type: $('#type').val()
            }
        }).then(function (response) {
            for(var i=0; i<$scope.actions.length; i++){
                if($scope.actions[i].id == id){
                    $scope.actions.splice(i, 1);  //removes 1 element at position i
                    break;
                }
            }
            console.info($scope.actions);
        }, function (errResponse) {
            console.error('Error while fetching notes');
        });
        };

        this.my_items = function () {
            this.mainMenuTab = 2;
            $scope.packet = false;
            $scope.trip = true;
            $("#type").val('2');
            console.info($("#type").val());
            $http({
                method: 'POST',
                url: 'action/backend/app_back_my_items',
                params: {
                    type: $('#type').val()
                }
            }).then(function (response) {
                for(var i=0;i<response.data.length;i++){
                    response.data[i]['edit_url'] = $("#temp_id").val() + response.data[i]['edit_url'];
                    response.data[i]['search_url'] = $("#temp_id").val() + response.data[i]['search_url'];
                }

                $scope.actions = response.data;
                console.info(response.data);
            }, function (errResponse) {
                console.error('Error while fetching notes');
            });
        };

        this.my_trips = function () {
            this.mainMenuTab = 3;
            $scope.packet = true;
            $scope.trip = false;
            $("#type").val('1');
            console.info($("#type").val());
            $http({
                method: 'POST',
                url: 'action/backend/app_back_my_items',
                params: {
                    type: $('#type').val()
                }
            }).then(function (response) {
                for(var i=0;i<response.data.length;i++){
                    response.data[i]['edit_url'] = $("#temp_id").val() + response.data[i]['edit_url'];
                    response.data[i]['search_url'] = $("#temp_id").val() + response.data[i]['search_url'];
                }

                $scope.actions = response.data;
                console.info(response.data);
            }, function (errResponse) {
                console.error('Error while fetching notes');
            });
        };

        this.my_notify = function () {
            this.mainMenuTab = 4;
            //$scope.packet = true;
            //$scope.trip = false;
            //$("#type").val('1');
            console.info($("#type").val());
            $http({
                method: 'POST',
                url: 'action/backend/app_back_my_notify',
                params: {
                    //type: $('#type').val()
                }
            }).then(function (response) {
                for(var i=0;i<response.data.length;i++){
                    response.data[i]['edit_url'] = $("#temp_id").val() + response.data[i]['edit_url'];
                    response.data[i]['search_url'] = $("#temp_id").val() + response.data[i]['search_url'];
                }

                $scope.actions = response.data;
                console.info(response.data);
            }, function (errResponse) {
                console.error('Error while fetching notes');
            });
        };

    }])
    .controller('SearchController', ['$http', '$scope', function ($http, $scope) {
        $scope.actions = [];
        this.packet_notify = function (idPacket, idAction, type) {
            console.info(idPacket);
            console.info(idAction);
            //return;
            $http({
                method: 'POST',
                url: 'notify_action',
                //url: Routing.generate('packet_new_trip', true),
                params: {
                    idPacket:  idPacket,
                    idTrip:  idAction,
                    type:  type
                }
            }).then(function (response) {
                return true;
            }, function (errResponse) {
                console.error('Error while fetching notes');
            });
        };
    }])

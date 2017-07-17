window.onload = function() {
    //var serviceFormView = new ServiceFormView();
    serviceFormView.render();

    socket.on('disconnect', function(data) {
        //alert('Se ha perdido la conexión de internet, vuelva a carga la página');
        location.reload();
    });
    socket.on('connect_failed', function(data) {
        alert('Error al conectar con servidor!');
        location.reload();
    });
    socket.on('userData', function(data) {
        //console.log(data);
        if (data.userData.id) {
            var currentUser = new User(data.userData);
            var userDataView = new UserDataView({model: currentUser});
            userDataView.render();
        } else {
            alert('No se encontraron resultados!');
            //var userBlankView = new UserBlankView();
            userBlankView.render();
            $('#usr_name').val('');
            $('#usr_lastname').val('');
            $('#usr_prefered_dirs').empty();
        }
    });
    socket.on('userDirs', function(data) {
        //console.log(data);
        if (data.userDirs.error == 0) {
            //console.log(data.userDirs.address.length);
            if (data.userDirs.address.length > 0) {
                currentAddressGroup.set(data.userDirs.address);
                //userDirsView = new UserDirsView({collection: currentAddressGroup});
                userDirsView.render();
            } else {
                $('#usr_prefered_dirs').empty();
            }
        }else{
            $('#usr_prefered_dirs').empty();
            serviceDirBlankView.render();
        }
    });
    
    socket.on('serviceCreated', function(data) {
        if (data.serviceData) {
            //console.log(data.serviceData);
            //loading();
            currentService = new Service(data.serviceData);
            serviceStateView = new ServiceStateView({model: currentService});
            serviceStateView.render();
            //console.log(currentService);
            serviceChecker(currentService);
        } else {
            console.log("Error: ", data);
        }
    });

    socket.on('serviceState', function(data) {
        if (data.serviceData) {
            if (currentService.get('status_id') !== data.serviceData.status_id) {
                //model state change;
                /*
                 currentService.set('status_id', data.serviceData.status_id);
                 currentService.set('state', data.serviceData.state);
                 currentService.set('driver', data.serviceData.driver);
                 */
                currentService.set(data.serviceData);
            }
            //itemId = ".page tbody #item" + data.serviceData.schedule_id;
            //console.log(data.serviceData);
            if (currentService.get('status_id') == 5 || currentService.get('status_id') == 6 || currentService.get('status_id') == 7 || currentService.get('status_id') == 8 || currentService.get('status_id') == 9) {
                clearInterval(servicesIntervals[0]);
                //currentService.set(data.serviceData);

                //serviceStateView.model.set();
                //$('#item' + parseInt(this.model.get('schedule_id'))).css('background-color', 'rgb(31, 255, 0)');//'#B42127');
                //var serviceStateView = new ServiceStateView({model: currentService});
                //serviceStateView.render();
                //$(itemId).css('background-color', 'rgb(31, 255, 0)');//'#B42127');
            } else {
                /*
                 var serviceStateView = new ServiceStateView({model: currentService});
                 serviceStateView.render();
                 */
            }
            /*currentService = new Service(data.serviceData);
             console.log(currentService);*/
        } else {
            console.log("Error: ", data);
        }
    });

};

function serviceState(serviceId) {
    socket.emit('serviceState', {serviceId: serviceId});
    //return true;
}

function serviceChecker(model) {
    //console.log(model);
    servicesIntervals[0] = self.setInterval(function() {
        serviceState(model.id)
    }, 1000);
}
window.onload = function() {

    var messages = [];
    var socket = io.connect(window.location.href);
    /*
     var field = document.getElementById("field");
     var sendButton = document.getElementById("send");
     var content = document.getElementById("content");
     var name = document.getElementById("name");
     var pos_x = document.getElementById("pos_x");
     var pos_y = document.getElementById("pos_y");
     var pos_z = document.getElementById("pos_z");
     */
    var currentSchedules;
    var currentService;
    unLoading();
    /*var serviceStateViewTest = new ServiceStateViewTest();
     serviceStateViewTest.render();
     */
    socket.on('disconnect', function(data) {
        alert('Se ha perdido la conexión de internet, vuelva a carga la página');
    });

    socket.on('schedules', function(data) {
        if (data.schedules) {
            //messages.push(data);
            //content.innerHTML = data;
            /*console.log(data);
             /*var pendSchedules = new Schedules(data.schedules);
             /*pendSchedules = Backbone.Collection.extend({
             // The Twitter Search API returns tweets under "results".
             parse: function(data) {
             return data;//response.results;
             }
             });*/
            //console.log(pendSchedules);
            currentSchedules = new Schedules(data.schedules);
            /*currentSchedules.on("change:status", function(model) {
             console.log("Schedule statue Changed " + model.get('status'));
             });*/
            //console.log(currentSchedules);
            var scheduleListView = new ScheduleListView({collection: currentSchedules});
            scheduleListView.render();
            //DataTable
            $('#dataTable').dataTable({
                "sDom": "<'row-fluid tb-head'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid tb-foot'<'span4'i><'span8'p>>",
                "bJQueryUI": false,
                "iDisplayLength": 10,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_",
                    "sSearch": "Search"
                }
            });
        } else {
            console.log("There is a problem:", data);
        }
    });

    /*socket.on('position', function(data) {
     //console.log(data);
     if (data) {
     pos_x.innerHTML = data.pos_x;
     pos_y.innerHTML = data.pos_y;
     pos_z.innerHTML = data.pos_z;
     } else {
     console.log("There is a problem:", data);
     }
     });*/
    socket.on('scheduleState', function(data) {
        //alert('?');
        //console.log(data);
        if (data.schedule) {
            //find in collection and update;
            var tmpSchedule = data.schedule;
            if (currentSchedules.get(tmpSchedule.id).get('status') != tmpSchedule.status) {
                //model state change;
                currentSchedules.get(tmpSchedule.id).set('status', tmpSchedule.status);
            } else {
                //console.log("Nothing changed");
                timeDiff = timeChecker(data.schedule);
                //console.log(timeDiff);
                //console.log(Date.parse(timeDiff));
                timeDiffMilis = Date.parse(timeDiff);//timeDiff.toISOString();//Date.UTC(timeDiff);
                if (timeDiffMilis > 0) {
                    // if (timeDiffMilis < 1800000) {  // 30 dias
                    //     // cuando pasan 30 minutos muestra un boton
                    //     // solicitar_service.visible = false;
                    //     show(document.getElementById('solicitar_service'));
                    // }
                    // else {
                    //     hide(document.getElementById('solicitar_service'));
                    // }

                    if (timeDiffMilis == 900000) {
                        document.getElementById('expireAlert').play();
                        alert('Agendamiento: ' + data.schedule.id + ' a quince minutos de cumplirse');
                    }
                    if (timeDiffMilis < 900000) {
                        //console.log(timeDiff.getUTCMinutes());
                        var pend = (-1) * (1 / 900000);
                        //console.log(pend);
                        var urgency = pend * timeDiffMilis + 1;
                        //$('#item' + data.schedule.id).css('background-color', 'RGBA(255,0,0,' + urgency + ')');//'#B42127');
                        $('#scheduleStatus' + data.schedule.id).css('background-color', 'RGBA(255,0,0,' + urgency + ')');//'#B42127');
                        //console.log(itemId + ":Red");
                        //console.log(urgency);
                        //$('#item' + data.schedule.id).css('opacity', urgency);
                        /*if (timeDiff.getUTCMinutes() <= 5) {
                         console.log('0.0!');
                         }*/
                    }
                } else {
                    if (timeDiffMilis == 0) {
                        alert('agendamiento vencido!');
                        //$('#item' + data.schedule.id).css('background-color', '#B42127');
                        //$('#item' + data.schedule.id).css('opacity', '1');
                        $('#scheduleStatus' + data.schedule.id).css('background-color', '#B42127');
                        //$('#scheduleStatus' + data.schedule.id).css('background-color', '#ffbf00');
                        $('#scheduleStatus' + data.schedule.id).css('opacity', '1');

                    }
                    clearInterval(schedulesIntervals[data.schedule.id]);
                    //socket.emit('expiredSchedule', {scheduleId: scheduleId});
                }

            }

        } else {
            console.log("There is a problem:", data);
        }
    });

    socket.on('serviceCreated', function(data) {
        if (data.serviceData) {
            //console.log(data.serviceData);
            //loading();
            currentService = new Service(data.serviceData);
            var serviceStateView = new ServiceStateView({model: currentService});
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
                currentService.set('status_id', data.serviceData.status_id);
                currentService.set('state', data.serviceData.state);
            }
            itemId = ".page tbody #item" + data.serviceData.schedule_id;
            itemIdStatus = '.page tbody #scheduleStatus' + data.serviceData.schedule_id;
            //console.log(data.serviceData);
            if (currentService.get('status_id') == 5 || currentService.get('status_id') == 6 || currentService.get('status_id') == 7 || currentService.get('status_id') == 8) {
                clearInterval(servicesIntervals[0]);
                //$('#item' + parseInt(this.model.get('schedule_id'))).css('background-color', 'rgb(31, 255, 0)');//'#B42127');
                var serviceStateView = new ServiceStateView({el: $(itemId), model: currentService});
                serviceStateView.render();
                $(itemIdStatus).css('background-color', 'rgb(31, 255, 0)');//'#B42127');
                //console.log(itemId + ":Green");
            } else {
                var serviceStateView = new ServiceStateView({el: $(itemId), model: currentService});
                serviceStateView.render();
            }
            /*currentService = new Service(data.serviceData);
             console.log(currentService);*/
        } else {
            console.log("Error: ", data);
        }
    });
};
var schedulesIntervals = [];//new Array();
var servicesIntervals = [];
function scheduleState(scheduleId) {
    socket.emit('scheduleState', {scheduleId: scheduleId});
    //return true;
}
function serviceState(serviceId) {
    socket.emit('serviceState', {serviceId: serviceId});
    //return true;
}
function scheduleChecker(model) {
    //console.log(model);
    var scheduleDateTimeArray = model.service_date_time.split(/[:\s,-]+/);
    scheduleDateTime = new Date(scheduleDateTimeArray[0], (scheduleDateTimeArray[1]) - 1, scheduleDateTimeArray[2], scheduleDateTimeArray[3], scheduleDateTimeArray[4], scheduleDateTimeArray[5]);
    nowDateTime = new Date();
    if (nowDateTime.getFullYear() == scheduleDateTime.getFullYear() && nowDateTime.getMonth() == scheduleDateTime.getMonth() && nowDateTime.getDate() == scheduleDateTime.getDate()) {
        //console.log(new Date(scheduleDateTime - nowDateTime).getUTCMinutes());
        schedulesIntervals[model.id] = self.setInterval(function() {
            scheduleState(model.id)
        }, 1000);
        ////setInterval(scheduleState(model.id), 3000);
        //var stateChecker= setInterval(scheduleState(model.id)), 30000);
        //clearInterval(nre);schedulesChecker[schedule.id]
    }
    if (scheduleDateTime < nowDateTime) {
        $('#item' + model.id).css('background-color', '#B42127');
    }
    /*else{
     console.log("Year "+nowDateTime.getFullYear()+" "+scheduleDateTime.getFullYear() +" Month "+ nowDateTime.getMonth()+" "+scheduleDateTime.getMonth()+" Day "+nowDateTime.getDate()+" "+scheduleDateTime.getDate());
     }*/
}

function serviceChecker(model) {
    //console.log(model);
    servicesIntervals[0] = self.setInterval(function() {
        serviceState(model.id)
    }, 1000);
}

function timeChecker(model) {
    var scheduleDateTimeArray = model.service_date_time.split(/[:\s,-]+/);
    scheduleDateTime = new Date(scheduleDateTimeArray[0], (scheduleDateTimeArray[1]) - 1, scheduleDateTimeArray[2], scheduleDateTimeArray[3], scheduleDateTimeArray[4], scheduleDateTimeArray[5]);
    nowDateTime = new Date();
    //console.log(scheduleDateTime - nowDateTime);
    diff = new Date(scheduleDateTime - nowDateTime);//.getUTCMinutes();
    return diff;
}
function loading() {
    $('#loading').show();
}
function unLoading() {
    $('#loading').hide();
}

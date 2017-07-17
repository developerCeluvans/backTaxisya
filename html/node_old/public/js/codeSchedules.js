var currentSchedules;
var currentService;
var schedulesIntervals = [];//new Array();
var servicesIntervals = [];

var scheduleItemView = [];

//< !-- Vistas-- >
var ScheduleListView = Backbone.View.extend({
    initialize: function() {
        //this.unbind(); // Unbind all local event bindings
        this.collection.on('add', this.render, this);
        this.collection.on('remove', this.render, this);
    },
    el: '.page',
    render: function() {
        var that = this;
        //var pendSchedules = new Schedules();
        //console.log(this.collection);
        var template = _.template($('#schedule-list-template').html(), {schedules: this.collection.toJSON()});
        that.$el.html(template);
        _.each(this.collection.toJSON(), function(schedule) {
            tmpSchedule = new Schedule(schedule);
            itemId = ".page tbody #item" + schedule.id;
            scheduleItemView[schedule.id] = new ScheduleItemView({el: $(itemId), model: tmpSchedule});
            scheduleItemView[schedule.id].render();
        });
        //console.log(scheduleItemView);
    }
});
var ScheduleItemView = Backbone.View.extend({
    initialize: function() {
        //this.unbind(); // Unbind all local event bindings
        this.model.on('change', this.render, this);
    },
    render: function() {
        var that = this;
        //var pendSchedules = new Schedules();
        //console.log(this.model);
        //console.log(this.el);

        var template = _.template($('#schedule-item-template').html(), {schedule: this.model.toJSON()});
        that.$el.html(template);

        //console.log(this.model.get('status'));
        if (parseInt(this.model.get('status')) === 1) {
            scheduleChecker(this.model.toJSON());
            console.log(this.model.toJSON());
        }

    },
    events: {
        'click #toService': 'toService',
        'click #cancelService': 'cancelService',
        'click #cancelSchedule': 'cancelSchedule'
    },
    toService: function(ev) {
        console.log(this.model.get('id'));
        var schedule_id = this.model.get('id');
        if (confirm("Desea convertir en servicio?")) {
            socket.emit('toService', {schedule_id: schedule_id});
        }
//alert(this.model.id);
    },
    cancelService: function() {
        //alert('Hey');
        var tmpServices = this.model.get('service');
        var service = tmpServices[tmpServices.length - 1];
        //console.log(service);
        socket.emit('cancelService', {service: service});
    },
    cancelSchedule: function() {
        console.log(this.model.get('id'));
        var schedule_id = this.model.get('id');
        if (confirm("¿Desea cancelar este agendamiento?")) {
            //console.log('Agendamiento %s',schedule_id);
            socket.emit('scheduleCancel', {schedule_id: schedule_id});
        }
    }
});

//<!-- Router -->
var Router = Backbone.Router.extend({
    routes: {
        "": "home"
    }
});
var router = new Router;
router.on('route:home', function() {
// render user list
    //socket.emit('schedules');
})
Backbone.history.start();

window.onload = function() {
//alert('Loaded');
    console.log(document.getElementById('customer_id').value);
    socket.emit('schedules', document.getElementById('customer_id').value);

    socket.on('disconnect', function(data) {
        alert('Se ha perdido la conexión de internet, vuelva a carga la página');
    });
    socket.on('schedules', function(data) {
        if (data.schedules) {

            currentSchedules = new Schedules(data.schedules);
            //console.log(currentSchedules);
            window.scheduleListView = new ScheduleListView({collection: currentSchedules});
            window.scheduleListView.render();
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

    socket.on('newSchedule', function(data) {
        if (data.schedule) {
            console.log(data);
            currentSchedules.add(data.schedule);
            //scheduleChecker(data.schedule);
            window.scheduleListView.collection.add(data.schedule);
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

    socket.on('canceledSchedule', function(data) {
        //console.log(data);
        if (data.id) {
            console.log(data);
            var schedule = currentSchedules.get(data.id)
            currentSchedules.remove(schedule);
            //currentSchedules.add(data.schedule);
            //scheduleChecker(data.schedule);
            window.scheduleListView.collection.remove(schedule);

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

    socket.on('scheduleState', function(data) {
        //alert('?');
        //console.log(data);
        if (data.schedule) {
            //find in collection and update;
            var tmpSchedule = data.schedule;

            scheduleStatusColor(tmpSchedule);
        } else {
            console.log("There is a problem:", data);
        }
    });

};

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
        //$('.page #item' + model.id).removeClass('odd');
        $('.page #item' + model.id).find('td').css('background', 'transparent');
        $('.page #item' + model.id).css('background-color', '#B42127');
    }
    /*else{
     console.log("Year "+nowDateTime.getFullYear()+" "+scheduleDateTime.getFullYear() +" Month "+ nowDateTime.getMonth()+" "+scheduleDateTime.getMonth()+" Day "+nowDateTime.getDate()+" "+scheduleDateTime.getDate());
     }*/
}
function serviceChecker(model) {
    //console.log(model);
    servicesIntervals[model.id] = self.setInterval(function() {
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
function scheduleStatusColor(tmpSchedule) {
    if (currentSchedules.get(tmpSchedule.id).get('status') !== tmpSchedule.status || tmpSchedule.status === "5") {
        //model state change;
        currentSchedules.get(tmpSchedule.id).set(tmpSchedule);
        scheduleItemView[tmpSchedule.id].model.set(tmpSchedule);
        if (tmpSchedule.status === "5") {
            var tmpServices = tmpSchedule.service;
            var service = tmpServices[tmpServices.length - 1];
            if (service.status_id === "5") {
                clearInterval(schedulesIntervals[tmpSchedule.id]);
                $('#item' + tmpSchedule.id).find('td').css('background', 'transparent');
                $('#item' + tmpSchedule.id).css('background-color', 'rgb(31, 255, 0)');
            }
        }
    } else {
        console.log("Nothing changed");
        timeDiff = timeChecker(tmpSchedule);
        console.log(timeDiff);
        console.log(Date.parse(timeDiff));
        timeDiffMilis = Date.parse(timeDiff);//timeDiff.toISOString();//Date.UTC(timeDiff);
        if (timeDiffMilis > 0) {
            if (timeDiffMilis > 180000) {
                // si pasan 30 minutos se desactiva el boton de solicitar
                var solicitaDiv = document.getElementById('solicitar_service');
//                solicitaDiv.setAttribute('class', 'hidden');
                // aca ver de ocultar el boton si no faltan 30 minutos
                solicitaDiv.setAttribute('class', 'show');
            }
            else {
                var solicitaDiv = document.getElementById('solicitar_service');
                solicitaDiv.setAttribute('class', 'show');
            }


            if (timeDiffMilis == 900000) {
                document.getElementById('expireAlert').play();
                alert('Agendamiento: ' + tmpSchedule.id + ' a quince minutos de cumplirse');
            }
            if (timeDiffMilis == 600000) {
                document.getElementById('expireAlert').play();
                alert('Agendamiento: ' + tmpSchedule.id + ' a diez minutos de cumplirse');
            }
            if (timeDiffMilis == 300000) {
                document.getElementById('expireAlert').play();
                alert('Agendamiento: ' + tmpSchedule.id + ' a cinco minutos de cumplirse');
            }
            if (timeDiffMilis < 900000) {
                //console.log(timeDiff.getUTCMinutes());
                var pend = (-1) * (1 / 900000);
                //console.log(pend);
                var urgency = pend * timeDiffMilis + 1;
                //$('#item' + tmpSchedule.id).css('background-color', 'RGBA(255,0,0,' + urgency + ')');//'#B42127');

                $('#item' + tmpSchedule.id).find('td').css('background', 'transparent');
                $('#item' + tmpSchedule.id).css('background-color', 'RGBA(255,0,0,' + urgency + ')');
                //$('#scheduleStatus' + tmpSchedule.id).removeClass("odd");
                //$('#scheduleStatus' + tmpSchedule.id).css('background-color', 'RGBA(255,0,0,' + urgency + ')');//'#B42127');

                //console.log(itemId + ":Red");
                //console.log(urgency);
                //$('#item' + tmpSchedule.id).css('opacity', urgency);
                /*if (timeDiff.getUTCMinutes() <= 5) {
                 console.log('0.0!');
                 }*/
                 // mirar esto
//                var solicitaDiv = document.getElementById('solicitar_service');
//                solicitaDiv.setAttribute('class', 'hidden');

            }
        } else {
            if (timeDiffMilis == 0) {
                $('#item' + tmpSchedule.id).find('td').css('background', 'transparent');
                $('#item' + tmpSchedule.id).css('background-color', '#B42127');
                $('#item' + tmpSchedule.id).css('opacity', '1');
                //$('#scheduleStatus' + tmpSchedule.id).css('background-color', '#B42127');
                //$('#scheduleStatus' + tmpSchedule.id).css('opacity', '1');
                alert('agendamiento vencido!');
            }
            clearInterval(schedulesIntervals[tmpSchedule.id]);
            //socket.emit('expiredSchedule', {scheduleId: scheduleId});
        }

    }
}

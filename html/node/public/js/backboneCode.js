//<!-- Vistas-->
var UserBlankView = Backbone.View.extend({
    el: '#usr-data',
    render: function() {
        var that = this;
        //var pendSchedules = new Schedules();
        //console.log(this.model.toJSON());
        var template = _.template($('#user-blank-template').html(), {}); //{user: this.model.toJSON()}
        that.$el.html(template);
        //console.log(template);                    
    },
    events: {
        'click #add_user': 'addUser',
        'keypress #usr_lastname': 'addUserKeyboard'
    },
    addUserKeyboard: function(e) {
        /*if (confirm("Desea convertir en servicio?")) {
         socket.emit('toService', {schedule_id: schedule_id});
         }*/
        //alert(this.model.id);
        //alert('Add:' + $('#usr_telephone').val());
        if (e.keyCode == 13) {
            $("#add_user").click();
        }
    },
    addUser: function(ev) {
        /*if (confirm("Desea convertir en servicio?")) {
         socket.emit('toService', {schedule_id: schedule_id});
         }*/
        //alert(this.model.id);
        //alert('Add:' + $('#usr_telephone').val());
        if (confirm('¿Desea registrar esta persona?')) {
            socket.emit('registerUser', {telephone: $('#usr_telephone').val(), name: $('input[name="usr_name"]').val(), lastname: ""});
        }
    }
});
var userBlankView = new UserBlankView();

var ServiceDirBlankView = Backbone.View.extend({
    el: '#dir_data',
    render: function() {
        //console.log('hey');
        this.setElement($('#dir_data'));
        var that = this;
        var template = _.template($('#service-dir-blank-template').html(), {});
        that.$el.html(template);
        $('select[name="dir_index_id"]').select2();
    },
    unbindEvents: function() {
        this.$el.off();
    },
    events: {
        'click #request1': 'requestService1'
    },
    requestService1: function() {
        //console.log($('#dir_data fieldset').serializeArray());
        $('#request1').attr("disabled", "disabled");
        socket.emit('requestService', $('form').serializeObject());
    }
});
var serviceDirBlankView = new ServiceDirBlankView();

var ServiceFormView = Backbone.View.extend({
    el: '.page',
    render: function() {
        var that = this;
        //var pendSchedules = new Schedules();
        //console.log(this.collection);
        var template = _.template($('#service-form-template').html());
        that.$el.html(template);
    },
    events: {
        'click #search_user': 'lookForUser',
        'keypress #usr_telephone': 'showKey',
        'click #add_user': 'addUser',
        'keypress #usr_lastname': 'addUserKeyboard'
    },
    lookForUser: function(ev) {
        /*if (confirm("Desea convertir en servicio?")) {
         socket.emit('toService', {schedule_id: schedule_id});
         }*/
        //alert(this.model.id);
        //alert('Look for:' + $('#usr_telephone').val());
        //var serviceDirBlankView = new ServiceDirBlankView();
        serviceDirBlankView.render();
        socket.emit('lookForUser', {user_telephone: $('#usr_telephone').val()});
    },
    showKey: function(e) {
        //console.log(e.keyCode);
        if (e.keyCode == 13) {
            $("#search_user").click();
        }
    },
    addUserKeyboard: function(e) {
        /*if (confirm("Desea convertir en servicio?")) {
         socket.emit('toService', {schedule_id: schedule_id});
         }*/
        //alert(this.model.id);
        //alert('Add:' + $('#usr_telephone').val());
        if (e.keyCode == 13) {
            $("#add_user").click();
        }
    },
    addUser: function(ev) {
        /*if (confirm("Desea convertir en servicio?")) {
         socket.emit('toService', {schedule_id: schedule_id});
         }*/
        //alert(this.model.id);
        //alert('Add:' + $('#usr_telephone').val());
        if (confirm('¿Desea registrar esta persona?')) {
            socket.emit('registerUser', {telephone: $('#usr_telephone').val(), name: $('input[name="usr_name"]').val(), lastname: ""});
        }
    }
});
var serviceFormView = new ServiceFormView();
var UserDataView = Backbone.View.extend({
    el: '#usr-data',
    render: function() {
        var that = this;
        //var pendSchedules = new Schedules();
        //console.log(this.model.toJSON());
        var template = _.template($('#user-data-template').html(), {user: this.model.toJSON()}); //{user: this.model.toJSON()}
        that.$el.html(template);
        //console.log(template);
        //console.log("Id de usuario:%s",this.model.get('id'));
        socket.emit('userDirs', {user_id: this.model.get('id')});
    }

});
var ServiceDirView = Backbone.View.extend({
    el: '#dir_data',
    render: function() {
        this.setElement($('#dir_data'));
        //console.log(this.model);
        var that = this;
        var template = _.template($('#service-dir-template').html(), {dir: this.model.toJSON()});
        that.$el.html(template);
        $("#dir_index_id").val(this.model.get('index_id'));
        $('select[name="dir_index_id"]').select2();
    }, unbindEvents: function() {
        this.$el.off();
    },
    events: {
        'click #request': 'requestService'
    },
    requestService: function() {
        //console.log($('#dir_data fieldset').serializeArray());
        $('#request').attr("disabled", "disabled");
        socket.emit('requestService', $('form').serializeObject());
    }
});
var tempAddress = new Address();
var serviceDirView = new ServiceDirView({model: tempAddress});

var UserDirsView = Backbone.View.extend({
    el: '#usr_prefered_dirs',
    render: function() {
        this.setElement($('#usr_prefered_dirs'));
        var that = this;
        var options = '<option>Seleccione una dirección</option>';
        var optionsTable = '<table class="table table-bordered"><thead><tr><th><h1>Direcciones de usuario</th></h1></tr></thead><tbody>';
        _.each(this.collection.toJSON(), function(tmpAddress) {
            /*tmpSchedule = new Schedule(schedule);
             itemId = ".page tbody #item" + schedule.id;
             var scheduleItemView = new ScheduleItemView({el: $(itemId), model: tmpSchedule});
             scheduleItemView.render();*/
            //options += '<option value="' + tmpAddress.id + '">' + tmpAddress.index_id + ' ' + tmpAddress.comp1 + ' No. ' + tmpAddress.comp2 + ' - ' + tmpAddress.no + ', Barrio: ' + tmpAddress.barrio + ' Obs:' + tmpAddress.obs + '</option>';
            optionsTable += '<tr id="dir-' + tmpAddress.id + '"><td>' + tmpAddress.index_id + ' ' + tmpAddress.comp1 + ' No. ' + tmpAddress.comp2 + ' - ' + tmpAddress.no + ', Barrio: ' + tmpAddress.barrio + ' Obs:' + tmpAddress.obs + '</td></tr>';
        });
        optionsTable += '</tbody></table>';
        //console.log(options);
        var template = _.template($('#user-dirs-template').html(), {options: options, user_dirs: optionsTable}); //{user: this.model.toJSON()}
        that.$el.html(template);
    },
    events: {
        //'change #usr_dirs': 'useDir',
        'click tr': 'selectDir'
    },
    useDir: function(ev) {
        //alert($('#usr_dirs').val());
        //var serviceDirView = new ServiceDirView({model: currentAddressGroup.get($('#usr_dirs').val())});
        //console.log(currentAddressGroup.get($('#usr_dirs').val()));
        serviceDirView.model.set(currentAddressGroup.get($('#usr_dirs').val()).toJSON());
        //console.log(serviceDirView);
        serviceDirView.render();
    },
    selectDir: function(ev) {
        //console.log(ev);
        var str = ev.currentTarget.id;
        var dirId = str.split('-');
        //console.log(dirId[1]);
        serviceDirView.model.set(currentAddressGroup.get(dirId[1]).toJSON());
        //console.log(serviceDirView);
        serviceDirView.render();
    }
});
var userDirsView = new UserDirsView({collection: currentAddressGroup});

var ServiceStateView = Backbone.View.extend({
    el: '#serviceData',
    model: Service,
    initialize: function() {
        //this.unbind(); // Unbind all local event bindings
        this.model.on('change', this.render, this);
    },
    render: function() {
        //console.log(this.model.toJSON());
        var that = this;
        //console.log(this.model.toJSON());
        var template = _.template($('#service-data-template').html(), {service: this.model.toJSON()});
        //console.log(template);
        that.$el.html(template);
    },
    events: {
        'click #cancelService': 'cancelService'
    },
    cancelService: function() {
        //alert('Hey');
        $('#cancelService').attr("disabled", "disabled");
        $('#request').removeAttr("disabled");
        $('#request1').removeAttr("disabled");
        socket.emit('cancelService', {service: this.model.toJSON()});
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
    // socket.emit('schedules');
})
Backbone.history.start();


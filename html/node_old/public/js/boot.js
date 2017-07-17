require.config({
    paths: {
        jQuery: '/js/libs/jquery',
        Underscore: '/js/libs/underscore',
        Backbone: '/js/libs/backbone',
        text: '/js/libs/text',
        templates: '../templates',
        SchedulesMan: '/js/SchedulesMan',
        ServiceMan: '/js/ServiceMan'
    },
    shim: {
        'Backbone': ['Underscore', 'jQuery'],
        'SchedulesMan': ['Backbone'],
        'ServiceMan': ['Backbone']
    }
});

require(['SchedulesMan'], function(SchedulesMan) {
    SchedulesMan.initialize();
});


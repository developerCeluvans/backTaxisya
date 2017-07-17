define(['text!templates/schedules.html'], function(schedulesTemplate) {
    var schedulesView = Backbone.View.extend({
        el: $('#content'),
        render: function() {
            this.$el.html(schedulesTemplate);
        }
    });

    return new schedulesView;
});


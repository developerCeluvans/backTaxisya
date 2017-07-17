define(['views/schedules'], function(schedulesView) {
    var initialize = function() {
        schedulesView.render();
    }

    return {
        initialize: initialize
    };
});
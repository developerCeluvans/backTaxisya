Schedule = Backbone.Model.extend({
    defaults: {
    },
    initialize: function() {
//        this.on('change:status', function(model) {
//            console.log('- Values for this model have changed.', model.get('status'));
//            //console.log(model);
//
//            var state = parseInt(model.get('status'));
//            scheduleId = parseInt(model.get('id'));
//            //console.log(state);
//            if (state === 5) {
//                clearInterval(schedulesIntervals[scheduleId]);
////                //tmpSchedule = model;//schedule);
//                itemId = ".page tbody #item" + parseInt(model.get('id'));//schedule.id;
//                var scheduleItemView = new ScheduleItemView({el: $(itemId), model: model});//tmpSchedule});
//                $(itemId).css('background-color', 'rgb(31, 255, 0)');
//                scheduleItemView.render();
////                //remove from table;
////                /*itemId = ".page tbody #item" + model.id;
////                 $(itemId).remove();*/
//            }
//        });
        // Do initialization 
    }
});

/*var account = new Stooge({ name: 'Larry', power: 'Baldness',
 friends: ['Curly', 'Moe']});*/
var Schedules = Backbone.Collection.extend({
    model: Schedule
});

/*function responseToCollection(dataArray){
 for (var i = dataArray.length - 1; i >= 0; i--) {
 var schedule+"-"+1=dataArray[i];
 };
 }*/
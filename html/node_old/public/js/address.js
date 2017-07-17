Address = Backbone.Model.extend({
    defaults: {
    },
    initialize: function() {
        // Do initialization 
    }
});

/*var account = new Stooge({ name: 'Larry', power: 'Baldness',
 friends: ['Curly', 'Moe']});*/
var Addresses = Backbone.Collection.extend({
    model: Address
});

/*function responseToCollection(dataArray){
 for (var i = dataArray.length - 1; i >= 0; i--) {
 var schedule+"-"+1=dataArray[i];
 };
 }*/
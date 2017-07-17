/**
* Search function.
*
* @param {String} search query
* @param {Function} callback
* @api public
*/
//var request = require('superagent');
var geocoder = require('geocoder');

exports.serviceLatLng = serviceLatLng;

function serviceLatLng (address,fn) {
  //console.log(address);
  geocoder.geocode(address, function ( err, data ) {
    //console.log(data);
    if (data && Array.isArray(data.results)) {
      return fn(null, data.results);
    }
    fn(new Error('Nos fregamos mano'));
  });
};  
var http 	= require('http');
var request = require('superagent');

var intervalCancelService = setInterval(cancelServicePending, 1 * 60 * 1000);

function cancelServicePending()
{
    request.post('http://localhost/public/v2/cancelservices/')
	  .send({ name: 'Manny', species: 'cat' })
	  .set('X-API-Key', 'foobar')
	  .set('Accept', 'application/json')
	  .end(function(error, res)
	  {
	  	console.log(res.text);
	  }
	);
}


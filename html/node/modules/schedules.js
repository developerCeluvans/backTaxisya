var request = require('superagent');

exports.daily = daily;

function daily(req, fn) {
    //request.get('http://search.twitter.com/search.json')
    /*request
     .post('/api/pet')
     .send({ name: 'Manny', species: 'cat' })
     .set('X-API-Key', 'foobar')
     .set('Accept', 'application/json')
     .end(function(error, res){
     
     });*/
    request.post('http://apps.imaginamos.com.co/taxisya/public/schedule/daily')
            //.data({ q: query })
            .send()
            .set('X-API-Key', 'taxisya')
            .set('Accept', 'application/json')
            .end(function(res) {
        console.log(res.body);
        if (res.body && Array.isArray(res.body)) {
            return fn(null, res.body);
        }
        fn(new Error('Error'));
    });
}



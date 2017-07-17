var http = require('http');
var express = require("express");
var request = require('superagent');
var address = require('./public/libs/addresses');
var app = express();
var port = 3700;
var tmpCounter = 0;
var serverUrl = 'http://localhost/';//192.237.188.107/';
//var schedule = require('./modules/schedules');

var positions = {}
, total = 0;
        // , servicesIntervals = []
        //, service_id
        // , servicesThread = setInterval(serviceChecker,20000);
//var server = http.createServer(app).listen(port);


//app.set('views', __dirname + '/tpl');
//app.set('view engine', "jade");
//app.engine('jade', require('jade').__express);

app.use(express.static(__dirname + '/public'));
app.use(express.bodyParser());

var io = require('socket.io').listen(app.listen(port));//,{ log: false });
//io.set('log level', 0); // reduce logging
io.set('log level', 2); // reduce logging
io.set('close timeout', 1000);
io.set('heartbeat timeout', 1000);
//var io = require('socket.io').listen(server);

/*app.get("/", function(req, res) {
 //res.render("page");
 res.sendfile(__dirname + '/public/templates/schedules.html');
 });*/

// function serviceChecker() {
//     //console.log("hey");
//     servicesIntervals.forEach(function(item , index){
//         //console.log("Diff: %s, index:%s",Math.round((Date.now()-item)/1000),index);
//         if(Math.round((Date.now()-item)/1000)>=60){
//             serviceStateChecker(index);
//             servicesIntervals.splice(index,1);
//         }
//     });
// }

// function serviceStateChecker(service_id) {
//     //scheduleState(model.id)
//     //service_id = 6264;
//     //console.log(service_id);
//     request.post(serverUrl + 'public/service/status')
//             //.type('form')
//             .send({service_id: service_id})
//             .set('X-API-Key', 'taxisya')
//             .set('Accept', 'application/json')
//             .end(function(serviceState) {
//         //console.log(serviceState.text);
//         //console.log(parseInt(serviceState.body.status_id, 10));
//         if (parseInt(serviceState.body.status_id, 10) == 1) {
//             //cancel services
//             //console.log("y aja");
//             //v2/user/(:num)/cancelservice
//             //var serviceCancelUrl = serverUrl + 'public/v2/user/' + serviceState.body.user_id + '/cancelservice';
//             var serviceCancelUrl = serverUrl + 'public/service/systemcancel';
//             //console.log(serviceCancelUrl);
//             request
//                     .post(serviceCancelUrl)
//                     .send({service_id: service_id})
//                     .set('X-API-Key', 'taxisya')
//                     .set('Accept', 'application/json')
//                     .end(function(res) {
//                 //console.log(res.text);
//             });
//         } else {
//             //console.log("Allright");
//         }
//     });
// }


function ServiceMonitor(service_id) {

    this.service_id = service_id;
    this.asked_on = Date.now();

    this.setupInterval(90*1000);

}
ServiceMonitor.prototype.setupInterval = function (time) {

    var self = this;
    console.log('Setting up interval for service ' + this.service_id + '');
    setTimeout(function () {
        self.cancelServiceIfPending();
    }, time);

}
ServiceMonitor.prototype.cancelServiceIfPending = function () {
    //laravel server
    var self = this;
    console.log('Checking status for service '+ this.service_id +'...');
    request.post(serverUrl + 'public/service/status')
            .set('X-API-Key', 'taxisya')
            .set('Accept', 'application/json')
            .send({service_id: this.service_id})
            .end(function(res) {

                if (res.ok) {
                    console.log('Could happily check status');
                    self._cancelService(res.body);
                } else {
                    //si algo salió mal, volver a intentar en 5 segundos
                    console.log("Could not check status, we'll try again in 5 seconds");
                    self.setupInterval(5*1000);
                }


            });
}
ServiceMonitor.prototype._cancelService = function (service) {
    var self = this;

    if (parseInt(service.status_id) === 1) {
        //cancelar con laravel
        console.log('Cancelling service '+ this.service_id +'...');
        var serviceCancelUrl = serverUrl + 'public/service/systemcancel';
        request
                .post(serviceCancelUrl)
                .send({service_id: this.service_id})
                .set('X-API-Key', 'taxisya')
                .set('Accept', 'application/json')
                .end(function (res) {

                    if (res.ok) {
                        console.log("Service was canceled");
                    } else {
                        //si algo salió mal, volver a intentar en 5 segundos
                        console.log("Could not cancel, we'll try again in 5 seconds");
                        self.setupInterval(5*1000);
                    }

                });
    } else {
        console.log("Service is no longer pending, no need to cancel");
    }
}

app.get("/test",function(req, res){
    res.write("1");
    res.end();
});

app.get("/service", function(req, res) {
    //res.render("page");
    res.sendfile(__dirname + '/public/templates/createService.html');
});

app.get("/schedule/:customer_id", function(req, res) {
    //res.render("page");
    console.log(req.params);
    //res.sendfile(__dirname + '/public/templates/schedulesIndex.html?customer_id='+req.params.customer_id);
    res.redirect('/templates/schedulesIndex.html?customer_id='+req.params.customer_id)
});

app.get('/reverse/geocoding/:address', function(req, res, next) {
    console.log(req.params.address);
    var tmpAddress = req.params.address;
    //console.log(req.query);
    //address.serviceLatLng("Calle 134 104 -10 Bogotá, Bogota, Colombia", function(err, result) {
    address.serviceLatLng(tmpAddress, function(err, result) {
        if (err)
            return next(err);
        console.log(result[0].geometry);
        //res.render('index');
    });
});

app.post("/service/request", function(req,res,next) {
    console.log("/service/reqyest");
    //console.log(req.body.email);
    //console.log(req.body.password);
    //console.log(req.body.order);
    //console.log(req.text);
    //console.log(io);
    /*
     'index_id' => Input::get('index_id'),
     'comp1' => Input::get('comp1'),
     'comp2' => Input::get('comp2'),
     'no' => Input::get('no'),
     'barrio' => Input::get('barrio'),
     'obs' => Input::get('obs'),
     uuid
     Input::get('lat')
     Input::get('lng')
     user_id
     */
    var serverData;
    request.post(serverUrl + 'public/v2/user/' + req.body.user_id + '/requestservice')//public/service/requestiphone')
            //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
            //.data({ q: query })
            .type('form')
            .send(req.body)
            .set('X-API-Key', 'taxisya')
            .set('Accept', 'application/json')
            .end(function(serverResponse) {
        //console.log(serverResponse.body);
        console.log(serverResponse.text);
        //console.log(JSON.parse(serverResponse.text))
        if (serverResponse.body) {
            serverData = serverResponse.body;
            if (serverResponse.body.error) {

            } else {
                //io.sockets.emit('newOrder', serverData);
            }
            var service_id = serverResponse.body.service_id;
            //console.log(service_id);

            //res.send(serverResponse.text);
            //socket.emit('scheduleState', {schedule: res.body});
            //socket.emit('schedules', {schedules:res.body});
            //return fn(null, res.body);
            //schedules=res.body;//.body;
            res.send(serverData);
            res.service_id = service_id;
            next();
        }

    });


},function (req,res) {
    // servicesIntervals[res.service_id] = Date.now();
    new ServiceMonitor(res.service_id);
});


app.post("/schedule/request", function(req,res,next) {
    //console.log(req.body.email);
    //console.log(req.body.password);
    //console.log(req.body.order);
    //console.log(req.text);
    //console.log(io);
    /*
     'index_id' => Input::get('index_id'),
     'comp1' => Input::get('comp1'),
     'comp2' => Input::get('comp2'),
     'no' => Input::get('no'),
     'barrio' => Input::get('barrio'),
     'obs' => Input::get('obs'),
     uuid
     Input::get('lat')
     Input::get('lng')
     user_id
     */
    var serverData;
    request.post(serverUrl + 'public/schedule/create')//public/service/requestiphone')
            //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
            //.data({ q: query })
            .type('form')
            .send(req.body)
            .set('X-API-Key', 'taxisya')
            .set('Accept', 'application/json')
            .end(function(serverResponse) {
        //console.log(serverResponse.body);
        console.log(serverResponse.text);
        //console.log(JSON.parse(serverResponse.text))
        if (serverResponse.body) {
            serverData = serverResponse.body;
            if (serverResponse.body.error != 0) {

            } else {
                //io.sockets.emit('newOrder', serverData);
                io.sockets.emit('newSchedule', serverData);
            }
            var service_id = serverResponse.body.service_id;
            //console.log(service_id);

            //res.send(serverResponse.text);
            //socket.emit('scheduleState', {schedule: res.body});
            //socket.emit('schedules', {schedules:res.body});
            //return fn(null, res.body);
            //schedules=res.body;//.body;
            res.send(serverData);
            res.service_id = service_id;
        }

    });


});

app.post("/schedule/cancel", function(req,res,next) {
    //console.log(req.body.email);
    //console.log(req.body.password);
    //console.log(req.body.order);
    //console.log(req.text);
    //console.log(io);
    /*
     'index_id' => Input::get('index_id'),
     'comp1' => Input::get('comp1'),
     'comp2' => Input::get('comp2'),
     'no' => Input::get('no'),
     'barrio' => Input::get('barrio'),
     'obs' => Input::get('obs'),
     uuid
     Input::get('lat')
     Input::get('lng')
     user_id
     */
    var serverData;
    request.post(serverUrl + 'public/schedule/cancel')//public/service/requestiphone')
            //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
            //.data({ q: query })
            .type('form')
            .send(req.body)
            .set('X-API-Key', 'taxisya')
            .set('Accept', 'application/json')
            .end(function(serverResponse) {
        //console.log(serverResponse.body);
        console.log(serverResponse.text);
        //console.log(JSON.parse(serverResponse.text))
        if (serverResponse.body) {
            serverData = serverResponse.body;
            io.sockets.emit('canceledSchedule', serverData);
            var service_id = serverResponse.body.service_id;
            //console.log(service_id);

            //res.send(serverResponse.text);
            //socket.emit('scheduleState', {schedule: res.body});
            //socket.emit('schedules', {schedules:res.body});
            //return fn(null, res.body);
            //schedules=res.body;//.body;
            res.send(serverData);
            res.service_id = service_id;
        }

    });


});

/*app.get("/", function(req, res){
 res.send("It works!");
 });*/

io.sockets.on('connection', function(socket) {
// we give the socket an id
//socket.id = ++total;
//var schedules;
    /*request.post('http://apps.imaginamos.com.co/taxisya/public/schedule/daily')
     //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
     //.data({ q: query })
     .send()
     .set('X-API-Key', 'taxisya')
     .set('Accept', 'application/json')
     .end(function(res) {
     console.log(res.body);
     if (res.body && Array.isArray(res.body)) {
     socket.emit('schedules', {schedules:res.body});
     //return fn(null, res.body);
     //schedules=res.body;//.body;
     }
     //fn(new Error('Error'));
     });*/

    socket.on('schedules', function(customer_id) {
        console.log('Okey schedules req '+customer_id);
        console.log('---------------------');
        console.log(serverUrl + 'public/schedule/daily?customer_id='+customer_id);
        console.log('---------------------');
        request.post(serverUrl + 'public/schedule/daily?customer_id='+customer_id)
                //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
                //.data({ q: query })
                .set('X-API-Key', 'taxisya')
                .set('Accept', 'application/json')
                .end(function(res) {
            console.log('Body = '+res.body);
            if (res.body && Array.isArray(res.body)) {
                console.log('Body = '+res.body);
                socket.emit('schedules', {schedules: res.body});
                //return fn(null, res.body);
                //schedules=res.body;//.body;
            }
//fn(new Error('Error'));
        });
    });
    socket.on('scheduleState', function(data) {
        //console.log(data);
        console.log(data.scheduleId);
        request.post(serverUrl + 'public/schedule/details')
                //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
                //.data({ q: query })
                .send({schedule_id: data.scheduleId})
                .set('X-API-Key', 'taxisya')
                .set('Accept', 'application/json')
                .end(function(res) {
            //console.log(res.body);
            if (res.body) {
                
                socket.emit('scheduleState', {schedule: res.body});
                //socket.emit('schedules', {schedules:res.body});
                //return fn(null, res.body);
                //schedules=res.body;//.body;
            }
        });
//fn(new Error('Error'));
//});
    });
    socket.on('scheduleStateDelete', function(data) {
        console.log('scheduleStateDelete en APP');
        console.log(data.scheduleId);
        request.post(serverUrl + 'public/schedule/details')
                //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
                //.data({ q: query })
                .send({schedule_id: data.scheduleId})
                .set('X-API-Key', 'taxisya')
                .set('Accept', 'application/json')
                .end(function(res) {
            //console.log(res.body);
            if (res.body) {
                
                socket.emit('scheduleStateDelete', {schedule: res.body});
                //socket.emit('schedules', {schedules:res.body});
                //return fn(null, res.body);
                //schedules=res.body;//.body;
            }
        });
//fn(new Error('Error'));
//});
    });
    socket.on('scheduleCancel', function(data){
        var serverData;
        request.post(serverUrl + 'public/schedule/cancelcms')//public/service/requestiphone')
            //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
            //.data({ q: query })
            .type('form')
            .send(data)
            .set('X-API-Key', 'taxisya')
            .set('Accept', 'application/json')
            .end(function(res) {
        //console.log(res.body);
        console.log(res.text);
        //console.log(JSON.parse(res.text))
        if (res.body) {
            serverData = res.body;
            io.sockets.emit('canceledSchedule', serverData);
            //var service_id = res.body.service_id;
            //console.log(service_id);

            //res.send(serverResponse.text);
            //socket.emit('scheduleState', {schedule: res.body});
            //socket.emit('schedules', {schedules:res.body});
            //return fn(null, res.body);
            //schedules=res.body;//.body;
            //res.send(serverData);
            //res.service_id = service_id;
        }

    });
    });

    socket.on('toService', function(data) {
        console.log('toService');
        console.log(data);
//io.sockets.emit('message', data);
        schedule_id = data.schedule_id;
        //console.log(data);
        //console.log(schedule_id);
        request.post(serverUrl + 'public/schedule/toservice')
                //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
                //.data({ q: query })
                .send({schedule_id: data.schedule_id})
                .set('X-API-Key', 'taxisya')
                .set('Accept', 'application/json')
                .end(function(res) {
            //console.log(res.body)ﬁ;
            if (res.body) {
                socket.emit('serviceCreated', {serviceData: res.body});
                //socket.emit('schedules', {schedules:res.body});
                //return fn(null, res.body);
                //schedules=res.body;//.body;
            }
        });
    });

    socket.on('requestService', function(data) {
        //console.log(data);
//io.sockets.emit('message', data);
        //schedule_id = data.schedule_id;
        //console.log(data);
        //console.log(schedule_id);
        //var tmpAddress = req.params.address;
        //console.log(req.query);
        //address.serviceLatLng("Calle 134 104 -10 Bogotá, Bogota, Colombia", function(err, result) {
        //var tmpAddress = "Calle 134 104 -10 Bogotá, Bogota, Colombia";//encodeURIComponent(
        var tmpAddress = data.dir_index_id + " " + data.dir_comp1 + " " + data.dir_comp2 + " -" + data.dir_no + " Bogotá, Colombia";//encodeURIComponent(
        //console.log(tmpAddress);
        address.serviceLatLng(tmpAddress, function(err, result) {
            if (err)
                return next(err);
            console.log(result[0].geometry);//result[0].geometry
            data.lat = result[0].geometry.location.lat;
            data.lng = result[0].geometry.location.lng;
            //console.log(data);
            request.post(serverUrl + 'public/service/cmsrequest')
                    //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
                    //.data({ q: query })
                    .send(data)
                    .set('X-API-Key', 'taxisya')
                    .set('Accept', 'application/json')
                    .end(function(err, res) {
                //console.log('ERROR: ', err);
                //console.log(res.body);
                if (res.body) {
                    socket.emit('serviceCreated', {serviceData: res.body});
                    //socket.emit('schedules', {schedules:res.body});
                    //return fn(null, res.body);
                    //schedules=res.body;//.body;
                }
            });
        });

        /*
         request.post('http://apps.imaginamos.com.co/taxisya/public/service/cmsrequest')
         //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
         //.data({ q: query })
         .send(data)
         .set('X-API-Key', 'taxisya')
         .set('Accept', 'application/json')
         .end(function(res) {
         //console.log(res.body);
         if (res.body) {
         socket.emit('serviceCreated', {serviceData: res.body});
         //socket.emit('schedules', {schedules:res.body});
         //return fn(null, res.body);
         //schedules=res.body;//.body;
         }
         });*/
    });


    socket.on('serviceState', function(data) {

        serviceId = data.serviceId;
        //console.log(data);
        //console.log(schedule_id);
        request.post(serverUrl + 'public/service/status')
                //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
                //.data({ q: query })
                .send({service_id: serviceId})
                .set('X-API-Key', 'taxisya')
                .set('Accept', 'application/json')
                .end(function(res) {
            //console.log(res.body);
            if (res.body) {
                socket.emit('serviceState', {serviceData: res.body});
                //socket.emit('schedules', {schedules:res.body});
                //return fn(null, res.body);
                //schedules=res.body;//.body;
            }
        });
    });

    socket.on('cancelService', function(data) {
        serviceId = data.service.id;
        //console.log(data);
        //console.log(schedule_id);

        request.post(serverUrl + 'public/service/cmscancelservice')
                //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
                //.data({ q: query })
                .send({serviceId: serviceId})
                .set('X-API-Key', 'taxisya')
                .set('Accept', 'application/json')
                .end(function(res) {
            console.log(res.body);
            if (res.body) {
                socket.emit('serviceState', {serviceData: res.body});
                //socket.emit('schedules', {schedules:res.body});
                //return fn(null, res.body);
                //schedules=res.body;//.body;
            }
        });
    });
    socket.on('expiredSchedule', function(data) {
        service_id = data.schedule_id;
        //console.log(data);
        request.post(serverUrl + 'public/schedule/toservice')
                //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
                //.data({ q: query })
                .send()
                .set('X-API-Key', 'taxisya')
                .set('Accept', 'application/json')
                .end(function(res) {
            //console.log(res.body);
            if (res.body && Array.isArray(res.body)) {
                socket.emit('serviceState', {serviceData: res.body});
                //socket.emit('schedules', {schedules:res.body});
                //return fn(null, res.body);
                //schedules=res.body;//.body;
            }
        });
    });
    socket.on('lookForUser', function(data) {

        //console.log(data);
        user_telephone = data.user_telephone;
        request.post(serverUrl + 'public/user/lookfor')
                //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
                //.data({ q: query })
                .send({user_telephone: data.user_telephone})
                .set('X-API-Key', 'taxisya')
                .set('Accept', 'application/json')
                .end(function(err, res) {
            //console.log('ERROR: ', err);
            //console.log(res.text);
            if (res.body) {
                socket.emit('userData', {userData: res.body});
                //socket.emit('schedules', {schedules:res.body});
                //return fn(null, res.body);
                //schedules=res.body;//.body;
            }
        });
    });

    socket.on('registerUser', function(data) {

        //console.log('registerUser');
        //console.log(data);
        user_telephone = data.telephone;
        user_name = data.name;
        user_lastname = data.lastname;
        //{telephone:$('#usr_telephone').val(),name:$('#usr_name').val(),lastname:$('#usr_lastname').val()}

        request.post(serverUrl + 'public/user/phoneregister')
                //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
                //.data({ q: query })
                .send({telephone: user_telephone, name: user_name, lastname: user_lastname})
                .set('X-API-Key', 'taxisya')
                .set('Accept', 'application/json')
                .end(function(res) {
            //console.log(res.text);
            if (res.body) {
                socket.emit('userData', {userData: res.body});
                //socket.emit('schedules', {schedules:res.body});
                //return fn(null, res.body);
                //schedules=res.body;//.body;
            }
        });
    });

    socket.on('userDirs', function(data) {

        //console.log(data);
        request.post(serverUrl + 'public/address/cmsbyuser')
                //request.get('http://apps.imaginamos.com.co/colombia_digital/public/book')
                //.data({ q: query })
                .send({user_id: data.user_id})
                .set('X-API-Key', 'taxisya')
                .set('Accept', 'application/json')
                .end(function(res) {
            //console.log(res.text);
            if (res.body) {
                socket.emit('userDirs', {userDirs: res.body});
                //socket.emit('schedules', {schedules:res.body});
                //return fn(null, res.body);
                //schedules=res.body;//.body;
            }
        });
    });

});
//app.listen(port);
console.log("Listening on port " + port);

/**
 * Allow other processes to execute while iterating over
 * an array. Useful for large arrays, or long-running processing
 *
 * @param {Function} fn    iterator fed each element of the array.
 * @param {Function} next  executed when done
 */
Array.prototype.nonBlockingForEach = function(fn, next) {
  var arr = this;
  var i = 0;
  var len = arr.length;
  function iter() {
    if (i < len) {
      fn(arr[i]);
      i++;
      process.nextTick(iter);
    } else {
      next();
    }
  }
  iter();
};

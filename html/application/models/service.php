<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Service
 *
 * @author IngJohnGuerrero
 */
class Service extends Eloquent {

    //public static $timestamps = false;
    public static $table = 'services';
    public $includes = array('schedule', 'schedule.type', 'user', 'state', 'driver', 'driver.car');
    //protected $GOOGLE_API_KEY = "";
    protected $bounding;
    protected $closeDrivers;
    protected $closeServices;

    public function car() {
        return $this->belongs_to('Car');
    }

    public function user() {
        return $this->belongs_to('User');
    }

    public function driver() {
        return $this->belongs_to('Driver');
    }

    public function state() {
        return $this->belongs_to('State', 'status_id');
    }

    public function kind() {
        return $this->belongs_to('Kind', 'kind_id');
    }

    public function schedule() {
        return $this->belongs_to('Schedule', 'schedule_id');
    }

    public function logs() {
        return $this->has_many('Log');
    }

    /* public function status()
      {
      return $this->has_one('status');
      } */
    /*  public function index()
      {
      return $this->has_one('dir_indexes','index_id');
      } */

    public static $rules = array(
        'name' => 'required|min:2',
        'lastname' => 'required|min:2',
        'email' => 'required|min:2',
        'login' => 'required|min:2',
        'pwd' => 'required|min:2'
    );

    public static function validate($data) {
        return Validator::make($data, static::$rules);
    }

    function distance($lat1, $lng1, $lat2, $lng2, $miles = false) {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lng1 *= $pi80;
        $lat2 *= $pi80;
        $lng2 *= $pi80;

        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlng = $lng2 - $lng1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) *
                sin($dlng / 2) * sin($dlng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;

        return ($miles ? ($km * 0.621371192) : $km);
    }

    // getBoundingBox
    // hacked out by ben brown <ben@xoxco.com>
    // http://xoxco.com/clickable/php-getboundingbox
    // Modified by IngJohnGuerrero to handle km input
    // given a latitude and longitude in degrees (40.123123,-72.234234) and a distance in miles
    // calculates a bounding box with corners $distance_in_miles away from the point specified.
    // returns $min_lat,$max_lat,$min_lon,$max_lon 

    function getBoundingBox($lat_degrees, $lon_degrees, $distance_in_miles, $milesResult = true) {

        if ($milesResult) 
        {
            $radius = 3963.1; // of earth in miles
        } else {
            $radius = 6372.797; // of earth in km
        }

        // bearings 
        $due_north = 0;
        $due_south = 180;
        $due_east = 90;
        $due_west = 270;

        // convert latitude and longitude into radians 
        $lat_r = deg2rad($lat_degrees);
        $lon_r = deg2rad($lon_degrees);

        // find the northmost, southmost, eastmost and westmost corners $distance_in_miles away
        // original formula from
        // http://www.movable-type.co.uk/scripts/latlong.html

        $northmost = asin(sin($lat_r) * cos($distance_in_miles / $radius) + cos($lat_r) * sin($distance_in_miles / $radius) * cos($due_north));
        $southmost = asin(sin($lat_r) * cos($distance_in_miles / $radius) + cos($lat_r) * sin($distance_in_miles / $radius) * cos($due_south));

        $eastmost = $lon_r + atan2(sin($due_east) * sin($distance_in_miles / $radius) * cos($lat_r), cos($distance_in_miles / $radius) - sin($lat_r) * sin($lat_r));
        $westmost = $lon_r + atan2(sin($due_west) * sin($distance_in_miles / $radius) * cos($lat_r), cos($distance_in_miles / $radius) - sin($lat_r) * sin($lat_r));


        $northmost = rad2deg($northmost);
        $southmost = rad2deg($southmost);
        $eastmost  = rad2deg($eastmost);
        $westmost  = rad2deg($westmost);

        // sort the lat and long so that we can use them for a between query    
        if ($northmost > $southmost) {
            $lat1 = $southmost;
            $lat2 = $northmost;
        } else {
            $lat1 = $northmost;
            $lat2 = $southmost;
        }


        if ($eastmost > $westmost) {
            $lon1 = $westmost;
            $lon2 = $eastmost;
        } else {
            $lon1 = $eastmost;
            $lon2 = $westmost;
        }

        return array($lat1, $lat2, $lon1, $lon2);
    }

    public function requestServiceEsteban($id = false, $lat, $lng, $serviceId = false, $distance=6)
    {

        $nigth = (date('G') < 5 || date('G') >= 22 ) ;
        //$distance = $nigth ? 10 : 6;
        $distanceAux = $nigth ? 5 : 2;

        list($lat1, $lat2, $lon1, $lon2) = $this->getBoundingBox($lat, $lng, $distanceAux, $milesResult = false);

        //list($lat1, $lat2, $lon1, $lon2) = $this->getBoundingBox($lat, $lng, $distance, $milesResult = false);

        $this->bounding['lat1'] = $lat1;
        $this->bounding['lng1'] = $lon1;
        $this->bounding['lat2'] = $lat2;
        $this->bounding['lng2'] = $lon2;
        //dd($this->bounding);
        //$sql="select * from drivers where (crt_lat between 4.60 and 4.69) and (crt_lng between -74.055 and -74.053);";
        $sql = "select id 
        from drivers 
        where (crt_lat between 
            {$lat1} and {$lat2}) 
        and (crt_lng between 
            {$lon1} and {$lon2}) 
        and available=1;";
        
        /* $this->closeDrivers = DB::table('drivers')
          ->where(function($query1) {
          $query1->where('crt_lat', '>', $this->bounding['lat1']);
          $query1->where('crt_lat', '<', $this->bounding['lat2']);
          })
          ->where(function($query) {
          $query->where('crt_lng', '>', $this->bounding['lng1']);
          $query->where('crt_lng', '<', $this->bounding['lng2']);
          })
          ->where_status_id('1')
          ->get(array('id', 'uuid')); */
        
        $this->closeDrivers = DB::query("SELECT drivers.* ,
                                              (3959 * ACOS( COS( RADIANS( ? ) ) * 
                                                COS( RADIANS( crt_lat ) ) * COS( RADIANS( crt_lng ) - 
                                                  RADIANS( ? ) ) + SIN ( RADIANS( ? ) ) * SIN( RADIANS( crt_lat ) ) )
                                                                                  ) AS distance
                                                                                  FROM drivers
                                                                                  WHERE available =  '1'
                                                                                  HAVING distance < ?
                                                                                  ORDER BY distance ",array($lat,$lng,$lat,$distance));

                           
        //push notification to driver
        /* $push = Push::make();
          $pushMessage = 'Se ha solicitado un servicio cerca a usted, desea tomarlo?';
          $pushMetaData = array('servicio' => Response::eloquent(Service::find($serviceId))); */
        //dd($pushMetaData);
        //envio de push
        /* foreach ($this->closeDrivers as $key => $driver) {
          //$push->android($driver->uuid, $pushMessage, 1, 'default', $action_key = 'Open', $pushMetaData);
          } */
        //return $pushMetaData;
        return $this->closeDrivers;
    }

    public function requestService($id = false, $lat, $lng, $serviceId = false, $distance=6) 
    {
         $nigth = (date('G') < 5 || date('G') >= 22 ) ;
        //$distance = $nigth ? 10 : 6;
        $distanceAux = $nigth ? 5 : 2;
        
        list($lat1, $lat2, $lon1, $lon2) = $this->getBoundingBox($lat, $lng, $distanceAux, $milesResult = false);

        //list($lat1, $lat2, $lon1, $lon2) = $this->getBoundingBox($lat, $lng, $distance, $milesResult = false);

        $this->bounding['lat1'] = $lat1;
        $this->bounding['lng1'] = $lon1;
        $this->bounding['lat2'] = $lat2;
        $this->bounding['lng2'] = $lon2;
        //dd($this->bounding);
        //$sql="select * from drivers where (crt_lat between 4.60 and 4.69) and (crt_lng between -74.055 and -74.053);";
        $sql = "select id 
        from drivers 
        where (crt_lat between 
            {$lat1} and {$lat2}) 
        and (crt_lng between 
            {$lon1} and {$lon2}) 
        and available=1 group by uuid;";
        
        /* $this->closeDrivers = DB::table('drivers')
          ->where(function($query1) {
          $query1->where('crt_lat', '>', $this->bounding['lat1']);
          $query1->where('crt_lat', '<', $this->bounding['lat2']);
          })
          ->where(function($query) {
          $query->where('crt_lng', '>', $this->bounding['lng1']);
          $query->where('crt_lng', '<', $this->bounding['lng2']);
          })
          ->where_status_id('1')
          ->get(array('id', 'uuid')); */
        
        $this->closeDrivers = Driver::where_between('crt_lat', $lat1, $lat2)
                                      ->where_between('crt_lng', $lon1, $lon2)
                                      ->where('available', '=', '1')
                    ->distinct('uuid')->get();

                           
        //push notification to driver
        /* $push = Push::make();
          $pushMessage = 'Se ha solicitado un servicio cerca a usted, desea tomarlo?';
          $pushMetaData = array('servicio' => Response::eloquent(Service::find($serviceId))); */
        //dd($pushMetaData);
        //envio de push
        /* foreach ($this->closeDrivers as $key => $driver) {
          //$push->android($driver->uuid, $pushMessage, 1, 'default', $action_key = 'Open', $pushMetaData);
          } */
        //return $pushMetaData;
        return $this->closeDrivers;
    }

    public function getBounds($lat, $lng, $distance )
    {
      return $this->getBoundingBox($lat, $lng, $distance, $milesResult = false);
    }

    public function getNearServices($lat, $lng, $boundingBox = true) {

        $nigth = (date('G') < 5 || date('G') >= 22 ) ;
        //$distance = $nigth ? 10 : 6;
        $distanceAux = $nigth ? 5 : 2;

         list($lat1, $lat2, $lon1, $lon2) = $this->getBoundingBox($lat, $lng, $distanceAux, $milesResult = false);
       // list($lat1, $lat2, $lon1, $lon2) = $this->getBoundingBox($lat, $lng, 3, $milesResult = false);
        
        $this->bounding['lat1'] = $lat1;
        $this->bounding['lng1'] = $lon1;
        $this->bounding['lat2'] = $lat2;
        $this->bounding['lng2'] = $lon2;
        //dd($this->bounding);
        //$sql="select * from drivers where (crt_lat between 4.60 and 4.69) and (crt_lng between -74.055 and -74.053);";
//        $sql = "select id 
//        from drivers 
//        where (crt_lat between 
//            {$lat1} and {$lat2}) 
//        and (crt_lng between 
//            {$lon1} and {$lon2}) 
//        and available=1;";
        /* $this->closeServices = DB::table('services')
          ->where(function($query1) {
          $query1->where('from_lat', '>', $this->bounding['lat1']);
          $query1->where('from_lat', '<', $this->bounding['lat2']);
          })
          ->where(function($query) {
          $query->where('from_lng', '>', $this->bounding['lng1']);
          $query->where('from_lng', '<', $this->bounding['lng2']);
          })
          ->where('status_id', '=', '1')
          ->get(array('id', 'index_id', 'comp1', 'comp2', 'no', 'barrio', 'obs', 'from_lat', 'from_lng'));
         */
        //dd($this->closeServices);

        /* $this->closeServices = DB::table('services')
          ->where('from_lat', '>', $lat1)
          ->where('from_lat', '<', $lat2)
          ->where('from_lng', '>', $lon1)
          ->where('from_lng', '<', $lon2)
          ->where('status_id', '=', '1')
          ->get(array('id', 'index_id', 'comp1', 'comp2', 'no', 'barrio', 'obs', 'from_lat', 'from_lng')); */
        if ($boundingBox) {
            $this->closeServices = Service::with('schedule')->where('from_lat', '>', $lat1)
                            ->where('from_lat', '<', $lat2)
                            ->where('from_lng', '>', $lon1)
                            ->where('from_lng', '<', $lon2)
                            //->where(DB::RAW("DATE(updated_at)"), '=', DB::RAW("DATE(NOW())"))
                            ->where('status_id', '=', '1')->get();
        } else {
            $this->closeServices = Service::where('status_id', '=', '1')->get();
        }
        //$this->closeServices = Service::where('status_id', '=', '1')->get();
        //->get(array('id', 'index_id', 'comp1', 'comp2', 'no', 'barrio', 'obs', 'from_lat', 'from_lng'));
        return $this->closeServices;
    }

    //Funcion candidata pero nunca probada, presente en android Hive
    /* public function send_notification_android($registatoin_ids, $message) {
      // include config
      //include_once './config.php';
      // Set POST variables
      $url = 'https://android.googleapis.com/gcm/send';

      $fields = array(
      'registration_ids' => $registatoin_ids,
      'data' => $message,
      );

      $headers = array(
      'Authorization: key=' . $this->GOOGLE_API_KEY,
      'Content-Type: application/json'
      );
      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Disabling SSL Certificate support temporarly
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

      // Execute post
      $result = curl_exec($ch);
      if ($result === FALSE) {
      die('Curl failed: ' . curl_error($ch));
      }

      // Close connection
      curl_close($ch);
      echo $result;
      }

      public function send_notification_iphone($registatoin_ids, $message) {

      } */
}

?>
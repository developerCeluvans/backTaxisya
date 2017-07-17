<?php

return array(
    'local' => array(
        'ios' => array(
             // desarrolllo
            'host' => 'gateway.sandbox.push.apple.com:2195',
            // producción
            //'host' => 'gateway.push.apple.com:2195',
	    'cert' => path('bundle') . 'push/certificates/co_taxisya_usuario.pem',
            'pwd' => 'imaginamos'
        ),
        'taxistas_ios' => array(
            'host' => 'gateway.sandbox.push.apple.com:2195',
            'cert' => path('bundle') . 'push/certificates/taxisya_conductor_ck.pem',
            'pwd' => 'imaginamos'
        ),
        'diageo' => array(
            'host' => 'gateway.sandbox.push.apple.com:2195', //'gateway.sandbox.push.apple.com:2195',
            'cert' => path('bundle') . 'push/certificates/diageo_local.pem',
            'pwd' => 'imaginamos'
        ),
        'taxistas' => array(
           	 'id_project' => '147226821678',
            	'api_key' => 'AIzaSyBLv22dWJbgizNkJEwRTg6RTYSxWAsIDhI',
          	'host' => 'https://android.googleapis.com/gcm/send'
        ),
	'usuarios' => array(
		'id_project'    => '254682418821',
                'api_key'       => 'AIzaSyDUvcRAQqBsyMlmJ-kZ_nGaqCwMNSNxKfI',
                'host'          => 'https://android.googleapis.com/gcm/send'
	),
    ),
    'prod' => array(
        'ios' => array(
            'host' => 'gateway.sandbox.push.apple.com:2195',
            //'host' => 'gateway.push.apple.com:2195',
            'cert' => path('bundle') . 'push/certificates/co_taxisya_usuario.pem',
            'pwd' => 'imaginamos'
        ),
        'taxistas_ios' => array(
            'host' => 'gateway.sandbox.push.apple.com:2195',
            'cert' => path('bundle') . 'push/certificates/co_taxisya_conductor.pem',
            'pwd' => 'imaginamos'
        ),
        'diageo' => array(
            'host' => 'gateway.sandbox.push.apple.com:2195', //'gateway.sandbox.push.apple.com:2195',
            'cert' => path('bundle') . 'push/certificates/diageo.pem',
            'pwd' => 'imaginamos'
        ),
        'taxistas' => array(
            	// cuenta de taxisya firebase
            	'id_project' => '147226821678',
            	'api_key' => 'AIzaSyBLv22dWJbgizNkJEwRTg6RTYSxWAsIDhI',
            	'host' => 'https://android.googleapis.com/gcm/send'
            	//'host' => 'https://fcm.googleapis.com/fcm/send'

        ),
	'usuarios' => array(
		'id_project'    => '254682418821',
                'api_key'       => 'AIzaSyDUvcRAQqBsyMlmJ-kZ_nGaqCwMNSNxKfI',
                'host'          => 'https://android.googleapis.com/gcm/send'
            ),
    ),
);

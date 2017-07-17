<?php

return array(
    'local' => array(
        'ios' => array(
            'host' => 'gateway.sandbox.push.apple.com:2195', //'gateway.sandbox.push.apple.com:2195',
            'cert' => path('bundle') . 'push/certificates/cklocal.pem',
            'pwd' => 'imaginamos'
        ),
        'taxistas' => array(
            'id_project' => '217009125456', //'689821773563',
            'api_key' => 'AIzaSyDBtALa3dlayVcOnMJKdUaCqNsFcinm8Po', //'AIzaSyBmUa3uM0YI2p4tz700kydwUfTpGZ03QZw',
            'host' => 'https://android.googleapis.com/gcm/send'
        ),
		'usuarios' => array(
                'id_project'    => '239425727079',
                'api_key'       => 'AIzaSyDproJjJc6obUCPE1OuXmun0_0yN6dLEKY',
                'host'          => 'https://android.googleapis.com/gcm/send'
            ),
    ),
    'prod' => array(
        'ios' => array(
            'host' => 'gateway.push.apple.com:2195',
            'cert' => path('bundle') . 'push/certificates/ck.pem',
            'pwd' => 'imaginamos'
        ),
        'taxistas' => array(
            'id_project' => '217009125456', //'689821773563',
            'api_key' => 'AIzaSyDBtALa3dlayVcOnMJKdUaCqNsFcinm8Po', //'AIzaSyBmUa3uM0YI2p4tz700kydwUfTpGZ03QZw',
            'host' => 'https://android.googleapis.com/gcm/send'
        ),
		'usuarios' => array(
                'id_project'    => '239425727079',
                'api_key'       => 'AIzaSyDproJjJc6obUCPE1OuXmun0_0yN6dLEKY',
                'host'          => 'https://android.googleapis.com/gcm/send'
            ),
    ),
);
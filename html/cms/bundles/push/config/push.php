<?php

return array(
    'local' => array(
        'ios' => array(
             // desarrolllo
            'host' => 'gateway.push.apple.com:2195',
            'cert' => path('bundle') . 'push/certificates/co_taxisya_usuario.pem',
            'pwd' => 'imaginamos'
        ),
        'taxistas_ios' => array(
           // 'host' => 'gateway.sandbox.push.apple.com:2195',
            'host' => 'gateway.push.apple.com:2195',
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
            'api_key' => 'AIzaSyCINYqzLIfJbasINqeS4qAlgrcq0Np3iLI', //'AIzaSyBmUa3uM0YI2p4tz700kydwUfTpGZ03QZw',
            'host' => 'https://android.googleapis.com/gcm/send'
        ),
        'usuarios' => array(
                'id_project'    => '254682418821',
                'api_key'       => 'AIzaSyA47lBB0XAPgt2yAIfw7YoXOl7m49PP76M',
                'host'          => 'https://android.googleapis.com/gcm/send'
            ),
    ),
    'prod' => array(
        'ios' => array(
            //'host' => 'gateway.sandbox.push.apple.com:2195',
            'host' => 'gateway.push.apple.com:2195',
            //'cert' => path('bundle') . 'push/certificates/taxisya_usuarios_ck.pem',
            'cert' => path('bundle') . 'push/certificates/co_taxisya_usuario.pem',
            'pwd' => 'imaginamos'
        ),
        'taxistas_ios' => array(
            //'host' => 'gateway.sandbox.push.apple.com:2195',
            'host' => 'gateway.push.apple.com:2195',
            'cert' => path('bundle') . 'push/certificates/co_taxisya_conductor.pem',
            'pwd' => 'imaginamos'
        ),
        'diageo' => array(
            'host' => 'gateway.sandbox.push.apple.com:2195', //'gateway.sandbox.push.apple.com:2195',
            'cert' => path('bundle') . 'push/certificates/diageo.pem',
            'pwd' => 'imaginamos'
        ),
        'taxistas' => array(
            'id_project' => '147226821678',
            'api_key' => 'AIzaSyCINYqzLIfJbasINqeS4qAlgrcq0Np3iLI', //'AIzaSyBmUa3uM0YI2p4tz700kydwUfTpGZ03QZw',
            'host' => 'https://android.googleapis.com/gcm/send'
        ),
        'usuarios' => array(
    		'id_project'    => '254682418821',
                'api_key'       => 'AIzaSyA47lBB0XAPgt2yAIfw7YoXOl7m49PP76M',
                'host'          => 'https://android.googleapis.com/gcm/send'
            ),
    ),
);

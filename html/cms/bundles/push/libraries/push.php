<?php

class Push
{

    protected static $config;

    public function __construct($config = null)
    {
        if(is_array($config))
        {
            static::$config = $config;
        }
        else
        {
            static::$config = (Request::env() != 'local') ? Config::get('push::push.prod') : Config::get('push::push.prod');
        }
    }

    public static function make($config = null)
    {
        return new static($config);
    }

    public static function getConfig()
    {
        return static::$config;
    }

    function android($tokens, $message = 'Laravel Push Notification', $badge = 1, $sound = 'default', $action_key = 'Open', $custom_parameters = array())
    {

        $config = static::$config['taxistas'];
        $tokens = (array)$tokens;

        $data['message']    = $message;
        $data['badge']      = $badge;
        $data['sound']      = $sound;
        $data['action_key'] = $action_key;

        new Push\Android($tokens, $data, $config, $custom_parameters);

    }
    public function drivers($tokens, $message = 'Laravel Push Notification', $badge = 1, $sound = 'default', $action_key = 'Open', $custom_parameters = array())
    {
        // determine type devices

        return $this->android($tokens, $message, $badge, $sound, $action_key, $custom_parameters);
    }

    function android2($tokens, $message = 'Laravel Push Notification', $badge = 1, $sound = 'default', $action_key = 'Open', $custom_parameters = array())
    {

        $config = static::$config['usuarios'];
        $tokens = (array)$tokens;

        $data['message']    = $message;
        $data['badge']      = $badge;
        $data['sound']      = $sound;
        $data['action_key'] = $action_key;

        new Push\Android($tokens, $data, $config, $custom_parameters);

    }
    public function users($tokens, $message = 'Laravel Push Notification', $badge = 1, $sound = 'default', $action_key = 'Open', $custom_parameters = array())
    {
        return $this->android2($tokens, $message, $badge, $sound, $action_key, $custom_parameters);
    }

    function ios($tokens, $message = 'Laravel Push Notification', $badge = 1, $sound = 'default', $action_key = 'Open', $custom_parameters = array())
    {

        $config = static::$config['ios'];
        $tokens = (array)$tokens;

        $data['message']    = $message;
        $data['badge']      = $badge;
        $data['sound']      = $sound;
        $data['action_key'] = $action_key;

        /*$validation = new Push\Validation(
            array(
                'alert'         => $message,
                'badge'         => $badge,
                'device_token'  => $tokens
            )
        );

        $validation->validate();*/
        //dd("push_ios");
        new Push\iOS($tokens, $data, $config, $custom_parameters);

    }

    function taxistas_ios($tokens, $message = 'Laravel Push Notification', $badge = 1, $sound = 'default', $action_key = 'Open', $custom_parameters = array())
    {
        $config = static::$config['taxistas_ios'];
        $tokens = (array)$tokens;

        $data['message']    = $message;
        $data['badge']      = $badge;
        $data['sound']      = $sound;
        $data['action_key'] = $action_key;

        //dd("push_ios");
        new Push\iOS($tokens, $data, $config, $custom_parameters);
    }

    function diageo_ios($tokens, $message = 'Laravel Push Notification', $badge = 1, $sound = 'default', $action_key = 'Open', $custom_parameters = array())
    {

        $config = static::$config['diageo'];
        $tokens = (array)$tokens;

        $data['message']    = $message;
        $data['badge']      = $badge;
        $data['sound']      = $sound;
        $data['action_key'] = $action_key;

        /*$validation = new Push\Validation(
            array(
                'alert'         => $message,
                'badge'         => $badge,
                'device_token'  => $tokens
            )
        );

        $validation->validate();*/

        new Push\iOS($tokens, $data, $config, $custom_parameters);

    }

}

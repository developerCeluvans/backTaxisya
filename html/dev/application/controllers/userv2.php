<?php


class UserV2_Controller extends Base_Controller {

	public function action_request_service($user_id)
	{
		$success = $user = User::find($user_id);

		$addr_data = array(
			'index_id' => Input::get('index_id'),
			'comp1' => Input::get('comp1'),
			'comp2' => Input::get('comp2'),
			'no' => Input::get('no'),
			'barrio' => Input::get('barrio'),
			'obs' => Input::get('obs'),
			'address' => NULL,
		);

		if ($success)
		{
			if ($user->get_wating_service())
			{

				return JSONResponse::error(404);
				//$user->cancel_service();

				//return JSONResponse::error(500);

			}

			User::update($user_id, array('uuid' => Input::get('uuid')));

			if (!$user->updateAddressPreference($addr_data))
			{
				$user->addAddress($addr_data);
			}

	    	$success = $service = $user->request_service($addr_data, Input::get('lat'), Input::get('lng'));

	    	if ($success)
	    	{
				$payload = array();
				$payload['service_id'] = $service->id;
				return JSONResponse::success($payload);
	    	}

	        return JSONResponse::error(500);
		}
		return JSONResponse::error(404);
	}

	// request service full address
	public function action_request_service_address($user_id)
	{
		$success = $user = User::find($user_id);
		//Log::write('info',action_request_service_address from user: '.$user_id);
        //Log::error('This is an error!');
		$addr_data = array(
			'index_id' => '',
			'comp1' => '',
			'comp2' => '',
			'no' => '',
			'obs' => '',
			'barrio' => Input::get('barrio'),
			'address' => Input::get('address'),
			'pay_type' => Input::get('pay_type'),
			'pay_reference' => Input::get('pay_reference'),
			'user_email' => Input::get('user_email'),						
			'user_card_reference' => Input::get('user_card_reference')

		);

        //dd($addr_data);
		if ($success) {
			if ($user->get_wating_service()) {
				return JSONResponse::error(404);
				//$user->cancel_service();
			}
			User::update($user_id, array('uuid' => Input::get('uuid')));
			// if (!$user->updateAddressPreference($addr_data)) {
			// 	$user->addAddress($addr_data);
			// }

	    	$success = $service = $user->request_service($addr_data, Input::get('lat'), Input::get('lng'));



	    	if ($success) {
				$payload = array();
				$payload['service_id'] = $service->id;
				$payload['status_id'] = $service->status_id;
				return JSONResponse::success($payload);
	    	}
	        return JSONResponse::error(500);
		}
		return JSONResponse::error(404);
	}

	public function action_cancel_service($user_id)
	{
		$success = $user = User::find($user_id);

		if ($user)
		{
			$success = $user->cancel_service(Input::has('by_system'));
		}
        return ($success) ? JSONResponse::success() : JSONResponse::error(404);
	}

}

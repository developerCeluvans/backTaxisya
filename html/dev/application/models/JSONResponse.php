<?php


class JSONResponse extends Response{

	public static function success($data = array())
	{
		$final_data = array_merge($data);
		$final_data['success'] =  true;
		$final_data['error'] =  0;
		return Response::json($final_data, 200);
	}	

	public static function error($error, $data = array())
	{
		$final_data = array_merge($data);
		$final_data['success'] =  false;
		$final_data['error'] =  $error;
		return Response::json($final_data, 200);
	}
}
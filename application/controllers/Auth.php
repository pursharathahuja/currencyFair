<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function checkRequestParams(){
		if($this->input->get_request_header('Authorization', TRUE)){
			$authorization = explode(':', base64_decode(explode(' ', $this->input->get_request_header('Authorization', TRUE))[1]));
			$userData['username'] = $authorization[0];
			$userData['password'] = $authorization[1];
			if($userData['username'] && $userData['password']){
				return $userData;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function getAuthToken(){
		if($_SERVER['REQUEST_METHOD'] != 'GET'){
			json_output(400, array('status' => 400, 'message' => 'Invalid Request Type'));
		} else {
			if($userData = $this->checkRequestParams()){
				$modelResponse = $this->MainModel->authenticateUserAndGenerateToken($userData);
				json_output(200, $modelResponse);
			}else{
				$response = array(
							'status' =>  422,
							'message' =>  'Invalid authorization params',
				);
				json_output(422, $response);
			}
		}
	}
	
}

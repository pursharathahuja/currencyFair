<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consumer extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
    }

	public function index(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400, array('status' => 400, 'message' => 'Invalid request method!'));
		} else {
			if($this->input->get_request_header('userID', TRUE) != $this->chekConsumerRequestParams()['userId']){
				return json_output(422 , array('status' => 400, 'message' => 'userId mismatch!'));
			}
			if(($this->checkAuthHeaders()) && ($postData = $this->chekConsumerRequestParams())){
				$response = $this->MainModel->saveConsumerMessage($postData);
				if($response['status'] == 200){
					if($this->input->get_request_header('AuthToken', TRUE) != $response['authToken']){
						json_output(200 , array('status' => 200, 'message' => 'Transaction successfull!', 'updatedAuthToken' => $response['authToken']));
					}else{
						json_output(200 , array('status' => 200, 'message' => 'Transaction successfull!', 'authToken' => $response['authToken']));
					}
				}else{
					json_output(400 , array('status' => 400, 'message' => $this->MainModel->saveConsumerMessage($postData)['message']));
				}
			}else{
				json_output(400 , array('status' => 400, 'message' => 'Invalid headers or request params!'));
			}
		}
	}

	public function checkAuthHeaders(){
		if($this->input->get_request_header('AuthToken', TRUE) && $this->input->get_request_header('userID', TRUE)){
			return true;
		}else{
			return false;
		}
	}

	public function chekConsumerRequestParams(){
		$requiredKeys = array('userId',
							'currencyFrom',
							'currencyTo',
							'amountSell',
							'amountBuy',
							'rate',
							'timePlaced',
							'originatingCountry',
							);
		$postData = json_decode(file_get_contents('php://input'), true);
		if (count(array_intersect_key(array_flip($requiredKeys), $postData)) === count($requiredKeys)) {
			// All requiredKeys present!
			return $postData;
		}else{
			return false;
		}
	}

}

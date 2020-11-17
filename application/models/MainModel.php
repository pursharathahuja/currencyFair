<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainModel extends CI_Model {

    public $authToken;
    public $updatedAuthToken;

    public function authenticateUserAndGenerateToken($userData){
        $queryResponse  = $this->db->select('password, id')->from('users')->where('username', $userData['username'])->get()->row();
        if($queryResponse == ""){
            return array('status' => 204,'message' => 'Incorrect Username entered');
        } else {
            if ($queryResponse->password == $userData['password']) {
                if($existingAuthTokenDetails = $this->checkForExistingAuthToken($queryResponse->id)){
                    if(date("Y-m-d H:i:s") >= $existingAuthTokenDetails->expired_at){
                        // Token expired refresh token
                        return $this->refreshAuthToken($existingAuthTokenDetails->users_id);
                    }else{
                        return array('status' => 200,
                                     'message'  => 'Auth Token still valid',
                                     'userID'   => $existingAuthTokenDetails->users_id,
                                     'token'    => $existingAuthTokenDetails->token,
                                     'expiry'   => $existingAuthTokenDetails->expired_at
                                    );
                    }
                }else{
                    return $this->generateNewAuthToken($queryResponse->id);
                }
            } else {
               return array('status' => 204, 'message' => 'Incorrect password entered');
            }
        }
    }

    public function refreshAuthToken($userId){
        $last_login = date('Y-m-d H:i:s');
        $token      = substr( md5(rand()), 0, 25);
        $expired_at = date("Y-m-d H:i:s", strtotime('+5 minutes'));
        $this->authToken = $token;
        $this->db->trans_start();
        $this->db->where('id', $userId)->update('users', array('last_login' => $last_login));
        $this->db->where('users_id', $userId)
                    ->update('users_authentication', array('expired_at'  => $expired_at,
                                                            'token'      => $token,
                                                        ));
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
           return false;
        } else {
           $this->db->trans_commit();
          return true;
        }
    }

    public function checkForExistingAuthToken($userId){
        $queryResponse  = $this->db->select('*')->from('users_authentication')->where('users_id', $userId)->get()->row();
        if($queryResponse == ""){
            return false;
        } else {
           return $queryResponse;
        }
    }

    public function generateNewAuthToken($userId){
        $last_login = date('Y-m-d H:i:s');
        $token      = substr( md5(rand()), 0, 25);
        $expired_at = date("Y-m-d H:i:s", strtotime('+5 minutes'));
        $this->db->trans_start();
        $this->db->where('id', $userId)->update('users', array('last_login' => $last_login));
        $this->db->insert('users_authentication', array('users_id' => $userId, 'token' => $token, 'expired_at' => $expired_at));
        if ($this->db->trans_status() === FALSE){
           $this->db->trans_rollback();
           return array('status' => 500, 'message' => 'Unable to create token, Server error.');
        } else {
           $this->db->trans_commit();
           return array('status' => 200, 'message' => 'Token generated sucessfully', 'userId' => $userId, 'token' => $token, 'expiry' => $expired_at);
        }
    }

    public function saveConsumerMessage($postData){
        if($this->checkConsumerAuthTokenValidity()){
            if($this->saveTransaction($postData)){
                return array('status' => 200,
                        'message'           => 'Transaction successfull',
                        'authToken'         => $this->authToken
                        );
            }else{
                return false;
            }
        }else{
            return array('status' => 400,
                'message'  => 'Auth token expired'
           );
        }
    }
    
    public function checkConsumerAuthTokenValidity(){
        $token  = $this->input->get_request_header('AuthToken', TRUE);
        $userId = $this->input->get_request_header('userID', TRUE);
        $queryResult  = $this->db->select('expired_at')->from('users_authentication')->where('users_id', $userId)->where('token', $token)->get()->row();
        $this->authToken = $token;
        if($queryResult == ""){
            return false;
        } else {
            if($queryResult->expired_at < date('Y-m-d H:i:s')){
               if($this->refreshAuthToken($userId)){
                    return true;
               }else{
                   return false;
               }
            } else {
                return true;
            }
        }
    }

    public function saveTransaction($postData){
        unset($postData['timePlaced']);
        $this->db->trans_start();
        $this->db->insert('transactions', $postData);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    public function getProcessedMessage(){
        return $this->db->select('*')->from('transactions')->order_by('id','asc')->get()->result_array();
    }

}

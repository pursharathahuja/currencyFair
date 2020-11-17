<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Ratchet\Server\IoServer;
use \Application\Libraries\Socket;
class RealTimeSocket extends CI_Controller {
	public function index(){
	  // Load package path
	  $this->load->add_package_path(FCPATH.'vendor/romainrg/ratchet_client');
	  $this->load->library('ratchet_client');
	  $this->load->remove_package_path(FCPATH.'vendor/romainrg/ratchet_client');

	  // Run server
	  $this->ratchet_client->run();
	//   $this->ratchet_client->set_callback('event', array($this, '_event'));

	//   $this->ratchet_client->send_message(json_encode(array('user_id' => 1, 'message' => Short on time!)));
	//   $this->ratchet_client->send_message(json_encode(array('user_id' => 1, 'message' => 'Ajaxed!')));
	  
	}
}

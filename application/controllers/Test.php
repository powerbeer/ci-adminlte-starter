<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	 
	public function test_template()
	{
		$this->load->view(TEMPLATE_PAGE_IFRAME);
	}
}

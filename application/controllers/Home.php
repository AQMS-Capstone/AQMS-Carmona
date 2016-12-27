<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
    {
        parent::__construct();
        $this->load->model('map_model');
        $this->load->helper('url_helper');
    }

    public function index()
	{
        $this->output->enable_profiler(TRUE);
        $data['title'] = 'Air Quality Monitoring System';

<<<<<<< HEAD
=======
        $array_data = $this->setDates();
        $data['bancal'] = $this->map_model->get_values($array_data[0], $array_data[1], "bancal");
        $data['slex'] = $this->map_model->get_values($array_data[0], $array_data[1], "slex");

>>>>>>> origin/AQMS-Laravel
        $this->load->view('/shared/header', $data);
		$this->load->view('home', $data);
	}

	private function setDates(){
        $array_data = array();

        date_default_timezone_set('Asia/Manila');

        $date_now = date("Y-m-d");
        $date_now_string = $date_now." 00:00:00";
        $date_tomorrow = date("Y-m-d", strtotime('tomorrow'));
        $date_tomorrow = $date_tomorrow." 00:00:00";
        $date_yesterday = date("Y-m-d", strtotime('yesterday'));

        $hour_value = date("H");

        if($hour_value == 0){
            array_push($array_data, $date_yesterday);
            array_push($array_data, $date_now_string);
        }else{
            array_push($array_data, $date_now);
            array_push($array_data, $date_tomorrow);
        }

        return $array_data;
    }
}

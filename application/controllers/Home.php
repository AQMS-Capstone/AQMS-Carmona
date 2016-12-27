<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
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
        $this->load->library('Area');
        $this->load->library('Map');
        $this->load->library('Constants');
    }

    public function index()
    {
        $this->output->enable_profiler(TRUE);
        $data['title'] = 'Air Quality Monitoring System';

        $area = array();

        $bancal = $this->GenerateMap("bancal");
        $slex = $this->GenerateMap("slex");

        array_push($area, $bancal);
        array_push($area, $slex);

        $this->load->view('/shared/header', $data);
        $this->load->view('home', $area);
    }

    private function setDates($hour_value){
        $array_data = array();

        date_default_timezone_set('Asia/Manila');

        $date_now = date("Y-m-d");
        $date_now_string = $date_now." 00:00:00";
        $date_tomorrow = date("Y-m-d", strtotime('tomorrow'));
        $date_tomorrow = $date_tomorrow." 00:00:00";
        $date_yesterday = date("Y-m-d", strtotime('yesterday'));

        if($hour_value == 0){
            array_push($array_data, $date_yesterday);
            array_push($array_data, $date_now_string);
        }else{
            array_push($array_data, $date_now);
            array_push($array_data, $date_tomorrow);
        }

        return $array_data;
    }
    private function classifyData($query){
        $array_holder = array();

        foreach ($query->result() as $row)
        {
            $dataClass = new Map();

            $dataClass->area_name = $row->area_name;
            $dataClass->e_id = $row->e_id;
            $dataClass->concentration_value = $row->concentration_value;
            $dataClass->timestamp = $row->timestamp;
            $dataClass->e_name = $row->e_name;
            $dataClass->e_symbol = $row->e_symbol;

            array_push($array_holder, $dataClass);
        }

        return $array_holder;
    }
    private function GenerateMap($area_name){
        $hour_value = date("H");
        $constants = new Constants();
        $area_generate = new Area();
        $area_generate->name = $area_name;

        $array_data = $this->setDates($hour_value);
        $result = $this->map_model->get_values($array_data[0], $array_data[1], $area_name);
        $area_generate->AllDayValues_array = $this->classifyData($result);

        for($i = 0; $i < count($area_generate->AllDayValues_array); $i++)
        {
            switch($area_generate->AllDayValues_array[$i]->e_id)
            {
                case 1: // CO
                    array_push($area_generate->co_values, $area_generate->AllDayValues_array[$i]);
                    break;

                case 2: // SO2
                    array_push($area_generate->so2_values, $area_generate->AllDayValues_array[$i]);
                    break;

                case 3: // NO2
                    array_push($area_generate->no2_values, $area_generate->AllDayValues_array[$i]);
                    break;

                case 4: // O3
                    array_push($area_generate->o3_values, $area_generate->AllDayValues_array[$i]);
                    break;

                case 5: // PM 10
                    array_push($area_generate->pm10_values, $area_generate->AllDayValues_array[$i]);
                    break;

                case 6: // TSP
                    array_push($area_generate->tsp_values, $area_generate->AllDayValues_array[$i]);
                    break;
            }
        }

        // --------- EXCRETE VALUES FROM CARBON MONOXIDE --------- //
        $data_container = $constants->EightHrAveraging($area_generate->co_values, $hour_value, $constants->co_guideline_values, $constants->aqi_values, 1);

        $area_generate->co_aqi_values = $data_container[0];
        $area_generate->co_actual_values = $data_container[1];

        if($data_container[2] != "") {
            $area_generate->date_gathered = $data_container[2];
        }

        // --------- EXCRETE VALUES FROM SULFUR DIOXIDE --------- //
        $data_container = $constants->TwentyFourHrAveraging($area_generate->so2_values, $hour_value, $constants->sufur_guideline_values, $constants->aqi_values, 3);

        $area_generate->so2_aqi_values = $data_container[0];
        $area_generate->so2_actual_values = $data_container[1];
        if($data_container[2] != "") {
            $area_generate->date_gathered = $data_container[2];
        }

        // --------- EXCRETE VALUES FROM NITROGEN DIOXIDE --------- //

        $data_container = $constants->OneHrAveraging($area_generate->no2_values, $hour_value, $constants->no2_guideline_values, $constants->aqi_values, 2);

        $area_generate->no2_aqi_values = $data_container[0];
        $area_generate->no2_actual_values = $data_container[1];
        if($data_container[2] != "") {
            $area_generate->date_gathered = $data_container[2];
        }

        // --------- EXCRETE VALUES FROM O3 --------- //

        $data_container = $constants->EightHrAveraging($area_generate->o3_values, $hour_value, $constants->ozone_guideline_values_8, $constants->aqi_values, 3);

        $area_generate->o3_aqi_values = $data_container[0];
        $area_generate->o3_actual_values = $data_container[1];

        if($data_container[2] != "") {
            $area_generate->date_gathered = $data_container[2];
        }

        // --------- EXCRETE VALUES FROM PM 10 --------- //

        $data_container = $constants->TwentyFourHrAveraging($area_generate->pm10_values, $hour_value, $constants->pm_10_guideline_values, $constants->aqi_values, 0);

        $area_generate->pm10_aqi_values = $data_container[0];
        $area_generate->pm10_actual_values = $data_container[1];
        if($data_container[2] != "") {
            $area_generate->date_gathered = $data_container[2];
        }

        // --------- EXCRETE VALUES FROM TSP --------- // REMEMBER TO COMMENT AQI > 400 IN TSP!!

        $data_container = $constants->TwentyFourHrAveraging($area_generate->tsp_values, $hour_value, $constants->tsp_guideline_values, $constants->aqi_values, 0);

        $area_generate->tsp_aqi_values = $data_container[0];
        $area_generate->tsp_actual_values = $data_container[1];
        if($data_container[2] != "") {
            $area_generate->date_gathered = $data_container[2];
        }

        // --------- TO SUPPORT VALIDATIONS IN CAQMS-API.JS --------- //

        $area_generate->co_max = max($area_generate->co_aqi_values);
        $area_generate->so2_max = max($area_generate->so2_aqi_values);
        $area_generate->no2_max = max($area_generate->no2_aqi_values);
        $area_generate->o3_max = max($area_generate->o3_aqi_values);
        $area_generate->pm10_max = max($area_generate->pm10_aqi_values);
        $area_generate->tsp_max = max($area_generate->tsp_aqi_values);

        // --------- GET MIN AND MAX VALUES OF EACH POLLUTANT --------- //

        //$min_max_values = array();

        array_push($area_generate->min_max_values, $constants->MinMax($area_generate->co_aqi_values));
        array_push($area_generate->min_max_values, $constants->MinMax($area_generate->so2_aqi_values));
        array_push($area_generate->min_max_values, $constants->MinMax($area_generate->no2_aqi_values));
        array_push($area_generate->min_max_values, $constants->MinMax($area_generate->o3_aqi_values));
        array_push($area_generate->min_max_values, $constants->MinMax($area_generate->pm10_aqi_values));
        array_push($area_generate->min_max_values, $constants->MinMax($area_generate->tsp_aqi_values));

        // --------- SET DEFAULT VALUE IF NO DATA IN DB --------- //

        //$aqi_values = array();

        array_push($area_generate->aqi_values, $constants->AQIValues($area_generate->co_max, $hour_value, $area_generate->co_aqi_values));
        array_push($area_generate->aqi_values, $constants->AQIValues($area_generate->so2_max, $hour_value, $area_generate->so2_aqi_values));
        array_push($area_generate->aqi_values, $constants->AQIValues($area_generate->no2_max, $hour_value, $area_generate->no2_aqi_values));
        array_push($area_generate->aqi_values, $constants->AQIValues($area_generate->o3_max, $hour_value, $area_generate->o3_aqi_values));
        array_push($area_generate->aqi_values, $constants->AQIValues($area_generate->pm10_max, $hour_value, $area_generate->pm10_aqi_values));
        array_push($area_generate->aqi_values, $constants->AQIValues($area_generate->tsp_max, $hour_value, $area_generate->tsp_aqi_values));

        // --------- DETERMINE POllUTANT WITH HIGHEST AQI --------- //

        if(count($area_generate->aqi_values) > 0 )
        {
            $area_generate->prevalentIndex = array_keys($area_generate->aqi_values, max($area_generate->aqi_values));
        }

        else {
            $area_generate->prevalentIndex = "0";
        }

        return $area_generate;
    }
}
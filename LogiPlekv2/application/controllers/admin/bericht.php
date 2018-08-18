<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Jeroen Hoegen
 * Date: 3-5-2018
 * Time: 10:43
 */
class Bericht extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('bericht_model');
    }

    public function index()
    {
        $data = $this->user_data();

        $data['js'] = array(
            'logiplek/bericht/index',
        );

        $data['title'] = 'Berichten';
        $data['root'] = 'Bericht';
        $data['main_content'] = 'admin/bericht/index';

        $this->load->view('admin/includes/template', $data);
    }


    public function get_berichten()
    {
        $berichten = $this->bericht_model->get_berichten();
        echo json_encode($berichten);
    }

    public function get_contacten()
    {
        $contacten = $this->bericht_model->get_contacten();

        foreach ($contacten as $key => $value)
        {
            $aantal_ongelezen = $this->bericht_model->get_ongelezen_berichten_aantal($value['contact']);
            $contacten[$key]['aantal_ongelezen'] = $aantal_ongelezen['aantal'];
        }

        echo json_encode($contacten);
    }

    public function verstuur_bericht()
    {
        $bericht = $this->bericht_model->verstuur_bericht();
        echo json_encode($bericht);
    }

    public function refreshCheck()
    {
        echo json_encode($this->bericht_model->refreshCheck());
    }

    public function contactSearch()
    {
        $contacten = $this->bericht_model->contactSearch();
        echo json_encode($contacten);
    }

    public function get_ongelezen()
    {
        $berichten = $this->bericht_model->get_ongelezen_berichten();
        echo json_encode($berichten);
    }
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Zoek extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('autos_model');
        $this->load->model('cms_model');
        $this->load->model('koeriers_model');
        $this->load->model('personeel_model');
        $this->load->model('routes_model');
        $this->load->model('steunpunten_model');
        $this->load->model('emballage_model');
    }

    public function index()
    {
        $data = $this->user_data();
        $data['query'] = $this->input->post('query');
        $data['autos'] = $this->autos_model->get_autos(FALSE, $data['query']);
        $data['koeriers'] = $this->koeriers_model->get_koeriers(FALSE, $data['query']);
        $data['personeel'] = $this->personeel_model->get_personeel(FALSE, $data['query']);
        $data['personeel_telefoon'] = $this->get_telefoon_personeel($this->personeel_model->get_personeel_telefoonnummers());
        $data['routes'] = $this->routes_model->get_routes(FALSE, $data['query']);
        $data['steunpunten'] = $this->steunpunten_model->get_steunpunten(FALSE, $data['query']);
        $data['emballage'] = $this->emballage_model->get_emballage(FALSE, $data['query']);
        $data['emballage_mee'] = $this->emballage_model->get_emballageMee();
        $data['emballage_retour'] = $this->emballage_model->get_emballageRetour();
        $data['emballage_emballagemee'] = $this->emballage_model->get_emballage_emballageMee();
        $data['emballage_emballageretour'] = $this->emballage_model->get_emballage_emballageRetour();
        $data['steunpunten_telefoon'] = $this->get_telefoon_steunpunten($this->steunpunten_model->get_steunpunten_telefoonnummers());
        $data['steunpunt_assortiment'] = $this->steunpunten_model->get_steunpunten_assortiment();
        $data['assortimenten'] = $this->cms_model->get_assortimenten();

        $data['hits'] = count($data['autos']) + count($data['koeriers']) + count($data['personeel']) + count($data['routes']) + count($data['steunpunten']) + count($data['emballage']);
        foreach ($data['steunpunt_assortiment'] as $s) {
            $data['steunpunt_assortiment'][$s['steunpunt_id']][$s['assortiment_id']] = true;
        }
        $data['js'] = array(
            'DataTable/media/js/jquery.dataTables.min',
            'logiplek/datatables',
            'logiplek/zoek/index',
        );
        $data['title'] = 'Zoekresultaten';
        $data['root'] = 'zoekresultaten';
        $data['main_content'] = 'admin/zoek/index';

        $this->load->view('admin/includes/template', $data);
    }

    public function get_telefoon_personeel($a)
    {
        $t = array();
        foreach ($a as $tel) {
            if (!isset($t[$tel['personeel_id']]['vast'])) {
                $t[$tel['personeel_id']]['vast'] = '';
            }
            if (!isset($t[$tel['personeel_id']]['mobiel'])) {
                $t[$tel['personeel_id']]['mobiel'] = '';
            }

            if ($tel['telefoon_type'] === 'Vast') {
                $t[$tel['personeel_id']]['vast'] = $tel['nummer'];
            } else if ($tel['telefoon_type'] === 'Mobiel') {
                $t[$tel['personeel_id']]['mobiel'] = $tel['nummer'];
            }
        }
        return $t;
    }

    public function get_telefoon_steunpunten($a)
    {
        $t = array();
        foreach ($a as $tel) {
            if (!isset($t[$tel['steunpunt_id']]['vast'])) {
                $t[$tel['steunpunt_id']]['vast'] = '';
            }
            if (!isset($t[$tel['steunpunt_id']]['mobiel'])) {
                $t[$tel['steunpunt_id']]['mobiel'] = '';
            }
            if ($tel['telefoon_type'] === 'Vast') {
                $t[$tel['steunpunt_id']]['vast'] = $tel['nummer'];
            } else if ($tel['telefoon_type'] === 'Mobiel') {
                $t[$tel['steunpunt_id']]['mobiel'] = $tel['nummer'];
            }
        }
        return $t;
    }
}
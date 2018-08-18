<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Brandstof extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('autos_model');
        $this->load->model('brandstof_model');
        $this->load->model('personeel_model');
    }

    public function index()
    {
        $data = $this->user_data();

        /* MESSAGES */
        if (($this->session->flashdata('toegevoegd'))) {
            $data['toegevoegd'] = true;
        }
        if (($this->session->flashdata('aangepast'))) {
            $data['aangepast'] = true;
        }
        if (($this->session->flashdata('verwijderd'))) {
            $data['verwijderd'] = true;
        }
        if (($this->session->flashdata('niet_gevonden'))) {
            $data['niet_gevonden'] = true;
        }

        $data['js'] = array(
            'DataTable/media/js/jquery.dataTables.min',
            'bootstrap-datepicker.min',
            'logiplek/datatables',
            'logiplek/brandstof/index1',
        );

        $data['autos'] = $this->autos_model->get_autos();
        $data['dagrapporten'] = $this->brandstof_model->get_dagrapport();
        $data['title'] = 'Brandstof';
        $data['root'] = 'Brandstof';
        $data['main_content'] = 'admin/brandstof/index';

        $this->load->view('admin/includes/template', $data);
    }

    public function autooverzicht()
    {
        $start = $this->input->post('start');
        $eind = $this->input->post('eind');
        $autonummer = $this->input->post('autonummer');

        $dagrapporten = $this->brandstof_model->get_dagrapport(FALSE, mysql_date($start), mysql_date($eind), $autonummer);
        if (empty($dagrapporten)) {
            $this->session->set_flashdata('niet_gevonden', true);
            redirect('/brandstof/', 'refresh');
        }

        $data = $this->user_data();

        $aantal_registraties = 0;
        $totaal_verbruik = 0;
        $totaal_km = 0;
        $totaal_diesel = 0;
        $laatste_start = 0;
        foreach ($dagrapporten as $d) {
            if (!empty($d['verbruik'])) {
                $aantal_registraties += 1;
                $totaal_verbruik += $d['verbruik'];
            }

            if (empty($d['eindstand']) && empty($laatste_start)) {
                $laatste_start = $d['beginstand'];
            }

            if (!empty($d['eindstand'])) {
                $totaal_km += $d['eindstand'] - (!empty($laatste_start) ? $laatste_start : $d['beginstand']);
                $laatste_start = 0;
            }

            if (!empty($d['liters'])) {
                $totaal_diesel += $d['liters'];
            }
        }

        $data['autonummer'] = $autonummer;
        $data['start'] = $start;
        $data['eind'] = $eind;
        $data['gemiddelde_verbruik'] = $totaal_verbruik / $aantal_registraties;
        $data['totaal_km'] = $totaal_km;
        $data['totaal_diesel'] = $totaal_diesel;
        $data['title'] = 'Gemiddelde verbruik auto ' . $autonummer;
        $data['root'] = 'Brandstof';
        $data['main_content'] = 'admin/brandstof/autooverzicht';

        $this->load->view('admin/includes/template', $data);
    }

    public function bekijken($id)
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('datum', 'Datum', 'required');
        $this->form_validation->set_rules('autonummer', 'Autonummer', 'required');
        $this->form_validation->set_rules('chauffeur', 'Chauffeur', 'required');
        $this->form_validation->set_rules('beginstand', 'Beginstand', 'required');

        if ($this->form_validation->run() === false) {
            $data = $this->user_data();

            $data['js'] = array(
                'DataTable/media/js/jquery.dataTables.min',
                'DataTable/extensions/KeyTable/js/dataTables.keyTable.min',
                'parsley.min',
                'bootstrap-datepicker.min',
                'logiplek/forms',
            );
            $data['dagrapport'] = $this->brandstof_model->get_dagrapport($id);
            $data['autos'] = $this->autos_model->get_autos();
            $data['personeel'] = $this->personeel_model->get_personeel();
            $data['title'] = 'Brandstof - ' . $id;
            $data['root'] = 'Brandstof';
            $data['main_content'] = 'admin/brandstof/bekijken';

            $this->load->view('admin/includes/template', $data);
        } else {
            $this->brandstof_model->set_dagrapport($id);
            $this->session->set_flashdata('aangepast', true);
            redirect('/brandstof/', 'refresh');
        }
    }

    public function json()
    {
        $dr = array();
        foreach ($this->brandstof_model->get_dagrapport() as $d) {
            $a = array(
                'id' => $d['id'],
                'datum' => nl_date($d['datum']),
                'autonummer' => $d['autonummer'],
                'chauffeur' => $d['chauffeur'],
                'beginstand' => $d['beginstand'],
                'eindstand' => $d['eindstand'],
                'liters' => $d['liters'],
                'verbruik' => $d['verbruik'],
                'koeling' => $d['koeling'],
                'adblue' => $d['adblue']
            );
            $dr[] = $a;
        }
        $data['dagrapporten'] = json_encode($dr);
        $this->output->set_header('Content-type: text/json');
        $this->load->view('admin/brandstof/json', $data);
    }

    public function toevoegen()
    {
        $this->load->library('form_validation');

        $dagrapport = $this->input->post('dagrapport');
        if (!empty($dagrapport)) {
            foreach ($dagrapport as $d => $data) {
                $this->form_validation->set_rules('dagrapport[' . $d . '][autonummer]', 'Autonummer', 'trim');
            }
        }
        if ($this->form_validation->run() === false) {
            $data = $this->user_data();
            $data['js'] = array(
                'DataTable/media/js/jquery.dataTables.min',
                'DataTable/extensions/KeyTable/js/dataTables.keyTable.min',
                'parsley.min',
                'bootstrap-datepicker.min',
                'logiplek/forms',
                'logiplek/brandstof/toevoegen',
            );
            $data['autos'] = $this->autos_model->get_autos();
            $data['personeel'] = $this->personeel_model->get_personeel();
            $data['vrachtwagen'] = $this->personeel_model->get_vrachtwagen($this->session->userdata('id'));
            $data['title'] = 'Brandstof toevoegen';
            $data['root'] = 'Brandstof';
            $data['main_content'] = 'admin/brandstof/toevoegen';

            $this->load->view('admin/includes/template', $data);
        } else {
            $this->brandstof_model->add_dagrapporten();
            $this->session->set_flashdata('toegevoegd', true);

            if ($this->session->userdata('functie_id') == 4 || $this->session->userdata('functie_id') == 3) {
                redirect('/brandstof/', 'refresh');
            } else {
                redirect('/brandstof/toevoegen', 'refresh');
            }
        }
    }

    public function verwijderen($id)
    {
        $this->brandstof_model->delete_invoer($id);
        $this->session->set_flashdata('verwijderd', true);
        redirect('/brandstof/', 'refresh');
    }

    public function weekoverzicht($wj)
    {
        $j = '20' . substr($wj, 2, 3);
        $w = substr($wj, 0, 2);

        $dto = new DateTime();
        $start = $dto->setISODate($j, $w)->format('Y-m-d');
        $eind = $dto->modify('+6 days')->format('Y-m-d');

        $dagrapporten = $this->brandstof_model->get_dagrapport(FALSE, $start, $eind);
        if (empty($dagrapporten)) {
            $this->session->set_flashdata('niet_gevonden', true);
            redirect('/brandstof/', 'refresh');
        }

        $data = $this->user_data();

        $data['bus'] = array(
            'aantal' => 0,
            'kilometers' => 0,
            'liters' => 0,
            'verbruik' => 0,
            'laagste_verbruik' => 0,
            'zuinigste_auto' => '',
            'zuinigste_chauf' => '',
        );

        $data['dingdong'] = array(
            'aantal' => 0,
            'kilometers' => 0,
            'liters' => 0,
            'verbruik' => 0,
            'laagste_verbruik' => 0,
            'zuinigste_auto' => '',
            'zuinigste_chauf' => '',
        );

        $data['vrachtwagen'] = array(
            'aantal' => 0,
            'kilometers' => 0,
            'liters' => 0,
            'verbruik' => 0,
            'laagste_verbruik' => 0,
            'koeling' => 0,
            'adblue' => 0,
            'zuinigste_auto' => '',
            'zuinigste_chauf' => '',
        );

        foreach ($dagrapporten as $d) {

            if (empty($d['eindstand'])) {
                $d['eindstand'] = $d['beginstand'];
            }

            $type = $this->autos_model->get_auto_type($d['autonummer']);
            $type = $type['type'];

            if ($type === 'Bus') {
                $data['bus']['aantal'] += 1;
                $data['bus']['kilometers'] += $d['eindstand'] - $d['beginstand'];
                $data['bus']['liters'] += $d['liters'];
                $data['bus']['verbruik'] += $d['verbruik'];
                if ((isset($d['verbruik'])) && ($d['verbruik'] > $data['bus']['laagste_verbruik'])) {
                    $data['bus']['laagste_verbruik'] = $d['verbruik'];
                    $data['bus']['zuinigste_auto'] = $d['autonummer'];
                    $data['bus']['zuinigste_chauf'] = $d['chauffeur'];
                }
            } else if ($type === 'Ding Dong') {
                $data['dingdong']['aantal'] += 1;
                $data['dingdong']['kilometers'] += $d['eindstand'] - $d['beginstand'];
                $data['dingdong']['liters'] += $d['liters'];
                $data['dingdong']['verbruik'] += $d['verbruik'];
                if ((isset($d['verbruik'])) && ($d['verbruik'] > $data['dingdong']['laagste_verbruik'])) {
                    $data['dingdong']['laagste_verbruik'] = $d['verbruik'];
                    $data['dingdong']['zuinigste_auto'] = $d['autonummer'];
                    $data['dingdong']['zuinigste_chauf'] = $d['chauffeur'];
                }
            } else if ($type === 'Vrachtwagen') {
                $data['vrachtwagen']['aantal'] += 1;
                $data['vrachtwagen']['kilometers'] += $d['eindstand'] - $d['beginstand'];
                $data['vrachtwagen']['liters'] += $d['liters'];
                $data['vrachtwagen']['verbruik'] += $d['verbruik'];
                $data['vrachtwagen']['koeling'] += $d['koeling'];
                $data['vrachtwagen']['adblue'] += $d['adblue'];
                if ((isset($d['verbruik'])) && ($d['verbruik'] > $data['vrachtwagen']['laagste_verbruik'])) {
                    $data['vrachtwagen']['laagste_verbruik'] = $d['verbruik'];
                    $data['vrachtwagen']['zuinigste_auto'] = $d['autonummer'];
                    $data['vrachtwagen']['zuinigste_chauf'] = $d['chauffeur'];
                }
            }
        }

        if ($data['bus']['aantal'] === 0) {
            $data['bus']['aantal'] = 1;
        }
        if ($data['dingdong']['aantal'] === 0) {
            $data['dingdong']['aantal'] = 1;
        }
        if ($data['vrachtwagen']['aantal'] === 0) {
            $data['vrachtwagen']['aantal'] = 1;
        }

        if ($data['bus']['laagste_verbruik'] === 0) {
            $data['bus']['laagste_verbruik'] = '';
        }
        if ($data['dingdong']['laagste_verbruik'] === 0) {
            $data['dingdong']['laagste_verbruik'] = '';
        }
        if ($data['vrachtwagen']['laagste_verbruik'] === 0) {
            $data['vrachtwagen']['laagste_verbruik'] = '';
        }

        $data['week'] = $wj;
        $data['title'] = 'Brandstof weekoverzicht';
        $data['root'] = 'Brandstof';
        $data['main_content'] = 'admin/brandstof/weekoverzicht';

        $this->load->view('admin/includes/template', $data);
    }

    public function wo()
    {
        $w = $this->input->post('weeknr');
        redirect('brandstof/weekoverzicht/' . $w);
    }
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Personeel_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function add_personeel()
    {

        $this->load->library('SimpleLoginSecure');
        $user = $this->session->userdata('voornaam') . ' ' . $this->session->userdata('achternaam');
        $defaultpass = $this->simpleloginsecure->hash_password("Welkom12!@");
        /* PERSONEEL */
        $data = array(
            'voornaam' => $this->input->post('voornaam'),
            'achternaam' => $this->input->post('achternaam'),
            'plaats' => $this->input->post('woonplaats'),
            'locatie_id' => $this->input->post('locatie'),
            'functie_id' => $this->input->post('functie'),
            'status_id' => '1',
            'toegevoegd_op' => date("Y-m-d H:i:s"),
            'toegevoegd_door' => $user,
            'email' => $this->input->post('email'),
            'personeel_pass' => $defaultpass,
        );
        $this->db->insert('personeel', $data);
        $id = $this->db->insert_id();

        /* GEBOORTEDATUM */
        $geboortedatum = $this->input->post('geboortedatum');

        if ($geboortedatum !== '') {
            $this->db->insert('personeel_geboortedatum', array('personeel_id' => $id, 'geboortedatum' => $geboortedatum));
        }

        /* ADRES */
        $straat = $this->input->post('straat');
        $huisnummer = $this->input->post('huisnummer');
        $postcode = $this->input->post('postcode');

        if (($straat !== '') || ($huisnummer !== '') || ($postcode !== '')) {
            $data = array(
                'straat' => $straat,
                'huisnummer' => $huisnummer,
                'postcode' => $postcode,
                'personeel_id' => $id,
            );
            $this->db->insert('personeel_adres', $data);
        }

        /* CONTACT */
        $mobiel = $this->input->post('mobiel');
        $this->db->insert('personeel_telefoon', array('personeel_id' => $id, 'nummer' => $mobiel, 'telefoon_type' => 'Mobiel'));

        $telefoon = $this->input->post('telefoonnummer');
        if ($telefoon !== '') {
            $this->db->insert('personeel_telefoon', array('personeel_id' => $id, 'nummer' => $telefoon, 'telefoon_type' => 'Vast'));
        }
    }

    public function delete_personeel($id)
    {
        $this->db->update('personeel', array('status_id' => 2), array('id' => $id));
    }

    public function get_personeel($id = FALSE, $q = FALSE, $h = FALSE)
    {
        $this->db->select('*');
        $this->db->from('personeel');
        $this->db->join('personeel_adres', 'personeel_adres.personeel_id = personeel.id', 'left outer');
        $this->db->join('personeel_functies', 'personeel_functies.functie_id = personeel.functie_id', 'left outer');
        $this->db->join('personeel_geboortedatum', 'personeel_geboortedatum.personeel_id = personeel.id', 'left outer');
        $this->db->order_by('voornaam', 'asc');

        if ($id === FALSE) {
            if ($h !== FALSE) {
                $this->db->where('status_id', 2);
            } else {
                $this->db->where('status_id', 1);
            }

            if ($q !== FALSE) {
                $this->db->where('(voornaam LIKE \'%' . $q . '%\' OR achternaam LIKE \'%' . $q . '%\' OR voornaam + \' \' + achternaam LIKE \'%' . $q . '%\' OR plaats LIKE \'%' . $q . '%\')');
                // $this->db->like('voornaam', $q);
                // $this->db->or_like('achternaam', $q);
                // $this->db->or_like('CONCAT(voornaam,\' \',achternaam)', $q);
                // $this->db->or_like('plaats', $q);
            }

            $query = $this->db->get();
            return $query->result_array();
        }

        $this->db->where('personeel.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_personeel_telefoonnummers($id = FALSE)
    {
        $this->db->select('*');
        $this->db->from('personeel_telefoon');

        if ($id === FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        }

        $this->db->where('personeel_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function set_personeel($id)
    {
        /* PERSONEEL */
        $data = array(
            'voornaam' => $this->input->post('voornaam'),
            'achternaam' => $this->input->post('achternaam'),
            'plaats' => $this->input->post('woonplaats'),
            'locatie_id' => $this->input->post('locatie'),
            'functie_id' => $this->input->post('functie'),
        );
        $this->db->where('id', $id);
        $this->db->update('personeel', $data);

        /* GEBOORTEDATUM */
        $geboortedatum = $this->input->post('geboortedatum');

        $query = $this->db->get_where('personeel_geboortedatum', array('personeel_id' => $id));
        $count = $query->num_rows();

        if ($geboortedatum !== '') {
            if ($count === 0) {
                $this->db->insert('personeel_geboortedatum', array('personeel_id' => $id, 'geboortedatum' => $geboortedatum));
            } else {
                $this->db->update('personeel_geboortedatum', array('geboortedatum' => $geboortedatum), array('personeel_id' => $id));
            }
        } else if ($count === 1) {
            $this->db->delete('personeel_geboortedatum', array('personeel_id' => $id));
        }

        /* ADRES */
        $straat = $this->input->post('straat');
        $huisnummer = $this->input->post('huisnummer');
        $postcode = $this->input->post('postcode');

        $query = $this->db->get_where('personeel_adres', array('personeel_id' => $id));
        $count = $query->num_rows();

        if (($straat !== '') || ($huisnummer !== '') || ($postcode !== '')) {
            $data = array(
                'straat' => $straat,
                'huisnummer' => $huisnummer,
                'postcode' => $postcode,
                'personeel_id' => $id,
            );
            if ($count === 0) {
                $this->db->insert('personeel_adres', $data);
            } else {
                $this->db->update('personeel_adres', $data, array('personeel_id' => $id));
            }
        } else if ($count === 1) {
            $this->db->delete('personeel_adres', array('personeel_id' => $id));
        }

        /* CONTACT */
        $mobiel = $this->input->post('mobiel');
        $this->db->update('personeel_telefoon', array('nummer' => $mobiel), array('personeel_id' => $id, 'telefoon_type' => 'Mobiel'));

        $telefoon = $this->input->post('telefoonnummer');
        $query = $this->db->get_where('personeel_telefoon', array('personeel_id' => $id, 'telefoon_type' => 'Vast'));
        $count = $query->num_rows();

        if ($telefoon !== '') {
            if ($count === 0) {
                $this->db->insert('personeel_telefoon', array('personeel_id' => $id, 'nummer' => $telefoon, 'telefoon_type' => 'Vast'));
            } else {
                $this->db->update('personeel_telefoon', array('nummer' => $telefoon), array('personeel_id' => $id, 'telefoon_type' => 'Vast'));
            }
        } else if ($count === 1) {
            $this->db->delete('personeel_telefoon', array('personeel_id' => $id, 'telefoon_type' => 'Vast'));
        }

        $email = $this->input->post('email');
        $query = $this->db->get_where('personeel', array('id' => $id));
        $count = $query->num_rows();

        if ($email !== '') {
            if ($count === 0) {
                $this->db->insert('personeel', array('id' => $id, 'email' => $email));
            } else {
                $this->db->update('personeel', array('email' => $email), array('id' => $id));
            }
        } else if ($count === 1) {
            $this->db->delete('personeel', array('id' => $id));
        }
    }

    public function reset_personeel($id)
    {
        $this->db->update('personeel', array('status_id' => 1), array('id' => $id));
    }

    public function get_vrachtwagen($id)
    {
        $this->db->select('*');
        $this->db->from('personeel_auto');
        $this->db->where('personeel_id', $id);
        $this->db->join('autos', 'personeel_auto.auto_id = autos.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function set_vrachtwagen($id)
    {
        $this->db->select('id');
        $this->db->from('autos');
        $this->db->where('kenteken', $this->input->post('kenteken'));
        $query = $this->db->get();
        $result = $query->row();

        $this->db->update('personeel_auto', array('auto_id' => $result->id), array('personeel_id' => $id));
    }
}

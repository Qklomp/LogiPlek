<?php
/**
 * Created by PhpStorm.
 * User: Jeroen Hoegen
 * Date: 4-5-2018
 * Time: 11:56
 */

class emballage_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }


    public function toevoegen_emballage()
    {
        $user = $this->session->userdata('voornaam') . ' ' . $this->session->userdata('achternaam');
        $emballageMeeArray = $this->arrayConv($this->get_emballageMee());
        $emballageRetourArray = $this->arrayConv($this->get_emballageRetour());

        $originalDate = $this->input->post('Toegevoegd_op');
        $newDate = date("Y-m-d", strtotime($originalDate));

        /* Emballage*/
        $data = array(
            'klantnummer' => $this->input->post('Klantnummer'),
            'vrachtwagen' => $this->input->post('Vrachtwagen'),
            'toegevoegd_door' => $user,
            'toegevoegd_op' => $newDate
        );

        $this->db->insert('emballage', $data);
        $id = $this->db->insert_id();

        foreach ($this->input->post(null, true) as $key => $value) {
            if ($value != '0' && ($key != 'Vrachtwagen' && $key != 'Klantnummer')) {
                $dbKey = explode("_", $key);
                if ($dbKey[1] === "mee") {
                    $data = array(
                        'emballage_id' => $id,
                        'emballagemee_id' => $emballageMeeArray[$dbKey[0]],
                        'aantal' => $value
                    );
                    $this->db->insert('emballage_emballagemee', $data);
                } else if ($dbKey[1] === "retour") {
                    $data = array(
                        'emballage_id' => $id,
                        'emballageretour_id' => $emballageRetourArray[$dbKey[0]],
                        'aantal' => $value
                    );
                    $this->db->insert('emballage_emballageretour', $data);
                } else {

                }
            }
        }
    }

    public function bewerk_emballage($id)
    {
        $user = $this->session->userdata('voornaam') . ' ' . $this->session->userdata('achternaam');
        $emballageMeeArray = $this->arrayConv($this->get_emballageMee());
        $emballageRetourArray = $this->arrayConv($this->get_emballageRetour());

        $originalDate = $this->input->post('Toegevoegd_op');
        $newDate = date("Y-m-d", strtotime($originalDate));

        /* Emballage */
        $data = array(
            'klantnummer' => $this->input->post('Klantnummer'),
            'vrachtwagen' => $this->input->post('Vrachtwagen'),
            'toegevoegd_door' => $user,
            'toegevoegd_op' => $newDate
        );

        $this->db->where('id', $id);
        $this->db->update('emballage', $data);

        $this->db->where('emballage_id', $id);
        $this->db->delete('emballage_emballagemee');
        $this->db->where('emballage_id', $id);
        $this->db->delete('emballage_emballageretour');

        foreach ($this->input->post(null, true) as $key => $value) {
            if ($value != '0' && ($key != 'Vrachtwagen' && $key != 'Klantnummer')) {
                $dbKey = explode("_", $key);

                if ($dbKey[1] === "mee") {
                    $data = array(
                        'emballage_id' => $id,
                        'emballagemee_id' => $emballageMeeArray[$dbKey[0]],
                        'aantal' => $value
                    );

                    $this->db->where('emballage_id', $id);
                    $this->db->insert('emballage_emballagemee', $data);
                } else if ($dbKey[1] === "retour") {
                    $data = array(
                        'emballage_id' => $id,
                        'emballageretour_id' => $emballageRetourArray[$dbKey[0]],
                        'aantal' => $value
                    );

                    $this->db->where('emballage_id', $id);
                    $this->db->insert('emballage_emballageretour', $data);
                }
            }
        }
    }

    public function delete_emballage($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('emballage');
    }


    public function get_emballageMee($id = FALSE)
    {
        $this->db->select('*');
        $this->db->from('emballage_mee');

        if ($id === FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        }
        $this->db->where('emballage_id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_emballageRetour($id = FALSE)
    {
        $this->db->select('*');
        $this->db->from('emballage_retour');
        if ($id === FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        }
        $this->db->where('emballage_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_emballage_emballageMee($id = FALSE)
    {
        $this->db->select('*');
        $this->db->from('emballage_emballagemee');
        if ($id === FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        }
        $this->db->where('emballage_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_emballage_emballageRetour($id = FALSE)
    {
        $this->db->select('*');
        $this->db->from('emballage_emballageretour');
        if ($id === FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        }
        $this->db->where('emballage_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function arrayConv($old)
    {
        $newArray = array();
        foreach ($old as $key => $value) {
            $newKey = str_replace(' ', '', $value['emballage']);
            $newArray[$newKey] = $value['id'];
        }
        return $newArray;
    }

    public function get_emballage($id = FALSE, $q = FALSE)
    {

        $this->db->select('*');
        $this->db->from('emballage');
        if ($q !== FALSE)
        {
            $this->db->like('toegevoegd_door', $q);
            $this->db->or_like('vrachtwagen', $q);
            $this->db->or_like('klantnummer', $q);
        }
        if ($id === FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        }
        $this->db->where('emballage.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function set_emballage_soorten_mee(){
        $a = $this->input->post('emballage');
        for ($i = 0; $i < count($a['emballage']); $i++)
        {
            if(isset($a['id'][$i]))
            {
                if($a['emballage'][$i] !== '')
                {
                    $this->db->update('emballage_mee', array('emballage' => ucfirst($a['emballage'][$i])), array('id' => $a['id'][$i]));
                }
                else
                {
                    $this->db->where('id', $a['id'][$i]);
                    $this->db->delete('emballage_mee');
                }
            }
            else if($a['emballage'][$i] !== '')
            {
                $this->db->insert('emballage_mee', array('emballage' => ucfirst($a['emballage'][$i])));
            }
        }
    }

    public function set_emballage_soorten_retour(){
        $a = $this->input->post('emballage');
        for ($i = 0; $i < count($a['emballage']); $i++)
        {
            if(isset($a['id'][$i]))
            {
                if($a['emballage'][$i] !== '')
                {
                    $this->db->update('emballage_retour', array('emballage' => ucfirst($a['emballage'][$i])), array('id' => $a['id'][$i]));
                }
                else
                {
                    $this->db->where('id', $a['id'][$i]);
                    $this->db->delete('emballage_retour');
                }
            }
            else if($a['emballage'][$i] !== '')
            {
                $this->db->insert('emballage_retour', array('emballage' => ucfirst($a['emballage'][$i])));
            }
        }
    }

    public function delete_emballage_soorten_retour($id){
        $this->db->where('id', $id);
        $this->db->delete('emballage_retour');
    }
    public function delete_emballage_soorten_mee($id){
        $this->db->where('id', $id);
        $this->db->delete('emballage_mee');
    }



}
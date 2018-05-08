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


    public function toevoegen_emballage(){

        $user = $this->session->userdata('voornaam') . ' ' . $this->session->userdata('achternaam');
        $emballageMeeArray = $this->arrayConv($this->get_emballageMee());
        $emballageRetourArray = $this->arrayConv($this->get_emballageRetour());

        /* Emballage*/
        $data = array(
            'klantnummer' => $this->input->post('Klantnummer'),
            'vrachtwagen' => $this->input->post('Vrachtwagen'),
            'toegevoegd_door' => $user
        );
        $this->db->insert('emballage', $data);
        $id = $this->db->insert_id();

        foreach($this->input->post(null, true) as $key => $value)
        {
            if($value != '0' && ($key != 'Vrachtwagen' && $key != 'Klantnummer'))
            {
                $dbKey = explode("_", $key);
                if($dbKey[1] === "Mee"){
                    $data = array(
                        'emballage_id' => $id,
                        'emballagemee_id' => $emballageMeeArray[$dbKey[0]],
                        'aantal' => $value
                    );
                    $this->db->insert('emballage_emballagemee', $data);
                }else if($dbKey[1] === "Retour"){
                    $data = array(
                        'emballage_id' => $id,
                        'emballageretour_id' => $emballageRetourArray[$dbKey[0]],
                        'aantal' => $value
                    );
                    $this->db->insert('emballage_emballageretour', $data);
                }else{
                    echo 'HET IS RKAPOT EN IEDEREEN GAAT DOOD!!!!!!!!!!!q111';
                }

            }
        }

    }

    public function get_emballageMee(){
        $this->db->select('*');
        $this->db->from('emballage_mee');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_emballageRetour(){
        $this->db->select('*');
        $this->db->from('emballage_retour');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_emballage_emballageMee(){
        $this->db->select('*');
        $this->db->from('emballage_emballagemee');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_emballage_emballageRetour(){
        $this->db->select('*');
        $this->db->from('emballage_emballageretour');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function arrayConv($old)
    {
        $newArray = array();
        foreach($old as $key => $value)
        {
            $newKey = str_replace(' ', '', $value['emballage']);
            $newArray[$newKey] = $value['id'];
        }
        return $newArray;
    }

    public function get_emballage(){

        $this->db->select('*');
        $this->db->from('emballage');

        $query = $this->db->get();
        return $query->result_array();
    }

}
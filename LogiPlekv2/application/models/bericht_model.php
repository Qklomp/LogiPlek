<?php
/**
 * Created by PhpStorm.
 * User: Jeroen Hoegen
 * Date: 14-5-2018
 * Time: 10:39
 */

class bericht_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_contacten($id)
    {
        $this->db->select('afzender, voornaam, achternaam');
        $this->db->from('bericht');
        $this->db->where('ontvanger', $id);
        $this->db->join('personeel', 'bericht.afzender = personeel.id');
        $this->db->distinct();
        $query = $this->db->get();
        $array1 = $query->result_array();
        $this->db->select('ontvanger, voornaam, achternaam');
        $this->db->from('bericht');
        $this->db->where('afzender', $id);
        $this->db->join('personeel', 'bericht.ontvanger = personeel.id');
        $this->db->distinct();
        $query = $this->db->get();
        $array2 = $query->result_array();
        $array_comb = array();
        foreach (array_merge($array1, $array2) as $key => $value) {
            if (key_exists('afzender', $value)) {
                $array_comb[$value['afzender']] = $value['voornaam'] . ' ' . $value['achternaam'];
            } else {
                $array_comb[$value['ontvanger']] = $value['voornaam'] . ' ' . $value['achternaam'];
            }
        }
        return $array_comb;
    }

    public function get_berichten($id){
        $this->db->select('afzender, tekst');
        $this->db->from('bericht');
        $this->db->where('ontvanger', $id);
        $this->db->join('bericht_tekst', 'bericht.inhoud = bericht_tekst.id');
        $query = $this->db->get();
        $array1 = $query->result_array();
        $this->db->select('ontvanger, tekst');
        $this->db->from('bericht');
        $this->db->where('afzender', $id);
        $this->db->join('bericht_tekst', 'bericht.inhoud = bericht_tekst.id');
        $query = $this->db->get();
        $array2 = $query->result_array();

        $array_comb = array_merge($array1, $array2);

        return $array_comb;
    }
}
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

    public function get_berichten($id, $contactId){
        $this->db->select('afzender, tekst, verstuurd_op');
        $this->db->from('bericht');
        $this->db->where('ontvanger', $id);
        $this->db->where('afzender', $contactId);
        $this->db->join('bericht_tekst', 'bericht.inhoud = bericht_tekst.id');
        $query = $this->db->get();
        $array1 = $query->result_array();

        $this->db->select('ontvanger, tekst, verstuurd_op');
        $this->db->from('bericht');
        $this->db->where('afzender', $id);
        $this->db->where('ontvanger', $contactId);
        $this->db->join('bericht_tekst', 'bericht.inhoud = bericht_tekst.id');
        $query = $this->db->get();
        $array2 = $query->result_array();

        $array_comb = array_merge($array1, $array2);

        function sortFunction( $a, $b ) {
            return strtotime($a["verstuurd_op"]) - strtotime($b["verstuurd_op"]);
        }
        usort($array_comb, "sortFunction");

        /*- bericht refresh tabel updaten -*/

        $this->db->set('status', '0');
        $this->db->where('personeel_id', $id);
        $this->db->update('bericht_refresh');

        return $array_comb;
    }

    public function verstuur_bericht()
    {
        $data = array(
            'tekst' => $this->input->post('bericht')
        );
        $this->db->insert('bericht_tekst', $data);
        $id = $this->db->insert_id();

        $data = array(
            'afzender' => $this->session->userdata('id'),
            'ontvanger' => $this->input->post('contactId'),
            'status' => 0,
            'inhoud' => $id,
            'verstuurd_op' => date('Y-m-d H:i:s')
        );
        $this->db->insert('bericht', $data);

        /*- bericht refresh tabel updaten -*/

        $this->db->set('status', '1');
        $this->db->where('personeel_id', $this->input->post('contactId'));
        $this->db->update('bericht_refresh');

        if($this->db->affected_rows() === 0)
        {
            $data = array(
                'personeel_id' => $this->input->post('contactId'),
                'status' => '1'
            );
            $this->db->insert('bericht_refresh', $data);
        }
    }

    public function refreshCheck($id)
    {
        $this->db->select('status');
        $this->db->from('bericht_refresh');
        $this->db->where('personeel_id', $id);

        $query = $this->db->get();
        $result = $query->row_array();

        return $result;
    }

    public function contactSearch($searchValue)
    {
        $this->db->select('id, voornaam, achternaam');
        $this->db->from('personeel');
        $this->db->like('voornaam', $searchValue, 'both');
        $this->db->or_like('achternaam', $searchValue, 'both');
        $this->db->limit(10);

        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }
}
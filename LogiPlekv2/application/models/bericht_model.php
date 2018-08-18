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

    public function get_contacten()
    {
        $this->db->select('afzender as contact, voornaam, achternaam, verstuurd_op');
        $this->db->from('(SELECT * FROM bericht ORDER BY verstuurd_op DESC LIMIT 18446744073709551615) as contacten');
        $this->db->where('ontvanger', $this->session->userdata('id'));
        $this->db->where('status_id', '1');
        $this->db->join('personeel', 'contacten.afzender = personeel.id');
        $this->db->group_by('afzender');
        $this->db->order_by('verstuurd_op DESC');
        $query = $this->db->get();
        $array1 = $query->result_array();

        $this->db->select('ontvanger as contact, voornaam, achternaam, verstuurd_op');
        $this->db->from('(SELECT * FROM bericht ORDER BY verstuurd_op DESC LIMIT 18446744073709551615) as contacten');
        $this->db->where('afzender', $this->session->userdata('id'));
        $this->db->where('status_id', '1');
        $this->db->join('personeel', 'contacten.ontvanger = personeel.id');
        $this->db->group_by('ontvanger');
        $this->db->order_by('verstuurd_op DESC');
        $query = $this->db->get();
        $array2 = $query->result_array();

        $array_comb = array();

        foreach (array_merge($array1, $array2) as $key => $value) {
            if(key_exists($value['contact'], $array_comb))
            {
                if($array_comb[$value['contact']]['verstuurd_op'] < $value['verstuurd_op']){
                    $array_comb[$value['contact']] = $value;
                }
            }
            else
                $array_comb[$value['contact']] = $value;
        }

        usort($array_comb, array($this, 'sortFunctionDESC'));

        return $array_comb;
    }

    function sortFunctionASC($a, $b)
    {
        return strtotime($a["verstuurd_op"]) - strtotime($b["verstuurd_op"]);
    }

    function sortFunctionDESC($a, $b)
    {
        return strtotime($b["verstuurd_op"]) - strtotime($a["verstuurd_op"]);
    }

    public function get_berichten()
    {
        $this->db->select('afzender, tekst, verstuurd_op, status');
        $this->db->from('bericht');
        $this->db->where('ontvanger', $this->session->userdata('id'));
        $this->db->where('afzender', $this->input->post('contactId'));
        $this->db->join('bericht_tekst', 'bericht.inhoud = bericht_tekst.id');
        $query = $this->db->get();
        $array1 = $query->result_array();

        $this->db->select('ontvanger, tekst, verstuurd_op, status');
        $this->db->from('bericht');
        $this->db->where('afzender', $this->session->userdata('id'));
        $this->db->where('ontvanger', $this->input->post('contactId'));
        $this->db->join('bericht_tekst', 'bericht.inhoud = bericht_tekst.id');
        $query = $this->db->get();
        $array2 = $query->result_array();

        $array_comb = array_merge($array1, $array2);

        usort($array_comb, array($this, 'sortFunctionASC'));

        /*- berichten op gelezen zetten -*/

        $this->set_berichten_gelezen($this->session->userdata('id'));

        /*- bericht refresh tabel updaten -*/

        $this->refresh_table_update($this->session->userdata('id'), 0);

        return $array_comb;
    }

    public function set_berichten_gelezen($id)
    {
        $this->db->set('status', '1');
        $this->db->set('gelezen_op', date('Y-m-d H:i:s'));
        $this->db->where('status', '0');
        $this->db->where('ontvanger', $id);
        $this->db->update('bericht');
    }

    public function refresh_table_update($id, $status)
    {
        $this->db->select('status');
        $this->db->from('bericht_refresh');
        $this->db->where('personeel_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $this->db->set('status', $status);
            $this->db->where('personeel_id', $id);
            $this->db->update('bericht_refresh');
        } else {
            $data = array(
                'personeel_id' => $id,
                'status' => $status
            );
            $this->db->insert('bericht_refresh', $data);
        }
    }

    public function get_ongelezen_berichten_aantal($contactId = null)
    {
        $this->db->select('count(id) as aantal');
        $this->db->from('bericht');
        $this->db->where('ontvanger', $this->session->userdata('id'));

        if($contactId !== null)
            $this->db->Where('afzender', $contactId);

        $this->db->where('status', '0');
        $query = $this->db->get();

        return $query->row_array();
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

        $this->refresh_table_update($this->input->post('contactId'), 1);

        return array(
            array(
                'ontvanger' => $this->session->userdata('id'),
                'status' => 0,
                'tekst' => $this->input->post('bericht'),
                'verstuurd_op' => date('Y-m-d H:i:s')
            )
        );
    }

    public function refreshCheck()
    {
        $this->db->select('status');
        $this->db->from('bericht_refresh');
        $this->db->where('personeel_id', $this->session->userdata('id'));

        $query = $this->db->get();
        $result = $query->row_array();

        return $result;
    }

    public function get_ongelezen_berichten()
    {
        $this->db->select('afzender, tekst, verstuurd_op, status');
        $this->db->from('bericht');
        $this->db->where('ontvanger', $this->session->userdata('id'));
        $this->db->where('afzender', $this->input->post('contactId'));
        $this->db->where('status', '0');
        $this->db->join('bericht_tekst', 'bericht.inhoud = bericht_tekst.id');
        $query = $this->db->get();

        $this->set_berichten_gelezen($this->session->userdata('id'));

        $this->refresh_table_update($this->session->userdata('id'), 0);

        return $query->result_array();
    }

    public function contactSearch()
    {
        $this->db->select('id, voornaam, achternaam');
        $this->db->from('personeel');
        $this->db->where("CONCAT(voornaam, ' ', achternaam) LIKE '%" . $this->input->post('searchValue') . "%'", NULL, FALSE);
        $this->db->where('status_id', '1');
        $this->db->where('id !=', $this->session->userdata('id'));
        $this->db->limit(8);

        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }
}
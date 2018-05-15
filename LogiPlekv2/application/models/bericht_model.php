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
        $this->db->select('afzender');
        $this->db->from('bericht');
        $this->db->where('ontvanger', $id);
        $this->db->distinct();
        $query = $this->db->get();

        $array1 = $query->result_array();

        $this->db->select('ontvanger');
        $this->db->from('bericht');
        $this->db->where('afzender', $id);
        $this->db->distinct();
        $query = $this->db->get();

        $array2 = $query->result_array();

        $handle = fopen('D://login.txt', 'a');

        foreach(array_merge($array1, $array2) as $key => $value)
        {
            fwrite($handle, "asdfghjkl;lkjhgfdsasdfghjkl;lkjhgfdsasdf");
            foreach($value as $key1 => $value2)
            {
                fwrite($handle, "mhjfdjfdjfdhgfdsgrtesedxgfdsrtdgfdaaaaa");
                $array_comb['contact'] = $value2;
            }

        }
        fclose($handle);
        return array_unique($array_comb);
    }
}
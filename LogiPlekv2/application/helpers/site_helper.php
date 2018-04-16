<?php
/**
 * Created by PhpStorm.
 * User: Jeroen Hoegen
 * Date: 16-4-2018
 * Time: 10:24
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function asset_url()
{

    return "http://".base_url().'LogiPlekv2/assets/';
}

function nl_date($mysql_date)
{
    list($y,$m,$d) = explode('-', $mysql_date);
    return "$d-$m-$y";
}

function nl_text_date($datetime)
{
    $date = new DateTime($datetime);
    $datum = $date->format('d M Y');
    $tijd = $date->format('H:i');

    $english = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
    $dutch = array('januari','februari','maart','april','mei','juni','juni','augustus','september','oktober','november','december');

    return str_replace($english, $dutch, $datum) . ' om ' . $tijd;
}


function mysql_date($nl_date)
{
    list($d,$m,$y) = explode('-', $nl_date);
    return "$y-$m-$d";
}

function upload_url()
{
    return base_url().'uploads/';
}
?>
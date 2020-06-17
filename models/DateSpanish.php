<?php

namespace app\models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DateSpanish {

    public static function cadena($fecha) {
        $date=new \DateTime($fecha);
        $meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return $date->format('d'). ' de '. $meses[$date->format('n')-1]. ' de '. $date->format('Y');
    }

}

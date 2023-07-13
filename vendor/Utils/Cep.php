<?php 

namespace Utils;

Class Cep{
    
    static public function teste(){
        echo "<p><b>Cep</b>: Consultando 11701-380... </p>";
    }
    
    static public function consulta($cep){
        $cep = str_replace('-','',$cep);
        $url = "https://viacep.com.br/ws/{$cep}/json/";
        $result = \Http::curl($url);
        echo ($result);
    }
    
}

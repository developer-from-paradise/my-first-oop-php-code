<?php

class webSearchAPI {
    static $pagesize = "10";
    static $autocorrect = "false";
    public function get_data(string $str){
        
        $headers = array(
            'X-Rapidapi-Key: ead56fdb28msh19440ae8fb332efp1d73f7jsnef6e8e48f056',
            'X-Rapidapi-Host: contextualwebsearch-websearch-v1.p.rapidapi.com'
        );
        $ch = curl_init("https://contextualwebsearch-websearch-v1.p.rapidapi.com/api/Search/WebSearchAPI?q=".$str."&pageNumber=1&pageSize=".self::$pagesize."&autoCorrect=".self::$autocorrect);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
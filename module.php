<?php

class webSearchAPI {
    static $pagesize = "10";
    static $autocorrect = "false";
    public function useGoogle( string $api, string $str){
        $data = file_get_contents("https://contextualwebsearch-websearch-v1.p.rapidapi.com/api/Search/WebSearchAPI?q={$str}&pageNumber=10&pageSize=".self::$pagesize."&autoCorrect=".self::$autocorrect."&rapidapi-key={$api}");
        return $data;
    }


    public function useChatGPT(string $api, string $prompt){
        $headers = array(
            'Content-Type: application/json',
            "Authorization: Bearer {$api}"
        );
        $data = array(
            "model" => "gpt-3.5-turbo",
            "messages" => array (
                array (
                "role" => "user",
                "content" => "Find information about this: '".$prompt."'"
                ),
            ),
            "max_tokens" => 4000,
            "temperature" => 1.0,
        );

        $payload = json_encode($data);

        $ch = curl_init("https://api.openai.com/v1/chat/completions");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
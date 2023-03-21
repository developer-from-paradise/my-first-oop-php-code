<?php
// This is a class for web search API that provides useGoogle() and useChatGPT() methods to make requests to the respective API.
class webSearchAPI {
    // There are static variables $pagesize and $autocorrect to store the page size and auto correct values respectively. 
    static $pagesize = "10";
    static $autocorrect = "false";
    // The useGoogle() method takes two parameters, the API key and the search string and returns the data from the API in JSON format.
    public function useGoogle( string $api, string $str){
        // Just get request nothinbg interesting
        $data = file_get_contents("https://contextualwebsearch-websearch-v1.p.rapidapi.com/api/Search/WebSearchAPI?q={$str}&pageNumber=10&pageSize=".self::$pagesize."&autoCorrect=".self::$autocorrect."&rapidapi-key={$api}");
        return $data;
    }

    // The useChatGPT() method takes two parameters, the API key and the prompt and returns the completion chat data from the API in JSON format.
    public function useChatGPT(string $api, string $prompt){
        // That's post request something interesting
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
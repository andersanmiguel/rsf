<?php 
class Http {

    public static function go($url) {
        header('Location: '.$url);
    }

    public static function error($error) {
      header('HTTP/1.0 '.$error.' Not Found');
    }

    public static function post($url, $data) {

      $fields = count($data);
      $fields_string = http_build_query($data);

      //open connection
      $ch = curl_init();

      //set the url, number of POST vars, POST data
      curl_setopt($ch,CURLOPT_URL,$url);
      curl_setopt($ch,CURLOPT_POST,count($fields));
      curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
      curl_setopt($ch,CURLOPT_HTTPHEADER,array('Location: '.$url));
      curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);

      //execute post
      $result = curl_exec($ch);

      //close connection
      curl_close($ch);
    }

}


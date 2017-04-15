<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


class Skyscanner
{
    private $username;
    private $password;
    private $headers;
    private $baseUrl;
    private $key;
    private $curl;

    public function __construct($baseUrl, $key)
    {
        $this->setBaseUrl($baseUrl);
        $this->setKey($key);
        $this->headers = array(
            'Accept: application/json',
            'Content-Type: application/json'
        );
    }

    private function configureCurl($url)
    {
        //Configure Curl
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_VERBOSE, 1);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        $this->setUrl($url);

        // Optional Authentication:
        // curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // curl_setopt($curl, CURLOPT_USERPWD, $this->username . ":" . $this->password);
    }

    private function setPassword($password)
    {
        $this->password = $password;
    }

    private function setUsername($username)
    {
        $this->username = $username;
    }

    private function setKey($key)
    {
        $this->key = $key;
    }

    private function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    private function insertKey()
    {
        return "?apiKey=" . $this->key;
    }

    private function setUrl($url)
    {
        $fullUrl = $this->baseUrl . $url . $this->insertKey();
        curl_setopt($this->curl, CURLOPT_URL, $fullUrl);
    }

    private function resturnValue($result)
    {
        if (($resultObject = json_decode($result)) != null) {
            return $resultObject;
        } else {
            return $result;
        }
    }

    public function getLocales()
    {
        $this->configureCurl('/reference/v1.0/locales');
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $this->resturnValue($response);
    }

    public function get($url)
    {
        $this->configureCurl($url);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $this->resturnValue($response);
    }

    public function postJSONFile($url, $file_path)
    {
        $file_name = basename($file_path);

        $cfile = new \CURLFile($file_path); // initiating CURLFile for preparing the upload
        $cfile->setPostFilename($file_name); //setting the file name

        $data = array('file' => $cfile); //creating array for Curl Post Fields
        $ch = curl_init(); // initiating curl

//setting the headers
        $headers = array(
            'X-Atlassian-Token: nocheck',
            'Content-Type: multipart/form-data'
        );

//setting curl option on array
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_USERPWD => $this->username . ":" . $this->password,
            CURLOPT_POST => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_VERBOSE => 1,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
        ));

//executing curl
        $response = curl_exec($ch);
        curl_close($ch); //closing curl

        if (($resultObject = json_decode($response)) != null) {
            return $resultObject;
        } else {
            return $response;
        }
    }

    public function downloadAttachment($url, $path)
    {
        $curl = curl_init($url);
        $fp = fopen($path, 'wb');
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($curl, CURLOPT_FILE, $fp);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_exec($curl);
        curl_close($curl);
        fclose($fp);
    }


}
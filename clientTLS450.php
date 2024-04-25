<?php
namespace BraienStorm\\Helper;
class TLS450
{
    private $username;
    private $password;
    private $ip;
    private $allTanks = array();
    public function __construct($username = '', $password = '', $ip = '')
    {
        $this->username = $username;
        $this->password = $password;
        $this->ip = $ip;
        $this->Refress();
    }
    private function GetAllTanksOverviewInfo()
    {
        $loginxml = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ns="urn:TLSWebService"><SOAP-ENV:Body><ns:Login></ns:Login></SOAP-ENV:Body></SOAP-ENV:Envelope>';
        $loginUrl = 'https://' . $this->username . ':' . $this->password . '@' . $this->ip . '/fcgi-bin/FastCGIRequestHandler';
        $tanksxml = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ns="urn:TLSWebService"><SOAP-ENV:Body><ns:GetAllTanksOverviewInfo></ns:GetAllTanksOverviewInfo></SOAP-ENV:Body></SOAP-ENV:Envelope>';
        $tanksUrl = 'https://' . $this->ip . '/fcgi-bin/FastCGIRequestHandler';
        $logoutxml = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ns="urn:TLSWebService"><SOAP-ENV:Body><ns:Logout></ns:Logout></SOAP-ENV:Body></SOAP-ENV:Envelope>';
        $validatorUrl = 'https://0:0@' . $this->ip . '/fcgi-bin/FastCGIRequestHandler';
        $validatorxml = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ns="urn:TLSWebService"><SOAP-ENV:Body><ns:GetCredentialValidators></ns:GetCredentialValidators></SOAP-ENV:Body></SOAP-ENV:Envelope>';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $loginUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $loginxml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($ch);
        $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:', 'ns:'], '', $output);
        $xml = simplexml_load_string($clean_xml);
        $sessionId = $xml->Body->LoginResponse->sessionId;
        curl_setopt($ch, CURLOPT_COOKIE, 'TLSSESSION=' . $sessionId);
        curl_setopt($ch, CURLOPT_URL, $tanksUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $tanksxml);
        $output = curl_exec($ch);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $logoutxml);
        $logout = curl_exec($ch);
        curl_setopt($ch, CURLOPT_COOKIE, '');
        curl_setopt($ch, CURLOPT_URL, $validatorUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $validatorxml);
        $valid = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    public function Refress()
    {
        $xml = $this->GetAllTanksOverviewInfo();
        $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:', 'ns:'], '', $xml);
        $xml = simplexml_load_string($clean_xml);
        //$this->allTanks = $xml->Body->AllTankOverviewInfo->AllTanks;
        foreach ($xml->Body->AllTankOverviewInfo->AllTanks as $tank) {
            $this->allTanks[] = $tank;
        }
        print_r($this->allTanks);
    }
    public function GetTank($tankId)
    {
        foreach ($this->allTanks as $tank) {
            if ($tank->TankId == $tankId) {
                $tank = json_decode(json_encode($tank), true);
                return $tank;
            }
        }
        return null;
    }
}




<?php

namespace App\Http\Controllers\API;

use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CASController extends Controller
{

    private $casUrl = 'https://cas.apiit.edu.my';
    private $casTGT = '';
    private $casST = '';

    private function getHttp(): Client {
        return new Client();
    }

    public function getTGT(string $username, string $password) { // TGT will be valid for 30 days
        try {
            $response = $this->getHttp()->request('POST', $this->casUrl . '/cas/v1/tickets', [
                'headers' => [
                    'Content-type' => 'Application/x-www-form-urlencoded'
                ],
                'form_params' => [
                    'username' => strtoupper($username),
                    'password' => $password
                ],
                'verify' => false
            ]);
            return $this->casTGT = str_replace('https://cas.apiit.edu.my/cas/v1/tickets/', '', $response->getHeader('Location')[0]);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'An error has occurred while we acquire your TGT from CAS']);
        }
    }

    public function getST() { // ST will be valid for 20 seconds
        try {
            $response = $this->getHttp()->request('POST', $this->casUrl . "/cas/v1/tickets/{$this->casTGT}", [
                'form_params' => [
                    'service' => 'https://api.apiit.edu.my/student/profile'
                ],
                'verify' => false
            ]);
            return $this->casST = $response->getBody()->getContents();
        } catch (\Exception $exception) {
            return response()->json(['message' => 'An error has occurred while we acquire your ST from CAS']);
        }
    }

   public function getStudentProfile($username = null, $password = null) {
        if (!$username || !$password) return response()->json(['message' => 'Parameters not satisfied.']);
        $this->getTGT($username, $password);
        $this->getST();

       try {
            $response = $this->getHttp()->request('GET', "https://api.apiit.edu.my/student/profile?ticket={$this->casST}", [
                'verify' => false
            ]);

            return $response->getBody()->getContents();
        } catch (\Exception $exception) {
            return response()->json(['message' => 'An error has occurred while we acquire your Student Profile. Please check your credentials.']);
        }
   }
}

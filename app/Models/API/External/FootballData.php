<?php

namespace App\Models\API\External;

use \Guzzle\Service\Client;
use Illuminate\Database\Eloquent\Model;

class FootballData extends Model {

    protected $_client = FALSE;
    protected $_url = "http://api.football-data.org/v1/";
    protected $_endpoint = FALSE;
    protected $_headers = array(
            'content-type' => 'application/json',
            'X-Auth-Token'=> 'aa4c6062cd224245864917f5dee9a138'
                );

    public function __construct() {
        $this->_client = new Client($this->_url);
    }

    public function other() {
        $client3 = new Client("https://restcountries.eu/rest/v2/");
        $request = $client3->get('all', array(
            'content-type' => 'application/json'
                ), array());
        $response = $request->send();
//        var_dump($response->json());

        $client2 = new Client("http://api.football-data.org/v1/");
        $request = $client2->get('/fixtures/', array(
            'content-type' => 'application/json'
                ), array());
        $response = $request->send();
        var_dump($response->json());

        $client2 = new Client("http://api.football-data.org/v1/");
        $request = $client2->get('competitions/424/fixtures', array(
            'content-type' => 'application/json'
                ), array());
        $response = $request->send();
        var_dump($response->json());


        die();
    }

    public function getAllCompetitions($year) {
        $this->_endpoint = "competitions?season={$year}";
        

        $request = $this->_client->get($this->_endpoint, $this->_headers, array());
        $response = $request->send();
        return $response->json();
    }

    public function getCompetitionFixtures($competition_id){
        $this->_endpoint = "competitions/{$competition_id}/fixtures";

        $request = $this->_client->get($this->_endpoint, $this->_headers, array());
        $response = $request->send();
        
        return $response->json();        
    }
    
    public function getCompetitionFinishedFixtures($competition_id){
        $all = $this->getCompetitionFixtures($competition_id);

        $fixtures = [];
        foreach($all['fixtures'] as $fixture){
            if($fixture['status'] == 'FINISHED'){
                $fixtures[] = $fixture;
            }
        }
        
        return $fixtures;
    }
    
    public function getCompetitionStandings($competition_id){
        
        
        
    }

}

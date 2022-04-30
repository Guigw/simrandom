<?php

namespace Yrial\Simrandom\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChallengeControllerTest extends WebTestCase
{
    public function testIndexChallenge(): void
    {
        $client = static::createClient();
        //get challenge list
        $client->request('GET', '/challenge');
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertGreaterThanOrEqual(1, count($responseData));

        //get first challenge
        $firstChallengeId = $responseData[0]['id'];
        $client->request('GET', '/challenge/' . $firstChallengeId);
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals(1, $responseData['id']);
        $challengeName = $responseData['name'];

        //get Results
        $randomizers = $responseData['randomizers'];
        $resultsRandomizer = [];
        foreach ($randomizers as $randomizer) {
            if ($randomizer == 'colors') {
                $client->request('GET', '/randomizer/' . $randomizer . '?number=' . $resultsRandomizer['rooms']['result']);
            } else {
                $client->request('GET', '/randomizer/' . $randomizer);
            }
            $response = $client->getResponse();
            $this->assertSame(200, $response->getStatusCode());
            $responseData = json_decode($response->getContent(), true);
            $this->assertEquals($randomizer, $responseData['title']);
            $this->assertNotEmpty($responseData['result']);
            $resultsRandomizer[$randomizer] = $responseData;
        }

        //post save
        $client->request('POST', '/challenge/save', [], [], [], json_encode([
            'name' => $challengeName,
            'resultList' => array_map(function ($result) {
                return $result['id'];
            }, $resultsRandomizer)
        ]));
        $response = $client->getResponse();
        $this->assertSame(201, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertNotEmpty($responseData['id']);
        $savedChallenge = $responseData['id'];

        //get saved challenge
        $client->request('GET', '/challenge/' . $savedChallenge . '/results');
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals($savedChallenge, $responseData['id']);
        $this->assertEquals(count($resultsRandomizer), $responseData['count']);
        foreach ($responseData['randomizers'] as $randomizer) {
            $this->assertEquals($resultsRandomizer[$randomizer['title']]['result'], $randomizer['result']);
        }
    }
}
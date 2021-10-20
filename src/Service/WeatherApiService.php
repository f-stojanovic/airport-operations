<?php

namespace App\Service;

use App\Entity\Weather;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class WeatherApiService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * WeatherApiService constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface|OptimisticLockException
     */
    public function getWeatherInformation(): Weather
    {
        $method = 'GET';
        $apiKey = '1a1f91e2241e9056cf2dd4f9cf66e8da';
        $url = "https://api.openweathermap.org/data/2.5/weather?q=London&appid=$apiKey";

        $response = HttpClient::create(['base_uri' => $url])->request($method, $url);

        $jsonData = json_decode($response->getContent());

        return $this->saveWeatherInformation(
            $jsonData->weather[0]->description,
            $jsonData->main->temp,
            $jsonData->visibility,
            $jsonData->wind->speed,
            $jsonData->wind->deg
        );
    }

    /**
     * @param $description
     * @param $temperature
     * @param $visibility
     * @param $windSpeed
     * @param $windDag
     * @throws OptimisticLockException
     * @throws \Exception
     */
    public function saveWeatherInformation($description, $temperature, $visibility, $windSpeed, $windDag): Weather
    {
        $newWeather = new Weather();
        $newWeather->setDescription($description);
        $newWeather->setTemperature($temperature);
        $newWeather->setVisibility($visibility);
        $newWeather->setWindSpeed($windSpeed);
        $newWeather->setWindDag($windDag);
        $newWeather->setLastUpdate();

        $this->entityManager->persist($newWeather);
        $this->entityManager->flush();

        return $newWeather;
    }
}

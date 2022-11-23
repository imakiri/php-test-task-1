<?php

namespace app\commands;

use app\repositories\CityRepository;
use app\repositories\CountryRepository;
use app\repositories\DirectionRepository;
use app\services\CityService;
use app\services\CountryService;
use app\services\DirectionService;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Exception;
use yii\helpers\Json;


class UpdateController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionIndex(): int
    {
        $url = "https://poedem.kz/find-form/get-data-for-wide";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Accept-Encoding: gzip',
            'User-Agent: PHP'
        ));
        $response = curl_exec($ch);
        if ($response === false) {
            $info = curl_error($ch);
            var_export($info);
            curl_close($ch);
            return ExitCode::IOERR;
        }
        curl_close($ch);

        $data = Json::decode($response);

        $city_service = new CityService(new CityRepository);
        $country_service = new CountryService(new CountryRepository);
        $direction_service = new DirectionService(new DirectionRepository);

        $city_service->set($data['cities']);
        $country_service->set($data['countries']);
        $direction_service->set($data['directions']);

        return ExitCode::OK;
    }
}
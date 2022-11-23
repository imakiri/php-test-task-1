<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Json;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class UpdateController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @return int Exit code
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

        $r_city = post("localhost:8080/city/set", Json::encode($data['cities']));
        $r_country = post("localhost:8080/country/set", Json::encode($data['countries']));
        $r_direction = post("localhost:8080/direction/set", Json::encode($data['directions']));

        print_r($r_city['info']['http_code']);
        print_r($r_city['error']);
        print_r($r_country['info']['http_code']);
        print_r($r_country['error']);
        print_r($r_direction['info']['http_code']);
        print_r($r_direction['error']);

        return ExitCode::OK;
    }
}

function post(string $url, string $payload): array
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch,CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'Content-Type: application/json',
        'Accept-Encoding: gzip',
        'User-Agent: PHP'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $err = curl_error($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    return ['error' => $err, 'info' => $info];
}

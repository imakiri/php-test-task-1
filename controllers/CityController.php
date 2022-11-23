<?php

namespace app\controllers;

use app\models\City;
use Yii;
use yii\base\InvalidConfigException;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Json;

require 'utils.php';

class CityController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['GET'],
                    'set' => ['POST'],
                ],
            ],
        ];
    }

    public function actionList(): string
    {
        $raw_data = City::find()->all();
        $data = [];
        foreach ($raw_data as $elem) {
            $data[$elem->getAttribute('city_id')] = $elem->getAttributes(null, ['city_id']);
        }

        $resp = Yii::$app->getResponse();
        $resp->format = Response::FORMAT_JSON;
        $resp->content = Json::encode($data);
        $resp->send();

        return "";
    }

    /**
     * @throws InvalidConfigException
     */
    public function actionSet(): string
    {
        $req = Yii::$app->getRequest();
        foreach ($req->getBodyParams() as $key => $elem) {
            $elem['city_id'] = $key;
            $elem['name_from'] = $elem['nameFrom'];
            unset($elem['nameFrom']);

            $city = new City();
            $city->attributes = $elem;
            $city->save();
        }

        return "";
    }

}

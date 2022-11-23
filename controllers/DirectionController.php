<?php

namespace app\controllers;

use app\models\Direction;
use Yii;
use yii\base\InvalidConfigException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\Response;

class DirectionController extends Controller
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
        $raw_data = Direction::find()->all();
        $data = $raw_data;
//        foreach ($raw_data as $elem) {
//
//
//            $data[$elem->getAttribute('city_id')] = $elem->getAttributes(null, ['city_id']);
//        }

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
        foreach ($req->getBodyParams() as $city_id => $t) {
            foreach ($t as $country_id => $elem) {

                $elem['city_id'] = intval($city_id);
                $elem['country_id'] = intval($country_id);
                $elem['default_date'] = $elem['defaultDate'];
                unset($elem['defaultDate']);
                $elem['days'] = Json::encode($elem['days']);

                $direction = new Direction();
                $direction->attributes = $elem;
                $direction->save();
            }
        }

        return "";
    }
}

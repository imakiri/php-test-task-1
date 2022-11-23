<?php

namespace app\controllers;

use app\models\Country;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\Response;

class CountryController extends Controller
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

    /**
     * @throws Exception
     */
    public function actionList(): string
    {
        $raw_data = (new Country)->list();

        $data = [];
        foreach ($raw_data as $elem) {
            $cid = $elem['country_id'];
            unset($elem['country_id']);

            $data[$cid] = $elem;
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
            $elem['country_id'] = $key;
            $elem['name_to'] = $elem['nameTo'];
            unset($elem['nameTo']);
            unset($elem['departs']);

            $country = new Country();
            $country->attributes = $elem;
            $country->save();

        }

        return "";
    }

}

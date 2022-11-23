<?php

namespace app\controllers;

use app\repositories\CityRepository;
use app\repositories\CountryRepository;
use app\repositories\DirectionRepository;
use app\services\CityService;
use app\services\CountryService;
use app\services\DirectionService;
use Yii;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\Response;

class ContentController extends Controller
{
    private CityService $service_city;
    private CountryService $service_country;
    private DirectionService $service_direction;

    function __construct($id, $module, $config = [])
    {
        $this->service_city = new CityService(new CityRepository());
        $this->service_country = new CountryService(new CountryRepository());
        $this->service_direction = new DirectionService(new DirectionRepository());
        parent::__construct($id, $module, $config);
    }

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
                ],
            ],
        ];
    }

    /**
     * @throws Exception
     */
    public function actionList(): string
    {
        $data = [
            'cities' => Json::decode($this->service_city->list()),
            'countries' => Json::decode($this->service_country->list()),
            'directions' => Json::decode($this->service_direction->list()),
        ];

        $resp = Yii::$app->getResponse();
        $resp->format = Response::FORMAT_JSON;
        $resp->content = Json::encode($data);
        $resp->send();

        return "";
    }

}
<?php

namespace app\controllers;

use app\repositories\DirectionRepository;
use app\services\DirectionService;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\Response;

class DirectionController extends Controller
{
    private DirectionService $service;

    function __construct($id, $module, $config = [])
    {
        $this->service = new DirectionService(new DirectionRepository());
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
        $data = $this->service->list();

        $resp = Yii::$app->getResponse();
        $resp->format = Response::FORMAT_JSON;
        $resp->content = $data;
        $resp->send();

        return "";
    }

    /**
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function actionSet(): string
    {
        $req = Yii::$app->getRequest()->getBodyParams();
        $err = $this->service->set($req);

        $resp = Yii::$app->getResponse();
        $resp->format = Response::FORMAT_JSON;
        $resp->content = Json::encode($err);
        $resp->send();

        return "";
    }
}

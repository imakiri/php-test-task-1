<?php

namespace app\services;

use app\entities\CityEntity;
use app\repositories\CityRepository;
use yii\db\Exception;
use yii\helpers\Json;

require_once "utils.php";

class CityService
{
    private CityRepository $repo;

    function __construct(CityRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @throws Exception
     */
    public function list(): string
    {
        $raw_data = $this->repo->list();
        $data = [];
        foreach ($raw_data as $city_id => $city) {
            $city_array = $city->toArray();

            unset($city_array[$city_id]);
            rename_key($city_array, 'name_from', 'nameFrom');

            $data[$city_id] = $city_array;
        }
        return Json::encode($data);
    }

    /**
     * @throws Exception
     */
    public function set(array $args): string
    {
        $errs = [];
        foreach ($args as $key => $elem) {
            $elem['city_id'] = $key;
            rename_key($elem, 'nameFrom', 'name_from');
            $errs[$key] = $this->repo->set((new CityEntity)->fromArray($elem));
        }
        return Json::encode($errs);
    }

}
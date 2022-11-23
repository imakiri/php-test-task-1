<?php

namespace app\services;

use app\entities\DirectionEntity;
use app\repositories\DirectionRepository;
use yii\db\Exception;
use yii\helpers\Json;

require_once "utils.php";

class DirectionService
{
    private DirectionRepository $repo;

    function __construct(DirectionRepository $repo)
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
        foreach ($raw_data as $direction) {
            $direction_array = $direction->toArray();
            rename_key($direction_array, 'default_date', 'defaultDate');
            $city_id = $direction_array['city_id'];
            $country_id = $direction_array['country_id'];
            unset($direction_array['city_id']);
            unset($direction_array['country_id']);
            $data[$city_id][$country_id] = $direction_array;
        }
        return Json::encode($data);
    }

    /**
     * @throws Exception
     */
    public function set(array $args): string
    {
        $errs = [];
        foreach ($args as $city_id => $t) {
            foreach ($t as $country_id => $elem) {
                $elem['city_id'] = $city_id;
                $elem['country_id'] = $country_id;
                rename_key($elem, 'defaultDate', 'default_date');
                $elem['days'] = Json::encode($elem['days']);
                $errs[$city_id.$country_id] = $this->repo->set((new DirectionEntity)->fromArray($elem));
            }
        }
        return Json::encode($errs);
    }

}

<?php

namespace app\services;

use app\entities\CountryEntity;
use app\repositories\CountryRepository;
use yii\db\Exception;
use yii\helpers\Json;

require_once "utils.php";

class CountryService
{
    private CountryRepository $repo;

    function __construct(CountryRepository $repo)
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
        foreach ($raw_data as $country_id => $country) {
            $country_array = $country->toArray();
            rename_key($country_array, 'name_to', 'nameTo');
            unset($country_array[$country_id]);
            $data[$country_id] = $country_array;
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
            $elem['country_id'] = $key;
            rename_key($elem, 'nameTo', 'name_to');
            $errs[$key] = $this->repo->set((new CountryEntity)->fromArray($elem));
        }
        return Json::encode($errs);
    }

}

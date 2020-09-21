<?php

namespace Make\Ship\Api\Data;

interface WaysInterface
{
    const ID = 'id';
    const NAME = 'name';
    const STATUS = 'status';
    const PRICE = 'price';
    const MIN_SUBTOTAL = 'min_subtotal';
    const MAX_SUBTOTAL = 'max_subtotal';
    const MIN_WEIGHT = 'min_weight';
    const MAX_WEIGHT = 'max_weight';
    const ZIPCODE = 'zipcode';
    const PERCENT = 'percent';



    public function getId();

    public function getName();

    public function getStatus();

    public function getPrice();

    public function getMinSubtotal();

    public function getMaxSubtotal();

    public function getMinWeight();

    public function getMaxWeight();

    public function getZipcode();

    public function getPercent();




    public function setId($id);

    public function setName($name);

    public function setStatus($status);

    public function setPrice($price);

    public function setMinSubtotal($min_subtotal);

    public function setMaxSubtotal($max_subtotal);

    public function setMinWeight($min_weight);

    public function setMaxWeight($max_weight);

    public function setZipcode($zipcode);

    public function setPercent($percent);
}

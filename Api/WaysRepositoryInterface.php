<?php

namespace Make\Ship\Api;

interface WaysRepositoryInterface
{
    public function save(\Make\Ship\Api\Data\WaysInterface $ways);

    public function getById($id);

    public function delete(\Make\Ship\Api\Data\WaysInterface $ways);

    public function deleteById($id);
}

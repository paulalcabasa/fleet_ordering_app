<?php

namespace App\Repositories;

interface OutOfficeRepositoryInterface
{
    public function all();

    public function findByUser($userId, $userSource);

    public function update($id);

    public function delete($id);

    public function store($request);
}
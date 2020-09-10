<?php

namespace App\Repositories;

interface OutOfficeRepositoryInterface
{
    public function all();

    public function findById($id);

    public function update($id);

    public function delete($id);

    public function store($request);
}
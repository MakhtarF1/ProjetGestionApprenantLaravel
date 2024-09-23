<?php
namespace App\Services\Interfaces;

interface ReferentielServiceInterface
{
    public function create(array $data);
    public function all($etat = null);
    public function find($id, $filter = null);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getArchived();
}

<?php

namespace App\Repositories\Interfaces;

interface PromotionRepositoryInterface
{
    public function create(array $data);
    public function all();
    public function find($id);
    public function save($id, array $data);
    public function delete($id);
    public function updateReferentiels($id, array $referentiels);
    public function getActiveReferentiels($id);
    public function getStatistics($id);
}

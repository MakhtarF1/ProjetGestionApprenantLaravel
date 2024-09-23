<?php

namespace App\Services\Interfaces;

interface PromotionServiceInterface
{
    public function all();
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function updateReferentiels($id, array $referentiels);
    public function changeStatus($id, $etat);
    public function closePromotion($id);
    public function getActiveReferentiels($id);
    public function getStatistics($id);
}

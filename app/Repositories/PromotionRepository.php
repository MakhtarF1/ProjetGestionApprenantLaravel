<?php

namespace App\Repositories;

use App\Facades\PromotionFacade;
use App\Models\PromotionModel;
use Illuminate\Support\Collection;

class PromotionRepository
{
    public function create(array $data): PromotionModel
    {
        return PromotionFacade::create($data);
    }

    public function update(string $id, array $data): PromotionModel
    {
        return PromotionFacade::update($id, $data);
    }

    public function find(string $id): ?PromotionModel
    {
        return PromotionFacade::find($id);
    }

    public function getAll(): Collection
    {
        return collect(PromotionFacade::all());
    }

    public function getByEtat(string $etat): Collection
    {
        return collect(PromotionFacade::where('etat', $etat)->get());
    }

    public function delete(string $id): bool
    {
        return PromotionFacade::delete($id);
    }
}
<?php

namespace App\Repositories\Interfaces;

/**
 * Interface PostCatalogueServiceInterface
 * @package App\Services\Interfaces
 */
interface AttributeRepositoryInterface extends BaseRepositoryInterface
{
   public function count(array $condition, string $keyword, string $query);
   public function paginate(array $condition, string $keyword, string $query ,array $config, int $page);
}

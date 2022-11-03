<?php

namespace App\Repositories\Interfaces;

/**
 * Interface PostCatalogueServiceInterface
 * @package App\Services\Interfaces
 */
interface SlideRepositoryInterface extends BaseRepositoryInterface
{
   public function count(array $condition, string $keyword);
   public function paginate(array $condition, string $keyword, array $config, int $page);
}

<?php

namespace App\Repositories\Interfaces;

/**
 * Interface PostCatalogueServiceInterface
 * @package App\Services\Interfaces
 */
interface BaseRepositoryInterface
{
   public function all(string $colum = '*', array $relation = [], int $language);
   public function findById(int $id);
   public function create(array $payload);
   public function createTranslate($payload, $table);
   public function update(array $payload, int $id);
   public function updateTranslate(array $payload, string $table, array $condition);
   public function createRelation(array $relation = [], string $table = '');
   public function deleteRelation(int $id, string $table);
   public function delete(int $id);

}

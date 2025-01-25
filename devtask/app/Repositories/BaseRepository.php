<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all records with pagination
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    // Get a record by its ID
    public function getById(int $id): ?Model
    {
        return $this->model->find($id);
    }

    // Create a new record
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    // Update an existing record
    public function update(int $id, array $data): ?Model
    {
        $model = $this->getById($id);
        if ($model) {
        $model->update($data);
        }
        return $model;
    }

    // Delete a record
    public function delete(int $id): bool
    {
        $model = $this->getById($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }
}

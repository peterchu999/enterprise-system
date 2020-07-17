<?php 

namespace App\Repositories\Impl;

use Carbon\Carbon;

use App\Repositories\IndustryRepository;
use App\Industry;


class IndustryRepositoryImpl implements IndustryRepository {
    protected $model;

    public function __construct(Industry $industry) {
        $this->model = $industry;
    }

    public function create(Industry $industry) {
        $this->model->create($industry->getAttributes());
    }

    public function remove($id) {
        $industry = $this->model->find($id);
        $industry->delete();
        return $industry;
    }

    public function update(Industry $indust, $id) {
        $industry = $this->model->find($id);
        $industry->update($indust->getAttributes());
        return $industry;
    }

    public function all() {
        return $this->model->all();
    }

    public function find($id) {
        return $this->model->where('id',$id)->first();
    }
}
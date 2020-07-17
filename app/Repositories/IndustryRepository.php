<?php 

namespace App\Repositories;

use App\Industry;

interface IndustryRepository
{
    public function create(Industry $industry);
    public function remove($id);
    public function update(Industry $industry, $id);
    public function all();
    public function find($id);
}
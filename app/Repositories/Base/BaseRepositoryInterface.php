<?php

namespace App\Repositories\Base;

interface BaseRepository 
{
    public function items(array $search, array $relations);
}
<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

use App\Article;

class DealExp extends Article
{
    protected $table = 'articles';
    
    function __construct(array $attributes = []){
        parent::__construct($attributes);
    }

    public function save(array $options = []){
        $this->_type = Article::TYPE_DEALEXP;
        $this->_create_by = Auth::user()->name;
        parent::save($options);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// use App\Category;
// use App\Section;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{

    protected $fillable = ['title','alias','content','categoryid','sectionid','type','published','deleted','ordering','out_link','from','deal_id'];

    const TYPE_PAGE = 'page';
    const TYPE_NORMAL = 'normal';
    const TYPE_RECRUIT = 'recruit';
    const TYPE_DEALEXP = 'dealexp';

    protected $_type = false;
    protected $_create_by = false;
    // const TYPE_MEDIA_REPORTS = 'media_reports';
    // const TYPE_NOTICE = 'notice';
    // const TYPE_OFFICIAL_NEWS = 'official_news';

    public function __construct(array $attributes = []){
        parent::__construct($attributes);
    }

    public function category(){
        return $this->hasOne('App\Category','id','categoryid');
    }

    public function section(){
        return $this->hasOne('App\Section','id','sectionid');
    }

    public function sModel(){
        return $this->hasOne('App\Article','id','id');
    }

    public function save(array $options = []){
        if( $this->_type ){
            $this->type = $this->_type;
        }else{
            $this->type = static::TYPE_NORMAL;
        }

        if( $this->_create_by ){
            $this->create_by = $this->_create_by;
        }else{
            $this->create_by = Auth::user()->name;
        }
        
        parent::save($options);
    }
}

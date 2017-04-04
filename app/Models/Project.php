<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Jenssegers\Mongodb\Eloquent\Model as Model;

class Project extends Model
{
    protected $collection = 'projects';
    protected $fillable = ['name','description', 'user_id'];
    private $rules = [
        'name' => 'required|max:255',
    ];

    /**
     * @param $data
     * @return bool
     */
    public function validate($data)
    {
        if(!$data) {
            return false;
        }

        $v = Validator::make($data, $this->rules);
        $v->validate();
        if ($v->fails()) {
            return false;
        }
        return true;
    }
}

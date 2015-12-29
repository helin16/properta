<?php namespace App\Modules\Issue\Models;

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\Rental\Models\Rental;
use App\Modules\User\Models\User;
use App\Modules\Issue\Models\IssueDetail;

class Issue extends BaseModel
{
    protected $fillable = ['requester_user_id', 'rental_id', 'status'];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_user_id');
    }

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function details()
    {
        return $this->hasMany(IssueDetail::class);
    }
    /**
     * update or create new
     *
     * @param $description
     * @param null $id
     * @return static
     */
    public static function store($description, Address $address = null, $id = null)
    {
        return self::updateOrCreate(['id' => $id], ['description' => $description, 'address_id' => $address->id]);
    }
}
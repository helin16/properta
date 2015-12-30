<?php namespace App\Modules\Issue\Models;

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\Rental\Models\Rental;
use App\Modules\User\Models\User;
use App\Modules\Issue\Models\IssueDetail;

class Issue extends BaseModel
{
    protected $fillable = ['requester_user_id', 'rental_id', 'status'];
    public static function getAll($rental_id = null, $requester_user_id = null)
    {
        $query = self::orderBy(array_keys(self::$orderBy)[0], array_values(self::$orderBy)[0]);
        if($rental_id)
            $query->where('rental_id', intval($rental_id));
        if($requester_user_id)
            $query->where('requester_user_id', intval($requester_user_id));
        return $query->paginate(self::$pageSize);
    }
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
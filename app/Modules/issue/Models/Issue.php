<?php namespace App\Modules\Issue\Models;

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\Rental\Models\Rental;
use App\Modules\Rental\Models\Property;
use App\Modules\User\Models\User;
use App\Modules\Rental\Models\RentalUser;
use Illuminate\Support\Facades\Session;

class Issue extends BaseModel
{
    const STATUS_APPROVED = 1;
    const STATUS_PENDING = 0;
    protected $fillable = ['requester_user_id', 'rental_id', 'status'];
    public static function getAll($rental_id = null, $requester_user_id = null, $property_id = null)
    {
        $role = (Session::get('currentUserRole'));
        $isAgencyAdmin = ($role === 'agency admin');
        $isAgenct = ($role === 'agent');
        $isLandlord = ($role === 'landlord');
        $isTenant = ($role === 'tenant');
        if(!($user = User::find(Session::get('currentUserId'))) instanceof User)
            return Redirect::to('user')->send();

        // filter by access control
        $rental_ids = [];
        foreach(RentalUser::where('user_id', $user->id)->get() as $rental_user)
            if(($rental = Rental::find($rental_user->rental_id)) instanceof Rental)
                $rental_ids[] = $rental->id;
        $rental_ids = array_unique($rental_ids);
        $query = self::whereIn('rental_id', $rental_ids);

        // filter by request
        if($rental_id)
            $query->where('rental_id', intval($rental_id));
        elseif($property_id and ($property = Property::find($property_id)) instanceof Property)
            $query->whereIn('rental_id', array_map(create_function('$a', 'return $a->id;'), $property->rentals->all()));
        if($requester_user_id)
            $query->where('requester_user_id', intval($requester_user_id));

        // filter by role
        if($isTenant)
            $query->where('requester_user_id', $user->id);
        elseif($isLandlord)
            $query->where('status', self::STATUS_APPROVED)->orWhere('requester_user_id', Session::get('currentUserId'));

        $query->orderBy(array_keys(self::$orderBy)[0], array_values(self::$orderBy)[0]);
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
    public function requester_user()
    {
        return $this->belongsTo(User::class, 'requester_user_id');
    }
    public static function store(User $requester_user, Rental $rental, $status = '', $id = null)
    {
        return self::updateOrCreate(['id' => $id], ['requester_user_id' => $requester_user->id, 'rental_id' => $rental->id, 'status' => $status]);
    }
    public function inline()
    {
        return $this->rental->inline();
    }
    public function status()
    {
        switch($this->status) {
            case self::STATUS_APPROVED:
                return 'approved';
            case self::STATUS_PENDING:
                return 'not approved';
        }
    }
    public static function statusOptions() {
        $role = (Session::get('currentUserRole'));
        if(!in_array($role, ['agency admin', 'agent']))
            return [self::STATUS_PENDING => 'not approved'];
        return [
            self::STATUS_APPROVED => 'approved',
            self::STATUS_PENDING => 'not approved',
        ];
    }
}
<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'size'
    ];

    /**
    * description
    *
    * @param 
    * @return 
    **/
    public function add($user)
    {
        $this->guardAgainstTooManyMembers($user);

        if($user instanceof User){
            return $this->members()->save($user);
        }

        $this->members()->saveMany($user);
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function count()
    {
        return $this->members()->count();
    }

    /**
    * description
    *
    * @param 
    * @return 
    **/
    public function remove($user)
    {
        if($user instanceof User){
            $user->team_id = null;
            $user->save();
            return $user;
        }
        
        $this->members()
            ->whereIn('id', $user->pluck('id'))
            ->update(['team_id' => null]);

    }

    /**
    * description
    *
    * @param 
    * @return 
    **/
    public function empty()
    {
        foreach($this->members()->get() as $member){
            $this->remove($member);
        }
    }

    /**
    * description
    *
    * @return void
    **/
    private function guardAgainstTooManyMembers($users)
    {
        $numberUsersToAdd = $users instanceof User ? 1 : $users->count();
        if($this->count() + $numberUsersToAdd > $this->size){
            throw new Exception();
        }
    }
}

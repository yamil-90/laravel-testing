<?php

namespace App\Traits;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;

trait IsLikeable
{
    /**
    * description
    *
    * @param
    * @return
    **/
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }


    /**
    * the authenticated user likes the likeable
    * @return void
    **/
    public function like()
    {
        $like = new Like(['user_id' => Auth::id()]);

        $this->likes()->save($like);
    }

    /**
    * the authenticated user unlikes the likeable
    * @return void
    **/
    public function unlike()
    {
        $this->likes()->where('user_id', Auth::id())->delete();
    }

    /**
    * the authenticated user toogles likes to the likeable
    * @return void
    **/
    public function toogle()
    {
        if ($this->isLiked()) {
           return $this->unlike();
        } 
        return $this->like();
    }

    /**
    * returns true if the likeable is liked by auth user
    *
    * @param
    * @return
    **/
    public function isLiked()
    {
        return !! $this->likes()->where('user_id', Auth::id())->count();
    }

    /**
    * returns the number of likes the likeable has
    *
    * @return int
    **/
    public function likesCount()
    {
        return $this->likes()->count();
    }
}
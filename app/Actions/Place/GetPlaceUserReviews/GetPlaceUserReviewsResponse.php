<?php
namespace Hedonist\Actions\Place\GetPlaceUserReviews;

use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Database\Eloquent\Collection;

class GetPlaceUserReviewsResponse
{
    private $placeCollection;
    private $user;

    public function __construct(Collection $places, User $user)
    {
        $this->placeCollection = $places;
        $this->user = $user;
    }

    public function getPlaceCollection(): Collection
    {
        return $this->placeCollection;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
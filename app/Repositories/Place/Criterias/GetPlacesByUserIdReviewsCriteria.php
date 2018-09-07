<?php
namespace Hedonist\Repositories\Place\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetPlacesByUserIdReviewsCriteria implements CriteriaInterface
{
    private $user_id;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->whereHas('reviews', function ($query) {
            $query
                ->where('user_id', $this->user_id);
        })
            ->take(15);
    }

}
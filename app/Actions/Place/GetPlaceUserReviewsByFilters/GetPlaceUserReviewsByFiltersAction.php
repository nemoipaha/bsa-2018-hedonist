<?php
namespace Hedonist\Actions\Place\GetPlaceUserReviewsByFilters;

use Hedonist\Actions\Place\GetPlaceUserReviews\GetPlaceUserReviewsResponse;
use Hedonist\Entities\User\User;
use Hedonist\Repositories\Place\Criterias\GetPlacesByUserIdReviewsCriteria;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetPlaceUserReviewsByFiltersAction
{
    private $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function execute(GetPlaceUserReviewsByFiltersRequest $request): GetPlaceUserReviewsResponse
    {
        $user_id = $request->getUserId();

        /** @var User $user */
        $user = Auth::user();

        $places = $this->placeRepository->findCollectionByCriterias(
            new GetPlacesByUserIdReviewsCriteria($user_id)
        );

        return new GetPlaceUserReviewsResponse($places, $user);
    }
}
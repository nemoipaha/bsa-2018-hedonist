<?php
namespace Hedonist\Actions\Place\GetPlaceUserReviews;

use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetPlaceUserReviewsAction
{
    private $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function execute(GetPlaceUserReviewsRequest $request): GetPlaceUserReviewsResponse
    {
        $placesUserComment = $this->placeRepository->getAllWithRelations();

        return new GetPlaceUserReviewsResponse($placesUserComment, Auth::user());
    }
}
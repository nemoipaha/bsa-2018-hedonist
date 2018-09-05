<?php

namespace Hedonist\Actions\Place\GetPlaceUserReviews;

use Hedonist\Actions\Place\GetPlaceUserReviews\GetPlaceUserReviewsResponse;
use Hedonist\Actions\Presenters\Place\PlaceWorkTimePresenter;
use Hedonist\Actions\Presenters\Review\ReviewPresenter;
use Hedonist\Actions\Presenters\Category\CategoryPresenter;
use Hedonist\Actions\Presenters\Category\Tag\CategoryTagPresenter;
use Hedonist\Actions\Presenters\City\CityPresenter;
use Hedonist\Actions\Presenters\Feature\FeaturePresenter;
use Hedonist\Actions\Presenters\Localization\LocalizationPresenter;
use Hedonist\Actions\Presenters\Photo\PlacePhotoPresenter;
use Hedonist\Actions\Presenters\Place\PlacePresenter;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\User\User;
use Illuminate\Support\Collection;

class GetPlaceUserReviewsCollectionPresenter
{
    private $placePresenter;
    private $reviewPresenter;
    private $localizationPresenter;
    private $cityPresenter;
    private $categoryPresenter;
    private $photoPresenter;

    public function __construct(
        PlacePresenter $placePresenter,
        ReviewPresenter $reviewPresenter,
        LocalizationPresenter $localizationPresenter,
        CityPresenter $cityPresenter,
        CategoryPresenter $categoryPresenter,
        PlacePhotoPresenter $photoPresenter
    ) {
        $this->placePresenter = $placePresenter;
        $this->reviewPresenter = $reviewPresenter;
        $this->localizationPresenter = $localizationPresenter;
        $this->cityPresenter = $cityPresenter;
        $this->categoryPresenter = $categoryPresenter;
        $this->photoPresenter = $photoPresenter;
    }

    public function present(GetPlaceUserReviewsResponse $placeResponse): array
    {
        return $placeResponse->getPlaceCollection()->map(function (Place $place) use ($placeResponse) {
            $result = $this->placePresenter->present($place);
            $result['review'] = $this->presentReview($place->reviews, $placeResponse->getUser());
            $result['photos'] = $this->photoPresenter->presentCollection($place->photos);
            $result['city'] = $this->cityPresenter->present($place->city);
            $result['localization'] = $this->localizationPresenter->presentCollection($place->localization);
            $result['category'] = $this->categoryPresenter->present($place->category);
            return $result;
        })->toArray();
    }

    private function presentReview(Collection $reviews, User $user): ?array
    {
//        dd($reviews);
//        $review = $reviews->first();
//        if (is_null($review)) {
//            return null;
//        }
        foreach ($reviews as $review) {
            $presented = $this->reviewPresenter->present($review);
            $presented['like'] = $review->getLikedStatus($user->id)->value();
        }

        return $presented;
    }
}
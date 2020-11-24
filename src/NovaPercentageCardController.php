<?php

namespace Creagia\NovaPercentageCard;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Http\Requests\NovaRequest;

class NovaPercentageCardController extends Controller
{
    use ValidatesRequests;

    /**
     * @param NovaRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(NovaRequest $request)
    {
        $request->validate([
            'cardClass' => [
                'required', 'string',
            ],
            'cacheKey' => [
                'required', 'string',
            ],
            'ttl' => [
                'required', 'int'
            ]
        ]);

        $cardClass = $request->cardClass;

        $result = Cache::remember($request->cacheKey, ($request->ttl * 60), function () use ($cardClass) {
            $card = new $cardClass;
            $count = $card->getCount();
            $total = $card->getTotal();
            $percentage = ($total > 0) ? (100 * $count / $total) : 0;
            $percentage = round($percentage, $card->getPercentagePrecision());

            return compact('count', 'total', 'percentage');
        });

        return response()->json($result);
    }
}

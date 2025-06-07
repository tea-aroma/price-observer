<?php

namespace App\Http\Controllers;


use App\Http\Requests\SubscribeRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;


/**
 * Provides actions for Subscribe logic.
 */
class SubscribeController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('subscribe.index');
    }

    /**
     * @param SubscribeRequest $request
     *
     * @return JsonResponse
     */
    public function subscribe(SubscribeRequest $request): JsonResponse
    {
        return response()->json([ 'message' => 'You will start receiving price change notifications only after you confirm your email.' ]);
    }
}

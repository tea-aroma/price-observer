<?php

namespace App\Http\Controllers;


use App\Http\Requests\SubscribeRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;


/**
 * Provides the actions for Recipient.
 */
class RecipientController extends Controller
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
        recipient()->subscribe($request->input('email'), $request->input('url'));

        return response()->json([ 'message' => 'You will start receiving price change notifications only after you confirm your email.' ]);
    }

    /**
     * Confirms the recipient's email.
     *
     * @param string $token
     *
     * @return RedirectResponse
     */
    public function confirm(string $token): RedirectResponse
    {
        recipient()->confirm($token);

        return redirect()->route('recipient.subscribe');
    }
}

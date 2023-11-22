<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'constants' => [
                'MAERSK_COMPANY_ID' => env('MAERSK_COMPANY_ID'),
                'CMA_COMPANY_ID' => env('CMA_COMPANY_ID'),
                'HAPAG_COMPANY_ID' => env('HAPAG_COMPANY_ID'),
                'MSC_COMPANY_ID' => env('MSC_COMPANY_ID'),
                'IGNORED_COMPANIES' => config('constants.IGNORED_COMPANIES'),
                'ROUTE_TYPE_SEA' => ROUTE_TYPE_SEA,
                'ROUTE_TYPE_LAND' => ROUTE_TYPE_LAND,
                'ROUTE_TYPE_AIR' => ROUTE_TYPE_AIR,
            ],
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}

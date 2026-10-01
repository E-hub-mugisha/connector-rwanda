<?php

namespace App\Http\Controllers\stadmin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PromotionsController extends Controller
{
    /**
     * Get the authenticated service provider.
     */
    private function provider(): ServiceProvider
    {
        return ServiceProvider::where(
            'user_id',
            Auth::id()
        )->firstOrFail();
    }

    /**
     * Display promotions belonging to the provider's services.
     */
    public function index()
    {
        $sprovider = $this->provider();

        /*
         * Get promotions only through services owned
         * by the authenticated service provider.
         */
        $promotions = Promotion::query()
            ->whereHas('service', function ($query) use ($sprovider) {
                $query->where(
                    'service_provider_id',
                    $sprovider->id
                );
            })
            ->with([
                'service:id,name,price,service_category_id',
                'service.category:id,name',
            ])
            ->latest()
            ->get();

        /*
         * Only services belonging to this provider
         * can be selected for a promotion.
         */
        $services = Service::query()
            ->where(
                'service_provider_id',
                $sprovider->id
            )
            ->with('category:id,name')
            ->select([
                'id',
                'name',
                'price',
                'service_category_id',
            ])
            ->orderBy('name')
            ->get();

        return view(
            'stadmin.promotions.index',
            compact(
                'promotions',
                'services',
                'sprovider'
            )
        );
    }

    /**
     * Create a promotion.
     */
    public function storePromotion(Request $request)
    {
        $sprovider = $this->provider();

        $validated = $request->validate([
            'service_id' => [
                'required',
                'integer',
                Rule::exists('services', 'id')
                    ->where(function ($query) use ($sprovider) {
                        $query->where(
                            'service_provider_id',
                            $sprovider->id
                        );
                    }),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'discount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:100',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],
        ]);

        Promotion::create($validated);

        return redirect()
            ->route('promotions.index')
            ->with(
                'success',
                'Promotion created successfully.'
            );
    }

    /**
     * Update a promotion.
     */
    public function update(Request $request, $id)
    {
        $sprovider = $this->provider();

        /*
         * Find the promotion only if its service belongs
         * to the currently authenticated provider.
         */
        $promotion = Promotion::query()
            ->whereKey($id)
            ->whereHas('service', function ($query) use ($sprovider) {
                $query->where(
                    'service_provider_id',
                    $sprovider->id
                );
            })
            ->firstOrFail();

        $validated = $request->validate([
            'service_id' => [
                'required',
                'integer',
                Rule::exists('services', 'id')
                    ->where(function ($query) use ($sprovider) {
                        $query->where(
                            'service_provider_id',
                            $sprovider->id
                        );
                    }),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'discount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:100',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],
        ]);

        $promotion->update($validated);

        return redirect()
            ->route('promotions.index')
            ->with(
                'success',
                'Promotion updated successfully.'
            );
    }
}

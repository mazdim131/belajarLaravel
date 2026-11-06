<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\SubscriptionPackageBook;
use App\Models\SubscriptionPackageUser;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $profile = Auth::user();
        $totalSubscriptionPackagesUser = SubscriptionPackageUser::where('user_id', Auth::id())->get()->count();
        $showSubscriptionPackage = SubscriptionPackageUser::where('user_id', Auth::id())->get();
        $activeSubscriptionPackage = SubscriptionPackageUser::where('user_id', Auth::id())->where('expired_date', '>=', now())->pluck('subscription_package_id');
        $showBookOfSubscription = SubscriptionPackageBook::with('Book')->whereIn('subscription_package_id', $activeSubscriptionPackage)->get();

        $totalCheckoutsUser = Checkout::where('user_id', Auth::id())->count();

        $type = request('type', 'subscription');

        if ($type === 'checkout') {
            $transactions = Checkout::where('user_id', Auth::id())->latest()->get();
        } else {
            $type = 'subscription';
            $transactions = SubscriptionPackageUser::with('SubscriptionPackage')
                // ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        return view('profile', compact(
            'profile',
            'totalSubscriptionPackagesUser',
            'showSubscriptionPackage',
            'showBookOfSubscription',
            'totalCheckoutsUser',
            'type',
            'transactions',
        ));
    }
}

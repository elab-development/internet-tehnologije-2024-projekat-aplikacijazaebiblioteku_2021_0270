<?php

namespace App\Models;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;

class SubscriptionController extends Model
{
    // GET /api/subscriptions
    public function index(Request $request)
    {
        $perPage = (int)($request->query('per_page', 10));
        $subs = Subscription::with('user')->paginate($perPage);
        return response()->json($subs);
    }

    // POST /api/subscriptions
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'    => ['required', 'integer', 'exists:users,id'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after:start_date'],
        ]);

        $sub = Subscription::create($data);
        return response()->json($sub->load('user'), 201);
    }

    // GET /api/subscriptions/{subscription}
    public function show(Subscription $subscription)
    {
        return response()->json($subscription->load('user'));
    }

    // PUT/PATCH /api/subscriptions/{subscription}
    public function update(Request $request, Subscription $subscription)
    {
        $data = $request->validate([
            'user_id'    => ['sometimes', 'integer', 'exists:users,id'],
            'start_date' => ['sometimes', 'date'],
            'end_date'   => ['sometimes', 'date', 'after:start_date'],
        ]);

        $subscription->update($data);
        return response()->json($subscription->load('user'));
    }

    // DELETE /api/subscriptions/{subscription}
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return response()->json(['message' => 'Subscription deleted']);
    }
}

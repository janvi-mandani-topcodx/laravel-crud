<?php

namespace App\Repositories;
use App\Models\Discount;
use App\Models\GiftCard;
use App\Models\UsersDemo;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class GiftCardRepository extends BaseRepository
{
    public function model()
    {
        return GiftCard::class;
    }
    public function store($data)
    {
        GiftCard::create([
            'code' => $data['code'],
            'balance' => $data['balance'],
            'user_id' => $data['customer_id'] ?? null,
            'notes' => $data['notes'],
            'expiry_at' => $data['expiry'] == null ? Carbon::now()->addYears(3) : $data['expiry'],
            'enabled' => isset($data['status']) && $data['status'] == 'on' ? 1 : 0,
        ]);
    }


    public function update($data , $giftCard)
    {
        $giftCard->update([
            'code' => $data['code'],
            'balance' => $data['balance'],
            'notes' => $data['notes'] ?? null,
            'expiry_at' => $data['expiry'] == null ? Carbon::now()->addYears(3) : $data['expiry'],
            'enabled' => isset($data['status']) && $data['status'] == 'on' ? 1 : 0,
        ]);
    }
}

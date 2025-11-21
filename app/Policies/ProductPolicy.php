<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

class ProductPolicy
{
    /**
     * Anyone (guest or logged in) can view products.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Anyone can view a single product.
     */
    public function view(?User $user, Product $product): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('seller') || $user->hasRole('admin');
    }

    public function update(User $user, Product $product): bool
    {
        return $user->hasRole('admin') || ($user->hasRole('seller') && $user->id === $product->user_id);
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->hasRole('admin') || ($user->hasRole('seller') && $user->id === $product->user_id);
    }


    /**
     * Custom helper: manage means full control (update/delete).
     */
    public function manage(User $user, Product $product): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->role === 'seller' && $product->user_id === $user->id;
    }

    protected $policies = [
        Product::class => ProductPolicy::class,
    ];

}
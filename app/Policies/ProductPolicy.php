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

    /**
     * Only sellers and admins can create products.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['seller', 'admin']);
    }

    /**
     * Admins can update any product.
     * Sellers can update only their own products.
     */
    public function update(User $user, Product $product): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->role === 'seller' && $user->id === $product->user_id;
    }

    /**
     * Admins can delete any product.
     * Sellers can delete only their own products.
     */
    public function delete(User $user, Product $product): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->role === 'seller' && $user->id === $product->user_id;
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
}
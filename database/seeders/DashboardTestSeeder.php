<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DashboardTestSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // Roles
        if(DB::table('roles')->count() === 0) {
            DB::table('roles')->insert([
                ['name'=>'buyer','created_at'=>$now,'updated_at'=>$now],
                ['name'=>'seller','created_at'=>$now,'updated_at'=>$now],
                ['name'=>'admin','created_at'=>$now,'updated_at'=>$now],
            ]);
        }

        // Users
        $adminId = DB::table('users')->insertGetId([
            'name'=>'Admin User',
            'email'=>'admin@example.com',
            'password'=>Hash::make('password'),
            'created_at'=>$now,
            'updated_at'=>$now,
        ]);

        $sellerId = DB::table('users')->insertGetId([
            'name'=>'Seller One',
            'email'=>'seller1@example.com',
            'password'=>Hash::make('password'),
            'created_at'=>$now,
            'updated_at'=>$now,
        ]);

        $buyerId = DB::table('users')->insertGetId([
            'name'=>'Buyer One',
            'email'=>'buyer1@example.com',
            'password'=>Hash::make('password'),
            'created_at'=>$now,
            'updated_at'=>$now,
        ]);

        // role_user (attach roles) - adjust role ids (buyer=1 seller=2 admin=3) if different
        DB::table('role_user')->insert([
            ['user_id'=>$adminId,'role_id'=>3,'created_at'=>$now,'updated_at'=>$now],
            ['user_id'=>$sellerId,'role_id'=>2,'created_at'=>$now,'updated_at'=>$now],
            ['user_id'=>$buyerId,'role_id'=>1,'created_at'=>$now,'updated_at'=>$now],
        ]);

        // Categories
        $cat1 = DB::table('categories')->insertGetId(['name'=>'Electronics','slug'=>'electronics','created_at'=>$now,'updated_at'=>$now]);

        // Products (seller)
        $p1 = DB::table('products')->insertGetId([
            'user_id'=>$sellerId,
            'category_id'=>$cat1,
            'name'=>'Phone Model X',
            'slug'=>'phone-model-x',
            'description'=>'Sample phone',
            'price'=>250.00,
            'stock'=>10,
            'status'=>'published',
            'images'=>json_encode([]),
            'created_at'=>$now,
            'updated_at'=>$now,
        ]);

        // Cart
        $cartId = DB::table('carts')->insertGetId(['user_id'=>$buyerId,'session_token'=>null,'created_at'=>$now,'updated_at'=>$now]);

        // Orders: one paid (2 days ago) and one pending (yesterday)
        $order1 = DB::table('orders')->insertGetId([
            'user_id'=>$buyerId,
            'cart_id'=>$cartId,
            'order_number'=>'ORD-1001',
            'subtotal'=>250.00,
            'shipping_fee'=>0.00,
            'total'=>250.00,
            'currency'=>'KHR',
            'status'=>'paid',
            'payment_method'=>'test',
            'payment_ref'=>'REF123',
            'shipping_name'=>'Buyer One',
            'shipping_phone'=>'012345678',
            'shipping_address'=>'Phnom Penh, Cambodia',
            'created_at'=>Carbon::now()->subDays(2),
            'updated_at'=>$now,
        ]);

        $order2 = DB::table('orders')->insertGetId([
            'user_id'=>$buyerId,
            'cart_id'=>$cartId,
            'order_number'=>'ORD-1002',
            'subtotal'=>5.00,
            'shipping_fee'=>0.00,
            'total'=>5.00,
            'currency'=>'KHR',
            'status'=>'pending',
            'shipping_name'=>'Buyer One',
            'shipping_phone'=>'012345678',
            'shipping_address'=>'Phnom Penh, Cambodia',
            'created_at'=>Carbon::now()->subDay(),
            'updated_at'=>$now,
        ]);

        // Order items
        DB::table('order_items')->insert([
            ['order_id'=>$order1,'product_id'=>$p1,'name'=>'Phone Model X','quantity'=>1,'unit_price'=>250.00,'line_total'=>250.00,'created_at'=>$now,'updated_at'=>$now],
            ['order_id'=>$order2,'product_id'=>$p1,'name'=>'Coffee Mug','quantity'=>1,'unit_price'=>5.00,'line_total'=>5.00,'created_at'=>$now,'updated_at'=>$now]
        ]);

        // Payment for order1
        DB::table('payments')->insert([
            'order_id'=>$order1,
            'amount'=>250.00,
            'currency'=>'KHR',
            'status'=>'confirmed',
            'provider'=>'test',
            'provider_ref'=>'REF123',
            'created_at'=>$now,
            'updated_at'=>$now,
        ]);
    }
}

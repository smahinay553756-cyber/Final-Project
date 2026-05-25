<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $firstNames = ['Maria', 'Juan', 'Jose', 'Ana', 'Carlo', 'Rosa', 'Miguel', 'Liza', 'Ramon', 'Elena',
                       'Pedro', 'Gloria', 'Antonio', 'Luz', 'Eduardo', 'Carmen', 'Roberto', 'Nora', 'Fernando', 'Celia',
                       'Ricardo', 'Marites', 'Danilo', 'Rowena', 'Ernesto', 'Teresita', 'Alfredo', 'Maricel', 'Renato', 'Josefa',
                       'Rodrigo', 'Evelyn', 'Nestor', 'Cristina', 'Arnel', 'Sheila', 'Rodel', 'Jasmine', 'Marlon', 'Precious'];

        $lastNames  = ['Santos', 'Reyes', 'Cruz', 'Bautista', 'Ocampo', 'Garcia', 'Mendoza', 'Torres', 'Flores', 'Villanueva',
                       'Ramos', 'Aquino', 'DelaC ruz', 'Gonzales', 'Lopez', 'Hernandez', 'Perez', 'David', 'Castillo', 'Morales'];

        $medicines      = Medicine::where('status', 'active')->get();
        $paymentMethods = ['cash', 'card', 'gcash'];
        $staff          = User::where('role', 'staff')->where('approved', true)->first();

        $count = 0;

        foreach ($firstNames as $first) {
            foreach ($lastNames as $last) {
                if ($count >= 70) break 2;

                $name     = $first . ' ' . $last;
                $username = strtolower(str_replace(' ', '', $first)) . ($count + 1);
                $email    = strtolower(str_replace(' ', '', $first)) . '.' . strtolower(str_replace([' ', 'C '], ['', 'c'], $last)) . '.customer@gmail.com';

                if (User::where('email', $email)->orWhere('username', $username)->exists()) {
                    $count++;
                    continue;
                }

                // Random date before 5/11/2026
                $createdAt = Carbon::create(2026, 1, 1)->addDays(rand(0, 129));

                $customer = User::create([
                    'name'       => $name,
                    'username'   => $username,
                    'email'      => $email,
                    'password'   => Hash::make('password'),
                    'role'       => 'customer',
                    'phone'      => '0917' . str_pad($count + 1000000, 7, '0', STR_PAD_LEFT),
                    'address'    => 'Toril, Davao City',
                    'approved'   => true,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                // Create 1-3 random orders per customer
                $orderCount = rand(1, 3);
                for ($o = 0; $o < $orderCount; $o++) {
                    $isWalkin       = (bool) rand(0, 1);
                    $paymentMethod  = $paymentMethods[array_rand($paymentMethods)];
                    $paymentStatus  = 'paid';
                    $orderDate      = $createdAt->copy()->addDays(rand(0, 5));
                    $medicine       = $medicines->random();
                    $quantity       = rand(1, 5);
                    $subtotal       = $medicine->selling_price * $quantity;

                    $order = Order::create([
                        'user_id'               => $isWalkin ? null : $customer->id,
                        'order_number'          => 'ORD-' . strtoupper(Str::random(8)),
                        'total_amount'          => $subtotal,
                        'status'                => 'dispensed',
                        'payment_method'        => $paymentMethod,
                        'payment_status'        => $paymentStatus,
                        'is_walkin'             => $isWalkin,
                        'walkin_name'           => $isWalkin ? $name : null,
                        'dispensed_by'          => $staff?->id,
                        'dispensed_at'          => $orderDate,
                        'prescription_required' => $medicine->requires_prescription,
                        'created_at'            => $orderDate,
                        'updated_at'            => $orderDate,
                    ]);

                    OrderItem::create([
                        'order_id'    => $order->id,
                        'medicine_id' => $medicine->id,
                        'quantity'    => $quantity,
                        'unit_price'  => $medicine->selling_price,
                        'subtotal'    => $subtotal,
                        'created_at'  => $orderDate,
                        'updated_at'  => $orderDate,
                    ]);
                }

                $count++;
            }
        }
    }
}

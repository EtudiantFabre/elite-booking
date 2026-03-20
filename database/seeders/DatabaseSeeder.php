<?php

namespace Database\Seeders;

use App\Enums\BookingStatus;
use App\Enums\ChargeType;
use App\Enums\RoomStatus;
use App\Enums\Sex;
use App\Models\BedType;
use App\Models\Booking;
use App\Models\BookingChildren;
use App\Models\CancellationRule;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Facility;
use App\Models\MealPlan;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use App\Services\Permission\PermissionService;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $defaultRoles = ['admin', 'reception', 'manager'];
        array_map(fn($name) => Role::create(['name' => $name]), $defaultRoles);

        User::factory()->create([
            'first_name' => 'Rasoul',
            'last_name' => 'Zinati',
            'email' => 'test@example.com',
            'password' => bcrypt('1234'),
            'sex' => Sex::Male,
            'is_super_admin' => true,
        ]);

        $users = User::factory(100)->create();

        $users->each(fn($user) => $user->assignRole(fake()->randomElements($defaultRoles), mt_rand(1, 3)));

        PermissionService::syncBaseOnPolicies();

        $countries = Country::factory(50)->create();

        $bedTypes = [
            'Simple' => 1,
            'Standard' => 2,
            'King Size' => 2,
            'Royale' => 2
        ];

        $bedTypes = array_map(fn($name, $quantity) => BedType::create(['name' => $name, 'capacity' => $quantity]),
            array_keys($bedTypes), $bedTypes);

        $facilities = [
            'Salle de bain privée',
            'Télévision à écran plat',
            'Terrasse',
            'Wifi gratuit',
            'Articles de toilette gratuits',
            'Douche',
            'Toilettes',
            'Parquet',
            'Serviettes',
            'Shopping'
        ];

        $facilities = array_map(fn($name) => Facility::create([
            'name' => $name,
        ]), $facilities);

        $roomTypes = [
            'Chambre Simple',
            'Chambre Double',
            'Chambre Twin',
            'Chambre Triple',
            'Chambre Quadruple',
            'Chambre Familiale',
            'Chambre King',
            'Chambre Queen',
            'Studio',
            'Chambre Deluxe',
            'Chambre Supérieure',
            'Chambre Exécutive',
            'Suite Junior',
            'Suite',
            'Suite Présidentielle',
            'Chambres Communicantes',
            'Chambres Adjacentes',
            'Chambre Accessible',
            'Chambre Fumeur',
        ];

        $roomTypes = collect($roomTypes)->map(function ($name) {
            return RoomType::factory()->create(['name' => $name, 'slug' => \Str::slug($name)]);
        });

        $roomTypes->map(function ($roomType) use ($bedTypes, $facilities) {
            $roomType->bedTypes()->sync([fake()->randomElement($bedTypes)->id => ['quantity' => mt_rand(1, 2)]]);
            $roomType->facilities()->sync(fake()->randomElements($facilities, mt_rand(5, 10)));
        });

        $roomTypes->each(function ($roomType) {
            Room::factory(mt_rand(10, 30))->create(['room_type_id' => $roomType->id]);
        });


        $mealPlans = [
            ['code' => 'RO', 'name' => 'Hébergement seul', 'description' => 'Aucun repas inclus', 'adult_price' => 0, 'child_price' => 0, 'infant_price' => 0],
            ['code' => 'BB', 'name' => 'Petit-déjeuner inclus', 'description' => 'Petit-déjeuner inclus', 'adult_price' => 5000, 'child_price' => 3000, 'infant_price' => 0],
            ['code' => 'HB', 'name' => 'Demi-pension', 'description' => 'Petit-déjeuner + Dîner', 'adult_price' => 15000, 'child_price' => 10000, 'infant_price' => 0],
            ['code' => 'FB', 'name' => 'Pension complète', 'description' => 'Petit-déjeuner + Déjeuner + Dîner', 'adult_price' => 25000, 'child_price' => 15000, 'infant_price' => 5000],
            ['code' => 'AI', 'name' => 'Tout compris', 'description' => 'Tous les repas + boissons', 'adult_price' => 45000, 'child_price' => 30000, 'infant_price' => 10000]
        ];

        foreach ($mealPlans as $mealPlan) {
            MealPlan::create($mealPlan);
        }

        $cancellationRules = [
            [
                'min_days_before' => 0,
                'max_days_before' => 1,
                'penalty_percent' => 100,
                'description' => 'Aucun remboursement pour les annulations effectuées moins de 1 jour avant l\'arrivée',
            ],
            [
                'min_days_before' => 2,
                'max_days_before' => 3,
                'penalty_percent' => 50,
                'description' => 'Remboursement de 50 % pour les annulations effectuées 2 à 3 jours avant l\'arrivée',
            ],
            [
                'min_days_before' => 4,
                'max_days_before' => 7,
                'penalty_percent' => 25,
                'description' => 'Frais d\'annulation de 25 % pour les annulations effectuées 4 à 7 jours avant l\'arrivée',
            ],
            [
                'min_days_before' => 8,
                'max_days_before' => 999,
                'penalty_percent' => 0,
                'description' => 'Annulation gratuite pour les réservations annulées 8 jours ou plus avant l\'arrivée',
            ],
        ];

        foreach ($cancellationRules as $cancellationRule) {
            CancellationRule::create($cancellationRule);
        }

        $customers = Customer::factory(200)
            ->state(fn() => ['national_id' => $countries->random()->id])
            ->create();


        $roomTypes = $roomTypes->random(mt_rand(2, 5));
        $allRooms = Room::whereHas('type', function ($query) use ($roomTypes) {
            $query->whereIn('name', $roomTypes->map(fn($r) => $r->name)->toArray());
        })
            ->whereNot('status', RoomStatus::Maintenance)
            ->get();

        $rooms = Room::with('type')->whereNot('status', RoomStatus::Maintenance)->inRandomOrder()->limit(100)->get();

        $rooms = $rooms->concat($allRooms);

        $rooms->each(function ($room) use ($customers) {
            $customer = $customers->random(1)->first();

            $now = now();
            $booking = Booking::create([
                'customer_id' => $customer->id,
                'adults' => $room->type->max_adult,
                'children' => mt_rand(0, $room->type->max_children),
                'check_in' => $now->addDays(mt_rand(0, 30)),
                'check_out' => $now->clone()->addDays(mt_rand(1, 14)),
                'smoking_preference' => $room->smoking_preference,
                'status' => BookingStatus::RESERVED,
                'meal_plan_id' => 1,
            ]);

            $booking->rooms()->sync($room->id);

            $booking->statuses()->create([
                'status' => BookingStatus::PENDING,
            ]);

            $booking->statuses()->create([
                'status' => BookingStatus::RESERVED,
            ]);


            $mealPlanPrice = 0;
            $booking->charges()->create([
                'charge_type' => ChargeType::MEAL_PLAN,
                'amount' => $mealPlanPrice
            ]);

            $numberOfDays = $booking->check_in->diffInDays($booking->check_out);

            $roomsPrice = $room->type->price * $numberOfDays;
            $booking->charges()->create([
                'charge_type' => ChargeType::ROOM,
                'amount' => $roomsPrice,
            ]);

            $tax = ($roomsPrice + $mealPlanPrice) * config('hotel.tax_rate');
            $booking->charges()->create([
                'charge_type' => ChargeType::TAX,
                'amount' => $tax
            ]);

            BookingChildren::factory($booking->children)->create(['booking_id' => $booking->id]);

            $booking->update(['total_price' => $roomsPrice + $mealPlanPrice + $tax]);
        });
    }
}

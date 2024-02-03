<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class CreateAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = Client::create([
            'id' => Uuid::uuid4(),
            'name' => 'Joe',
            'email' => 'joe@j.com'
        ]);

        $account = Account::create([
            'id' => Uuid::uuid4(),
            'client_id' => $client->id,
            'balance' => 1000
        ]);

        $client = Client::create([
            'id' => Uuid::uuid4(),
            'name' => 'Jane',
            'email' => 'jane@j.com'
        ]);

        $account = Account::create([
            'id' => Uuid::uuid4(),
            'client_id' => $client->id,
            'balance' => 0
        ]);
    }
}

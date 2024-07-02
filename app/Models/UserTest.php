<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserTest extends Model
{
    use HasFactory;

//    protected $fillable = [
//        'name',
//        'email',
//        'password',
//    ];
    protected $guarded = [];
    protected $hidden = [
        'password'
    ];

    public static function create(array $data): UserTest
    {
        DB::table('user_tests')->insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'age' => $data['age'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return new UserTest(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'age' => $data['age'],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}

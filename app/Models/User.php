<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $email)
 * @method static find($id)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function getUserByEmail($email)
    {
        $user = User::where('email', $email)->first();
        if($user){
            return $user;
        }
        return null;
    }

    public function getAllUsers()
    {
        return User::orderBy('created_at','desc')->get()->map(function ($user){
            $name = explode(' ',$user->name);
            $last_name = array_pop($name);
            $first_name = implode(' ',$name);
            return (object)[
                'id' => $user->id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $user->email,
                'role' => $user->role,
            ];
        });
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

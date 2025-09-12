<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Enums\UserRole;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'photo',
        'nmc_number',
        'suspended_at',
        'phone',
        'address',
        'dob',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'role' => UserRole::class
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
     public function suspend()
    {
        $this->suspended_at = now();
        $this->save();
    }

    public function isSuspended()
    {
        return $this->suspended_at ? true : false ;

    }

    public function unsuspended()
    {
        $this->suspended_at = NULL;
        $this->save();
        
    }

     public function unreadMessages()
        {
            return $this->hasMany(ChatMessage::class, 'sender_id')
                ->where('receiver_id', auth()->id())
                ->whereNull('read_at');
        }

       public function lastConversationMessage()
            {
                return $this->hasOne(ChatMessage::class, 'sender_id')
                    ->where('receiver_id', auth()->id())
                    ->orWhere(function($query) {
                        $query->where('sender_id', auth()->id())
                            ->where('receiver_id', $this->id);
                    })
                    ->latest()
                    ->limit(1);
            }


            // In User.php model
public function purchases()
{
    return $this->hasMany(Purchase::class);
}
            // In User.php

}

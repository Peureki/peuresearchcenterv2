<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_key',
        'checklist',
        'includes',
        'filter_research_notes',
        'settings_buy_order',
        'settings_sell_order',
        'settings_tax',
        'favorites',
        'filters',
        'theme',
        'achievements',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_key',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'achievements' => 'array',
        'email_verified_at' => 'datetime',
        'checklist' => 'array',
        'includes' => 'array',
        'filter_research_notes' => 'array',
        'favorites' => 'array',
        'filters' => 'array',
    ];

    // *
    // * ADDITIONAL ATTRIBUTES
    // *
    // api_key is private, but sometimes I need to know if the user has an api key saved
    protected $appends = ['has_api_key'];

    public function getHasApiKeyAttribute(){
        return !empty($this->api_key);
    }
}

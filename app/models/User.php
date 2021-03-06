<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * The attributes fillable for mass assignment protection.
     *
     * @var array
     */
    protected $fillable = ['username', 'email'];

    /**
    * Validation rules
    *
    * @var array
    */
    public static $rules = [
        'save' => [
            'username' => 'required|between:4,16',
            'email' => 'required|email',
            'password' => 'required|alpha_num|min:8|confirmed'            
        ],
        'create' => [
            'username' => 'required|between:4,16|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|alpha_num|min:8|confirmed',
            'password_confirmation' => 'required|alpha_num|min:8'
        ],
        'update' => []        
    ];    

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
    	return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
    	return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
    	return $this->email;
    }

    /**
     * Force hashing of the password on save and/or create
     *
     * @param $value string
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        //make sure not to double hash in case allready hashed
        if ( ! Hash::needsRehash($value)) {
            $this->attributes['password'] = Hash::make($value);    
        }        
    }

}

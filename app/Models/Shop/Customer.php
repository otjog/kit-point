<?php

namespace App\Models\Shop;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use App\Facades\GlobalData;
use Illuminate\Support\Facades\Auth;

class Customer extends Authenticatable{

    use Notifiable;

    protected $table = 'shop_customers';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'customer_group_id',
        'address',
        'full_name_json',
        'address_json',
        'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function customer_group()
    {
        return $this->belongsTo(    'App\Models\Shop\CustomerGroup', 'customer_group_id');
    }

    public function shopOrders()
    {
        return $this->hasMany('App\Order');
    }

    public function storeCustomer($data)
    {
        $data_customer = $this->prepareData($data);

        return self::create($data_customer);
    }

    public function updateCustomer(){

    }

    public function findOrCreateCustomer($data)
    {
        $email = $data['email'];

        $customer = $this->getCustomerByEmail($email);

        if( isset( $customer[0] ) ){
            return $customer[0];
        }else{
            return $this->storeCustomer($data);
        }

    }

    public function getAuthCustomer($data)
    {
        $customer = Auth::user();

        if($customer === null)
            return $this->findOrCreateCustomer($data);
        else
            return $customer;
    }

    public function getCustomerByEmail($email)
    {
        return self::select(
            'id',
            'full_name',
            'email',
            'phone',
            'address',
            'full_name_json',
            'address_json'
        )
            ->where('email', $email)
            ->get();
    }

    public function prepareData($data)
    {
        $data_customer = [];

        foreach( $data as $key => $value ){
            switch($key){
                case 'full_name' :
                case 'email' :
                case 'phone' :
                case 'address' :
                case 'address_json' :
                case 'full_name_json' :
                    $data_customer[$key] = $value;
                    break;
                case 'password' :
                    $data_customer[$key] = Hash::make($data['password']);
                    break;
            }
        }

        $data_customer['customer_group_id'] = GlobalData::getParameter('components.shop.default_customer_group.id');

        if(!isset($data_customer['password']))
            $data_customer['password'] = Hash::make($this->getRandomPassword());

        return $data_customer;
    }

    private function getRandomPassword()
    {
        $passwordSymbols = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP!@#$%^&*()_+!";

        $passwordLength = 10;

        $passwordSymbolsLength = StrLen($passwordSymbols)-1;

        $password = null;

        while($passwordLength--)
            $password .= $passwordSymbols[rand(0, $passwordSymbolsLength)];

        return $password;
    }

}

 <p align="center">
<a href="https://github.com/sammyfort/fortphp"><img src="https://img.shields.io/badge/%3C%2F%3E-PHP%20-blue" alt="Build Status"></a>
<a href="https://packagist.org/packages/fort/php"> <img alt="Packagist Version (custom server)" src="https://img.shields.io/packagist/v/fort/php"></a>
<img alt="Packagist Downloads (custom server)" src="https://img.shields.io/packagist/dt/fort/php">

<img alt="GitHub" src="https://img.shields.io/github/license/sammyfort/FortPHP">
</p>

## Installation

install with composer

```bash
  composer require fort/php
```

# Available PHP Functions

## Table of Content

* [Database](#Database)
    * [Connect](#test-db-connection)
    * [Insert](#insert-record)
    * [Update](#update-record)
    * [Transactions](#Transactions)
    * [Queries](#Queries)
    * [Where](#Where)
    * [All](#all)
    * [Sum](#Count)
    * [Max](#Max)
    * [Min](#Min)
    * [First](#First)
    * [orWhere](#orWhere)


* [Http Requests](#http-requests)
    * [Post Request](#post-request)
    * [Get Request](#get-request)
    * [Put / Patch Request](#putpatch-request)
    * [Delete Request](#delete-request)
    * [Multipart Request](#postmultipart-request)


* [String](#string-helpers)
    * [Str valueExist](#str-valueexist)
    * [Str contains](#str-contains)
    * [Str between](#str-between)
    * [Str after](#str-after)
    * [Str afterLast](#str-afterlast)
    * [Str before](#str-before)
    * [Str beforeLast](#str-beforelast)


* [Array](#array-helpers)
    * [Arr Maximum](#arr-maximum)
    * [Arr Minimum](#arr-minimum)
    * [Arr valueExist](#arr-valueexist)
    * [Arr Accessible](#arr-accessible)
    * [Arr Where](#arr-where)
    * [Arr First](#arr-first)
    * [Arr Last](#arr-last)
    * [Arr Wrap](#arr-wrap)
  
  
* [SMS](#sms)
    * [sendSMS](#send-sms)


* [Math](#math-helpers)
    * [Percentage](#Percentage)
    * [Exponential](#Exponential)
    * [Square Root](#SquareRoot)
    * [Maximum](#Maximum)
    * [Minimum](#Minimum)
    * [Sum](#Summation)
    * [Sub](#subtraction)
    * [Divide](#Division)
    * [Multiply](#Multiplication)

### Database

To start using the database support, you must create a `.env` file just in the root directory of your project and set
your database credentials like below

``` dotenv
DB_DATABASE=fort_project
DB_PORT=3306
DB_HOST=localhost
DB_USER=sam
DB_PASSWORD=sammyabc
```

Add the below codes in your index.php or entry point of your application;

```php
<?php
require_once __DIR__ . "/vendor/autoload.php";
\Dotenv\Dotenv::createImmutable(__DIR__)->load();
 

```

### Test DB connection

```php
<?php
use Fort\PHP\Support\DB;

DB::connect();

// PDO Objected connected
```

### Insert Record

```php
<?php
use Fort\PHP\Support\DB;
use Carbon\Carbon;

DB::insert('users', [
 'name'=> 'Phil Everette',
 'email'=> 'pever@example.com',
 'phone'=> '0205550368',
 'created_at'=> Carbon::now() // fort/php already ships with carbon
]);

// @return (bool) true, false otherwise
```

### Update Record

```php
<?php
use Fort\PHP\Support\DB;
use Carbon\Carbon;

DB::update('users', 1, [
 'name'=> 'Sam Everette',
 'email'=> 'pever@example.com',
 'phone'=> '0205550368',
 'created_at'=> Carbon::now()  
]);

// 1 is the id of the record to update
// @return (bool) true, false otherwise
```

### Transactions

```php
<?php
use Fort\PHP\Support\DB;
 

public function createInvoice(){
  try {
  DB::beginTransaction();
  //start some database queries
  DB::commit();
  // commit the queries
 }
 
 catch (Exception $exception){
   DB::rollBack();
  // rollback the transaction in case of error
 }
}
```

### Queries

```php
<?php
use Fort\PHP\Support\DB;

$unpaidOrders = DB::table('orders')
  ->where('payment_status', '=', 'unpaid')
  ->orderBy('id', 'desc')
  ->get();
  
foreach ($unpaidOrders as $item){
  echo  $item['amount'];
}
```

### Raw Queries

```php
<?php
use Fort\PHP\Support\DB;

$items = DB::rawQuery("SELECT users.id FROM users, 
 INNER JOIN orders ON users.id = orders.user_id")->get();
  
foreach ($items as $item){
 // echo ... ;
}
```

### Select

```php
<?php
use Fort\PHP\Support\DB;

$adult = DB::table('users')
  ->select(['name', 'age'])
  ->where('age', '>', 18)
  ->orderBy('id', 'desc')
  ->get();
  
foreach ($adult as $individual){
  echo  $individual['age'];
}
```

### All

```php
<?php
use Fort\PHP\Support\DB;

DB::table('invoices')->all();
// @returns all invoices
```

### First

```php
<?php
use Fort\PHP\Support\DB;

DB::table('users')->where('email', '=','sam@example.com')->first();
// @returns the record in the query set
```

### Where

```php
<?php
use Fort\PHP\Support\DB;

DB::table('invoices')->where('amount_paid', '<', 1)->get();
```

### OrWhere

```php
<?php
use Fort\PHP\Support\DB;

DB::table('invoices')->where('amount_paid', '<', 1)
  ->orWhere('amount_paid', '=', false)
  ->get();
```

### Sum

```php
<?php
use Fort\PHP\Support\DB;

DB::table('invoices')->sum('amount_paid');
// @returns (int|float) a sum of the specified column

```

### Count

```php
<?php
use Fort\PHP\Support\DB;

  DB::table('orders')->count();
  // @returns total number of orders
```

### Max

```php
<?php
use Fort\PHP\Support\DB;

DB::table('invoices')->max('amount');
// @returns (int|float) the highest number in the column

```

### Min

```php
<?php
use Fort\PHP\Support\DB;

DB::table('invoices')->min('amount');
// @returns (int|float) the smallest number in the column

```

## Http Requests

### Post Request

```php
<?php
 use Fort\PHP\Support\Http;
 
 Http::post('https://api.velstack.com/send',[$data],
            ["Accept: application/json", "Authorization: Bearer API_KEY"]);

```

### Get Request

```php
<?php
 use Fort\PHP\Support\Http;
 
 Http::get('https://api.velstack.com/resource', 
            ["Accept: application/json", "Authorization: Bearer API_KEY}"],
            ['timeout'=> 20, 'return_transfer'=> true, 'maxredirs'=> 10, 'encoding'=> ""]);

```

### Put/Patch Request

```php
<?php
 use Fort\PHP\Support\Http;
 
 Http::put('https://api.velstack.com/resource', [$data],
            ["Accept: application/json", "Authorization: Bearer API_KEY}"]);

```

### Delete Request

```php
<?php
 use Fort\PHP\Support\Http;
 
 Http::delete('https://api.velstack.com/resource', 
            ["Accept: application/json", "Authorization: Bearer API_KEY}"]);

```

### PostMultipart Request

```php
<?php
 use Fort\PHP\Support\Http;
 
 Http::asPostMultipart('https://api.velstack.com/send', [$data],
             "Authorization: Bearer API_KEY");

```

## String Helpers

### Str valueExist

 ```php
<?php
 use Fort\PHP\Str;

 $haystack = array('Fort', 'Everette', 'Mike');
 // returns true if the needle exist in case insensitive, false otherwise
 Str::valueExist($haystack, 'foRT');
  // true
```

### Str contains

 ```php
<?php
 use Fort\PHP\Str;

$slice = Str::contains('I was raised in Ghana', 'Ghana');
// 'true'

```

### Str after

 ```php
<?php
 use Fort\PHP\Str;

$slice = Str::after('His name is fort', 'His name');
// ' is fort'

```

### Str afterLast

 ```php
<?php
 use Fort\PHP\Str;

 $slice = Str::afterLast('App\Http\Controllers\Controller', '\\');
 // 'Controller'

```

### Str before

 ```php
<?php
 use Fort\PHP\Str;

$slice = Str::before('He is married', 'married');
// 'He is'

```

### Str beforeLast

 ```php
<?php
 use Fort\PHP\Str;

$slice = Str::beforeLast('He is married', 'is');
// 'He'

```

### Str between

 ```php
<?php
 use Fort\PHP\Str;

$slice = Str::between('He was born in March', 'He', 'March');
// 'was born in'

```

## Array Helpers

### Arr Maximum

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['Fort'=> 3, 'Phil'=> 0, 'Ever'=> 1];

print_r(Arr::maximum($array));

// Fort
```

### Arr Minimum

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['Fort'=> 3, 'Phil'=> 1, 'Ever'=> 0];

print_r(Arr::minimum($array));

// Ever
```

### Arr valueExist

Checks in an array if the `needle` exist in the array in case-insensitive manner. @returns true if the needle exist,
false otherwise.

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['Fort', 'Phil', 'Ever'];

 print_r(Arr::valueExist($array, 'FORT'));

// true
```

### Arr accessible

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['Fort' => 1, 'Phil'=> 2, 'Ever' => 3];

 print_r(Arr::accessible($array));

// true

$array = "fort";

 print_r(Arr::accessible($array));

// false
```

### Arr where

```php
<?php
 use Fort\PHP\Arr;
 
$array = [100, '200', '300', '400', '500'];
 
$filtered = Arr::where($array, function ($value, $key) {
    return is_numeric($value);
});
 
// [0 => '100']
```

### Arr first

```php
<?php
 use Fort\PHP\Arr;
 
$array = [1, 15, 35];
 
$first = Arr::first($array, function ($value, $key) {
    return $value >= 20;
});
 
// 35
```

### Arr last

```php
<?php
 use Fort\PHP\Arr;
 
$array = [1, 15, 35, 40];
 
$first = Arr::last($array, function ($value, $key) {
    return $value >= 40;
});
 
// 40
 
 
```

### Arr wrap

```php
<?php
 use Fort\PHP\Arr;
 
$string = 'PHP is fun';
 
$array = Arr::wrap($string);
 
// ['PHP is fun']
```

## SMS
To start using the SMS support, you must set the following variables in your `.env`  file.
The `SMS_DRIVER` can only be set to  [`velstack`](https://sms.velstack.com) or [`vonage`](https://vonage.com).
These are the supported drivers.

``` dotenv
SMS_DRIVER=velstack
SMS_API_KEY=sk_test__
SMS_SECRET_KEY=
SMS_SENDER_ID=BUSINESS
```
### Send SMS

```php
<?php
 use Fort\PHP\Support\SMS;
 
 return SMS::send('+233205550368', 'Hello, API messaging is just awesome');
```



## Math Helpers

### Percentage

```php
<?php
 use Fort\PHP\Math;
 
 Math::percentage(1.5, 200);
 // 3

```

### Exponential

```php
<?php
 use Fort\PHP\Math;
 
 Math::expo(2, 2);
 // 4
```

### SquareRoot

```php
<?php
 use Fort\PHP\Math;
 
 Math::sqrRoot(20);
  // 4.4721359549996
```

### Summation

```php
<?php
 use Fort\PHP\Math;
 
 Math::sum(11, 11);
 // 22
```

### Subtraction

```php
<?php
 use Fort\PHP\Math;
 
 Math::sub(10, 11);
 // -1
```

### Subtraction

```php
<?php
 use Fort\PHP\Math;
 
 Math::div(19, 5);
 // 3.8
```

### Subtraction

```php
<?php
 use Fort\PHP\Math;
 
 Math::mul(21, 8);
 // 168
```

### Maximum

```php
<?php
 use Fort\PHP\Math;
 
 Math::max(2, 6, 4);
 // 6
```

### Minimum

```php
<?php
 use Fort\PHP\Math;
 
 Math::min(2, 6, 4);
 // 2

```

#### Make sure model uses the `DateFilters` trait

```php
 

namespace App\Models;

use Fort\Illuminate\Support\Eloquent\DateFilters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory, DateFilters;
     

    protected $table = 'invoices';

     protected $fillable = [
        'user_id',
        'invoice_id',
        'customer',
        'shipping' ,
    ];

      
}

```

#### Once the `DateFilters` has been implemented in your model, you may access them in your controller like below

```php
 
namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
 

class InvoiceController extends Controller
{
 

    public function getTodayInvoices()
    {

        return Invoice::today()->get();
        
        // all invoices created today
    }
    
    public function yesterday()
    {

        return Invoice::yesterday()->sum('amount');
        // sums yesterday invoices amount
    }
    
     public function week()
     {

        return Invoice::Last7Days()->get();
        // returns invoices of the last 7 days
    }
    
    
       public function two_weeks()
     {

        return Invoice::QuarterToDate()->get();
        // returns all invoices from last two weeks
    }
    
     public function this_month()
     {

        return Invoice::MonthToDate()->sum('amount');
        // returns invoices from the start of the current month 
    }
    
    public function last30days()
     {

        return Invoice::Last30Days()->get();
         // returns invoices created in the last 30 days.
     }
    
   
    
    public function this_year()
     {

        return Invoice::YearToDate()->get();
        // returns all invoices from the start of the year
    }
    
    
      public function last_year()
     {

        return Invoice::LastYear()->get();
        // returns all invoices from last year
    }
    
    
       public function last_quater()
     {

        return Invoice::LastQuarter()->get();
        // returns all invoices from last 3 months
    }  
}
 
```

 
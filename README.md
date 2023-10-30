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

Add the below codes in your index.php or entry point of your application;

```php
<?php
require_once __DIR__ . "/vendor/autoload.php";
\Dotenv\Dotenv::createImmutable(__DIR__)->load();
 

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
    * [Str containsAll](#str-containsall)
    * [Str after](#str-after)
    * [Str afterLast](#str-afterlast)
    * [Str before](#str-before)
    * [Str beforeLast](#str-beforelast)
    * [Str between](#str-between)
    * [Str replace](#str-replace)
    * [Str charAt](#str-charat)
    * [Str endsWith](#str-endswith)
    * [Str finish](#str-finish)
    * [Str is](#str-is)
    * [Str length](#str-length)
    * [Str words](#str-words)
    * [Str wordCount](#str-wordcount)
    * [Str limit](#str-limit)
    * [Str padBoth](#str-padboth)
    * [Str padLeft](#str-padleft)
    * [Str padRight](#str-padright)
    * [Str random](#str-random)
    * [Str uuid](#str-uuid)
    * [Str isAscii](#str-isascii)
    * [Str isUuid](#str-isuuid)
    * [Str upper](#str-upper)
    * [Str lower](#str-lower)
    * [Str title](#str-title)
    * [Str slug](#str-slug)
    * [Str snake](#str-snake)
    * [Str studly](#str-studly)
    * [Str kebab](#str-kebab)
    * [Str mask](#str-mask)
    * [Str start](#str-start)
    * [Str reverse](#str-reverse)
    * [Str substr](#str-substr)
    * [Str substrCount](#str-substrcount)
    * [Str substrReplace](#str-substrreplace)
    * [Str replaceFirst](#str-replacefirst)
    * [Str replaceLast](#str-replacelast)
    * [Str lcfirst](#str-lcfirst)
    * [Str ucfirst](#str-ucfirst)


* [Array](#array-helpers)
    * [Arr Maximum](#arr-maximum)
    * [Arr Minimum](#arr-minimum)
    * [Arr valueExist](#arr-valueexist)
    * [Arr Accessible](#arr-accessible)
    * [Arr Where](#arr-where)
    * [Arr First](#arr-first)
    * [Arr Last](#arr-last)
    * [Arr Wrap](#arr-wrap)
    * [Arr Add](#arr-add)
    * [Arr Set](#arr-set)
    * [Arr Shuffle](#arr-shuffle)
    * [Arr Collapse](#arr-collapse)
    * [Arr Divide](#arr-divide)
    * [Arr Except](#arr-except)
    * [Arr Exists](#arr-exists)
    * [Arr Flatten](#arr-flatten)
    * [Arr Forget](#arr-forget)
    * [Arr Get](#arr-get)
    * [Arr Has](#arr-has)
    * [Arr hasAny](#arr-hasany)
    * [Arr isAssoc](#arr-isassoc)
    * [Arr Prepend](#arr-prepend)
    * [Arr PLuck](#arr-pluck)
    * [Arr Pull](#arr-pull)
    * [Arr Query](#arr-query)
    * [Arr Random](#arr-random)

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

### Test DB connection
Test if the databases was successfully connected
```php
<?php
use Fort\PHP\Support\DB;

DB::connect();

// PDO Object: connected
```

### Insert Record
Insert or create a new record in your database
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
Update a specific record in your database.
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
Start database transactions.
```php
<?php
use Fort\PHP\Support\DB;
 

public function createInvoice()
{
  try
   {
  DB::beginTransaction();
  //start some database queries
  DB::commit();
  // commit the queries
 }
 
 catch (Exception $exception)
 {
   DB::rollBack();
  // rollback the transaction in case of error
 }
}
```

### Queries
Run queries to your database.
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

 $haystack = array('Transporter', 'Everette', 'Mike');
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

### Str containsAll

 ```php
<?php
 use Fort\PHP\Str;

$string = Str::containsAll('My dad is from UK but i live in the US', ['UK', 'US']);

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

### Str replace

 ```php
<?php
 use Fort\PHP\Str;
 
 
$string = 'Transporter is a brilliant !';
 
$replaced = Str::replace('brilliant', 'genius', $string);
 
// Transporter is a genius !

```

### Str charAt

 ```php
<?php
 use Fort\PHP\Str;
 
 
$string = 'Transporter !';
 
$char = Str::charAt($string, 3);
 
// t

```

### Str endsWith

 ```php
<?php
 use Fort\PHP\Str;
 
 
$string = 'Everette is 1 year old';
 
$string = Str::endsWith($string, 'old');
 
// true

```

### Str finish

 ```php
<?php
 use Fort\PHP\Str;
 
 
$string = 'Everette is 1 year old';
 
$string = Str::finish($string, '!');
 
// Everette is 1 year old!
```

### Str is

The Str::is method determines if a given string matches a given pattern. Asterisks may be used as wildcard values:

 ```php
<?php
 use Fort\PHP\Str;
 
 
$matches = Str::is('foo*', 'foobar');
 
// true
 
$matches = Str::is('baz*', 'foobar');
 
// false

```

### Str isUuid

 ```php
<?php
 use Fort\PHP\Str;
 
 
$isUuid = Str::isUuid('a0a2a2d2-0b87-4a18-83f2-2529882be2de');
 
// true
 
$isUuid = Str::isUuid('laravel');
 
// false

```

### Str length

 ```php
<?php
 use Fort\PHP\Str;
 
 
$isUuid = Str::length('Velstack');
 
// 8

```

### Str words

 ```php
<?php
 use Fort\PHP\Str;
 
  Str::words('Though he came, he could not make it.', 3, ' >>>');
 
// Though he came, >>>

```

### Str wordCount

 ```php
<?php
 use Fort\PHP\Str;
 
  Str::words('He was born in July');
 
// 5

```

### Str limit

 ```php
<?php
 use Fort\PHP\Str;
 
 
$truncated = Str::limit('He is a good man', 4, ' ...');
 
// He is ...

```

### Str padBoth

 ```php
<?php
 use Fort\PHP\Str;
 
$padded = Str::padBoth('sammy', 10, '_');
 
// 'sammy'
 
$padded = Str::padBoth('James', 10);
 
// '  sammy   '
```

### Str padLeft

 ```php
<?php
 use Fort\PHP\Str;
 
 
$padded = Str::padLeft('sammy', 6, '@');
 
// @sammy'
 
$padded = Str::padLeft('sammy', 6);
 
// '    sammy'
```

### Str padRight

 ```php
<?php
 use Fort\PHP\Str;
 
 $padded = Str::padRight('sammy', 10, '-');
 
// 'sammy-----'
 
$padded = Str::padRight('sammy', 10);
 
// 'sammy     '
```

### Str random

 ```php
<?php
 use Fort\PHP\Str;
 
$random = Str::random(5);

// 3Cewm
```

### Str uuid

 ```php
<?php
 use Fort\PHP\Str;
 
$output = Str::uuid();

// a0a2a2d2-0b87-4a18-83f2-2529882be2de
 
 
```

### Str isAscii

 ```php
<?php
 use Fort\PHP\Str;
 
$isAscii = Str::isAscii('Accra');
 
// true
 
$isAscii = Str::isAscii('ü');
 
// false
 
```

### Str isUuid

 ```php
<?php
 use Fort\PHP\Str;
 
$string = Str::isUuid('a0a2a2d2-0b87-4a18-83f2-2529882be2de');
 
// true
 
$string = Str::isUuid('Accra');
 
// false
 
```

### Str upper

 ```php
<?php
 use Fort\PHP\Str;
 
 
$converted = Str::upper('fort');
 
// FORT
```

### Str lower

 ```php
<?php
 use Fort\PHP\Str;
 
 
$converted = Str::lower('FORT');
 
// fort
```

### Str title

 ```php
<?php
 use Fort\PHP\Str;
 
 
$converted = Str::title('how to make money from home');
 
// How To Make Money From Home
```

### Str slug

 ```php
<?php
 use Fort\PHP\Str;
 
 
$converted = Str::slug('how to make money from home','-');
 
// How-To-Make-Money-From-Home
```

### Str snake

 ```php
<?php
 use Fort\PHP\Str;
 
 
$output = Str::snake('FootBall', '_');
 
// Foot_Ball
```

### Str studly

 ```php
<?php
 use Fort\PHP\Str;
 
 $output = Str::studly('foo_bar');
 
// FooBar
```

### Str kebab

 ```php
<?php
 use Fort\PHP\Str;
 
 
$output = Str::kebab('fooBar');
 
// foo-bar
```

### Str mask

 ```php
<?php
 use Fort\PHP\Str;
 
 
$string = Str::mask('samuelfort@example.com', '*', -15, 3);
 
// sam***@example.com
```

### Str start

The Str::start method adds a single instance of the given value to a string if it does not already start with that
value:

 ```php
<?php
 use Fort\PHP\Str;
 
$adjusted = Str::start('sammy_fort', '@');
 
// @sammy_fort
 
$adjusted = Str::start('@fortameyaw', '@');
 
// @fortameyaw
```

### Str reverse

 ```php
<?php
 use Fort\PHP\Str;
 
$reversed = Str::reverse('Hello');
 
// olleH
```

### Str substr

 ```php
<?php
 use Fort\PHP\Str;
 
 
$converted = Str::substr('The Symfony PHP Framework', 4, 7);
 
// Laravel
```

### Str substrCount

 ```php
<?php
 use Fort\PHP\Str;
 
$count = Str::substrCount('If you like ice cream, you will like snow cones.', 'like');
 
// 2
```

### Str substrReplace

 ```php
<?php
 use Fort\PHP\Str;
 
$result = Str::substrReplace('1300', ':', 2);
// 13:
 
$result = Str::substrReplace('1300', ':', 2, 0);
// 13:00
```

### Str replaceFirst

 ```php
<?php
 use Fort\PHP\Str;
 
$string  = 'He is lazy';

$output = Str::replaceFirst('He', 'Tom', $string);
 
// Tom is lazy
```

### Str replaceLast

 ```php
<?php
 use Fort\PHP\Str;
 
$string  = 'Kwaku is a handsome boy';

$output = Str::replaceLast('a', 'the', $string);
 
// Kwaku is the handsome boy
```

### Str lcfirst

 ```php
<?php
 use Fort\PHP\Str;
 
$output = Str::lcfirst('Handsome');
 
// handsome
```

### Str ucfirst

 ```php
<?php
 use Fort\PHP\Str;
 
$output = Str::ucfirst('beautiful');
 
// Beautiful
```

## Array Helpers

### Arr Maximum

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['Transporter'=> 3, 'Phil'=> 0, 'Ever'=> 1];

print_r(Arr::maximum($array));

// Transporter
```

### Arr Minimum

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['Transporter'=> 3, 'Phil'=> 1, 'Ever'=> 0];

print_r(Arr::minimum($array));

// Ever
```

### Arr valueExist

Checks in an array if the `needle` exist in the array in case-insensitive manner. @returns true if the needle exist,
false otherwise.

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['Transporter', 'Phil', 'Ever'];

 print_r(Arr::valueExist($array, 'FORT'));

// true
```

### Arr accessible

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['Transporter' => 1, 'Phil'=> 2, 'Ever' => 3];

 print_r(Arr::accessible($array));

// true

$array = "fort";

 print_r(Arr::accessible($array));

// false
```

### Arr whereNotNull

```php
<?php
 use Fort\PHP\Arr;
 
$array = [0, null];
 
$filtered = Arr::whereNotNull($array);
 
// [0 => 0]
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

### Arr add

The Arr::shuffle method randomly shuffles the items in the array:

```php
<?php
 use Fort\PHP\Arr;
 
$array = Arr::add(['name' => 'Desk'], 'price', 100);
 
// ['name' => 'Desk', 'price' => 100]
 
$array = Arr::add(['name' => 'Desk', 'price' => null], 'price', 100);
 
// ['name' => 'Desk', 'price' => 100]
```

### Arr set

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['orders' => ['desk' => ['price' => 100]]];
 
Arr::set($array, 'orders.desk.price', 200);
 
// ['orders' => ['desk' => ['price' => 200]]]
```

### Arr shuffle

The Arr::shuffle method randomly shuffles the items in the array:

```php
<?php
 use Fort\PHP\Arr;
 
$array = Arr::shuffle([1, 2, 3, 4, 5]);
 
// [3, 2, 5, 1, 4] - (generated randomly)
```

### Arr collapse

```php
<?php
 use Fort\PHP\Arr;
$array = Arr::collapse([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);
 
// [1, 2, 3, 4, 5, 6, 7, 8, 9]
```

### Arr divide

The Arr::divide method returns two arrays: one containing the keys and the other containing the values of the given
array:

```php
<?php
 use Fort\PHP\Arr;
 
[$keys, $values] = Arr::divide(['name' => 'Desk']);
 
// $keys: ['name']
 
// $values: ['Desk']
```

### Arr except

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['name' => 'Desk', 'price' => 100];
 
$filtered = Arr::except($array, ['price']);
 
// ['name' => 'Desk']
```

### Arr exists

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['name' => 'Desk', 'price' => 100];
$array = ['name' => 'John Doe', 'age' => 17];
 
$exists = Arr::exists($array, 'name');
 
// true

$exists = Arr::exists($array, 'salary');
 
// false
```

### Arr flatten

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['name' => 'Joe', 'languages' => ['PHP', 'Ruby']];
 
$flattened = Arr::flatten($array);
 
// ['Joe', 'PHP', 'Ruby']
 
// false
```

### Arr forget

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['products' => ['desk' => ['price' => 100]]];
 
Arr::forget($array, 'products.desk');
 
// ['products' => []]
```

### Arr get

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['products' => ['desk' => ['price' => 100]]];
 
$price = Arr::get($array, 'products.desk.price');
 
// 100
```

### Arr has

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['product' => ['name' => 'Desk', 'price' => 100]];
 
$contains = Arr::has($array, 'product.name');
 
// true
 
$contains = Arr::has($array, ['product.price', 'product.discount']);
 
// false
```

### Arr hasAny

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['product' => ['name' => 'Desk', 'price' => 100]];
 
$contains = Arr::hasAny($array, 'product.name');
 
// true
 
$contains = Arr::hasAny($array, ['product.name', 'product.discount']);
 
// true
 
$contains = Arr::hasAny($array, ['category', 'product.discount']);
 
// false
```

### Arr isAssoc

```php
<?php
 use Fort\PHP\Arr;
 
$isAssoc = Arr::isAssoc(['product' => ['name' => 'Desk', 'price' => 100]]);
 
// true
 
$isAssoc = Arr::isAssoc([1, 2, 3]);
 
// false
```

### Arr prepend

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['one', 'two', 'three', 'four'];
 
$array = Arr::prepend($array, 'zero');
 
// ['zero', 'one', 'two', 'three', 'four']

$array = ['price' => 100];
 
$array = Arr::prepend($array, 'Desk', 'name');
 
// ['name' => 'Desk', 'price' => 100]
```

### Arr pluck

```php
<?php
 use Fort\PHP\Arr;
 
$array = [
    ['product' => ['id' => 1, 'name' => 'Drink']],
    ['product' => ['id' => 2, 'name' => 'Wheat']],
];
 
$names = Arr::pluck($array, 'product.name');
 
// ['Drink', 'Wheat']
```

### Arr only

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['name' => 'Desk', 'price' => 100, 'orders' => 10];
 
$slice = Arr::only($array, ['name', 'price']);
 
// ['name' => 'Desk', 'price' => 100]
```

### Arr pull

```php
<?php
 use Fort\PHP\Arr;
 
$array = ['name' => 'Desk', 'price' => 100];
 
$name = Arr::pull($array, 'name');
 
// $name: Desk
 
// $array: ['price' => 100]
```

### Arr query

```php
<?php
 use Fort\PHP\Arr;
 
$array = [
    'name' => 'Mike',
    'order' => [
        'column' => 'created_at',
        'direction' => 'desc'
    ]
];
 
 $q = Arr::query($array);
 
// name=Mike&order[column]=created_at&order[direction]=desc
```

### Arr random

```php
<?php
 use Fort\PHP\Arr;
 
$array = [1, 2, 3, 4, 5];
 
$random = Arr::random($array);
 
// 4 - (retrieved randomly)
```

## SMS

To start using the SMS support, you must set the following variables in your `.env`  file. The `SMS_DRIVER` can only be
set to  [`velstack`](https://sms.velstack.com) or [`vonage`](https://vonage.com). These are the supported drivers.

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

### Division

```php
<?php
 use Fort\PHP\Math;
 
 Math::div(19, 5);
 // 3.8
```

### Multiplication

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

 
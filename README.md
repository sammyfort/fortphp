 <p align="center">
<a href="https://github.com/sammyfort/fortphp"><img src="https://img.shields.io/badge/%3C%2F%3E-PHP%20-blue" alt="Build Status"></a>
<a href="https://packagist.org/packages/fort/php"> <img alt="Packagist Version (custom server)" src="https://img.shields.io/packagist/v/fort/php"></a>
<img alt="Packagist Downloads (custom server)" src="https://img.shields.io/packagist/dt/fort/php">

<img alt="GitHub" src="https://img.shields.io/github/license/sammyfort/FortPHP">


 

</p>
 

## PHP and Laravel Global Helpers.

## Installation

install with composer

```bash
  composer require fort/php
```

 
 
# Guides
### Laravel Eloquent Filtering by Date

#### Make sure model uses the `DateFilters`

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
# Standard

#### General php helpers
```php
class User{

 public function string()
  {
  
    return fort_random_string(32);
    // generate random string string with a length of 32     
  }
   

  
  public function addN()
  {
  
    return fort_sum(3, 7);
    // 10     
  }
  
  public function subtractN()
  {
  
    return fort_sub(4, 8);
    // -4     
  }
   
   public function mulN()
  {
  
    return fort_multiply(4, 8);
    // 32     
  }
  
     public function divN()
  {
  
    return fort_div(20, 2);
    // 10     
  }
  
   public function percentage()
  {
  
    return fort_percentage(1.5, 200);
    // 3    
  }
  
    public function squareRoot()
  {
  
    return fort_square_root_of(20);
    // 4.4721359549996 
  }
  
    public function exponential()
  {
  
    return fort_expo(2, 2);
    // 2 exponent 2
    // returns 4
  }
  
  
     public function maxValInArray()
  {
    $collection = ['first'=> 10, 'second'=> 20, 'third'=>30];
    return fort_max_array_value($collection);
   
    // returns 'third'
  }
  
  
       public function minValInArray()
  {
    $collection = ['everett'=> 1, 'phill'=> 2, 'fort'=>3];
    return fort_min_array_value($collection);
   
    // returns 'everett'
  }
  
  
         public function arrayInArrayValue()
  {
    $collection = [
    ['everett'=> 1, 'phill'=> 2, 'fort'=>3]
    ];
    return fortMaxArrayInArrayValue($collection,'everett');
   
    // returns 1
  }
   
}
 
```
 
 

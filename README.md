 <p align="center">
<a href="https://github.com/sammyfort/mNotify-laravel"><img src="https://img.shields.io/badge/%3C%2F%3E-PHP%20-blue" alt="Build Status"></a>
<a href="https://packagist.org/packages/velstack/mnotify"><img src="https://img.shields.io/github/license/sammyfort/mNotify-laravel"></a>

 

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
  
  public function usage()
  {
  
    return fort_sum(3, 7);
    // 10     
  }
   
}
 
```
 
 

## Laravel Validated API Requests

This package allows you to use Laravel's validators on API requests.
This package is intented to be used only on API requests as the same behaviour can be achieved for regular requests using Laravel's `FormRequest`.

### Installation
```sh
composer require nickfla1/laravel-validated-api-requests
```
**Requirements**

| Library/Ext | Version |
| --- | --- |
| php | >=7.0.* |
| laravel/framework | >=5.5 |

### Basic Usage

**Request**
```php
use Nickfla1\Utilities\ApiRequest;

class FooRequest extends ApiRequest
{
    /**
     * Defines if the request should fire an ApiRequestException
     * on validation failure.
     *
     * @var bool
     */
    protected $firesException = true;
    
    /**
     * Define validation rules.
     *
     * @return array|null
     */
    protected function rules()
    {
        return [
            'foo' => 'required|string|max:30',
            'bar' => 'required|mail'
        ];
    }
}
```

**Controller**
```php
class TheController extends Controller
{
    public function index(FooRequest $request)
    {
        // If we get here the request was validated successfully!
    }
}
```

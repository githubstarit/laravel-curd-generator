# Laravel Curd Generator

## Usage

### Step 1: Install Through Composer

```
composer require aiddroid/laravel-curd-generator:dev-master
```

### Step 2: Add the Service Provider

You'll only want to use these generators for local development, so you don't want to update the production  `providers` array in `config/app.php`. Instead, add the provider in `app/Providers/AppServiceProvider.php`, like so:

```php
public function register()
{
	if ($this->app->environment() == 'local') {
		$this->app->register('Aiddroid\Generators\GeneratorsServiceProvider');
	}
}
```


### Step 3: Run Artisan!

You're all set. Run `php artisan` from the console, and you'll see the new commands.

## Examples

- [Make CURD Controller](#make-curd-controller)
- [Make CURD View](#make-curd-view)

### Make CURD Controller
Make a controller for CURD
```
php artisan make:controller:curd CommentController --model='App\Models\Comment' --view=comment
```

#### Make CURD View
Make views for CURD

```
php artisan make:view:curd comment --table=comments
```

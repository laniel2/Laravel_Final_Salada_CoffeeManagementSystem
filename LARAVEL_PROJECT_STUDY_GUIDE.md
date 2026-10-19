# Coffee Shop Management System - Laravel Study Guide

## 1. Project Overview
This project is a Laravel CRUD application for managing a coffee shop business. It allows the admin to manage categories, products, customers, orders, and order items.

The project follows the standard Laravel MVC structure:
- Models handle database logic and relationships
- Controllers handle request handling and validation
- Views are Blade templates for the UI
- Routes define the application endpoints
- Migrations create the database tables
- Seeders and factories generate sample data

---

## 2. Project Purpose
The purpose of the app is to help a coffee shop manage:
- product categories
- menu items and stock
- customer records
- order tracking
- order details per product

This is a good example of a practical Laravel project because it combines database design, logic, HTML forms, and CRUD operations.

---

## 3. Main Features
### Categories
- Add a new category
- View all categories
- Edit category information
- Delete category

### Products
- Add products under categories
- Store name, description, price, and stock
- View and update product details

### Customers
- Add customer profiles
- Store email, phone, address
- View and update details

### Orders
- Create customer orders
- Add order date and status
- Track total amount

### Order Items
- Add multiple products to each order
- Store quantity, unit price, and subtotal
- Link each item to a product and order

---

## 4. Laravel Structure Used

### Routes
Routes are defined in:
- `routes/web.php`

The app uses resource routes like:
- `categories`
- `products`
- `customers`
- `orders`
- `order-items`

Example route definitions:
```php
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('customers', CustomerController::class);
Route::resource('orders', OrderController::class);
Route::resource('order-items', OrderItemController::class);
```

These automatically handle common CRUD routes such as:
- index
- create
- store
- show
- edit
- update
- destroy

---

### Controllers
Controllers are located in:
- `app/Http/Controllers/`

Main controllers:
- `CategoryController`
- `ProductController`
- `CustomerController`
- `OrderController`
- `OrderItemController`

Each controller:
- fetches records from the database
- validates request input
- creates, updates, or deletes records
- redirects to index pages with success or error messages

Example structure:
```php
public function index()
{
    $records = Category::latest()->paginate(10);
    return view('categories.index', compact('records'));
}
```

---

### Models
Models are in:
- `app/Models/`

Main models:
- `Category`
- `Product`
- `Customer`
- `Order`
- `OrderItem`

Each model defines:
- `$fillable` fields
- relationship methods

Example:
```php
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description', 'price', 'stock'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

---

## 5. Database Design

The database has 5 main tables:

### categories
```php
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->text('description')->nullable();
    $table->timestamps();
});
```

### products
```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2);
    $table->unsignedInteger('stock')->default(0);
    $table->timestamps();
    $table->unique(['category_id', 'name']);
});
```

### customers
```php
Schema::create('customers', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('phone', 30)->nullable();
    $table->text('address')->nullable();
    $table->timestamps();
});
```

### orders
```php
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('customer_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
    $table->dateTime('order_date');
    $table->enum('status', ['pending', 'preparing', 'completed', 'cancelled'])->default('pending');
    $table->decimal('total_amount', 10, 2)->default(0);
    $table->timestamps();
});
```

### order_items
```php
Schema::create('order_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
    $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
    $table->unsignedInteger('quantity');
    $table->decimal('unit_price', 10, 2);
    $table->decimal('subtotal', 10, 2);
    $table->timestamps();
    $table->unique(['order_id', 'product_id']);
});
```

---

## 6. Relationship Explanation

### One-to-Many
- One category has many products
```php
public function products()
{
    return $this->hasMany(Product::class);
}
```

- One customer has many orders
```php
public function orders()
{
    return $this->hasMany(Order::class);
}
```

- One order has many order items
```php
public function items()
{
    return $this->hasMany(OrderItem::class);
}
```

### Many-to-One / BelongsTo
- Product belongs to category
- Order belongs to customer
- Order item belongs to order
- Order item belongs to product

Example:
```php
public function product()
{
    return $this->belongsTo(Product::class);
}
```

---

## 7. Validation in Controllers
Validation is implemented in each controller using a `rules()` method.

Example from `ProductController`:
```php
private function rules($id = null): array
{
    return [
        'category_id' => 'required|exists:categories,id',
        'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')->where(fn ($query) => $query->where('category_id', request('category_id')))->ignore($id)],
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ];
}
```

This ensures:
- category must exist
- name is required
- price is numeric
- stock is non-negative
- product names must be unique per category

---

## 8. Blade Views and UI
The project uses Laravel Blade templates in:
- `resources/views/`

Important views:
- `dashboard.blade.php`
- `categories/index.blade.php`
- `products/form.blade.php`
- `customers/index.blade.php`
- `orders/index.blade.php`
- `order-items/index.blade.php`

The shared layout is:
- `resources/views/layouts/app.blade.php`

This layout includes:
- navigation bar
- Bootstrap CDN
- success/error alerts
- page content section

Example layout snippet:
```blade
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">☕ Coffee Shop Management System</a>
    </div>
</nav>
```

---

## 9. CRUD Flow
### Create
- User clicks Add button
- Controller method `create()` returns form view
- User submits form
- `store()` validates and saves data

### Read
- `index()` gets records from database
- Display list in a table
- Use pagination to split large results

### Update
- `edit()` loads the record
- User changes fields
- `update()` validates and saves updates

### Delete
- `destroy()` removes the record
- If the record is used elsewhere, Laravel may reject deletion and show an error message

---

## 10. Example of a Controller Workflow
```php
public function store(Request $request)
{
    $data = $request->validate($this->rules());
    Product::create($data);

    return redirect()->route('products.index')->with('success', 'Product created successfully.');
}
```

This shows the standard Laravel pattern:
1. receive request
2. validate
3. save to database
4. redirect with success message

---

## 11. Seeders and Factories
Seeders are used to populate the database with sample data.

The project uses:
- `DatabaseSeeder`
- specific seeders for categories, products, customers, orders, and order items

Example:
```php
$this->call([
    CategorySeeder::class,
    ProductSeeder::class,
    CustomerSeeder::class,
    OrderSeeder::class,
    OrderItemSeeder::class,
]);
```

Factories generate realistic fake data for testing and demonstration.

Example from `CategoryFactory`:
```php
return [
    'name' => fake()->unique()->words(2, true),
    'description' => fake()->sentence(),
];
```

---

## 12. Pagination
The app uses Laravel pagination for listing tables.

Example:
```blade
{{ $records->links('pagination::bootstrap-5') }}
```

This gives Bootstrap-style Previous and Next buttons.

---

## 13. Security and Good Practices Used
The project includes standard Laravel practices such as:
- `@csrf` in forms
- validation before saving data
- redirecting after actions
- using Eloquent models instead of raw SQL
- relationship-based querying

---

## 14. How to Run the Project
You can run:
```bash
php artisan migrate
php artisan db:seed
php artisan serve
```

Then open the app in the browser.

---

## 15. Common Instructor Questions and Answers

### Q: What is Laravel?
A: Laravel is a PHP framework used to build web applications using MVC architecture, routing, validation, Blade, and Eloquent ORM.

### Q: What is MVC?
A: Model-View-Controller. Models manage data, views display the UI, and controllers handle logic and requests.

### Q: What is Eloquent?
A: Eloquent is Laravel's ORM that lets you manage database tables as PHP objects and relationships.

### Q: Why are there migrations?
A: Migrations let you create and version database tables in a structured, repeatable way.

### Q: Why use seeders?
A: Seeders populate the database with sample data for testing and demo purposes.

### Q: What is a resource route?
A: A resource route automatically creates CRUD endpoints for a model.

### Q: How do you validate form data?
A: By using Laravel validation in the controller, usually through `$request->validate()`.

---

## 16. Final Short Presentation Script
> “This project is a Laravel-based coffee shop management system. It uses resource routes, Eloquent models, migrations, and Blade templates to manage categories, products, customers, orders, and order items. Each module supports CRUD operations, validation, and relationship-based data handling. The app uses Bootstrap for presentation and follows the MVC structure that Laravel is built around.”

---

## 17. Important Files to Review Before Presentation
- `routes/web.php`
- `app/Http/Controllers/CategoryController.php`
- `app/Http/Controllers/ProductController.php`
- `app/Http/Controllers/CustomerController.php`
- `app/Http/Controllers/OrderController.php`
- `app/Http/Controllers/OrderItemController.php`
- `app/Models/Category.php`
- `app/Models/Product.php`
- `app/Models/Customer.php`
- `app/Models/Order.php`
- `app/Models/OrderItem.php`
- `resources/views/layouts/app.blade.php`
- `resources/views/dashboard.blade.php`
- `database/migrations/`
- `database/seeders/DatabaseSeeder.php`

---

## 18. Final Tip
Before your presentation, be ready to explain:
- how the app is organized
- what each controller does
- what the database relationships are
- why validations matter
- how the UI is rendered using Blade
- how CRUD works in Laravel

Practice speaking clearly and simply. The instructor is usually looking for understanding of Laravel concepts, not just working code.

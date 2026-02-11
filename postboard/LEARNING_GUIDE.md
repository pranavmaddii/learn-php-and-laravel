# PostBoard Project - Complete Learning Reference

A comprehensive guide covering everything built in this Laravel project.

---

## Table of Contents

1. [Project Structure](#1-project-structure)
2. [Features Built](#2-features-built)
3. [MVC Flow](#3-the-mvc-flow)
4. [Key Laravel Concepts](#4-key-laravel-concepts)
5. [Common Artisan Commands](#5-common-artisan-commands)
6. [Common Errors & Solutions](#6-common-errors--solutions)
7. [Debugging Tips](#7-debugging-tips)
8. [New Project Skeleton](#8-new-project-skeleton-steps)
9. [What to Master Next](#9-what-to-master-next)
10. [Learning Resources](#10-learning-resources)

---

## 1. Project Structure

```
postboard/
├── app/
│   ├── Http/
│   │   └── Controllers/          <- Your logic lives here
│   │       ├── AuthController.php
│   │       ├── PostController.php
│   │       ├── CommentController.php
│   │       └── Api/
│   │           └── AuthController.php
│   └── Models/                   <- Database representations
│       ├── User.php
│       ├── Post.php
│       └── Comment.php
├── database/
│   └── migrations/               <- Database structure changes
├── resources/
│   └── views/                    <- HTML templates (Blade)
│       ├── layouts/
│       │   └── app.blade.php     <- Master template
│       ├── auth/
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   ├── forgot-password.blade.php
│       │   └── reset-password.blade.php
│       └── posts/
│           ├── index.blade.php
│           ├── show.blade.php
│           ├── create.blade.php
│           ├── edit.blade.php
│           ├── mine.blade.php
│           └── deleted.blade.php
├── routes/
│   ├── web.php                   <- Browser routes
│   └── api.php                   <- API routes (for mobile apps)
├── public/
│   └── storage/                  <- Uploaded files (symlink)
├── storage/
│   └── app/public/posts/         <- Actual uploaded images
└── config/
    └── sanctum.php               <- Sanctum configuration
```

---

## 2. Features Built

| Feature | Files Involved |
|---------|----------------|
| User Registration | `AuthController@register`, `register.blade.php`, `User` model |
| User Login (Email/Username) | `AuthController@login`, `login.blade.php` |
| Logout | `AuthController@logout` |
| Password Reset | `AuthController`, `forgot-password.blade.php`, `reset-password.blade.php` |
| Create Post | `PostController@store`, `create.blade.php` |
| View Posts | `PostController@index`, `index.blade.php` |
| View Single Post | `PostController@show`, `show.blade.php` |
| Edit Post | `PostController@edit/update`, `edit.blade.php` |
| Delete Post (Soft) | `PostController@destroy` |
| Restore Post | `PostController@restore` |
| My Posts | `PostController@myPosts`, `mine.blade.php` |
| Deleted Posts | `PostController@deleted`, `deleted.blade.php` |
| Comments | `CommentController@store`, form in `show.blade.php` |
| Likes (AJAX) | `PostController@toggleLike`, JavaScript in `show.blade.php` |
| Image Upload | `PostController@store`, file input in `create.blade.php` |
| Search | `PostController@index` with search query parameter |
| Dark Mode | JavaScript in `app.blade.php`, localStorage |
| API Authentication | `Api\AuthController`, Laravel Sanctum tokens |

---

## 3. The MVC Flow

How Laravel processes a request:

```
User Request -> Route -> Controller -> Model -> View -> Response
```

### Example: User visits /posts/5

**Step 1: Route (routes/web.php)**
```php
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
```

**Step 2: Controller (app/Http/Controllers/PostController.php)**
```php
public function show($id)
{
    $post = Post::with('user')->findOrFail($id);  // Talks to Model
    $comments = $post->comments()->with('user')->paginate(5);
    return view('posts.show', compact('post', 'comments'));  // Returns View
}
```

**Step 3: Model (app/Models/Post.php)**
- Fetches data from 'posts' table in database
- Uses relationships to get related data

**Step 4: View (resources/views/posts/show.blade.php)**
- Displays the data as HTML using Blade syntax

---

## 4. Key Laravel Concepts

### A. Routing (routes/web.php)

```php
// Basic GET route
Route::get('/posts', [PostController::class, 'index']);

// Route with parameter
Route::get('/posts/{id}', [PostController::class, 'show']);

// POST route (for forms)
Route::post('/posts', [PostController::class, 'store']);

// PUT/PATCH route (for updates)
Route::put('/posts/{id}', [PostController::class, 'update']);

// DELETE route
Route::delete('/posts/{id}', [PostController::class, 'destroy']);

// Route groups with middleware
Route::middleware('auth:sanctum')->group(function () {
    // All routes here require authentication
    Route::get('/posts', [PostController::class, 'index']);
});

// Guest only routes (not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm']);
});

// Named routes - use in views with route('name')
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
// In Blade: {{ route('posts.index') }}
// With parameter: {{ route('posts.show', $post->id) }}
```

### B. Controllers (app/Http/Controllers/)

```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // GET /posts - List all posts
    public function index(Request $request)
    {
        $posts = Post::active()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('posts.index', compact('posts'));
    }

    // GET /posts/create - Show create form
    public function create()
    {
        return view('posts.create');
    }

    // POST /posts - Save new post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:40',
            'body'  => 'required|string|max:2000',
        ]);

        Post::create([
            'title'   => $validated['title'],
            'body'    => $validated['body'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post created!');
    }

    // GET /posts/{id} - Show single post
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    // GET /posts/{id}/edit - Show edit form
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    // PUT /posts/{id} - Update post
    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:40',
            'body'  => 'required|string|max:2000',
        ]);

        $post = Post::findOrFail($id);
        $post->update($validated);

        return redirect()->route('posts.show', $id)
            ->with('success', 'Post updated!');
    }

    // DELETE /posts/{id} - Delete post
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete(); // or soft delete with status change

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted!');
    }
}
```

### C. Models (app/Models/)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Which fields can be mass-assigned (filled via create/update)
    protected $fillable = [
        'title',
        'body',
        'image',
        'user_id',
        'status',
    ];

    // ==================
    // RELATIONSHIPS
    // ==================

    // Post belongs to one User (author)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Post has many Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Post has many Likes (many-to-many with users via pivot table)
    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_likes')
            ->withTimestamps();
    }

    // ==================
    // SCOPES (reusable query conditions)
    // ==================

    // Usage: Post::active()->get()
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Usage: Post::inactive()->get()
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
```

### D. Migrations (database/migrations/)

**Creating a new table:**
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();                              // Auto-increment primary key
            $table->string('title');                   // VARCHAR(255)
            $table->text('body');                      // TEXT (longer content)
            $table->string('image')->nullable();       // Can be NULL
            $table->foreignId('user_id')->constrained(); // Foreign key to users table
            $table->string('status')->default('active'); // Default value
            $table->timestamps();                      // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

**Modifying existing table:**
```php
public function up(): void
{
    Schema::table('posts', function (Blueprint $table) {
        $table->string('image')->nullable()->after('body');
    });
}

public function down(): void
{
    Schema::table('posts', function (Blueprint $table) {
        $table->dropColumn('image');
    });
}
```

**Column types:**
| Method | MySQL Type | Usage |
|--------|------------|-------|
| `$table->id()` | BIGINT AUTO_INCREMENT | Primary key |
| `$table->string('name')` | VARCHAR(255) | Short text |
| `$table->string('name', 100)` | VARCHAR(100) | Custom length |
| `$table->text('body')` | TEXT | Long text |
| `$table->integer('count')` | INT | Numbers |
| `$table->boolean('is_active')` | TINYINT(1) | true/false |
| `$table->timestamp('published_at')` | TIMESTAMP | Date/time |
| `$table->timestamps()` | TIMESTAMP x2 | created_at & updated_at |
| `$table->foreignId('user_id')->constrained()` | BIGINT | Foreign key |

**Modifiers:**
- `->nullable()` - Can be NULL
- `->default('value')` - Default value
- `->after('column')` - Position after column
- `->unique()` - Must be unique

### E. Blade Templates (resources/views/)

**Master Layout (layouts/app.blade.php):**
```blade
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Default Title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <!-- Navigation -->
    </header>

    <main>
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>
```

**Page Template (posts/index.blade.php):**
```blade
@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
    <h1>All Posts</h1>

    @foreach ($posts as $post)
        <div class="post">
            <h2>{{ $post->title }}</h2>
            <p>By {{ $post->user->username }}</p>
        </div>
    @endforeach

    {{ $posts->links() }}  <!-- Pagination -->
@endsection

@section('scripts')
<script>
    // Page-specific JavaScript
</script>
@endsection
```

**Common Blade Syntax:**

```blade
{{-- Comments (not rendered) --}}

{{ $variable }}                    <!-- Escaped output (safe) -->
{!! $html !!}                      <!-- Unescaped output (careful!) -->

@if ($condition)
    ...
@elseif ($other)
    ...
@else
    ...
@endif

@foreach ($items as $item)
    {{ $item->name }}
@endforeach

@forelse ($posts as $post)
    {{ $post->title }}
@empty
    <p>No posts found.</p>
@endforelse

@auth
    <!-- User is logged in -->
    Welcome, {{ Auth::user()->username }}
@endauth

@guest
    <!-- User is NOT logged in -->
    <a href="/login">Login</a>
@endguest

@error('fieldname')
    <p class="error">{{ $message }}</p>
@enderror
```

**Forms:**
```blade
<form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
    @csrf    <!-- Required for POST/PUT/DELETE -->

    <!-- For PUT/PATCH/DELETE -->
    @method('PUT')
    @method('DELETE')

    <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}">

    @error('title')
        <p>{{ $message }}</p>
    @enderror

    <button type="submit">Submit</button>
</form>
```

### F. Validation (in Controller)

```php
$validated = $request->validate([
    // Required field
    'title' => 'required',

    // Multiple rules (pipe separated)
    'title' => 'required|string|max:40',

    // Optional field (can be empty)
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

    // Unique in database (table,column)
    'email' => 'required|email|unique:users,email',

    // Must match another field (field_confirmation)
    'password' => 'required|min:6|confirmed',  // needs password_confirmation field

    // Must exist in another table
    'user_id' => 'required|exists:users,id',
]);
```

**Common validation rules:**
| Rule | Description |
|------|-------------|
| `required` | Must have a value |
| `nullable` | Can be empty/null |
| `string` | Must be a string |
| `integer` | Must be a number |
| `email` | Must be valid email format |
| `min:6` | Minimum length/value |
| `max:255` | Maximum length/value |
| `unique:table,column` | Must be unique in database |
| `exists:table,column` | Must exist in database |
| `confirmed` | Must have matching _confirmation field |
| `image` | Must be an image file |
| `mimes:jpeg,png` | Allowed file types (no spaces!) |

### G. Authentication

**Login/Logout:**
```php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Check credentials and login
if (Hash::check($password, $user->password)) {
    Auth::guard('web')->login($user);
}

// Logout
Auth::guard('web')->logout();
$request->session()->invalidate();
$request->session()->regenerateToken();

// Get current user
$user = Auth::user();
$userId = Auth::id();

// Check if logged in
if (Auth::check()) {
    // User is logged in
}
```

**In Blade templates:**
```blade
@auth
    Welcome, {{ Auth::user()->username }}!
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endauth

@guest
    <a href="{{ route('login') }}">Login</a>
@endguest
```

### H. File Upload

**Controller:**
```php
public function store(Request $request)
{
    $validated = $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        // Stores in storage/app/public/posts/
        // Returns path like: posts/abc123.jpg
        $imagePath = $request->file('image')->store('posts', 'public');
    }

    Post::create([
        'image' => $imagePath,
        // ... other fields
    ]);
}
```

**View (form):**
```blade
<!-- IMPORTANT: enctype required for file uploads! -->
<form method="POST" action="..." enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" accept="image/*">
    <button type="submit">Upload</button>
</form>
```

**View (display):**
```blade
@if ($post->image)
    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
@endif
```

**Required setup (run once):**
```bash
php artisan storage:link
```

### I. Relationships

| Type | Example | In Parent Model | In Child Model |
|------|---------|-----------------|----------------|
| One to Many | User has many Posts | `hasMany(Post::class)` | `belongsTo(User::class)` |
| Many to Many | Post has many Likes | `belongsToMany(User::class, 'post_likes')` | - |
| One to One | User has one Profile | `hasOne(Profile::class)` | `belongsTo(User::class)` |

**Using relationships:**
```php
// Get all posts by a user
$user->posts

// Get post author
$post->user->username

// Get comments on a post
$post->comments

// Eager loading (prevents N+1 query problem)
$posts = Post::with('user', 'comments')->get();

// Check if relationship exists
if ($post->likes->contains($userId)) {
    // User already liked this post
}

// Many-to-many operations
$post->likes()->attach($userId);    // Add like
$post->likes()->detach($userId);    // Remove like
$post->likes()->toggle($userId);    // Toggle like
```

### J. Sanctum API Authentication

**Setup:**
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

**User model:**
```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
}
```

**API login (returns token):**
```php
public function login(Request $request)
{
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('auth-token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
}
```

**Protected API routes:**
```php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
```

**Client usage:**
```
GET /api/user
Headers:
  Authorization: Bearer YOUR_TOKEN_HERE
  Accept: application/json
```

---

## 5. Common Artisan Commands

### Create Files
```bash
php artisan make:controller PostController
php artisan make:model Post
php artisan make:model Post -m              # With migration
php artisan make:migration create_posts_table
php artisan make:migration add_image_to_posts_table
```

### Database
```bash
php artisan migrate                  # Run pending migrations
php artisan migrate:rollback         # Undo last migration
php artisan migrate:fresh            # Drop all tables & re-migrate
php artisan migrate:status           # Show migration status
```

### Server & Development
```bash
php artisan serve                    # Start dev server (localhost:8000)
php artisan serve --host=0.0.0.0     # Accessible from other devices
php artisan serve --port=8080        # Custom port
```

### Storage
```bash
php artisan storage:link             # Create public/storage symlink
```

### Cache (Clear when things don't update)
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear           # Clear all caches
```

### Debugging
```bash
php artisan route:list               # Show all routes
php artisan route:list --path=posts  # Filter by path
```

---

## 6. Common Errors & Solutions

| Error | Cause | Solution |
|-------|-------|----------|
| **404 Not Found** | Route doesn't exist or wrong URL | Check `routes/web.php`, run `php artisan route:list` |
| **419 Page Expired** | Missing CSRF token | Add `@csrf` inside forms |
| **500 Server Error** | PHP error in code | Check `storage/logs/laravel.log` |
| **SQLSTATE: Table not found** | Migration not run | Run `php artisan migrate` |
| **Mass assignment exception** | Field not in `$fillable` | Add field to model's `$fillable` array |
| **Class not found** | Missing import/namespace | Add `use App\Models\Post;` at top of file |
| **Image not showing** | Storage not linked | Run `php artisan storage:link` |
| **Validation fails silently** | Spaces in validation rules | `mimes:jpeg,png` not `mimes:jpeg, png` |
| **Auth::user() is null** | Not logged in or wrong guard | Use `Auth::guard('web')->user()` |
| **Method not allowed** | Wrong HTTP method | Check route method (GET vs POST) |
| **Token mismatch** | CSRF token expired | Refresh page, add `@csrf` to forms |
| **View not found** | Wrong view path | Check file exists in `resources/views/` |
| **Route not defined** | Missing named route | Add `->name('route.name')` to route |

---

## 7. Debugging Tips

### In PHP/Controller:
```php
// Print and stop execution
dd($variable);
dd($request->all());
dd(Auth::user());

// Print without stopping
dump($variable);

// Log to file (storage/logs/laravel.log)
\Log::info('Message here');
\Log::info('User data:', ['user' => $user]);
```

### In Blade:
```blade
{{ dd($post) }}
{{ dump($posts) }}
```

### Check logs:
```
storage/logs/laravel.log
```

### Browser:
- Press `F12` to open Developer Tools
- Check **Console** tab for JavaScript errors
- Check **Network** tab for failed requests

### Database queries:
```php
// See the SQL being executed
\DB::enableQueryLog();
$posts = Post::all();
dd(\DB::getQueryLog());
```

---

## 8. New Project Skeleton Steps

When starting a fresh Laravel project:

```bash
# 1. Create new Laravel project
composer create-project laravel/laravel projectname
cd projectname

# 2. Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=

# 3. Create database in phpMyAdmin or MySQL

# 4. Create models with migrations
php artisan make:model Post -m
php artisan make:model Comment -m

# 5. Edit migrations in database/migrations/
# Define your table columns

# 6. Run migrations
php artisan migrate

# 7. Create controllers
php artisan make:controller PostController
php artisan make:controller AuthController

# 8. Define routes in routes/web.php

# 9. Create layout file
# resources/views/layouts/app.blade.php

# 10. Create view files
# resources/views/posts/index.blade.php
# resources/views/posts/show.blade.php
# etc.

# 11. For Tailwind CSS (already included in Laravel)
npm install
npm run dev    # Development
npm run build  # Production

# 12. For file uploads
php artisan storage:link

# 13. For API authentication (optional)
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
# Add HasApiTokens trait to User model

# 14. Start development server
php artisan serve
```

---

## 9. What to Master Next

| Topic | Description | Priority |
|-------|-------------|----------|
| **Eloquent ORM** | Advanced queries, scopes, relationships | High |
| **Form Requests** | Move validation to separate classes | High |
| **Policies & Gates** | Authorization (who can do what) | High |
| **Middleware** | Custom request filtering | Medium |
| **Blade Components** | Reusable UI components | Medium |
| **API Resources** | Transform data for API responses | Medium |
| **Queues & Jobs** | Background processing | Medium |
| **Events & Listeners** | Decouple application logic | Medium |
| **Testing** | PHPUnit tests for your code | Medium |
| **Caching** | Improve performance | Low |
| **Broadcasting** | Real-time features with WebSockets | Low |

---

## 10. Learning Resources

### Official
- **Laravel Documentation**: https://laravel.com/docs
- **Laravel News**: https://laravel-news.com

### Video Tutorials
- **Laracasts**: https://laracasts.com (best Laravel tutorials)
- **Laravel Daily (YouTube)**: Practical tips and tutorials
- **Traversy Media (YouTube)**: Beginner-friendly

### Community
- **Laravel.io Forums**: https://laravel.io
- **Stack Overflow**: For specific errors
- **Reddit r/laravel**: Community discussions

### Practice Projects
1. Blog with comments
2. Todo app with categories
3. E-commerce (products, cart, checkout)
4. Social media clone
5. REST API for mobile app

---

## Quick Reference Card

### File Locations
| What | Where |
|------|-------|
| Routes | `routes/web.php`, `routes/api.php` |
| Controllers | `app/Http/Controllers/` |
| Models | `app/Models/` |
| Views | `resources/views/` |
| Migrations | `database/migrations/` |
| Config | `config/` |
| Logs | `storage/logs/laravel.log` |
| Uploads | `storage/app/public/` |
| Public Assets | `public/` |

### Common Imports
```php
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
```

### Route Methods
```php
Route::get()      // Read
Route::post()     // Create
Route::put()      // Update (full)
Route::patch()    // Update (partial)
Route::delete()   // Delete
```

### Blade Shortcuts
```blade
{{ $var }}           // Echo escaped
{!! $var !!}         // Echo raw HTML
@if / @else / @endif
@foreach / @endforeach
@forelse / @empty / @endforelse
@auth / @endauth
@guest / @endguest
@csrf               // CSRF token
@method('PUT')      // Form method spoofing
@error('field')     // Validation error
```

---

*Last updated: February 2026*
*Project: PostBoard - Laravel Learning Project*

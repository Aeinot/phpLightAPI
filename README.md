# phpLightAPI
A lightweight PHP API framework.

## Features
 - Simple routing
 - MySQL integration
 - JSON responses

## Installation
Clone the git repository, edit the `config/config.php` file. 

## Usage

### Routing
You will define all of the routes for your application in the `config/routes.php` file. The most basic routes simply accept a URI and a callback function:

```php
app('router')->get('/foo', function () {
    return 'Hello World';
});

app('router')->post('/foo', function () {
    //
});
```

#### Available Router Methods

The router allows you to register routes that respond to any HTTP verb:

```php
app('router')->get($uri, $callback);
app('router')->post($uri, $callback);
app('router')->put($uri, $callback);
app('router')->delete($uri, $callback);
```

#### Route Parameters

Of course, sometimes you will need to capture segments of the URI within your route. For example, you may need to capture a user's ID from the URL. You may do so by defining route parameters:

```php
app('router')->get('/user/{id}', function ($id) {
    return 'User '.$id;
});
```

You may define as many route parameters as required by your route:

```php
app('router')->get('/posts/{postId}/comments/{commentId}', function ($postId, $commentId) {
    //
});
```

Route parameters are always encased within "curly" braces. The parameters will be passed into your route's `Closure` when the route is executed.  The name of the parameters passed to the callback function does not matter, but the order must be the same as in the route URI.

#### Input values
If you need to access the body of the request, you can add the parameter `$_post` to the callback function. It works as `$_POST`, and is compatible with `POST` and `PUT` requests. 

```php
app('router')->put('/user/{id}', function ($_post, $id) {
    if(isset($_post["new_password"]))
        // $_post["new_password"]
});
```

### Responses
All routes and controllers should return some kind of response to be sent back to the user's browser. The most basic response is simply returning a string from a route or controller:

```php
app('router')->get('/', function () {
    return 'Hello World';
});
```

#### JSON Responses

The `json` static method will automatically set the `Content-Type` header to `application/json`, as well as convert the given array into JSON using the `json_encode` PHP function:

```php
return Response::json(['name' => 'Abigail', 'state' => 'CA']);
```

#### HTTP Status Code
The `status_code` static method will automatically set the `Content-Type` header to `application/json`, set the HTTP status code according to the given value and return a json array with two values : `code` and `message`. The `message` parameter is optional and will be set to the default message for the following status code values : 200, 201, 304, 400, 401, 403, 404, 500.

```php
app('router')->get('/not-found', function () {
    return Response::status_code(404);
});

app('router')->get('/auth-required', function () {
    return Response::status_code(403, "Authentication Required");
});
```


### MySQL

The MySQL database is accessible through the `app` helper:

```php
app('router')->get('/user/{id}', function ($id) {
    $results = app('db')->select("SELECT * FROM users WHERE id = :id",
       ['id' => $id]);
    return Response::json($results);
});
```
The following methods can be used:
 - `select(string $request[, array $params])` : returns the results as an array.
 - `insert(string $request[, array $params])` : returns `True` if the insertion was successfull, `False` if not.
 - `update(string $request[, array $params])` : returns the number of updated rows.
 - `update(string $request[, array $params])` : returns the number of deleted rows.


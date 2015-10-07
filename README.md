# Active Resource Model
A simple active resource model.

An Active Resource Model is like an Active Record Model, only it uses an API instead of a database for persistent storage.

```
use \Jstewmc\Api;
use \Jstewmc\ActiveResourceModel as Model;

// instantiate a new api client
$client = new Api\Client();

// instantiate a new model (assuming we've defined a concrete Active Resource Model
//     named Foo with two properties "foo" and "bar")
//
$model = new Model\Foo($client);

// set the model's properties
$model->foo = "bar";
$model->bar = "baz";

// does the model have an id? (no, it's new)
isset($model->id);  // returns false

// create the model using the api (the model will send a create request and receive 
//     a create response using the API client)
//
$model->create();

// does the model has an id? (yes, it's been created)
isset($model->id);  // returns true
```

## (Mostly) Agnostic

This library is designed to be API agnostic, leaving the implementation of the API's client, requests, and responses up to you. 

Unfortunately, it's far from perfect. As one of my first attempts to _really_ separate components, I couldn't help but design this library with my other libraries - [jstewmc/api](https://github.com/jstewmc/api), [jstewmc/model](https://github.com/jstewmc/model), [jstewmc/url](https://github.com/jstewmc/url), and [jstewmc/api-tester](https://github.com/jstewmc/api-tester) - in mind.

## Client

The API client is the heart of the Active Resource Model. 

The API client is responsible for sending requests and receiving responses to and from the service. A client that implements the `Api\Client` interface must be passed to a model at construction.

For now, the client must implement at least two methods: `send()` and `receive()`. The `send()` method should accept a _request_, and the `receive()` method should accept a _response_.


## Requests

This library defines five request interfaces: _create_, _read_, _update_, _delete_, and _index_. 

In the concrete Active Resource Model you define, you should write `getCreateRequest()`, `getReadRequest()`, `getUpdateRequest()`, `getDeleteRequest()`, and `getIndexRequest()` methods to return a request of the same name.

This is one of the nice features of this library. It doesn't care about any of the details of your request. If the API client you're using accepts it, it's good enough for this library.

## Responses

This library defines five response interfaces, one for each type of request: _create_, _read_, _update_, _delete_, and _index_. 

In the concrete Active Resource Model you define, you should write `getCreateResponse()`, `getReadResponse()`, `getUpdateResponse()`, `getDeleteResponse()`, and `getIndexResponse()` methods to return a response of the same name. 

Again, this library cares very little about the details of your response. It just needs a few pieces of data according to the type of request:

- Create, must define a `getId()` method to return the model's new id.
- Read, must define a `getAttributes()` method to return the model's data.
- Index, must define a `getEntities()` method to return the indexed entities.

The `Update` and `Delete` responses have no requirements.


## Model

Once you've implemented the API client, requests, and responses, you're ready to implement the model.

### Properties

Like many "magic" models, an Active Resource Model defines its properties using a static `properties` array and uses magic methods like `__get()` and `__set()` to get and set them. 

See [jstewmc/model](https://github.com/jstewmc/model) for details.

### Methods

The model provides `create()`, `read()`, `update()`, `delete()`, and `index()` methods to execute typical CRUD operations of the same name.

The methods vary mainly on whether or not the model should be read beforehand, and the outcome of a successful operation.

| Method | Read before   | Outcome   |
|--------|---------------|-----------|
| Create | Forbidden     | Set id    |
| Read   | N/A           | Set data  |
| Update | Required      | No change |
| Delete | Required      | Unset id  |
| Index  | N/A           | N/A       |


## Implementation

I know this has been a tremendous amount of _abstract_ information. 

So, here is a simple create-only implementation using my libraries with the following assumptions:

- assuming our application's namespace is `App`
- assuming our model, Foo, has two properties "id" and "bar"
- assuming our API service is available at `http://localhost`
- assuming our API receives a POST request to create a resource
- assuming our API sends a JSON response like `{"id":1}` on success

Let's define our API client (path/to/api/client.php):

```php
namespace App\Api;

class Client extends \Jstewmc\Api\Client 
	implements \Jstewmc\ActiveResourceModel\Api\Client
{
	// nothing yet	
}
```

Let's define our POST create _request_ (path/to/api/request/create.php):

```php
namespace App\Api\Request;

class Create extends \Jstewmc\Api\Request\Post
	implements \Jstewmc\ActiveResourceModel\Api\Request\Create
{
	// nothing yet
}
```

Let's define our JSON create _response_ (path/to/api/response/create.php):

```php
namespace App\Api\Response;

class Create extends \Jstewmc\Api\Response\Json
	implements \Jstewmc\ActiveResourceModel\Api\Response\Create
{
	public function getId()
	{
		if ($this->data) {
			if (array_key_exists('id', $this->data)) {
				return $this->data['id'];	
			}	
		}
		
		return null;
	}
}
```

Let's define our _model_ (path/to/model/foo.php):

```php
namespace Appi\Model;

class Foo extends \Jstewmc\ActiveResourceModel\Model
{
	protected static $properties = ['id', 'bar'];
	
	protected function getCreateRequest()
	{
		return new App\Api\Request\Create('htt://localhost/foo');
	}
	
	protected function getCreateResponse()
	{
		return new App\Api\Response\Create();	
	}	
}
```

Let's define our _controller_ (path/to/controller/foo.php):

```php
namespace App\Controller;

class Foo
{
	public function action_create()
	{
		$client = new Api\Client();
		
		$model = new Model\Foo($client);
		
		$model->bar = "baz";
		
		$model->create();
		
		header("Location:http://localhost/foo/read/{$model->id}");
	}
}
```

That's it. It's definitely a lot of classes to define. However, hopefully, now you have a (mostly) API-agnostic active resource model! Woot!

## Version

### 0.1.0 - October 6, 2015

- Initial release

## Author

[Jack Clayton](mailto:clayjs0@gmail.com)

## License

[MIT](https://github.com/jstewmc/active-resource-model/blob/master/LICENSE)


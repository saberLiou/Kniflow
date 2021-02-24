# 02. Categories


## 2-2. Store a newly created category in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://kniflow.test/api/categories" \
    -H "Authorization: Bearer {personal-access-token}" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    -d '{"name":"saberLiou","sort":0}'

```

```python
import requests
import json

url = 'http://kniflow.test/api/categories'
payload = {
    "name": "saberLiou",
    "sort": 0
}
headers = {
  'Authorization': 'Bearer {personal-access-token}',
  'Accept': 'application/json',
  'Content-Type': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://kniflow.test/api/categories',
    [
        'headers' => [
            'Authorization' => 'Bearer {personal-access-token}',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'name' => 'saberLiou',
            'sort' => 0,
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://kniflow.test/api/categories"
);

let headers = {
    "Authorization": "Bearer {personal-access-token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

let body = {
    "name": "saberLiou",
    "sort": 0
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```


> Example response (201, when category created.):

```json
{
    "jsonapi": {
        "version": "2021.02"
    },
    "data": {
        "id": 1,
        "type": "categories",
        "attributes": {
            "slug": "saberliou",
            "name": "saberLiou",
            "sort": 0,
            "created_at": "1970-01-01 00:00:01",
            "updated_at": "1970-01-01 00:00:01"
        },
        "relationships": {
            "user": {
                "data": {
                    "id": 1,
                    "name": "saberLiou",
                    "email": "saberliou@gmail.com",
                    "email_verified_at": null,
                    "created_at": "1970-01-01 00:00:00",
                    "updated_at": "1970-01-01 00:00:00"
                }
            },
            "posts": []
        }
    },
    "links": {
        "self": "http:\/\/kniflow.test\/api\/categories"
    }
}
```
> Example response (401, without personal access token.):

```json
{
    "jsonapi": {
        "version": "2021.02"
    },
    "errors": [
        {
            "status": "401",
            "source": {
                "pointer": "",
                "parameter": ""
            },
            "title": "Unauthorized",
            "detail": "Unauthenticated."
        }
    ]
}
```
> Example response (422, when any validation failed.):

```json
{
    "jsonapi": {
        "version": "2021.02"
    },
    "errors": [
        {
            "status": "422",
            "source": {
                "pointer": "\/data\/attributes\/name",
                "parameter": ""
            },
            "title": "Invalid Attribute",
            "detail": "{validation-error-message}"
        },
        {
            "status": "422",
            "source": {
                "pointer": "\/data\/attributes\/sort",
                "parameter": ""
            },
            "title": "Invalid Attribute",
            "detail": "{validation-error-message}"
        }
    ]
}
```
<div id="execution-results-POSTapi-categories" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-categories"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-categories"></code></pre>
</div>
<div id="execution-error-POSTapi-categories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-categories"></code></pre>
</div>
<form id="form-POSTapi-categories" data-method="POST" data-path="api/categories" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {personal-access-token}","Accept":"application\/json","Content-Type":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-categories', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-categories" onclick="tryItOut('POSTapi-categories');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-categories" onclick="cancelTryOut('POSTapi-categories');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-categories" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/categories</code></b>
</p>
<p>
<label id="auth-POSTapi-categories" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-categories" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-categories" data-component="body" required  hidden>
<br>
The name of the category.</p>
<p>
<b><code>sort</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="sort" data-endpoint="POSTapi-categories" data-component="body"  hidden>
<br>
The sort of the category.</p>

</form>


## 2-1. Display a listing of the categories.




> Example request:

```bash
curl -X GET \
    -G "http://kniflow.test/api/categories" \
    -H "Accept: application/json"
```

```python
import requests
import json

url = 'http://kniflow.test/api/categories'
headers = {
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://kniflow.test/api/categories',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://kniflow.test/api/categories"
);

let headers = {
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```


> Example response (200, when categories displayed.):

```json
{
    "jsonapi": {
        "version": "2021.02"
    },
    "data": [
        {
            "id": 1,
            "type": "categories",
            "attributes": {
                "slug": "category",
                "name": "category",
                "sort": 0,
                "created_at": "1970-01-01 00:00:00",
                "updated_at": "1970-01-01 00:00:00"
            },
            "relationships": {
                "user": {
                    "data": {
                        "id": 1,
                        "name": "saberLiou",
                        "email": "saberliou@gmail.com",
                        "email_verified_at": null,
                        "created_at": "1970-01-01 00:00:00",
                        "updated_at": "1970-01-01 00:00:00"
                    }
                },
                "posts": []
            }
        }
    ],
    "links": {
        "self": "http:\/\/kniflow.test\/api\/categories"
    }
}
```
<div id="execution-results-GETapi-categories" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-categories"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-categories"></code></pre>
</div>
<div id="execution-error-GETapi-categories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-categories"></code></pre>
</div>
<form id="form-GETapi-categories" data-method="GET" data-path="api/categories" data-authed="0" data-hasfiles="0" data-headers='{"Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-categories', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-categories" onclick="tryItOut('GETapi-categories');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-categories" onclick="cancelTryOut('GETapi-categories');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-categories" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/categories</code></b>
</p>
</form>


## 2-3. Display the specified category.




> Example request:

```bash
curl -X GET \
    -G "http://kniflow.test/api/categories/aut" \
    -H "Accept: application/json"
```

```python
import requests
import json

url = 'http://kniflow.test/api/categories/aut'
headers = {
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://kniflow.test/api/categories/aut',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://kniflow.test/api/categories/aut"
);

let headers = {
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```


> Example response (200, when category displayed.):

```json
{
    "jsonapi": {
        "version": "2021.02"
    },
    "data": {
        "id": 1,
        "type": "categories",
        "attributes": {
            "slug": "saberliou",
            "name": "saberLiou",
            "sort": 0,
            "created_at": "1970-01-01 00:00:00",
            "updated_at": "1970-01-01 00:00:00"
        },
        "relationships": {
            "user": {
                "data": {
                    "id": 1,
                    "name": "saberLiou",
                    "email": "saberliou@gmail.com",
                    "email_verified_at": null,
                    "created_at": "1970-01-01 00:00:00",
                    "updated_at": "1970-01-01 00:00:00"
                }
            },
            "posts": []
        }
    },
    "links": {
        "self": "http:\/\/kniflow.test\/api\/categories\/saberLiou"
    }
}
```
> Example response (404, when category not found.):

```json
{
    "jsonapi": {
        "version": "2021.02"
    },
    "errors": [
        {
            "status": "404",
            "source": {
                "pointer": "",
                "parameter": ""
            },
            "title": "Not Found",
            "detail": "Cannot find the resource."
        }
    ]
}
```
<div id="execution-results-GETapi-categories--category-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-categories--category-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-categories--category-"></code></pre>
</div>
<div id="execution-error-GETapi-categories--category-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-categories--category-"></code></pre>
</div>
<form id="form-GETapi-categories--category-" data-method="GET" data-path="api/categories/{category}" data-authed="0" data-hasfiles="0" data-headers='{"Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-categories--category-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-categories--category-" onclick="tryItOut('GETapi-categories--category-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-categories--category-" onclick="cancelTryOut('GETapi-categories--category-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-categories--category-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/categories/{category}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>category</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="category" data-endpoint="GETapi-categories--category-" data-component="url" required  hidden>
<br>
</p>
</form>




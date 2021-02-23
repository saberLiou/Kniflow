# 02. Categories


## Display a listing of the categories.




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
                "created_at": "1970-01-01 00:00:03",
                "updated_at": "1970-01-01 00:00:03"
            },
            "relationships": {
                "user": {
                    "data": {
                        "id": 1,
                        "name": "saberLiou",
                        "email": "saberliou@gmail.com",
                        "email_verified_at": null,
                        "created_at": "1970-01-01 00:00:01",
                        "updated_at": "1970-01-01 00:00:01"
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




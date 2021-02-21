# 01. Authentication


## Register a user with a personal access token.




> Example request:

```bash
curl -X POST \
    "http://kniflow.test/api/register" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -H "Accept: application/json" \
    -d '{"name":"saberLiou","email":"saberliou@gmail.com","password":"12345678","device_name":"Pixel"}'

```

```python
import requests
import json

url = 'http://kniflow.test/api/register'
payload = {
    "name": "saberLiou",
    "email": "saberliou@gmail.com",
    "password": "12345678",
    "device_name": "Pixel"
}
headers = {
  'Content-Type': 'application/x-www-form-urlencoded',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://kniflow.test/api/register',
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'saberLiou',
            'email' => 'saberliou@gmail.com',
            'password' => '12345678',
            'device_name' => 'Pixel',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://kniflow.test/api/register"
);

let headers = {
    "Content-Type": "application/x-www-form-urlencoded",
    "Accept": "application/json",
};

let body = {
    "name": "saberLiou",
    "email": "saberliou@gmail.com",
    "password": "12345678",
    "device_name": "Pixel"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```


> Example response (201, when registration succeeded.):

```json
{
    "jsonapi": {
        "version": "2021.02"
    },
    "data": {
        "id": 1,
        "type": "users",
        "attributes": {
            "name": "saberLiou",
            "email": "saberliou@gmail.com",
            "email_verified_at": null,
            "created_at": "1970-01-01 00:00:00",
            "updated_at": "1970-01-01 00:00:00",
            "token": "{personal-access-token}"
        },
        "relationships": {
            "tokens": {
                "data": [
                    {
                        "id": 1,
                        "tokenable_type": "users",
                        "tokenable_id": 1,
                        "name": "Pixel",
                        "abilities": [
                            "*"
                        ],
                        "last_used_at": null,
                        "created_at": "1970-01-01 00:00:00",
                        "updated_at": "1970-01-01 00:00:00"
                    }
                ]
            },
            "categories": [],
            "posts": []
        }
    },
    "links": {
        "self": "http:\/\/kniflow.test\/api\/register"
    }
}
```
<div id="execution-results-POSTapi-register" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-register"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-register"></code></pre>
</div>
<div id="execution-error-POSTapi-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-register"></code></pre>
</div>
<form id="form-POSTapi-register" data-method="POST" data-path="api/register" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/x-www-form-urlencoded","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-register', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-register" onclick="tryItOut('POSTapi-register');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-register" onclick="cancelTryOut('POSTapi-register');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-register" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/register</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>
The name of the user.</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>
The email of the user. value 必須是有效的 E-mail。.</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="password" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>
The password of the user.</p>
<p>
<b><code>device_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="device_name" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>
The device of the user.</p>

</form>




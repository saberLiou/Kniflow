# 01. Authentication


## Register a user with a personal access token for the device.




> Example request:

```bash
curl -X POST \
    "http://kniflow.test/api/register" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    -d '{"name":"saberLiou","email":"saberliou@gmail.com","password":"12345678","device_name":"saberLiou's Pixel"}'

```

```python
import requests
import json

url = 'http://kniflow.test/api/register'
payload = {
    "name": "saberLiou",
    "email": "saberliou@gmail.com",
    "password": "12345678",
    "device_name": "saberLiou's Pixel"
}
headers = {
  'Accept': 'application/json',
  'Content-Type': 'application/json'
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
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'name' => 'saberLiou',
            'email' => 'saberliou@gmail.com',
            'password' => '12345678',
            'device_name' => 'saberLiou\'s Pixel',
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
    "Accept": "application/json",
    "Content-Type": "application/json",
};

let body = {
    "name": "saberLiou",
    "email": "saberliou@gmail.com",
    "password": "12345678",
    "device_name": "saberLiou's Pixel"
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
                        "name": "saberLiou's Pixel",
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
                "pointer": "\/data\/attributes\/email",
                "parameter": ""
            },
            "title": "Invalid Attribute",
            "detail": "{validation-error-message}"
        },
        {
            "status": "422",
            "source": {
                "pointer": "\/data\/attributes\/password",
                "parameter": ""
            },
            "title": "Invalid Attribute",
            "detail": "{validation-error-message}"
        },
        {
            "status": "422",
            "source": {
                "pointer": "\/data\/attributes\/device_name",
                "parameter": ""
            },
            "title": "Invalid Attribute",
            "detail": "{validation-error-message}"
        }
    ]
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
<form id="form-POSTapi-register" data-method="POST" data-path="api/register" data-authed="0" data-hasfiles="0" data-headers='{"Accept":"application\/json","Content-Type":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-register', this);">
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
The device name of the user.</p>

</form>


## Login a user with a new personal access token for the device.




> Example request:

```bash
curl -X POST \
    "http://kniflow.test/api/login" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    -d '{"email":"saberliou@gmail.com","password":"12345678","device_name":"saberLiou's Pixel"}'

```

```python
import requests
import json

url = 'http://kniflow.test/api/login'
payload = {
    "email": "saberliou@gmail.com",
    "password": "12345678",
    "device_name": "saberLiou's Pixel"
}
headers = {
  'Accept': 'application/json',
  'Content-Type': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://kniflow.test/api/login',
    [
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'email' => 'saberliou@gmail.com',
            'password' => '12345678',
            'device_name' => 'saberLiou\'s Pixel',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://kniflow.test/api/login"
);

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
};

let body = {
    "email": "saberliou@gmail.com",
    "password": "12345678",
    "device_name": "saberLiou's Pixel"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```


> Example response (200, when login succeeded.):

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
            "created_at": "1970-01-01 00:00:01",
            "updated_at": "1970-01-01 00:00:01",
            "token": "{personal-access-token}"
        },
        "relationships": {
            "tokens": {
                "data": [
                    {
                        "id": 2,
                        "tokenable_type": "users",
                        "tokenable_id": 1,
                        "name": "saberLiou's Pixel",
                        "abilities": [
                            "*"
                        ],
                        "last_used_at": null,
                        "created_at": "1970-01-01 00:00:01",
                        "updated_at": "1970-01-01 00:00:01"
                    }
                ]
            },
            "categories": [],
            "posts": []
        }
    },
    "links": {
        "self": "http:\/\/kniflow.test\/api\/login"
    }
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
                "pointer": "\/data\/attributes\/email",
                "parameter": ""
            },
            "title": "Invalid Attribute",
            "detail": "{validation-error-message}"
        },
        {
            "status": "422",
            "source": {
                "pointer": "\/data\/attributes\/password",
                "parameter": ""
            },
            "title": "Invalid Attribute",
            "detail": "{validation-error-message}"
        },
        {
            "status": "422",
            "source": {
                "pointer": "\/data\/attributes\/device_name",
                "parameter": ""
            },
            "title": "Invalid Attribute",
            "detail": "{validation-error-message}"
        }
    ]
}
```
<div id="execution-results-POSTapi-login" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-login"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-login"></code></pre>
</div>
<div id="execution-error-POSTapi-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-login"></code></pre>
</div>
<form id="form-POSTapi-login" data-method="POST" data-path="api/login" data-authed="0" data-hasfiles="0" data-headers='{"Accept":"application\/json","Content-Type":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-login', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-login" onclick="tryItOut('POSTapi-login');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-login" onclick="cancelTryOut('POSTapi-login');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-login" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/login</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-login" data-component="body" required  hidden>
<br>
The email of the user. value 必須是有效的 E-mail。.</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="password" data-endpoint="POSTapi-login" data-component="body" required  hidden>
<br>
The password of the user.</p>
<p>
<b><code>device_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="device_name" data-endpoint="POSTapi-login" data-component="body" required  hidden>
<br>
The device name of the user.</p>

</form>


## Logout a user with all the personal access tokens being revoked on the device.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://kniflow.test/api/logout" \
    -H "Authorization: Bearer {personal-access-token}" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    -d '{"device_name":"saberLiou's Pixel"}'

```

```python
import requests
import json

url = 'http://kniflow.test/api/logout'
payload = {
    "device_name": "saberLiou's Pixel"
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
    'http://kniflow.test/api/logout',
    [
        'headers' => [
            'Authorization' => 'Bearer {personal-access-token}',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'device_name' => 'saberLiou\'s Pixel',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://kniflow.test/api/logout"
);

let headers = {
    "Authorization": "Bearer {personal-access-token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

let body = {
    "device_name": "saberLiou's Pixel"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```


> Example response (200, when logout succeeded.):

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
            "created_at": "1970-01-01 00:00:02",
            "updated_at": "1970-01-01 00:00:02"
        },
        "relationships": {
            "tokens": [],
            "categories": [],
            "posts": []
        }
    },
    "links": {
        "self": "http:\/\/kniflow.test\/api\/logout"
    }
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
                "pointer": "\/data\/attributes\/device_name",
                "parameter": ""
            },
            "title": "Invalid Attribute",
            "detail": "{validation-error-message}"
        }
    ]
}
```
<div id="execution-results-POSTapi-logout" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-logout"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-logout"></code></pre>
</div>
<div id="execution-error-POSTapi-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-logout"></code></pre>
</div>
<form id="form-POSTapi-logout" data-method="POST" data-path="api/logout" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {personal-access-token}","Accept":"application\/json","Content-Type":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-logout', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-logout" onclick="tryItOut('POSTapi-logout');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-logout" onclick="cancelTryOut('POSTapi-logout');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-logout" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/logout</code></b>
</p>
<p>
<label id="auth-POSTapi-logout" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-logout" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>device_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="device_name" data-endpoint="POSTapi-logout" data-component="body" required  hidden>
<br>
The device name of the user.</p>

</form>




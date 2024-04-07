**API Specification Doc**

**(_Martin Delivery App_)**

Martin Delivery is a delivery request project that is developed by Martin Deliver and APIs are given to the other collections.

<table>
  <tr>
   <td><strong>Version</strong>
   </td>
   <td><strong>Date</strong>
   </td>
   <td><strong>Author</strong>
   </td>
   <td><strong>Description</strong>
   </td>
  </tr>
  <tr>
   <td>1.0
   </td>
   <td>07-May-2022
   </td>
   <td>Mohammad Javad Mehrabi
   </td>
   <td>Initial draft
   </td>
  </tr>
</table>


<p>Methods

<h1 id="1-all-users">1. All Users</h1>


<h2 id="1-1-get-tokens">1.1. Get Tokens</h2>


This will generate 6 users (if you did not run db:seed) and will give you tokens to use on all of APIs.

<h2 id="request">Request</h2>



<table>
  <tr>
   <td><strong>Method</strong>
   </td>
   <td><strong>URL            </strong>
   </td>
  </tr>
  <tr>
   <td><strong><code>GET</code></strong>
   </td>
   <td><code>api/users/get-token</code>
   </td>
  </tr>
</table>


Hence as mentioned in the task, we do not need authentication, so this route will run without any special access.

<h2 id="response">Response</h2>



<table>
  <tr>
   <td><strong>Status</strong>
   </td>
   <td><strong>Response</strong>
   </td>
  </tr>
  <tr>
   <td><code>200</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 200,</code>
<p>
<code>    "data": [{</code>
<p>
<code>    	"user_id": &lt;user_id>,</code>
<p>
<code>    	"name": &lt;name>,</code>
<p>
<code>    	"role": &lt;role>,</code>
<p>
<code>    	"token": &lt;token>,</code>
<p>
<code>    }],</code>
<p>
<code>}</code>
<p>
<code>user_id (<strong>integer</strong>)</code> - The id of user, this will use for authorization.
<code>name (<strong>string</strong>)</code> - Just a simple name for a showcase.
<code>role (<strong>string</strong>)</code> - would be any value of <a href="#conventions">admin</a>, <a href="#conventions">collection</a>, and <a href="#conventions">deliverer</a>.
<code>token (<strong>string</strong>)</code> - This token should be used in the rest of the APIs header as Authorization: Bearer <code>token.</code>
   </td>
  </tr>
</table>


<h1 id="2-collections">2. Collections</h1>


<h2>2.1. Insert New Delivery Request</h2>


Collections can insert new delivery requests.

<h2 id="request">Request</h2>



<table>
  <tr>
   <td><strong>Method</strong>
   </td>
   <td><strong>URL            </strong>
   </td>
  </tr>
  <tr>
   <td><strong><code>POST</code></strong>
   </td>
   <td><code>api/delivery-request/</code>
   </td>
  </tr>
</table>



<table>
  <tr>
   <td><strong>Type</strong>
   </td>
   <td><strong>Params</strong>
   </td>
   <td><strong>Values</strong>
   </td>
  </tr>
  <tr>
   <td><code>HEADER</code>
<p>
<code>POST</code>
<p>
<code>POST</code>
<p>
<code>POST</code>
<p>
<code>POST</code>
<p>
<code>POST</code>
<p>
<code>POST</code>
<p>
<code>POST</code>
<p>
<code>POST</code>
<p>
<code>POST</code>
<p>
<code>POST</code>
<p>
<code>POST</code>
<p>
<code>POST</code>
   </td>
   <td>Authorization: Bearer token
<p>
<code>o_latitude</code>
<p>
<code>o_longitude</code>
<p>
<code>o_firstname</code>
<p>
<code>o_lastname</code>
<p>
<code>o_address</code>
<p>
<code>o_phone</code>
<p>
<code>d_latitude</code>
<p>
<code>d_longitude</code>
<p>
<code>d_firstname</code>
<p>
<code>d_lastname</code>
<p>
<code>d_address</code>
<p>
<code>d_phone</code>
   </td>
   <td><code>string</code>
<p>
<code>number</code>
<p>
<code>number</code>
<p>
<code>string</code>
<p>
<code>string</code>
<p>
<code>string</code>
<p>
<code>string</code>
<p>
<code>string</code>
<p>
<code>number</code>
<p>
<code>number</code>
<p>
<code>string</code>
<p>
<code>string</code>
<p>
<code>string</code>
   </td>
  </tr>
</table>


**Authorization: Bearer**

The ` token ` that was given as token in response to `/api/users/get-token.`


```
o_latitude
```


The origin latitude of delivery request.


```
o_longitude
```


The origin latitude of delivery request.


```
o_firstname
```


The firstname of person in the origin.


```
o_firstname
```


The firstname of person in the origin.


```
o_lastname
```


The lastname of person in the origin.


```
o_address
```


The address of origin.


```
o_phone
```


The phone of origin.


```
d_latitude
```


The destination latitude of delivery request.


```
d_longitude
```


The destination latitude of delivery request.


```
d_firstname
```


The firstname of person in the destination.


```
d_firstname
```


The firstname of person in the destination.


```
d_lastname
```


The lastname of person in the destination.


```
d_address
```


The address of destination.


```
d_phone
```


The phone of destination.

<h2 id="response">Response</h2>



<table>
  <tr>
   <td><strong>Status</strong>
   </td>
   <td><strong>Response</strong>
   </td>
  </tr>
  <tr>
   <td><code>201</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 201,</code>
<p>
<code>    "data": &lt;delivery_request_id></code>
<p>
<code>}</code>
<p>
<code>delivery_request_id (<strong>integer</strong>)</code> - A simpe auto increment key that will give to the collection for future tracking.
   </td>
  </tr>
  <tr>
   <td><code>403</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 403,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
  <tr>
   <td><code>422</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 422,</code>
<p>
<code>    "data": {</code>
<p>
<code>      &lt;field_name>: [&lt;error_messages>]</code>
<p>
<code>    }</code>
<p>
<code>}</code>
<p>
<code>data (<strong>object</strong>)</code> - Object of errors (can contains multiple errors).
<code>field_name (<strong>string</strong>)</code> - Not validated filed.
<code>errors_message (<strong>string</strong>)</code> - Message of errors.
   </td>
  </tr>
  <tr>
   <td><code>500</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 500,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
</table>


<h2>2.2. Cancel Delivery Request</h2>


Collections can canell delivery request anytime before receiving by deliverer.

<h2 id="request">Request</h2>



<table>
  <tr>
   <td><strong>Method</strong>
   </td>
   <td><strong>URL            </strong>
   </td>
  </tr>
  <tr>
   <td><strong><code>PUT</code></strong>
   </td>
   <td><code>api/&lt;delivery_request_id>/delivery-request/cancel/</code>
   </td>
  </tr>
</table>



<table>
  <tr>
   <td><strong>Type</strong>
   </td>
   <td><strong>Params</strong>
   </td>
   <td><strong>Values</strong>
   </td>
  </tr>
  <tr>
   <td><code>HEADER</code>
<p>
<code>URL_PARAM</code>
   </td>
   <td>Authorization: Bearer token
<p>
<code>delivery_request_id</code>
   </td>
   <td><code>string</code>
<p>
<code>number</code>
   </td>
  </tr>
</table>


**Authorization: Bearer**

The ` token ` that was given as token in response to `/api/users/get-token.`


```
delivery_request_id
```


The ` delivery_request_id ` that was given to the collection in response to `/api/delivery-request/`

<h2 id="response">Response</h2>



<table>
  <tr>
   <td><strong>Status</strong>
   </td>
   <td><strong>Response</strong>
   </td>
  </tr>
  <tr>
   <td><code>200</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 200,</code>
<p>
<code>    "data": &lt;message></code>
<p>
<code>}</code>
<p>
<code>message (<strong>string</strong>)</code> - A simple message that can be used to display to the user
   </td>
  </tr>
  <tr>
   <td><code>403</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 403,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
  <tr>
   <td><code>422</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 422,</code>
<p>
<code>    "data": {</code>
<p>
<code>      &lt;field_name>: [&lt;error_messages>]</code>
<p>
<code>    }</code>
<p>
<code>}</code>
<p>
<code>data (<strong>object</strong>)</code> - Object of errors (can contains multiple errors).
<code>field_name (<strong>string</strong>)</code> - Not validated filed.
<code>errors_message (<strong>string</strong>)</code> - Message of errors.
   </td>
  </tr>
  <tr>
   <td><code>500</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 500,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
</table>


<h2>2.3. Set Webhook</h2>


Collections can set their preferred webhook without telling the admin to change that.

<h2 id="request">Request</h2>



<table>
  <tr>
   <td><strong>Method</strong>
   </td>
   <td><strong>URL            </strong>
   </td>
  </tr>
  <tr>
   <td><strong><code>PUT</code></strong>
   </td>
   <td><code>api/users/setwebhook</code>
   </td>
  </tr>
</table>



<table>
  <tr>
   <td><strong>Type</strong>
   </td>
   <td><strong>Params</strong>
   </td>
   <td><strong>Values</strong>
   </td>
  </tr>
  <tr>
   <td><code>HEADER</code>
<p>
<code>PUT</code>
   </td>
   <td>Authorization: Bearer token
<p>
<code>url</code>
   </td>
   <td><code>string</code>
<p>
<code>string</code>
   </td>
  </tr>
</table>


**Authorization: Bearer**

The ` token ` that was given as token in response to `/api/users/get-token.`


```
url
```


URL of the requested webhook with the maximum character of 2048. Also It can be null to remove the webhook url and not send the notifications.

<h2 id="response">Response</h2>



<table>
  <tr>
   <td><strong>Status</strong>
   </td>
   <td><strong>Response</strong>
   </td>
  </tr>
  <tr>
   <td><code>200</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 200,</code>
<p>
<code>    "data": &lt;message></code>
<p>
<code>}</code>
<p>
<code>message (<strong>string</strong>)</code> - A simple message that can be used to display to the user
   </td>
  </tr>
  <tr>
   <td><code>403</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 403,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
  <tr>
   <td><code>500</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 500,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
</table>


<h1 id="3-deliverers">3. Deliverers</h1>


<h2 id="3-1-get-all-of-the-available-and-accepted-requests">3.1. Get All Of The Available And Accepted Requests</h2>


Deliverers can get all of their accepted delivery requests plus all available delivery requests.

<h2 id="request">Request</h2>



<table>
  <tr>
   <td><strong>Method</strong>
   </td>
   <td><strong>URL            </strong>
   </td>
  </tr>
  <tr>
   <td><strong><code>GET</code></strong>
   </td>
   <td><code>api/delivery-request/all?page=&lt;page></code>
   </td>
  </tr>
</table>



<table>
  <tr>
   <td><strong>Type</strong>
   </td>
   <td><strong>Params</strong>
   </td>
   <td><strong>Values</strong>
   </td>
  </tr>
  <tr>
   <td><code>HEADER</code>
<p>
<code>URL_PARAM</code>
   </td>
   <td>Authorization: Bearer token
<p>
<code>page</code>
   </td>
   <td><code>string</code>
<p>
<code>integer</code>
   </td>
  </tr>
</table>


**Authorization: Bearer**

The ` token ` that was given as token in response to `/api/users/get-token.`


```
page
```


This is used as offset of pagination.

<h2 id="response">Response</h2>



<table>
  <tr>
   <td><strong>Status</strong>
   </td>
   <td><strong>Response</strong>
   </td>
  </tr>
  <tr>
   <td><code>200</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 200,</code>
<p>
<code>    "data": {</code>
<p>
<code>      "data": [&lt;data>],</code>
<p>
<code>      "pagination": {</code>
<p>
<code>        "count": &lt;count>,</code>
<p>
<code>        "per_page": &lt;per_page>,</code>
<p>
<code>        "current_page": &lt;current_page>,</code>
<p>
<code>        "total_pages": &lt;total_pages>,</code>
<p>
<code>      }</code>
<p>
<code>    }</code>
<p>
<code>}</code>
<p>
<code>count (<strong>string</strong>)</code> - A simple message that can be used to display to the user
<code>per_page (<strong>string</strong>)</code> - Items tht show per page - default is 50
<code>current_page (<strong>string</strong>)</code> - Current page
<code>total_pages (<strong>string</strong>)</code> - Total number of pages based on per page
   </td>
  </tr>
  <tr>
   <td><code>403</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 403,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
</table>


<h2 id="3-2-get-all-of-accepted-requests">3.2. Get All Of Accepted Requests</h2>


Deliverer can get a list of his/her accepted request.

<h2 id="request">Request</h2>



<table>
  <tr>
   <td><strong>Method</strong>
   </td>
   <td><strong>URL            </strong>
   </td>
  </tr>
  <tr>
   <td><strong><code>GET</code></strong>
   </td>
   <td><code>api/deliverers/delivery-request?page=&lt;page></code>
   </td>
  </tr>
</table>



<table>
  <tr>
   <td><strong>Type</strong>
   </td>
   <td><strong>Params</strong>
   </td>
   <td><strong>Values</strong>
   </td>
  </tr>
  <tr>
   <td><code>HEADER</code>
<p>
<code>URL_PARAM</code>
   </td>
   <td>Authorization: Bearer token
<p>
<code>page</code>
   </td>
   <td><code>string</code>
<p>
<code>integer</code>
   </td>
  </tr>
</table>


**Authorization: Bearer**

The ` token ` that was given as token in response to `/api/users/get-token.`


```
page
```


This is used as offset of pagination.

<h2 id="response">Response</h2>



<table>
  <tr>
   <td><strong>Status</strong>
   </td>
   <td><strong>Response</strong>
   </td>
  </tr>
  <tr>
   <td><code>200</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 200,</code>
<p>
<code>    "data": {</code>
<p>
<code>      "data": [&lt;data>],</code>
<p>
<code>      "pagination": {</code>
<p>
<code>        "count": &lt;count>,</code>
<p>
<code>        "per_page": &lt;per_page>,</code>
<p>
<code>        "current_page": &lt;current_page>,</code>
<p>
<code>        "total_pages": &lt;total_pages>,</code>
<p>
<code>      }</code>
<p>
<code>    }</code>
<p>
<code>}</code>
<p>
<code>count (<strong>string</strong>)</code> - A simple message that can be used to display to the user
<code>per_page (<strong>string</strong>)</code> - Items tht show per page - default is 50
<code>current_page (<strong>string</strong>)</code> - Current page
<code>total_pages (<strong>string</strong>)</code> - Total number of pages based on per page
   </td>
  </tr>
  <tr>
   <td><code>403</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 403,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
</table>


<h2>3.3. Get All Of The Available Requests</h2>


Display a list of available request that is ready to deliver to the deliverer.

<h2 id="request">Request</h2>



<table>
  <tr>
   <td><strong>Method</strong>
   </td>
   <td><strong>URL            </strong>
   </td>
  </tr>
  <tr>
   <td><strong><code>GET</code></strong>
   </td>
   <td><code>api/delivery-request?page=&lt;page></code>
   </td>
  </tr>
</table>



<table>
  <tr>
   <td><strong>Type</strong>
   </td>
   <td><strong>Params</strong>
   </td>
   <td><strong>Values</strong>
   </td>
  </tr>
  <tr>
   <td><code>HEADER</code>
<p>
<code>URL_PARAM</code>
   </td>
   <td>Authorization: Bearer token
<p>
<code>page</code>
   </td>
   <td><code>string</code>
<p>
<code>integer</code>
   </td>
  </tr>
</table>


**Authorization: Bearer**

The ` token ` that was given as token in response to `/api/users/get-token.`


```
page
```


This is used as offset of pagination.

<h2 id="response">Response</h2>



<table>
  <tr>
   <td><strong>Status</strong>
   </td>
   <td><strong>Response</strong>
   </td>
  </tr>
  <tr>
   <td><code>200</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 200,</code>
<p>
<code>    "data": {</code>
<p>
<code>      "data": [&lt;data>],</code>
<p>
<code>      "pagination": {</code>
<p>
<code>        "count": &lt;count>,</code>
<p>
<code>        "per_page": &lt;per_page>,</code>
<p>
<code>        "current_page": &lt;current_page>,</code>
<p>
<code>        "total_pages": &lt;total_pages>,</code>
<p>
<code>      }</code>
<p>
<code>    }</code>
<p>
<code>}</code>
<p>
<code>count (<strong>string</strong>)</code> - A simple message that can be used to display to the user
<code>per_page (<strong>string</strong>)</code> - Items tht show per page - default is 50
<code>current_page (<strong>string</strong>)</code> - Current page
<code>total_pages (<strong>string</strong>)</code> - Total number of pages based on per page
   </td>
  </tr>
  <tr>
   <td><code>403</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 403,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
</table>


<h2 id="3-4-accept-an-available-requests">3.4. Accept An Available Requests</h2>


Deliverer can accept an available request.

<h2 id="request">Request</h2>



<table>
  <tr>
   <td><strong>Method</strong>
   </td>
   <td><strong>URL            </strong>
   </td>
  </tr>
  <tr>
   <td><strong><code>PUT</code></strong>
   </td>
   <td><code>api/delivery-request/&lt;delivery_request_id>/accept</code>
   </td>
  </tr>
</table>



<table>
  <tr>
   <td><strong>Type</strong>
   </td>
   <td><strong>Params</strong>
   </td>
   <td><strong>Values</strong>
   </td>
  </tr>
  <tr>
   <td><code>HEADER</code>
<p>
<code>URL_PARAM</code>
   </td>
   <td>Authorization: Bearer token
<p>
<code>delivery_request_id</code>
   </td>
   <td><code>string</code>
<p>
<code>integer</code>
   </td>
  </tr>
</table>


**Authorization: Bearer**

The ` token ` that was given as token in response to `/api/users/get-token.`


```
delivery_request_id
```


The id of delivery request that deliverer want to accept.

<h2 id="response">Response</h2>



<table>
  <tr>
   <td><strong>Status</strong>
   </td>
   <td><strong>Response</strong>
   </td>
  </tr>
  <tr>
   <td><code>200</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 200,</code>
<p>
<code>    "data": &lt;message></code>
<p>
<code>}</code>
<p>
<code>message (<strong>string</strong>)</code> - A simple message that can be used to display to the user
   </td>
  </tr>
  <tr>
   <td><code>403</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 403,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
  <tr>
   <td><code>406</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 406,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
  <tr>
   <td><code>500</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 500,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
</table>


<h2 id="3-5-receive-an-accepted-requests">3.5. Receive An Accepted Requests</h2>


Deliverer can receive a request that is accpted by him/her self.

<h2 id="request">Request</h2>



<table>
  <tr>
   <td><strong>Method</strong>
   </td>
   <td><strong>URL            </strong>
   </td>
  </tr>
  <tr>
   <td><strong><code>PUT</code></strong>
   </td>
   <td><code>api/delivery-request/&lt;delivery_request_id>/received</code>
   </td>
  </tr>
</table>



<table>
  <tr>
   <td><strong>Type</strong>
   </td>
   <td><strong>Params</strong>
   </td>
   <td><strong>Values</strong>
   </td>
  </tr>
  <tr>
   <td><code>HEADER</code>
<p>
<code>URL_PARAM</code>
   </td>
   <td>Authorization: Bearer token
<p>
<code>delivery_request_id</code>
   </td>
   <td><code>string</code>
<p>
<code>integer</code>
   </td>
  </tr>
</table>


**Authorization: Bearer**

The ` token ` that was given as token in response to `/api/users/get-token.`


```
delivery_request_id
```


The id of delivery request that deliverer want to receive.

<h2 id="response">Response</h2>



<table>
  <tr>
   <td><strong>Status</strong>
   </td>
   <td><strong>Response</strong>
   </td>
  </tr>
  <tr>
   <td><code>200</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 200,</code>
<p>
<code>    "data": &lt;message></code>
<p>
<code>}</code>
<p>
<code>message (<strong>string</strong>)</code> - A simple message that can be used to display to the user
   </td>
  </tr>
  <tr>
   <td><code>403</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 403,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
  <tr>
   <td><code>406</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 406,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
  <tr>
   <td><code>500</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 500,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
</table>


<h2 id="3-6-deliver-an-received-requests">3.6. Deliver An Received Requests</h2>


Deliverer can deliver a request that is received by him/her self.

<h2 id="request">Request</h2>



<table>
  <tr>
   <td><strong>Method</strong>
   </td>
   <td><strong>URL            </strong>
   </td>
  </tr>
  <tr>
   <td><strong><code>PUT</code></strong>
   </td>
   <td><code>api/delivery-request/&lt;delivery_request_id>/delivered</code>
   </td>
  </tr>
</table>



<table>
  <tr>
   <td><strong>Type</strong>
   </td>
   <td><strong>Params</strong>
   </td>
   <td><strong>Values</strong>
   </td>
  </tr>
  <tr>
   <td><code>HEADER</code>
<p>
<code>URL_PARAM</code>
   </td>
   <td>Authorization: Bearer token
<p>
<code>delivery_request_id</code>
   </td>
   <td><code>string</code>
<p>
<code>integer</code>
   </td>
  </tr>
</table>


**Authorization: Bearer**

The ` token ` that was given as token in response to `/api/users/get-token.`


```
delivery_request_id
```


The id of delivery request that deliverer want to deliver..

<h2 id="response">Response</h2>



<table>
  <tr>
   <td><strong>Status</strong>
   </td>
   <td><strong>Response</strong>
   </td>
  </tr>
  <tr>
   <td><code>200</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 200,</code>
<p>
<code>    "data": &lt;message></code>
<p>
<code>}</code>
<p>
<code>message (<strong>string</strong>)</code> - A simple message that can be used to display to the user
   </td>
  </tr>
  <tr>
   <td><code>403</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 403,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
  <tr>
   <td><code>406</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 406,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
  <tr>
   <td><code>500</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 500,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
</table>


<h1>**4. Martin Deliver**</h1>


<h1 id="4-1-set-webhook">**4.1. Set Webhook**</h1>


Collections can set their preferred webhook without telling the admin to change that.

<h2 id="request">Request</h2>



<table>
  <tr>
   <td><strong>Method</strong>
   </td>
   <td><strong>URL            </strong>
   </td>
  </tr>
  <tr>
   <td><strong><code>PUT</code></strong>
   </td>
   <td><code>api/users/&lt;id>/setwebhook</code>
   </td>
  </tr>
</table>



<table>
  <tr>
   <td><strong>Type</strong>
   </td>
   <td><strong>Params</strong>
   </td>
   <td><strong>Values</strong>
   </td>
  </tr>
  <tr>
   <td><code>HEADER</code>
<p>
<code>PUT</code>
<p>
<code>URL_PARAM</code>
   </td>
   <td>Authorization: Bearer token
<p>
<code>Url</code>
<p>
<code>id</code>
   </td>
   <td><code>string</code>
<p>
<code>String</code>
<p>
<code>int</code>
   </td>
  </tr>
</table>


**Authorization: Bearer**

The ` token ` that was given as token in response to `/api/users/get-token.`


```
url
```


URL of the requested webhook with the maximum character of 2048. Also It can be null to remove the webhook url and not send the notifications. \



```
id
```


ID of the collection that Martin Deliver wants to change its webhook.

<h2 id="response">Response</h2>



<table>
  <tr>
   <td><strong>Status</strong>
   </td>
   <td><strong>Response</strong>
   </td>
  </tr>
  <tr>
   <td><code>200</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 200,</code>
<p>
<code>    "data": &lt;message></code>
<p>
<code>}</code>
<p>
<code>message (<strong>string</strong>)</code> - A simple message that can be used to display to the user
   </td>
  </tr>
  <tr>
   <td><code>403</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 403,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
  <tr>
   <td><code>422</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 422,</code>
<p>
<code>    "data": {</code>
<p>
<code>      &lt;field_name>: [&lt;error_messages>]</code>
<p>
<code>    }</code>
<p>
<code>}</code>
<p>
<code>data (<strong>object</strong>)</code> - Object of errors (can contains multiple errors).
<code>field_name (<strong>string</strong>)</code> - Not validated filed.
<code>errors_message (<strong>string</strong>)</code> - Message of errors.
   </td>
  </tr>
  <tr>
   <td><code>500</code>
   </td>
   <td><code>{</code>
<p>
<code>    "status": 500,</code>
<p>
<code>    "data": ""</code>
<p>
<code>}</code>
   </td>
  </tr>
</table>


<p>Glossary

<h2 id="conventions">Conventions</h2>




* **Martin Deliver - Admin** - The Shipment company.
* **Deliverer **- Someone who picks up and delivers a product.
* **Collection** - A company or a group that submits an order to the Martin Deliver.
* **Client** - Client application.
* **Status** - HTTP status code of the response.
* All the possible responses are listed under ‘Responses’ for each method. Only one of them is issued per request server.
* All responses are in JSON format.
* All request parameters are mandatory unless explicitly marked as `[optional].`
* <code>Dont forget to include <strong><em>Content-Type: application/json</em></strong> or <strong><em>Content-Type: application/x-www-form-urlencoded</em></strong> relative to your data type, into your header.</code>

<h2 id="status-codes">Status Codes</h2>


All status codes are standard HTTP status codes. The below ones are used in this API.

`2XX - `Success of some kind

`4XX - `Error occurred in client’s part

`5XX - `Error occurred in server’s part


<table>
  <tr>
   <td><strong>Status Code</strong>
   </td>
   <td><strong>Description</strong>
   </td>
  </tr>
  <tr>
   <td><code>200</code>
   </td>
   <td><code>OK</code>
   </td>
  </tr>
  <tr>
   <td><code>201</code>
   </td>
   <td><code>Created</code>
   </td>
  </tr>
  <tr>
   <td><code>403</code>
   </td>
   <td><code>Forbidden</code>
   </td>
  </tr>
  <tr>
   <td><code>409</code>
   </td>
   <td><code>Conflict</code>
   </td>
  </tr>
  <tr>
   <td><code>422</code>
   </td>
   <td><code>Unprocessable entity</code>
   </td>
  </tr>
  <tr>
   <td><code>500</code>
   </td>
   <td><code>Internal Server Error</code>
   </td>
  </tr>
  <tr>
   <td><code>503</code>
   </td>
   <td><code>Service Unavailable</code>
   </td>
  </tr>
</table>


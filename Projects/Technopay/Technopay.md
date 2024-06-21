# TechnoPay Code Challenge
In this code challenge, we want to apply filter[s] on our models.
For example, suppose we have an `Order` model. Also there is an API to list orders as below address:

```sh
api.lendo.local/api/backoffice/orders
```

Now, we need to filter the `Order` model based on incoming request parameters.

Currently, we have 3 filters here:

- filter by order status.
- filter by customer national code or mobile number.
- filter by order amount. The value of amount can have a min value, a max value or both. 

  eg: ['min'=> null, 'max'=> 1_000_000] | ['min'=> 1_000_000, 'max'=> null] | ['min'=> 1_000_000, 'max'=> 2_000_000]

There is another requirement. If your filter runs into an exception you should send an `SMS` and `e-mail` notifications to the admin system and log the error.
```
email: admin@admin.ir
mobile: 0910000000
```
> Note: You don't need to implement a real SMS service. It can be a mock service.

What if our filters grow during the project process?
In other words, the business will need more filters and also complex queries in the future.

What is your solution for this situation?

## Notes
- Please do not use any extra packages.
- Use the Laravel framework(v10+).
- Please follow clean code, software principles and design patterns.
- Writing test(unit/feature) is an advantage.
- You have 24/48H to do it.
- After finishing the task, please upload the code to your `GitHub` repository and send your repo to us.
- If you have any questions, please feel free to ask via this email address: `fouladgar.dev@gmail.com`

Thank you in advance for your valuable time.

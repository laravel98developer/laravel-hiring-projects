واقعا متاسفم برای هاستینگ‌ی مثل
<b><a href="https://parspack.com/">پارس پک</a></b>
که حتی حاضر نشده کمی روی این سوالات وقت بزاره و سوالاتی درخور عزیزانی که لطف کردن و رزومه براشون ارسال کردن، طرح کنه! سوالات پر از غلط های نگارشی (هم در کد و هم در کلمات انگلیسی) و گرامری ست! <br />
شما که نمیتوانید کلمات انگلیسی را صحیح بنویسید چه اصراری به نوشتن غلط غلوت کلمات دارید؟ <br />
در این فایل تا آن جایی که سواد و دانشم اجازه داده اصلاح کردم و اجازه نخواهم داد کیفیت این ریپو توسط اشتباهات بسیار زیاد شما در این سوالات، پایین بیایید. 

هدف این ریپو بالا بردن سطح دانش برنامه نویسان با به چالش کشیدن
<b> سوالات </b>
شما در مصاحبه های استخدامی ست، نه پیدا کردن 
<b> غلط های نگارشی و گرامری </b>
سوالات!!!<br/>
فایل اصلی که برای برنامه نویسان ارسال شده است را هم میتوانید در
<b><a href="https://github.com/laravel98developer/laravel-hiring-projects/blob/master/Projects/ParsPack/P1/HiringTasks.txt">اینجا</a></b>
ببینید. (مخلص جامعه لاراول، نگارنده ریپو)
<br/>
<br/>
<br/>
<hr />

1. Consider the following code:

```php
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Queue;

Queue::XXX();
Http::XXX(function ($request) {
  return [];
});
```
You are conducting some tests and don't want to send HTTP requests or 
jobs into the queue. What method should you write instead of xxx?

<hr />

2. How to enqueue Laravel event listeners?

<hr />

3. Consider the following components in a project:

    1. You use a global middleware, to append default parameters for the language key:
    ```php
    <?php
    namespace App\Http\Middleware;
    class SetDefaultLanguageForUrls
    {
        public function handle ($request, Closure $next)
        {
            URL::defaults(['language' => 'en']);
            return $next($request);
        }
    }
    ```
    
    2. You have defined the following route for the article page:
    ```php
    Route::prefix('(language)')->group(function () {
        Route::get('article/{id}')->name('article.show');
    });
    ```
    
    3. In your `articles.blade.php`, you define the following links:
    ```php
    <div>
        @foreach ($articles as $article)
            <a href="{{ route('article. show', ['language' => 'it','id' => {{ $article->name }}]"></a>
        @endforeach
    </div>
    ```
    
    Which URI will be generated in your Blade file for the article page with `ID 1`?

<hr />

4. Write a query for joining Customer and Product tables with certain columns

<hr />

5. Implement the function encodeplaintext($text)
It receives a text for example aaaabcccaaa
You must encode it by counting each consecutive sequence of letters for ex in aaaabccca there are : 
4 times the letter a
Then 1 b
Then 3 c
Then 3 a
Therefore you must return string 4a1b3c3a 
Constraints:
Text is made of lower letters: a-z
Text is never null and has a maximum length of 15000 characters

<hr />

6. The rephase function should return the string str without spaces and laid out in lines of at most n characters 
```
Example : rephase(3,”abc de fghij”)
Returns: 
abc
def
ghi
j
```
```
Example 2: rephase(2,”1 23 456”) 
Returns:
12
34
56
Write the body of the rephase function
Note: do not add a trailing \n character
```

<hr />

7. Sample payment code must be refactored to the best practice of design pattern and clean code.
```php
public function start(Request $request, Points $points, Payments $paymentModel)
{
    $id = $points->getOrinsert(Auth::user()->id, $request->cycleld);
    $validate= resolve(Provider1 PaymentValidateUserHandler::class, ['request' => new
    Provider1PaymentValidateUserRequest()])->handleRequest();
    if ($validate == = false) {
        return redirect(route('financial-factors-form', $request->cycleld));
    }
    
    $serial = resolve(Provider1 PaymentHandler::class, ['request' => new
    Provider1PaymentRequest($id)])->handleRequest();
    if ($serial == true) {
        $payment = $paymentModel->updateOrinsert('order_id', $id, ['order_id' => $id, 'total_amount'=> self::amount, 'serial' => $serial, 'user_id' => Auth::user()->id]);
        return view('payment.redirect_to_bank', [
        'order_id' => $id,
        'serial' => $serial,
        'postback_url' => route('callback', ['amount' => self::amount, 'order_id' => $id]),
        'payment_id' => is_object($payment) ? $payment->id: $payment
            ]);
    }
    return redirect(route('pay-form', $request->cycleld));
}

public function callback(Request $request, Points $points, Payments $paymentModel)
{
    $payment = $paymentModel->getByOrderid(Auth::user()->id, $request->order_id); 
    if (!$payment) {
        Session::flash('message', _('app.payment notfound')); 
        Session::flash('alert-class', 'alert-danger');
        return redirect(URL::previous());
    }
    $response = resolve(Provider1 PaymentStatusHandler::class, ['request': => new Provider1PaymentStatusRequest($request->order_id, $payment->serial)])->handleRequest();
    if (!$response) { 
        Session::flash('message', _('app.payment notfound'));
        Session::flash('alert-class', 'alert-danger');
        return redirect(URL::previous());
    }

    $paymentModel->edit($payment->id, ['gateway' => $response['gateway'], 'status' => $response['status'], 'total_amount' => $response['total_amount']]);
    if ($response['status'] == '6') {
        $points->edit($payment->order_id, ['payment_status' => Payments::PAYED]);
        return redirect(route('reciept', $point->cycle_id));
    }
    
    return redirect(URL::previous());
}
```

<hr />

8. Implement closestTozero function to return the integer in the array $ints that is closest to zero
If there are two integers equally close to zero consider the positive element to be closer to zero <br />
(example: if $ints contains -5 and 5 return 5) If $ints is empty, return 0

Input: integers in $ints have values ranging from -2147483647 to 2147483647

<hr />

9. We consider the sequence of numbers where a number is followed by the same number plus the sum of its digits 
two sequences which starts from different numbers may join at the given point for example the sequence starting from 471 and the sequence starting from 480 share the number 519 the join point in their sequence 
Implement the function computeJoinPoint($s1,$s2)
You are guaranteed that the two sequences always join 
At a joining point lower than 20 000 000

Available ram:512MB
Timeout:6 seconds

<hr />

10. Implement a sudoku game to check each row, column, and squares

<h1>Hello, {{ $recipient->name }}!</h1>

<p>The price for the product "{{ $itemInformation->name }}" has changed.</p>

<p>Old price: {{ $itemHistory->old_price }} ({{ $itemInformation->currency }})</p>

<p>New price: {{ $itemHistory->new_price }} ({{ $itemInformation->currency }})</p>

<p>You can check the product here: <a href="{{ $itemInformation->url }}">Item</a></p>

<p>Thank you for using our service!</p>

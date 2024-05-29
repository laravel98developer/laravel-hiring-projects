@component("NDP::vendor.mail.html.message")
  hello

  Task due within the next 24 hours:

  <button><a href="{{route('task.index')}}">See Tasks</a></button>
@endcomponent
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Contact message</title>
</head>
<body>
  <h2>New contact message</h2>
  <p><strong>Name:</strong> {{ $data['name'] ?? '' }}</p>
  <p><strong>Email:</strong> {{ $data['email'] ?? '' }}</p>
  @if(!empty($data['subject']))
    <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
  @endif
  <hr>
  <p>{!! nl2br(e($data['message'])) !!}</p>
  <hr>
  <p>Sent at: {{ \Carbon\Carbon::now()->toDateTimeString() }}</p>
</body>
</html>

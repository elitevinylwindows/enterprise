<!DOCTYPE html>
<html>
<head>
    <title>{{env('APP_NAME')}}</title>
</head>
<body>
<h1>{{ $data['subject'] }}</h1>
<p>{{ $data['message'] }}</p>
<p>{{__('Thank you')}}</p>
</body>
</html>

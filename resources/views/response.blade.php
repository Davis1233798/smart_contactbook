{{-- resources/views/response.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>留言板</title>
</head>
<body>
    <h1>留言板</h1>
    <form action="{{ url( '/response/submit/$parentInfo->id ') }}" method="POST">
        @csrf
        <textarea name="message" rows="4" cols="50">在這裡留下您的訊息...</textarea>
        <br>
        <button type="submit">儲存</button>
    </form>
</body>
</html>

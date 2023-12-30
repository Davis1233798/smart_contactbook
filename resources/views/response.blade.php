{{-- resources/views/response.blade.php --}}
<!DOCTYPE html>
<html>
<head>    
    <title>留言板</title>
    感謝您撥空簽到，今日聯絡簿已成功簽名。
    歡迎在下方留言與老師交流，謝謝
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

<!-- resources/views/response_success.blade.php -->
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>提交成功</title>
    <style>
        body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f4f4f4;
    }

    .container {
        text-align: center;
        padding: 20px;
        border: 1px solid #ddd;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #333;
    }

    p {
        color: #666;
    }

    /* 響應式布局調整 */
    @media (max-width: 600px) {
        .container {
            width: 90%;
            margin: 0 auto;
        }

        body {
            padding: 10px;
        }
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>您已成功留言</h1>
        <p>感謝您的回覆。</p>
    </div>
</body>
</html>

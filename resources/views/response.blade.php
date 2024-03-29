<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言板</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }

        h1 {
            text-align: center;
        }

        .alert {
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h1>留言板</h1>
                <div class="alert alert-success">
                    感謝您撥空簽到，今日聯絡簿已成功簽名。
                </div>
                <div class="alert alert-info">
                    歡迎在下方留言與老師交流，謝謝
                </div>
                <form action="{{ url('/response/submit') }}" method="POST">
                    @csrf
                    <!-- 隱藏欄位儲存 JWT token -->
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <textarea name="message" rows="4" class="form-control" placeholder="在這裡留下您的訊息..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">送出</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
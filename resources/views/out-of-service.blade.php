<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Out of Service</title>

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #111827, #1f2937, #0f766e);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .card {
            max-width: 620px;
            width: 100%;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 24px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(14px);
        }

        .badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            color: #d1fae5;
            font-size: 14px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 32px;
            margin: 0 0 16px;
            line-height: 1.1;
        }

        p {
            font-size: 18px;
            line-height: 1.7;
            color: #e5e7eb;
            margin: 0;
        }

        .footer {
            margin-top: 28px;
            font-size: 14px;
            color: #cbd5e1;
        }
    </style>
</head>

<body>
    <main class="card">
        <div class="badge">Service Notice</div>

        <h1>Out of Service</h1>

        <p>
            This platform cannot handle any request at the moment.
        </p>

        <div class="footer">
            Error code: AuthError407.
        </div>
    </main>
</body>

</html>

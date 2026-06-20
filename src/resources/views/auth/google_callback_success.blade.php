<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Authenticating...</title>
    <style>
        body {
            background-color: #0b0f19;
            color: #f4efe3;
            font-family: sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .loader {
            border: 4px solid rgba(255, 255, 255, 0.1);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border-left-color: #c9a84c;
            animation: spin 1s linear infinite;
            margin-bottom: 16px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="loader" style="margin: 0 auto 12px;"></div>
        <div>Connecting to Chess War...</div>
    </div>
    
    <script>
        if (window.opener) {
            window.opener.location.href = '/dashboard';
            window.close();
        } else {
            window.location.href = '/dashboard';
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESTful API - Todo Application</title>
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            padding: 2rem;
            background-color: #1e293b;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            max-width: 500px;
            width: 90%;
        }
        h1 {
            color: #38bdf8;
            margin-bottom: 0.5rem;
        }
        p {
            color: #94a3b8;
            margin-bottom: 1.5rem;
        }
        .status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background-color: #059669;
            color: #ecfdf5;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Todo RESTful API</h1>
        <p>Aplikasi RESTful API untuk pengelolaan Todo List dengan autentikasi Laravel Sanctum.</p>
        <span class="status">System Status: Online</span>
    </div>
</body>
</html>

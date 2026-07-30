<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Internal Server Error</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }
        .error-container {
            max-width: 600px;
            padding: 30px;
            text-align: center;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .error-title {
            font-size: 6rem;
            font-weight: bold;
            color: #dc3545;
        }
        .error-message {
            font-size: 1.2rem;
            margin: 20px 0;
        }
        .btn-home {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
        }
    </style>
</head>
<body>

    <div class="error-container">
        <div class="error-title">
            500
        </div>
        <h3 class="text-danger">Oops! Something went wrong.</h3>
        <p class="error-message">An internal server error has occurred. Please try again later or contact support.</p>
        <div class="alert alert-warning">
            <strong>Error Details:</strong> {{ $exception->getMessage() }}
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

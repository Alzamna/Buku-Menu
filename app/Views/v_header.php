<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .header {
            background-color: #fff;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .menu-category {
            overflow-x: auto;
            white-space: nowrap;
            padding: 0.5rem 1rem;
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .menu-category button {
            margin-right: 10px;
        }

        .menu-item {
            background-color: #fff;
            margin-bottom: 1rem;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .menu-item img {
            width: 100%;
            max-height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .menu-name {
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 0.5rem;
        }

        .menu-price {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
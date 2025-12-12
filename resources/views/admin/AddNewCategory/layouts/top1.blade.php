<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .page-title {
            margin-bottom: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .icon-picker-container {
            position: relative;
        }
        .icon-picker-container .dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
            width: 100%;
            padding: 10px;
        }
        .icon-picker-container .dropdown-item {
            cursor: pointer;
            padding: 10px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }
        .icon-picker-container .dropdown-item:hover {
            background-color: #f0f0f0;
        }
        .icon-picker-container .dropdown-item i {
            font-size: 24px;
            margin-right: 10px;
        }
        .icon-picker-container .dropdown-item.selected {
            background-color: #007bff;
            color: #fff;
        }
        .search-box {
            margin-bottom: 10px;
            width: 100%;
            border-radius: 5px;
            padding: 5px;
            border: 1px solid #ced4da;
        }
        .btn-lg {
            font-size: 1.25rem;
            padding: 0.75rem 1.25rem;
        }
        .dropdown-toggle {
            display: flex;
            align-items: center;
        }
        .dropdown-toggle i {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
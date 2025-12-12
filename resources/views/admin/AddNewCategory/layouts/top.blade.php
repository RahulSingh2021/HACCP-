<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 30px;
        }

        .card {
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            object-fit: cover;
            height: 200px;
        }

        .card-body {
            background-color: #ffffff;
        }

        .list-group-item {
            border: 0;
            border-bottom: 1px solid #dee2e6;
            position: relative;
        }

        .list-group-item:last-child {
            border-bottom: 0;
        }

        .edit-delete-buttons {
            display: none;
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            padding: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .list-group-item:hover .edit-delete-buttons,
        .card:hover .edit-delete-buttons {
            display: block;
        }

        .btn-edit,
        .btn-delete {
            margin: 0 2px;
        }

        .space-add {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem;
        }

        .page-title {
            margin: 0;
            font-size: 1.5rem;
        }

        .btn-rounded {
            border-radius: 50px;
        }

        .title_icon {
            margin-right: 0.5rem;
        }

        .alignToTitle {
            margin-left: auto; 
        }
    </style>
</head>

<body>

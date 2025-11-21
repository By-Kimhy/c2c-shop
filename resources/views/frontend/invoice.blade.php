<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <title>វិក្កយបត្រ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Load Kantumruy Pro Khmer font --}}
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Kantumruy Pro', sans-serif;
            padding: 40px;
        }

        h2, h4, h5, p {
            margin: 0;
        }

        .invoice-container {
            max-width: 900px;
            margin: auto;
            border: 1px solid #ccc;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .order_details_table {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 10px 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .print-btn {
            margin-top: 30px;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="invoice-container">
        <h2>វិក្កយបត្រ</h2>

        {{-- Optional user or invoice details --}}
        <p>ឈ្មោះអតិថិជន៖ ST5</p>
        <p>កាលបរិច្ឆេទ៖ {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>

        <div class="order_details_table">
            <h3>ព័ត៌មានលម្អិតនៃការបញ្ជាទិញ</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ផលិតផល</th>
                            <th>ចំនួន</th>
                            <th>សរុប</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><p>addidas New Hammer sole​​ សម្រាប់អ្នកកីឡា</p></td>
                            <td><h5>x 02</h5></td>
                            <td><p>$720.00</p></td>
                        </tr>
                        <tr>
                            <td><p>addidas New Hammer sole​​ សម្រាប់អ្នកកីឡា</p></td>
                            <td><h5>x 02</h5></td>
                            <td><p>$720.00</p></td>
                        </tr>
                        <tr>
                            <td><p>addidas New Hammer sole​​ សម្រាប់អ្នកកីឡា</p></td>
                            <td><h5>x 02</h5></td>
                            <td><p>$720.00</p></td>
                        </tr>
                        <tr>
                            <td><h4>សរុបទឹកប្រាក់</h4></td>
                            <td></td>
                            <td><p>$2160.00</p></td>
                        </tr>
                    </tbod

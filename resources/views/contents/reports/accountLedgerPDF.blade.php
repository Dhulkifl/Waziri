<!DOCTYPE html>
<html>
<head>
    <title>Account Ledger Report</title>
    <style>
        body{
            font-family: sans-serif;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 2px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>{{$report[0]['account_name']}} Transaction Report</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Project Name</th>
                <th>Description</th>
                <th>Cash In</th>
                <th>Cash Out</th>
                <th>Currency</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report[0]['data'] as $index => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['project_name'] }}</td>
                    <td style="font-family: sans-serif !important;">{{ $item['description'] }}</td>
                    <td>{{ $item['cash_in'] }}</td>
                    <td>{{ $item['cash_out'] }}</td>
                    <td>{{ $item['currency'] }}</td>
                    <td>{{ $item['date'] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr >
                <td colspan="7" style="font-weight: bold; padding-top: 10px; padding-bottom: 10px;">TOTAL</td>
            </tr>
            <tr style="font-weight: bold;">
                <td colspan="2" style="font-weight: bold;"> Cash In AFN: {{ number_format($report[0]['totals']['AFN']['cash_in']) }}</td>
                <td colspan="2" style="font-weight: bold;"> Cash Out AFN: {{ number_format($report[0]['totals']['AFN']['cash_out']) }}</td>
                <td colspan="3" style="font-weight: bold;">On Hand: {{number_format(abs($report[0]['totals']['AFN']['cash_in'] - $report[0]['totals']['AFN']['cash_out']))}} AFN</td>
                
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;"> Cash In USD: {{ number_format($report[0]['totals']['USD']['cash_in']) }}</td>
                <td colspan="2" style="font-weight: bold;"> Cash Out USD: {{ number_format($report[0]['totals']['USD']['cash_out']) }}</td>
                <td colspan="3" style="font-weight: bold;">On Hand: {{ number_format(abs($report[0]['totals']['USD']['cash_in'] - $report[0]['totals']['USD']['cash_out']))}} USD</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
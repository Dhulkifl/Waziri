<!DOCTYPE html>
<html dir="rtl">
<head>
    <title>Account Summary Report</title>
    <style>
        body{
            font-family: sans-serif;
        }
        table { border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 2px; text-align: center; }
        th { background-color: #f2f2f2; }
        .balance-table {
            margin-top: 20px;
        }
        .balance-table th, .balance-table td {
            text-align: center;
        }
        .space {
            margin-bottom: 20px;
        }
        .px{
            padding-right: 20px;
            padding-left: 20px;
        }
        .table-container {
            display: flex;
            justify-content: space-between;
        }
        .table-container table {
            width: 33.33%;
            margin: auto;
        }
        .table-container .space {
            width: 33.33%;
        }
        .center {
            text-align: center;
        }
        .px{
            width: 200px;
            max-width: 250px;
        }
        
    </style>
</head>
<body>
    <p class="center" style="font-size: 20px;"><span>دفتر خدمات پروژه عزیزی پلازا</span> <br> <span>تصفیه حساب برج میزان 1403</span></p>
    <div class="table-container">
        <table>
            <tr>
                <th colspan="3">جدول عایدات</th>
            </tr>
            <tr>
                <th class="px">موضوع عاید</th>
                <th class="px">واحد پولی</th>
                <th class="px">مقدار</th>
            </tr>
            @foreach($report[0]['incomes'] as $income)
                <tr>
                    <td class="px">{{ $income['account_name'] }}</td>
                    <td class="px">{{ $income['currency'] }} </td>
                    <td class="px">{{ number_format($income['amount']) }} @if($income['currency'] == 'USD') $ @else &#1547; @endif</td>
                </tr>
            @endforeach
        </table>
        <div class="space"></div>
        <table>
            <tr>
                <th colspan="3">جدول مصارف</th>
            </tr>
            <tr>
                <th class="px">موضوع مصرف</th>
                <th class="px">واحد پولی</th>
                <th class="px">مقدار</th>
            </tr>
            @foreach($report[0]['expenses'] as $expense)
                <tr>
                    <td class="px">{{ $expense['account_name'] }}</td>
                    <td class="px">{{ $expense['currency'] }}</td>
                    <td class="px">{{ number_format($expense['amount']) }} @if($income['currency'] == 'USD') $ @else &#1547; @endif</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div style="height: 20px;"></div>
    <table class="balance-table" style="margin: auto;">
        <tr>
            <th colspan="2">تصفیه حساب</th>
        </tr>
        <tr>
            <th class="px">مجموعه عاید افغانی:</th>
            <td class="px">{{ number_format($report[0]['totalIncomeAFN']) }} &#1547;</td>
        </tr>
        <tr>
            <th class="px"> مجموعه عاید دالر:</th>
            <td class="px">{{ number_format($report[0]['totalIncomeUSD']) }} $</td>
        </tr>
        <tr>
            <th class="px">مجموعه مصرف  افغانی:</th>
            <td class="px">{{ number_format($report[0]['totalExpensesAFN']) }} &#1547;</td>
        </tr>
        <tr>
            <th class="px"> مجموعه مصرف دالر:</th>
            <td class="px">{{ number_format($report[0]['totalExpensesUSD']) }} $</td>
        </tr>
        <tr>
            <th class="px">فاضل/باقی افغانی:</th>
            <td>{{ number_format($report[0]['balanceAFN']) }} &#1547;</td>
        </tr>
        <tr>
            <th class="px">فاضل/باقی دالر:</th>
            <td>{{ number_format($report[0]['balanceUSD']) }} $</td>
        </tr>
    </table>
</body>
</html>
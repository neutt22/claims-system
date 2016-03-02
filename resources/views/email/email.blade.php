<html>
<head>
    <style>
        .email-container {
            width: 100%;
            border: 1px solid #bbbbbb;
            padding: 10px;
        }
        h4 {
            margin: 0;
            text-align: center;
            color: #3b3b3b;
            font-family: Helvetica, Arial;
        }
        h5 {
            text-align: center;
            margin: 0;
            color: #525252;
        }

    </style>
</head>
</html>
<div class="email-container">
    <h4>GIBX Claims System Daily Report</h4>
    <h5>This is a system generated report</h5>
    <hr>
    <div style="font-size: 13px;">
        <span style="font-size: 11px;">Today:</span><span>{{ \Carbon\Carbon::now('Asia/Manila') }}</span>
    </div>
    <div>
        <h5>List of Claimants Deadline Today</h5>
    </div>
    <table style="width:100%; border-collapse: collapse;">
        <thead>
        <th>Principal</th>
        <th>Claimant</th>
        <th>COC</th>
        <th>Documents</th>
        <th>Inception</th>
        <th>Encoded</th>
        <th>Amount</th>
        <th>Stage</th>
        <th>Deadline</th>
        <th>Status</th>
        </thead>
        <tbody>
            @foreach($data as $deadline_names)
                <tr>
                    <td>
                        {{ $deadline_names['name'] }}
                    </td>
                    <td>
                        {{ $deadline_names['claimant'] }}
                    </td>
                    <td>
                        {{ $deadline_names['coc'] }}
                    </td>
                    <td>
                        {{ $deadline_names['documents'] }}
                    </td>
                    <td>
                        {{ $deadline_names['inception']->format('m/d/Y') }}
                    </td>
                    <td>
                        {{ $deadline_names['encoded']->format('m/d/Y') }}
                    </td>
                    <td>
                        {{ $deadline_names['amount'] }}
                    </td>
                    <td>
                        {{ $deadline_names['stage'] }}
                    </td>
                    <td>
                        {{ $deadline_names['dead_line']->format('m/d/Y h:i A') }}
                    </td>
                    <td>
                        <span>
                          {{ $deadline_names['claim_status'] }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
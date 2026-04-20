<!DOCTYPE html>
<html>

<head>
    <title>Failed Payment Notification</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
        }
        body {
            margin: 0 !important;
            padding: 0 !important;
            background-color: #f4f4f4;
        }
        table {
            border-collapse: collapse !important;
        }
        a {
            color: #1f283c;
            text-decoration: none;
        }
        img {
            border: 0;
            outline: none;
            text-decoration: none;
            height: auto;
            line-height: 100%;
        }
        @media screen and (max-width: 600px) {
            h1 {
                font-size: 24px !important;
                line-height: 28px !important;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0; width: 100%; background-color: #f4f4f4;">
    <table class="ttt" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#1F283C" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" style="padding: 40px 10px;">
                            <h1 style="color: #ffffff; font-family: Arial, sans-serif; font-size: 24px; font-weight: bold; margin: 0;">Failed Payment Notification</h1>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 10px 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; color: #666666;">
                            <p style="margin: 0;">Dear Admin,</p>
                            <p style="margin: 0;">We have detected a failed payment attempt on POSWiz. Below are the details for your review:</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; color: #666666;">
                            <h3 style="margin: 0; color: #1f283c;">User Details:</h3>
                            <p style="margin: 0;"><strong>Name:</strong> {{$name}}</p>
                            <p style="margin: 0;"><strong>Email:</strong> {{$email}}</p>
                            <p style="margin: 0;"><strong>Contact Number:</strong> {{$phone}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; color: #666666;">
                            <h3 style="margin: 0; color: #1f283c;">Transaction Details:</h3>
                            <p style="margin: 0;"><strong>Date and Time:</strong> {{$payment_dateTime}}</p>
                            <p style="margin: 0;"><strong>Transaction ID:</strong> {{$transaction_id}}</p>
                            <p style="margin: 0;"><strong>Amount:</strong> {{$amount}}</p>
                            <p style="margin: 0;"><strong>Payment Method:</strong> {{$payment_method}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; color: #666666;">
                            <h3 style="margin: 0; color: #1f283c;">Error Details:</h3>
                            <p style="margin: 0;"><strong>Reason for Failure:</strong> {{$error_message}}</p>
                            <p style="margin: 0;"><strong>Card Type:</strong> {{$card_type}}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" align="left" style="padding: 20px; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; color: #666666;">
                <p style="margin: 0;">Please review the issue and take appropriate action. You may choose to contact the user to resolve the payment problem.</p>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 10px 0;">
                <p style="margin: 0; font-family: Arial, sans-serif; font-size: 12px; color: #999999;">POSWiz Support Team</p>
            </td>
        </tr>
    </table>
</body>

</html>

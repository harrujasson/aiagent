<!DOCTYPE html>
<html>

<head>
    <title>{{$title}}</title>
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
                            <h1 style="color: #ffffff; font-family: Arial, sans-serif; font-size: 24px; font-weight: bold; margin: 0;">{{$title}}</h1>
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
                            <p style="margin: 0;">A new subscription has been created on our website. Below are the details for your review and any necessary action.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; color: #666666;">
                            <h3 style="margin: 0; color: #1f283c;">Subscriber Details:</h3>
                            <p style="margin: 0;"><strong>Name:</strong> {{$name}}</p>
                            <p style="margin: 0;"><strong>Email:</strong> {{$email}}</p>
                            <p style="margin: 0;"><strong>Contact Number:</strong> {{$phone}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; color: #666666;">
                            <h3 style="margin: 0; color: #1f283c;">Subscription  Details:</h3>
                            <p><span class="strong">Subscription ID:</span> {{$subscription_id}}</p>
                            <p><span class="strong">Plan:</span> {{$plan}}</p>
                            <p><span class="strong">Amount:</span> {{$amount}}</p>
                        
                            <p><span class="strong">Start Date:</span> {{$start_date}}</p>
                            <p><span class="strong">Payment Method:</span> {{$payment_method}}</p>
                    
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" align="left" style="padding: 20px; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; color: #666666;">
                <p style="margin: 0;">Please review the subscription and take any required action. You can view the subscription in the admin panel for more details.</p>
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

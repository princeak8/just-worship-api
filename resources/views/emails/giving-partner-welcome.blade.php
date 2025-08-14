<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Partnership</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #6b4e00; /* fallback for older email clients */
            background: linear-gradient(135deg, #6b4e00 0%, #8a6a0a 50%, #a97c0f 100%);
            color: white;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.25);
            padding: 30px 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px 20px;
            border-radius: 0 0 10px 10px;
        }
        .highlight {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }
        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
        }

        .payment-accounts {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #8a6a0a;
        }

        .payment-accounts h3 {
            color: #6b4e00;
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .payment-accounts h4 {
            color: #8a6a0a;
            margin-bottom: 10px;
        }

        .payment-accounts .account {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px dashed #eee;
        }

        .payment-accounts .account:last-child,
        .payment-accounts .online-payments {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .payment-accounts ul {
            padding-left: 20px;
        }

        .payment-accounts a {
            color: #667eea;
            text-decoration: none;
        }

        .payment-accounts a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Thank You, {{ $partner->full_name }}! ❤️</h1>
        <p>Your heart to partner with Just Worship International through giving is deeply appreciated.</p>
    </div>
    
    <div class="content">
        <p>Dear <b>{{ $partner->firstname }},</b></p>
        
        <p>We have received your partnership commitment and we are incredibly grateful for your generous heart. 
            Your support enables us to continue the mission of filling the earth with the worship our God and raising true worshippers.</p>
        
        <div class="highlight">
            <h3>Your Partnership Details:</h3>
            <p><strong>Amount:</strong> <span class="amount">${{ $partner->formatted_amount }}</span></p>
            <p><strong>Type:</strong> {{ $partner->recurrent ? $partner->recurrent_type . ' Recurring' : 'One-time' }} Donation</p>
            
            <!-- @if($partner->prayer_point)
            <p><strong>Prayer Request:</strong> {{ $partner?->prayer_point ?? "-" }}</p>
            @endif -->
        </div>
        
        @if($partner->recurrent)
        <p><strong>Recurring Donation:</strong> Thank you for committing to a recurring partnership! This will help us plan better and create more impact. We will send you reminders and updates about your recurring contributions.</p>
        @else
        <p><strong>One-time Donation:</strong> Your one-time gift makes an immediate impact. Every contribution, regardless of size, makes a difference in the lives we serve.</p>
        @endif
        
        @if($partner->prayer_point)
        <p><strong>Your Prayer Request:</strong> We have received your prayer request and our prayer team will be interceding on your behalf. God hears and answers prayers!</p>
        @endif
        
        <p>use the accounts below for your donation. <br/> If you have any questions or need to make changes to your partnership details, please don't hesitate to contact us.</p>

        <div class="payment-accounts">
            <h3>Bank Transfer Details:</h3>

            @foreach ($bankAccounts as $bankAccount)
                <div class="account">
                    <!-- <h4>USD Account (International Transfers)</h4> -->
                    <p><strong>Bank Name:</strong> {{ $bankAccount->bank }}</p>
                    <p><strong>Account Name:</strong> {{ $bankAccount->name }}</p>
                    <p><strong>Account Number:</strong> {{ $bankAccount->number }}</p>
                    <p><strong>Currency:</strong> {{ $bankAccount->currency }}</p>
                </div>
            @endforeach
            
            <!-- <div class="account">
                <!- <h4>USD Account (International Transfers)</h4> --
                <p><strong>Bank Name:</strong> Your Bank Name</p>
                <p><strong>Account Name:</strong> Just Worship International</p>
                <p><strong>Account Number:</strong> 1234567890</p>
                <p><strong>SWIFT/BIC:</strong> BANKUS33</p>
                <p><strong>Routing Number:</strong> 021000021</p>
            </div>
            
            <div class="account">
                <!- <h4>Local Currency Account</h4> --
                <p><strong>Bank Name:</strong> Local Bank Name</p>
                <p><strong>Account Name:</strong> Just Worship International</p>
                <p><strong>Account Number:</strong> 0987654321</p>
                <p><strong>Sort Code:</strong> 12-34-56</p>
            </div> -->
            
            <div class="online-payments">
                <h3>Online Payment Options:</h3>
                <ul>
                    @foreach ($onlineAccounts as $onlineAccount)
                        <li><strong>{{ $onlineAccount->name }}:</strong> <a href="{{ $onlineAccount->url }}" >{{ $onlineAccount->url }}</a></li>
                    @endforeach
                    <!-- <li><strong>PayPal:</strong> paypal@justworshipinternational.com</li> -->
                    <!-- <li><strong>Stripe:</strong> <a href="https://pay.justworshipinternational.com">pay.justworshipinternational.com</a></li> -->
                    <!-- <li><strong>Mobile Money:</strong> +1234567890 (Provider Name)</li> -->
                </ul>
            </div>
        </div>
        
        <p>May God bless you abundantly as you bless others through your generosity.</p>
        
        <p>With gratitude,<br>
        <strong>Just Worship International</strong></p>
    </div>
    
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>If you need assistance, please contact us at support@justworshipinternational.com</p>
    </div>
</body>
</html>
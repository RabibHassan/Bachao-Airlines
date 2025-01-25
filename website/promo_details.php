<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotion Details - Bachao Airlines</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f6f9fc 0%, #e9f2ff 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .promo-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .promo-code {
            background: #FF8C00;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 24px;
            display: inline-block;
            margin: 20px 0;
        }

        .terms {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .terms h3 {
            color: #333;
        }

        .terms ul {
            padding-left: 20px;
        }

        .terms li {
            margin: 10px 0;
            color: #666;
        }
    </style>
</head>
<body>
    <?php
    $promoCode = $_GET['code'] ?? '';
    $promoDetails = [
        'BKASH20' => [
            'title' => '20% Off with bKash Payment',
            'description' => 'Get 20% discount up to 2000৳ on domestic flights when paying with bKash',
            'terms' => [
                'Offer valid until December 31, 2024',
                'Maximum discount of 2000৳ per transaction',
                'Valid only for domestic flights',
                'Must pay using bKash to avail the offer'
            ]
        ],
        'STUDENT10' => [
            'title' => '10% Student Discount',
            'description' => 'Special discount for students on all flights',
            'terms' => [
                'Valid student ID required at check-in',
                'Maximum discount of 3000৳',
                'One booking per student ID',
                'Not combinable with other offers'
            ]
        ],
        'MASTER35' => [
            'title' => '35% Off with MasterCard',
            'description' => 'Exclusive discount for MasterCard holders on all flights',
            'terms' => [
                'Valid on MasterCard credit/debit cards only',
                'Maximum discount of 5000৳',
                'Valid till December 31, 2024',
                'Not applicable on promotional fares'
            ]
        ],
        'GP25' => [
            'title' => '25% Off for GP STAR',
            'description' => 'Special discount for Grameenphone STAR members',
            'terms' => [
                'Valid GP STAR membership required',
                'Maximum discount of 3000৳',
                'One booking per GP number per month',
                'Valid on domestic routes only'
            ]
        ],
        'ROBI20' => [
            'title' => '20% Off for Robi Users',
            'description' => 'Exclusive discount for Robi subscribers',
            'terms' => [
                'Valid Robi number verification required',
                'Maximum discount of 2500৳',
                'Valid on all routes',
                'Cannot be combined with other offers'
            ]
        ],
        'UNI15' => [
            'title' => '15% Off with Unilever',
            'description' => 'Special partner discount for Unilever customers',
            'terms' => [
                'Must show Unilever product purchase receipt',
                'Maximum discount of 2000৳',
                'Valid for 30 days from purchase',
                'Subject to seat availability'
            ]
        ],
        'PRAN25' => [
            'title' => '25% Off with PRAN Products',
            'description' => 'Special discount for PRAN product buyers',
            'terms' => [
                'Must present PRAN product purchase receipt of min 1000৳',
                'Maximum discount of 3000৳',
                'Valid for domestic flights only',
                'Receipt must be within last 7 days'
            ]
        ],
        'DBBL30' => [
            'title' => '30% Off with Dutch-Bangla Bank',
            'description' => 'Exclusive offer for DBBL card holders',
            'terms' => [
                'Valid on DBBL credit/debit cards',
                'Maximum discount of 4000৳',
                'Valid till June 30, 2024',
                'Minimum transaction amount 10000৳'
            ]
        ],
        'CITY40' => [
            'title' => '40% Off with City Bank AMEX',
            'description' => 'Premium discount for City Bank American Express cards',
            'terms' => [
                'Valid only on City Bank AMEX cards',
                'Maximum discount of 6000৳',
                'Valid for international flights',
                'Weekend surcharge may apply'
            ]
        ],
        'PATHAO20' => [
            'title' => '20% Off for Pathao Users',
            'description' => 'Special discount for Pathao platinum members',
            'terms' => [
                'Must show Pathao platinum membership',
                'Maximum discount of 2500৳',
                'Valid on domestic routes',
                'One booking per Pathao account'
            ]
        ],
        'FAMILY25' => [
            'title' => '25% Family Package Discount',
            'description' => 'Special savings for family travelers',
            'terms' => [
                'Minimum 4 passengers required',
                'Maximum discount of 10000৳',
                'Valid on same flight booking',
                'Must be immediate family members'
            ]
        ],
        'SUMMER30' => [
            'title' => '30% Summer Holiday Special',
            'description' => 'Beat the heat with cool travel deals',
            'terms' => [
                'Valid from May to July 2024',
                'Maximum discount of 5000৳',
                'Valid on all routes',
                'Blackout dates apply during Eid'
            ]
        ],
        'FIRST40' => [
            'title' => '40% First Flight Discount',
            'description' => 'Special welcome offer for first-time flyers',
            'terms' => [
                'First-time booking on Bachao Airlines only',
                'Maximum discount of 4000৳',
                'Valid on domestic flights',
                'Must create account to avail'
            ]
        ],
        'NAGAD15' => [
            'title' => '15% Off with Nagad',
            'description' => 'Digital payment partner discount',
            'terms' => [
                'Must pay using Nagad wallet',
                'Maximum discount of 2000৳',
                'Valid till December 2024',
                'Minimum fare 5000৳'
            ]
        ]
    ];

    $promo = $promoDetails[$promoCode] ?? null;
    ?>

    <div class="container">
        <?php if ($promo): ?>
            <div class="promo-header">
                <h1><?php echo htmlspecialchars($promo['title']); ?></h1>
                <div class="promo-code"><?php echo htmlspecialchars($promoCode); ?></div>
                <p><?php echo htmlspecialchars($promo['description']); ?></p>
            </div>

            <div class="terms">
                <h3>Terms & Conditions</h3>
                <ul>
                    <?php foreach ($promo['terms'] as $term): ?>
                        <li><?php echo htmlspecialchars($term); ?></li>
                    <?php endforeach; ?>
                    <li>Bachao Airlines reserves the right to modify or cancel this offer without prior notice</li>
                    <li>All standard Bachao Airlines terms and conditions apply</li>
                </ul>
            </div>
        <?php else: ?>
            <div class="promo-header">
                <h1>Promo Code is not Available Right Now</h1>
                <p>The requested promotion code is not valid.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
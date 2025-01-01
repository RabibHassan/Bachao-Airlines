<!-- <?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $database = "flights";

// $conn = new mysqli($servername, $username, $password, $database);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $sql = "SELECT * FROM `flight-1`";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     $index = 1; 
//     while ($row = $result->fetch_assoc()) {
//         ${"start_time" . $index} = $row['Start_time'];
//         ${"end_time" . $index} = $row['end_time'];
//         ${"duration" . $index} = $row['Duration'];
//         ${"from" . $index} = $row['Flight_from'];
//         ${"to" . $index} = $row['DHK'];
//         ${"type" . $index} = $row['Type'];
//         ${"start_date" . $index} = $row['Start_date'];
//         ${"land_date" . $index} = $row['Land_date'];
//         ${"ID" . $index} = $row['Flight_ID'];
//         ${"price" . $index} = $row['Price'];
        
//         $index++;
//     }
// }
// else {
//     echo "No flight data found.";
// }

// $conn->close();
?> -->
<!DOCTYPE html>
<html>
    <head>
        <title>Bachao Airlines</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles/header.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&family=Murecho:wght@100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/body.css">
    <style>
        html
        {
            scroll-behavior: smooth;
        }
    </style>
    </head>

    <body>
        <nav class="header1">
            <div class="store-logo">
                <img class="logost" src="pics/piclogo-removebg-preview.png">
            </div>
            <div class="search">
                <input class="searchbar" type="search" name="search" placeholder="Filter your flight search ✈︎ ">
                <img class="glass" src="pics/AIRPLANE LOGO DESIGN.png">
            </div>
            <div class="contact">
                <div class="con-up">
                    <p class="c1-text" >Need help? Connect with us on  </p>
                    <img class="ig" src="pics/ig-removebg-preview.png">
                </div>
                <div>
                    <a class="c-text" href="https://www.instagram.com/rababechan/" target="_blank">@rababechan | </a>
                    <a class="c-text" href="https://www.instagram.com/monir_akib/" target="_blank"> @monir_akib | </a>
                    <a class="c-text" href="https://www.instagram.com/ia.yamin/" target="_blank"> @ia.yamin </a>
                </div>
            </div>
            <div class="guest">
                <img class="guest-logo" src="pics/guest-removebg-preview.png">
            </div>
            <div class="log-in">
                <button style="color: rgb(48, 47, 47);; font-family: Murecho; font-weight:700;" type="button" class="login-button" 
                onclick="location.href='//monirakib.github.io/BachaoAIrlines-Login-Page/'" target="_blank">
                    <p>Login</p>
                </button>
            </div>
            <div>

            </div>
        </nav>
        
        <nav class="header2">
            <div class="head2">
                <div class="head2t">
                    <p>Reward Points</p>
                </div>
                <div class="head2t">
                    <p>Travel Insurance</p>
                </div>
                <div class="head2t">
                    <p>PromoCodes</p>
                </div>
                <div class="head2t">
                    <p>Discounts</p>
                </div>
                <div class="head2t">
                    <p>Our Recommendation</p>
                </div>
                <div class="head2t">
                    <a style="color: rgb(104, 102, 102); font-family: Murecho; font-weight: 700;" class="f-text" href="https://iayamin6.github.io/BFeedback/" target="_blank">
                        Customer Support
                    </a>
                </div>
            </div>
        </nav>
        <video class="video1" autoplay muted loop plays-inline>
            <source src="pics/Orange Blue Modern Travel Video (4150 x 1080 px).mp4"
            type="video/mp4">
        </video>
        <nav class="header3">
            <div class="head3">
                <h2 class="tagline">Fly Beyond Horizons, Explore the World Your Way!</h2>
                <p class="sub-tagline">Still dreaming of your perfect getaway? Book your dream destination now!</p>
                <div class="book-button">
                    <a href="#book" class="book-linkSmoothScroll">
                        <button> Book now</button>
                    </a>
                </div>
            </div>
            <div class="book-plane-animation">
                <img src="pics/airplane.png" alt="Plane" class="book-plane">
            </div>
        </nav>

    <div class="flight-details-grid" id="book">
        <div class="box">
            <div class="ticket-brief">
                <div class="tb">
                    <p class="tedit">💎Partially refundable</p>
                </div>
                <div class="tb">
                    <p class="tedit">💰Best deal</p>
                </div>
                <div class="tb">
                    <p class="tedit">🕓Pay later</p>
                </div>
            </div>
            <div class="time">
                <div class="departure">
                    <p class="tedit"><?php echo htmlspecialchars($start_time1);?></p>
                </div>
                <div class="duration">
                    <p class="tedit"><?php echo htmlspecialchars($duration1);?></p>
                </div>
                <div class="arrival">
                    <p class="tedit"><?php echo htmlspecialchars($end_time1);?></p>
                </div>
            </div>
            <div class="destination">
                <div class="from">
                    <p class="tedit"><?php echo htmlspecialchars($from1);?></p>
                </div>
                <div class="logo">
                    <img class="minilogo" src="pics/black_minimalist_jet_airplane_logo_design__1_-removebg-preview.png">
                </div>
                <div class="to">
                    <p class="tedit"><?php echo htmlspecialchars($to1);?></p>
                </div>
            </div>
            <div class="date">
                <div class="stdate">
                    <p class="tedit2"><?php echo htmlspecialchars($start_date1);?></p>
                </div>
                <div class="type">
                    <p class="tedit2"><?php echo htmlspecialchars($type1);?></p>
                </div>
                <div class="enddate">
                    <p class="tedit2"><?php echo htmlspecialchars($land_date1);?></p>
                </div>
            </div>
            <div class="ticket-price">
                <div ticket-id-price>
                    <div id>
                        <p style="margin-top: 5px;" class="tedit2">🎫<?php echo htmlspecialchars($ID1);?></p>
                    </div>
                    <div price>
                        <p class="tedit3"><?php echo htmlspecialchars($price1);?></p>
                    </div>
                </div>
                <div class="select">
                    <button style="color: aliceblue; font-weight: 700;" 
                    class="select-button">
                        Select>
                    </button>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="ticket-brief">
                <div class="tb">
                    <p class="tedit">💎Partially refundable</p>
                </div>
                <div class="tb">
                    <p class="tedit">💰Best deal</p>
                </div>
                <div class="tb">
                    <p class="tedit">🕓Pay later</p>
                </div>
            </div>
            <div class="time">
                <div class="departure">
                    <p class="tedit"><?php echo htmlspecialchars($start_time2);?></p>
                </div>
                <div class="duration">
                    <p class="tedit"><?php echo htmlspecialchars($duration2);?></p>
                </div>
                <div class="arrival">
                    <p class="tedit"><?php echo htmlspecialchars($end_time2);?></p>
                </div>
            </div>
            <div class="destination">
                <div class="from">
                    <p class="tedit"><?php echo htmlspecialchars($from2);?></p>
                </div>
                <div class="logo">
                    <img class="minilogo" src="pics/black_minimalist_jet_airplane_logo_design__1_-removebg-preview.png">
                </div>
                <div class="to">
                    <p class="tedit"><?php echo htmlspecialchars($to2);?></p>
                </div>
            </div>
            <div class="date">
                <div class="stdate">
                    <p class="tedit2"><?php echo htmlspecialchars($start_date2);?></p>
                </div>
                <div class="type">
                    <p class="tedit2"><?php echo htmlspecialchars($type2);?></p>
                </div>
                <div class="enddate">
                    <p class="tedit2"><?php echo htmlspecialchars($land_date2);?></p>
                </div>
            </div>
            <div class="ticket-price">
                <div ticket-id-price>
                    <div id>
                        <p style="margin-top: 5px;" class="tedit2">🎫<?php echo htmlspecialchars($ID2);?></p>
                    </div>
                    <div price>
                        <p class="tedit3"><?php echo htmlspecialchars($price2);?></p>
                    </div>
                </div>
                <div class="select">
                    <button style="color: aliceblue; font-weight: 700;" 
                    class="select-button">
                        Select>
                    </button>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="ticket-brief">
                <div class="tb">
                    <p class="tedit">💎Partially refundable</p>
                </div>
                <div class="tb">
                    <p class="tedit">💰Best deal</p>
                </div>
                <div class="tb">
                    <p class="tedit">🕓Pay later</p>
                </div>
            </div>
            <div class="time">
                <div class="departure">
                    <p class="tedit"><?php echo htmlspecialchars($start_time3);?></p>
                </div>
                <div class="duration">
                    <p class="tedit"><?php echo htmlspecialchars($duration3);?></p>
                </div>
                <div class="arrival">
                    <p class="tedit"><?php echo htmlspecialchars($end_time3);?></p>
                </div>
            </div>
            <div class="destination">
                <div class="from">
                    <p class="tedit"><?php echo htmlspecialchars($from3);?></p>
                </div>
                <div class="logo">
                    <img class="minilogo" src="pics/black_minimalist_jet_airplane_logo_design__1_-removebg-preview.png">
                </div>
                <div class="to">
                    <p class="tedit"><?php echo htmlspecialchars($to3);?></p>
                </div>
            </div>
            <div class="date">
                <div class="stdate">
                    <p class="tedit2"><?php echo htmlspecialchars($start_date3);?></p>
                </div>
                <div class="type">
                    <p class="tedit2"><?php echo htmlspecialchars($type3);?></p>
                </div>
                <div class="enddate">
                    <p class="tedit2"><?php echo htmlspecialchars($land_date3);?></p>
                </div>
            </div>
            <div class="ticket-price">
                <div ticket-id-price>
                    <div id>
                        <p style="margin-top: 5px;" class="tedit2">🎫<?php echo htmlspecialchars($ID3);?></p>
                    </div>
                    <div price>
                        <p class="tedit3"><?php echo htmlspecialchars($price3);?></p>
                    </div>
                </div>
                <div class="select">
                    <button style="color: aliceblue; font-weight: 700;" 
                    class="select-button">
                        Select>
                    </button>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="ticket-brief">
                <div class="tb">
                    <p class="tedit">💎Partially refundable</p>
                </div>
                <div class="tb">
                    <p class="tedit">💰Best deal</p>
                </div>
                <div class="tb">
                    <p class="tedit">🕓Pay later</p>
                </div>
            </div>
            <div class="time">
                <div class="departure">
                    <p class="tedit"><?php echo htmlspecialchars($start_time4);?></p>
                </div>
                <div class="duration">
                    <p class="tedit"><?php echo htmlspecialchars($duration4);?></p>
                </div>
                <div class="arrival">
                    <p class="tedit"><?php echo htmlspecialchars($end_time4);?></p>
                </div>
            </div>
            <div class="destination">
                <div class="from">
                    <p class="tedit"><?php echo htmlspecialchars($from4);?></p>
                </div>
                <div class="logo">
                    <img class="minilogo" src="pics/black_minimalist_jet_airplane_logo_design__1_-removebg-preview.png">
                </div>
                <div class="to">
                    <p class="tedit"><?php echo htmlspecialchars($to4);?></p>
                </div>
            </div>
            <div class="date">
                <div class="stdate">
                    <p class="tedit2"><?php echo htmlspecialchars($start_date4);?></p>
                </div>
                <div class="type">
                    <p class="tedit2"><?php echo htmlspecialchars($type4);?></p>
                </div>
                <div class="enddate">
                    <p class="tedit2"><?php echo htmlspecialchars($land_date4);?></p>
                </div>
            </div>
            <div class="ticket-price">
                <div ticket-id-price>
                    <div id>
                        <p style="margin-top: 5px;" class="tedit2">🎫<?php echo htmlspecialchars($ID4);?></p>
                    </div>
                    <div price>
                        <p class="tedit3"><?php echo htmlspecialchars($price4);?></p>
                    </div>
                </div>
                <div class="select">
                    <button style="color: aliceblue; font-weight: 700;" 
                    class="select-button">
                        Select>
                    </button>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="ticket-brief">
                <div class="tb">
                    <p class="tedit">💎Partially refundable</p>
                </div>
                <div class="tb">
                    <p class="tedit">💰Best deal</p>
                </div>
                <div class="tb">
                    <p class="tedit">🕓Pay later</p>
                </div>
            </div>
            <div class="time">
                <div class="departure">
                    <p class="tedit"><?php echo htmlspecialchars($start_time5);?></p>
                </div>
                <div class="duration">
                    <p class="tedit"><?php echo htmlspecialchars($duration5);?></p>
                </div>
                <div class="arrival">
                    <p class="tedit"><?php echo htmlspecialchars($end_time5);?></p>
                </div>
            </div>
            <div class="destination">
                <div class="from">
                    <p class="tedit"><?php echo htmlspecialchars($from5);?></p>
                </div>
                <div class="logo">
                    <img class="minilogo" src="pics/black_minimalist_jet_airplane_logo_design__1_-removebg-preview.png">
                </div>
                <div class="to">
                    <p class="tedit"><?php echo htmlspecialchars($to5);?></p>
                </div>
            </div>
            <div class="date">
                <div class="stdate">
                    <p class="tedit2"><?php echo htmlspecialchars($start_date5);?></p>
                </div>
                <div class="type">
                    <p class="tedit2"><?php echo htmlspecialchars($type5);?></p>
                </div>
                <div class="enddate">
                    <p class="tedit2"><?php echo htmlspecialchars($land_date5);?></p>
                </div>
            </div>
            <div class="ticket-price">
                <div ticket-id-price>
                    <div id>
                        <p style="margin-top: 5px;" class="tedit2">🎫<?php echo htmlspecialchars($ID5);?></p>
                    </div>
                    <div price>
                        <p class="tedit3"><?php echo htmlspecialchars($price5);?></p>
                    </div>
                </div>
                <div class="select">
                    <button style="color: aliceblue; font-weight: 700;" 
                    class="select-button">
                        Select>
                    </button>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="ticket-brief">
                <div class="tb">
                    <p class="tedit">💎Partially refundable</p>
                </div>
                <div class="tb">
                    <p class="tedit">💰Best deal</p>
                </div>
                <div class="tb">
                    <p class="tedit">🕓Pay later</p>
                </div>
            </div>
            <div class="time">
                <div class="departure">
                    <p class="tedit"><?php echo htmlspecialchars($start_time6);?></p>
                </div>
                <div class="duration">
                    <p class="tedit"><?php echo htmlspecialchars($duration6);?></p>
                </div>
                <div class="arrival">
                    <p class="tedit"><?php echo htmlspecialchars($end_time6);?></p>
                </div>
            </div>
            <div class="destination">
                <div class="from">
                    <p class="tedit"><?php echo htmlspecialchars($from6);?></p>
                </div>
                <div class="logo">
                    <img class="minilogo" src="pics/black_minimalist_jet_airplane_logo_design__1_-removebg-preview.png">
                </div>
                <div class="to">
                    <p class="tedit"><?php echo htmlspecialchars($to6);?></p>
                </div>
            </div>
            <div class="date">
                <div class="stdate">
                    <p class="tedit2"><?php echo htmlspecialchars($start_date6);?></p>
                </div>
                <div class="type">
                    <p class="tedit2"><?php echo htmlspecialchars($type6);?></p>
                </div>
                <div class="enddate">
                    <p class="tedit2"><?php echo htmlspecialchars($land_date6);?></p>
                </div>
            </div>
            <div class="ticket-price">
                <div ticket-id-price>
                    <div id>
                        <p style="margin-top: 5px;" class="tedit2">🎫<?php echo htmlspecialchars($ID6);?></p>
                    </div>
                    <div price>
                        <p class="tedit3"><?php echo htmlspecialchars($price6);?></p>
                    </div>
                </div>
                <div class="select">
                    <button style="color: aliceblue; font-weight: 700;" 
                    class="select-button">
                        Select>
                    </button>
                </div>
            </div>
        </div>            
    </div>
    </body>
</html>
<?php
$quotes = [
    "Data is the new oil. - Clive Humby",
    "The web as I envisaged it, we have not seen it yet. The future is still so much bigger than the past. - Tim Berners-Lee",
    "Store your files wisely; retrieve them swiftly.",
    "In the bucket of knowledge, every drop counts.",
    "Files come and go, but storage endures.",
    "Innovation distinguishes between a leader and a follower. - Steve Jobs",
    "The advance of technology is based on making it fit in so that you don't really even notice it. - Bill Gates",
    "Keep your data close, and your backups closer.",
    "Every file tells a story.",
    "Simplicity is the ultimate sophistication. - Leonardo da Vinci"
];

$randomQuote = $quotes[array_rand($quotes)];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bucket - Internal File Storage</title>
    <style>
    body {
        font-family: 'Courier New', Courier, monospace;
        /* Classic typewriter font for retro feel */
        background: linear-gradient(to bottom, #f0f0f0, #d0d0d0);
        /* Subtle gray gradient like old paper */
        color: #333;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        text-align: center;
        overflow: hidden;
        /* Prevent scroll on animations */
        position: relative;
        /* For particles */
    }

    /* Subtle particle background for digital retro effect */
    .particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
    }

    .particle {
        position: absolute;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        animation: float 10s infinite linear;
    }

    @keyframes float {
        0% {
            transform: translateY(0);
            opacity: 0.5;
        }

        100% {
            transform: translateY(-100vh);
            opacity: 0;
        }
    }

    .container {
        background: #fff;
        border: 2px solid #999;
        /* Thick border like old windows */
        border-radius: 4px;
        /* Slight rounding for modernity */
        padding: 40px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Modern shadow for depth */
        max-width: 600px;
        width: 90%;
        position: relative;
        z-index: 1;
        /* Above particles */
        animation: fadeIn 1s ease-in-out;
        /* Fade in container */
    }

    h1 {
        font-size: 2em;
        margin-bottom: 20px;
        border-bottom: 2px dashed #666;
        /* Dashed line for retro separator */
        padding-bottom: 10px;
        overflow: hidden;
        /* For typewriter effect */
        white-space: nowrap;
        animation: typewriter 3s steps(30) 1s 1 normal both,
            blinkCursor 0.75s steps(1) infinite normal;
    }

    .quote {
        font-size: 1.2em;
        font-style: italic;
        margin-bottom: 30px;
        opacity: 0;
        animation: fadeIn 1s ease-in-out 3s forwards;
        /* Fade in after typewriter */
    }

    p {
        font-size: 1.2em;
        margin-bottom: 30px;
        opacity: 0;
        animation: fadeIn 1s ease-in-out 4s forwards;
    }

    .status {
        font-weight: bold;
        color: #006600;
        /* Green for success, like old terminals */
    }

    /* Enhanced bucket animation - more detailed retro ASCII-like bucket with glow effect */
    .bucket {
        font-size: 1.5em;
        margin: 20px auto;
        width: 200px;
        height: 150px;
        position: relative;
        border: 2px solid #999;
        border-radius: 0 0 10px 10px;
        /* Curved bottom */
        opacity: 0;
        animation: fadeIn 1s ease-in-out 5s forwards, glow 2s infinite alternate 6s;
        /* Appear and glow */
    }

    .bucket::before {
        content: '';
        position: absolute;
        top: -10px;
        left: 20%;
        width: 60%;
        height: 10px;
        background: #999;
        border-radius: 5px 5px 0 0;
        /* Handle */
    }

    .bucket-content {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 0%;
        background: linear-gradient(to top, #add8e6, #87cefa);
        /* Gradient blue for "files" */
        animation: fillContent 3s ease-in-out 6s forwards;
        overflow: hidden;
    }

    .bucket-content::after {
        content: 'DATA';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        font-weight: bold;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    /* Keyframe animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes typewriter {
        from {
            width: 0;
        }

        to {
            width: 100%;
        }
    }

    @keyframes blinkCursor {
        from {
            border-right: 0.15em solid #333;
        }

        to {
            border-right: 0.15em solid transparent;
        }
    }

    @keyframes fillContent {
        from {
            height: 0%;
        }

        to {
            height: 80%;
        }

        /* Fill higher for better effect */
    }

    @keyframes glow {
        from {
            box-shadow: 0 0 5px rgba(0, 102, 0, 0.3);
        }

        to {
            box-shadow: 0 0 15px rgba(0, 102, 0, 0.8);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 480px) {
        .container {
            padding: 20px;
        }

        h1 {
            font-size: 1.5em;
        }

        .quote,
        p {
            font-size: 1em;
        }

        .bucket {
            font-size: 1em;
            width: 150px;
            height: 100px;
        }
    }
    </style>
</head>

<body>
    <div class="particles">
        <?php
        // Generate 20 random particles for background effect
        for ($i = 0; $i < 20; $i++) {
            $size = rand(2, 5);
            $left = rand(0, 100);
            $delay = rand(0, 10);
            echo "<div class='particle' style='width: {$size}px; height: {$size}px; left: {$left}%; animation-delay: -{$delay}s; animation-duration: " . rand(8, 15) . "s;'></div>";
        }
        ?>
    </div>
    <div class="container">
        <h1>Welcome to the Bucket</h1>
        <p class="quote"><?php echo $randomQuote; ?></p>
        <!-- <p>This is an internal file storage system. Intended for API use only, but enjoy this view if you're here.</p> -->
        <div class="bucket">
            <div class="bucket-content"></div>
        </div>
        <p class="status"><?php echo "Hello from the Bucket"; ?></p>
        <!-- Add utilitarian features if needed, e.g., API docs link -->
        <!-- <a href="/api-docs" style="text-decoration: underline; color: #0000ff;">View API Documentation</a> -->
    </div>
</body>

</html>
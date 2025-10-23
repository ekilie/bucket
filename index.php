<?php
// Improved index page for Ekilie Bucket with animations
// Utilitarian design: Simple, functional, no-frills interface
// Retro-modern aesthetic: Monospace fonts, subtle gradients, basic layout reminiscent of early web, but with modern CSS for responsiveness and animations
// Animations: Subtle retro-inspired effects like typewriter text, fading elements, and a simple bucket "fill" animation using CSS
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekilie Bucket - Internal File Storage</title>
    <style>
    /* Retro-modern styling */
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

    p {
        font-size: 1.2em;
        margin-bottom: 30px;
        opacity: 0;
        animation: fadeIn 1s ease-in-out 3s forwards;
        /* Fade in after typewriter */
    }

    .status {
        font-weight: bold;
        color: #006600;
        /* Green for success, like old terminals */
    }

    /* Bucket animation - simple retro ASCII-like bucket filling */
    .bucket {
        font-size: 1.5em;
        margin: 20px auto;
        width: 200px;
        height: 150px;
        position: relative;
        opacity: 0;
        animation: fadeIn 1s ease-in-out 4s forwards;
        /* Appear after text */
    }

    .bucket::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background:
            linear-gradient(to bottom, transparent 0%, #ccc 0%, #ccc 20%, transparent 20%),
            /* Top rim */
            linear-gradient(to bottom, transparent 80%, #ccc 80%, #ccc 100%, transparent 100%);
        /* Bottom rim */
        border-left: 2px solid #999;
        border-right: 2px solid #999;
        animation: fillBucket 2s ease-in-out 5s forwards;
        /* Fill animation */
    }

    .bucket-content {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 0%;
        background: #add8e6;
        /* Light blue for "files" */
        animation: fillContent 2s ease-in-out 5s forwards;
        overflow: hidden;
    }

    .bucket-content::after {
        content: 'FILES';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        font-weight: bold;
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

    @keyframes fillBucket {
        0% {
            background-position: 0 0, 0 100%;
        }

        100% {
            background-position: 0 0, 0 20%;
        }

        /* "Fill" by moving bottom up */
    }

    @keyframes fillContent {
        from {
            height: 0%;
        }

        to {
            height: 60%;
        }

        /* Fill to 60% for visual effect */
    }

    /* Responsive adjustments */
    @media (max-width: 480px) {
        .container {
            padding: 20px;
        }

        h1 {
            font-size: 1.5em;
        }

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
    <div class="container">
        <h1>Welcome to Ekilie Bucket</h1>
        <p>This is the internal file storage system for Ekilie. Intended for API use only, but here's a glimpse if
            you're browsing.</p>
        <div class="bucket">
            <div class="bucket-content"></div>
        </div>
        <p class="status"><?php echo "Hello from Ekilie Bucket Here"; ?></p>
        <!-- Add utilitarian features if needed, e.g., login link or file upload placeholder -->
        <!-- <a href="/api-docs" style="text-decoration: underline; color: #0000ff;">View API Documentation</a> -->
    </div>
</body>

</html>
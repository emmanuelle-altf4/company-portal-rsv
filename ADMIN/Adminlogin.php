<?php
include 'db.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        :root {
            --bg-color: #ffffff;
            --text-color: #333333;
            --input-bg: #f0f0f0;
            --input-text: #000000;
            --button-bg: #007bff;
            --button-text: #ffffff;
            --border-color: #cccccc;
        }

        .dark-mode {
            --bg-color: #333333;
            --text-color: #ffffff;
            --input-bg: #555555;
            --input-text: #ffffff;
            --button-bg: #0056b3;
            --button-text: #ffffff;
            --border-color: #666666;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--bg-color);
            padding: 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        h1, h2 {
            color: var(--text-color);
            text-align: center;
        }

        form {
            background-color: #007bff(--bg-color);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background-color: var(--input-bg);
            color: var(--input-text);
        }

        button {
            background-color: var(--button-bg);
            color: var(--button-text);
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: var(--button-bg);
            opacity: 0.9;
        }

        .center {
            text-align: center;
        }

        /* Switch styling */
        .switch {
            position: fixed;
            top: 20px;
            right: 20px;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--button-bg);
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:checked + .slider:before {
            transform: translateX(24px);
        }

        a {
            color: var(--button-bg);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Dark Mode Switch -->
    <label class="switch">
        <input type="checkbox" id="mode-toggle">
        <span class="slider"></span>
    </label>

    <h1>Login Form</h1>

    <form action="Adminloginprocess.php" method="POST">
        <div>
            <label for="Adminname">Admin Name:</label>
            <input type="text" id="Adminname" name="Adminname" required>
        </div>
        <div>
            <label for="Password">Password:</label>
            <input type="Password" id="Password" name="Password" required>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>

    <p class="center">
        Admin Registration <a href="Adminregistrationform.php">Register here</a>
    </p>

    <script>
        const toggleSwitch = document.getElementById('mode-toggle');
        toggleSwitch.addEventListener('change', () => {
            document.body.classList.toggle('dark-mode');
        });
    </script>
</body>

</html>

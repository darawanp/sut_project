<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Modern and responsive login page">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Favicons -->
    <link href="images/RMUTI.png" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Inline CSS -->
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Prompt', sans-serif;
            background-color: #f4f4f9; /* Neutral background */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .box {
            background-color: #ffffff; /* White background */
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .box img {
            width: 120px;
            margin-bottom: 20px;
        }

        .box h2 {
            font-size: 24px;
            color: #555;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .box input[type="text"],
        .box input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: border 0.3s ease;
        }

        .box input[type="text"]:focus,
        .box input[type="password"]:focus {
            border-color: #6c63ff; /* Highlighted border */
        }

        .box input[type="submit"] {
            width: 100%;
            background-color: #6c63ff; /* Primary button color */
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 15px;
            transition: background 0.3s ease;
        }

        .box input[type="submit"]:hover {
            background-color: #574bfc; /* Hover effect */
        }

        .box p {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .box p a {
            color: #6c63ff;
            text-decoration: none;
        }

        .box p a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .box {
                padding: 20px;
            }

            .box h2 {
                font-size: 20px;
            }

            .box input[type="text"],
            .box input[type="password"] {
                font-size: 14px;
            }

            .box input[type="submit"] {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="box">
        <form class="login-form" action="check.php" method="post">
            <img src="assets/img/logo.png" alt="Logo">
            <h2>Login</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="Login" value="Login">
           <!-- <p>Don't have an account? <a href="register.html">Sign Up</a></p>-->
        </form>
    </div>
</body>

</html>

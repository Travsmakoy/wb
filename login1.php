<!doctype html>
<html lang="en">
<head>
    <!--Finalized-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Responsive Registration Form</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            background-color: #0b062c;
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            margin-top: 5rem;
        }
        .form-fields h2 {
            padding-top: 2rem;
            font-family: "Poppins", sans-serif;
            padding-bottom: 2rem;
            text-align: center;
            font-weight: 900;
            background: linear-gradient(to right, rgb(54, 103, 176), rgb(80, 80, 196), rgb(165, 67, 192), rgb(14, 1, 14));
            -webkit-text-fill-color: transparent;
            -webkit-background-clip: text;
        }
        .form-container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0px 0px 7px 7px black;
        }
        .form-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 2rem;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 2px solid rgb(17, 163, 163);
        }
        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: linear-gradient(to right, rgb(178, 41, 59), rgb(165, 67, 192));
            color: white;
            font-size: 16px;
            font-weight: 800;
            font-family: 'Poppins';
        }
        button:hover {
            background-color: #0056b3;
        }
        .bottom {
            text-align: center;
            font-family: 'Poppins';
            display: flex;
            gap: 0.5rem;
            font-weight: 500;
            margin-top: 1rem;
        }
        .bottom p {
            color: rgb(222, 42, 222);
        }
        @media (max-width: 768px) {
            .form-container {
                padding: 15px;
            }
            .form-fields h2 {
                font-size: 1.5rem; /* Adjust heading size on mobile */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <img src="innociousimg.png" alt="Image">
            <div class="form-content">
                <div class="form-fields">
                    <h2>LOG IN</h2>
                    <form>
                        <label for="Email">Email</label>
                        <input type="email" id="Email" placeholder="Email" required>
                        <label for="Password">Password</label>
                        <input type="password" id="Password" placeholder="Password" required>
                        <button type="submit">LOGIN</button>
                    </form>
                    <div class="bottom" id="footer">
                        <p>Don't have an account?</p>
                        <a href="./index.html" class="text-white">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

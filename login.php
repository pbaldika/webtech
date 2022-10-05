<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="main">
        <section class="signup">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container">
                <div class="signup-content">
                    <form onsubmit="login(this)" method="POST" id="form" class="signup-form">
                        <h2 class="form-title">Login to Your Account</h2>
                        <div class="form-group">
                            <input type="" class="form-input" name="username" id="username" placeholder="Username" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" name="password" id="password" placeholder="Password" />
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Log in"
                                style="cursor: pointer;" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Log in"
                                style="cursor: pointer;" />
                        </div>
                    </form>
                    <p class="loginhere">
                        Don't have an account? <a href="register.html" class="loginhere-link">Register Here</a>
                    </p>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script>
        // handle form submit
        function login(event) {
            // var username = event.id.username;
            // var password= event.id.password;
            var username = "aldika";
            var password= "123456";

            var data = new FormData();
            data.append('username', username);
            data.append('password', password);


            var http = new XMLHttpRequest();

            var url = 'http://localhost:3000/api/index.php/login/"' + username +'"&' + password;
            http.open('get', url);

            http.onreadystatechange = function () {
                if (http.readyState == 4 && http.status == 200) {
                    // alert("Form submitted successfully");
                    // document.getElementById("frmdata").reset();
                    console.log(http.responseText);
                }
            }
            http.send(data);     
            window.location.replace("http://localhost:3000/add.html");       
        }
    </script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
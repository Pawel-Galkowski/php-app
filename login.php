<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    <title>login form</title>
</head>

<body>
    <main id="app-center">
        <div class="app-container">
            <div class="loginform">
                <form id="uzytkownik" action="./index.php" method="post">
                    <label for="uname">Username</label>
                    <input type="text" placeholder="Enter Username" class="uname" name="uname" required>

                    <label for="psw">Password</label>
                    <input type="password" placeholder="Enter Password" class="psw" name="psw" required>

                    <button type="submit"  class="logToApp" name="logToApp">Login</button>
                    <div class="flex">
                        <p>Forgot <a href="#">password?</a></p>
                        <label>
                            <input type="checkbox" checked="checked" name="remember"> Remember me
                        </label>
                    </div>

                    <a class="cancel-link" href="../index.html">
                        <input type="button" name="cancel" value="Cancel" class="cancelbtn">
                    </a>
                </form>
                <p class="log-status"></p>
            </div>
        </div>
    </main>
</body>

</html>

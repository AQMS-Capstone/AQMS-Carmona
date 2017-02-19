<?php
include('login.php');
if(isset($_SESSION["USERNAME"]))
{
    header('Location: feed.php');
}
?>
<?php
define("PAGE_TITLE", "Login - Air Quality Monitoring System");
?>

<!DOCTYPE html>
<html>
<head>
    <?php
    include('include/header-meta.php');
    ?>
</head>

<body>
<div>
    <nav class="z-depth-1" style="height: 70px;">
        <div class="nav-wrapper">
            <a id="logo" href="http://aqms.mcl-ccis.net/"><img class="brand-logo center" alt="Brand Logo"
                                                               src="res/logo.png"> </a>
        </div>
    </nav>
</div>


<div id="content-holder">
    <br>
    <h3 class="header center teal-text" style="margin-bottom: 0; padding-bottom: 0;"><span class="material-icons" style="font-size: 2em;">account_circle</span></h3>
    <h5 class="header center teal-text" style="margin-top: 0; padding-top: 0;"><b>Login</b></h5>

    <div class="section no-pad-bot">
        <div class="container" style="width: 30%;">
            <div class="divider"></div>
            <br>
            <div class="row">
                <div class="col s12">
                    <div>
                        <form method = "post" action="">
                            <div class="input-field col s12">
                                <input id="username" name="username" type="text" class="validate">
                                <label for="username">Username</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="password" name="password" type="password" class="validate">
                                <label for="password">Password</label>
                            </div>

                            <div class="input-field center col s12">
                                <button class='btn waves-effect waves-light'style="width: 100%;" name="submit" type="submit">Submit</button>
                            </div>
                            <div class="center">
                                <h6 class="header col s12 red-text"><b><?php if (isset($_POST['submit'])){echo $error;} ?></b></h6>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
</div>

<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>
</body>
</html>
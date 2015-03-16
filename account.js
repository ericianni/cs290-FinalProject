/**
 * This file handles all the user interactions with logging in or
 * registering for an account.
 */

$(document).ready(function() {
    
    /**
     * Sends user to the register page
     */
    $('#regButton').click(function() {
        var url = 'http://web.engr.oregonstate.edu/~iannie/final/register.php';
        $(location).attr('href', url);
    });

    /**
     * Submits the login form
     */
    $('#submitL').click(function() {
        login();
    });

    /**
     * Submits the register form
     */
    $('#submitR').click(function() {
        register();
    });

    /**
     * Sends the user to the homepage
     */
    $('#redirect').click(function() {
        var url = 'http://web.engr.oregonstate.edu/~iannie/final/';
        $(location).attr('href', url);
    });

    /**
     * Sends the user to the inventory page
     */
    $('#redirect2').click(function() {
        var url = 'http://web.engr.oregonstate.edu/~iannie/final/shopInventory.php';
        $(location).attr('href', url);
    });

    /**
     * Logs the user out
     */
    $('#logout').click(function() {
        $.post('logout.php', function(data) {
            $('#loginMessage').empty();
            $('#loginMessage').append(data);
        });
    });

    /**
     * On Blur check username availability
     */
    $('#usernameR').blur(function() {
        var username = $('#usernameR').val();
        $('#userStatus').empty();
        if (username != '') {
            $('#userStatus').append('Checking Username Availability');
            $.post('login.php', {
                checkUser: username
            }, function(data) {
                $('#userStatus').empty();
                $('#userStatus').append(data);
            });
        }
    });

    /**
     * on blur check passwords matching
     */

    $('#password1').blur(function() {
        $('#passwordStatus').empty();
        var password1 = $('#password1').val();
        var password2 = $('#password2').val();

        if (password1 != '' && password2 != '') {
            if (password1 == password2) {
                $('#passwordStatus').append('Passwords Match');
            } else {
                $('#passwordStatus').append('Passwords Don\'t Match');
            }
        }

    });

    /**
     * on blur check password matching
     */
    $('#password2').blur(function() {
        $('#passwordStatus').empty();
        var password1 = $('#password1').val();
        var password2 = $('#password2').val();
        
        if (password1 != '' && password2 != '') {
            if (password1 == password2) {
                $('#passwordStatus').append('Passwords Match');
            } else {
                $('#passwordStatus').append('Passwords Don\'t Match');
            }
        }
    });

    /*
    * on blur check email availability and format
     */

    $('#emailR').blur(function() {
        var email = $('#emailR').val();
        $('#emailStatus').empty();
        if (email != '') {
            $('#emailStatus').append('Checking Email Availability');
            $.post('login.php', {
                checkEmail: email
            }, function(data) {
                $('#emailStatus').empty();
                $('#emailStatus').append(data);
            });
        }
    });
});

/**
 * Attempts to regist the user with the info
 * from the form
 */

function register() {
    var username = $('#usernameR').val();
    var password1 = $('#password1').val();
    var password2 = $('#password2').val();
    var email = $('#emailR').val();
    $.post('login.php', {
        register: 1,
        usr: username,
        pw1: password1,
        pw2: password2,
        emai: email
    }, function(data) {
        $('#registerMessage').empty();
        $('#registerMessage').append(data);
    });
}

/**
 * Attempts to login the user with the
 * info from the form
 */
function login() {
    var username = $('#usernameL').val();
    var password = $('#passwordL').val();

    $('#loginMessage').empty();
    if (username == '' || password == '') {
        $('#loginMessage').append('Please Enter a Username and Password');
    } else {
        $.post('login.php', {
            usr: username,
            pw: password
        }, function(data) {
            $('#loginMessage').empty();
            $('#loginMessage').append(data);
            if (data == 'Successfully logged in') {
                $('#loginMessage').append('<br />Redirecting...');
                $(location).attr('href', 'http://web.engr.oregonstate.edu/~iannie/final/shopInventory.php');
            }
        });
    }
}

/**
 * Handles the action of the home button created by the php
 */
function goToLogin() {
        var url = 'http://web.engr.oregonstate.edu/~iannie/final/';
        $(location).attr('href', url);
}

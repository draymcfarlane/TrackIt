document.getElementById('requestButton').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Show the map frame
    document.getElementById('mapFrame').style.display = 'inline';

    
    // Show the cancel button
    document.getElementById('cancelButton').style.display = 'inline';

    // Optionally, show an alert as confirmation or update the page with a message
     alert('Your pick-up request has been sent!');

    // AJAX request to send pick-up data to the server (pick-up.php)
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "pick-up.php", true); // Adjust the URL as necessary
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // Response handling
            console.log('Pick-up request sent successfully.');
        }
    };
    // Adjust the POST data as necessary
    xhr.send("requestPickup=true&userName=<?php echo urlencode($_SESSION['user_name']); ?>");


});




document.getElementById('cancelButton').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default action

    // Hide the map frame
    document.getElementById('mapFrame').style.display = 'none';

    // Hide the cancel button
    document.getElementById('cancelButton').style.display = 'none';

    // AJAX request to notify the server of the cancellation
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "cancel_pickup.php", true); // Assuming `cancel_pickup.php` handles the cancel action
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // Optional: Handle any server response here
            console.log('Pick-up request canceled successfully.');
        }
    };
    xhr.send(); // No need to send user data if we're just canceling the current request

    //xhr.send("cancelPickup=true"); // Send an action indicating cancellation


});






   




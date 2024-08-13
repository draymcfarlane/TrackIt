<?php

include ("config.php");
include ("dbcon.php");
include ("firebaseRDB.php");

// prevents users that are not logged in from accessing this page
if (!isset($_SESSION['user'])) { ?>
  <script type="text/javascript">
    alert("Please login to access this page!");
    window.location.href = "login.php";
  </script>
  <?php
}

// Example check
if (isset($_SESSION['pickup_request']) && $_SESSION['pickup_request']) {
  // Show the pickup message
} else {
  // Hide the pickup message or show a default message
  echo "<script>document.getElementById('pickupMessage').style.display = 'none';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Passengers</title>

  <!-- custom css file link  -->
  <link rel="icon" type="image/x-icon" href="images/favicon.svg">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/dashboard.css">
  <link rel="stylesheet" href="css/routes.css">
  <link rel="stylesheet" href="css/passenger-check.css">
</head>


<body>

  <!-- Icon Properties -->
  <svg style="display:none;">
    <symbol id="down" viewBox="0 0 16 16">
      <polygon points="3.81 4.38 8 8.57 12.19 4.38 13.71 5.91 8 11.62 2.29 5.91 3.81 4.38" />
    </symbol>
    <symbol id="pages" viewBox="0 0 16 16">
      <rect x="4" width="12" height="12" transform="translate(20 12) rotate(-180)" />
      <polygon points="2 14 2 2 0 2 0 14 0 16 2 16 14 16 14 14 2 14" />
    </symbol>
    <symbol id="users" viewBox="0 0 16 16">
      <path
        d="M8,0a8,8,0,1,0,8,8A8,8,0,0,0,8,0ZM8,15a7,7,0,0,1-5.19-2.32,2.71,2.71,0,0,1,1.7-1,13.11,13.11,0,0,0,1.29-.28,2.32,2.32,0,0,0,.94-.34,1.17,1.17,0,0,0-.27-.7h0A3.61,3.61,0,0,1,5.15,7.49,3.18,3.18,0,0,1,8,4.07a3.18,3.18,0,0,1,2.86,3.42,3.6,3.6,0,0,1-1.32,2.88h0a1.13,1.13,0,0,0-.27.69,2.68,2.68,0,0,0,.93.31,10.81,10.81,0,0,0,1.28.23,2.63,2.63,0,0,1,1.78,1A7,7,0,0,1,8,15Z" />
    </symbol>
    <symbol id="trends" viewBox="0 0 16 16">
      <polygon
        points="0.64 11.85 -0.02 11.1 2.55 8.85 4.57 10.4 9.25 5.25 12.97 8.84 15.37 6.79 16.02 7.54 12.94 10.2 9.29 6.68 4.69 11.76 2.59 10.14 0.64 11.85" />
    </symbol>
    <symbol id="collection" viewBox="0 0 16 16">
      <rect width="7" height="7" />
      <rect y="9" width="7" height="7" />
      <rect x="9" width="7" height="7" />
      <rect x="9" y="9" width="7" height="7" />
    </symbol>
    <symbol id="comments" viewBox="0 0 16 16">
      <path d="M0,16.13V2H15V13H5.24ZM1,3V14.37L5,12h9V3Z" />
      <rect x="3" y="5" width="9" height="1" />
      <rect x="3" y="7" width="7" height="1" />
      <rect x="3" y="9" width="5" height="1" />
    </symbol>
    <symbol id="options" viewBox="0 0 16 16">
      <path d="M8,11a3,3,0,1,1,3-3A3,3,0,0,1,8,11ZM8,6a2,2,0,1,0,2,2A2,2,0,0,0,8,6Z" />
      <path
        d="M8.5,16h-1A1.5,1.5,0,0,1,6,14.5v-.85a5.91,5.91,0,0,1-.58-.24l-.6.6A1.54,1.54,0,0,1,2.7,14L2,13.3a1.5,1.5,0,0,1,0-2.12l.6-.6A5.91,5.91,0,0,1,2.35,10H1.5A1.5,1.5,0,0,1,0,8.5v-1A1.5,1.5,0,0,1,1.5,6h.85a5.91,5.91,0,0,1,.24-.58L2,4.82A1.5,1.5,0,0,1,2,2.7L2.7,2A1.54,1.54,0,0,1,4.82,2l.6.6A5.91,5.91,0,0,1,6,2.35V1.5A1.5,1.5,0,0,1,7.5,0h1A1.5,1.5,0,0,1,10,1.5v.85a5.91,5.91,0,0,1,.58.24l.6-.6A1.54,1.54,0,0,1,13.3,2L14,2.7a1.5,1.5,0,0,1,0,2.12l-.6.6a5.91,5.91,0,0,1,.24.58h.85A1.5,1.5,0,0,1,16,7.5v1A1.5,1.5,0,0,1,14.5,10h-.85a5.91,5.91,0,0,1-.24.58l.6.6a1.5,1.5,0,0,1,0,2.12L13.3,14a1.54,1.54,0,0,1-2.12,0l-.6-.6a5.91,5.91,0,0,1-.58.24v.85A1.5,1.5,0,0,1,8.5,16ZM5.23,12.18l.33.18a4.94,4.94,0,0,0,1.07.44l.36.1V14.5a.5.5,0,0,0,.5.5h1a.5.5,0,0,0,.5-.5V12.91l.36-.1a4.94,4.94,0,0,0,1.07-.44l.33-.18,1.12,1.12a.51.51,0,0,0,.71,0l.71-.71a.5.5,0,0,0,0-.71l-1.12-1.12.18-.33a4.94,4.94,0,0,0,.44-1.07l.1-.36H14.5a.5.5,0,0,0,.5-.5v-1a.5.5,0,0,0-.5-.5H12.91l-.1-.36a4.94,4.94,0,0,0-.44-1.07l-.18-.33L13.3,4.11a.5.5,0,0,0,0-.71L12.6,2.7a.51.51,0,0,0-.71,0L10.77,3.82l-.33-.18a4.94,4.94,0,0,0-1.07-.44L9,3.09V1.5A.5.5,0,0,0,8.5,1h-1a.5.5,0,0,0-.5.5V3.09l-.36.1a4.94,4.94,0,0,0-1.07.44l-.33.18L4.11,2.7a.51.51,0,0,0-.71,0L2.7,3.4a.5.5,0,0,0,0,.71L3.82,5.23l-.18.33a4.94,4.94,0,0,0-.44,1.07L3.09,7H1.5a.5.5,0,0,0-.5.5v1a.5.5,0,0,0,.5.5H3.09l.1.36a4.94,4.94,0,0,0,.44,1.07l.18.33L2.7,11.89a.5.5,0,0,0,0,.71l.71.71a.51.51,0,0,0,.71,0Z" />
    </symbol>
    <symbol id="charts" viewBox="0 0 16 16">
      <polygon
        points="0.64 7.38 -0.02 6.63 2.55 4.38 4.57 5.93 9.25 0.78 12.97 4.37 15.37 2.31 16.02 3.07 12.94 5.72 9.29 2.21 4.69 7.29 2.59 5.67 0.64 7.38" />
      <rect y="9" width="2" height="7" />
      <rect x="12" y="8" width="2" height="8" />
      <rect x="8" y="6" width="2" height="10" />
      <rect x="4" y="11" width="2" height="5" />
    </symbol>
    <symbol id="collapse" viewBox="0 0 16 16">
      <polygon points="11.62 3.81 7.43 8 11.62 12.19 10.09 13.71 4.38 8 10.09 2.29 11.62 3.81" />
    </symbol>
  </svg>


  <!-- Navigation Attributes -->
  <header class="page-header">
    <nav>
      <a class="logo" style="margin-left: 35px; font-size: 30px;"> TRACKIT </a>
      <button class="toggle-mob-menu" aria-expanded="false" aria-label="open menu">
        <svg width="20" height="20" aria-hidden="true">
          <use xlink:href="#down"></use>
        </svg>
      </button>
      <ul class="admin-menu">
        <li class="menu-heading">
          <h3>Utilities</h3>
        </li>
        <li>
          <a href="routes.php">
            <svg>
              <use xlink:href="#pages"></use>
            </svg>
            <span>Routes</span>
          </a>
        </li>
        <li>
          <a href="passengers.php">
            <svg>
              <use xlink:href="#users"></use>
            </svg>
            <span>Passengers</span>
          </a>
        </li>
        <li>
          <a href="my-path.php">
            <svg>
              <use xlink:href="#trends"></use>
            </svg>
            <span>MyPath</span>
          </a>
        </li>
        <li>
          <a href="admin_page.php">
            <svg>
              <use xlink:href="#collection"></use>
            </svg>
            <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="reviews.php">
            <svg>
              <use xlink:href="#comments"></use>
            </svg>
            <span>Reviews</span>
          </a>
        </li>
        <li>
          <a href="analytics.php">
            <svg>
              <use xlink:href="#charts"></use>
            </svg>
            <span>Analytics</span>
          </a>
        </li>


        <li>
          <?php // determines the current logged in user and sets the UID from the database in the href
          
          include ("dbcon.php");
          $users = $auth->listUsers();
          foreach ($users as $user) {
            $email = $_SESSION['user'];
            $rdb = new firebaseRDB($databaseURL);
            $retrieve = $rdb->retrieve("/user/users", "email", "EQUAL", $email);
            $data = json_decode($retrieve, 1);
            if (count($data) == 0) {
              echo "error";
            } else {
              $ref_table = 'user/users';
              $fetchdata = $database->getReference($ref_table)->getValue();
              if ($fetchdata > 0) {
                foreach ($fetchdata as $key => $row) {
                  if ($row['email'] == $email && $row['email'] == $user->email) {
                    ?>
                    <a href="edit_account.php?id=<?= $user->uid; ?>">
                      <svg>
                        <use xlink:href="#options"></use>
                      </svg>
                      <span>Settings</span>
                    </a>

                  <?php }
                }
              }
            }
          } ?>


        </li>
        <li>
          <div class="switch">
            <input type="checkbox" id="mode" checked>
            <label for="mode">
              <span></span>
              <span>Dark</span>
            </label>
          </div>
          <button class="collapse-btn" aria-expanded="true" aria-label="collapse menu">
            <svg aria-hidden="true">
              <use xlink:href="#collapse"></use>
            </svg>
            <span>Collapse</span>
          </button>
        </li>
      </ul>
    </nav>
  </header>


  <!-- Welcome & Logout Section -->
  <div class="container" style=" margin:0px; padding: 0px;">
    <div class="content" style="margin-bottom: 10px;">
      <h3>ky, <span>bus driver</span></h3> <!-- displays appropriate username that is currently logged in -->
      <h1>welcome <span>
          <?php
          include ("dbcon.php");
          $users = $auth->listUsers();
          foreach ($users as $user) {
            $ref_table = 'user/users';
            $fetchdata = $database->getReference($ref_table)->getValue();
            if ($fetchdata > 0) {
              foreach ($fetchdata as $key => $row) {
                if ($row['email'] == $email && $row['email'] == $user->email) {
                  $name = $row['name'];
                  echo $name;
                  $_SESSION['name'] = $name;
                }
              }
            }
          } ?>
        </span></h1>

      <a href="logout.php" class="btn">logout</a>
    </div>
  </div>


  <section class="page-content">
    <section class="grid" style="text-align: center;">

      <article class="route-content" style="padding-bottom: 20px;">
        <div class="text">
          <h2>Passenger Pick Up Requests</h2>
          <p>Displays on the map below all pick up request.</p>
        </div>

        <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1Janl8u7nsPvj-tnNrBLwJrad5e6xwdc&ehbc=2E312F&noprof=1"
          width="800" height="480"></iframe>
        <div class="text">
          <h2>Confirm Pick Up</h2>
          <p>Lists all passengers that requested for a pick up. Select a collect passenger to clear them from the list if you've collected them.</p>
        </div>
        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
        <pre
          style="color:#5562eb;"> <h3> List of Passengers                                                                      Picked Up?</h3>  </pre>
        <form class="form">

          <?php if (isset($_SESSION['pickup_request'])): ?>
            <div class="inputGroup">
              <input id="option1" name="option1" type="checkbox" />
              <label for="option1">
                <?php echo $_SESSION['pickup_request']; ?>
              </label>
            </div>
            <?php unset($_SESSION['pickup_request']); // Remove the variable after displaying  ?>
          <?php endif; ?>



          <div class="inputGroup">
            <input id="option2" name="option2" type="checkbox" />
            <label for="option2">Passenger kate - at location</label>
          </div>

          <div class="inputGroup">
            <input id="option3" name="option3" type="checkbox" />
            <label for="option3">Passenger tye - at location</label>
          </div>

          <div class="inputGroup">
            <input id="option4" name="option4" type="checkbox" />
            <label for="option4">Passenger tyson - at location</label>
          </div>
        </form>

        <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
      </article>

    </section>
  </section>

  <script>
    document.querySelectorAll('.inputGroup input[type="checkbox"]').forEach(function (checkbox) {
      checkbox.addEventListener('click', function () {
        var inputGroup = checkbox.closest('.inputGroup');
        // Set opacity to 0 and height to 0 to smoothly hide the input group
        inputGroup.style.opacity = '0';
        inputGroup.style.height = '0';
        // After a delay, set display to 'none' to completely remove the input group from the layout
        setTimeout(function () {
          inputGroup.style.display = 'none';
        }, 5000); // Wait for the transition duration (0.5s)
      });
    });

  </script>

  <script src="js/admin-script.js"></script>

  <script src="js/pick-up.js"></script>

</body>

</html>
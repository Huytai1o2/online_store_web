<!DOCTYPE html>
<html lang="en">
<head>
    <include src="shared_lib/head.php" />
    <style>
        .echo-text {
            font-size: 48px;
            color: #333;
            font-weight: bold;
        }
        /* Adjust the map container size */
        #map {
            height: 400px;
            width: 100%;
        }
        /* Style for the search input and button */
        #search-bar {
            margin-bottom: 20px;
        }
    </style>
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC9ZlPv1608U0rJrhYmwDS-3azSV9xFB68&callback=initMap&libraries=places" async defer></script>
    <script>
        var map;
        var marker;
        
        // Initialize the map
        function initMap() {
            // Default location (Hanoi, Vietnam)
            var defaultLocation = { lat: 10.77230, lng: 106.65783 };
            
            // Create a map centered on the location
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: defaultLocation
            });

            // Add a marker at the location
            marker = new google.maps.Marker({
                position: defaultLocation,
                map: map
            });
        }

        // Function to search for a location
        function searchLocation() {
            var geocoder = new google.maps.Geocoder();
            var address = document.getElementById("search-input").value;

            // Geocode the address
            geocoder.geocode({ 'address': address }, function(results, status) {
    console.log(status); // Check status for debugging
    if (status === 'OK') {
        var location = results[0].geometry.location;
        map.setCenter(location);
        marker.setPosition(location);
    } else {
        alert('Geocode was not successful for the following reason: ' + status);
    }
});

        }
    </script>
</head>
<body>
    <include src="shared_lib/navbar.php" />
    
    <!-- Content -->
    <div class="container mt-5 text-center">
        <h1>Welcome to my website</h1>

        <!-- Display the username if logged in -->
        <?php
        if (session_status() === PHP_SESSION_NONE) {
          session_start();
        }
        if (isset($_SESSION['username'])) {
            echo "<p class='echo-text'>Hello, " . htmlspecialchars($_SESSION['username']) . "!</p>";
        } else {
            echo "<p>My name is Nguyễn Huy Tài.</p>";
        }
        ?>
    </div>

    <!-- Long paragraph content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <p class="text-justify">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                    Nullam nec purus nec nunc tincidunt tincidunt. 
                    Integer eget orci neque. Sed condimentum risus non velit feugiat, 
                    vel consectetur purus viverra. 
                    Phasellus faucibus metus ut felis varius, a tempor metus hendrerit. 
                    Maecenas tristique dolor ac magna hendrerit, in bibendum est aliquam. 
                    Suspendisse potenti. Ut vehicula, nunc ac luctus posuere, felis odio convallis arcu, 
                    et vestibulum dui nisi a risus.
                </p>

                <p class="text-justify">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                    Nullam nec purus nec nunc tincidunt tincidunt. 
                    Integer eget orci neque. Sed condimentum risus non velit feugiat, 
                    vel consectetur purus viverra. 
                    Phasellus faucibus metus ut felis varius, a tempor metus hendrerit. 
                    Maecenas tristique dolor ac magna hendrerit, in bibendum est aliquam. 
                    Suspendisse potenti. Ut vehicula, nunc ac luctus posuere, felis odio convallis arcu, 
                    et vestibulum dui nisi a risus.
                </p>
            </div>
        </div>
    </div>

    <!-- Search bar -->
    <div class="container mt-5" id="search-bar">
        <input type="text" id="search-input" class="form-control" placeholder="Enter a location" />
        <button class="btn btn-primary mt-2" onclick="searchLocation()">Search</button>
    </div>

    <!-- Google Map -->
    <div class="container mt-5">
        <h2>Google Map</h2>
        <!-- This div will contain the map -->
        <div id="map"></div>
    </div>

    <include src="shared_lib/footer.php" />
</body>
</html>

<?php
require __DIR__ . '/../src/bootstrap.php';
//require __DIR__ . '/student2.php';//tarviiko?????
require_login();
?>

<?php view('header', ['title' => 'Dashboard']) ?>
<h1>Registration
    <?= current_user() ?>
</h1>
<div class="container">
    <div class="row">
        <div class="col-sm">
            <h2>Courses in the study plan</h2>

            <!-- Placeholder for the list -->
            <div class="col-sm-12">
                <ul id="itemList"></ul>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ohjelmoinnin peruskurssi 1</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ohjelmoinnin peruskurssi 2</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tietorakenteet ja algoritmit</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tietokannat</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary" onclick="register()">Register</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm" id="targetColumn">
            <h2>Course registrations</h2>

        </div>
    </div>

</div>

<script>
    // Function to fetch course names via AJAX
    function fetchCourseNames() {
        // Make an AJAX request to your PHP script
        $.ajax({
            url: "student2.php", // Adjust the path accordingly "__DIR__ . '/../src/libs/student2.php"
            method: 'POST',
            //data: { username: username },
            dataType: 'json',
            success: function (response) {
                // Call a function to update the HTML content
                updateList(response);
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Function to update the HTML content
    function updateList(items) {
        // Get the placeholder element
        const itemList = document.getElementById('itemList');

        // Clear existing content
        itemList.innerHTML = '';

        // Loop through the items and create list items
        items.forEach(item => {
            const li = document.createElement('li');
            li.textContent = item.name; // Assuming 'name' is the key in the returned data
            itemList.appendChild(li);
        });
    }

    // Call the function to fetch and display course names
    fetchCourseNames();
</script>

<script>
    function register() {
        // Get the card element
        var cardElement = document.querySelector('.card');

        // Clone the card
        var clonedCard = cardElement.cloneNode(true);

        // Remove the original card from its column
        cardElement.parentNode.removeChild(cardElement);

        // Append the cloned card to the target column
        document.getElementById('targetColumn').appendChild(clonedCard);
    }
</script>

<?php

//echo "<h3> PHP List All Session Variables</h3>";
//foreach ($_SESSION as $key => $val)
//    echo $key . " " . $val . "<br/>";
?>
<?php view('footer') ?>
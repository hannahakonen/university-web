<?php
require __DIR__ . '/../src/bootstrap.php';
//require __DIR__ . '/student2.php';//tarviiko?????
require_login();
?>

<?php view('header', ['title' => 'Dashboard']) ?>
<h2>Registration
    <?= current_user() ?>
</h2>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <h3>Courses in the study plan</h3>
            <h4>tähän EI voi palautua jo rekisteröidyt!!!</h4>
            <!-- Placeholder for the list -->
            <div class="col-sm">
                <ul id="itemList"></ul>
            </div>

            <div id="courseCards" class="card-deck"></div>

        </div>

        <div class="col-sm-6" id="targetColumn">
            <h3>Course registrations</h3>
            <h4>tähän rekisteröidyt tietokannasta pysyvästi+cancel-mahd, reg button -> cancel</h4>
   
        </div>
    </div>

</div>

<script>
    //TARVITAANKO TÄSSÄ AJAXIA???????????????????????????
    // Function to fetch course names via AJAX
    function fetchCourseNames() {
        // Make an AJAX request to your PHP script
        $.ajax({
            url: "courses.php", // Adjust the path accordingly "__DIR__ . '/../src/libs/courses.php"
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

    // Function to update the card list
    function updateList(items) {
        const courseCards = document.getElementById('courseCards');

        // Clear existing content
        courseCards.innerHTML = '';

        // Loop through the items and create Bootstrap cards with buttons
        items.forEach(item => {
            const card = document.createElement('div');
            card.className = 'card';

            const cardBody = document.createElement('div');
            cardBody.className = 'card-body';

            const cardTitle = document.createElement('h5');
            cardTitle.className = 'card-title';
            cardTitle.textContent = item.name;

            const addButton = document.createElement('button');
            addButton.className = 'btn btn-primary';
            addButton.textContent = 'Register'; // Customize button text as needed

            // You can add an event listener to the button if you want to handle clicks
            addButton.addEventListener('click', function () {
                // Add your logic here when the button is clicked
                register(item.name); //USERNAME PUUTTUU!!!!!!!!!!!!!!!!!!!
                console.log('Enroll button clicked for:', item.name);
            });

            cardBody.appendChild(cardTitle);
            cardBody.appendChild(addButton);
            card.appendChild(cardBody);

            courseCards.appendChild(card);
        });
    }


    // Function to update the list
    /*function updateList(items) {
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
    }*/

    // Call the function to fetch and display course names
    fetchCourseNames();
</script>

<script>
function register(courseName) {//, username
    // Make an AJAX request to the PHP script
    $.ajax({
        url: 'enroll.php', // Adjust the path accordingly
        method: 'POST',
        data: { courseName: courseName }, //, username: username
        success: function (response) {
            // Handle the success response if needed
            console.log('Enrollment successful');
        },
        error: function (error) {
            console.error('Error enrolling:', error);
        }
    });
    // Find the card element with the specific course name
    const cards = document.querySelectorAll('.card');
    const cardElement = Array.from(cards).find(card => card.querySelector('.card-title').textContent === courseName);

    if (cardElement) {
        // Clone the card
        const clonedCard = cardElement.cloneNode(true);

        // Remove the original card from its column
        cardElement.parentNode.removeChild(cardElement);

        // Append the cloned card to the target column
        document.getElementById('targetColumn').appendChild(clonedCard);
    }
}
</script>

<?php

//echo "<h3> PHP List All Session Variables</h3>";
//foreach ($_SESSION as $key => $val)
//    echo $key . " " . $val . "<br/>";
?>
<?php view('footer') ?>
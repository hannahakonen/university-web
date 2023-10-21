<?php
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/selected-courses.php';
require __DIR__ . '/enrolled-courses.php';
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
            <!-- Placeholder for the list -->
            <div class="col-sm">
                <ul id="itemList"></ul>
            </div>

            <div id="courseCards" class="card-deck"></div>

        </div>

        <div class="col-sm-6" id="targetColumn">
            <h3>Course registrations</h3>
            <div id="registeredCourseCards" class="registered-card-deck"></div>
        </div>
    </div>

</div>

<script>
    
    updateLists();

    // Function to update the card list
    function updateList(items, id, buttonText) {
        const courseCards = document.getElementById(id); //courseCards

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
            addButton.textContent = buttonText; // Customize button text as needed

            // You can add an event listener to the button if you want to handle clicks
            addButton.addEventListener('click', function () {
                // Add your logic here when the button is clicked
                register(item.name, buttonText);
                console.log('Enroll button clicked for:', item.name);
            });

            cardBody.appendChild(cardTitle);
            cardBody.appendChild(addButton);
            card.appendChild(cardBody);

            courseCards.appendChild(card);
        });
    }

    function updateLists() {
        //Courses to study plan
        var selectedCourses = <?php echo json_encode($selected_courses); ?>;  //from selected-courses.php
        updateList(selectedCourses, 'courseCards', 'Register');
        //Courses to reg courses
        var enrolledCourses = <?php echo json_encode($enrolled_courses); ?>;  //from enrolled-courses.php
        updateList(enrolledCourses, 'registeredCourseCards', 'Cancel registration');
    }

    // Function to fetch course names via AJAX, not used
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

    // Call the function to fetch and display course names
    //fetchCourseNames();

    function register(courseName, buttonText) {//, username
        // Make an AJAX request to the PHP script
        $.ajax({
            url: 'enroll.php', // Adjust the path accordingly
            method: 'POST',
            data: { courseName: courseName, buttonText: buttonText }, //, username: username
            success: function (response) {
                // Handle the success response if needed
                console.log('Enrollment successful');
            },
            error: function (error) {
                console.error('Error enrolling:', error);
            }
        });
        //JATKON MUOKKAUS NIIN ETTÄ POISTO PLANISTA JA REKISTERÖITYJEN KURSSIEN HAKU (AJAX+PHP) 
        //JA LISTA REKISTERÖITYIHIN 

        //TARVITAAN YHÄ???????????????

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
        location.reload();  //lataa koko sivun, mikä ei ole tarkoitus, pitäisi olla dynaaminen!!!!!!!!!!!!!!!
    }
    

</script>

<?php view('footer') ?>
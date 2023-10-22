<?php
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/selected-courses.php';
require __DIR__ . '/enrolled-courses.php';
require_login();
?>

<?php view('header', ['title' => 'Dashboard']) ?>
<h2>Registration
</h2>
<div class="container">
    <div class="row">
        <div class="col-sm-6" id="selectedColumn">
            <h3>Courses in the study plan</h3>
            <!-- Placeholder for the list -->
            <div class="col-sm">
                <ul id="itemList"></ul>
            </div>
            <div id="courseCards" class="card-deck"></div>

        </div>

        <div class="col-sm-6" id="registeredColumn">
            <h3>Course registrations</h3>
            <div id="registeredCourseCards" class="registered-card-deck"></div>
        </div>
    </div>

</div>

<script>

    updateLists();

    // Function to update the card list
    function updateList(items, id, buttonText) {
        const courseCards = document.getElementById(id); //div id
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

    function register(courseName, buttonText) {
        // Make an AJAX request to the PHP script

        $.ajax({
            url: 'enroll.php',
            method: 'POST',
            data: { courseName: courseName, buttonText: buttonText },
            success: function (response) {
                // Handle the success response if needed
                console.log('Enrollment successful');

                //KOKEILU TÄHÄN VÄLIIN LOPPUOSA
                // Find the card element with the specific course name

                const cards = document.querySelectorAll('.card');
                const cardElement = Array.from(cards).find(card => card.querySelector('.card-title').textContent === courseName);

                if (cardElement) {
                    // Clone the card
                    var clonedCard = cardElement.cloneNode(true);

                    // Get the parent div of the card
                    //const parentDiv = cardElement.parentNode;
                    // Get the ID of the parent div
                    //const parentId = parentDiv.id; // ei toimi

                    //console.log(parentId);

                    // Remove the original card from its column
                    cardElement.parentNode.removeChild(cardElement);

                    //Button for the text change
                    //var buttonElement = cardElement.querySelector('button');
                    var buttonElement = clonedCard.querySelector('button');

                    console.log(buttonElement.textContent);

                    // Append the cloned card to the target column 
                    if (buttonElement.textContent == 'Register') {
                        console.log('target reg');
                        
                        document.getElementById('registeredColumn').appendChild(clonedCard);

                        buttonElement.textContent = 'Cancel registration';
                        console.log('Button Text After:', buttonElement.textContent);

                    } else if (buttonElement.textContent == 'Cancel registration') {
                        console.log('target sel');
                        
                        document.getElementById('selectedColumn').appendChild(clonedCard);

                        buttonElement.textContent = 'Register';
                        console.log('Button Text After:', buttonElement.textContent);

                    }
                }
                location.reload();  //lataa koko sivun, mikä ei ole tarkoitus, pitäisi olla dynaaminen!!!!!!!!!!!!!!!


            },
            error: function (error) {
                console.error('Error enrolling:', error);
            }
        });

    }


</script>

<?php view('footer') ?>
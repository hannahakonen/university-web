<?php
require __DIR__ . '/../src/bootstrap.php';

require_login();
?>

<?php view('header', ['title' => 'Dashboard']) ?>

<div class="container">
<div class="row"><h2>Front page</h2></div>
    <div class="row" style='background-color: white'>
        <div class="col" id="selectedColumn">
            <h3>Newest messages</h3>
            <div></div>
        </div>
        <div class="col" id="registeredColumn">
            <h3>Calender</h3>
            <div></div>
        </div>
        <div class="col" id="registeredColumn">
            <h3>Course registrations</h3>
            <div></div>
        </div>
    </div>

</div>

<?php view('footer') ?>
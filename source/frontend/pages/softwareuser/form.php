<?php

/**
 * 
 * The form page is to generate the form display for the user.
 * 
 */
$title = "Request Form";
require_once("../allusers/header.php");

?>
    
<form>
    <h1 class="text-center"> HELL's Software Access Request</h1>
    <div style="padding-left:20%; padding-right:20%;">
    <div class= "form-group">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon3">Select Software</span>
            <select class="selectpicker form-control" data-live-search="true" aria-describedby="basic-addon3">
                <option data-tokens="---"> ----- </option>
                <!-- list of options here -->
                <option data-tokens="OMG">OMG: Operating Map of Gastropathy</option>
                <option data-tokens="LOL">LOL: Limited Operating Liability</option>
                <option data-tokens="TMI">TMI: Total Mastering of Incisions</option>
            </select>
        </div>
    </div>
</div>
</form>
<?php require_once("../allusers/footer.php"); ?>

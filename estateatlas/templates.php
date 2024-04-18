<?php
function templateCompany(): void
{
    echo '<div class="form-group">';
    echo '<form method="post">';
    echo '<input name="formName" type="hidden" value="companyInsertManually">';
    echo '<table class="table table-striped" id="dataTable">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Name</th>';
    echo '<th scope="col">Address</th>';
    echo '<th scope="col">ZIP</th>';
    echo '<th scope="col">City</th>';
    echo '<th scope="col">Country code</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo '<tr>';
    echo '<td><input class="form-control" name="formName" placeholder="Name" required type="text"></td>';
    echo '<td><input class="form-control" name="formAddress" placeholder="Address" required type="text"></td>';
    echo '<td><input class="form-control" name="formZip" placeholder="Zip code" required type="text"></td>';
    echo '<td><input class="form-control" name="formCity" placeholder="City" required type="text"></td>';
    echo '<td><input class="form-control" name="formCountry" placeholder="Country code" required type="text"></td>';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    echo '<div class="btn-group-justified" id="buttonGroup" style="width: 100%;">';
    echo '<div aria-label="Button group with spacing" class="btn-group me-2" role="group">';
    echo '<div class="btn-group" style="width: 100%;">';
    echo '<input class="btn btn-warning btn-block" type="submit" value="Upload">';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</form>';
    echo '</div>';
}

function templateOwner(): void
{
    echo '<div class="form-group">';
    echo '<form method="post">';
    echo '<input name="formName" type="hidden" value="ownerInsertManually">';
    echo '<table class="table table-striped" id="dataTable">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">First Name</th>';
    echo '<th scope="col">Last Name</th>';
    echo '<th scope="col">Phone (without prefix)</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo '<tr>';
    echo '<td><input class="form-control" name="formFirstName" placeholder="First Name" required type="text"></td>';
    echo '<td><input class="form-control" name="formLastName" placeholder="Last Name" required type="text"></td>';
    echo '<td><input class="form-control" name="formPhone" placeholder="Phone" required type="text"></td>';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    echo '<div class="btn-group-justified" id="buttonGroup" style="width: 100%;">';
    echo '<div aria-label="Button group with spacing" class="btn-group me-2" role="group">';
    echo '<div class="btn-group" style="width: 100%;">';
    echo '<input class="btn btn-warning btn-block" id="shortenBtn" type="submit" value="Upload">';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</form>';
    echo '</div>';
}

function templateOwnershipList(Array $parcels, Array $owners, Array $companies) : void
{
echo "<div class='form-group'>";
echo "<form method='post'>";
echo "<input name='formName' type='hidden' value='ownershipListInsertManually'>";
echo "<table class='table table-striped' id='dataTable'>";
echo "<thead>";
echo "<tr>";
echo "<th scope='col'>Parcel</th>";
echo "<th scope='col'>Owner/Company</th>";
echo "<th scope='col'>Stake (Between 1 and 0)</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
echo "<tr>";
echo "<td>";
echo "<select class='form-select' name='formParcel' required>";
foreach ($parcels as $parcel) {
    echo "<option value='" . $parcel['id'] . "'>" . $parcel['number'] . "</option>";
}
echo "</select>";
echo "</td>";
echo "<td>";
echo "<select class='form-select' name='formOwnerCompany' required>";
echo "<optgroup label='Owners'>";
foreach ($owners as $owner) {
    echo "<option value='o" . $owner['id'] . "'>" . $owner['first_name'] . " " . $owner['last_name'] . "</option>";
}
echo "</optgroup>";
echo "<optgroup label='Companies'>";
foreach ($companies as $company) {
    echo "<option value='c" . $company['id'] . "'>" . $company['name'] . "</option>";
}
echo "</optgroup>";
echo "</select>";
echo "</td>";
echo "<td><input class='form-control' name='formStake' placeholder='Stake' required type='text'></td>";
echo "</tr>";
echo "</tbody>";
echo "</table>";
echo "<div class='btn-group-justified' id='buttonGroup' style='width: 100%;'>";
echo "<div aria-label='Button group with spacing' class='btn-group me-2' role='group'>";
echo "<div class='btn-group' style='width: 100%;'>";
echo "<input class='btn btn-warning btn-block' type='submit' value='Upload'>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</form>";
echo "</div>";
}

function templateParcels() : void
{
    echo '<div class="form-group">';
    echo '<form method="post">';
    echo '<input name="formName" type="hidden" value="parcelInsertManually">';
    echo '<table class="table table-striped" id="dataTable">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Number</th>';
    echo '<th scope="col">Size (m&#178;)</th>';
    echo '<th scope="col">Latitude</th>';
    echo '<th scope="col">Longitude</th>';
    echo '<th scope="col">Legal state</th>';
    echo '<th scope="col">Type</th>';
    echo '<th scope="col">Address</th>';
    echo '<th scope="col">Zip</th>';
    echo '<th scope="col">City</th>';
    echo '<th scope="col">Country</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo '<tr>';
    echo '<td><input class="form-control" name="formNumber" placeholder="Number" required type="text"></td>';
    echo '<td><input class="form-control" name="formSize" placeholder="Size (m&#178;)" required type="text"></td>';
    echo '<td><input class="form-control" name="formLatitude" placeholder="Latitude" required type="text"></td>';
    echo '<td><input class="form-control" name="formLongitude" placeholder="Longitude" required type="text"></td>';
    echo '<td><select class="form-select" name="formLegalState" required>';
    echo '<option value="0">Owned</option>';
    echo '<option value="1">Leased</option>';
    echo '<option value="2">Pledged</option>';
    echo '</select></td>';
    echo '<td><select class="form-select" name="formType" required>';
    echo '<option value="0">Built-up areas and courtyards</option>';
    echo '<option value="1">Agricultural land</option>';
    echo '<option value="2">Forest land</option>';
    echo '<option value="3">Water surfaces</option>';
    echo '<option value="4">Other surfaces</option>';
    echo '</select></td>';
    echo '<td><input class="form-control" name="formAddress" placeholder="Address" required type="text"></td>';
    echo '<td><input class="form-control" name="formZip" placeholder="Zip" required type="text"></td>';
    echo '<td><input class="form-control" name="formCity" placeholder="City" required type="text"></td>';
    echo '<td><input class="form-control" name="formCountry" placeholder="Country" required type="text"></td>';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    echo '<div class="btn-group-justified" id="buttonGroup" style="width: 100%;">';
    echo '<div aria-label="Button group with spacing" class="btn-group me-2" role="group">';
    echo '<div class="btn-group" style="width: 100%;">';
    echo '<input class="btn btn-warning btn-block" id="shortenBtn" type="submit" value="Upload">';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</form>';
    echo '</div>';
}

function templateUser() : void
{
    echo '<div class="form-group">';
    echo '<form method="post">';
    echo '<input name="formName" type="hidden" value="userInsertManually">';
    echo '<table class="table table-striped" id="dataTable">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Email</th>';
    echo '<th scope="col">Password</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo '<tr>';
    echo '<td><input class="form-control" name="formEmail" placeholder="Email" required type="text"></td>';
    echo '<td><input class="form-control" name="formPassword" placeholder="Password" required type="text"></td>';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    echo '<div class="btn-group-justified" id="buttonGroup" style="width: 100%;">';
    echo '<div aria-label="Button group with spacing" class="btn-group" role="group">';
    echo '<div class="btn-group" style="width: 100%">';
    echo '<input class="btn btn-warning btn-block btn-lg"  id="shortenBtn" type="submit" value="Upload">';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</form>';
    echo '</div>';
}
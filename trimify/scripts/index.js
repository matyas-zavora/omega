// Function to add a new row to the table
function addRow(tableID) {
    var table = document.getElementById(tableID);
    var lastRow = table.rows[table.rows.length - 1];
    var inputs = lastRow.getElementsByTagName('input');
    var input1 = inputs[0].value.trim();
    var input2 = inputs[1].value.trim();

    // Check if both input fields are not empty
    if (input1 !== '' && input2 !== '') {
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);

        // Insert cells with input fields
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = '<input class="form-control" name="input1[]" oninput="addRow(\'dataTable\')" type="text">';
        cell2.innerHTML = '<input class="form-control" name="input2[]" oninput="addRow(\'dataTable\')" type="text">';

        // Display clear button and shorten button
        document.getElementById('clearBtn').style.display = 'block';
        document.getElementById('shortenBtn').style.display = 'block';
    }
}

// Function to clear the table
function clearTable() {
    var confirmation = confirm("Are you sure you want to clear the tables?");
    if (confirmation) {
        var table = document.getElementById('dataTable');
        while (table.rows.length > 2) {
            table.deleteRow(1);
        }

        // Clear input values
        var inputs = table.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].value = '';
        }

        // Hide clear button and shorten button
        document.getElementById('clearBtn').style.display = 'none';
        document.getElementById('shortenBtn').style.display = 'none';
    }
}

// Function to check if the table is filled
function isTableFilled() {
    var table = document.getElementById('dataTable');
    var rows = table.getElementsByTagName('tr');
    for (var i = 1; i < rows.length; i++) {
        var inputs = rows[i].getElementsByTagName('input');
        var input1 = inputs[0].value.trim();
        var input2 = inputs[1].value.trim();
        if (input1 !== '' && input2 !== '') {
            return true;
        }
    }
    return false;
}

// Function to check if a file is uploaded
function isFileUploaded() {
    var fileInput = document.getElementById('fileImport');
    return fileInput.files.length > 0;
}

// Function to toggle the shorten button based on table and file upload status
function toggleShortenButton() {
    if (isTableFilled() && isFileUploaded()) {
        buttonGroup.innerHTML =
            "<div aria-label=\"Button group with spacing\" class=\"me-2 d-flex\" role=\"group\">" +
            "       <input class=\"btn btn-danger btn-block\" id=\"clearBtn\" onclick=\"clearTable()\" type=\"button\" value=\"Clear Table\">" +
            "   <div class=\"me-2 \" role=\"group\"></div>" +
            "       <input class=\"btn btn-info btn-block\" id=\"shortenBtn\" type=\"submit\" value=\"Shorten!\">" +
            "</div>"
        ;
    }
}

// Event listener for file input change
document.getElementById('fileImport').addEventListener('change', toggleShortenButton);
document.getElementById('dataTable').addEventListener('input', toggleShortenButton);

// Constants and elements for file handling
const buttonGroup = document.getElementById('buttonGroup');
const fileInput = document.getElementById('fileImport');
const fileErrorAlert = document.getElementById('fileError');
const fileSuccessAlert = document.getElementById('fileSuccess');

// Event listener for file input change
fileInput.addEventListener('change', function () {
    const file = fileInput.files[0];
    if (file) {
        const fileName = file.name;
        const extension = fileName.split('.').pop();
        if (extension !== 'txt') {
            // Display file error alert if file extension is not .txt
            fileErrorAlert.style.display = 'block';
            fileInput.value = '';

            // Update button group based on table status
            if (isTableFilled()) {
                buttonGroup.innerHTML =
                    "<div aria-label=\"Button group with spacing\" class=\"btn-group me-2\" role=\"group\">" +
                    "   <div class=\"btn-group\" style=\"width: 100%;\">" +
                    "       <input class=\"btn btn-danger btn-block\" id=\"clearBtn\" onclick=\"clearTable()\" type=\"button\" value=\"Clear Table\">" +
                    "   </div>" +
                    "</div>"
                ;
            } else {
                buttonGroup.innerHTML = '';
            }

            // Hide file error alert after 2 seconds
            setTimeout(function () {
                fileErrorAlert.style.display = 'none';
            }, 2000);
        } else {
            // Hide file error alert and display file success alert
            fileErrorAlert.style.display = 'none';
            fileSuccessAlert.style.display = 'block';
            document.getElementById('fileName').innerText = fileName;

            // Hide file success alert after 2 seconds
            setTimeout(function () {
                fileSuccessAlert.style.display = 'none';
            }, 2000);

            // Toggle shorten button
            toggleShortenButton();
        }
    }
});

// Function to download file from server
function downloadFileFromServer(fileName) {
    const link = document.createElement('a');
    link.href = 'download.php?file=' + fileName;
    link.download = fileName + '.txt';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
function addRow(tableID) {
    var table = document.getElementById(tableID);
    var lastRow = table.rows[table.rows.length - 1];
    var inputs = lastRow.getElementsByTagName('input');
    var input1 = inputs[0].value.trim();
    var input2 = inputs[1].value.trim();

    if (input1 !== '' && input2 !== '') {
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);

        cell1.innerHTML = '<input class="form-control" name="input1[]" oninput="addRow(\'dataTable\')" type="text">';
        cell2.innerHTML = '<input class="form-control" name="input2[]" oninput="addRow(\'dataTable\')" type="text">';

        document.getElementById('clearBtn').style.display = 'block';
        document.getElementById('shortenBtn').style.display = 'block';
    }
}

function clearTable() {
    var confirmation = confirm("Are you sure you want to clear the tables?");
    if (confirmation) {
        var table = document.getElementById('dataTable');
        while (table.rows.length > 2) {
            table.deleteRow(1);
        }

        var inputs = table.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].value = '';
        }
        document.getElementById('clearBtn').style.display = 'none';
        document.getElementById('shortenBtn').style.display = 'none';
    }
}

function isTableFilled() {
    var table = document.getElementById('dataTable');
    var rows = table.getElementsByTagName('tr');
    // Start at index 1 to skip the header row
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

function isFileUploaded() {
    var fileInput = document.getElementById('fileImport');
    return fileInput.files.length > 0;
}

function toggleShortenButton() {
    if (isTableFilled() && isFileUploaded()) {
        buttonGroup.innerHTML =
            "<div aria-label=\"Button group with spacing\" class=\"btn-group me-2\" role=\"group\">" +
            "   <div class=\"btn-group\" style=\"width: 50%;\">" +
            "       <input class=\"btn btn-danger btn-block\" id=\"clearBtn\" onclick=\"clearTable()\" type=\"button\" value=\"Clear Table\">" +
            "   </div>" +
            "   <div class=\"btn-group me-2\" role=\"group\"></div>" +
            "   <div class=\"btn-group\" style=\"width: 50%;\">" +
            "       <input class=\"btn btn-info btn-block\" id=\"shortenBtn\" type=\"submit\" value=\"Shorten!\">" +
            "   </div>" +
            "</div>"
        ;
    }
}

document.getElementById('fileImport').addEventListener('change', toggleShortenButton);
document.getElementById('dataTable').addEventListener('input', toggleShortenButton);

const buttonGroup = document.getElementById('buttonGroup');
const fileInput = document.getElementById('fileImport');
const fileErrorAlert = document.getElementById('fileError');
const fileSuccessAlert = document.getElementById('fileSuccess');

fileInput.addEventListener('change', function () {
    const file = fileInput.files[0];
    if (file) {
        const fileName = file.name;
        const extension = fileName.split('.').pop();
        if (extension !== 'txt') {
            fileErrorAlert.style.display = 'block';
            fileInput.value = '';

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

            setTimeout(function () {
                fileErrorAlert.style.display = 'none';
            }, 2000);
        } else {
            fileErrorAlert.style.display = 'none';
            fileSuccessAlert.style.display = 'block';
            document.getElementById('fileName').innerText = fileName;

            setTimeout(function () {
                fileSuccessAlert.style.display = 'none';
            }, 2000);

            toggleShortenButton();
        }
    }
});

function downloadFileFromServer(fileName) {
    const link = document.createElement('a');
    link.href = 'download.php?file=' + fileName;
    link.download = fileName + '.txt';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

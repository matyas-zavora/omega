<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alpha 2</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="./img/favicon/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180">
    <link href="./img/favicon/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png">
    <link href="./img/favicon/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png">
    <link href="./img/favicon/site.webmanifest" rel="manifest">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="./styles/reset.css" rel="stylesheet">
    <link href="./styles/index.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h1>
            <img alt="Logo" src="./img/favicon/android-chrome-512x512.png"
                 style="height: 78px; vertical-align: middle;">
            <span class="text-info">Alpha 2</span>
        </h1>
        <p>Alpha 2 is a simple web application that allows you to shorten desired text based on
            <span class="text-info">T</span>he
            <span class="text-info">M</span>ighty
            <span class="text-info">T</span>able
            <span class="text-info">O</span>f
            <span class="text-info">S</span>hortages (<span class="text-info">TMTOS</span>) &#169;</p>
    </div>

    <div class="alert alert-danger" id="fileError" role="alert" style="display: none;">
        Invalid file format! Please upload a .txt file.
    </div>
    <div class="alert alert-success" id="fileSuccess" role="alert" style="display: none;">
        <span id="fileName"></span> has been successfully uploaded.
    </div>
    <div class="alert alert-danger" id="phpError" role="alert" style="display: none;"></div>
    <div class="alert alert-success" id="phpSuccess" role="alert" style="display: none;"></div>
    <div class="alert alert-info" id="phpInfo" role="alert" style="display: none;"></div>

</div>
<form enctype="multipart/form-data" id="shortenForm" method="post">
    <div class="container">
        <div class="form-group">
            <label class="form-label" for="fileImport">Upload a .txt file</label>
            <input class="form-control form-control-lg" id="fileImport" name="fileImport" type="file">
        </div>

        <div class="form-group">
            <label for="outputFileName">Output File Name</label>
            <input class="form-control" id="outputFileName" name="outputFileName" placeholder="Enter output file name"
                   type="text">
        </div>

        <div class="divider"></div>

        <div class="row">
            <h1 class="text-center">
                <span class="text-info">T</span>he
                <span class="text-info">M</span>ighty
                <span class="text-info">T</span>able
                <span class="text-info">O</span>f
                <span class="text-info">S</span>hortages &#169;
            </h1>
        </div>
        <div class="form-group">
            <table class="table table-striped" id="dataTable">
                <thead>
                <tr>
                    <th scope="col">I want this...</th>
                    <th scope="col">To be replaced with this...</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input class="form-control" name="input1[]" oninput="addRow('dataTable')" type="text"></td>
                    <td><input class="form-control" name="input2[]" oninput="addRow('dataTable')" type="text"></td>
                </tr>
                </tbody>
            </table>
            <div class="btn-group btn-group-justified" id="buttonGroup" style="width: 100%;">
                <div class="btn-group" style="width: 50%;">
                    <input class="btn btn-danger btn-block" id="clearBtn" onclick="clearTable()" style="display: none;"
                           type="button"
                           value="Clear Table">
                </div>
            </div>
        </div>
    </div>
</form>
<div class="container">
    <button class="btn btn-primary" onclick="window.location.href='./assignment.php'">Assignment</button>
    <a class="btn btn-primary" download href="./log/log.txt">Download Log</a>
    <a class="btn btn-primary" href="https://github.com/matyas-zavora/aplha-2" target="_blank">Github</a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="./scripts/index.js"></script>

</body>
</html>

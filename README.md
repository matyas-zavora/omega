# OmniToolBox

## Table of Contents
1. [Introduction](#introduction)
2. [Project Overview](#project-overview)
3. [Database Structure](#database-structure)
4. [Functionality](#functionality)
5. [Requirements](#requirements)
6. [Installation](#installation)
7. [Usage](#usage)
8. [CLOC results](#cloc)

---

## Introduction <a id="introduction"></a>
OmniToolBox is a versatile web application designed to serve as a central hub for managing various projects. It integrates multiple tools such as Trimify, EstateAtlas, and ListEase into a single platform for enhanced convenience and productivity.

---

## Project Overview <a id="project-overview"></a>
The project includes functionalities from multiple sub-projects, namely Trimify, EstateAtlas, and ListEase. Each sub-project contributes specific features such as text shortening, real estate data management, and list management, respectively.

---

## Database Structure <a id="database-structure"></a>
The application uses a MySQL database to store data related to each sub-project. Each sub-project may have its own database schema, tailored to its specific requirements.

<details>
<summary>EstateAtlas</summary>
<img src="/home/zavoram/Desktop/omega/323735979-464f72ce-0a3e-4305-9934-4f92eab5ff09.png">
</details>
<details>
<summary>ListEase</summary>
<img src="/home/zavoram/Desktop/omega/323736098-40634d0d-bdaa-4ebb-8583-f8a61ec5c26f.png">
</details>

---

## Functionality <a id="functionality"></a>
- **User Authentication**: Users can register and login to access the application.
- **Project Integration**: OmniToolBox integrates functionalities from Trimify, EstateAtlas, and ListEase into a unified platform.
- **Data Management**: Users can manage data specific to each sub-project, such as short texts, real estate parcel information, and list items.
- **Database Operations**: Administrators can perform database operations such as deletion if needed.

---

## Requirements <a id="requirements"></a>
- PHP 7.0 or higher
- MySQL 5.6 or higher
- Web Server (Apache, Nginx, etc.)
- Web Browser (Chrome, Firefox, Safari, etc.)
- Internet Connection (Optional)

---

## Installation <a id="installation"></a>
1. Clone the repository to your local machine.
2. Ensure that PHP and MySQL are installed on your server.
3. Upload the project files to your web server.
4. Set appropriate file permissions for uploaded files and directories.
5. Access the application through a web browser.

---

## Usage <a id="usage"></a>
1. Register or login to the application.
2. Access tools and functionalities such as Trimify, EstateAtlas, or ListEase from the unified interface.
3. Manage data, perform operations, and access features specific to each sub-project seamlessly.
4. Log out of the application when done.
5. Delete database records if wanted from the main menu.

--- 

## CLOC results <a id="cloc"></a>
cloc --exclude-dir=vendor,.idea  . && cloc --exclude-dir=vendor,.idea --by-file .

```
      63 text files.
      56 unique files.                              
      24 files ignored.

github.com/AlDanial/cloc v 1.90  T=0.02 s (2299.6 files/s, 202522.4 lines/s)
-------------------------------------------------------------------------------
Language                     files          blank        comment           code
-------------------------------------------------------------------------------
PHP                             27            235            402           2442
Markdown                         3             56              0            208
JavaScript                       3             27             41            187
CSS                              5             24              5            136
JSON                             4              0              0             19
CSV                              1              0              0              5
-------------------------------------------------------------------------------
SUM:                            43            342            448           2997
-------------------------------------------------------------------------------
      63 text files.
      56 unique files.                              
      24 files ignored.

github.com/AlDanial/cloc v 1.90  T=0.02 s (2238.5 files/s, 197145.7 lines/s)
----------------------------------------------------------------------------------------------
File                                                       blank        comment           code
----------------------------------------------------------------------------------------------
./connect.php                                                 28             38            271
./estateatlas/manually.php                                    31             51            269
./estateatlas/templates.php                                    4             23            201
./listease/index.php                                          17              6            196
./estateatlas/upload.php                                      19             22            160
./index.php                                                    7             24            138
./trimify/index.php                                            9             18            126
./trimify/assignment.php                                       0              0            122
./estateatlas/read.php                                        15             17            119
./trimify/scripts/index.js                                    17             20            107
./trimify/README.md                                           30              0            101
./trimify/functions.php                                       11             40             79
./estateatlas/register.php                                     8             13             70
./estateatlas/index.php                                        2              8             69
./listease/register.php                                       10             12             69
./estateatlas/login.php                                        7             11             68
./listease/login.php                                           7             11             68
./scripts/dark-mode.js                                         5              9             65
./estateatlas/assignment.php                                   0              0             60
./estateatlas/README.md                                       10              0             56
./styles/font.css                                             11              0             56
./estateatlas/download_full_parcel_data.php                   13             15             53
./estateatlas/files.php                                        4              5             53
./estateatlas/write.php                                        0              0             53
./README.md                                                   16              0             51
./database_checker.php                                         9             18             48
./trimify/styles/reset.css                                     7              5             42
./delete.php                                                   1             12             37
./trimify/test/FileProcessingTest.php                         13             28             29
./listease/quantity.php                                        6              9             25
./listease/price.php                                           6              9             24
./listease/delete.php                                          6              9             23
./trimify/styles/index.css                                     3              0             17
./listease/scripts/index.js                                    5             12             15
./trimify/styles/assignment.css                                3              0             15
./trimify/composer.json                                        0              0              8
./listease/logout.php                                          2              3              7
./estateatlas/styles/google_icons.css                          0              0              6
./composer.json                                                0              0              5
./estateatlas/composer.json                                    0              0              5
./estateatlas/logout.php                                       0              0              5
./estateatlas/output/full_parcel_data.csv                      0              0              5
./trimify/img/favicon/site.webmanifest                         0              0              1
----------------------------------------------------------------------------------------------
SUM:                                                         342            448           2997
----------------------------------------------------------------------------------------------
```

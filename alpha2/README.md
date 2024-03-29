# <img src="https://i.imgur.com/lPtkKoH.png" width="40"> Alpha 2

## Description

This is the second alpha project.
It is a website that allows the user to upload a text file and then shorten it (or make it longer) based on user's
criteria.
The processing is done by a backend written
in <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/2560px-PHP-logo.svg.png" width="40">.
The website is written
in <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/38/HTML5_Badge.svg/800px-HTML5_Badge.svg.png" width="20">,
<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/62/CSS3_logo.svg/1024px-CSS3_logo.svg.png" width="20">
and <img src="https://iconape.com/wp-content/png_logo_vector/javascript-logo.png" width="18">.

###### <a href="https://youtu.be/WSIvP9uCOAw?si=NxzMHvnKdOQCV5Ui" style="a {color: inherit;text-decoration: none; cursor: default;}">Hey, listen!</a> The shortening is also case-insensitive.

<br>

This project was made by [Matyáš Závora](https://www.linkedin.com/in/matyas-zavora/) (me)
<br><a href="https://www.linkedin.com/in/matyas-zavora/"><img src="https://avatars.githubusercontent.com/u/105340917?v=4" width=10%></a>

#### Grade(s):
|           Percent score            |   70%    |
|:----------------------------------:|:--------:|
|            Czech grade             |  __2__   |
|  Configurability and universality  | __85%__  |
|  Architecture and design patterns  | __40%__  |
|   Usability and program control    | __63%__  |
|     Correctness and efficiency     | __83%__  |
|     Testing and error handling     | __66%__  |
| Documentation and code readability | __100%__ |

### Prerequisites

- [<u><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/03/Xampp_logo.svg/2560px-Xampp_logo.svg.png" width="80"></u>](https://www.apachefriends.org/index.html) (
  or any other web server)
- [<u><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/2560px-PHP-logo.svg.png" width="40"></u>](https://www.php.net/downloads.php)
  7.4 (or higher)
- A web browser
- A text file to shorten
- (Optional) Access to the internet (
  for <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Bootstrap_logo.svg/2560px-Bootstrap_logo.svg.png" width="24">)
    - Note: website is fully functional
      without <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Bootstrap_logo.svg/2560px-Bootstrap_logo.svg.png" width="24">,
      but it won't look as good as it is supposed to.

## Installation

#### Windows

1. Open <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/03/Xampp_logo.svg/2560px-Xampp_logo.svg.png" width="80">
or any other web server
2. Clone this repository into the `htdocs` folder of <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/03/Xampp_logo.svg/2560px-Xampp_logo.svg.png" width="80">
3. Start <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/03/Xampp_logo.svg/2560px-Xampp_logo.svg.png" width="80"> (Apache should be enough) (default port is 80)
4. Open `localhost[:port]/alpha2` in your browser

#### Linux

1. Clone this repository into `/var/www/html`
2. Start Apache (default port is 80)
3. Open `localhost[:port]/alpha2` in your browser

If you get a permission error, run `sudo chmod -R 777 /var/www/html/alpha2`
and `sudo chown -R www-data:www-data /var/www/html/alpha2`.
This will give the web server full access to the folder.

## Usage

1. Open the website in your browser (see [Installation](#installation))
2. Click on the `Choose file` button
3. Select a text file
4. Fill out The mighty table of shortages
5. (Optional) Change the name of the output file
6. Click on the `Shorten!` button
7. Wait for the website to process the file
8. Select a location to save the processed file
9. Click on the `Save` button

### Example

#### Input

```
Lorem ipsum dolor sit amet.
```

#### The mighty table of shortages

| Shortage | Replacement |
|----------|-------------|
| Lorem    | L           |
| ipsum    | i           |
| dolor    | d           |
| sit      | s           |
| amet     | a           |

#### Output

```
L i d s a.
```

## TODO

### Meta

- [X] Write `README.md`
- [X] Turn assignment in on Moodle in time
- [X] Make sure everything works
- [X] Make sure everything is documented

### Frontend

- [X] Change assignment button placement
- [X] Make file input accept only text files
- [X] Change style of file input
- [X] Make submit button appear only when file is uploaded
- [X] Change button style (add more space in between)
- [X] Implement text input for name of output file

### Backend

- [X] Make submit button work
- [X] Make file input work
- [X] Make text input work (name of output file)
- [X] Output processed file (website starts downloading it)
    - [X] Make processing case-insensitive
    - [X] Fix file deletion from server
- [X] Add unit tests
- [X] Add "show logs" button
    - Routes to a page that shows logs 

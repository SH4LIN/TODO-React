# Movie Library Advance Plugin - Dashboard Widget

The Dashboard Widget feature is used to display the top-rated movies upcoming movies and recent movies.

- Recent movies and Top-rated movies are displayed from the Plugin DB.
- Upcoming movies are displayed from the IMDB API.
  ​
  **You can directly see the Dashboard Widget from below URL**

[Movie Library Advance Plugin - Dashboard Widget](https://feature-dashboard-widget.shalin-shah.tr.rt.gw/wp-admin/)

## Overview

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
1. **plugins/movie-library/admin/classes/partials/dashboard-movie-card.php**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
       - Partial is created to display the movie card.
       - It contains the code for.
       1. Movie Poster.
       2. Movie Title.
       3. Edit and View buttons according to the user's capabilities.
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

2. **plugins/movie-library/admin/classes/widgets/class-upcoming-movies-widget.php, plugins/movie-library/admin/classes/widgets/class-movies-widget.php**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
       These files fetch the Movie details either from the Plugin DB or IMDB API and 
       display it accordingly using the dashboard-movie-card partial.

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

## Directory Structure
```bash
.
|-- README.md
|-- admin
|   |-- classes
|   |   |-- class-asset.php
|   |   |-- class-movie-library-save-post.php
|   |   |-- class-settings-page.php
|   |   |-- custom-post-types
|   |   |   |-- class-rt-movie.php
|   |   |   `-- class-rt-person.php
|   |   |-- meta-boxes
|   |   |   |-- class-rt-media-meta-box.php
|   |   |   |-- class-rt-movie-meta-box.php
|   |   |   `-- class-rt-person-meta-box.php
|   |   |-- partials
|   |   |   `-- dashboard-movie-card.php
|   |   |-- shortcodes
|   |   |   |-- class-movie-shortcode.php
|   |   |   `-- class-person-shortcode.php
|   |   |-- taxonomies
|   |   |   |-- class-movie-genre.php
|   |   |   |-- class-movie-label.php
|   |   |   |-- class-movie-language.php
|   |   |   |-- class-movie-person.php
|   |   |   |-- class-movie-production-company.php
|   |   |   |-- class-movie-tag.php
|   |   |   `-- class-person-career.php
|   |   `-- widgets
|   |       |-- class-movies-widget.php
|   |       `-- class-upcoming-movies-widget.php
|   |-- css
|   |   `-- movie-library-admin.css
|   |-- images
|   |   `-- placeholder.webp
|   `-- js
|       |-- movie-library-character.js
|       |-- movie-library-custom-label.js
|       |-- movie-library-image-video-upload.js
|       |-- movie-library-rt-movie-validation.js
|       `-- movie-library-rt-person-validation.js
|-- includes
|   |-- class-autoloader.php
|   |-- class-movie-library.php
|   `-- class-singleton.php
|-- index.php
|-- languages
|   `-- movie-library.pot
|-- movie-library.php
|-- public
|   |-- css
|   |   `-- movie-library-frontend.css
|   `-- js
|       `-- movie-library-frontend.js
`-- uninstall.php

16 directories, 38 files

```
## Built with
​
-   **PHP**
-   **HTML/CSS/Javascript**
-   **Docker**
-   **wp-i18n**
    ​
## Screenshots
​
![image](https://user-images.githubusercontent.com/56588503/230004203-c0cdd50b-e29e-452b-8b7c-49d37f54917e.png)
![image](https://user-images.githubusercontent.com/56588503/230004242-62c9f8d7-821e-4479-9fba-ddea2b63ce08.png)
![image](https://user-images.githubusercontent.com/56588503/230004295-453d71e5-ee53-46fd-8688-130e75de728a.png)


​
## Authors
​
-   [rtCamp](https://github.com/rtCamp)
    ​
## Feedback
​
Please feel free to discuss anything about rt Movie Plugin to shalin.shah@rtcamp.com
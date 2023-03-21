## [Screen Time - Theme](https://feature-theme.shalin-shah.tr.rt.gw/)

This is a child theme for the Twenty Twenty-One theme. 
It is a theme for the Movie Library plugin. It has four templates
1. [archive-rt-movie.php](https://feature-theme.shalin-shah.tr.rt.gw/rt-movie/)
2. [archive-rt-person.php](https://feature-theme.shalin-shah.tr.rt.gw/rt-person/)
3. [single-rt-movie.php](https://feature-theme.shalin-shah.tr.rt.gw/rt-movie/avengers-endgame/)
4. [single-rt-person.php](https://feature-theme.shalin-shah.tr.rt.gw/rt-person/chris-evans/)
5. header.php
6. footer.php



## Overview
1. **header.php**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        It is divided into four parts (Desktop): (site-header.php)
            1. Search action (site-search.php)
            2. Logo (site-logo.php)
            3. Login action (site-login-language.php)
            4. Menu (site-nav.php)

        It is divided into three parts (Mobile / Tablet): (site-header.php)
            1. Search action (No label) (site-search.php)
            2. Logo (site-logo.php)
            3. Menu action (Expanded menu) (site-nav-expanded.php)
        
        Every section divided in the header is a separate file 
        and is included in the site-header.php file.
        which is included in the header.php file.

        header.css is used for styling the header.


2. **footer.php**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
       It is divided into the three parts (Desktop): (site-footer.php)
            1. Footer social (footer-content.php)
            2. Footer menu (footer-menu.php)
            3. Footer credits (footer-copyright.php)

       It is divided into the two parts (Mobile / Tablet): (site-footer.php)
            1. Footer social (footer-content.php)
            2. Footer credits (footer-copyright.php)

       Every section divided in the footer is a separate file and included in the site-footer.php file. 
       Which is included in the footer.php file.
       
       footer.css is used for styling the footer.
       
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

3. **archive-rt-movie.php**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
         It is the archive template for the rt-movie post type.

         It is divided into three parts (Desktop): (archive-rt-movie-template.php)
            1. Movie slider (slider-template.php)
            2. Movie trending movie list (trending-movies-template.php)
            3. Movie upcoming movie list (upcoming-movies-template.php)

         Every section divided in the separate files and
         included in the archive-rt-movie-template.php file.
         which is included in the archive-rt-movie.php file.
          
         archive-movie.css is used for styling the archive-movie.php file.
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

4. **archive-rt-person.php**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        It is the archive template for the rt-person post type.

        It is divided into single section (Desktop): (archive-rt-person-template.php)
            1. Person list (person-list-template.php)

        Section is included into the archive-rt-person.php file.
        
        archive-person.css is used for styling the archive-person.php file.
            

5. **single-rt-movie.php**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        It is the single template for the rt-movie post type.

        It is divided into six section (Desktop): (single-rt-movie-template.php)
            1. Movie details (poster-title-template.php)
            2. Movie description (plot-quick-links-template.php)
            3. Movie cast (cast-crew-template.php)
            4. Movie reviews (reviews-template.php)
            5. Movie videos (trailers-clips-template.php)
            6. Movie snapshots (snapshots-template.php)

        Every section is divided into separate files
        and included in single-rt-movie-template.php.
        which is included into the single-rt-movie.php file.
        
        single-movie.css is used for styling the single-movie.php file.

6. **single-rt-person.php**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        It is the single template for the rt-person post type.

        It is divided into two section (Desktop): (single-rt-person-template.php)
            1. Person details (hero-template.php)
            2. Person description (about-quick-links-template.php)
            3. Person popular movies (popular-movies-template.php)
            4. Person snapshots (snapshots-template.php)
            5. Person videos (videos-template.php)

        Every section is divided into separate files
        and included in single-rt-person-template.php.
        which is included into the single-rt-person.php file.
        
        single-person.css is used for styling the single-person.php file.

## Directory Structure
```bash
.
|-- README.md
|-- archive-rt-movie.php
|-- archive-rt-person.php
|-- assets
|   |-- css
|   |   |-- about.css
|   |   |-- archive-movie.css
|   |   |-- archive-person.css
|   |   |-- common.css
|   |   |-- footer.css
|   |   |-- header.css
|   |   |-- movies.css
|   |   |-- single-movie.css
|   |   |-- single-person.css
|   |   |-- snapshots.css
|   |   `-- videos.css
|   |-- images
|   |   |-- ic_arrow.svg
|   |   |-- ic_arrow_red.svg
|   |   |-- ic_close.svg
|   |   |-- ic_down.svg
|   |   |-- ic_down_arrow.svg
|   |   |-- ic_facebook_filled.svg
|   |   |-- ic_instagram.svg
|   |   |-- ic_instagram_filled.svg
|   |   |-- ic_menu.svg
|   |   |-- ic_play.svg
|   |   |-- ic_rss_filled.svg
|   |   |-- ic_search.svg
|   |   |-- ic_star.svg
|   |   |-- ic_twitter.svg
|   |   |-- ic_twitter_filled.svg
|   |   |-- ic_user.svg
|   |   |-- ic_youtube_filled.svg
|   |   |-- placeholder-banner.png
|   |   `-- placeholder.webp
|   `-- js
|       |-- menu-expand.js
|       |-- movie-slider.js
|       `-- video-player.js
|-- classes
|   |-- class-archive-rt-movie-data.php
|   |-- class-archive-rt-person-data.php
|   |-- class-single-rt-movie-data.php
|   |-- class-single-rt-person-data.php
|   `-- trait-singleton.php
|-- footer.php
|-- functions.php
|-- header.php
|-- inc
|-- languages
|   `-- screen-time.pot
|-- single-rt-movie.php
|-- single-rt-person.php
|-- style.css
`-- template-parts
    |-- footer
    |   `-- footer-menu.php
    |-- header
    |   |-- site-header.php
    |   `-- site-nav-expanded.php
    |-- navigation
    |-- page
    `-- post
        |-- about-template.php
        |-- movie-template.php
        |-- rt-movie
        |   |-- archive
        |   |   |-- slider-template.php
        |   |   `-- upcoming-movies-template.php
        |   `-- single
        |       |-- cast-crew-template.php
        |       |-- poster-title-template.php
        |       `-- reviews-template.php
        |-- rt-person
        |   `-- single
        |       `-- hero-template.php
        |-- snapshots-template.php
        `-- videos-template.php

19 directories, 61 files


```
## Built with
​
-   **PHP**
-   **HTML/CSS/Javascript**
-   **Local**
-   **wp-i18n**
​

## Screenshots
​
![image](https://user-images.githubusercontent.com/56588503/225207642-8dfe8677-bf45-4610-a50d-2513de84d102.png)

![image](https://user-images.githubusercontent.com/56588503/225207733-a133839b-658c-4436-b2ef-1a21ac0eced2.png)

<img width="1470" alt="Screenshot 2023-03-15 at 10 06 43 AM" src="https://user-images.githubusercontent.com/56588503/225207799-c6f4c80f-4610-428e-8ab0-5352a11bdc15.png">

![image](https://user-images.githubusercontent.com/56588503/225207856-d0687e0c-be53-4a0e-af5e-fddc8e8be401.png)

​
## Authors

-   [rtCamp](https://github.com/rtCamp)
## Feedback
​
Please feel free to discuss anything about rt Movie Plugin to shalin.shah@rtcamp.com
# Movie Library Plugin

​
The movie Library plugin can be used to create a movie library like IMDB where new movies released are published with ratings.
​
## Run Locally
​
**Clone the project by running the following**
​
```bash
  git clone https://github.com/rtCamp/trainee-shalin-shah.git
```
​
**Navigate to the trainee-shalin-shah directory by executing**
​
```bash
  cd php-shalin-shah
```
**You can also access the site using the following URL**

[RT Movie Plugin](https://feature-plugin.shalin-shah.tr.rt.gw/)

## Overview
1. **Custom post types created**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        1. Movie (rt-movie) 
           - It will support the title, editor, excerpt, thumbnail, author, and comment
           - and It will store the  Movie title, Movie plot, Synopsis and poster image using the default post inputs.
        2. Person (rt-person) 
           - It will support the title, editor, excerpt, thumbnail, and author 
           - and it will store Name, Biography and Profile picture.


2. **Custom taxonomies created**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
       Hierarchical taxonomies for the rt-movie

       1. Genre (rt-movie-genre)
       2. Labels (rt-movie-label)
       3. Language (rt-movie-language)
       4. Production Company (rt-movie-production-company)


       Non-hierarchical taxonomies for the rt-person

	    1. Tags (rt-movie-tag)
	    2. Person (_rt-movie-person)
		  - It is a Shadow taxonomy, which means it’s not public and has no UI.
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
       Hierarchical taxonomy for the rt-person

	   1. Career (rt-person-career)

3. **Custom meta-boxes created**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    Basic metadata for the `rt-movie` post type. It will provide inputs for the following.

    1. Rating (rt-movie-meta-basic-rating) -
       - The user can rate between 1 to 10 if the value exceeds 10 then it will automatically store the highest rating which is 10
       - and if the user tries to rate with a negative value then it will automatically store the lowest rating which is 0.
       - The user will only be able to enter the numbers if the user tries to enter a value other than the number then it won't be stored.

    2. Runtime (rt-movie-meta-basic-runtime)
       - It will allow only numbers to be entered.

    3. Release Date (rt-movie-meta-basic-release-date)  
       - It will store the date.
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    Crew metadata for the rt-movie post type. It will provide multiple selection dropdowns for the following.

    1. Director (rt-movie-meta-crew-director)
       - It will fetch all person details who are directors and show them in the dropdown.

    2. Producer (rt-movie-meta-crew-producer)
       - It will fetch all person details who are producers and show them in the dropdown.

    3. Writer (rt-movie-meta-crew-writer)
       - It will fetch all person details who are writers and show them in the dropdown.

    4. Actor (rt-movie-meta-crew-actor)
       - It will fetch all person details who are actors and show them in the dropdown.
       - Selecting any actor will add an input field in which the user can give the character name of that actor in that movie.
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    Basic metadata for the rt-person post type. It will provide multiple selection dropdowns for the following.

    1. Birth Date (rt-person-meta-basic-birth-date)
    2. Birth Place (rt-person-meta-basic-birth-place)
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    Social metadata for the rt-person-meta-social post type. It will provide multiple selection inputs for the following.


    1. Twitter (rt-person-meta-social-twitter)
    2. Facebook (rt-person-meta-social-facebook)
    3. Instagram (rt-person-meta-social-instagram)
    4. Website (rt-person-meta-social-web)

    All the fields are sanitized using the **esc_url_raw()** function.

4. **Custom meta-boxes for photos and videos created**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
   	Photo (rt-media-meta-images)
   	Video  (rt-media-meta-videos) 
   		- meta-boxes are created for the rt-movie and rt-person to allow them to upload images and videos.

5. **Shortcodes created**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
   	[movie] and [person] shortcodes are created with allowed attributes.

6. **Settings page created**
---
   	The settings page is created with a checkbox for the user to check and a proper warning of what will happen if the user checks that checkbox.

## Directory Structure
```bash
.
|-- README.md
|-- admin
|   |-- classes
|   |   |-- class-asset.php
|   |   |-- class-movie-library-activation.php
|   |   |-- class-movie-library-deactivation.php
|   |   |-- class-movie-library-save-post.php
|   |   |-- class-settings-page.php
|   |   |-- custom-post-types
|   |   |   |-- class-rt-movie.php
|   |   |   `-- class-rt-person.php
|   |   |-- meta-boxes
|   |   |   |-- class-rt-media-meta-box.php
|   |   |   |-- class-rt-movie-meta-box.php
|   |   |   `-- class-rt-person-meta-box.php
|   |   |-- roles-capabilities
|   |   |   `-- class-movie-manager-role-capabilities.php
|   |   |-- shortcodes
|   |   |   |-- class-movie-shortcode.php
|   |   |   `-- class-person-shortcode.php
|   |   `-- taxonomies
|   |       |-- class-movie-genre.php
|   |       |-- class-movie-label.php
|   |       |-- class-movie-language.php
|   |       |-- class-movie-person.php
|   |       |-- class-movie-production-company.php
|   |       |-- class-movie-tag.php
|   |       `-- class-person-career.php
|   |-- css
|   |   `-- movie-library-admin.css
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

14 directories, 37 files
```

## Screenshots
​
<img width="1470" alt="Screenshot 2023-03-06 at 11 24 32 AM" src="https://user-images.githubusercontent.com/56588503/223030141-41281663-f1f9-46e5-9957-dbf56133742f.png">
<img width="1470" alt="Screenshot 2023-03-06 at 11 25 01 AM" src="https://user-images.githubusercontent.com/56588503/223030169-2797abfc-1bfe-4fa8-b362-4cf8eca9f5de.png">
<img width="1470" alt="Screenshot 2023-03-06 at 11 25 21 AM" src="https://user-images.githubusercontent.com/56588503/223030176-6f53df25-691c-4d51-911d-54d5c4019cfb.png">
<img width="1470" alt="Screenshot 2023-03-06 at 11 25 33 AM" src="https://user-images.githubusercontent.com/56588503/223030181-637cc3b0-9e2e-4a66-98e7-5ec9e9cc41e1.png">
<img width="1470" alt="Screenshot 2023-03-06 at 11 25 37 AM" src="https://user-images.githubusercontent.com/56588503/223030191-1677209e-c48a-4b96-98e0-23011eaaa434.png">


# Movie Library Advance Plugin - Rewrite Rules

The Rewrite Rukes feature is used to Change the permalink of the single post as below.

Movie post type URL structure

http://your-site.test/movie/%genre-taxonomy%/%postname%-%post_id%/

Example, http://your-site.test/movie/action/movie-post-slug-postID/

Person post type URL structure

http://your-site.test/person/%career-taxonomy%/%postname%-%post_id%/

Example, http://your-site.test/person/director/person-post-slug-postID/

**You can directly see the Rewrite rules below URL**

[Movie Library Advance Plugin - Rewrite Rules](https://feature-rewrite-rules.shalin-shah.tr.rt.gw)
[Avengers Endgame Movie URL](https://feature-rewrite-rules.shalin-shah.tr.rt.gw/movie/adventure/avengers-endgame-220/)

1. **class-rt-movie.php, class-rt-person.php**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
     CPT files are updated with hooks and filters that will be used to update the permalink structure of the post type
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
## Screenshots

![image](https://user-images.githubusercontent.com/56588503/230009491-24cad64a-3da6-464f-8935-ef007c6f0ddd.png)
![image](https://user-images.githubusercontent.com/56588503/230009593-47e6e18f-63df-41ad-a930-54ef6722cffa.png)

# Movie Library Advance Plugin - Custom Roles

The Custom Roles feature is used to allow only the admin and movie manager to access the movie CPT and person CPT

**You can directly see the Custom Roles from below URL**

[Movie Library Advance Plugin - Custom Roles](https://feature-custom-roles.shalin-shah.tr.rt.gw/wp-admin/)

## Overview

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
1. **class-movie-manager-role-capabilities.php**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
      This file will create movie-manager role on plugin activation and add all the required capabilities to access the movies and person.
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

2. **CPT and taxonomies are updated to have custom capability**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
       1. rt-movie has capability type of movie
       2. rt-person has capability type of array(person, people).
       3. Taxonomy capabilities added like manage_{taxonomy}, edit_{taxonomy} , delete_{taxonomy} , assign_{taxonomy} 
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


![image](https://user-images.githubusercontent.com/56588503/230005089-43f6df4d-4f15-49a4-b4c7-0a04b653f072.png)
![image](https://user-images.githubusercontent.com/56588503/230005288-7f98e159-236e-4c7c-9708-b35f1d3b3969.png)


## Built with
-   **PHP**
-   **HTML/CSS/Javascript**
-   **Docker**
-   **wp-i18n**

## Authors
-   [rtCamp](https://github.com/rtCamp)
## Feedback

Please feel free to discuss anything about rt Movie Plugin to shalin.shah@rtcamp.com
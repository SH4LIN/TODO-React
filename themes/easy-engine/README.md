## [Easy Engine - Theme](https://feature-theme-easy-engine.shalin-shah.tr.rt.gw/)

This is a Parent theme easy-engine Referenced from [Easy Engine](https://easyengine.io/)
Data is fetched using the given testing data
1. [Front Page](https://feature-theme-easy-engine.shalin-shah.tr.rt.gw/)
2. [Blog Page](https://feature-theme-easy-engine.shalin-shah.tr.rt.gw/blog/)
3. [Single Page](https://feature-theme-easy-engine.shalin-shah.tr.rt.gw/block-image/)
4. header.php
5. footer.php



## Overview
1. **header.php**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        In the header.php the logo is displayed using the_logo().
        If the logo does not exist than it will display the site title.
        The site title is displayed using bloginfo('name').

        Then for the small screen it has expanded menu 
        and for the large screen it has the menu directly displayed in the header.
        
        Large screen menu and small screen menu are displayed using the wp_nav_menu() function.
        Large screen menu can support the dropdown menu till depth 10.

        Search functionality is implemented using the searchform.php file.
        You can disable the search functionlity from the Appearance >> Easy Engine Settings.

        header.scss is used for styling the header.
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
2. [Front Page](https://feature-theme-easy-engine.shalin-shah.tr.rt.gw/)
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        Front Page is created using the gutenberg blocks.

        CSS for the pre tag is added using my CSS.
        Columns block is converted into grid using my CSS.
        Custom classes used to style the columns in the front page.
        .has-3-columns
        .has-2-columns
       
        front-page.scss is used for styling the front page.
       
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
3. [Blog Page](https://feature-theme-easy-engine.shalin-shah.tr.rt.gw/blog/)
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        Blog page is assigned to `a blog page` page from admin Reading panel.
        `a blog page` is assigned page template template-front-page.php.
        
        template-front-page.php uses template-parts/blog-template.php template file. To display the Posts.

        In the blog page following details are displayed.

        1. post date.
        2. post tile 
        3. post author 
        4. post categories and 
        5. post tags 

        For each post.

        Navigation for the blog page is displayed using the_posts_navigation().

        blog.scss and blog-template.scss is used for styling the blog page.
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
4. [Single Page](https://feature-theme-easy-engine.shalin-shah.tr.rt.gw/block-image/)
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        In the single post page the post title is displayed using the_title().
        then the author of the post and categories and the tags are displayed.

        Then the post content is displayed using the_content().
        
        Post share button and the likes buttons are are displayed using the template-parts/social-buttons.php file.
        Then the comments are displayed using the comments_template().

        
        single-post.scss is used for styling the single page.

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
5. **category.php & tag.php**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        It will display the archive page of the category and tag.
        both of them are using the template-parts/blog-template.php template part to display the posts.

        Pagination is displayed using the_posts_navigation().

        blog.scss and blog-template.scss is used for styling the blog page.
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
6. **footer.php**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        It will display the footer.

        Footer is divided into the four parts.
        1. Documentation menu.
        2. Community menu.
        3. EasyEngine menu.
        4. Newsletter form.

        All the menus are displayed using the wp_nav_menu() function.

        
        footer.scss is used for styling the footer file.

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
7. **functions.php**
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        This file contains the setup theme function and the enqueue scripts and styles function. 
        Also the settings is also registered from this file.
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


## Directory Structure
```bash
.
|-- README.md
|-- SKELETON.md
|-- assets
|   |-- css
|   |   |-- blog-template.css
|   |   |-- blog-template.css.map
|   |   |-- blog.css
|   |   |-- blog.css.map
|   |   |-- comments.css
|   |   |-- comments.css.map
|   |   |-- common.css
|   |   |-- common.css.map
|   |   |-- footer.css
|   |   |-- footer.css.map
|   |   |-- front-page.css
|   |   |-- front-page.css.map
|   |   |-- header.css
|   |   |-- header.css.map
|   |   |-- search.css
|   |   |-- search.css.map
|   |   |-- single-post.css
|   |   |-- single-post.css.map
|   |   |-- social-buttons.css
|   |   `-- social-buttons.css.map
|   |-- images
|   |-- js
|   |   |-- expand-menu.js
|   |   |-- search-form.js
|   |   `-- share-buttons.js
|   |-- scss
|   |   |-- _variables.scss
|   |   |-- blog-template.scss
|   |   |-- blog.scss
|   |   |-- comments.scss
|   |   |-- common.scss
|   |   |-- footer.scss
|   |   |-- front-page.scss
|   |   |-- header.scss
|   |   |-- search.scss
|   |   |-- single-post.scss
|   |   `-- social-buttons.scss
|   `-- svgs
|       `-- down-arrow.svg
|-- category.php
|-- comments.php
|-- footer.php
|-- functions.php
|-- header.php
|-- home.php
|-- index.php
|-- languages
|-- search.php
|-- searchform.php
|-- settings
|   `-- settings-page.php
|-- single-post.php
|-- style.css
|-- tag.php
|-- template-front-page.php
`-- template-parts
    |-- blog-template.php
    `-- socials-buttons.php

10 directories, 53 files
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
<img width="720" alt="Screen Shot 2023-03-29 at 6 08 53 PM" src="https://user-images.githubusercontent.com/56588503/228547927-b6f255a8-293e-4153-af3e-f893f4f47fce.png">

<img width="720" alt="Screen Shot 2023-03-29 at 6 09 28 PM" src="https://user-images.githubusercontent.com/56588503/228548584-931619e7-3147-4882-baed-7ff9983bca88.png">

<img width="720" alt="Screen Shot 2023-03-29 at 6 09 36 PM" src="https://user-images.githubusercontent.com/56588503/228548712-3061421f-f0ba-4e7d-a5c6-8aefe46b1451.png">

<img width="720" alt="Screen Shot 2023-03-29 at 6 10 08 PM" src="https://user-images.githubusercontent.com/56588503/228548800-c4cbb3fd-2948-4ddf-a5d3-4fe37713f798.png">

<img width="720" alt="Screen Shot 2023-03-29 at 6 10 21 PM" src="https://user-images.githubusercontent.com/56588503/228548859-3ce4f150-ba43-4c2d-9650-c862fdd2ef4e.png">


​
## Authors

-   [rtCamp](https://github.com/rtCamp)
## Feedback
​
Please feel free to discuss anything about rt Movie Plugin to shalin.shah@rtcamp.com
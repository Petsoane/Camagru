# Camagru
A small photo editing web application.

# General features
    * No errors, warning, or log line in console when running the webapp. (with exceptions)
    * Only PHP for the server-side code.
    * HTML, CSS, JavaScript for the client side.
    * All external frameworks are forbidden.
    * The PDO abstraction driver must be user to communication with the database, and have its
      error mode set to PDO::ERRMODE_EXCEPTION
    * There should not be any security leak. (At the very least cases in mandatory part)
    * Any web server can be used
    * The web app should be compatible with Firefox (>= 41) and chrome (>=46)

# Features
    * Common features
        The web app should be structured in some way (even though it is not mandatory to do so), have a decent page
        layout that displays correctly on mobile devies as well have an adopted layout on small resolutions.

        All the forms should have validations adding to the whole sites overall security.
        Here are a few things that will make your site insecure:
            * Passwords stored in plain text.
            * HTML and JS injections can be done.
            * unauthorized upload to server.
            * sql injection.
            * ability to manipulate 'private data' from external form.

    * User features
        * User sign up must require a valid email, username and a password with a set minimum
          level of commplexity
        * Users must confirm account after registration.
        * User can then login with set username and password.
            * The user can also send a password reset.
        * Ability to logout in one click from any point in the site.
        * Once logged in, the user should be able to modify some information.

    * Gallery featuress
        * This is public to all visitors of the showing all created images sorted by date
          created.
            * !NB -:
                Only logged in users can like and comment of a picture.
        * Image creator recieves email notification when someone comments on his/her picture
            * This is the a default action that can be turned off by the user.
        * The list of images must piginated, with at least 4 elements per page.

    * Editing features
        * Only accessible by authenticate logged in users.
        * The main section containing:
            * users webcamp preview
            * list of stickers
            * capture button
        * Thumbnails section containing previous pictures.

        Pictures can only be taken when a sticker is chosen, from which , the taken
        picture should be created sent to the server.
        There should also be an upload option for those with no webcam.
        All images can be deleted only if they are owned by the deleting user.

# Required tools
    * PHP
    * SQL
    * html
    * css
    

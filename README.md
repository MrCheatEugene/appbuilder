# appbuilder
A simple mobile application builder, what works in the browser. Code HTML, JS and CSS directly in the beautiful Monaco editor., and then compile it into APK!

# Dependencies

- PHP 7+ Webserver
- Android SDK and Build Tools v. 30.0.3
- Latest Node.js
- Latest Apache Cordova installed
- JDK 8
- 'exec' commmand enabled in php.ini
- Gradle
- Emscripten(for WASM compilation)
# Installation
1. Install the dependencies.
2. Download latest release&extract it into your webserver's root folder.
3. Edit config.php and set `$cordova_path` to whatever command you want to use to execute Apache Cordova, set `$projects_path` to a folder where cordowa will store it's projects in, set `$tmp_path` to a folder where temp files should be stored,- set `$slash` to whatever slash your OS uses. Unix/Linux systems use forward-slash(/), and windows uses backwards one(you should write it twice and in double-quotes!), and set `$empp` to path to em++ executable, and lastly - set `$emcc` to emcc executable.
4. Re-start the webserver, if you did not shut it off while installing dependencies
5. Go to http://127.0.0.1/ and woila! Here is your editor!

# How to use

1. Click on the paper list, and create a new project. It will take a while.
2. After success message, click on plus sigb, and create a new file. You need to create index.html as the default page for the app.
3. Code as usual! You can include files between them. If you ever coded a website, this will be easy.
4. Also, you can set up language syntax and editor theme, if you want to, and download all of the files by clicking that arrow in the menu. Don't forget to save! For that, click on a little diskette in the menu, and it will save the project to session. 
5. Click on triangle in menu, to complile the application. If everything set up correctly, after a few decades, it will download.

# IMPORTANT
THIS PROJECT IS UNDER DEVELOPMENT!
ALL OF THE PROJECTS ARE STORED IN SESSION, WHAT MEANS THAT AFTER 4-12 HOURS PROJECT WILL BE DELETED AND CANNOT BE ACCESSED FROM THE UI OF THE BUILDER!
IT'S NOT READY TO USE IN PRODUCTION OR ANYTTHING LIKE THAT!
Planned:
- Save files TO ACTUAL FS, not the $_SESSION
- Add WASM editing& compiling
- Add external asset upload support

# Support me
If you liked this project, please star me, or if you want, you can donate me [here](http://donationalerts.ru/r/mrcheatt)
Thanks!

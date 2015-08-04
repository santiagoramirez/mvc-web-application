This repository is my take at creating an MVC web app framework.

###### Folder/File Structure

**/core**

The core directory contains our applications models, controllers and views.

**/core/base-controller.php**

The base-controller.php file contains the abstract class ‘Controller’ which is used as the parent class for all controllers. The class is capable of extracting, filtering and validating request data.

**/core/base-view.php**

The base-view.php file contains the class ‘View’ which determines the current page to be displayed by searching the `core/views/templates` directory for a file that has the exact same name of the page to be displayed.

For example, given the URL `http://example.com/?page=hello`, the View class will search the templates directory for `hello.tpl`. It will also search the `core/views/helpers` directory for `hello.php`. The difference between a helper and a template file is that a template file is a smarty template and a helper file prepares data for the smarty template. A helper is not required for each page, but a template is.

```
/core
    /controllers
    /models
    /views
        /helpers
        /templates
    base-controller.php
    base-model.php
    base-view.php
/public
    /assets
      /css
      /images
      /js
    index.php
/resources
    /classes
    /libs
    config.php
    functions.php
/sql
```

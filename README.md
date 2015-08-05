### Folder/File Structure

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

**/ core**

The core directory contains our applications models, controllers and views.

**/ core / controllers**

This directory contains our controller calsses 

**/ core / models**

This directory contains our model calsses.

**/ core / views**

This directory contains our view templates and helpers.

**/ core / views / helpers**

This directory contains our helpers which prepare data for the corresponding Smarty template. For example, if there is a variable named `{$data}` in the Smarty template `my-page.tpl`, then the helper `my-page.php`, in the helpers folder, will prepare the data contained in the variable `{$data}` by calling on the neccesary controllers and/or models. A helper can also be used to redirect a page if certain conditions are not met.

A helper is not required to render a template, but a template is required to render a page.

**/ core / views / templates**

This directory contains our Smarty templates. The file name of each Smarty template should be the name of the page being displayed. For example, given the url `http://example.com?page=my-page` the name of the Smarty template would need to be `my-page.tpl`.




**/ core / base-controller.php**
The `base-controller.php` file contains the `Controller` abstract class which is used as the parent class for all controllers. The class is capable of extracting, filtering and validating request data.

**/core/base-model.php**

The `base-model.php` file contains the `Model` abstract class which is used as the parent class for all models. The class is used to make prepared queries to the database.

Database login credentials are set in `resources/config.php`.

**/core/base-view.php**

The `base-view.php` file contains the `View` class which determines the current page to be displayed by searching the `core/views/templates` and `core/views/helpers` directory for a file that correlates to the name of the page to be displayed.

For example, given the URL `http://example.com/?page=hello`, the View class will search the templates directory for `hello.tpl`. It will also search the `core/views/helpers` directory for `hello.php`. The difference between a helper and a template file is that a template file is a Smarty template and a helper file prepares data for the smarty template. A helper is not required for each page, but a template is.



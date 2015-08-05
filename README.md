# MVC Web Application

#### About this repository

I'll admit it, there was a time when I did not know of the term MVC. A time when I wrote spaghetti code like a madman, but those days are long gone. When did this all change, you ask? Well, when I first became familiar with AngularJS.

Learning AngularJS forced me to research the concept of MVC more in depth and it did not take long before I realized the benefits MVC could offer; if implemented in a backend web application. The only problem was that I could not find a reliable source on how to implement it. Sure, there are PHP frameworks, but a framework just didn't cut it. I wanted to build my own implementation from scratch.

After much research, trial, and error, this repository contains what I think is a great way to implement MVC in a backend web application.

#### The Folder and File Structure

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
```

**/core**

The core directory contains our applications models, controllers, and views.

**/core/controllers**

This directory contains our controller classes.

**/core/models**

This directory contains our model classes.

**/core/views**

This directory contains our view templates and helpers.

**/core/views/helpers**

This directory contains our helpers which prepare data for the corresponding Smarty template. For example, if there is a variable named `{$data}` in the Smarty template `my-page.tpl`, then the helper `my-page.php`, in the helpers folder, will prepare the data contained in the variable `{$data}` by calling on the necessary controllers and/or models. A helper can also be used to redirect a page if certain conditions are not met.

A helper is not required to render a template, but a template is required to render a page.

**/core/views/templates**

This directory contains our Smarty templates. The file name of each Smarty template should be the name of the page being displayed. For example, given the URL `http://example.com?page=my-page` the name of the Smarty template would need to be `my-page.tpl`.

**/core/base-controller.php**

The `base-controller.php` file contains the `Controller` abstract class which is used as the parent class for all controllers  contained in the `core/controllers` directory. The class is capable of extracting, filtering and validating request data.

**/core/base-model.php**

The `base-model.php` file contains the `Model` abstract class which is used as the parent class for all models contained in the `core/models` directory. The class is used to make prepared queries to our database.

Database login credentials are set in `resources/config.php`.

**/core/base-view.php**

The `base-view.php` file contains the `View` class which determines the current page to be displayed by searching the `core/views/templates` and `core/views/helpers` directory for a file that correlates to the name of the page to be displayed.

**/public**

This directory contains files which are visible through the domain.

**/public/assets**

This directory contains all the CSS/SASS, images and JavaScript used in our web application.

**/public/index.php**

The `index.php` require all the necessary files needed to run our application and calls on the `View` class to render the current page.

**/resources**

This directory contains files which are not necessarily the core of our application, but are used to assist our core application.

**/resources/classes**

This directory contains any class which is used in our web application.

**/resources/libs**

This directory contains any library which is used in our web application. Smarty is the only library by default since it is used to render our templates.

**/resources/config.php**

The `config.php` file is where we configure our web application to run on the server.

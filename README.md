## Overview

[![Build Status](https://api.travis-ci.com/silverstripe/silverstripe-installer.svg?branch=4)](https://travis-ci.com/silverstripe/silverstripe-installer)

Base project folder for a SilverStripe ([http://silverstripe.org](http://silverstripe.org)) installation. Required modules are installed via [http://github.com/silverstripe/recipe-cms](http://github.com/silverstripe/recipe-cms). For information on how to change the dependencies in a recipe, please have a look at [https://github.com/silverstripe/recipe-plugin](https://github.com/silverstripe/recipe-plugin). In addition, installer includes [theme/simple](https://github.com/silverstripe-themes/silverstripe-simple) as a default theme.

## Local Setup
        
Build docker (Linux)
```
composer linux:start-docker:rebuild
```

Setup Silverstripe database
```
composer linux:setup:docker
```

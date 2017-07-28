# Laravel Skeleton maker

## Installation

To install this package you will need:

* Laravel 5.4+

Install via **Laravel Skeleton Maker**

- First, download using composer

```bash
composer global require "framgia/laravel-skeleton"
```

Make sure to place the `$HOME/.composer/vendor/bin` directory (or the equivalent directory for your OS) in your `$PATH` so the `laravel-skeleton` executable can be located by your system.

Once installed, the `laravel-skeleton run` command will create a laravel skeleton in the directory you specify.

- Options:
```bash
      --with-docker     Init with docker-compose file
      --docker-only     Init docker-compose file only
```

- Folder structure

```bash
app
├── Console
│   └── Kernel.php
├── Exceptions
│   └── Handler.php
├── Helpers
│   ├── ApiHelper.php
│   └── FormHelper.php
├── Http
│   ├── Controllers
│   │   ├── Admin
│   │   │   ├── BaseController.php
│   │   │   └── HomeController.php
│   │   ├── Api
│   │   │   ├── BaseController.php
│   │   │   └── UsersController.php
│   │   ├── Auth
│   │   │   ├── ForgotPasswordController.php
│   │   │   ├── LoginController.php
│   │   │   ├── RegisterController.php
│   │   │   └── ResetPasswordController.php
│   │   ├── Controller.php
│   │   └── Web
│   │       ├── BaseController.php
│   │       └── HomeController.php
│   ├── Kernel.php
│   ├── Middleware
│   │   ├── AdminAuthenticate.php
│   │   ├── EncryptCookies.php
│   │   ├── RedirectIfAuthenticated.php
│   │   ├── TrimStrings.php
│   │   └── VerifyCsrfToken.php
│   └── Requests
│       ├── Api
│       │   ├── BaseRequest.php
│       │   ├── UserRegisterRequest.php
│       │   └── UserUpdateRequest.php
│       └── Web
│           └── BaseRequest.php
├── Mail
│   ├── BaseMail.php
│   └── User
│       └── WelcomeMail.php
├── Models
│   ├── Traits
│   │   └── ApiScopes.php
│   └── User.php
├── Providers
│   ├── AppServiceProvider.php
│   ├── AuthServiceProvider.php
│   ├── BroadcastServiceProvider.php
│   ├── EventServiceProvider.php
│   ├── RouteServiceProvider.php
│   └── ServicesBindingProvider.php
└── Services
    ├── Api
    │   ├── BaseService.php
    │   ├── Contracts
    │   │   ├── BaseServiceInterface.php
    │   │   ├── CanSortAndFilter.php
    │   │   └── UserServiceInterface.php
    │   ├── Pagination
    │   │   └── ApiPaginator.php
    │   ├── UserService.php
    │   └── Values
    │       └── ApiParam.php
    ├── Helpers
    │   └── EmailService.php
    ├── Traits
    │   └── EloquentFilter.php
    └── Web
        ├── BaseService.php
        ├── Contracts
        │   ├── BaseServiceInterface.php
        │   └── UserServiceInterface.php
        └── UserService.php
 
 resources
 ├── assets
 │   ├── js
 │   │   ├── app.js
 │   │   ├── bootstrap.js
 │   │   └── components
 │   │       └── Example.vue
 │   └── sass
 │       ├── _variables.scss
 │       └── app.scss
 ├── lang
 │   └── en
 │       ├── auth.php
 │       ├── pagination.php
 │       ├── passwords.php
 │       └── validation.php
 └── views
     ├── admin
     │   └── welcome.blade.php
     ├── emails
     │   └── en
     │       └── user
     │           └── welcome.blade.php
     ├── web
     │   └── welcome.blade.php
     └── welcome.blade.php
```
      
## License

The MIT License (MIT)

Copyright (c) 2017 Framgia Vietnam Ltd.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
** WORK IN PROGRESS - Nothing to see here yet, please carry on... **

# Home Page

A custom landing page for your web browser.

Home Page is a fully free and open source web application designed to be a useful tool in your everyday workflow. It doesn't get in the way: set it once and forget, import and export your settings for...

## Features

Home Page includes a settings panel with different options to tweak the look and feel of the landing page. The following serves as a list of available and planned features, with no estimated release date for the latter:

- [x] Free and open source.
- [x] Self-host friendly.
- [x] Support for Docker Secrets.
- [ ] Support for end-to-end encryption.
- [ ] Theme picker.
- [ ] Multiple profiles.
- [ ] Multi-factor authentication.
- [ ] Import/export functionality.

## How To Run

1.  ### Install local dependencies

    The only required dependency installed in your computer or server is `docker`. Follow the instructions on how to install it for your operating system by following the [installation instructions from the official documentation page](https://docs.docker.com/get-docker/).

    You will also need to have `git` installed to download this repository to your local machine.

2.  ### Clone the repository

        Download, or clone, this repository to your local machine.

    ```console
    $ git clone https://github.com/d10f/home_page.git
    ```

3.  ### Install front- and back-end packages.

    ```console
    $ docker compose run --rm composer install
    $ docker compose run --rm npm install
    ```

4.  ### Initialize key

    ```console
    $ docker compose run --rm artisan key:generate
    ```

5.  ### Compile front-end assets.

    ```console
    $ docker compose run --rm npm run build
    ```

6.  ### Deploy

    TBD...

7.  ### Configure

    Refer to the "Environment Variables" section to learn more about the environment variables used to tweak the behavior of Home Page during deployment.

## Environment Variables

When deployed this project can be easily configured by providing environment variables. Docker Secrets are supported and all of the variables may be provided in the form of a `_FILE` suffix.

In addition to the ones you will find in any Laravel project, you can also tweak the following variables:

**ENCRYPT**: `true | false`

`default: false`

Specifies whether the front-end application will encrypt all sensitive data before sending it to the server. Note that this option is not compatible with some other features, such as real-time bookmark searching.

## Contribute

To contribute to this project follow steps 1 through 5 from the "How To Run" section, to have a local development environment setup in your machine. Start the server by running:

```console
$ docker compose run --rm -d nginx
```

This application is built with [Vue](https://v2.vuejs.org/v2/style-guide/) and [Laravel](https://laravel.com/docs/10.x/contributions#coding-style). Please adhere to the guidelines specified by the respective projects, where applicable throughout the code base.

## Credits

Home Page is built with Laravel, Vue, Inertia, Vite, Tailwind, Redis, MariaDB, Meilisearch, and many more amazing open source technologies. Thank you to all authors and contributors that made them possible available for the rest of us.

Big thank you, as well, to the entire community built around these projects that helped me by providing guidance, advice or feedback in some capacity.

Vector icon set [Wolf Kit Rounded Line](https://www.svgrepo.com/collection/wolf-kit-rounded-line-icons) by [SVG Repo](https://www.svgrepo.com/) - [CC License](https://www.svgrepo.com/page/licensing/#CC%20Attribution).

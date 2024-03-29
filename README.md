# Bookmark Manager

An intuitive and customizable way to handle bookmarks.

## Features

- [x] Organize bookmarks hierarchically.
- [ ] Sort categories and bookmarks:
    - [x] drag and drop (lexicographical).
    - [ ] alphabetical.
    - [ ] frequently used.
- [x] Fuzzy find bookmarks.
- [x] Keyboard navigation.
- [ ] Import/export bookmark data.
- [ ] Multi-factor authentication.
- [ ] Theme picker.

## How To Run

1.  ### Install local dependencies

    The only required dependency installed in your computer or server is `docker`. Follow the instructions on how to install it for your operating system by following the [installation instructions from the official documentation page](https://docs.docker.com/get-docker/).

    You will also need to have `git` installed to download this repository to your local machine.

2.  ### Clone the repository

    Download, or clone, this repository to your local machine.

    ```console
    git clone https://github.com/D10f/bookmark_manager
    ```

3.  ### Install front- and back-end packages.

    ```console
    docker compose run --rm composer install
    docker compose run --rm npm install
    ```

4.  ### Initialize key

    ```console
    docker compose run --rm artisan key:generate
    ```

5.  ### Compile front-end assets.

    ```console
    docker compose run --rm npm run build
    ```

## Configure

    Refer to the "Environment Variables" section to learn more about the environment variables used to tweak the behavior of Home Page during deployment.

## Contribute

This application is built with [Vue](https://vuejs.org/style-guide/) and [Laravel](https://laravel.com/docs/10.x/contributions#coding-style). Please adhere to the guidelines specified by the respective projects, where applicable throughout the code base.

## Credits

Home Page is built with Laravel, Vue, Inertia, Vite, Tailwind, Redis, MariaDB, Meilisearch, and many more amazing open source technologies. Thank you to all authors and contributors that made them possible available for the rest of us.

Big thank you, as well, to the entire community built around these projects that helped me by providing guidance, advice or feedback in some capacity.

Vector icon set [Wolf Kit Rounded Line](https://www.svgrepo.com/collection/wolf-kit-rounded-line-icons) by [SVG Repo](https://www.svgrepo.com/) - [CC License](https://www.svgrepo.com/page/licensing/#CC%20Attribution).

Folder icon from Adwaita Icon Set by [The Gnome Project](http://www.gnome.org).

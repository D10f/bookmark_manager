# Bookmark Manager

An intuitive and customizable way to handle bookmarks.

## Features

- [x] Organize bookmarks hierarchically.
- [x] Custom sort &minus; drag and drop, lexicographical.
- [ ] Alphabetical sort.
- [ ] Frequency sort.
- [x] Fuzzy find bookmarks.
- [x] Keyboard navigation.
- [x] Import/export bookmark data.
- [ ] Theme picker.
- [ ] Web browser style _tags_ and _keywords_.
- [ ] Password Reset.
- [ ] OAuth authentication (Socialite).
- [ ] Key-based authentication (RSA).
- [ ] Multi-factor authentication (OTP).
- [ ] Merge bookmarks.
- [ ] Bulk Edit.

## Anti-Features

I've designed this web application around my own personal use case. Browser bookmarks can have keywords and tags assign to them, designed to make them easier to organize and find. However, I never found this useful; I normally have a rough idea of what I'm looking for by name and the address bar brings up those results quickly. Otherwise, I tend to use folders to keep bookmarks oragnized in categories which I can also search for easily.

Therefore, one anti-feature of this project is that bookmarks don't have either tags nor bookmarks. This simplifies the database schema and speeds up queries. That said, I would like to implement these features at one point in order to make this more accessible to others.

## How To Run

1.  ### Install local dependencies

    The only required dependency installed in your computer or server is `docker`. Follow the instructions on how to install it for your operating system by following the [installation instructions from the official documentation page](https://docs.docker.com/get-docker/).

    You will also need to have `git` installed to download this repository to your local machine.

2.  ### Clone the repository

    Download, or clone, this repository to your local machine.

    ```
    git clone https://github.com/D10f/bookmark_manager
    ```

3.  ### Install front- and back-end packages.

    ```
    docker compose run --rm composer install
    docker compose run --rm npm install
    ```

4.  ### Initialize key.

    ```
    docker compose run --rm artisan key:generate
    ```

5.  ### Populate the environent variables.

    Copy the `src/.env.example` file into `src/.env` and update the environment variables as needed. See the #Environment Variables section for more details.

6.  ### Start the web server.

    ```
    docker compose up -d nginx
    ```

## Deployment

TBD

## Environment Variables

TDB

## Contribute

This application is built with [Vue](https://vuejs.org/style-guide/) and [Laravel](https://laravel.com/docs/10.x/contributions#coding-style). Please adhere to the guidelines specified by the respective projects, where applicable throughout the code base.

## Credits

Home Page is built with Laravel, Vue, Inertia, Vite, Tailwind, Redis, MariaDB, Meilisearch, and many more amazing open source technologies. Thank you to all authors and contributors that made them possible available for the rest of us.

Big thank you, as well, to the entire community built around these projects that helped me by providing guidance, advice or feedback in some capacity.

Vector icon set [Wolf Kit Rounded Line](https://www.svgrepo.com/collection/wolf-kit-rounded-line-icons) by [SVG Repo](https://www.svgrepo.com/) - [CC License](https://www.svgrepo.com/page/licensing/#CC%20Attribution).

Folder icon from Adwaita Icon Set by [The Gnome Project](http://www.gnome.org).

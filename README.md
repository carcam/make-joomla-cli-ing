# Make Joomla! CLI-ing

This repository contains the code for my workshop on developing a console plugin for Joomla! 5 at [JoomlaDay US
2025](https://jdayusa.com) titled: **Make Joomla! CLI-ing**.

In this session, I demonstrated how to develop a console plugin for Joomla! that gets information from the database and
show it in the console.

This session followed the structure of my book on developing extensions for Joomla! 5 titled _[Developing Extensions For
Joomla! 5](https://developingextensionsforjoomla5.com/?utm_source=gh-jdusa25)_.

[![Cover of the book 'Developing Extensions For Joomla!
5'](https://developingextensionsforjoomla5.com/images/cover.webp)](https://developingextensionsforjoomla5.com/)

## Download the PDF presentation

- [Make Joomla! CLI-ing](https://carcam.github.io/make-joomla-cli-ing/slides/make-joomla-cli-ing.pdf)

## How to use this repository

### Plugin Code

The component code is located in the _main_ branch of this repository and is organized by the following tags, reflecting
the different stages of my session:

- **v1.0.0**: This is the final version of the plugin.

### Presentation Files

The presentation files are located in the _slides_ branch of this repository, specifically in the `slides` folder.

The presentation was created using [Marp](https://marp.app/), and the source files are located in the `slides/src`
folder.

The command to generate the presentation with _Marp-cli_ is:

```bash
cd slides/src &&  marp --pdf ./make-joomla-cli-ing.md  --theme-set ./book.css --output ../make-joomla-cli-ing.pdf --allow-local-file
```

And the pdf will be inside the `slides` folder of the repository.

### Mockup data

I provide some mockup data you can import in your database. It comes in three different formats:

-`generic.sql`: This file can be easily imported in your database, just replace the generic table prefix in the `insert`
command with the one of your database.
- `ddev.sql`: This file can be imported directly in your DDEV site.
- `import.csv`: This file can be imported with PhpMyAdmin or any similar tool that is able to import CSV file in a
  databse table.

## Setup a development environment

To set up a development environment, follow these instructions:

1. Install the latest version of Joomla! in your preferred development box.
1. Then, install the main component from this link.
1. Finally, you can add some tasks in the Joomla! administrator or import the ones in the Mockup data folder of this repo.

### Setup using DDEV

If you are using [DDEV](https://ddev.com/) As your local development solution, you can use this commands to set up your environment:

#### 1. Setup DDEV for Joomla!

```bash
mkdir jdayusa25 && cd jdayusa25
```

```bash
curl -o joomla.zip -L $(curl -sL https://api.github.com/repos/joomla/joomla-cms/releases/latest | docker run -i --rm ddev/ddev-utilities jq -r '.assets | map(select(.name | test("^Joomla.*Stable-Full_Package\\.zip$")))[0].browser_download_url')
```

```bash
unzip joomla.zip && rm -f joomla.zip
```

```bash
ddev config --project-type=php --webserver-type=apache-fpm --upload-dirs=images
```

```bash
ddev start
```

```bash
ddev php installation/joomla.php install --site-name="Make Joomla! CLI-ing" --admin-user="Administrator"
--admin-username=admin --admin-password=AdminAdmin1! --admin-email=admin@example.com --db-type=mysql --db-encryption=0
--db-host=db --db-user=db --db-pass="db" --db-name=db --db-prefix=ddev_ --public-folder=""
```

#### 2. Install main component using CLI

```bash
ddev php cli/joomla.php extension:install --url=https://github.com/carcam/Unlock-the-Power-of-Joomla-5/releases/download/5-api/com_ctl.zip
```

#### 3. Load mockup data into Database

```bash
wget https://raw.githubusercontent.com/carcam/make-joomla-cli-ing/refs/heads/main/mockup-data/ddev.sql -O tasks.sql
```

```bash
ddev import-db --file=tasks.sql --no-drop
```




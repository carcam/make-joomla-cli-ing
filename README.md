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

### Component Code

The component code is located in the _main_ branch of this repository and is organized by the following tags, reflecting
the different stages of my session:

- **v1.0.0**: This is the final version of the plugin.

### Presentation Files

The presentation files are located in the _slides_ branch of this repository, specifically in the `slides` folder.

The presentation was created using [Marp](https://marp.app/), and the source files are located in the `slides/src`
folder.

The command to generate the presentation with _Marp-cli_ is:

```bash
marp --html make-joomla-cli-ing.md --theme-set book.css --pdf-notes --allow-local-files --output
slides/make-joomla-cli-ing.pdf

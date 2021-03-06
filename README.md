# Deftly Collapsible Content Plugin

Add collapsible content to your WordPress site - Includes Teaser and Q&A formats.

Built during a [KnowTheCode](https://knowthecode.io) Lab with Tonya Mork.

## Features

This plugin includes the following features:

- QA Shortcode, `[qa]`
- Teaser Shortcode, `[teaser]`
- FAQ Shortcode
- FAQ Custom Post Type
- Topics Custom Taxonomy
- Font icon visual indicator
- jQuery sliding animation

The FAQ feature is built as a module. It uses a CPT and Custom Taxonomy generator.
The generator allows multiple custom post types and taxonomies to be created from one
config file, and allows configuration for:

- all messages (incl bulk) 
- all labels
- all supported features
- multiple help tabs

I will extricate this into it's own custom content module shortly, when I have moved onto OOP.

## Installation

### Using Git Clone

1. In terminal, navigate to `{path to your sandbox project}/wp-content/plugins`.
2. Then type in terminal or Git Bash: `git clone https://github.com/JeffCleverley/CollapsibleContent.git`
4. Log into your WordPress website.
5. Go to Plugins and activate this plugin.

### Downloading

If you do not have git or SSH setup yet, then you can click on the Download button here in this repository.  Install following these steps:

1. Click on the Download button above.
2. Move the zipped file into your project's `{path to your sandbox project}/wp-content/plugins` folder
3. Unzip the file
4. Log into your WordPress website.
5. Go to Plugins and activate this plugin.
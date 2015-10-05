# Shariff plugin for OMP
This plugin adds social media buttons to you web site (to the footer of each page, sidebar or share tab on the book page). It implements shariff by heise ([Github](https://github.com/heiseonline/shariff), [article](http://ct.de/shariff))  in [Open Monograph Press](https://pkp.sfu.ca/omp/).

## Installation
Clone this repo in your plugin folder or download the code and tar.gz it and upload it via the gui.

## Usage

The front end can be used to display the buttons themselves. Available social media services are:
- AddThis
- Facebook
- Twitter
- Google+
- LinkedIn
- Pinterest
- Whatsapp
- XING
- Mail
- Info

An info button that links to the heise article can be added.

![Shariff icons](https://raw.githubusercontent.com/langsci/lsp-artwork/master/shariff/shariff-icons.PNG)

### Settings
The following settings are available: 
- select buttons (AddThis, Facebook, Twitter, Google+, LinkedIn, Pinterest, Whatsapp, XING, Mail, Info)
- order buttons
- select theme (Standard, White, Grey)
- select orientation (horizontal or vertical)
- determine the position of the social media buttons on your web site
- add backend-url

![Shariff settings](https://raw.githubusercontent.com/langsci/lsp-artwork/master/shariff/shariff-settings.PNG)

### Display numbers

![Shariff icons with numbers](https://raw.githubusercontent.com/langsci/lsp-artwork/master/shariff/shariff-icons-numbers.PNG)

To display the numbers of likes, tweets and plus-ones, shariff uses a backend. This plugin uses the [php backend] (http://github.com/heiseonline/shariff-backend-php). 

To set up the backend you need to have access to the code. Follow the steps:
 1. Copy the folder `shariff-backend` to the top level of your OMP installation.
 2. Make the folder `cache` writeable.
 3. Change the `domain` in `shariff.json` to your domain.
 4. Add the url of the backend at the settings page. Example: `http://your-press.org/shariff-backend`.

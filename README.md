# Shariff plugin for OMP
This plugin adds social media buttons to the footer of each page. It implements shariff by heise ([Github](https://github.com/heiseonline/shariff), [article](http://ct.de/shariff))  in [Open Monograph Press](https://pkp.sfu.ca/omp/).


## Usage

The front end can be used to display the buttons themselves. Available social media services are:
- facebook
- twitter
- googleplus

An info button that links to the heise article can be added.

![Shariff Icons](https://raw.githubusercontent.com/langsci/lsp-artwork/master/shariff/shariff-icons.PNG)

### Settings
The following settings are available: 
- select buttons (facebook, twitter, googleplus, info)
- language (de, en)
- theme (standard, white, grey)
- backend-url

![Shariff Settings](https://raw.githubusercontent.com/langsci/lsp-artwork/master/shariff/shariff-settings.PNG)

### Display numbers

To display the numbers of likes, tweets and plus-ones shariff uses a backend. This plugin uses the [php backend] (http://github.com/heiseonline/shariff-backend-php). 

To set up the backend you need to have access to the code. Follow the steps:
 1. Copy the folder shariff-backend to the top level of your OMP installation.
 2. Make the folder chache writeable.
 3. Change the domain in shariff.json to your domain.
 4. Add the url of the backend at the settings page.

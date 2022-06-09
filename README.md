# PHP

Repository for technical assessment project of PHP development cadidates

## Getting started with your assessment

To make it easy for you to get started with your assessment, here's a list of what you need to do.

## Clone, Create, & Conquer

- [ ] Create your own empty public repository in [GitLab] (https://gitlab.com)
- [ ] Copy all the files of this project into your new repository
- [ ] Implement the required tasks in your own reository
- [ ] Share the link to your repository for us to review

## How to Initialize the Project

- [ ] Open the project using Visual Studio Code
- [ ] Inside VS Code, open a terminal and run `docker compose up`
- [ ] Open your Docker Desktop Dashboard and open the CLI for the vpp-php container
- [ ] Execute `composer install` to install the project's dependencies / packages
- [ ] Execute `vendor/bin/phinx migrate -e development` to build the database
- [ ] Execute `vendor/bin/phinx seed:run -e development` to import all data to the database
- [ ] cd to /application/libraries/codeigniter-predis and execute `composer install` inside the directory
- [ ] In your local machine, look for your hosts file and add the following `127.0.0.1 mtm.lvh.me`. Save the file.
- [ ] Open your browser and go to http://mtm.lvh.me

## Solve Problems

The problems are specified within the project. Please do as much as you can and as best as you can. You will be evaluated not on how many you've finished, but on how you approached, thought about, and solve each problem.

## Things to Remember

- Do not commit and push any changes into this repository.
- Once you're done with the assessment and ready to submit your work, send us the link to the new public GitLab repository you've created to clone this project.
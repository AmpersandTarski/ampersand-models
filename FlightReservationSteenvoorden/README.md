# Ampersand project template
A default folder setup for Ampersand projects

## Quick start
It includes a Dockerfile and docker-compose configuration to easily build and run a prototype application based on your Ampersand script.

Place all your scripts files in the `./model` folder. The [script.adl](./model/script.adl) file is your entry point.

Rename `.env.example` to `.env` and fill in the missing environment variables.

Run `docker-compose up -d --build` to build and run your application. Navigate to `https://localhost:80` to open the application.

## Prerequisites:
* Make sure that ports 80 and 443 on your laptop are available.
* Make sure that Docker is running on your laptop.

## Steps
1. Git clone https://github.com/AmpersandTarski/project-template into an empty directory, so you have all the necessary files needed to deploy your application. We will call this the working directory.
2. Put your Ampersand scripts in the `model` folder. The file `script.adl` is you entry point. When you want to rename this file, also rename it in the [Dockerfile](./Dockerfile).
3. Edit the file .env to choose a root password for the database and an ampersand password for your application that accesses this database. We recommend you generate a random password here; there is no need to be able to remember it.
4. Open a command line interface (CLI) and run `docker-compose build`. This step bakes your image. Docker stores that image on your laptop.
5. Run `docker compose up -d`. This instructs docker to deploy your application.
6. Go to your browser and navigate to https://localhost:80 to access your application.
7. Follow the instructions on screen.

For Dutch speakers: the following video https://youtu.be/qPnaYkPclYE provides more info on running and installing a Ampersand prototype application.
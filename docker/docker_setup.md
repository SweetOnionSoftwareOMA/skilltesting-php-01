## Setting up VisionPlanPro DOCKER
*****

The instructions and helpful hints for setting up and managing the docker instances are found in this readme. It is contained seperately to allow for easier editing, readability, and document length. Most of these instructuons are universal, but they are written for MACOS, so your commands might vary.

## REQUIREMENTS
*****

You must install both for the service to setup following the directions in this document.

* Docker Package
  * https://docs.docker.com/get-docker/
* Docker Compose Package
  * https://docs.docker.com/compose/install/
* LOCAL LOOPBACK IP
  * 10.254.254.254 this IP is a requirement for XDEBUG to work properly, atleast on MacOS due to docker not playing nice with localhost IP.
  * https://zpz.github.io/blog/connect-to-localhost-from-container/

&nbsp;

#### Creating the images

From the project root you can initialize and create the docker containers and then run them using:

* `docker-compose up`

&nbsp;

#### Connecting to the image

You can connect to any docker image and obtain a shell. ` docker exec -it $@ /bin/bash`  The `$@` should be replaced with the container name.  That is also the framework for creating a bash function in your local machine.

&nbsp;

#### Removing Docker Images

Sometimes changes will be made to the docker composer file, docker image configurations, or the files used to build the images.  This is how you can remove the existing images.

From your local PC environment in the project root directory.

```    docker rm /vpp-php /vpp-nginx /vpp-redis  /vpp-db /vpp-mailcatcher ```


&nbsp;

****
Image Explanations
****

**vpp-nginx**

You can setup the url to be anything, the guide recommends visionplanpro.biz, but lvh.me will also work and requires no additional configuration.

    This docker container provides the webservice, there are 3 websites served from the service:
        Appadmin, appadmin.localurl.tld, /var/www
        officemanager, om.localurl.tld, /var/www2
        retail, retail.localurl.tld, /var/www3

The sites are served up using a copied version of `./docker/nginx/default.conf`. Any permanent changes need to be made in this file, and the image rebuilt.

**vpp-php**

Microservice for PHP-FPM.  The Nginx connects via TCP to this service. In addition, the service exposes `10.254.254.254:9001` for use with XDEBUG from your IDE. If you use vscode, there is already a configuration file in .vscode that setups the debug service.  It is important to note, you can only run the debug service from one project at a time since the "project folder" is specified to PHP-FPM

This service has its own special setup instructions `./docker/php/Dockerfile` and separate configuration files that are copied to the service when intially built.  Anychanges to the configuration files requires a docker rebuild.

**vpp-redis**

This a redis server, no authentication required. Runs on the standard port.

**vpp-mailcatcher**

This is ruby based local SMTP server. It will catch all mail being sent via its service and it generates a web view of the email available at `localhost:1080`. Neither web interface or the SMTP service requires authentication.

**vpp-db**

PostgreSQL server that mounts your local disk at `./tmp/pgData` to provide persistant storage for the database across rebuilds of the docker images. you can connect to the docker image and then using the root user, just as you would with any local host development situation.


&nbsp;

&nbsp;

****
#### Alias & Helpful Commands
***

```
alias dockerup='docker-compose up'
alias dockerdown='docker-compose down'
alias dockerloopback='sudo ifconfig lo0 alias 10.254.254.254'

function dockerssh {
  docker exec -it $@ /bin/bash
}
```

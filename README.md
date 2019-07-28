# Long march image optimizer

The target of this project is provide a very simple batch image optimizer for any format inside a docker image, with customizable priority options and resources limit options and CLI and web frontends.

The image optimization is made by third party software (JPEGoptim, OptiPNG & GIFsycle), this project only install it inside a webserver with PHP and making it easy.

## Usage
* Clone this repo

´´´
$ git clone pijuzmagnificuz/long-march-image-optimizer
´´´

* Ensure your port 80 is open or foward it to other in docker-compose.yaml
* Use scripts on tools folder (will perform a docker-compose up --build)

```
$ tools/scripts/docker_up.sh
```

### Web frontend
Go to http://localhost, drag and drop your images and submit them. The resultant images will be at output folder

### CLI frontend
* Mount the volume(s) with the desired folder(s) to optimize
* Enter at container with

´´´
$ docker exec -i -t imgoptimizer.web bash
´´´

* Use the optimize PHP script as:
´´´
$ php optimize.php <folder1> <folder2> <folder3> ...
´´´

### Limits
* Docker compose memory and CPU limits not working if not deploy as swarm
* The priority of underliying optimize commands is 20 (lowest) as default, you can change it 
in upload.php and optimize.php source files.


That's all folks

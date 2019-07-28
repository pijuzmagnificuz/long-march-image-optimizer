#!/bin/bash
docker stop $(docker ps -a -q)
docker rm $(docker ps -a -q)
docker rmi $(docker images -a --filter=dangling=true -q)
docker rm $(docker ps --filter=status=exited --filter=status=created -q)
docker system prune --volumes -a
docker builder prune -a
docker image prune -a
docker container prune -f;

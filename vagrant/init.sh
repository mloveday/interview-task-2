#!/bin/bash

cd /tmp

sudo apt-get install -y make gcc > /dev/null 2>&1

wget http://download.redis.io/redis-stable.tar.gz > /dev/null 2>&1
tar xvzf redis-stable.tar.gz > /dev/null 2>&1
cd redis-stable

make > /dev/null 2>&1
sudo make install > /dev/null 2>&1

sudo mkdir /etc/redis
sudo mkdir -p /var/redis/6379

sudo useradd --system --home-dir /var/redis redis 
sudo chown -R redis.redis /var/redis

sudo cp /vagrant/redis.conf /etc/redis/6379.conf
sudo cp /vagrant/redis.init.d /etc/init.d/redis_6379

sudo update-rc.d redis_6379 defaults
/etc/init.d/redis_6379 start

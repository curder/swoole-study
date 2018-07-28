# -*- mode: ruby -*-
# vi: set ft=ruby :


Vagrant.configure("2") do |config|
  config.vm.box = "centos/7"
  config.vm.hostname = "centos7-swoole"
  config.vm.network "private_network", ip: "192.168.33.12"
  config.vm.network "public_network", bridge: "en1: Wi-Fi (AirPort)"
  config.vm.synced_folder ".", "/vagrant", :nfs => true
  config.vm.provider "virtualbox" do |vb|
    vb.cpus = 2
    vb.memory = "1024"
    vb.name = "centos7-swoole"
  end
end

# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure("2") do |config|

  config.vm.box = "ubuntu/xenial64"
  config.vbguest.auto_update = false

  # Mount shared folder using NFS
  config.vm.synced_folder ".", "/var/www/html"
  config.vm.synced_folder "./vendor", "/var/www/html/vendor", disabled: true

  # Apache
  config.vm.network "forwarded_port", guest: 80, host: 8080

  # Assign a quarter of host memory and all available CPU's to VM
  # Depending on host OS this has to be done differently.
  config.vm.provider :virtualbox do |vb|
    cpus = 2
    mem = 2048

    vb.customize ["modifyvm", :id, "--memory", mem]
    vb.customize ["modifyvm", :id, "--cpus", cpus]
  end

  config.vm.provision :shell, :path => ".vagrant/bootstrap.sh"

end
# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure("2") do |config|

  config.vm.box = "ubuntu/xenial64"
  config.vbguest.auto_update = false

  # Mount shared folder using NFS
  config.vm.synced_folder ".", "/var/www/html", disabled: true

  config.vm.synced_folder ".tmp", "/var/www/html/.tmp", disabled: false
  config.vm.synced_folder "./bin", "/var/www/html/bin", disabled: false
  config.vm.synced_folder "./config", "/var/www/html/config", disabled: false
  config.vm.synced_folder "./public", "/var/www/html/public", disabled: false
  config.vm.synced_folder "./src", "/var/www/html/src", disabled: false
  config.vm.synced_folder "./templates", "/var/www/html/templates", disabled: false
  config.vm.synced_folder "./tests", "/var/www/html/tests", disabled: false
  config.vm.synced_folder "./translations", "/var/www/html/translations", disabled: false

  config.vm.provision "file", source: ".env", destination: "/var/www/html/.env"
  config.vm.provision "file", source: "composer.json", destination: "/var/www/html/composer.json"
  config.vm.provision "file", source: "phpunit.xml.dist", destination: "/var/www/html/phpunit.xml.dist"

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
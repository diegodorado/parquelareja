Vagrant.configure("2") do |config|
  config.vm.box      = 'lucid64-lamp'
  config.vm.box_url  = 'https://dl.dropbox.com/u/14741389/vagrantboxes/lucid64-lamp.box'
  config.vm.network "private_network", ip: "192.168.56.101"

  config.vm.network "forwarded_port", guest: 80, host: 3000
  config.vm.network "forwarded_port", guest: 443, host: 3001

  config.vm.provider :virtualbox do |virtualbox|
    virtualbox.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    virtualbox.customize ["modifyvm", :id, "--memory", "512"]
    virtualbox.customize ["setextradata", :id, "--VBoxInternal2/SharedFoldersEnableSymlinksCreate/v-root", "1"]
  end

  config.vm.provision :shell, :path => "vm/reset_mysql_password.sh", :args => "root 1234"
  config.vm.provision :shell, :path => "vm/setup.sh"


end


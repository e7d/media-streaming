Vagrant.configure(2) do |config|
    config.vm.define "Neap" do |node|
        # For a complete reference, please see the online documentation at
        # https://docs.vagrantup.com.

        # General configuration
        node.vm.hostname = "neap.dev"
        node.vm.box = "e7d/neap-box"
        node.vm.box_version = ">= 1.2.6"
        node.hostsupdater.aliases = ["api.neap.dev", "db.neap.dev", "doc.neap.dev", "irc.neap.dev", "mail.neap.dev", "rtmp.neap.dev", "socket.neap.dev", "static.neap.dev", "www.neap.dev"]

        # Network configuration
        node.vm.network "private_network", ip: "192.168.32.10"
        node.vm.network "public_network"
        node.vm.network "forwarded_port", guest: 80, host: 8080
        node.vm.network "forwarded_port", guest: 443, host: 8443
        node.vm.network "forwarded_port", guest: 5432, host: 5432

        # Synced folder configuration
        node.vm.synced_folder ".", "/vagrant", type: "nfs"

        # VirtualBox provider
        node.vm.provider "virtualbox" do |vb|
            # System configuration
            vb.name = "Neap"
            vb.cpus = "4"
            vb.memory = "1024"

            # Additional storage configuration
            data_disk = "./.vagrant/machines/neap/virtualbox/data.vdi"
            unless File.exist?(data_disk)
                vb.customize ["createhd", "--filename", data_disk, "--size", 512 * 1024]
                vb.customize ["storageattach", :id, "--storagectl", "SATA Controller", "--port", 1, "--device", 0, "--type", "hdd", "--medium", data_disk]
            end
        end

        #  VirtualBox Guest update
        node.vbguest.auto_update = true
        node.vbguest.no_remote = true

        # Provisioning script
        node.vm.provision "shell" do |s|
            s.inline = "/vagrant/bootstrap.sh | tee /vagrant/bootstrap.log"
            s.keep_color = true
        end
    end
end

# Neap

[![Build Status](https://img.shields.io/travis/e7d/neap.svg)](https://travis-ci.org/e7d/neap)
[![Code Quality](https://img.shields.io/scrutinizer/g/e7d/neap.svg)](https://scrutinizer-ci.com/g/e7d/neap)
[![Coverage](https://img.shields.io/coveralls/e7d/neap.svg)](https://coveralls.io/github/e7d/neap)

A ready to go streaming server.

## About

**Version:** 0.0.0

**Web:** Coming later, [neap.io](http://neap.io)

**Project Owner:** Michaël "[e7d](https://github.com/e7d)" Ferrand

## Prerequisites

In order to run the code of Neap effectively, you'll need to have a few tools installed:

1. Install [Git](https://git-scm.com)
1. Install [VirtualBox](http://virtualbox.org)
1. Install [Vagrant](http://vagrantup.com)

### Windows-specific ###

1. Add the Git executables to your path
1. Install [Vagrant::WinNFSd](https://github.com/winnfsd/vagrant-winnfsd), to use NFS on a Windows host  
`vagrant plugin install vagrant-winnfsd`

### Recommended

1. Use a development workstation with at least 2 cores and 8GB of RAM, as Vagrant should be allocated 1GB of RAM
1. Install [Vagrant::Hostsupdater](https://github.com/cogitatio/vagrant-hostsupdater), to keep your hosts file in line with the built VM  
`vagrant plugin install vagrant-hostsupdater`
1. Install [Vagrant::VBGuest](https://github.com/dotless-de/vagrant-vbguest), to manage the host's VirtualBox Guest Additions on the guest system  
`vagrant plugin install vagrant-vbguest`

## Installation ##

1. `git clone https://github.com/e7d/neap.git` to clone the latest version
1. Change into the directory `neap`
1. Run `vagrant up`

## Update ##

For an "*In-Place*" upgrade of a working environment:

1. `git pull` to get the latest version of the code
1. Change into the directory `neap`
1. Run `vagrant reload`
1. Run `vagrant provision`

For a complete update from scratch, destroying and rebuilding everything:

1. `git pull` to get the latest version of the code
1. Change into the directory `neap`
1. Run `vagrant destroy`
1. Run `vagrant up`

## What you get ##

### Software environment ###

Neap is using its own "virtual box" to manage its environment, embedding the whole needed software.
You can consult a detailed list here: [Neap Box software stack](https://github.com/e7d/neap-box#software-stack)

On top of that, Neap adds:
* [Zend Framework](http://framework.zend.com/) 2 as PHP framework, with:
    * [Apigility](https://apigility.org/) as API framework
    * [React](http://reactphp.org/) as I/O library
    * [Ratchet](http://socketo.me/) as WebSocket library
* [Angular](https://angular.io/) 2 as JavaScript framework, with:
    * [Polymer](https://www.polymer-project.org/1.0/) as Web Components library
    * [React](https://facebook.github.io/react/) as use interfaces library
    * [lodash](https://lodash.com/) as utility library
* [Emoji One](http://emojione.com/) as Emoji collection
* [twemoji](http://twitter.github.io/twemoji/) as alternative Emoji collection


### Next Steps ###

Once the VM is done provisioning, direct your browser to http://neap.dev You will receive fuller instructions on the use of this Vagrant environment there.

These URLs also provide you some control over the project:
* [neap.dev](http://neap.dev) -- General documentation and links for all of the tools
* [api.neap.dev](http//api.neap.dev) -- API interface
* [doc.neap.dev](http//doc.neap.dev) -- API documentation interface
* [db.neap.dev](http://db.neap.dev) -- Database administration interface
* [irc.neap.dev](http://irc.neap.dev) -- IRC server
* [static.neap.dev](http://static.neap.dev) -- Cache content access
* Soon: [swagger.neap.dev](http://swagger.neap.dev) -- Swagger documentation interface
* Soon: [cache.neap.dev](http://cache.neap.dev) -- Cache performance test

## Development and debugging ##

### On-disk sources ###

Neap utilizes Vagrant's [synced folders](http://docs.vagrantup.com/v2/synced-folders/index.html) to create a shared folder, that is accessible from both the Neap virtual machine and your operating system.  
This directory will be available for use after the first time the virtual machine is started using the `vagrant up` command. You can access it directly by going to the neap sources directory in the Finder or Explorer of your operating system.

### SSH ###

To connect to the Vagrant instance, type `vagrant ssh` from a console located in the Neap directory.

### Database ###

A database representation made with [pgModeler (PostgreSQL Database Modeler)](http://www.pgmodeler.com.br/) may be found under the `resources\database\neap.dbm` location, alongside a PNG view of this same model.  
The PostgreSQL instance may be administrated through [pgAdmin](http://www.pgadmin.org/), with this connection information:
- **Host:** localhost
- **Port:** 5432
- **Username:** neap
- **Password:** neap

## Documentation ##

[README.md](https://github.com/e7d/neap/blob/master/README.md) - This markdown file, the technical steps to get Neap up and running.  
[Wiki](https://github.com/e7d/neap/wiki) - Coming later: Frequently asked questions, per OS install guides, debugging information

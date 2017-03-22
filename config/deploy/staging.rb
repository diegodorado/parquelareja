set :domain,      "parquelareja.org"
set :user, 'parqaa7'
set :deploy_to,   "/home/#{user}/staging"
set :use_sudo, false

ssh_options[:port] = 9022
default_run_options[:pty] = true

#set :deploy_via, :copy
set :deploy_via, :remote_cache

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where symfony migrations will run

server domain, :app, :web, :primary => true

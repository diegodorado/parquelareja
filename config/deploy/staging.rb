set :domain,      "plr.cooph.com.ar"
set :user, 'hormigon'
set :deploy_to,   "/home/#{user}/#{application}"
set :use_sudo, false

set :deploy_via, :remote_cache

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where symfony migrations will run

server domain, :app, :web, :primary => true
